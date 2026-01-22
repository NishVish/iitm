<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Websearch extends Controller
{
    public function websearch()
    {
    $webid = $this->request->getPost('webid');
    $id2   = $this->request->getPost('id2');

    if (empty($webid) || empty($id2)) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Both webid and id2 are required.'
        ]);
    }

    // Normalize URL
    $url = $webid;
    if (!preg_match('/^https?:\/\//', $url)) {
        $url = 'https://' . $url;
    }

    // Step 1: Fetch homepage and try to find "Contact" link
    $homepageHtml = @file_get_contents($url);
    if (!$homepageHtml) {
        return $this->response->setJSON(['success' => false, 'message' => 'Unable to fetch website homepage.']);
    }
    
    // Step 2: Try to find contact page URL
// Step 2: Try to find contact page URL from homepage links first
$contactPath = null;

preg_match_all('/<a[^>]+href=["\']([^"\']+)["\'][^>]*>(.*?)<\/a>/is', $homepageHtml, $matches, PREG_SET_ORDER);

foreach ($matches as $m) {
    $href = trim($m[1]);
    $text = strip_tags($m[2]);

    if (
        stripos($href, 'contact') !== false || 
        stripos($href, 'contact-us') !== false || 
        stripos($href, 'contactus') !== false || 
        stripos($text, 'contact') !== false || 
        stripos($text, 'contact us') !== false
    ) {
        $contactPath = $href;
        break;
    }
}

// Normalize base URL for fallback tries
$baseUrl = rtrim($url, '/');

if (!$contactPath) {
    // No contact link found, try common contact URLs directly
    $possiblePaths = [
        '/contact/',
        '/contact-us',
        '/contactus',
        '/contact.html',
        '/contact-us.html',
    ];

    foreach ($possiblePaths as $path) {
        $tryUrl = $baseUrl . $path;
        $tryHtml = @file_get_contents($tryUrl);
        if ($tryHtml) {
            $contactPath = $tryUrl;
            break;
        }
    }

    if (!$contactPath) {
        return $this->response->setJSON(['success' => false, 'message' => 'Contact page not found.']);
    }
}

// If the contactPath is relative (from link), build full URL
if (strpos($contactPath, 'http') !== 0) {
    // If it's already a full URL, keep as is
    $contactUrl = $baseUrl . '/' . ltrim($contactPath, '/');
} else {
    $contactUrl = $contactPath;
}

// Step 3: Fetch contact page content
$contactHtml = @file_get_contents($contactUrl);
if (!$contactHtml) {
    return $this->response->setJSON(['success' => false, 'message' => 'Unable to fetch contact page.']);
}

    // Step 4: Extract visible contact content as-is (without parsing)
// We'll strip HTML tags but preserve line breaks and spacing for readability

// Remove scripts/styles for cleaner content
$cleanedHtml = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $contactHtml);
$cleanedHtml = preg_replace('#<style(.*?)>(.*?)</style>#is', '', $cleanedHtml);

// Convert HTML to plain text (preserving structure)
$contactText = strip_tags($cleanedHtml);
$RawText = strip_tags($cleanedHtml);


// Clean and limit characters (optional)
$contactText = html_entity_decode($contactText, ENT_QUOTES | ENT_HTML5);
$contactText = preg_replace('/[ \t]+/', ' ', $contactText);         // Normalize spaces
$contactText = preg_replace('/\s{3,}/', "\n", $contactText);        // Convert extra spaces to newlines
$contactText = trim($contactText);

// Optional: Limit length to prevent overfilling DB
$contactText = mb_substr($contactText, 0, 3000); // Limit to 3000 characters

// Step 5: Prepare final block to append to ocr_text
$scrapedText = "// Website Contact Info:\n";
$scrapedText .= $contactText . "\n\n(Source: $contactUrl)";

// Step 6: Append to ocr_text in DB
$model = new \App\Models\ImageDataModel();

$record = $model->find($id2);
if (!$record) {
    return $this->response->setJSON(['success' => false, 'message' => 'Record not found in database.']);
}

