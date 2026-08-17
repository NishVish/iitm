<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Floating Bottom Nav</title>

    <style>
        body {
            margin: 0;
            font-family: sans-serif;
            height: 200vh;
            /* demo scroll */
            background: #f5f5f5;
        }

        .bottom-nav {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            width: 90%;
            max-width: 420px;

            display: flex;
            justify-content: space-around;
            align-items: center;

            padding: 12px 10px;
            border-radius: 30px;

            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);

            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .bottom-nav a {
            text-decoration: none;
            color: #555;
            font-size: 13px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
        }

        .bottom-nav a.active {
            color: #007bff;
            font-weight: 600;
        }

        .bottom-nav a span {
            font-size: 20px;
        }
    </style>
</head>

<body>

    <div class="bottom-nav">
        <a href="#" class="active"><span>🏠</span>Home</a>
        <a href="#"><span>🔍</span>Search</a>
        <a href="#"><span>➕</span>Add</a>
        <a href="#"><span>❤️</span>Likes</a>
        <a href="#"><span>👤</span>Profile</a>
    </div>

</body>

</html>