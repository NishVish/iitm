<?php
$path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$segments = explode('/', $path);

$last_segment = end($segments);
$second_segment = $segments[1] ?? '';

$events = [
    'iitm_bengaluru' => [
        'name' => 'Bengaluru',
        'date' => '23 - 25 July 2026'
    ],
    'iitm_bangalore' => [
        'name' => 'Bengaluru',
        'date' => '23 - 25 July 2026'
    ],


    'iitm_chennai' => [
        'name' => 'Chennai',
        'date' => '23 - 25 July 2026'
    ],
    'iitm_hyderabad' => [
        'name' => 'Hyderabad',
        'date' => '23 - 25 July 2026'
    ],
    'iitm_kochi' => [
        'name' => 'Kochi',
        'date' => '23 - 25 July 2026'
    ],
    'iitm_ahmedabad' => [
        'name' => 'Ahmedabad',
        'date' => '23 - 25 July 2026'
    ],
    'iitm_kolkata' => [
        'name' => 'Kolkata',
        'date' => '23 - 25 July 2026'
    ],
    'iitm_mumbai' => [
        'name' => 'Mumbai',
        'date' => '23 - 25 July 2026'
    ],
    'iitm_delhi' => [
        'name' => 'Delhi',
        'date' => '23 - 25 July 2026'
    ]
];

$segment = '';

foreach ($events as $key => $value) {
    if ($last_segment === $key || $second_segment === $key) {
        $segment = $key;
        break;
    }
}

if ($segment && isset($events[$segment])) {
    $cityname = $events[$segment]['name'];
    $date = $events[$segment]['date'];
    ?>

    <p><?= $cityname ?> | <?= $date ?></p>

<?php } ?>