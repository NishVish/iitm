<!DOCTYPE html>
<html>
<head>
    <title>Leads & Stall Details</title>
</head>
<body>
    <h1>Leads and Stall Details</h1>

    <form method="POST" action="/submit-leads">
        @csrf
        <input type="text" name="lead_name" placeholder="Lead Name"><br>
        <input type="text" name="stall_name" placeholder="Stall Name"><br>
        <textarea name="details" placeholder="Details"></textarea><br>
        <button type="submit">Submit</button>
    </form>
</body>
</html>