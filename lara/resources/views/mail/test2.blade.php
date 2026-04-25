<!DOCTYPE html>
<html>

<head>
    <title>Send Mail</title>
</head>

<body>

    <h2>Send Email</h2>

    @if(session('status'))
        <p style="color:green;">{{ session('status') }}</p>
    @endif

    <form method="POST" action="{{ url('mail/send') }}">
        @csrf

        <label>Email:</label><br>
        <input type="email" name="email" required style="width:300px;"><br><br>

        <label>Subject:</label><br>
        <input type="text" name="subject" required style="width:300px;"><br><br>

        <label>Message (HTML allowed):</label><br>
        <textarea name="message" rows="8" cols="50" required></textarea><br><br>

        <button type="submit">Send Mail</button>
    </form>

</body>

</html>