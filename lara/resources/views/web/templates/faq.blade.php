@php

    $faqPath = public_path('ai/iitm-faq-rag.json');

    $faqData = [];

    if (file_exists($faqPath)) {

        $faqData = json_decode(
            file_get_contents($faqPath),
            true
        );

    }

@endphp

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>FAQ - IITM India</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f7fb;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1000px;
            margin: auto;
            padding: 60px 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 50px;
            color: #1a237e;
        }

        .faq-item {
            background: white;
            margin-bottom: 18px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .faq-question {

            width: 100%;

            background: white;

            border: none;

            padding: 22px;

            text-align: left;

            font-size: 18px;

            font-weight: bold;

            cursor: pointer;

            position: relative;

            color: #222;
        }

        .faq-question:hover {
            background: #f3f4ff;
        }

        .faq-question::after {

            content: "+";

            position: absolute;

            right: 20px;

            top: 18px;

            font-size: 24px;

            color: #1a237e;
        }

        .faq-item.active .faq-question::after {
            content: "−";
        }

        .faq-answer {

            display: none;

            padding: 0 22px 22px;

            color: #555;

            line-height: 1.8;

            font-size: 16px;
        }

        .faq-item.active .faq-answer {
            display: block;
        }

        .empty {
            text-align: center;
            color: #888;
            margin-top: 80px;
        }
    </style>

</head>

<body>

    <div class="container">

        <h1>Frequently Asked Questions</h1>

        @if(!empty($faqData))

            @foreach($faqData as $index => $faq)

                <div class="faq-item">

                    <button class="faq-question">

                        {{ $faq['question'] ?? '' }}

                    </button>

                    <div class="faq-answer">

                        {!! nl2br(e($faq['answer'] ?? '')) !!}

                    </div>

                </div>

            @endforeach

        @else

            <div class="empty">

                FAQ data file not found
                <br><br>

                public/ai/iitm-faq-rag.json

            </div>

        @endif

    </div>

    <script>

        document
            .querySelectorAll(".faq-question")
            .forEach(button => {

                button.addEventListener("click", () => {

                    const item = button.parentElement;

                    item.classList.toggle("active");

                });

            });

    </script>

</body>

</html>