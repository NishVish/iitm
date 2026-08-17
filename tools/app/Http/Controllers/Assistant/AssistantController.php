<?php

namespace App\Http\Controllers\Assistant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Smalot\PdfParser\Parser;

class AssistantController extends Controller
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


    public function assistant($type)
    {
        return view('assistant.index');

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


        $baseDir = $type === 'web'
            ? $this->webPath
            : $this->workspacePath;

        $savePath = $baseDir . '/trained_text.txt';

        File::put(
            $savePath,
            $allText
        );

        // dd($allText);
        $chunks = $this->createChunks($allText);

        $this->saveSql(
            $type,
            $chunks
        );

        return response()->json([
            'status' => true,
            'type' => $type,
            'chunks' => count($chunks),
            'database' => $type === 'web'
                ? $this->webDb
                : $this->workspaceDb,
            'output' => $savePath
        ]);
    }



    private function createChunks(string $text, int $chunkSize = 1000, int $overlap = 200): array
    {
        $chunks = [];

        $text = trim(preg_replace('/\s+/', ' ', $text));

        $length = strlen($text);
        $start = 0;
        $index = 0;

        while ($start < $length) {

            $chunk = substr($text, $start, $chunkSize);

            $chunks[] = [
                'chunk_index' => $index,
                'content' => $chunk
            ];

            $start += ($chunkSize - $overlap);
            $index++;
        }

        return $chunks;
    }

    private function embedding(string $text): array
    {
        try {

            $response = Http::timeout(60)->post(
                'http://localhost:11434/api/embeddings',
                [
                    'model' => $this->embeddingModel,
                    'prompt' => $text
                ]
            );

            return $response->json('embedding') ?? [];

        } catch (\Exception $e) {

            Log::error('Embedding failed', [
                'error' => $e->getMessage()
            ]);

            return [];
        }
    }

    public function saveSql(string $type, array $chunks)
    {
        $dbPath = '';

        if ($type === 'web') {
            $dbPath = $this->webDb;
        }

        if ($type === 'workspace') {
            $dbPath = $this->workspaceDb;
        }

        if (empty($dbPath)) {
            return false;
        }

        $sqlite = new \SQLite3($dbPath);

        $sqlite->exec("
        CREATE TABLE IF NOT EXISTS embeddings (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            chunk_index INTEGER,
            content TEXT,
            embedding TEXT,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )
    ");

        $sqlite->exec("DELETE FROM embeddings");

        foreach ($chunks as $chunk) {

            $embedding = $this->embedding(
                $chunk['content']
            );

            $stmt = $sqlite->prepare("
            INSERT INTO embeddings (
                chunk_index,
                content,
                embedding
            )
            VALUES (
                :chunk_index,
                :content,
                :embedding
            )
        ");

            $stmt->bindValue(
                ':chunk_index',
                $chunk['chunk_index'],
                SQLITE3_INTEGER
            );

            $stmt->bindValue(
                ':content',
                $chunk['content'],
                SQLITE3_TEXT
            );

            $stmt->bindValue(
                ':embedding',
                json_encode($embedding),
                SQLITE3_TEXT
            );

            $stmt->execute();
        }

        $sqlite->close();

        return true;
    }



    public function ask(Request $request, string $type = 'web')
    {




        $request->validate([
            'question' => 'required|string|min:3|max:1000',
        ]);

        $question = trim($request->question);

        $dbPath = match ($type) {
            'web' => $this->webDb,
            'workspace' => $this->workspaceDb,
            default => null
        };

        if (!$dbPath) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid source type'
            ], 400);
        }

        if (!file_exists($dbPath)) {
            return response()->json([
                'status' => false,
                'message' => 'Database not found'
            ], 404);
        }

        $sqlite = new \SQLite3($dbPath);

        $matches = $this->findMatches(
            $sqlite,
            $question
        );

        $sqlite->close();

        if (empty($matches)) {
            return response()->json([
                'status' => false,
                'message' => 'No relevant context found'
            ], 404);
        }

        $topChunks = array_slice(
            $matches,
            0,
            5
        );

        $context = implode(
            "\n\n",
            array_column($topChunks, 'content')
        );



        $prompt = <<<PROMPT
You are a RAG AI assistant.

Answer ONLY from the provided context.

If the answer is not found, reply:
Answer not found in documents.

CONTEXT:
{$context}

QUESTION:
{$question}
PROMPT;

        try {

            $response = Http::timeout(120)->post(
                'http://localhost:11434/api/generate',
                [
                    'model' => $this->chatModel,
                    'prompt' => $prompt,
                    'stream' => false
                ]
            );

            if ($response->failed()) {
                return response()->json([
                    'status' => false,
                    'message' => 'LLM request failed',
                    'error' => $response->body()
                ], 500);
            }

            $answer = $response->json('response')
                ?? 'No answer generated';

            return response()->json([
                'status' => true,
                'type' => $type,
                'question' => $question,
                'answer' => trim($answer),
                'chunks_used' => count($topChunks),
                'matches' => $topChunks
            ]);

        } catch (\Exception $e) {

            Log::error('Ask failed', [
                'type' => $type,
                'question' => $question,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    private function findMatches(
        \SQLite3 $sqlite,
        string $question
    ): array {
        $words = array_filter(
            explode(
                ' ',
                strtolower($question)
            ),
            fn($word) => strlen($word) >= 3
        );

        $result = $sqlite->query("
        SELECT
            id,
            chunk_index,
            content
        FROM embeddings
    ");

        $matches = [];

        while (
            $row = $result->fetchArray(
                SQLITE3_ASSOC
            )
        ) {

            $score = 0;

            $content = strtolower(
                $row['content']
            );

            foreach ($words as $word) {

                if (
                    str_contains(
                        $content,
                        $word
                    )
                ) {
                    $score++;
                }
            }

            if ($score > 0) {

                $matches[] = [
                    'chunk_index' => $row['chunk_index'],
                    'content' => $row['content'],
                    'score' => $score
                ];
            }
        }

        usort(
            $matches,
            fn($a, $b) =>
            $b['score'] <=> $a['score']
        );

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