$updatedText = rtrim($record['ocr_text']) . "\n\n" . $scrapedText;

$model->update($id2, [
    'ocr_text' => $updatedText
]);

return $this->response->setJSON([
    'success' => true,
    'highlight_id' => $id2
]);

}



}


// // public function websearch()
// {
//     helper('filesystem');

//     $webid = $this->request->getPost('webid');
//     $id2   = $this->request->getPost('id2');

//     if (empty($webid) || empty($id2)) {
//         return $this->response->setJSON([
//             'success' => false,
//             'message' => 'Both webid and id2 are required.'
//         ]);
//     }

//     // normalize URL
//     $url = $webid;
//     if (!preg_match('/^https?:\/\//i', $url)) {
//         $url = 'https://' . $url;
//     }
//     $baseUrl = rtrim($url, '/');

//     // --- fetcher using file_get_contents (no cURL) ---
//     $fetch = function ($url) {
//         // build HTTP context with browser-like headers
//         $opts = [
//             'http' => [
//                 'method'  => "GET",
//                 'header'  => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 Chrome/120 Safari/537.36\r\n" .
//                              "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8\r\n" .
//                              "Accept-Language: en-US,en;q=0.9\r\n" .
//                              "Connection: close\r\n",
//                 'timeout' => 15,
//                 'ignore_errors' => true // get the response even for non-2xx codes (so we can examine headers)
//             ],
//             'ssl' => [
//                 'verify_peer'      => false,
//                 'verify_peer_name' => false,
//             ]
//         ];
//         $context = stream_context_create($opts);

//         $html = @file_get_contents($url, false, $context);
//         // get status from $http_response_header
//         $status = 0;
//         if (!empty($http_response_header) && is_array($http_response_header)) {
//             foreach ($http_response_header as $hdr) {
//                 if (preg_match('#^HTTP/\d+\.\d+\s+(\d+)#i', $hdr, $m)) {
//                     $status = (int)$m[1];
//                     break;
//                 }
//             }
//         }

//         // If Content-Encoding: gzip present, try to decode (some servers return gzip)
//         $headersString = implode("\n", $http_response_header ?? []);
//         if ($html !== false && stripos($headersString, 'Content-Encoding: gzip') !== false && function_exists('gzdecode')) {
//             $decoded = @gzdecode($html);
//             if ($decoded !== false) $html = $decoded;
//         }

//         // success only for 2xx or 3xx
//         if ($html !== false && $status >= 200 && $status < 400) {
//             return $html;
//         }

//         // Save debug info to writable/logs for inspection
//         $debugPath = WRITEPATH . 'logs/websearch_fetch_debug.html';
//         $out = "<!-- FETCH DEBUG: $url -->\n";
//         $out .= "<!-- HTTP STATUS: $status -->\n\n";
//         $out .= ($html === false) ? "<!-- file_get_contents returned false -->\n" : $html;
//         file_put_contents($debugPath, $out);

//         return false;
//     };


//     // Step 1: fetch homepage
//     $homepageHtml = $fetch($url);
//     if (!$homepageHtml) {
//         return $this->response->setJSON([
//             'success' => false,
//             'message' => 'Failed to fetch homepage (see writable/logs/websearch_fetch_debug.html).',
//             'url'     => $url
//         ]);
//     }

//     // Step 2: try to find contact link in homepage anchors
//     // Step 2: Try to find contact page URL from homepage links first
// $contactCandidates = [];
// preg_match_all('/<a[^>]+href=["\']([^"\']+)["\'][^>]*>(.*?)<\/a>/is', $homepageHtml, $matches, PREG_SET_ORDER);

// foreach ($matches as $m) {
//     $href = trim($m[1]);
//     $text = strip_tags($m[2]);

//     if (
//         stripos($href, 'contact') !== false ||
//         stripos($text, 'contact') !== false
//     ) {
//         $contactCandidates[] = $href;
//     }
// }

