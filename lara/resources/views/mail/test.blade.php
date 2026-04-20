<!DOCTYPE html>
<html>

<head>
    <title>Mail Debug Dashboard</title>
    <style>
        body {
            font-family: Arial;
            padding: 20px;
        }

        textarea {
            width: 100%;
            height: 200px;
        }

        input,
        button {
            padding: 10px;
            margin-top: 10px;
            width: 100%;
        }

        .success {
            color: green;
        }

        .error {
            color: red;
        }

        .debug {
            background: #f4f4f4;
            padding: 10px;
            margin-top: 20px;
        }
    </style>
</head>

<body>

    <h2>📧 Mail Test Debug Dashboard</h2>

    {{-- ✅ Success --}}
    @if(session('success'))
        <p class="success">{{ session('success') }}</p>
    @endif

    {{-- ❌ Error --}}
    @if(session('error'))
        <p class="error">{{ session('error') }}</p>
    @endif

    {{-- 🔍 Validation Errors --}}
    @if($errors->any())
        <div class="error">
            <ul>
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <h3>⚙️ SMTP Configuration</h3>

    <div style="background:#f4f4f4; padding:15px; margin-bottom:20px;">
        <strong>Mailer:</strong> {{ $smtp['mailer'] }} <br>
        <strong>Host:</strong> {{ $smtp['host'] }} <br>
        <strong>Port:</strong> {{ $smtp['port'] }} <br>
        <strong>Encryption:</strong> {{ $smtp['encryption'] }} <br>
        <strong>Username:</strong> {{ $smtp['username'] }} <br>
        <strong>From Address:</strong> {{ $smtp['from_address'] }} <br>
        <strong>From Name:</strong> {{ $smtp['from_name'] }} <br>
    </div>
    <form method="POST" action="{{ url('/mail-test/send') }}">
        @csrf

        <label>Email:</label>
        <input type="email" name="email" value="{{ old('email') }}" required>

        <label>Email Body (HTML):</label>
        <textarea name="body" required>{{ old('body') }}</textarea>

        <button type="submit">Send Mail</button>
    </form>

    {{-- 🔍 Debug Output --}}
    @if(session('debug'))
        <div class="debug">
            <h4>Debug Data Sent:</h4>
            <pre>{{ print_r(session('debug'), true) }}</pre>
        </div>
    @endif

    {{-- 🔍 Live HTML Preview --}}
    <h3>Live Preview:</h3>
    <div style="border:1px solid #ccc; padding:10px;">
        {!! old('body') !!}
    </div>

</body>

</html>