<div id="main" class="split-layout">
    <style>
        :root {
            --accent: #00f5ff;
            --bg-dark: #0f172a;
            --bg-blue: #1e3a8a;
        }

        .split-layout {
            display: flex;
            width: 100%;
            height: 80vh;
            font-family: system-ui, sans-serif;
            background: var(--bg-dark);
            overflow: hidden;
        }

        /* Left Panel */
        .left {
            width: 30%;
            padding: 20px;
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            overflow-y: auto;
        }

        #btnRow {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .city-btn {
            padding: 12px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(255, 255, 255, 0.03);
            color: #aaa;
            cursor: pointer;
            text-align: left;
            transition: 0.3s;
        }

        .city-btn.active {
            border-color: var(--accent);
            color: #fff;
            background: rgba(0, 245, 255, 0.1);
        }

        /* Right Panel */
        .right {
            width: 70%;
            display: flex;
            flex-direction: column;
            color: white;
        }

        .hero {
            flex: 7;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 40px;
            background: linear-gradient(135deg, var(--bg-dark), var(--bg-blue));
            overflow: hidden;
        }

        .hero-text h1 {
            font-size: 42px;
            margin: 0;
        }

        #eventImage {
            width: 350px;
            height: 250px;
            object-fit: cover;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            transition: 0.3s;
        }

        /* Chips */
        .chips {
            position: absolute;
            bottom: 20px;
            display: flex;
            gap: 15px;
            width: calc(100% - 80px);
        }

        .chip {
            background: rgba(255, 255, 255, 0.1);
            padding: 8px 15px;
            border-radius: 8px;
            font-size: 13px;
            backdrop-filter: blur(5px);
        }

        .info {
            flex: 3;
            background: linear-gradient(135deg, #0ea5e9, #1e3a8a);
            display: flex;
            align-items: center;
            justify-content: space-around;
            padding: 20px;
        }

        .primary-btn {
            padding: 12px 24px;
            background: white;
            color: var(--bg-blue);
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
        }

        @media (max-width: 900px) {
            .split-layout {
                flex-direction: column;
                height: auto;
            }

            .left,
            .right {
                width: 100%;
            }

            .left {
                height: 70px;
                padding: 10px;
            }

            #btnRow {
                flex-direction: row;
                overflow-x: auto;
            }

            .hero {
                flex-direction: column;
                text-align: center;
                gap: 20px;
            }

            .chips {
                position: static;
                flex-direction: column;
                align-items: center;
                width: 100%;
                margin-top: 20px;
            }
        }
    </style>

    <div class="left">
        <div id="btnRow"></div>
    </div>

    <div class="right">
        <div class="hero" id="hero-content">
            <div class="hero-text">
                <h1 id="eventName">Loading...</h1>
                <p id="eventVenue"></p>
                <p id="eventAccess"></p>
            </div>
            <img id="eventImage" src="" alt="Event">
            <div class="chips">
                <div id="eventDate" class="chip">Date</div>
                <div id="eventVenueDetails" class="chip">Venue Details</div>
                <div id="eventAccessInfo" class="chip">Access Info</div>
            </div>
        </div>
        <div class="info">
            <button class="primary-btn" onclick="toggleModal()">Register Interest</button>
            <p>IITM: Connecting the Travel Industry</p>
        </div>
    </div>
</div>

