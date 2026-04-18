<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IdentifycategoryController extends Controller
{

    public function dictionaryEditor()
    {
        $path = public_path('assets/dictionary.json');

        if (!file_exists($path)) {
            return back()->with('error', 'Dictionary file not found.');
        }

        $json = file_get_contents($path);
        $dictionary = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return back()->with('error', 'Invalid JSON format.');
        }

        return view('dictionaryeditor', compact('dictionary'));
    }
    public function update(Request $request)
    {
        $keywords = $request->keyword;
        $categories = $request->category;

        $data = [];

        foreach ($keywords as $i => $keyword) {
            if (!$keyword)
                continue;

            $data[] = [
                'keyword' => $keyword,
                'category' => $categories[$i] ?? ''
            ];
        }

        file_put_contents(
            public_path('assets/dictionary.json'),
            json_encode($data, JSON_PRETTY_PRINT)
        );

        return back()->with('success', 'Updated successfully');
    }
    public function category($nameofthecompany = null)
    {
        if (empty($nameofthecompany)) {
            return response()->json([
                'status' => false,
                'message' => 'Company name is required',
                'category' => null
            ]);
        }

        $path = public_path('assets/dictionary.json');

        if (!file_exists($path)) {
            return response()->json([
                'status' => false,
                'message' => 'Dictionary not found',
                'category' => null
            ]);
        }

        $json = file_get_contents($path);
        $dictionary = json_decode($json, true);

        if (!is_array($dictionary)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid dictionary format',
                'category' => null
            ]);
        }

        $companyName = strtolower(trim($nameofthecompany));
        $foundCategory = null;
        $matchedKeyword = null;

        foreach ($dictionary as $item) {
            $keyword = strtolower($item['keyword'] ?? '');

            if ($keyword !== '' && stripos($companyName, $keyword) !== false) {
                $foundCategory = $item['category'] ?? 'Uncategorized';
                $matchedKeyword = $keyword;
                break;
            }
        }

        return response()->json([
            'status' => true,
            'company_name' => $nameofthecompany,
            'category' => $foundCategory ?? 'Uncategorized',
            'keyword' => $matchedKeyword
        ]);
    }
}