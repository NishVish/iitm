@php
    $names = ['sanjay', 'usha', 'dilip', 'rohit', 'indira', 'abhinav', 'tejaswini', 'hari'];

    $cities = [
        'chennai' => $names,
        'bangalore' => $names,
        // 'kochi' => $names,
        // 'hyderabad' => $names,
    ];

    /*
        RAW DATA FORMAT:
        [
            { "city":"bangalore", "data": { "sanjay": 50, "usha": 2 } },
            { "city":"chennai", "data": { "sanjay": 12, "dilip": 4 } }
        ]
    */

    $grouped = collect($data)->mapWithKeys(function ($row) {

        $city = strtolower(trim($row['city'] ?? $row->city ?? ''));

        $dataArr = collect($row['data'] ?? [])
            ->mapWithKeys(function ($value, $key) {
                return [strtolower(trim($key)) => (int) $value];
            });

        return [$city => $dataArr];
    });
@endphp


@foreach($cities as $city => $persons)

    @php
        $cityCounts = $grouped[$city] ?? collect();
    @endphp

    <div class="city-card">
        <h2>📍 {{ ucfirst($city) }}</h2>

        <table class="cool-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Count</th>
                    <th>Open Form</th>
                    <th>Entries</th>
                    <th>Copy Form Link</th>
                </tr>
            </thead>

            <tbody>
                @foreach($persons as $person)

                    @php
                        $key = strtolower(trim($person));
                        $count = $cityCounts[$key] ?? 0;

                        $openUrl = url($city . '/' . $person);
                        $entryUrl = url('entriesbyspecifics/' . $city . '/' . $person);
                    @endphp

                    <tr>
                        <td>{{ ucfirst($person) }}</td>

                        <td>
                            <span class="badge">{{ $count }}</span>
                        </td>
                        <td>
                            <a href="{{ $openUrl }}" target="_blank"
                                style="display:inline-block;padding:6px 10px;background:#2563eb;color:#fff;border-radius:6px;text-decoration:none;font-size:12px;font-weight:600;">
                                Open
                            </a>
                        </td>

                        <td>
                            <a href="{{ $entryUrl }}" target="_blank"
                                style="display:inline-block;padding:6px 10px;background:#0ea5e9;color:#fff;border-radius:6px;text-decoration:none;font-size:12px;font-weight:600;">
                                Entries
                            </a>
                        </td>

                        <td>
                            <button onclick="copyLink('{{ $openUrl }}')"
                                style="padding:6px 10px;background:#16a34a;color:#fff;border:none;border-radius:6px;font-size:12px;font-weight:600;cursor:pointer;">
                                Copy
                            </button>
                        </td>
                    </tr>

                @endforeach
            </tbody>
        </table>
    </div>

@endforeach


<div id="toast" class="toast">Link copied!</div>

<script>
    function copyLink(url) {
        navigator.clipboard.writeText(url);

        const toast = document.getElementById('toast');
        toast.classList.add('show');

        setTimeout(() => {
            toast.classList.remove('show');
        }, 1200);
    }
</script>
<style>
    body {
        background: #f5f6f8;
        font-family: system-ui;
        color: #111827;
        margin: 0;
        padding: 0;
    }

    .title {
        text-align: center;
        margin: 20px 10px 10px;
        font-size: 22px;
    }

    .subtitle {
        text-align: center;
        color: #6b7280;
        margin: 0 10px 20px;
        font-size: 14px;
    }

    .city-card {
        width: 95%;
        margin: 15px auto;
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 12px;
        overflow-x: auto;
    }

    .cool-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 600px;
        /* allows horizontal scroll on mobile */
    }

    .cool-table th {
        background: #f3f4f6;
        padding: 10px;
        text-align: left;
        font-size: 13px;
        white-space: nowrap;
    }

    .cool-table td {
        padding: 10px;
        border-bottom: 1px solid #e5e7eb;
        font-size: 13px;
        white-space: nowrap;
    }

    .cool-table tr:hover {
        background: #f9fafb;
    }

    .badge {
        background: #e5e7eb;
        padding: 3px 8px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
    }

    .toast {
        position: fixed;
        bottom: 15px;
        right: 15px;
        left: 15px;
        background: #111827;
        color: #fff;
        padding: 12px;
        border-radius: 8px;
        opacity: 0;
        transition: 0.3s;
        text-align: center;
        font-size: 14px;
    }

    .toast.show {
        opacity: 1;
    }

    /* MOBILE IMPROVEMENTS */
    @media (max-width: 768px) {

        .title {
            font-size: 18px;
        }

        .subtitle {
            font-size: 12px;
        }

        .city-card {
            width: 98%;
            padding: 10px;
        }

        .cool-table {
            min-width: 500px;
        }

        .cool-table th,
        .cool-table td {
            padding: 8px;
            font-size: 12px;
        }
    }

    /* VERY SMALL SCREENS */
    @media (max-width: 480px) {
        .cool-table {
            min-width: 450px;
        }
    }
</style>

@include('registration.search')