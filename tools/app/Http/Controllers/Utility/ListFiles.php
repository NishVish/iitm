<?php

namespace App\Http\Controllers\Utility;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class ListFiles extends Controller
{
    public function index(string $folder): JsonResponse
    {
        $path = public_path($folder);

        if (!is_dir($path)) {
            return response()->json([
                'success' => false,
                'message' => 'Folder not found',
            ], 404);
        }

        $files = collect(scandir($path))
            ->reject(fn ($file) => in_array($file, ['.', '..']))
            ->values();
// dd($files);
        return response()->json([
            'success' => true,
            'files' => $files,
        ]);
    }
}