<?php

namespace App\Http\Controllers\Ai;

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
        $this->ragPath =  storage_path('app/rag');
        $this->dbPath = $this->ragPath . '/data.sqlite3';
        $this->ragTestDbPath = $this->ragPath . '/ragtest.sqlite3';
        $this->model = config('ai.model');

    }

public function train()
{
	
	$this->removeOldEmbeddingData();
	
    $pdfPath = storage_path('app/rag/brochure.pdf');

   $text = $this->processPdf($pdfPath);

    $this->runRagProcess(
        'brochure.pdf',
        $text
    );


$this->websiteRag("https://iitmindia.com/");
// $this->websiteRag("https://ttfotm.com/");
// $this->websiteRag("https://spheretravelmedia.com/");



    return redirect('chat');
}
	
public function websiteRag(string $websiteLink)
{
    $visited = [];

    // Process homepage
    $html = $this->scrapePage($websiteLink);

    if (!$html) {
        return;
    }

    $text = $this->htmlToText($html);
    $this->runRagProcess($websiteLink, $text);

    $visited[$websiteLink] = true;

    // Find all internal links
    $links = $this->extractLinks($html, $websiteLink);

    foreach ($links as $link) {

        if (isset($visited[$link])) {
            continue;
        }

        $visited[$link] = true;

        $pageHtml = $this->scrapePage($link);

        if (!$pageHtml) {
            continue;
        }

        $pageText = $this->htmlToText($pageHtml);

        $this->runRagProcess($link, $pageText);
    }
}
	
private function scrapePage(string $url): ?string
{
    // Block non-web URLs
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

private function htmlToText(string $html): string
{
    return trim(
        html_entity_decode(
            strip_tags($html),
            ENT_QUOTES | ENT_HTML5,
            'UTF-8'
        )
    );
}
private function extractLinks(string $html, string $baseUrl): array
{
    preg_match_all('/<a\s[^>]*href=["\']([^"\']+)["\']/i', $html, $matches);

    $links = [];

    foreach ($matches[1] as $href) {

        // Ignore anchors, mailto, javascript
        if (
            str_starts_with($href, '#') ||
            str_starts_with($href, 'mailto:') ||
            str_starts_with($href, 'javascript:')
        ) {
            continue;
        }

        // Convert relative URLs to absolute
        $url = $this->absoluteUrl($baseUrl, $href);

        // Keep only internal links
        if (parse_url($url, PHP_URL_HOST) === parse_url($baseUrl, PHP_URL_HOST)) {
            $links[] = $url;
        }
    }

    return array_values(array_unique($links));
}

	private function absoluteUrl(string $baseUrl, string $href): string
{
    // Already an absolute URL
    if (filter_var($href, FILTER_VALIDATE_URL)) {
        return $href;
    }

    $base = parse_url($baseUrl);

    $scheme = $base['scheme'] ?? 'https';
    $host   = $base['host'];

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
	private function processPdf(string $source): string
	{
		try {

			if (!file_exists($source)) {
				throw new \Exception("PDF not found: {$source}");
			}

			$parser = new Parser();
			$pdf = $parser->parseFile($source);

			return $pdf->getText();

		} catch (\Exception $e) {

			Log::error("PDF processing failed", [
				'pdf' => $source,
				'error' => $e->getMessage()
			]);

			return '';
		}
	}
		
	
    

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