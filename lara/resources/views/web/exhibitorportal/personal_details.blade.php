<!DOCTYPE html>
<html>
<head>
    <title>Personal Details</title>
</head>
<body>
    <h1>Personal Details Form</h1>

    <form method="POST" action="/submit-personal">
        @csrf
        <input type="text" name="name" placeholder="Name"><br>
        <input type="email" name="email" placeholder="Email"><br>
        <input type="text" name="phone" placeholder="Phone"><br>
        <button type="submit">Submit</button>
    </form>
</body>
</html>