<!DOCTYPE html>
<html>

<head>
    <title>Send Mail</title>
</head>

<body>

    <h2>Send Email</h2>

    @if(session('status'))
        <p style="color: green;">
            {{ session('status') }}
        </p>
    @endif

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