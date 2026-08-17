<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exhibition Experience</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #0f0f1a;
            color: white;
            overflow-x: hidden;
        }

        /* Animated gradient background */
        body::before {
            content: "";
            position: fixed;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, #ff00cc, #3333ff, #00ffee, #ff6600);
            background-size: 400% 400%;
            animation: gradientMove 15s ease infinite;
            z-index: -1;
            filter: blur(120px);
        }

        @keyframes gradientMove {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        /* Center container */
        .container {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            text-align: center;
        }

        /* Title animation */
        .title {
            font-size: 4rem;
            letter-spacing: 3px;
            opacity: 0;
            transform: translateY(40px);
            animation: fadeUp 1.5s forwards;
        }

        .subtitle {
            margin-top: 15px;
            font-size: 1.2rem;
            opacity: 0;
            animation: fadeUp 1.5s 0.5s forwards;
        }

        /* Button */
        .btn {
            margin-top: 40px;
            padding: 15px 40px;
            border: none;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            font-size: 1rem;
            border-radius: 50px;
            cursor: pointer;
            backdrop-filter: blur(10px);
            transition: 0.4s;
        }

        .btn:hover {
            background: white;
            color: black;
            transform: scale(1.1);
        }

        /* Floating particles */
        .particle {
            position: absolute;
            width: 5px;
            height: 5px;
            background: white;
            border-radius: 50%;
            opacity: 0.7;
            animation: float 10s linear infinite;
        }

        @keyframes float {
            from {
                transform: translateY(100vh);
                opacity: 0;
            }

            to {
                transform: translateY(-10vh);
                opacity: 1;
            }
        }

        /* Fade animation */
        @keyframes fadeUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Footer text */
        .footer {
            position: absolute;
            bottom: 20px;
            font-size: 0.8rem;
            opacity: 0.7;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1 class="title">THE EXHIBITION</h1>
        <p class="subtitle">An immersive experience you don’t want to miss</p>
        <button class="btn" onclick="enterExperience()">Enter</button>
    </div>

    <div class="footer">Coming Soon • Limited Access</div>

    <script>
        // Create floating particles
        for (let i = 0; i < 40; i++) {
            let particle = document.createElement("div");
            particle.classList.add("particle");

            particle.style.left = Math.random() * 100 + "vw";
            particle.style.animationDuration = (5 + Math.random() * 10) + "s";
            particle.style.opacity = Math.random();

            document.body.appendChild(particle);
        }

        // Button interaction
        function enterExperience() {
            document.body.style.transition = "1s";
            document.body.style.opacity = "0";

            setTimeout(() => {
                alert("Welcome to the Exhibition ✨");
                document.body.style.opacity = "1";
            }, 1000);
        }
    </script>

</body>

</html>