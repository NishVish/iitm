<!DOCTYPE html>
<html>

<head>
    <title>Mail Test Dashboard</title>
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
    </style>
</head>

<body>

    <h2>Mail Test Dashboard</h2>

    @if(session('success'))
    <p class="success">{{ session('success') }}</p>
    @endif

    <form method="POST" action="/mail-dashboard/send">
        @csrf

        <label>Send To:</label>
        <input type="email" name="email" placeholder="Enter email" required>

        <label>Email Body (HTML allowed):</label>
        <textarea name="body" placeholder="<h1>Hello</h1><p>This is test mail</p>" required></textarea>

        <button type="submit">Send Mail</button>
    </form>

</body>

</html>