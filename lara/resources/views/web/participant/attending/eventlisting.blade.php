<div id="main" class="split-layout">
    <style>
        .split-layout {
            display: flex;
            width: 100%;
            height: 80vh;
            overflow: hidden;
            font-family: system-ui, sans-serif;
        }

        /* LEFT 30% */
        .left {
            width: 30%;
            background: #0f172a;
            padding: 20px;
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
            transition: 0.2s;
        }

        /* RIGHT 70% */
        .right {
            width: 70%;
            display: flex;
            flex-direction: column;
        }


        /* BOTTOM 30% INFO BAR */
        .info {
            flex: 3;
            display: flex;
            justify-content: space-around;
            align-items: center;
            background: linear-gradient(135deg, #0ea5e9, #1e3a8a);
            color: white;
            padding: 20px;
        }

        /* =========================
   RESPONSIVE LAYOUT
========================= */

        @media (max-width: 900px) {

            .split-layout {
                flex-direction: column;
                height: auto;
            }

            /* LEFT becomes top bar */
            .left {
                width: 100%;
                height: auto;
                padding: 10px;
            }

            #btnRow {
                flex-direction: row;
                overflow-x: auto;
                gap: 8px;
                white-space: nowrap;
            }

            .city-btn {
                flex: 0 0 auto;
                padding: 10px 14px;
                font-size: 14px;
                border-radius: 8px;
            }

            /* RIGHT becomes full width */
            .right {
                width: 100%;
            }

            /* HERO adjustments */
            .hero {
                flex-direction: column;
                text-align: center;
                padding: 20px;
                gap: 15px;
            }

            .hero-text {
                max-width: 100%;
                align-items: center;
            }

            .hero-text h1 {
                font-size: 28px;
            }

            #eventImage {
                width: 100%;
                height: 200px;
            }

            /* Convert absolute chips into inline stack */
            #eventDate,
            #eventVenueDetails,
            #eventAccessInfo {
                position: static;
                transform: none;
                margin: 6px 0;
                display: block;
                width: fit-content;
            }

            /* INFO BAR */
            .info {
                flex-direction: column;
                text-align: center;
                gap: 10px;
                padding: 15px;
            }
        }
    </style>

    <!-- LEFT -->
    <div class="left">
        <div id="btnRow"></div>
    </div>

    <!-- RIGHT -->
    <div class="right" id="hero">

        <!-- TOP (70%) -->
        <div class="hero">

            <style>
                .hero {
                    position: relative;
                    width: 100%;
                    height: 100%;
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    padding: 50px;
                    background: linear-gradient(135deg, #0f172a, #1e3a8a);
                    color: white;
                    overflow: hidden;
                    box-sizing: border-box;
                }

                .hero-text {
                    display: flex;
                    flex-direction: column;
                    gap: 10px;
                    max-width: 45%;
                    z-index: 2;
                }

                .hero-text h1 {
                    font-size: 42px;
                    font-weight: 800;
                    margin: 0;
                    letter-spacing: -0.02em;
                }

                .hero-text p {
                    margin: 0;
                    font-size: 15px;
                    opacity: 0.85;
                }

                #eventImage {
                    width: 380px;
                    height: 260px;
                    object-fit: cover;
                    border-radius: 16px;
                    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
                    z-index: 2;
                    transition: transform 0.3s ease;
                }

                #eventImage:hover {
                    transform: scale(1.03);
                }

                /* bottom info chips */
                #eventDate,
                #eventVenueDetails,
                #eventAccessInfo {
                    position: absolute;
                    bottom: 20px;
                    font-size: 13px;
                    padding: 10px 14px;
                    border-radius: 10px;
                    background: rgba(255, 255, 255, 0.08);
                    backdrop-filter: blur(10px);
                    color: #e2e8f0;
                    z-index: 3;
                }

                #eventDate {
                    left: 40px;
                }

                #eventVenueDetails {
                    left: 50%;
                    transform: translateX(-50%);
                }

                #eventAccessInfo {
                    right: 40px;
                }

                /* decorative glow */
                .hero::before {
                    content: "";
                    position: absolute;
                    width: 500px;
                    height: 500px;
                    background: radial-gradient(circle, rgba(59, 130, 246, 0.25), transparent 60%);
                    top: -150px;
                    right: -150px;
                    z-index: 1;
                }

                @media (max-width: 900px) {
                    .hero {
                        flex-direction: column;
                        text-align: center;
                        padding: 30px;
                    }

                    .hero-text {
                        max-width: 100%;
                    }

                    #eventImage {
                        width: 100%;
                        height: 220px;
                        margin-top: 20px;
                    }

                    #eventDate,
                    #eventVenueDetails,
                    #eventAccessInfo {
                        position: static;
                        transform: none;
                        margin-top: 10px;
                        display: inline-block;
                    }
                }
            </style>

            <div class="hero-text">
                <h1 id="eventName">Event</h1>
                <p id="eventVenue">Venue</p>
                <p id="eventAccess">Access</p>
            </div>

            <img id="eventImage" src="" />

            <div id="eventDate">Date</div>
            <div id="eventVenueDetails">Venue Details</div>
            <div id="eventAccessInfo">Access Info</div>

        </div>
        <!-- BOTTOM (30%) -->
        <div class="info">
            <button class="primary-btn" onclick="toggleModal()">
                Register Interest
            </button>
            Its A Markte That is Filled with THis and that
        </div>

    </div>


</div>


