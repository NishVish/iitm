<?php

namespace App\Http\Controllers\Ai;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Utility\ListFiles;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Smalot\PdfParser\Parser;
class RagServicesQuery extends Controller
{
    private string $dbPath;
    private string $ragPath;
    private string $model;

    public function __construct()
    {
        $this->ragPath = storage_path('app/rag');
        $this->dbPath = $this->ragPath . '/data.sqlite3';
        $this->ragTestDbPath = $this->ragPath . '/ragtest.sqlite3';
        $this->model = config('ai.model');

    }







    /*
    |--------------------------------------------------------------------------
    | ASK
    |--------------------------------------------------------------------------
    */

    public function ask(Request $request)
    {

        // echo "helo";

        // die();

        $topChunks = [];
        $request->validate([
            'question' => 'required|string|min:3|max:1000'
        ]);

        $question = trim($request->input('question'));

        // $question = "what company do";
        if (!file_exists($this->dbPath)) {
            //return $this->error('RAG database not found', 404);


            return response()->json([
                'status' => true,
                'question' => $question,
                'answer' => "please Give More Info",
                'matched_files' => array_unique(array_column($topChunks, 'file_name')),
                'top_matches' => $topChunks
            ]);
        }

        $sqlite = new \SQLite3($this->dbPath);
        $matches = $this->findMatches($sqlite, $question);
        $sqlite->close();

        if (empty($matches)) {
            //return $this->error('No relevant context found', 404);

            return response()->json([
                'status' => true,
                'question' => $question,
                'answer' => "please Give More Info",
                'matched_files' => array_unique(array_column($topChunks, 'file_name')),
                'top_matches' => $topChunks
            ]);

        }

        $topChunks = array_slice($matches, 0, 5);
        $context = implode("\n\n", array_column($topChunks, 'content'));

        $prompt = "
You are a helpful assistant.

Rules:
- Use ONLY information from the provided context.
- If the answer is not in the context, reply exactly: I Need More Info.
- Answer naturally and professionally.
- When listing events, use bullet points.
- Include event name, dates, and venue.
- Do not mention 'based on the context' or 'provided context'.
- Do not number items unless explicitly asked.
- If no Answer Found Reply Please Give More Info.

CONTEXT:
{$context}

QUESTION:
{$question}
";
        // echo $context ." | " . $question;
// echo $this->model;

        // echo "<br>";
// echo $prompt;

        // die();
        $response = Http::timeout(120)->post('http://localhost:11434/api/generate', [
            'model' => $this->model,
            'prompt' => $prompt,
            'stream' => false
        ]);

        // echo "<br>";
// echo $response;

        // die();
        if ($response->failed()) {
            return $this->error('LLM generation failed: ' . $response->body(), 500);
        }

        $answer = $response->json('response') ?? 'No answer generated';
        // echo $answer;

        // die();
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

    /*
    |--------------------------------------------------------------------------
    | COSINE SIMILARITY
    |--------------------------------------------------------------------------
    */

    private function cosineSimilarity(array $a, array $b): float
    {
        $dot = 0.0;
        $normA = 0.0;
        $normB = 0.0;

        foreach ($a as $i => $val) {
            $dot += $val * $b[$i];
            $normA += $val * $val;
            $normB += $b[$i] * $b[$i];
        }

        $denom = sqrt($normA) * sqrt($normB);

        return $denom > 0 ? $dot / $denom : 0.0;
    }

    // public function updateData2(){

    //         $path = public_path('ai/rag/resource');


    // }



    /*
    |--------------------------------------------------------------------------
    | ERROR HELPER
    |--------------------------------------------------------------------------
    */

    private function error(string $message, int $status = 400)
    {
        return response()->json(['status' => false, 'message' => $message], $status);
    }
}