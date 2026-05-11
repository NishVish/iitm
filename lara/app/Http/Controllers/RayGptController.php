<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
class RayGptController extends Controller
{
    protected $model;
    protected $ollamaUrl;

    public function __construct(Request $request)
    {
        $this->detectConfig($request);
    }

    private function detectConfig(Request $request)
    {
        $host = $request->getHost();

        // LOCAL MACHINE
        if ($host === 'localhost' || $host === '127.0.0.1') {
            $this->model = 'llama3';
            $this->ollamaUrl = 'http://127.0.0.1:11434';
            return;
        }

        // ALMA LINUX SERVER
        if ($host === 'iitmindia.com') {
            $this->model = 'phi3:mini';
            $this->ollamaUrl = 'http://127.0.0.1:11434';
            return;
        }

        // fallback
        $this->model = 'llama3';
        $this->ollamaUrl = 'http://127.0.0.1:11434';
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

            curl_setopt($ch, CURLOPT_URL, $this->ollamaUrl . '/api/generate');
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
                $this->ollamaUrl . '/api/generate',
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
    public function ollamaDebug(Request $request)
    {
        $data = [];

        // 🔹 Server info
        $data['hostname'] = gethostname();
        $data['ip'] = request()->server('SERVER_ADDR');
        $data['host'] = $request->getHost();
        $data['time'] = now()->toDateTimeString();

        // 🔹 Your selected config
        $data['selected_model'] = $this->model ?? 'not-set';
        $data['ollama_url'] = $this->ollamaUrl ?? 'not-set';

        // 🔹 Check Ollama models
        try {
            $tags = Http::timeout(5)->get($this->ollamaUrl . '/api/tags');
            $data['models'] = $tags->json();
        } catch (\Exception $e) {
            $data['models_error'] = $e->getMessage();
        }

        // 🔹 Check generate endpoint
        try {
            $gen = Http::timeout(10)->post($this->ollamaUrl . '/api/generate', [
                'model' => $this->model,
                'prompt' => 'ping',
                'stream' => false,
            ]);

            $data['generate_test'] = $gen->json();
        } catch (\Exception $e) {
            $data['generate_error'] = $e->getMessage();
        }

        return response()->json($data, JSON_PRETTY_PRINT);
    }
}