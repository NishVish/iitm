<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration | {{ $company['company_name'] }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Syncopate:wght@400;700&family=Inter:wght@300;400;600;900&display=swap');

        :root {
            --primary: #00f5ff;
            --bg-deep: #0a0a0a;
            --glass: rgba(255, 255, 255, 0.05);
            --border: rgba(255, 255, 255, 0.1);
            --success: #4caf50;
        }

        body {
            background-color: var(--bg-deep);
            color: #fff;
            font-family: 'Inter', sans-serif;
            padding: 40px 20px;
        }

        .registration-container {
            width: 100%;
            max-width: 900px;
            margin: auto;
            margin-top: 80px;

        }

        /* --- STEPPER --- */
        .stepper-header {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 50px;
        }

        .step {
            text-align: center;
            width: 120px;
        }

        .step .circle {
            width: 45px;
            height: 45px;
            background: #1a1a1a;
            border: 2px solid #333;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
            font-family: 'Syncopate';
            font-size: 14px;
            transition: 0.4s;
        }

        .step span {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #555;
            font-family: 'Syncopate';
        }

        .step.completed .circle {
            background: var(--success);
            border-color: var(--success);
            color: white;
        }

        .step.active .circle {
            border-color: var(--primary);
            color: var(--primary);
            box-shadow: 0 0 20px rgba(0, 245, 255, 0.2);
        }

        .step.active span {
            color: white;
        }

        .step-line {
            flex: 0 1 80px;
            height: 2px;
            background: #333;
            margin: 0 10px;
            transform: translateY(-15px);
        }

        .step-line.filled {
            background: var(--success);
        }

        /* --- CARDS --- */
        .form-card {
            background: var(--glass);
            backdrop-filter: blur(15px);
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 40px;
            display: none;
            margin-bottom: 30px;
        }

        .form-card.active {
            display: block;
            animation: slideUp 0.5s ease forwards;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        h3 {
            font-family: 'Syncopate';
            font-weight: 700;
            font-size: 1.3rem;
            color: var(--primary);
            margin-bottom: 25px;
        }

        .section-title {
            font-size: 11px;
            text-transform: uppercase;
            color: var(--primary);
            letter-spacing: 2px;
            margin: 30px 0 15px;
            border-bottom: 1px solid #333;
            padding-bottom: 5px;
        }

        /* --- INPUTS --- */
        .form-group label {
            font-size: 11px;
            text-transform: uppercase;
            color: #888;
            margin-bottom: 8px;
            display: block;
        }

        .form-control {
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid #333;
            color: #fff;
            border-radius: 10px;
            padding: 10px 15px;
            margin-bottom: 15px;
        }

        .form-control:focus {
            background: rgba(0, 0, 0, 0.5);
            border-color: var(--primary);
            box-shadow: none;
            color: #fff;
        }

        .scroll-box {
            height: 180px;
            overflow-y: auto;
            background: rgba(0, 0, 0, 0.2);
            border: 1px solid #333;
            border-radius: 10px;
            padding: 15px;
        }

        .opt-label {
            display: block;
            font-size: 13px;
            color: #bbb;
            margin-bottom: 8px;
            cursor: pointer;
        }

        .opt-label input {
            margin-right: 10px;
            accent-color: var(--primary);
        }

        .btn-next,
        .btn-submit {
            background: #fff;
            color: #000;
            border: none;
            padding: 12px 35px;
            border-radius: 50px;
            font-family: 'Syncopate';
            font-size: 11px;
            font-weight: 700;
        }

        .btn-back {
            background: transparent;
            border: 1px solid #333;
            color: #777;
            padding: 12px 35px;
            border-radius: 50px;
            margin-right: 10px;
            font-family: 'Syncopate';
            font-size: 11px;
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
        <form action="{{ route('registration.submit') }}" method="POST" novalidate>
            @csrf
            <input type="hidden" name="contact_id" value="{{ $contact['contact_id'] }}">
            <input type="hidden" name="company_id" value="{{ $contact['company_id'] }}">
            @include('web.registration.choosecity')


            @include('web.registration.personalfields')
            <div class="form-card" id="step3">

                <!-- <pre>{{ print_r($company) }}</pre> -->
                @include('web.registration.companydetails')

                <div class="d-flex justify-content-end mt-5">
                    <button type="button" class="btn-back" onclick="goToStep(2)">← Back</button>
                    <button type="submit" class="btn-submit">Submit Registration ✓</button>
                </div>
            </div>

        </form>
    </div>

    <script>
        function goToStep(num) {
            document.querySelectorAll('.form-card').forEach(c => c.classList.remove('active'));
            document.getElementById('step' + num).classList.add('active');

            if (num === 3) {
                document.getElementById('node2').classList.replace('active', 'completed');
                document.getElementById('node2').querySelector('.circle').innerText = '✓';
                document.getElementById('line2').classList.add('filled');
                document.getElementById('node3').classList.add('active');
            } else {
                document.getElementById('node2').classList.replace('completed', 'active');
                document.getElementById('node2').querySelector('.circle').innerText = '02';
                document.getElementById('line2').classList.remove('filled');
                document.getElementById('node3').classList.remove('active');
            }
            window.scrollTo(0, 0);
        }
    </script>
</body>

</html>