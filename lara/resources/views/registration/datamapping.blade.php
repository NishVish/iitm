@php
    $names = ['sanjay', 'usha', 'dilip', 'rohit', 'indira', 'Abhinav', 'Tejaswini', 'Hari'];

    $cities = [
        'chennai' => $names,
        'bangalore' => $names,
    ];
    $mapped = collect($names)->map(function ($name, $index) use ($data) {
        return [
            'name' => $name,
            'count' => $data[$index]->total ?? 0,
        ];
    });

    $names = ['sanjay', 'usha', 'dilip', 'rohit', 'indira', 'Abhinav', 'Tejaswini', 'Hari'];

    $counts = collect($data)
        ->mapWithKeys(fn($item) => [strtolower($item->state) => $item->total]);


    $counts = collect($data)
        ->mapWithKeys(fn($item) => [strtolower($item->state) => $item->total]);
@endphp

<!-- @foreach($names as $name)
            <p>{{ $name }} - {{ $counts[strtolower($name)] ?? 0 }}</p>
        @endforeach -->