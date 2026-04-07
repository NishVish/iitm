<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IITM Exhibition Platform</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #f8fafc;
            overflow-x: hidden;
        }

        /* ================= HERO ================= */
        .hero {
            min-height: 90vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            text-align: center;
            overflow: hidden;
        }

        .hero h1 {
            font-size: 3rem;
            font-weight: 800;
            background: linear-gradient(90deg, #6366f1, #a855f7);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero p {
            color: #64748b;
            max-width: 600px;
            margin: auto;
        }

        /* Floating blobs */
        .blob {
            position: absolute;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            filter: blur(80px);
            z-index: -1;
            animation: float 15s infinite alternate;
        }

        .blob1 {
            background: #6366f133;
            top: -100px;
            left: -100px;
        }

        .blob2 {
            background: #10b98133;
            bottom: -100px;
            right: -100px;
        }

        @keyframes float {
            0% {
                transform: translate(0, 0);
            }

            100% {
                transform: translate(60px, 80px);
            }
        }

        /* ================= ROLE BUTTONS ================= */
        .role-card {
            border-radius: 20px;
            padding: 25px;
            background: white;
            border: 1px solid #e2e8f0;
            transition: 0.4s;
            cursor: pointer;
            width: 260px;
        }

        .role-card:hover {
            transform: translateY(-10px) scale(1.03);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        /* ================= INFO BOX ================= */
        .info-box {
            display: none;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            margin-top: 30px;
        }

        /* ================= CITY ================= */
        .city-card {
            padding: 20px;
            border-radius: 15px;
            background: white;
            transition: 0.3s;
            cursor: pointer;
            border: 1px solid #eee;
        }

        .city-card:hover {
            background: #6366f1;
            color: white;
            transform: translateX(10px);
        }

        /* Mouse glow */
        .cursor-glow {
            position: fixed;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.2), transparent);
            pointer-events: none;
            border-radius: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
        }
    </style>
</head>

<body>

    <div class="cursor-glow" id="glow"></div>

    <div class="container">

        {{-- HERO --}}
        <div class="hero">
            <div class="blob blob1"></div>
            <div class="blob blob2"></div>

            <div>
                <h1>India’s Exhibition Platform</h1>
                <p class="mt-3">
                    Join IITM exhibitions across India’s major cities.
                    Connect as an exhibitor or explore as a visitor.
                </p>

                <div class="d-flex justify-content-center gap-4 mt-5 flex-wrap">
                    <div class="role-card" onclick="selectRole('exhibitor')">
                        <h5>🚀 Exhibitor</h5>
                        <small>Showcase your brand & grow business</small>
                    </div>

                    <a href="{{ url('/events') }}" class="text-decoration-none">
                        <div class="role-card">
                            <div class="card-icon">🎫</div>
                            <h5>Visitor</h5>
                            <small>Explore opportunities & network</small>
                        </div>
                    </a>
                </div>

                {{-- Dynamic Info --}}
                <div class="info-box" id="infoBox">
                    <h4 id="roleTitle"></h4>
                    <p id="roleDesc"></p>
                    <a href="{{ url('/events') }}" class="btn btn-dark">Explore Events</a>
                </div>
            </div>
        </div>

        {{-- CITY SECTION --}}
        <div class="mt-5">
            <h3 class="mb-4">Explore Cities</h3>

            @php
                $cities = ['Mumbai', 'Delhi', 'Bengaluru', 'Chennai', 'Kolkata', 'Hyderabad', 'Pune', 'Ahmedabad', 'Jaipur'];
            @endphp

            <div class="row g-3">
                @foreach($cities as $city)
                    <div class="col-md-4">
                        <div class="city-card" onclick="goToCity('{{ strtolower($city) }}')">
                            {{ $city }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

    <script>
        // ROLE SELECTION
        function selectRole(role) {
            const box = document.getElementById('infoBox');
            const title = document.getElementById('roleTitle');
            const desc = document.getElementById('roleDesc');

            box.style.display = 'block';

            if (role === 'exhibitor') {
                title.innerHTML = "Become an Exhibitor";
                desc.innerText = "Showcase your brand to thousands of visitors and generate business leads.";
            } else {
                title.innerHTML = "Join as Visitor";
                desc.innerText = "Discover opportunities, connect with exhibitors and explore new markets.";
            }

            box.scrollIntoView({ behavior: 'smooth' });
        }

        // CITY NAVIGATION
        function goToCity(city) {
            window.location.href = `/${city}/events`;
        }

        // MOUSE GLOW EFFECT
        document.addEventListener('mousemove', e => {
            const glow = document.getElementById('glow');
            glow.style.left = e.clientX + 'px';
            glow.style.top = e.clientY + 'px';
        });
    </script>

</body>

</html>