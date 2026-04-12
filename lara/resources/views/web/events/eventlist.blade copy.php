<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Immersive Events</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        /* SCOPED PAGE */
        #eventsPage {
            font-family: 'Inter', sans-serif;
            background: #0b0f1a;
            color: white;
            overflow: hidden;
            position: relative;
            height: 100vh;
        }

        /* TOP BAR */
        #eventsPage .top-bar {
            position: absolute;
            top: 0;
            width: 100%;
            z-index: 10;
            display: flex;
            justify-content: space-between;
            padding: 15px 20px;
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(10px);
        }

        #eventsPage .top-btn {
            background: white;
            color: black;
            border: none;
            padding: 8px 14px;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
        }

        /* HERO */
        #eventsPage .hero {
            height: 100%;
            display: flex;
            align-items: flex-end;
            justify-content: center;
            position: relative;
            transition: opacity 0.5s ease;
        }

        #eventsPage .hero img {
            position: absolute;
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: brightness(0.5);
        }

        #eventsPage .details {
            position: relative;
            z-index: 2;
            width: 100%;
            padding: 40px;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.9), transparent);
        }

        #eventsPage .title {
            font-size: 36px;
            font-weight: 800;
        }

        #eventsPage .meta {
            opacity: 0.8;
            margin-top: 10px;
        }

        #eventsPage .nav-indicator {
            text-align: center;
            padding: 10px;
            opacity: 0.7;
            position: absolute;
            bottom: 0;
            width: 100%;
        }
    </style>

</head>

<body>

    <!-- WRAPPER -->
    <div id="eventsPage">

        <!-- TOP NAV -->
        <div class="top-bar">
            <button class="top-btn" id="prevBtn">← Prev</button>
            <button class="top-btn" id="nextBtn">Next →</button>
        </div>


        <!-- HERO -->
        <div class="hero" id="hero">
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

    </div>

    <script>
        let events = [];
        let index = 0;

        const hero = document.getElementById("hero");
        const eventImage = document.getElementById("eventImage");
        const eventName = document.getElementById("eventName");
        const eventVenue = document.getElementById("eventVenue");
        const eventDate = document.getElementById("eventDate");

        // FETCH EVENTS
        fetch("{{ url('api/events') }}")
            .then(res => res.json())
            .then(data => {
                events = data;
                if (events.length) update();
            })
            .catch(() => {
                eventName.innerText = "Failed to load events";
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

        // SCROLL NAVIGATION (scoped safer)
        let lock = false;
        document.getElementById("eventsPage").addEventListener("wheel", (e) => {
            if (lock) return;
            lock = true;

            if (e.deltaY > 0) next();
            else prev();

            setTimeout(() => lock = false, 600);
        });
    </script>

</body>

</html>