<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RayGptController extends Controller
{
    protected $model;

    /**
     * Constructor
     */
    public function __construct(Request $request)
    {
        $this->model = $this->selectModel($request);
    }

    /**
     * Select model based on URL
     */
    private function selectModel(Request $request)
    {
        $url = $request->fullUrl();
        echo $url;

        // localhost → llama3
        if (str_contains($url, 'localhost')) {
            echo 'llama3';
            return 'llama3';
        }

        // production URL → phi3:mini
        if (str_contains($url, 'iitmindia.com/ci/lara/bot')) {
            echo 'phi3:mini';
            return 'phi3:mini';
        }
        // echo $url;

        return 'llama3';
    }

    public function index()
    {
        return view('chatbot.ray');
    }

    public function iitmbot(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('iitm');
        }

        return $this->streameroutput($request);
    }

    public function chat(Request $request)
    {
        return $this->streameroutput($request);
    }

    /**
     * Stream response from Ollama
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
                'model' => $this->model,
                'prompt' => $prompt,
                'stream' => true,
                'keep_alive' => '30m',
            ]));

            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json'
            ]);

            curl_setopt($ch, CURLOPT_WRITEFUNCTION, function ($ch, $data) {

                $lines = explode("\n", trim($data));

                foreach ($lines as $line) {

                    $json = json_decode($line, true);

                    if (isset($json['response'])) {

                        echo $json['response'];

                        if (ob_get_level() > 0) {
                            ob_flush();
                        }

                        flush();
                    }
                }

                return strlen($data);
            });

            curl_exec($ch);

            curl_close($ch);

        }, 200, [
            'Cache-Control' => 'no-cache',
            'Content-Type' => 'text/event-stream',
            'X-Accel-Buffering' => 'no',
        ]);
    }

    /**
     * Normal bot response
     */
    public function bot($text = null)
    {
        if ($text == null) {
            return view('bot');
        }

        $response = Http::connectTimeout(30)
            ->timeout(300)
            ->post(
                'http://localhost:11434/api/generate',
                [
                    'model' => $this->model,
                    'prompt' => $text,
                    'stream' => false,
                    'keep_alive' => '30m',
                ]
            );

        return $response->json()['response'] ?? 'No response';
    }

    public function emotionofthis($text)
    {
        $prompt = "what is the emotion of this sentence only answer in one word " . $text;

        return $this->bot($prompt);
    }

    public function colorofthisemotion($text)
    {
        $prompt = "what is the color of this emotion only answer in hex code " . $text;

        return $this->bot($prompt);
    }
}