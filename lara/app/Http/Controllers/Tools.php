<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Tools extends Controller
{
    public function index()
    {
        return view('tools.tool');
    }
    public function saveOcr(Request $request)
    {
        // 1. Validation
        $request->validate([
            'company_name' => 'nullable|string|max:255',
            'operator' => 'nullable|string|max:255', // Correctly validated
            'person_name' => 'nullable|string|max:255',
            'designation' => 'nullable|string|max:255',
            'mobile' => 'nullable|string|max:20',
            'email' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'raw_ocr_text' => 'nullable|string'
        ]);

        // 2. Insert into DB
        DB::table('scanned_documents')->insert([
            'operator' => $request->operator, // ADDED THIS LINE
            'company_name' => $request->company_name,
            'person_name' => $request->person_name,
            'designation' => $request->designation,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'address' => $request->address,
            'raw_ocr_text' => $request->raw_ocr_text,
            'created_at' => now()
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Data saved successfully',
            'received' => $request->all() // Good for console logging
        ]);
    }

    public function list()
    {
        $documents = DB::table('scanned_documents')
            ->orderBy('id', 'desc')
            ->get();

        return view('tools.list', compact('documents'));
    }

}