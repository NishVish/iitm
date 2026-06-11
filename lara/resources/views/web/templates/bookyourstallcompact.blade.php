<style>
    .iitm2026_widget_box {
        max-width: 400px;
        font-family: sans-serif;
        padding: 10px;
    }

    .iitm2026_widget_info h3 {
        margin: 0 0 10px;
        color: #A62322;
    }

    .iitm2026_widget_info p {
        margin: 0 !important;
        padding: 0 !important;
    }
</style>

<div class="iitm2026_widget_box">
    <div class="iitm2026_widget_info">
        <h3 id="iitm2026_title"></h3>
        <p><b>Venue:</b> <span id="iitm2026_venue"></span></p>
        <p><b>Date:</b> <span id="iitm2026_date"></span></p>
    </div>
</div>

<script>
    (() => {
        const elTitle = document.getElementById("iitm2026_title");
        const elVenue = document.getElementById("iitm2026_venue");
        const elDate = document.getElementById("iitm2026_date");

        fetch("{{ url('api/events') }}")
            .then(r => r.json())
            .then(data => {
                const events = Array.isArray(data) ? data : [];

                const now = new Date();

                const upcoming = events
                    .filter(e => e.start_date && new Date(e.start_date) >= now)
                    .sort((a, b) => new Date(a.start_date) - new Date(b.start_date));

                if (!upcoming.length) {
                    elTitle.textContent = "No upcoming events";
                    elVenue.textContent = "";
                    elDate.textContent = "";
                    return;
                }

                const nextEvent = upcoming[0];

                elTitle.textContent = nextEvent.name || "";
                elVenue.textContent = nextEvent.venue_details || "";

                elDate.textContent =
                    (nextEvent.start_date && nextEvent.end_date)
                        ? `${new Date(nextEvent.start_date).toDateString()} - ${new Date(nextEvent.end_date).toDateString()}`
                        : "TBA";
            })
            .catch(err => {
                console.error("Event fetch failed:", err);
            });
    })();
</script>