// // Ensure "/contact/" is checked first if found
// usort($contactCandidates, function ($a, $b) {
//     if (stripos($a, 'contact/') !== false) return -1;
//     if (stripos($b, 'contact/') !== false) return 1;
//     return strlen($a) - strlen($b);
// });

// // Normalize base
// $baseUrl = rtrim($url, '/');

// // Try each candidate until one works
// $contactUrl = null;
// foreach ($contactCandidates as $candidate) {
//     $fullUrl = resolveUrl($baseUrl, $candidate);
//     $html = fetchUrl($fullUrl);

//     if ($html && stripos($html, 'DoesNotExist') === false) {
//         $contactUrl = $fullUrl;
//         $contactHtml = $html;
//         break;
//     }
// }

// // Fallback: try manual common paths
// if (!$contactUrl) {
//     $possiblePaths = ['/contact/', '/contact-us/'];
//     foreach ($possiblePaths as $path) {
//         $tryUrl = $baseUrl . $path;
//         $html = fetchUrl($tryUrl);
//         if ($html && stripos($html, 'DoesNotExist') === false) {
//             $contactUrl = $tryUrl;
//             $contactHtml = $html;
//             break;
//         }
//     }
// }

// if (!$contactUrl) {
//     return $this->response->setJSON([
//         'success' => false,
//         'message' => 'No valid contact page found.'
//     ]);
// }



// function resolveUrl(string $base, string $relative): string {
//     // Already absolute
//     if (preg_match('#^https?://#i', $relative)) {
//         return $relative;
//     }

//     $parsed = parse_url($base);
//     $scheme = $parsed['scheme'] ?? 'http';
//     $host   = $parsed['host'] ?? '';
//     $port   = isset($parsed['port']) ? ':' . $parsed['port'] : '';

//     // Root-relative path
//     if (strpos($relative, '/') === 0) {
//         $path = $relative;
//     } else {
//         // Relative path → merge with base directory
//         $dir  = isset($parsed['path']) ? rtrim(dirname($parsed['path']), '/') : '';
//         $path = $dir . '/' . $relative;
//     }

//     // Normalize "/../" and "/./"
//     $parts = [];
//     foreach (explode('/', $path) as $segment) {
//         if ($segment === '' || $segment === '.') {
//             continue;
//         }
//         if ($segment === '..') {
//             array_pop($parts);
//         } else {
//             $parts[] = $segment;
//         }
//     }

//     $normalizedPath = '/' . implode('/', $parts);

//     return $scheme . '://' . $host . $port . $normalizedPath;
// }


//     // Step 5: fetch contact page
//     $contactHtml = $fetch($contactUrl);
//     if (!$contactHtml) {
//         return $this->response->setJSON([
//             'success' => false,
//             'message' => 'Unable to fetch contact page (see writable/logs/websearch_fetch_debug.html).',
//             'url'     => $contactUrl
//         ]);
//     }

//     // Step 6: clean & extract visible text
//     $cleaned = preg_replace('#<(script|style)(.*?)>(.*?)</\1>#is', '', $contactHtml);
//     $contactText = strip_tags($cleaned);
//     $contactText = html_entity_decode($contactText, ENT_QUOTES | ENT_HTML5);
//     $contactText = preg_replace('/[ \t]+/', ' ', $contactText);
//     $contactText = preg_replace('/\s{3,}/', "\n", $contactText);
//     $contactText = trim(mb_substr($contactText, 0, 3000));
//     $scrapedText = "// Website Contact Info:\n" . $contactText . "\n\n(Source: $contactUrl)";

//     // Step 7: append to DB
//     $model = new \App\Models\ImageDataModel();
//     $record = $model->find($id2);
//     if (!$record) {
//         return $this->response->setJSON(['success' => false, 'message' => 'Record not found.']);
//     }

//     $updatedText = rtrim($record['ocr_text']) . "\n\n" . $scrapedText;
//     $model->update($id2, ['ocr_text' => $updatedText]);

//     return $this->response->setJSON(['success' => true, 'highlight_id' => $id2]);
// }
