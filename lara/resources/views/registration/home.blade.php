<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Share Links</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background: #f5f7fb;
            padding: 50px 20px;
        }

        .container {
            max-width: 900px;
            margin: auto;
        }

        .title {
            text-align: center;
            font-size: 34px;
            margin-bottom: 35px;
            color: #1f2937;
        }

        .city {
            background: #fff;
            border-radius: 18px;
            overflow: hidden;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .08);
        }

        .city h2 {
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            color: #fff;
            padding: 18px 24px;
            font-size: 22px;
        }

        .link-card {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 18px 24px;
            border-bottom: 1px solid #edf2f7;
            transition: .25s;
        }

        .link-card:last-child {
            border-bottom: none;
        }

        .link-card:hover {
            background: #f8faff;
        }

        .name {
            font-size: 18px;
            font-weight: 600;
            color: #374151;
        }

        .actions {
            display: flex;
            gap: 10px;
        }

        .open-btn,
        .copy-btn {
            text-decoration: none;
            border: none;
            cursor: pointer;
            padding: 10px 18px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            transition: .25s;
        }

        .open-btn {
            background: #eef2ff;
            color: #4f46e5;
        }

        .open-btn:hover {
            background: #4f46e5;
            color: #fff;
        }

        .copy-btn {
            background: #10b981;
            color: #fff;
        }

        .copy-btn:hover {
            background: #059669;
        }

        .toast {
            position: fixed;
            top: 25px;
            right: 25px;
            background: #10b981;
            color: #fff;
            padding: 12px 18px;
            border-radius: 8px;
            font-weight: 600;
            opacity: 0;
            transform: translateY(-20px);
            transition: .3s;
            z-index: 999;
        }

        .toast.show {
            opacity: 1;
            transform: translateY(0);
        }

        @media(max-width:650px) {
            .link-card {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .actions {
                width: 100%;
            }

            .actions a,
            .actions button {
                flex: 1;
                text-align: center;
            }
        }
    </style>
</head>

<body>

    <div class="container">

        <h1 class="title">🔗 Share Links</h1>

        @php
            $cities = [
                'chennai' => ['sanjay', 'usha', 'dilip', 'rohit', 'indira'],
                'bangalore' => ['sanjay', 'usha', 'dilip', 'rohit', 'indira'],
            ];
        @endphp

        @foreach($cities as $city => $persons)
            <div class="city">
                <h2>📍 {{ ucfirst($city) }}</h2>

                @foreach($persons as $person)
                    <div class="link-card">
                        <div class="name">{{ ucfirst($person) }}</div>

                        <div class="actions">
                            <a class="open-btn" href="{{ url($city . '/' . $person) }}" target="_blank">
                                Open
                            </a>

                            <a class="open-btn" href="{{ url('entriesbyspecifics/' . $city . '/' . $person) }}" target="_blank">
                                Entries
                            </a>

                            <button class="copy-btn" onclick="copyLink('{{ url($city . '/' . $person) }}')">
                                Copy
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
        ```


    </div>

    <div id="toast" class="toast">✅ Link copied!</div>

    <script>
        function copyLink(url) {
            navigator.clipboard.writeText(url);

            const toast = document.getElementById('toast');
            toast.classList.add('show');

            setTimeout(() => {
                toast.classList.remove('show');
            }, 1500);
        }
    </script>

</body>

</html>