<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    /* NAMESPACED STYLES to prevent conflicts */
    #event-calendar-app {
        --cal-primary: #4f46e5;
        --cal-secondary: #10b981;
        --cal-bg: #f8fafc;
        --cal-surface: #ffffff;
        --cal-text-main: #0f172a;
        --cal-text-muted: #64748b;
        
        background-color: var(--cal-bg);
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: var(--cal-text-main);
        padding: 40px 20px;
        border-radius: 32px; /* Optional: contains the app area */
    }

    #event-calendar-app .cal-container {
        max-width: 850px;
        margin: 0 auto;
    }

    #event-calendar-app .cal-header {
        margin-bottom: 30px;
    }

    #event-calendar-app .cal-header h1 {
        font-size: clamp(24px, 5vw, 32px);
        font-weight: 800;
        letter-spacing: -1px;
        margin: 0;
        color: var(--cal-text-main);
    }

    #event-calendar-app #cal-status-msg {
        display: inline-block;
        margin-top: 10px;
        padding: 6px 16px;
        background: #e0e7ff;
        color: var(--cal-primary);
        border-radius: 100px;
        font-size: 13px;
        font-weight: 700;
    }

    #event-calendar-app .cal-list {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    /* CARD STYLING */
    #event-calendar-app .cal-card {
        background: var(--cal-surface);
        display: flex;
        align-items: center;
        padding: 24px;
        border-radius: 24px;
        border: 1px solid #e2e8f0;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    #event-calendar-app .cal-card:hover {
        transform: translateX(10px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05);
        border-color: var(--cal-primary);
    }

    /* DATE BADGE */
    #event-calendar-app .cal-date-badge {
        background: #f1f5f9;
        min-width: 80px;
        height: 90px;
        border-radius: 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        margin-right: 24px;
        transition: all 0.3s ease;
    }

    #event-calendar-app .cal-card:hover .cal-date-badge {
        background: var(--cal-primary);
        color: white;
    }

    #event-calendar-app .cal-date-badge .day {
        font-size: 28px;
        font-weight: 800;
        line-height: 1;
    }

    #event-calendar-app .cal-date-badge .month {
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        margin-top: 4px;
    }

    /* INFO SECTION */
    #event-calendar-app .cal-info {
        flex-grow: 1;
    }

    #event-calendar-app .cal-info h3 {
        margin: 0 0 8px 0;
        font-size: 20px;
        font-weight: 700;
        color: var(--cal-text-main);
    }

    #event-calendar-app .cal-info p {
        margin: 0;
        color: var(--cal-text-muted);
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* ACTIONS */
    #event-calendar-app .cal-actions {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    #event-calendar-app .cal-btn-book {
        background: var(--cal-secondary);
        color: white;
        padding: 12px 24px;
        border-radius: 14px;
        font-size: 14px;
        font-weight: 700;
        text-decoration: none;
        transition: 0.3s;
        box-shadow: 0 4px 10px rgba(16, 185, 129, 0.2);
    }

    #event-calendar-app .cal-btn-book:hover {
        background: #059669;
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(16, 185, 129, 0.3);
    }

    #event-calendar-app .cal-btn-circle {
        width: 48px;
        height: 48px;
        background: #f1f5f9;
        color: var(--cal-text-main);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: 0.3s;
    }

    #event-calendar-app .cal-btn-circle:hover {
        background: var(--cal-primary);
        color: white;
        transform: rotate(-45deg);
    }

    /* MOBILE TWEAKS */
    @media (max-width: 650px) {
        #event-calendar-app .cal-card { flex-direction: column; align-items: flex-start; }
        #event-calendar-app .cal-date-badge { min-width: 100%; height: 50px; flex-direction: row; gap: 10px; margin-bottom: 15px; }
        #event-calendar-app .cal-actions { width: 100%; margin-top: 20px; justify-content: space-between; }
        #event-calendar-app .cal-btn-book { flex-grow: 1; text-align: center; }
    }
</style>

<div id="event-calendar-app">
    <div class="cal-container">
        <div class="cal-header">
            <h1>Upcoming Events</h1>
            <div id="cal-status-msg">Fetching showtimes...</div>
        </div>

        <div id="cal-list-container" class="cal-list">
            </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const listContainer = document.getElementById("cal-list-container");
    const statusMsg = document.getElementById("cal-status-msg");

    fetch('<?= base_url('mobile/events/upcoming/all') ?>')
    .then(res => res.json())
    .then(data => {
        if (data && data.length > 0) {
            statusMsg.innerText = `${data.length} Global Events Found`;
            
            let html = '';
            data.forEach(event => {
                const dateObj = new Date(event.start_date);
                const day = dateObj.getDate();
                const month = dateObj.toLocaleString('default', { month: 'short' });

                html += `
                <div class="cal-card">
                    <div class="cal-date-badge">
                        <span class="day">${day}</span>
                        <span class="month">${month}</span>
                    </div>
                    
                    <div class="cal-info">
                        <h3>${event.name}</h3>
                        <p><i class="fa-solid fa-location-dot"></i> ${event.venue_details || 'Venue TBA'}</p>
                    </div>

                    <div class="cal-actions">
                        <a href="<?= base_url('stalls/book/') ?>${event.event_id}" class="cal-btn-book">
                            <i class="fa-solid fa-ticket"></i> Book Stall
                        </a>
                        <a href="<?= base_url('layout?id=') ?>${event.event_id}" class="cal-btn-circle" title="View Details">
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </div>`;
            });
            listContainer.innerHTML = html;
        } else {
            statusMsg.innerText = "No Scheduled Events";
            listContainer.innerHTML = '<div style="text-align:center; padding: 50px; opacity: 0.5;">No upcoming shows found at this time.</div>';
        }
    })
    .catch(err => {
        statusMsg.innerText = "Connection Error";
        console.error("Fetch error:", err);
    });
});
</script>