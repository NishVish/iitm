<script>
    /**
     * Call this function to refresh the UI when the event index changes.
     * It maps your specific API keys: event_image, venue_details, venue_booking_details.
     */

    console.log("hello");
    function updateDisplayxx() {


        console.log("hello");


        const ev = events[index];
        console.log("hello");


        console.log("hello");

        console.log("hello");

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
                    console.log(events);
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
            console.log(ev.event_image);
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
            // document.getElementById("view_coordinator").innerText = ev.coordinator || "N/A";

            // 2. Update Hidden Inputs (For Form Submission)
            document.getElementById("modal_event_id").value = ev.event_id ?? ev.id ?? "";
            document.getElementById("modal_event_name").value = ev.name ?? "";
            document.getElementById("modal_year").value = ev.year ?? "";
            document.getElementById("modal_venue_details").value = ev.venue_details ?? "";
            document.getElementById("modal_coordinator").value = ev.coordinator ?? "";
            document.getElementById("modal_start_date").value = ev.start_date ?? "";


            document.getElementById("eventName").innerText = ev.name;
            document.getElementById("eventVenue").innerText = ev.venue_details || "TBA";
            console.log(ev.event_image);
            document.getElementById("eventImage").src = ev.event_image || 'https://via.placeholder.com/350x250';
            document.getElementById("eventDate").innerText = `${new Date(ev.start_date).toDateString()}`;
            const btn = document.getElementById("regBtn");
            console.log({
                name: ev.name,
                year: ev.year,
                venue: ev.venue_details,
                access: ev.venue_booking_details,
                image: ev.image
            });
            if (btn) {
                const venueText = (ev.venue_details || "").toUpperCase();

                if (venueText.includes("TBA")) {
                    btn.innerText = "Registration Opening Soon";
                    btn.disabled = true;
                    btn.style.opacity = "0.6";
                    btn.style.cursor = "not-allowed";
                } else {
                    btn.innerText = "Register Interest";
                    btn.disabled = false;
                    btn.style.opacity = "1";
                    btn.style.cursor = "pointer";
                }
            } // Sync all fields to the modal
            document.getElementById("modal_event_id").value = ev.event_id ?? ev.id ?? "";
            document.getElementById("modal_event_name").value = ev.name ?? "";
            document.getElementById("modal_year").value = ev.year ?? "";
            document.getElementById("modal_venue_details").value = ev.venue_details ?? "";
            // document.getElementById("modal_coordinator").value = ev.coordinator ?? "";
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
        function highlightActiveButton(activeIndex) {
            const allBtns = document.querySelectorAll('.city-btn');

            allBtns.forEach((btn, i) => {
                if (i === activeIndex) {
                    btn.style.borderColor = "var(--iitm-background2)";
                    btn.style.color = "var(--iitm-text2)";
                    btn.style.background = "var(--iitm-background2)";
                } else {
                    btn.style.borderColor = "var(--iitm-background2)";
                    btn.style.color = "var(--iitm-text)";
                    btn.style.background = "var(--iitm-background)";
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
<div id="auth-modal" style="display:none; position:fixed; inset:0; z-index:9999; align-items:center; justify-content:center;
    background:rgba(0,0,0,0.6); font-family:system-ui, sans-serif;">

    <div style="background:var(--iitm-background); padding:25px; border-radius:10px; width:100%; max-width:420px;
        position:relative; color:var(--iitm-text); border:1px solid var(--iitm-background2);
        box-shadow:0 10px 30px rgba(0,0,0,0.15);">

        <button onclick="toggleModal()" style="position:absolute; right:12px; top:10px; border:none; background:none;
            font-size:24px; cursor:pointer; color:var(--iitm-text); opacity:0.7;">
            &times;
        </button>

        <h3 style="margin-top:0; color:var(--iitm-text); font-size:20px; letter-spacing:0.5px;">
            Register Interest
        </h3>

        <!-- EVENT SUMMARY -->
        <div style="background:var(--iitm-background); padding:15px; border-radius:8px; margin-bottom:18px;
            border:1px solid var(--iitm-background2); font-size:14px;">

            <div style="margin-bottom:8px;">
                <strong>Event:</strong> <span id="view_event_name"></span>
            </div>
            <div style="margin-bottom:8px;">
                <strong>Year:</strong> <span id="view_year"></span>
            </div>
            <div style="margin-bottom:8px;">
                <strong>Venue:</strong> <span id="view_venue"></span>
            </div>
            <div style="margin-bottom:8px;">
                <strong>Date:</strong> <span id="view_date"></span>
            </div>
            <div>
                <!-- <strong>Coordinator:</strong> <span id="view_coordinator"></span> -->
            </div>
        </div>

        <!-- FORM -->
        <form method="POST" action="{{ url('/visitor-form') }}">
            @csrf

            <input type="hidden" name="event_id" id="modal_event_id">
            <input type="hidden" name="event_name" id="modal_event_name">
            <input type="hidden" name="year" id="modal_year">
            <input type="hidden" name="venue_details" id="modal_venue_details">
            <input type="hidden" name="coordinator" id="modal_coordinator">
            <input type="hidden" name="start_date" id="modal_start_date">

            <div style="margin-bottom:15px;">
                <label style="display:block; font-size:13px; font-weight:600; margin-bottom:8px;
                color:var(--iitm-text);">
                    Your Mobile or Email
                </label>

                <input type="text" name="input" required placeholder="Ex: 9876543210 or mail@example.com" style="width:100%; padding:12px; border:1px solid var(--iitm-background2);
                    border-radius:6px; box-sizing:border-box; font-size:15px; color:var(--iitm-text);
                    outline:none;">
            </div>

            <button type="submit" style="width:100%; padding:14px; background:var(--iitm-background2);
                color:var(--iitm-text2); border:none; border-radius:6px;
                font-weight:600; cursor:pointer; font-size:15px;
                transition:0.2s ease;">

                Get Started </button>

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