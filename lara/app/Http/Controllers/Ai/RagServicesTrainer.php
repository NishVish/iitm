<?php

namespace App\Http\Controllers\Ai;
use DOMDocument;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Utility\ListFiles;

use Illuminate\Support\Facades\File;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Smalot\PdfParser\Parser;
class RagServicesTrainer extends Controller
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

    public function trainbylink($link)
    {

        $this->websiteRag($link);
        return redirect('chat');

    }

    public function train()
    {

        $this->removeOldEmbeddingData();

        // $pdfPath = storage_path('app/rag/brochure.pdf');

        // // dd('pdfPath', $pdfPath);

        // $text = $this->processPdf($pdfPath);

        // // $this->runRagProcess(
        // //     'brochure.pdf',
        // //     $text
        // // );

        $pdfPath = storage_path('app/rag/output.pdf');

        // dd('pdfPath', $pdfPath);

        $text = $this->processPdf($pdfPath);

        $this->runRagProcess(
            'output.pdf',
            $text
        );

        // $this->websiteRag("https://iitmindia.com/ci/lara");
        // $this->websiteRag("https://ttfotm.com/");
// $this->websiteRag("https://spheretravelmedia.com/");


        // dd("none");
        return redirect('chat');
    }
    private function processPdf(string $source): string
    {
        try {

            if (!file_exists($source)) {
                throw new \Exception("PDF not found: {$source}");
            }

            $parser = new Parser();
            $pdf = $parser->parseFile($source);
            // echo "<pre>";
            // print_r($pdf->getText());
            // echo "</pre>";
            return $pdf->getText();

        } catch (\Exception $e) {

            Log::error("PDF processing failed", [
                'pdf' => $source,
                'error' => $e->getMessage()
            ]);

            return '';
        }
    }


    private function htmlToText(string $html): string
    {
        libxml_use_internal_errors(true);

        $dom = new \DOMDocument();

        @$dom->loadHTML($html, LIBXML_NOERROR | LIBXML_NOWARNING | LIBXML_NONET);

        // Remove unwanted elements
        $removeTags = [
            'script',
            'style',
            'noscript',
            'svg',
            'canvas',
            'iframe',
            'header',
            'footer',
            'nav',
            'aside',
            'form',
            'button',
            'input',
            'textarea',
            'select',
            'option',
            'link',
            'meta',
            'picture',
            'source'
        ];

        foreach ($removeTags as $tag) {
            while (true) {
                $nodes = $dom->getElementsByTagName($tag);

                if ($nodes->length === 0) {
                    break;
                }

                $node = $nodes->item(0);

                $node->parentNode?->removeChild($node);
            }
        }

        $text = $dom->textContent ?? '';

        // Decode HTML entities
        $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        // Remove URLs
        $text = preg_replace('/https?:\/\/\S+/i', ' ', $text);

        // Remove emails
        $text = preg_replace('/\S+@\S+\.\S+/i', ' ', $text);

        // Remove CSS variables like --color-name
        $text = preg_replace('/--[\w-]+\s*:/', ' ', $text);

        // Remove CSS selectors and braces
        $text = preg_replace('/[.#]?[a-zA-Z0-9_-]+\s*\{[^}]*\}/s', ' ', $text);

        // Remove @media, @import, @font-face, @keyframes blocks
        $text = preg_replace('/@(media|import|font-face|keyframes)[^{]*\{(?:[^{}]*|\{[^{}]*\})*\}/is', ' ', $text);

        // Remove leftover CSS punctuation
        $text = preg_replace('/[{};<>]/', ' ', $text);

        // Remove long hexadecimal/color codes
        $text = preg_replace('/#[0-9a-f]{3,8}\b/i', ' ', $text);

        // Remove repeated punctuation
        $text = preg_replace('/[_=\-*]{2,}/', ' ', $text);

        // Normalize whitespace
        $text = preg_replace('/\R+/', "\n", $text);
        $text = preg_replace('/[ \t]+/', ' ', $text);
        $text = preg_replace('/\n{2,}/', "\n\n", $text);

        return trim($text);
    }


    public function websiteRag(string $websiteLink)
    {
        $pages = $this->crawlWebsite($websiteLink, 30);

        foreach ($pages as $url) {
            $html = $this->scrapePage($url);

            if (!$html) {
                continue;
            }

            $text = $this->htmlToText($html);
            // echo "<pre>";
            // print_r($text);
            // echo "</pre>";
            // dd("none");

            $this->runRagProcess($url, $text);
        }
    }

    /**
     * Crawl website recursively (BFS)
     * Collects max $limit internal pages.
     */
    private function crawlWebsite(string $startUrl, int $limit = 30): array
    {
        $visited = [];
        $queue = [$startUrl];
        $results = [];

        $host = parse_url($startUrl, PHP_URL_HOST);

        while (!empty($queue) && count($results) < $limit) {

            $url = array_shift($queue);

            if (isset($visited[$url])) {
                continue;
            }

            $visited[$url] = true;

            $html = $this->scrapePage($url);

            if (!$html) {
                continue;
            }

            $results[] = $url;

            if (count($results) >= $limit) {
                break;
            }

            $links = $this->extractLinks($html, $url);

            foreach ($links as $link) {

                if (count($results) + count($queue) >= $limit) {
                    break;
                }

                if (isset($visited[$link])) {
                    continue;
                }

                if (parse_url($link, PHP_URL_HOST) !== $host) {
                    continue;
                }

                $queue[] = $link;
            }
        }

        return $results;
    }

    private function scrapePage(string $url): ?string
    {
        // Ignore non-http links
        if (
            str_starts_with($url, 'mailto:') ||
            str_starts_with($url, 'tel:') ||
            str_starts_with($url, 'javascript:')
        ) {
            return null;
        }

        try {
            $context = stream_context_create([
                'http' => [
                    'timeout' => 10,
                    'ignore_errors' => true,
                    'user_agent' => 'Mozilla/5.0 RAG-Bot'
                ]
            ]);

            $html = @file_get_contents($url, false, $context);

            if (!$html) {
                return null;
            }

            return $html;

        } catch (\Throwable $e) {
            return null;
        }
    }

    /**
     * Extract all internal links from HTML.
     */
    private function extractLinks(string $html, string $baseUrl): array
    {
        libxml_use_internal_errors(true);

        $dom = new DOMDocument();

        @$dom->loadHTML($html);

        $links = [];

        $baseParts = parse_url($baseUrl);

        $scheme = $baseParts['scheme'] ?? 'https';
        $host = $baseParts['host'] ?? '';

        foreach ($dom->getElementsByTagName('a') as $a) {

            $href = trim($a->getAttribute('href'));

            if ($href === '') {
                continue;
            }

            if (
                str_starts_with($href, '#') ||
                str_starts_with($href, 'mailto:') ||
                str_starts_with($href, 'tel:') ||
                str_starts_with($href, 'javascript:')
            ) {
                continue;
            }

            // Absolute URL
            if (preg_match('/^https?:\/\//i', $href)) {
                $absolute = $href;
            }
            // Root-relative
            elseif (str_starts_with($href, '/')) {
                $absolute = $scheme . '://' . $host . $href;
            }
            // Relative
            else {
                $path = $baseParts['path'] ?? '/';
                $path = preg_replace('#/[^/]*$#', '/', $path);
                $absolute = $scheme . '://' . $host . $path . $href;
            }

            $absolute = strtok($absolute, '#');

            // Normalize ../ and ./
            $parts = parse_url($absolute);

            if (!isset($parts['host'])) {
                continue;
            }

            $path = $parts['path'] ?? '/';

            $segments = [];

            foreach (explode('/', $path) as $segment) {

                if ($segment === '' || $segment === '.') {
                    continue;
                }

                if ($segment === '..') {
                    array_pop($segments);
                    continue;
                }

                $segments[] = $segment;
            }

            $normalized =
                ($parts['scheme'] ?? 'https') .
                '://' .
                $parts['host'] .
                '/' .
                implode('/', $segments);

            if (!empty($parts['query'])) {
                $normalized .= '?' . $parts['query'];
            }

            if (($parts['host'] ?? '') !== $host) {
                continue;
            }

            $links[$normalized] = true;
        }

        return array_keys($links);
    }


    private function absoluteUrl(string $baseUrl, string $href): string
    {
        // Already an absolute URL
        if (filter_var($href, FILTER_VALIDATE_URL)) {
            return $href;
        }

        $base = parse_url($baseUrl);

        $scheme = $base['scheme'] ?? 'https';
        $host = $base['host'];

        // Root-relative URL
        if (str_starts_with($href, '/')) {
            return $scheme . '://' . $host . $href;
        }

        // Relative URL
        $path = isset($base['path']) ? dirname($base['path']) : '';

        return rtrim($scheme . '://' . $host . '/' . trim($path, '/'), '/') . '/' . ltrim($href, '/');
    }
    /*
    |--------------------------------------------------------------------------
    | PROCESS PDF
    |--------------------------------------------------------------------------
    */



    public function removeOldEmbeddingData()
    {
        $sqlite = new \SQLite3($this->dbPath);

        $sqlite->exec("
        CREATE TABLE IF NOT EXISTS embeddings (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            file_name TEXT,
            chunk_index INTEGER,
            content TEXT,
            embedding TEXT,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )
    ");

        // Delete all rows
        $sqlite->exec("DELETE FROM embeddings");

        // Optional: Reset auto-increment IDs
        $sqlite->exec("DELETE FROM sqlite_sequence WHERE name='embeddings'");
    }
    /*
    |--------------------------------------------------------------------------
    | RUN RAG ON DATA (embed + store)
    |--------------------------------------------------------------------------
    */

    public function runRagProcess(string $fileName, string $text)
    {
        $sqlite = new \SQLite3($this->dbPath);

        $sqlite->exec("
        CREATE TABLE IF NOT EXISTS embeddings (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            file_name TEXT,
            chunk_index INTEGER,
            content TEXT,
            embedding TEXT,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )
    ");

        $stmt = $sqlite->prepare(
            "DELETE FROM embeddings WHERE file_name = :file_name"
        );

        $stmt->bindValue(':file_name', $fileName, SQLITE3_TEXT);
        $stmt->execute();

        $chunks = str_split($text, 1000);

        $saved = 0;

        foreach ($chunks as $index => $chunk) {

            $chunk = trim($chunk);

            if ($chunk === '') {
                continue;
            }

            $embedding = $this->getEmbedding($chunk);

            $stmt = $sqlite->prepare("
            INSERT INTO embeddings
            (file_name, chunk_index, content, embedding)
            VALUES
            (:file_name, :chunk_index, :content, :embedding)
        ");

            $stmt->bindValue(':file_name', $fileName);
            $stmt->bindValue(':chunk_index', $index);
            $stmt->bindValue(':content', $chunk);
            $stmt->bindValue(':embedding', json_encode($embedding));

            $stmt->execute();

            $saved++;
        }

        $sqlite->close();

        return [
            'file' => $fileName,
            'chunks' => $saved
        ];
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