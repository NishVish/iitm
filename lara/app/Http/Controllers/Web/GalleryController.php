<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;

class GalleryController extends Controller
{
    public function gallery()
    {
        // Path to public/assets/gallery
        $galleryPath = public_path('assets/gallery');

        $result = [];

        // Get all folders inside gallery
        $folders = File::directories($galleryPath);

        foreach ($folders as $folder) {

            $folderName = basename($folder);

            // Get all image files
            $images = File::files($folder);

            $imageUrls = [];

            foreach ($images as $image) {

                $extension = strtolower($image->getExtension());

                // Allow only image files
                if (in_array($extension, ['jpg', 'jpeg', 'png', 'webp', 'gif'])) {

                    $imageUrls[] = asset(
                        'public/assets/gallery/' . $folderName . '/' . $image->getFilename()
                    );
                }
            }

            $result[] = [
                'title' => $folderName,
                'images' => $imageUrls
            ];
        }

        return response()->json([
            'status' => true,
            'data' => $result
        ]);
    }
}