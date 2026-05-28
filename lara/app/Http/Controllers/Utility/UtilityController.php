<?php

namespace App\Http\Controllers\Utility;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Smalot\PdfParser\Parser;

class UtilityController extends Controller
{
    public function pdftotext()
    {
        return view("utility.index");
    }

    public function convert(Request $request)
    {
        $request->validate([
            'pdf' => 'required|mimes:pdf|max:20480'
        ]);

        $file = $request->file('pdf');

        // ✅ SAFE FILE SAVE (no Laravel storage confusion)
        $filename = time() . '_' . $file->getClientOriginalName();

        $tempPath = storage_path('app/temp');

        if (!file_exists($tempPath)) {
            mkdir($tempPath, 0777, true);
        }

        $fullPath = $tempPath . '/' . $filename;

        $file->move($tempPath, $filename);

        try {

            $parser = new Parser();

            $pdf = $parser->parseFile($fullPath);

            $text = $pdf->getText();

            return view('utility.index', [
                'text' => $text
            ]);

        } catch (\Exception $e) {

            return view('utility.index', [
                'error' => $e->getMessage()
            ]);
        }
    }
}