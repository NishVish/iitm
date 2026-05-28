<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Programs extends Controller
{
    public function sponsorship()
    {
        return view('web.sponsorship.index');
    }

    public function hostedBuyer()
    {
        return view('web.hostedbuyer.index');
    }


    public function data()
    {
        try {
            $path = public_path('assets/sponsor.json');

            if (!file_exists($path)) {
                return response()->json([
                    'success' => false,
                    'message' => 'JSON file not found',
                    'path' => $path
                ], 404);
            }

            $json = file_get_contents($path);

            if ($json === false) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unable to read JSON file'
                ], 500);
            }

            $data = json_decode($json, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid JSON format',
                    'error' => json_last_error_msg()
                ], 500);
            }

            return response()->json([
                'success' => true,
                'data' => $data
            ]);

        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Server error',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}