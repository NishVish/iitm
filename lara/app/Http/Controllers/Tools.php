<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Tools extends Controller
{
    // Show OCR page
    public function index()
    {
        return view('tools.tool');
    }

    // Save OCR text from JS
    public function saveOcr(Request $request)
    {
        // Validate input
        $request->validate([
            'text' => 'required|string'
        ]);

        // Insert into database
        DB::table('ocr_texts')->insert([
            'text' => $request->text,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'OCR text saved successfully'
        ]);
    }
}