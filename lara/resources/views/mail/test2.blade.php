<!DOCTYPE html>
<html>

<head>
    <title>Send Mail</title>
</head>

<body>

    <h2>Send Email</h2>

    <!-- STATUS -->
    @if(session('status'))
        <p style="color: green;">
            <strong>Status:</strong> {{ session('status') }}
        </p>
    @endif

    <!-- EMAIL -->
    @if(session('email'))
        <p>
            <strong>Email:</strong> {{ session('email') }}
        </p>
    @endif

    <!-- SUBJECT -->
    @if(session('subject'))
        <p>
            <strong>Subject:</strong> {{ session('subject') }}
        </p>
    @endif

    <!-- MESSAGE -->
    @if(session('message'))
        <p>
            <strong>Message:</strong><br>
            {!! session('message') !!}
        </p>
    @endif

    <!-- HEADERS -->
    @if(session('headers'))
        <p>
            <strong>Headers:</strong><br>
        <pre>{{ session('headers') }}</pre>
        </p>
    @endif

    <!-- SENT FLAG -->
    @if(session('sent') !== null)
        <p>
            <strong>Sent Flag:</strong>
            {{ session('sent') ? 'true' : 'false' }}
        </p>
    @endif

    <hr>

    <label>Email:</label><br>
    <input type="email" id="email" required style="width:300px;" value="nishwakarma3@gmail.com"><br><br>

    <label>Data:</label><br>
    <textarea id="data" rows="6" cols="50"></textarea><br><br>

    <a href="#" onclick="sendMail()">Send Mail</a>

    <script>
        function sendMail() {
            let email = document.getElementById('email').value;
            let data = document.getElementById('data').value;

            if (!data) {
                data = 'xyz';
            }

            let url = "{{ url('mail/sendtest') }}/"
                + encodeURIComponent(email) + "/"
                + encodeURIComponent(data);

            window.location.href = url;
        }
    </script>

</body>

</html>