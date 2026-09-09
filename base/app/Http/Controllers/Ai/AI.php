<?php

namespace App\Http\Controllers\Ai;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class Ai extends Controller
{
    public function index()
    {
        return view('ai.index');
    }

    public function airespond(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $response = Http::timeout(120)->post(
            'http://127.0.0.1:1234/agent',
            [
                'message' => $request->message,
            ]
        );
        // dd($response);
        if ($response->failed()) {
            return response()->json([
                'success' => false,
                'error' => 'Agent server failed',
                'details' => $response->body(),
            ], 500);
        }

        return response()->json([
            'success' => true,
            'response' => $response->json('response'),
        ]);
    }

    public function respond($message)
    {

        $response = Http::timeout(120)->post(
            'http://127.0.0.1:1234/agent',
            [
                'message' => $message,
            ]
        );
        dd($response);

    }
}
