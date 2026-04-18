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
        // Fetch unique operator names from the table
        $operators = DB::table('scanned_documents')
            ->whereNotNull('operator')
            ->distinct()
            ->pluck('operator'); // Returns a simple array of names

        // Pass them to the scanner view
        return view('tools.tool', compact('operators'));
    }

    public function temptable()
    {

        return view('tools.temptable');
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
        $validated = $request->validate([
            'company_name' => 'nullable|string|max:255',
            'operator' => 'nullable|string|max:255',
            'person_name' => 'nullable|string|max:255',
            'designation' => 'nullable|string|max:255',
            'mobile' => 'nullable|string|max:255',
            'email' => 'nullable|string|max:255',
            'website' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'raw_ocr_text' => 'nullable|string'
        ]);

        // Store variables
        $company_name = $validated['company_name'] ?? null;

        if ($company_name) {
            // 1. Remove specific OCR symbols at the start or end (=, |, ©, etc.)
            // This targets common "border" characters picked up by OCR
            $company_name = preg_replace('/^[\s=|+\-©]+|[\s=|+\-©]+$/u', '', $company_name);

            // 2. Remove extra spaces between words
            $company_name = preg_replace('/\s+/', ' ', trim($company_name));

            // 3. Optional: Fix casing if it's all uppercase (AROUND THE WORLD -> Around The World)
            if ($company_name === strtoupper($company_name)) {
                $company_name = ucwords(strtolower($company_name));
            }
        }
        $operator = $validated['operator'] ?? null;
        $person_name = $validated['person_name'] ?? null;
        $designation = $validated['designation'] ?? null;
        $mobile = $validated['mobile'] ?? null;
        $email = $validated['email'] ?? null;
        $website = $validated['website'] ?? null;

        if ($website) {
            // 1. Split by comma or space in case OCR picked up multiple
            $sites = preg_split('/[,\s]+/', $website);

            $clean_sites = [];
            foreach ($sites as $site) {
                $site = trim(strtolower($site));
                if (empty($site))
                    continue;

                // 2. Normalize: remove 'www.' and protocols to find the unique "root"
                // This makes 'https://www.site.com' and 'site.com' look the same
                $normalized = preg_replace('/^(https?:\/\/)?(www\.)?/', '', $site);
                $normalized = rtrim($normalized, '/');

                // 3. Keep the first occurrence of each unique domain
                if (!isset($clean_sites[$normalized])) {
                    // Ensure the version we keep has a protocol for the DB
                    if (!str_starts_with($site, 'http')) {
                        $site = 'https://' . $site;
                    }
                    $clean_sites[$normalized] = $site;
                }
            }

            // 4. Return only the first unique website found
            $website = !empty($clean_sites) ? reset($clean_sites) : null;
        }
        $address = $validated['address'] ?? null;
        $raw_ocr_text = $validated['raw_ocr_text'] ?? null;

        if ($person_name) {
            // 1. Remove email addresses
            $person_name = preg_replace('/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-z]{2,}/', '', $person_name);

            // 2. Remove Phone Numbers (often found in mashed OCR names)
            // This looks for patterns like +61..., 0410..., etc.
            $person_name = preg_replace('/(\+?\d[\d\s-]{7,})/', '', $person_name);

            // 3. Remove OCR/Symbol artifacts
            // Specifically target: ( ) © [ ] = + |
            $person_name = preg_replace('/[\(\)©\[\]=\+\|]/u', '', $person_name);

            // 4. Remove leading/trailing non-alphanumeric symbols
            $person_name = preg_replace('/^[^a-zA-Z0-9]+|[^a-zA-Z0-9]+$/', '', $person_name);

            // 5. Final cleanup: Remove extra spaces
            $person_name = preg_replace('/\s+/', ' ', trim($person_name));
        }

        // Clean designation: remove emails and OCR symbols
        if ($designation) {
            // Remove email addresses
            $designation = preg_replace('/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-z]{2,}/', '', $designation);
            // Remove leading/trailing non-alphanumeric symbols (like "(=)")
            $designation = preg_replace('/^[^a-zA-Z0-9]+|[^a-zA-Z0-9]+$/', '', $designation);
            // Remove extra spaces
            $designation = preg_replace('/\s+/', ' ', trim($designation));
        }

        try {
            $data = [
                'company_name' => $company_name,
                'operator' => $operator,
                'person_name' => $person_name,
                'designation' => $designation,
                'mobile' => $mobile,
                'email' => $email,
                'address' => $address,
                'website' => $website ?? null, // Added website as well
                'raw_ocr_text' => $raw_ocr_text,
                'created_at' => now()->toDateTimeString()
            ];

            // $data = [
            //     'company_name' => 'TWM TRAVEL WALA Pvt LTD',
            //     'operator' => 'Nishant',
            //     'person_name' => 'ALISHA',
            //     'designation' => 'PRODUCT MANAGER',
            //     'mobile' => '+91704239303',
            //     'email' => 'sales@twmtravelwala.com',
            //     'address' => 'OFFICE NO- 8204, 1st FLOOR, ROSHANARA CLUB ROAD, DELHI-110007',
            //     'website' => 'www.twmtravelwala.com',
            //     'raw_ocr_text' => 'i ALISHA (=) sales@twmtravelwala.com PRODUCT MANAGER +91704239303 OFFICE NO- 8204...',
            //     'created_at' => now()->toDateTimeString()
            // ];

            // 2. Perform the insert
            DB::table('scanned_documents')->insert($data);

            // 3. Return the data in the JSON response
            return response()->json([
                'status' => 'success',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            \Log::error('Save OCR Error: ' . $e->getMessage());

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
    public function update(Request $request, $id)
    {
        try {
            // ADD 'website' TO THIS ARRAY
            $fields = $request->only([
                'company_name',
                'person_name',
                'designation',
                'mobile',
                'email',
                'address',
                'website' // <--- MUST BE HERE
            ]);

            DB::table('scanned_documents')->where('id', $id)->update($fields);

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $doc = DB::table('scanned_documents')->where('id', $id)->first();

        if ($doc) {
            $operator = $doc->operator;
            DB::table('scanned_documents')->where('id', $id)->delete();

            // Ensure 'documents.list' is the correct route name for your history page
            return redirect()->back()->with('success', 'Document deleted.');
        }

        return redirect()->back()->with('error', 'Record not found.');
    }
}