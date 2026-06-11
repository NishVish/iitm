<?php

namespace App\Http\Controllers\Assistant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Smalot\PdfParser\Parser;

class AssistantControllerOld extends Controller
{
    private string $webPath;
    private string $workspacePath;

    private string $webDb;
    private string $workspaceDb;

    private string $chatModel = 'qwen2.5:14b';
    private string $embeddingModel = 'nomic-embed-text';

    public function __construct()
    {
        $basePath = public_path('assistant');

        $this->webPath = $basePath . '/web';
        $this->workspacePath = $basePath . '/workspace';

        $this->webDb = $this->webPath . '/data.sqlite3';
        $this->workspaceDb = $this->workspacePath . '/data.sqlite3';
    }

    public function trainAssistant($type)
    {
        $filesResponse = $this->listFiles($type);
        $data = $filesResponse->getData(true);

        $baseDir = $type === "web" ? $this->webPath : $this->workspacePath;

        $parser = new Parser();
        $allText = "";

        $fileList = $data[$type]['files'] ?? [];

        foreach ($fileList as $fileName) {
            $filePath = $baseDir . '/' . $fileName;

            if (!File::exists($filePath)) {
                continue;
            }

            $ext = strtolower(File::extension($filePath));

            try {
                if ($ext === 'pdf') {
                    $pdf = $parser->parseFile($filePath);
                    $text = $pdf->getText();
                } elseif (in_array($ext, ['txt', 'md', 'log'])) {
                    $text = File::get($filePath);
                } else {
                    $text = "";
                }

                $allText .= "\n\n===== FILE: {$fileName} =====\n\n" . $text;
            } catch (\Exception $e) {
                Log::error("Failed parsing file {$fileName}: " . $e->getMessage());
            }
        }

        // dd($allText);
        $savePath = $baseDir . '/trained_text.txt';

        $chunks = $this->createChunks($allText);

        File::put($savePath, $chunks);

        return response()->json([
            'status' => 'success',
            'type' => $type,
            'files' => $fileList,
            'output' => $savePath
        ]);
    }


    function createChunks($text)
    {





    }

    function embedding()
    {





    }


    public function saveSql($type)
    {


        //     if($type == "web"){
//        crate the sqlite fle if not exit in the webpath;


        //     }

        //     if($type == "workspace"){
//                crate the sqlite fle if not exit in the webpath;
// workspace 


        //     }



    }

    public function ask(Request $request)
    {
        $request->validate([
            'question' => 'required|string|min:3|max:1000'
        ]);

        $question = trim($request->input('question'));

        // $question = "what company do";
        if (!file_exists($this->dbPath)) {
            return $this->error('RAG database not found', 404);
        }

        $sqlite = new \SQLite3($this->dbPath);
        $matches = $this->findMatches($sqlite, $question);
        $sqlite->close();

        if (empty($matches)) {
            return $this->error('No relevant context found', 404);
        }

        $topChunks = array_slice($matches, 0, 5);
        $context = implode("\n\n", array_column($topChunks, 'content'));

        $prompt = "
You are a RAG AI assistant.
Answer ONLY from the provided context.
If the answer is not found, say: Answer not found in documents.

CONTEXT:
{$context}

QUESTION:
{$question}
";

        $response = Http::timeout(120)->post('http://localhost:11434/api/generate', [
            'model' => $this->model,
            'prompt' => $prompt,
            'stream' => false
        ]);

        if ($response->failed()) {
            return $this->error('LLM generation failed: ' . $response->body(), 500);
        }

        $answer = $response->json('response') ?? 'No answer generated';

        return response()->json([
            'status' => true,
            'question' => $question,
            'answer' => $answer,
            'matched_files' => array_unique(array_column($topChunks, 'file_name')),
            'top_matches' => $topChunks
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | FIND MATCHES (keyword scoring)
    |--------------------------------------------------------------------------
    */

    private function findMatches(\SQLite3 $sqlite, string $question): array
    {
        $words = array_filter(
            explode(' ', strtolower($question)),
            fn($w) => strlen(trim($w)) >= 3
        );

        $result = $sqlite->query("SELECT id, file_name, content FROM embeddings");
        $matches = [];

        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $content = strtolower($row['content']);
            $score = 0;

            foreach ($words as $word) {
                if (str_contains($content, trim($word))) {
                    $score++;
                }
            }

            if ($score > 0) {
                $matches[] = [
                    'content' => $row['content'],
                    'score' => $score,
                    'file_name' => $row['file_name']
                ];
            }
        }

        usort($matches, fn($a, $b) => $b['score'] <=> $a['score']);

        return $matches;
    }


    public function listFiles($type)
    {
        $basePath = public_path('assistant');

        $webPath = $basePath . '/web';
        $workspacePath = $basePath . '/workspace';

        if ($type == "web") {
            return response()->json([
                'web' => [
                    'path' => $webPath,
                    'files' => File::exists($webPath)
                        ? collect(File::allFiles($webPath))->map(fn($file) => $file->getRelativePathname())->values()
                        : [],
                ]
            ]);
        }

        if ($type == "workspace") {
            return response()->json([
                'workspace' => [
                    'path' => $workspacePath,
                    'files' => File::exists($workspacePath)
                        ? collect(File::allFiles($workspacePath))->map(fn($file) => $file->getRelativePathname())->values()
                        : [],
                ],
            ]);
        }

        return response()->json([
            'error' => 'Invalid type'
        ], 400);
    }

    public function readfiles(Request $request)
    {
        $type = $request->input('type', 'web');
        $list = $this->listFiles($type)->getData(true);

        return response()->json($list);
    }

    public function converttotext(Request $request)
    {
        $filePath = $request->input('path');

        if (!File::exists($filePath)) {
            return response()->json(['error' => 'File not found'], 404);
        }

        $ext = strtolower(File::extension($filePath));
        $parser = new Parser();

        try {
            if ($ext === 'pdf') {
                $pdf = $parser->parseFile($filePath);
                $text = $pdf->getText();
            } else {
                $text = File::get($filePath);
            }

            return response()->json([
                'text' => $text
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function exporttext(Request $request)
    {
        $type = $request->input('type', 'web');
        $text = $request->input('text', '');

        $baseDir = $type === "web" ? $this->webPath : $this->workspacePath;
        $filePath = $baseDir . '/exported_text_' . time() . '.txt';

        File::put($filePath, $text);

        return response()->json([
            'status' => 'saved',
            'path' => $filePath
        ]);
    }
}