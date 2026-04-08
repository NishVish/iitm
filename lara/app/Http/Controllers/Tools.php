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
        // return response()->json($request->all()); // This will show you exactly what is arriving

        // Validate incoming data
        $request->validate([
            'company_name' => 'nullable|string|max:255',
            'person_name' => 'nullable|string|max:255',
            'designation' => 'nullable|string|max:255',
            'mobile' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'raw_ocr_text' => 'nullable|string'
        ]);

        // Insert into DB
        DB::table('scanned_documents')->insert([
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
            'message' => 'Data saved successfully'
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