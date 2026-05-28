<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class HighlightsController extends Controller
{
    /**
     * Get all highlights
     */
    public function index()
    {
        try {

            $highlights = DB::table('highlights')
                ->orderBy('id', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $highlights
            ], 200);

        } catch (\Exception $e) {

            Log::error('Highlights Index Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch highlights'
            ], 500);
        }
    }

    /**
     * Store new highlight
     */
    public function store(Request $request)
    {
        try {

            // DEBUG REQUEST
            Log::info('Highlights Store Request', [
                'all' => $request->all(),
                'files' => $request->file(),
                'type' => 'nullable|string|max:255',

            ]);

            // VALIDATION
            $request->validate([
                'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
                'text' => 'required|string',
                'type' => 'nullable|string|max:255',

            ]);

            // CHECK DIRECTORY
            $destinationPath = public_path('asset/highlights');

            if (!file_exists($destinationPath)) {

                mkdir($destinationPath, 0777, true);

                Log::info('Directory created', [
                    'path' => $destinationPath
                ]);
            }

            // CHECK IMAGE EXISTS
            if (!$request->hasFile('image')) {

                Log::error('No image uploaded');

                return redirect()->back()->with(
                    'error',
                    'No image uploaded'
                );
            }

            $image = $request->file('image');

            Log::info('Uploaded Image Info', [
                'original_name' => $image->getClientOriginalName(),
                'extension' => $image->extension(),
                'size' => $image->getSize(),
                'mime' => $image->getMimeType(),
            ]);

            // GENERATE IMAGE NAME
            $imageName = time() . '_' . uniqid() . '.' . $image->extension();

            // MOVE IMAGE
            $image->move($destinationPath, $imageName);

            // SAVE PATH
            $imagePath = '/assets/highlights/' . $imageName;

            Log::info('Image moved successfully', [
                'path' => $imagePath
            ]);

            // INSERT DATABASE
            $id = DB::table('highlights')->insertGetId([
                'image' => $imagePath,
                'text' => $request->text,
                'type' => $request->type, // ✅ ADD THIS

                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            Log::info('Highlight inserted', [
                'id' => $id
            ]);

            return redirect()->back()->with(
                'success',
                'Highlight created successfully'
            );

        } catch (\Illuminate\Validation\ValidationException $e) {

            Log::error('Validation Error', [
                'errors' => $e->errors()
            ]);

            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();

        } catch (\Exception $e) {

            Log::error('Highlights Store Error Full Debug', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'trace' => $e->getTraceAsString(),
            ]);

            dd($e);

            return redirect()->back()->with(
                'error',
                $e->getMessage()
            );
        }
    }


    public function getHighlights($type)
    {
        try {
            Log::info('Highlights Type', [
                'type' => $type
            ]);

            $highlights = DB::table('highlights')
                ->where('type', $type)
                ->orderBy('id', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $highlights
            ], 200);

        } catch (\Exception $e) {

            Log::error('Highlights Gallery Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch highlights'
            ], 500);
        }
    }    /**
         * Update highlight
         */
    public function update(Request $request, $id)
    {
        try {

            $highlight = DB::table('highlights')
                ->where('id', $id)
                ->first();

            if (!$highlight) {

                return redirect()->back()->with(
                    'error',
                    'Highlight not found'
                );
            }

            $imagePath = $highlight->image;

            if ($request->hasFile('image')) {

                $request->validate([
                    'image' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
                    'type' => 'nullable|string|max:255',

                ]);

                if (
                    $highlight->image &&
                    File::exists(public_path($highlight->image))
                ) {
                    File::delete(public_path($highlight->image));
                }

                $imageName = time() . '.' . $request->image->extension();

                $request->image->move(
                    public_path('asset/highlights'),
                    $imageName
                );

                $imagePath = 'asset/highlights/' . $imageName;
            }

            DB::table('highlights')
                ->where('id', $id)
                ->update([
                    'image' => $imagePath,
                    'text' => $request->text,
                    'type' => $request->type, // ✅ ADD THIS

                    'updated_at' => Carbon::now(),
                ]);

            return redirect()->back()->with(
                'success',
                'Highlight updated successfully'
            );

        } catch (\Exception $e) {

            Log::error('Highlights Update Error: ' . $e->getMessage());

            return redirect()->back()->with(
                'error',
                'Failed to update highlight'
            );
        }
    }

    /**
     * Delete highlight
     */
    public function destroy($id)
    {
        try {

            $highlight = DB::table('highlights')
                ->where('id', $id)
                ->first();

            if (!$highlight) {

                return redirect()->back()->with(
                    'error',
                    'Highlight not found'
                );
            }

            if (
                $highlight->image &&
                File::exists(public_path($highlight->image))
            ) {
                File::delete(public_path($highlight->image));
            }

            DB::table('highlights')
                ->where('id', $id)
                ->delete();

            return redirect()->back()->with(
                'success',
                'Highlight deleted successfully'
            );

        } catch (\Exception $e) {

            Log::error('Highlights Delete Error: ' . $e->getMessage());

            return redirect()->back()->with(
                'error',
                'Failed to delete highlight'
            );
        }
    }

    public function highlightpageedit($type = null)
    {
        if ($type == null) {

            $highlights = DB::table('highlights')
                ->orderBy('id', 'desc')
                ->get();
        } else {

            $highlights = DB::table('highlights')
                ->where('type', $type)
                ->orderBy('id', 'desc')
                ->get();
        }
        $alltypesofhightlight = DB::table('highlights')
            ->distinct()
            ->get();

        return view(
            'backend.highlights.index',
            compact('highlights', 'alltypesofhightlight')
        );
    }
}