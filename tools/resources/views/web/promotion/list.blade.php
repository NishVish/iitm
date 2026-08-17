<style>
    :root {
        --iitm-primary: #A62322;
        --iitm-primary-hover: #821b1a;
        --iitm-text-dark: #2d3748;
        --iitm-text-muted: #718096;
        --iitm-bg-card: #ffffff;
        --iitm-border: #e2e8f0;
    }

    .iitm-events {
        display: flex;
        flex-direction: column;
        gap: 24px;
        max-width: 1100px;
        margin: 40px auto;
        padding: 0 20px;
        font-family: Arial, sans-serif;
    }

    .iitm-event {
        display: flex;
        background: var(--iitm-bg-card);
        border: 1px solid var(--iitm-border);
        border-radius: 16px;
        overflow: hidden;
    }

    .iitm-event-main {
        flex: 1.4;
        padding: 28px;
    }

    .iitm-title {
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--iitm-text-dark);
        margin-bottom: 12px;
    }

    .iitm-meta-item {
        font-size: 0.95rem;
        color: var(--iitm-text-muted);
        margin: 6px 0;
    }

    .iitm-event-actions {
        flex: 1;
        display: flex;
        background: #f8fafc;
        border-left: 1px solid var(--iitm-border);
    }

    .iitm-box {
        flex: 1;
        padding: 24px;
        text-align: center;
    }

    .iitm-box:first-child {
        border-right: 1px solid var(--iitm-border);
    }

    .iitm-btn {
        display: inline-block;
        width: 100%;
        padding: 12px;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
    }

    .iitm-btn-primary {
        background: var(--iitm-primary);
        color: #fff;
        border: 2px solid var(--iitm-primary);
    }

    .iitm-btn-outline {
        background: transparent;
        color: var(--iitm-primary);
        border: 2px solid var(--iitm-primary);
    }
</style>

<div id="iitmEvents" class="iitm-events"></div>

<script>
    const container = document.getElementById("iitmEvents");

    const apiUrl = "{{ url('api/events') }}";
    const promotionBase = "{{ url('promotion') }}";

    fetch(apiUrl)
        .then(res => res.json())
        .then(events => {

            container.innerHTML = events.map(e => {

                const safeName = encodeURIComponent(
                    (e.name || "event").toLowerCase().replace(/\s+/g, "-")
                );

                const sellerUrl = `${promotionBase}/${safeName}/seller`;
                const buyerUrl = `${promotionBase}/${safeName}/buyer`;

                const dateRange = (e.start_date && e.end_date)
                    ? `${new Date(e.start_date).toDateString()} - ${new Date(e.end_date).toDateString()}`
                    : "Dates to be announced";

                return `
                <div class="iitm-event">

                    <div class="iitm-event-main">
                        <div class="iitm-title">${e.name ?? "Untitled Event"}</div>

                        <div class="iitm-meta-item">📅 ${dateRange}</div>
                        <div class="iitm-meta-item">📍 ${e.venue_details ?? "Venue TBA"}</div>
                    </div>

                    <div class="iitm-event-actions">

                        <div class="iitm-box">
                            <h4>Buy a Stall</h4>
                            <a class="iitm-btn iitm-btn-outline" href="${sellerUrl}">
                                Buy Stall
                            </a>
                        </div>

                        <div class="iitm-box">
                            <h4>Visit Event</h4>
                            <a class="iitm-btn iitm-btn-primary" href="${buyerUrl}">
                                Visit Event
                            </a>
                        </div>

                    </div>

                </div>
            `;
            }).join('');

        })
        .catch(err => {
            console.error(err);
            container.innerHTML = "<p>Failed to load events</p>";
        });
</script>