<!DOCTYPE html>
<html>

<head>
    <title>Users CRUD Dashboard</title>
    <style>
        body {
            font-family: Arial;
            background: #f4f4f4;
            text-align: center;
            padding: 50px;
        }

        .box {
            background: white;
            padding: 30px;
            width: 400px;
            margin: auto;
            box-shadow: 0 0 10px #ccc;
            border-radius: 10px;
        }

        a {
            display: block;
            margin: 10px 0;
            padding: 12px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 6px;
        }

        a:hover {
            background: #0056b3;
        }

        h2 {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

    <div class="box">

        <h2>👨‍💼 Users CRUD Dashboard</h2>

        <a href="users/list.php">📋 View All Users</a>
        <a href="users/create.php">➕ Add New User</a>
        <a href="users/list.php">✏️ Edit Users (from list)</a>
        <a href="users/list.php">❌ Delete Users (from list)</a>

    </div>

</body>

</html>