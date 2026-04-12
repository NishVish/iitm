</div>
<div id="hero" class="hero-container">
    <div class="image-wrapper">
        <img id="eventImage" src="" alt="Event Backdrop">
        <div class="image-overlay"></div>
    </div>

    <div class="details-content">
        <div class="meta-tags">
            <span id="eventYear" class="tag">2026</span>
            <span class="tag accent" id="eventStatus">UPCOMING</span>
        </div>

        <h1 id="eventName" class="event-title">—</h1>

        <div class="info-grid">
            <div class="info-item">
                <label>Location</label>
                <p id="eventVenue">—</p>
            </div>
            <div class="info-item">
                <label>Date</label>
                <p id="eventDate">—</p>
            </div>
            <div class="info-item">
                <label>Access</label>
                <p id="eventAccess">—</p>
            </div>
        </div>

        <div class="action-bar">
            <button class="primary-btn" onclick="toggleModal()">Register Interest</button>
            <div class="nav-arrows">
                <button id="prevBtn" class="nav-btn" onclick="changeEvent(-1)">←</button>
                <button id="nextBtn" class="nav-btn" onclick="changeEvent(1)">→</button>
            </div>
        </div>
    </div>
</div>

<style>
    :root {
        --accent: #00f5ff;
        --glass: rgba(255, 255, 255, 0.03);
        --border: rgba(255, 255, 255, 0.08);
        --bg-deep: #050505;
    }

    .hero-container {
        display: flex;
        background: var(--glass);
        border: 1px solid var(--border);
        border-radius: 32px;
        margin: 20px 40px;
        min-height: 500px;
        overflow: hidden;
        position: relative;
        backdrop-filter: blur(15px);
        transition: opacity 0.4s ease, transform 0.4s ease;
    }

    .image-wrapper {
        flex: 1;
        position: relative;
        background: #111;
        overflow: hidden;
    }

    .image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 1.2s cubic-bezier(0.2, 0, 0.2, 1);
    }

    .image-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to right, transparent, var(--bg-deep));
    }

    .details-content {
        flex: 1.2;
        padding: 60px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        background: var(--bg-deep);
    }

    .meta-tags {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
    }

    .tag {
        font-size: 10px;
        font-family: 'Syncopate', sans-serif;
        padding: 6px 14px;
        border: 1px solid #333;
        border-radius: 4px;
        color: #888;
        letter-spacing: 1px;
    }

    .tag.accent {
        border-color: var(--accent);
        color: var(--accent);
    }

    .event-title {
        font-size: clamp(2.5rem, 5vw, 4rem);
        font-weight: 900;
        margin: 0 0 30px 0;
        line-height: 0.9;
        text-transform: uppercase;
        letter-spacing: -2px;
        color: #fff;
    }


    /* Add this to force the Info Items to stay the same width */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        /* 3 equal columns */
        gap: 30px;
        width: 100%;
        text-align: left;
        margin-top: 20px;
    }

    .info-item {
        min-width: 0;
        /* Prevents overflow issues */
    }

    .info-item p {
        color: #fff;
        font-size: 14px;
        line-height: 1.6;
        margin: 5px 0 0 0;
        /* This ensures even short text takes up space */
        min-height: 3.2em;
    }

    .primary-btn {
        background: #fff;
        color: #000;
        border: none;
        padding: 18px 45px;
        border-radius: 50px;
        font-family: 'Syncopate', sans-serif;
        font-size: 10px;
        font-weight: 700;
        cursor: pointer;
        transition: 0.3s;
    }

    .primary-btn:hover {
        transform: scale(1.05);
        box-shadow: 0 0 30px rgba(255, 255, 255, 0.1);
    }

    .nav-btn {
        background: transparent;
        border: 1px solid #333;
        color: white;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        cursor: pointer;
        margin-left: 10px;
        transition: 0.3s;
    }

    .nav-btn:hover {
        border-color: var(--accent);
        color: var(--accent);
    }

    /* Transition Animation */
    .hero-transition {
        opacity: 0.5;
        transform: translateY(10px);
    }
</style>

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
            // Update Text & Images
            safeUpdateContent("eventImage", "src", ev.image || "https://media.gettyimages.com/id/1957832025/vector/people-and-landmarks-of-india-in-1895-law-courts-madras.jpg?s=612x612&w=0&k=20&c=mDruHajtQ4JZE3aqSPiXHlS7g918L4c1b128gT3XNOs=");
            safeUpdateContent("eventName", "innerText", ev.name);
            safeUpdateContent("eventVenue", "innerText", ev.venue_details || "TBA");
            safeUpdateContent("eventVenue", "innerText", ev.venue_details || "TBA");

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
</div>