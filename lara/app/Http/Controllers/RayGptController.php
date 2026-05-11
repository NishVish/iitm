<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RayGptController extends Controller
{
    public function index()
    {
        return view('chatbot.ray');
    }

    public function iitmbot(Request $request)
    {
        // If it's a GET request, show the view. If POST, stream.
        if ($request->isMethod('get')) {
            return view('iitm'); // Ensure your view name matches
        }

        return $this->streameroutput($request);
    }

    /**
     * Standard Chat Route
     */
    public function chat(Request $request)
    {
        return $this->streameroutput($request);
    }

    /**
     * The Master Streamer
     * This handles the cURL connection to Ollama and flushes chunks to the browser.
     */
    private function streameroutput(Request $request)
    {
        $prompt = $request->input('message');

        return response()->stream(function () use ($prompt) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'http://localhost:11434/api/generate');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
                'model' => 'llama3',
                'prompt' => $prompt,
                'stream' => true,
                'keep_alive' => '30m', // Keeps the model in memory for faster follow-up
            ]));

            // Set the handler for incoming data chunks
            curl_setopt($ch, CURLOPT_WRITEFUNCTION, function ($ch, $data) {
                // Ollama sends multiple JSON objects in one chunk sometimes
                // We split them by newlines if necessary, but usually, it's one per line
                $json = json_decode($data, true);

                if (isset($json['response'])) {
                    echo $json['response'];

                    // Force the data out to the browser immediately
                    if (ob_get_level() > 0)
                        ob_flush();
                    flush();
                }
                return strlen($data);
            });

            curl_exec($ch);
            curl_close($ch);
        }, 200, [
            'Cache-Control' => 'no-cache',
            'Content-Type' => 'text/event-stream',
            'X-Accel-Buffering' => 'no', // Critical for Nginx/Apache streaming
        ]);
    }


    // public function chat(Request $request)
    // {
    //     $prompt = $request->input('message');

    //     // }
    //     $response = Http::post('http://localhost:11434/api/generate', [
    //         'model' => 'llama3',
    //         'prompt' => $prompt,
    //         'stream' => false,
    //     ]);

    //     return response()->json([
    //         'reply' => $response->json()['response'] ?? 'No response'
    //     ]);
    // }

    public function bot($text = null)
    {
        if ($text == null) {
            return view('bot');


        }

        // dd($text);
        $response = Http::connectTimeout(30)
            ->timeout(300)
            ->post(
                'http://localhost:11434/api/generate',
                [
                    'model' => 'llama3',

                    'prompt' => $text,

                    'stream' => false,
                    'keep_alive' => '30m',
                ]
            );

        return $response->json()['response'] ?? 'No response';

    }

    public function emotionofthis($text)
    {
        // dd("hello");
        $prompt = "what is the emotion of this sentence only answer in one word " . $text;
        return $this->bot($prompt);
    }

    public function colorofthisemotion($text)
    {
        // dd("hello");
        $prompt = "what is the color of this emotion only answer in hex code " . $text;
        return $this->bot($prompt);
    }

}