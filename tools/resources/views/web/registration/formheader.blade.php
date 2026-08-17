<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration | {{ $contact['company_id'] ?? 'NEW_COMPANY' }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Crimson+Pro:wght@600;700&family=Public+Sans:wght@300;400;600&display=swap');

        :root {
            --iitm-maroon: #851919;
            --iitm-gold: #c5a059;
            --bg-light: #f4f4f4;
            --text-main: #2d2d2d;
            --border-gray: #dee2e6;
        }



        .registration-container {
            width: 100%;
            max-width: 900px;
            margin: auto;
            margin-top: 40px;
        }

        /* --- INSTITUTIONAL STEPPER --- */
        .stepper-header {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 40px;
        }

        .step {
            text-align: center;
            width: 130px;
        }

        .step .circle {
            width: 40px;
            height: 40px;
            background: #fff;
            border: 2px solid var(--border-gray);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
            font-weight: 700;
            font-size: 14px;
            color: #888;
            transition: 0.3s;
        }

        .step span {
            font-size: 11px;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 0.5px;
            color: #888;
        }

        .step.completed .circle {
            background: var(--iitm-maroon);
            border-color: var(--iitm-maroon);
            color: white;
        }

        .step.active .circle {
            border-color: var(--iitm-maroon);
            color: var(--iitm-maroon);
            box-shadow: 0 0 0 4px rgba(133, 25, 25, 0.1);
        }

        .step.active span {
            color: var(--iitm-maroon);
        }

        .step-line {
            flex: 0 1 80px;
            height: 2px;
            background: var(--border-gray);
            margin: 0 10px;
            transform: translateY(-15px);
        }

        .step-line.filled {
            background: var(--iitm-maroon);
        }

        /* --- ACADEMIC CARDS --- */
        .form-card {
            background: #ffffff;
            border-top: 4px solid var(--iitm-maroon);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border-radius: 4px;
            padding: 40px;
            display: none;
            margin-bottom: 30px;
        }

        .form-card.active {
            display: block;
            animation: fadeIn 0.4s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        h3 {
            font-family: 'Crimson Pro', serif;
            font-weight: 700;
            font-size: 1.6rem;
            color: var(--iitm-maroon);
            margin-bottom: 25px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }

        .section-title {
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            color: var(--iitm-gold);
            letter-spacing: 1px;
            margin: 30px 0 15px;
        }

        /* --- INPUTS --- */
        .form-group label {
            font-size: 12px;
            font-weight: 600;
            color: #555;
            margin-bottom: 6px;
            display: block;
        }

        .form-control {
            background: #fff;
            border: 1px solid var(--border-gray);
            color: var(--text-main);
            border-radius: 4px;
            padding: 10px 15px;
            margin-bottom: 15px;
        }

        .form-control:focus {
            border-color: var(--iitm-maroon);
            box-shadow: 0 0 0 3px rgba(133, 25, 25, 0.1);
        }

        .scroll-box {
            height: 180px;
            overflow-y: auto;
            background: #fcfcfc;
            border: 1px solid var(--border-gray);
            border-radius: 4px;
            padding: 15px;
        }

        .opt-label {
            display: block;
            font-size: 13px;
            color: #444;
            margin-bottom: 8px;
            cursor: pointer;
        }

        .opt-label input {
            margin-right: 10px;
            accent-color: var(--iitm-maroon);
        }

        /* --- BUTTONS --- */
        .btn-next,
        .btn-submit {
            background: var(--iitm-maroon);
            color: #fff;
            border: none;
            padding: 10px 30px;
            border-radius: 4px;
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: 0.2s;
        }

        .btn-next:hover {
            background: #6b1414;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        .btn-back {
            background: transparent;
            border: 1px solid var(--border-gray);
            color: #666;
            padding: 10px 30px;
            border-radius: 4px;
            margin-right: 10px;
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase;
        }
    </style>
</head>

<body>
    @include('web.header3')
    <div class="registration-container">

        <div class="stepper-header">
            <div class="step completed">
                <div class="circle">✓</div>
                <span>Verified</span>
            </div>
            <div class="step-line filled"></div>
            <div class="step active" id="node2">
                <div class="circle">02</div>
                <span>Personal</span>
            </div>
            <div class="step-line" id="line2"></div>
            <div class="step" id="node3">
                <div class="circle">03</div>
                <span>Company</span>
            </div>
        </div>