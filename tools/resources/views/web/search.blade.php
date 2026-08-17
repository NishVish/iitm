<!DOCTYPE html>
<html>
<head>
    <title>Search</title>
</head>
<body>

<h2>Search: {{ $nameofthecompany }}</h2>

@php
    $query = urlencode($nameofthecompany);
    $url = "https://html.duckduckgo.com/html/?q={$query}";

    $results = [];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0");

    $html = curl_exec($ch);
    curl_close($ch);

    if ($html) {
        libxml_use_internal_errors(true);

        $dom = new DOMDocument();
        $dom->loadHTML($html);

        $xpath = new DOMXPath($dom);

        $links = $xpath->query('//a[contains(@class,"result__a")]');

        foreach ($links as $link) {
            $results[] = [
                'title' => $link->nodeValue,
                'url' => $link->getAttribute('href')
            ];
        }
    }
@endphp

<h3>Results:</h3>

@if(count($results))
    <ul>
        @foreach($results as $r)
            <li>
                <a href="{{ $r['url'] }}" target="_blank">
                    {{ $r['title'] }}
                </a>
            </li>
        @endforeach
    </ul>
@else
    <p>No results found.</p>
@endif

</body>
</html>