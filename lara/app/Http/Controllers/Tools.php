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
        // $request->validate(['text' => 'required|string']);
        // DB::table('ocr_texts')->insert([
        //     'text' => $request->text,
        //     'created_at' => now(),
        //     'updated_at' => now()
        // ]);
        // return response()->json(['status' => 'success']);
    }
}