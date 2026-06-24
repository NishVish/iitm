<?php

namespace App\Http\Controllers\Ai;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Smalot\PdfParser\Parser;
class RagController extends Controller
{
    private string $dbPath;
    private string $ragPath;
    private string $model = 'qwen2.5:14b';
    public function __construct()
    {
        $this->ragPath = public_path('ai/rag');
        $this->dbPath = $this->ragPath . '/data.sqlite3';
        $this->ragTestDbPath = $this->ragPath . '/ragtest.sqlite3';

    }

    /*
    |--------------------------------------------------------------------------
    | ASK
    |--------------------------------------------------------------------------
    */

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

    /*
    |--------------------------------------------------------------------------
    | UPDATE DATA (scrape + store)
    |--------------------------------------------------------------------------
    */

    public function updateData()
    {
        $dataPath = public_path('ai/data.json');

        if (!file_exists($dataPath)) {
            return $this->error('data.json not found', 404);
        }

        $documents = json_decode(file_get_contents($dataPath), true);

        if (empty($documents['documents'])) {
            return $this->error('No documents found in data.json', 422);
        }

        if (!file_exists($this->ragPath)) {
            mkdir($this->ragPath, 0755, true);
        }

        $results = [];
        foreach ($documents['documents'] as $document) {

            $source = $document['source'] ?? null;
            $type = $document['type'] ?? null;

            if (!$source || !$type) {
                continue;
            }

            if ($type === 'website') {

                $result = $this->scrapeWebsite($source);
                $results[] = $result;

            } elseif ($type === 'pdf') {

                $result = $this->processPdf($source);
                $results[] = $result;

            } elseif ($type === 'json') {

                $result = $this->processJson($source);
                $results[] = $result;
            }
        }
        $this->runRagOnData();
        return redirect(url('chat'));
        // return $this->RagTest();
    }
    private function processJson(string $source): array
    {
        try {

            $path = public_path($source);

            if (!file_exists($path)) {
                throw new \Exception("JSON file not found: {$path}");
            }

            $data = json_decode(file_get_contents($path), true);

            if (!$data) {
                throw new \Exception("Invalid JSON format");
            }

            // normalize into text for RAG
            $text = json_encode($data, JSON_PRETTY_PRINT);

            $structuredData = [
                'type' => 'json',
                'source' => $source,
                'text' => substr($text, 0, 50000)
            ];

            $filename = pathinfo($source, PATHINFO_FILENAME);

            $savePath = $this->ragPath . '/' . $filename . '.json';

            file_put_contents(
                $savePath,
                json_encode($structuredData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
            );

            return [
                'json' => $source,
                'saved' => $savePath,
                'size' => strlen($text)
            ];

        } catch (\Exception $e) {

            return [
                'json' => $source,
                'error' => $e->getMessage()
            ];
        }
    }
    /*
    |--------------------------------------------------------------------------
    | PROCESS PDF
    |--------------------------------------------------------------------------
    */

    public function RagTest()
    {
        $db = new \SQLite3($this->ragTestDbPath);

        $db->exec("
        CREATE TABLE IF NOT EXISTS rag_questions (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            question TEXT,
            answer TEXT DEFAULT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )
    ");

        $prompt = "
Generate 20 interview questions about IITMINDIA Website.
Return ONLY one question per line.
No numbering, no extra text.
";

        $response = Http::timeout(120)->post('http://localhost:11434/api/generate', [
            'model' => $this->model,
            'prompt' => $prompt,
            'stream' => false
        ]);

        $text = $response->json('response');

        if (!$text) {
            return view('ai.index', [
                'error' => 'No response from model'
            ]);
        }

        $lines = preg_split("/\r\n|\n|\r/", trim($text));

        $questions = [];
        $inserted = 0;

        foreach ($lines as $line) {

            $question = trim($line);

            if (strlen($question) < 5)
                continue;

            // insert into DB
            $stmt = $db->prepare("
            INSERT INTO rag_questions (question)
            VALUES (:question)
        ");

            $stmt->bindValue(':question', $question, SQLITE3_TEXT);
            $stmt->execute();

            $questions[] = $question;
            $inserted++;
        }

        return view('ai.index', [
            'questions' => $questions,
            'inserted' => $inserted
        ]);
    }
    private function processPdf(string $source): array
    {
        try {

            $pdfPath = public_path($source);

            if (!file_exists($pdfPath)) {
                throw new \Exception("PDF not found: {$pdfPath}");
            }

            $parser = new Parser();
            $pdf = $parser->parseFile($pdfPath);

            $text = $pdf->getText();

            $structuredData = [
                'type' => 'pdf',
                'source' => $source,
                'text' => substr($text, 0, 50000)
            ];

            $filename = pathinfo($source, PATHINFO_FILENAME);

            $savePath = $this->ragPath . '/' . $filename . '.json';

            file_put_contents(
                $savePath,
                json_encode(
                    $structuredData,
                    JSON_PRETTY_PRINT |
                    JSON_UNESCAPED_SLASHES |
                    JSON_UNESCAPED_UNICODE
                )
            );

            return [
                'pdf' => $source,
                'saved' => $savePath,
                'characters' => strlen($text)
            ];

        } catch (\Exception $e) {

            Log::error("PDF processing failed", [
                'pdf' => $source,
                'error' => $e->getMessage()
            ]);

            return [
                'pdf' => $source,
                'error' => $e->getMessage()
            ];
        }
    }
    /*
    |--------------------------------------------------------------------------
    | SCRAPE WEBSITE
    |--------------------------------------------------------------------------
    */

    private function scrapeWebsite(string $source): array
    {
        $baseUrl = rtrim($source, '/');
        try {

            if (!preg_match('/^https?:\/\//', $baseUrl)) {
                $baseUrl = 'https://' . $baseUrl;
            }

            $homepageHtml = @file_get_contents($baseUrl);

            if ($homepageHtml === false) {
                throw new \Exception("Failed to fetch homepage");
            }

            [$homepageText, $links] = $this->parseHtml($homepageHtml, $baseUrl, $source);

            $pages = [];

            foreach (array_slice($links, 0, 10) as $pageUrl) {
                $pages[] = $this->scrapePage($pageUrl);
            }

            $structuredData = [
                'website' => $source,
                'homepage' => [
                    'url' => $baseUrl,
                    'text' => substr($homepageText, 0, 5000),
                    'links' => $links
                ],
                'pages' => $pages
            ];

            $filename = pathinfo($source, PATHINFO_FILENAME);
            $savePath = $this->ragPath . '/' . $filename . '.json';

            file_put_contents(
                $savePath,
                json_encode($structuredData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
            );

            return ['website' => $source, 'saved' => $savePath, 'pages' => count($pages)];

        } catch (\Exception $e) {
            Log::error("RAG scrape failed: {$source}", ['error' => $e->getMessage()]);
            return ['website' => $source, 'error' => $e->getMessage()];
        }
    }

    /*
    |--------------------------------------------------------------------------
    | PARSE HTML -> TEXT + LINKS
    |--------------------------------------------------------------------------
    */

    private function parseHtml(string $html, string $baseUrl, string $source): array
    {
        libxml_use_internal_errors(true);

        $dom = new \DOMDocument();
        $dom->loadHTML($html);
        $xpath = new \DOMXPath($dom);

        foreach ($xpath->query('//script | //style | //noscript | //header | //footer | //nav') as $node) {
            $node->parentNode->removeChild($node);
        }

        $body = $xpath->query('//body')->item(0);
        $text = $body ? trim(preg_replace('/\s+/', ' ', $body->textContent)) : '';

        $links = [];

        foreach ($xpath->query('//a[@href]') as $link) {
            $href = trim($link->getAttribute('href'));

            if (
                empty($href) ||
                str_starts_with($href, '#') ||
                str_starts_with($href, 'mailto:') ||
                str_starts_with($href, 'tel:') ||
                preg_match('/\.(jpg|jpeg|png|gif|pdf|svg|webp)$/i', $href)
            ) {
                continue;
            }

            if (str_starts_with($href, '/')) {
                $href = rtrim($baseUrl, '/') . $href;
            }

            if (str_contains($href, $source)) {
                $links[] = $href;
            }
        }

        return [$text, array_values(array_unique($links))];
    }

    /*
    |--------------------------------------------------------------------------
    | SCRAPE SINGLE PAGE
    |--------------------------------------------------------------------------
    */

    private function scrapePage(string $url): array
    {
        try {
            $html = @file_get_contents($url);

            if ($html === false)
                throw new \Exception("Fetch failed");

            libxml_use_internal_errors(true);

            $dom = new \DOMDocument();
            @$dom->loadHTML($html);
            $xpath = new \DOMXPath($dom);

            foreach ($xpath->query('//script | //style') as $node) {
                $node->parentNode->removeChild($node);
            }

            $title = trim($xpath->query('//title')->item(0)?->textContent ?? '');
            $bodyNode = $xpath->query('//body')->item(0);
            $pageText = $bodyNode ? trim(preg_replace('/\s+/', ' ', $bodyNode->textContent)) : '';

            $innerLinks = [];
            foreach ($xpath->query('//a[@href]') as $link) {
                $href = trim($link->getAttribute('href'));
                if (!empty($href)) {
                    $innerLinks[] = $href;
                }
            }

            return [
                'title' => $title,
                'url' => $url,
                'text' => substr($pageText, 0, 5000),
                'links' => array_values(array_unique($innerLinks))
            ];

        } catch (\Exception $e) {
            return ['url' => $url, 'error' => $e->getMessage()];
        }
    }

    /*
    |--------------------------------------------------------------------------
    | RUN RAG ON DATA (embed + store)
    |--------------------------------------------------------------------------
    */

    public function runRagOnData()
    {
        if (!file_exists($this->ragPath)) {
            return $this->error('RAG folder not found', 404);
        }

        $sqlite = new \SQLite3($this->dbPath);

        $sqlite->exec("
            CREATE TABLE IF NOT EXISTS embeddings (
                id          INTEGER PRIMARY KEY AUTOINCREMENT,
                file_name   TEXT,
                chunk_index INTEGER,
                content     TEXT,
                embedding   TEXT,
                created_at  DATETIME DEFAULT CURRENT_TIMESTAMP
            )
        ");

        $sqlite->exec("CREATE INDEX IF NOT EXISTS idx_file_name ON embeddings (file_name)");

        $files = glob($this->ragPath . '/*.json');
        $results = [];

        foreach ($files as $file) {
            $fileName = basename($file);
            $data = json_decode(file_get_contents($file), true);

            if (!$data)
                continue;

            $text = strip_tags(json_encode($data));
            $text = preg_replace('/\s+/', ' ', $text);
            $chunks = str_split($text, 1000);

            // clear old chunks for this file
            $stmt = $sqlite->prepare(
                "DELETE FROM embeddings WHERE file_name = :file_name"
            );

            $stmt->bindValue(':file_name', $fileName, SQLITE3_TEXT);

            $stmt->execute();
            $saved = 0;

            foreach ($chunks as $index => $chunk) {
                $chunk = trim($chunk);
                if (empty($chunk))
                    continue;

                $embedding = $this->getEmbedding($chunk);

                $stmt = $sqlite->prepare("
                    INSERT INTO embeddings (file_name, chunk_index, content, embedding)
                    VALUES (:file_name, :chunk_index, :content, :embedding)
                ");

                $stmt->bindValue(':file_name', $fileName);
                $stmt->bindValue(':chunk_index', $index);
                $stmt->bindValue(':content', $chunk);
                $stmt->bindValue(':embedding', json_encode($embedding));
                $stmt->execute();

                $saved++;
            }

            $results[] = [
                'file' => $fileName,
                'chunks' => $saved,
                'status' => 'embedded'
            ];
        }

        $sqlite->close();

        return response()->json([
            'status' => true,
            'database' => $this->dbPath,
            'results' => $results
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | GET EMBEDDING FROM OPENAI
    |--------------------------------------------------------------------------
    */
    private function getEmbedding(string $text): array
    {
        try {

            $response = Http::timeout(30)->post(
                'http://localhost:11434/api/embeddings',
                [
                    'model' => 'nomic-embed-text',
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