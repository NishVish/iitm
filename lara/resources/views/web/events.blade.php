<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Immersive Events</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #0b0f1a;
            color: white;
            overflow: hidden;
        }

        /* ================= LOADER ================= */
        #loader {
            position: fixed;
            inset: 0;
            background: radial-gradient(circle at center, #111827, #05070d);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            flex-direction: column;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
            width: 60%;
            max-width: 400px;
        }

        .city {
            font-size: 14px;
            padding: 10px;
            text-align: center;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.05);
            color: #9ca3af;
            transition: 0.2s;
            letter-spacing: 1px;
        }

        .city.active {
            color: white;
            background: rgba(99, 102, 241, 0.8);
            box-shadow: 0 0 20px rgba(99, 102, 241, 0.8);
            transform: scale(1.1);
        }

        .loader-text {
            margin-top: 30px;
            opacity: 0.7;
            font-size: 14px;
            letter-spacing: 3px;
        }

        /* TOP BAR */
        .top-bar {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 10;
            display: flex;
            justify-content: space-between;
            padding: 15px 20px;
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(10px);
        }

        .top-btn {
            background: white;
            color: black;
            border: none;
            padding: 8px 14px;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
        }

        /* HERO */
        .hero {
            height: 100vh;
            display: flex;
            align-items: flex-end;
            justify-content: center;
            position: relative;
            transition: opacity 0.5s ease;
        }

        .hero img {
            position: absolute;
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: brightness(0.5);
        }

        .details {
            position: relative;
            z-index: 2;
            width: 100%;
            padding: 40px;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.9), transparent);
        }

        .title {
            font-size: 36px;
            font-weight: 800;
        }

        .meta {
            opacity: 0.8;
            margin-top: 10px;
        }

        .nav-indicator {
            text-align: center;
            padding: 10px;
            opacity: 0.7;
        }
    </style>

</head>

<body>

    <!-- ================= LOADER ================= -->
    <div id="loader">
        <div class="grid" id="cityGrid"></div>
        <div class="loader-text">INITIALIZING EVENTS...</div>
    </div>

    <!-- TOP NAV -->
    <div class="top-bar">
        <button class="top-btn" id="prevBtn">← Prev</button>
        <button class="top-btn" id="nextBtn">Next →</button>
    </div>

    <!-- HERO -->
    <div class="hero" id="hero" style="opacity:0;">
        <img id="eventImage" src="" />
        <div class="details">
            <div class="title" id="eventName">Loading...</div>
            <div class="meta">
                <div id="eventVenue"></div>
                <div id="eventDate"></div>
            </div>
        </div>
    </div>

    <div class="nav-indicator">
        Scroll to change event ⬇
    </div>

    <script>

        let events = [];
        let index = 0;

        const cities = [
            "Mumbai", "Delhi", "Bengaluru", "Chennai", "Kolkata", "Hyderabad", "Pune", "Ahmedabad", "Jaipur",
            "Surat", "Lucknow", "Kanpur", "Nagpur", "Indore", "Bhopal", "Patna", "Ludhiana", "Agra",
            "Nashik", "Vadodara", "Coimbatore", "Kochi", "Mysuru", "Goa", "Varanasi", "Ranchi", "Noida"
        ];

        // ================= LOADER ANIMATION =================
        const grid = document.getElementById("cityGrid");

        cities.forEach(c => {
            const div = document.createElement("div");
            div.className = "city";
            div.innerText = c;
            grid.appendChild(div);
        });

        let flashIndex = 0;
        let flashInterval = setInterval(() => {
            document.querySelectorAll(".city").forEach(c => c.classList.remove("active"));

            let random = Math.floor(Math.random() * cities.length);
            document.querySelectorAll(".city")[random].classList.add("active");

            flashIndex++;
        }, 120);

        // STOP LOADER AFTER 3 SECONDS
        setTimeout(() => {
            clearInterval(flashInterval);
            document.getElementById("loader").style.opacity = "0";

            setTimeout(() => {
                document.getElementById("loader").style.display = "none";
                document.getElementById("hero").style.opacity = "1";
            }, 600);

        }, 3000);

        // ================= EVENTS =================
        const hero = document.getElementById("hero");
        const eventImage = document.getElementById("eventImage");
        const eventName = document.getElementById("eventName");
        const eventVenue = document.getElementById("eventVenue");
        const eventDate = document.getElementById("eventDate");

        fetch("{{ url('api/events') }}")
            .then(res => res.json())
            .then(data => {
                events = data;
                if (events.length) update();
            });

        function update() {
            const ev = events[index];
            if (!ev) return;

            eventImage.src = ev.image || "https://via.placeholder.com/1200x800";
            eventName.innerText = ev.name;
            eventVenue.innerText = ev.venue_details || "TBA";

            eventDate.innerText =
                new Date(ev.start_date).toDateString() +
                " - " +
                new Date(ev.end_date).toDateString();

            hero.style.opacity = 0;
            setTimeout(() => hero.style.opacity = 1, 200);
        }

        function next() {
            index = (index + 1) % events.length;
            update();
        }

        function prev() {
            index = (index - 1 + events.length) % events.length;
            update();
        }

        document.getElementById("nextBtn").onclick = next;
        document.getElementById("prevBtn").onclick = prev;

        // scroll
        let lock = false;
        window.addEventListener("wheel", (e) => {
            if (lock) return;
            lock = true;

            if (e.deltaY > 0) next();
            else prev();

            setTimeout(() => lock = false, 600);
        });

    </script>

</body>

</html>