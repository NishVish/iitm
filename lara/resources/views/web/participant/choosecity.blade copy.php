<div id="eventOverlay" class="event-overlay">
    <div class="event-box shadow-lg">
        <h2 class="fw-bold mb-1">Select Event</h2>
        <p class="text-muted small">Please choose an event to continue</p>

        <div id="eventButtons" class="event-list-container mt-3">
            <div class="text-center py-5" id="eventLoader">
                <div class="spinner-border text-primary spinner-border-sm" role="status"></div>
                <div class="mt-2 text-secondary small">Fetching events...</div>
            </div>
        </div>

        <input type="hidden" name="event_id" id="event_id">

        <div class="d-grid mt-4">
            <button type="button" id="continueBtn" class="btn btn-success btn-lg disabled" onclick="confirmEvent()">
                Continue
            </button>
        </div>
    </div>
</div>

<div id="selectedEventBox" class="alert alert-success mt-3 shadow-sm mx-auto" style="display:none; max-width: 550px;">
    <div class="d-flex align-items-center">
        <span class="me-2">✅</span>
        <span>Selected Event: <strong id="selectedEventName"></strong></span>
    </div>
</div>

<style>
    /* Full screen modern backdrop */
    .event-overlay {
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.8);
        backdrop-filter: blur(8px);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 99999;
        padding: 20px;
        transition: opacity 0.3s ease;
    }

    /* The Modal Card */
    .event-box {
        background: #ffffff;
        padding: 2rem;
        border-radius: 1.25rem;
        width: 100%;
        max-width: 500px;
        text-align: center;
        animation: eventModalSlide 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }

    /* Scrollable Area for buttons */
    .event-list-container {
        max-height: 350px;
        overflow-y: auto;
        padding: 5px;
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    /* Custom Event Buttons */
    .event-btn {
        transition: all 0.2s ease;
        border: 2px solid #f1f5f9;
        text-align: left;
        padding: 1rem;
        border-radius: 0.75rem;
        background: #fff;
        cursor: pointer;
        display: flex;
        flex-direction: column;
    }

    .event-btn:hover {
        border-color: #0d6efd;
        background-color: #f8fbff;
        transform: translateY(-2px);
    }

    .event-btn.active {
        border-color: #0d6efd;
        background-color: #eef6ff;
        box-shadow: 0 0 0 1px #0d6efd;
    }

    /* Animation */
    @keyframes eventModalSlide {
        from {
            opacity: 0;
            transform: translateY(20px) scale(0.95);
        }

        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    /* Scrollbar styling */
    .event-list-container::-webkit-scrollbar {
        width: 5px;
    }

    .event-list-container::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }
</style>

<script>
    const UI = {
        container: document.getElementById("eventButtons"),
        hiddenInput: document.getElementById("event_id"),
        continueBtn: document.getElementById("continueBtn"),
        overlay: document.getElementById("eventOverlay"),
        resultBox: document.getElementById("selectedEventBox"),
        resultName: document.getElementById("selectedEventName")
    };

    let selectedEventData = { id: null, name: "" };

    // Initial Load
    document.addEventListener("DOMContentLoaded", () => {
        fetchEvents();
    });

    async function fetchEvents() {
        try {
            // Replace with your actual endpoint
            const response = await fetch("{{ url('api/events') }}");
            if (!response.ok) throw new Error("Failed to load");

            const events = await response.json();
            renderEvents(events);
        } catch (err) {
            UI.container.innerHTML = `
                <div class="py-4">
                    <p class="text-danger mb-0">Unable to load events.</p>
                    <button class="btn btn-sm btn-link" onclick="fetchEvents()">Try Again</button>
                </div>`;
        }
    }

    function renderEvents(events) {
        UI.container.innerHTML = "";

        if (events.length === 0) {
            UI.container.innerHTML = `<div class="text-muted py-4">No events found.</div>`;
            return;
        }

        events.forEach(event => {
            const btn = document.createElement("button");
            btn.type = "button";
            btn.className = "event-btn";

            btn.innerHTML = `
                <span class="fw-bold text-dark">${event.name}</span>
                <small class="text-muted">${event.start_date} — ${event.end_date}</small>
            `;

            btn.onclick = () => {
                // Update selection state
                selectedEventData.id = event.event_id;
                selectedEventData.name = event.name;
                UI.hiddenInput.value = event.event_id;

                // Toggle visual "active" state
                document.querySelectorAll(".event-btn").forEach(b => b.classList.remove("active"));
                btn.classList.add("active");

                // Enable the continue button
                UI.continueBtn.classList.remove("disabled");
            };

            UI.container.appendChild(btn);
        });
    }

    function confirmEvent() {
        if (!selectedEventData.id) return;

        // Fade out animation
        UI.overlay.style.opacity = "0";

        setTimeout(() => {
            UI.overlay.style.display = "none";
            UI.resultBox.style.display = "block";
            UI.resultName.textContent = selectedEventData.name;
        }, 300);
    }
</script>