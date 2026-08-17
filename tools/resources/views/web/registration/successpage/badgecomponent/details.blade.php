<div class="Contact">

    <style>
        .Contact {
            height: 100px;
            width: 360px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 0 10px;
            box-sizing: border-box;
            font-family: "Playfair Display", Georgia, serif;
        }

        .contact-inner {
            width: 100%;
        }

        .name,
        .company {
            display: block;
            font-weight: 700;
            text-transform: uppercase;
            word-break: break-word;
            line-height: 1.1;
            color: #111;
        }

        .company {
            margin-top: 6px;
            opacity: 0.8;
        }
    </style>

    @php
        $name = trim($data['contactName'] ?? '');
        $company = trim($data['companyName'] ?? '');

        $len = max(strlen($name), strlen($company));

        // =========================
        // FONT CONTROL (PHP ONLY)
        // =========================
        if ($len <= 18) {
            $nameSize = 28;
            $companySize = 20;
            $shiftDown = 15;
        } elseif ($len <= 28) {
            $nameSize = 22;
            $companySize = 18;
            $shiftDown = 15;
        } elseif ($len <= 38) {
            $nameSize = 18;
            $companySize = 15;
            $shiftDown = 10;
        } elseif ($len <= 50) {
            $nameSize = 15;
            $companySize = 12;
            $shiftDown = 7;
        } else {
            $nameSize = 13;
            $companySize = 11;
            $shiftDown = 5;
        }

    @endphp

    <div class="contact-inner" style="transform: translateY({{ $shiftDown }}px);">

        <span class="name" style="font-size: {{ $nameSize }}px;">
            {{ $name }}
        </span>

        <span class="company" style="font-size: {{ $companySize }}px;">
            {{ $company }}
        </span>

    </div>

</div>