<script>
    (function () {
        let events = [];
        let index = 0;

        async function fetchEvents() {
            try {
                const res = await fetch("{{ url('api/events') }}");
                events = await res.json();
                if (events.length) {

                    console.log("Current Events Data:", events); // <--- Add this line here                    renderButtons();
                    updateDisplay();
                }
            } catch (err) {
                document.getElementById("eventName").innerText = "Connection Error";
            }
        }

        function renderButtons() {
            const btnRow = document.getElementById("btnRow");
            btnRow.innerHTML = events.map((ev, i) =>
                `<button class="city-btn" onclick="setEvent(${i})">${ev.name.toUpperCase()}</button>`
            ).join('');
            highlightButton();
        }

        window.setEvent = (i) => {
            index = i;
            updateDisplay();
        };

        function updateDisplay() {
            const ev = events[index];
            const hero = document.getElementById("hero-content");

            // Fade effect
            hero.style.opacity = 0.3;

            const modalInput = document.getElementById("modal_event_id");
            if (modalInput) {
                modalInput.value = ev.id || ev.event_id || "";
            }

            setTimeout(() => {

                document.getElementById("view_event_name").innerText = ev.name || "N/A";
                document.getElementById("view_year").innerText = ev.year || "2026";
                document.getElementById("view_venue").innerText = ev.venue_details || "TBA";
                document.getElementById("view_date").innerText = ev.start_date ? new Date(ev.start_date).toDateString() : "TBA";
                document.getElementById("view_coordinator").innerText = ev.coordinator || "N/A";

                // 2. Update Hidden Inputs (For Form Submission)
                document.getElementById("modal_event_id").value = ev.event_id ?? ev.id ?? "";
                document.getElementById("modal_event_name").value = ev.name ?? "";
                document.getElementById("modal_year").value = ev.year ?? "";
                document.getElementById("modal_venue_details").value = ev.venue_details ?? "";
                document.getElementById("modal_coordinator").value = ev.coordinator ?? "";
                document.getElementById("modal_start_date").value = ev.start_date ?? "";


                document.getElementById("eventName").innerText = ev.name;
                document.getElementById("eventVenue").innerText = ev.venue_details || "TBA";
                document.getElementById("eventImage").src = ev.image || 'https://via.placeholder.com/350x250';
                document.getElementById("eventDate").innerText = `${new Date(ev.start_date).toDateString()}`;
                // Sync all fields to the modal
                document.getElementById("modal_event_id").value = ev.event_id ?? ev.id ?? "";
                document.getElementById("modal_event_name").value = ev.name ?? "";
                document.getElementById("modal_year").value = ev.year ?? "";
                document.getElementById("modal_venue_details").value = ev.venue_details ?? "";
                document.getElementById("modal_coordinator").value = ev.coordinator ?? "";
                document.getElementById("modal_start_date").value = ev.start_date ?? "";

                const eventInput = document.getElementById("event_id");
                if (eventInput) eventInput.value = ev.id || "";

                highlightButton();
                hero.style.opacity = 1;
            }, 200);
        }

        function highlightButton() {
            document.querySelectorAll('.city-btn').forEach((btn, i) => {
                btn.classList.toggle('active', i === index);
            });
        }

        fetchEvents();
    })();


    // 1. Toggle function for the window
    window.toggleModal = function () {
        const modal = document.getElementById('auth-modal');
        modal.style.display = (modal.style.display === 'flex') ? 'none' : 'flex';
    }
</script>
<div id="auth-modal"
    style="display:none; position:fixed; inset:0; z-index:9999; align-items:center; justify-content:center; background:rgba(0,0,0,0.7); font-family:sans-serif;">
    <div
        style="background:white; padding:25px; border-radius:12px; width:100%; max-width:400px; position:relative; color:#333; box-shadow: 0 10px 25px rgba(0,0,0,0.2);">
        <button onclick="toggleModal()"
            style="position:absolute; right:15px; top:15px; border:none; background:none; font-size:24px; cursor:pointer; color:#888;">&times;</button>

        <h3 style="margin-top:0; color:#1e3a8a;">Register Interest</h3>

        <div
            style="background:#f8fafc; padding:15px; border-radius:8px; margin-bottom:20px; border:1px solid #e2e8f0; font-size:14px;">
            <div style="margin-bottom:8px;"><strong>Event:</strong> <span id="view_event_name"></span></div>
            <div style="margin-bottom:8px;"><strong>Year:</strong> <span id="view_year"></span></div>
            <div style="margin-bottom:8px;"><strong>Venue:</strong> <span id="view_venue"></span></div>
            <div style="margin-bottom:8px;"><strong>Date:</strong> <span id="view_date"></span></div>
            <div><strong>Coordinator:</strong> <span id="view_coordinator"></span></div>
        </div>

        <form method="POST" action="{{ url('/request-otp') }}">
            @csrf
            <input type="hidden" name="event_id" id="modal_event_id">
            <input type="hidden" name="event_name" id="modal_event_name">
            <input type="hidden" name="year" id="modal_year">
            <input type="hidden" name="venue_details" id="modal_venue_details">
            <input type="hidden" name="coordinator" id="modal_coordinator">
            <input type="hidden" name="start_date" id="modal_start_date">

            <div style="margin-bottom:15px;">
                <label style="display:block; font-size:13px; font-weight:bold; margin-bottom:8px;">Your Mobile or
                    Email</label>
                <input type="text" name="input" required placeholder="Ex: 9876543210 or mail@example.com"
                    style="width:100%; padding:12px; border:1px solid #cbd5e1; border-radius:6px; box-sizing:border-box; font-size:15px;">
            </div>

            <button type="submit"
                style="width:100%; padding:14px; background:#2563eb; color:white; border:none; border-radius:6px; font-weight:bold; cursor:pointer; font-size:16px;">
                Submit Registration
            </button>
        </form>
    </div>
</div>