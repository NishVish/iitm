<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;

class DownloadController extends Controller
{
    public function downloadfile($file_name = null)
    {
        // dd("hello");
        if (!$file_name) {
            return back()->with('error', 'File not specified');
        }

        // Special case: sponsorship file
        if ($file_name === 'sponsorship') {


            // dd("hello");

            $path = public_path('public/assets/resource/sponsorship.pdf');
            // echo $path;
            // die;
            if (file_exists($path)) {
                return response()->download($path);
            }

            return back()->with('error', 'File not found');
        }

        // Default download
        $path = public_path('assets/' . $file_name);

        if (file_exists($path)) {
            return response()->download($path);
        }

        return back()->with('error', 'File not found');
    }
}