<script>
    /**
     * Call this function to refresh the UI when the event index changes.
     * It maps your specific API keys: event_image, venue_details, venue_booking_details.
     */
    function updateDisplay() {
        const ev = events[index];
        if (!ev) return;

        const hero = document.getElementById("hero");
        hero.classList.add("hero-transition");

        // Set Text Data
        safeUpdateContent("eventName", "innerText", ev.name || "Untitled Event");
        safeUpdateContent("eventYear", "innerText", ev.year || "2026");
        safeUpdateContent("eventVenue", "innerText", ev.venue_details || "Location TBA");
        safeUpdateContent("eventAccess", "innerText", ev.venue_booking_details || "General Access");

        // Handle Image Transitions
        const imgEl = document.getElementById("eventImage");
        if (imgEl) {
            imgEl.style.opacity = "0";
            setTimeout(() => {
                imgEl.src = ev.event_image || `https://media.gettyimages.com/id/1957832025/vector/people-and-landmarks-of-india-in-1895-law-courts-madras.jpg?s=612x612&w=0&k=20&c=mDruHajtQ4JZE3aqSPiXHlS7g918L4c1b128gT3XNOs=`;
                imgEl.style.opacity = "1";
            }, 200);
        }

        // Format Dates
        if (ev.start_date && ev.end_date) {
            const start = new Date(ev.start_date).toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
            const end = new Date(ev.end_date).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
            safeUpdateContent("eventDate", "innerText", `${start} — ${end}`);
        }

        // Cleanup Transition
        setTimeout(() => hero.classList.remove("hero-transition"), 400);

        // Run UI sync for buttons (from your previous logic)
        if (typeof highlightActiveButton === "function") highlightActiveButton();
    }

    // Navigation trigger
    function changeEvent(dir) {
        index = (index + dir + events.length) % events.length;
        updateDisplay();
    }




    (function () {
        // --- Global State ---
        let events = [];
        let index = 0;

        // --- Selectors ---
        const btnRow = document.getElementById("btnRow");
        const loader = document.getElementById("loader");
        const main = document.getElementById("main");
        const loadText = document.getElementById("loadText");

        // --- Initialization ---
        init();

        function init() {
            fetchEvents();
            setupNavListeners();
        }

        // --- API Logic ---
        function fetchEvents() {
            fetch("{{ url('api/events') }}")
                .then(res => res.json())
                .then(data => {
                    events = data;
                    if (events.length) {
                        renderCityButtons();
                        updateDisplay();
                        revealInterface();
                    }
                })
                .catch(err => {
                    if (loadText) loadText.innerText = "CONNECTION ERROR";
                    console.error("Fetch Error:", err);
                });
        }

        // --- Rendering Logic (The Buttons) ---
        function renderCityButtons() {
            if (!btnRow) return;
            btnRow.innerHTML = "";

            events.forEach((ev, i) => {
                const btn = document.createElement("button");
                btn.className = "city-btn";
                btn.textContent = (ev.name || "Event").toUpperCase();

                // Direct jump to this event
                btn.onclick = () => {
                    index = i;
                    updateDisplay();
                };

                btnRow.appendChild(btn);
            });
        }

        // --- Update Logic (The Hero Section) ---
        function updateDisplay() {

            const ev = events[index];
            if (!ev) return;

            const eventInput = document.getElementById("event_id");


            console.log(eventInput);
            if (eventInput) {
                // Use ev.id or ev.event_id based on your API response structure
                eventInput.value = ev.id || ev.event_id || "";
            }
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
            const dateString = `${new Date(ev.start_date).toDateString()} - ${new Date(ev.end_date).toDateString()}`;
            safeUpdateContent("eventDate", "innerText", dateString);

            // Visual Feedback
            highlightActiveButton();
            triggerHeroTransition();
        }

        // --- Navigation Logic ---
        function next() {
            index = (index + 1) % events.length;
            updateDisplay();
        }

        function prev() {
            index = (index - 1 + events.length) % events.length;
            updateDisplay();
        }

        function setupNavListeners() {
            const nBtn = document.getElementById("nextBtn");
            const pBtn = document.getElementById("prevBtn");
            if (nBtn) nBtn.onclick = next;
            if (pBtn) pBtn.onclick = prev;
        }

        // --- Helpers (Fancy Effects & Safety) ---
        function safeUpdateContent(id, property, value) {
            const el = document.getElementById(id);
            if (el) el[property] = value;
        }

        function highlightActiveButton() {
            const allBtns = document.querySelectorAll('.city-btn');
            allBtns.forEach((btn, i) => {
                if (i === index) {
                    btn.style.borderColor = "#00f5ff";
                    btn.style.color = "#fff";
                    btn.style.background = "rgba(0, 245, 255, 0.1)";
                } else {
                    btn.style.borderColor = "rgba(255, 255, 255, 0.1)";
                    btn.style.color = "#aaa";
                    btn.style.background = "rgba(255, 255, 255, 0.03)";
                }
            });
        }

        function triggerHeroTransition() {
            const hero = document.getElementById("hero");
            if (hero) {
                hero.style.opacity = 0;
                setTimeout(() => hero.style.opacity = 1, 200);
            }
        }

        function revealInterface() {
            setTimeout(() => {
                if (loader) loader.classList.add("hide");
                if (main) main.classList.add("show");
            }, 1500);
        }

    })();
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

<script>
    function toggleModal() {
        var modal = document.getElementById("auth-modal");

        if (modal.style.display === "flex") {
            modal.style.display = "none";
        } else {
            modal.style.display = "flex";
        }
    }
</script>