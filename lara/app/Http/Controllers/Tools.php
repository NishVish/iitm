<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Tools extends Controller
{
    /**
     * 1. THE NAVIGATION
     */
    public function index()
    {
        return view('tools.tool');
    }

    public function ocr()
    {
        // This is your scanner view (resources/views/tools/ocr.blade.php)
        return view('tools.ocr');
    }

    /**
     * 2. THE SEARCH ENGINE (RELATIONAL LOOKUP)
     * This searches your 35k records across 4 linked tables.
     */



    public function lookuptest(\Illuminate\Http\Request $request)
    {
        $lines = null;

        if ($request->has('lines')) {
            $lines = $request->input('lines');
        }

        return view('tools.lookuptest', compact('lines'));
    }



    public function lookup(Request $request)
    {
        try {
            $lines = $request->input('lines', []);
            if (empty($lines)) {
                return response()->json(['found' => false, 'data' => []]);
            }

            $result = [
                'name' => '',
                'designation' => '',
                'company' => '',
                'email' => [],
                'mobile' => [],
                'address' => [],
            ];

            // 1. Get a list of known designations from your contact table to use as "keywords"
            $knownDesignations = DB::table('contact')
                ->whereNotNull('designation')
                ->distinct()
                ->pluck('designation')
                ->map(fn($d) => strtolower($d))
                ->toArray();

            $addrKeys = ['road', 'street', 'st.', 'floor', 'city', 'zip', 'building', 'airport', 'india', 'pincode'];

            foreach ($lines as $line) {
                $cleanLine = trim($line);
                $lower = strtolower($cleanLine);

                // --- 1. Identify Emails ---
                if (filter_var($cleanLine, FILTER_VALIDATE_EMAIL)) {
                    $result['email'][] = $cleanLine;
                    continue;
                }

                // --- 2. Identify Mobiles ---
                $digits = preg_replace('/\D/', '', $cleanLine);
                if (strlen($digits) >= 10) {
                    $result['mobile'][] = substr($digits, -10);
                    continue;
                }

                // --- 3. Identify Company (Exact or Partial Match in company_data) ---
                if (empty($result['company'])) {
                    $compMatch = DB::table('company_data')
                        ->where('company_name', 'LIKE', "%{$cleanLine}%")
                        ->first();
                    if ($compMatch) {
                        $result['company'] = $compMatch->company_name;
                        // If we find the company, we can also grab the address from the DB
                        if ($compMatch->address)
                            $result['address'][] = $compMatch->address;
                        continue;
                    }
                }

                // --- 4. Identify Designation (Check against existing designations in DB) ---
                if (empty($result['designation'])) {
                    foreach ($knownDesignations as $job) {
                        if (!empty($job) && str_contains($lower, $job)) {
                            $result['designation'] = $cleanLine;
                            continue 2;
                        }
                    }
                }

                // --- 5. Identify Address Keywords ---
                foreach ($addrKeys as $k) {
                    if (str_contains($lower, $k)) {
                        $result['address'][] = $cleanLine;
                        continue 2;
                    }
                }

                // --- 6. Name Fallback ---
                // If the line isn't a company/designation/email/phone, and it's 2+ words, assume Name
                if (empty($result['name']) && !preg_match('/\d/', $cleanLine)) {
                    if (str_word_count($cleanLine) >= 2) {
                        $result['name'] = $cleanLine;
                    }
                }
            }

            // Clean up output
            return response()->json([
                'found' => true,
                'data' => [
                    'name' => $result['name'],
                    'designation' => $result['designation'],
                    'company' => $result['company'],
                    'email' => array_values(array_unique($result['email'])),
                    'mobile' => array_values(array_unique($result['mobile'])),
                    'address' => array_values(array_unique($result['address'])),
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'found' => false,
                'message' => 'Database Error: ' . $e->getMessage()
            ], 500);
        }
    }



    /**
     * 3. DATA FORMATTER
     */
    private function formatResult($db)
    {
        return [
            'company' => $db->company_name ?? '',
            'name' => $db->person_name ?? '',
            'designation' => $db->designation ?? '',
            'mobile' => $db->matched_phone ?? $db->phone ?? '',
            'email' => $db->email ?? $db->website ?? '',
            'address' => trim(($db->address ?? '') . ' ' . ($db->city ?? '') . ' ' . ($db->pincode ?? ''))
        ];
    }

    /**
     * 4. SAVE (CREATE)
     */
    public function saveOcr(Request $request)
    {
        // If validation fails, this will now throw a JSON response 
        // because we added 'Accept: application/json' in the JS headers.

        // return response()->json($request->all());
        $validated = $request->validate([
            'company_name' => 'nullable|string|max:255',
            'operator' => 'nullable|string|max:255',
            'person_name' => 'nullable|string|max:255',
            'designation' => 'nullable|string|max:255',
            'mobile' => 'nullable|string|max:255',
            'email' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'raw_ocr_text' => 'nullable|string'
        ]);

        try {
            // Ensure 'scanned_documents' table has exactly these column names
            DB::table('scanned_documents')->insert(array_merge($validated, [
                'created_at' => now(),
                // 'updated_at' => now() // Add this if your table has it
            ]));

            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            \Log::error('Save OCR Error: ' . $e->getMessage());

            // Return JSON so the JS 'catch' can read the actual SQL error
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * 5. LIST RECORDS
     */
    public function list($operator)
    {
        // var_dump($operator);
        // exit;
        $documents = DB::table('scanned_documents')
            ->where('operator', $operator)
            ->orderBy('id', 'desc')
            ->get();

        return view('tools.list', compact('documents', 'operator'));
    }

    /**
     * 6. UPDATE & EDIT
     */
    public function edit($id)
    {
        $document = DB::table('scanned_documents')->where('id', $id)->first();
        if (!$document)
            return redirect()->back()->with('error', 'Not found');
        return view('tools.edit', compact('document'));
    }

    public function update(Request $request, $id)
    {
        try {
            $fields = $request->only(['company_name', 'person_name', 'designation', 'mobile', 'email', 'address']);
            DB::table('scanned_documents')->where('id', $id)->update($fields);
            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * 7. DELETE
     */
    public function destroy($id)
    {
        $doc = DB::table('scanned_documents')->where('id', $id)->first();
        if ($doc) {
            $operator = $doc->operator;
            DB::table('scanned_documents')->where('id', $id)->delete();
            return redirect()->route('documents.list', ['operator' => $operator])
                ->with('success', 'Document deleted.');
        }
        return redirect()->back();
    }
}