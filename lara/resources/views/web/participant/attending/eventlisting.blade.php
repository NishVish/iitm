<div id="main" class="split-layout">
    @include('web.participant.attending.eventlistingcss')


    <!-- LEFT -->
    <div class="left">
        <div id="btnRow"></div>
    </div>

    <!-- RIGHT -->
    <div class="right">

        <div class="hero">

            <h1 id="eventName">Event Name</h1>

            <img id="eventImage" src="https://via.placeholder.com/390x270" />

            <div class="event-meta">
                <div id="eventDate">Date: 10 Jan 2026</div>
                <div id="eventVenue">Venue: Chennai Trade Centre</div>
            </div>

        </div>

        <div class="info">
            <button id="regBtn" class="primary-btn" onclick="toggleModal()">Register Interest</button>
            <div class="tagline">Global Marketplace • Tourism • Business Networking</div>
        </div>

    </div>

    <style>
        .right {
            width: 72%;
            display: flex;
            flex-direction: column;
            font-family: system-ui, sans-serif;
        }

        .hero {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px;
            gap: 15px;
            text-align: center;
        }

        #eventName {
            font-size: 42px;
            font-weight: 900;
            margin: 0;
            color: #AA2324;
            text-transform: uppercase;
        }

        #eventImage {
            width: 390px;
            height: 270px;
            object-fit: cover;
            border-radius: 12px;
            border: 2px solid #AA2324;
        }

        .event-meta {
            gap: 10px;
            margin-top: 10px;
            flex-wrap: wrap;
            justify-content: center;
            max-width: 100%;
            gap: 10px;
        }

        /* FIXED BADGES */
        .event-meta div {
            margin-bottom: 5px;
            padding: 8px 12px;
            font-size: 12px;
            border-radius: 6px;
            background: #AA2324;
            color: #fff;

            /* IMPORTANT FIX */
            white-space: normal;
            max-width: 50vh;
            text-align: center;
            word-break: break-word;
            overflow-wrap: break-word;
        }
    </style>
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const dateEl = document.getElementById("eventDate");

        if (!dateEl) return;

        // remove label like "Date:"
        let rawDate = dateEl.innerText.replace("Date:", "").trim();

        let dateObj = new Date(rawDate);

        // fallback if invalid
        if (isNaN(dateObj)) return;

        const formatted = dateObj.toLocaleDateString("en-IN", {
            day: "2-digit",
            month: "short",
            year: "numeric"
        });

        dateEl.innerText = "Date: " + formatted;
    });
</script>

@include('web.participant.attending.eventlistingscript')