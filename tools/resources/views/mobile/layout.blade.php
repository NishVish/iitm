{{-- resources/views/mobile/events/layout.blade.php --}}

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    :root {
        --primary: #4f46e5;
        --secondary: #10b981;
        --surface: #ffffff;
        --text-main: #0f172a;
        --text-muted: #64748b;
    }

    body {
        background-color: #f3f4f6;
        font-family: 'Plus Jakarta Sans', sans-serif;
        margin: 0;
        color: var(--text-main);
    }

    .event-container {
        max-width: 900px;
        margin: 40px auto;
        background: var(--surface);
        border-radius: 32px;
        overflow: hidden;
        box-shadow: 0 40px 100px -20px rgba(0,0,0,0.1);
    }

    .location-header {
        padding: 3px;
        text-align: center;
        border-bottom: 1px solid #f1f5f9;
        background: #fff;
    }

    .location-header i {
        color: var(--primary);
        font-size: 24px;
        margin-bottom: 10px;
    }

    .location-header h1 {
        margin: 0;
        font-size: 22px;
        font-weight: 800;
        letter-spacing: -0.5px;
        text-transform: uppercase;
    }

    .location-header p {
        margin: 5px 0 0;
        color: var(--text-muted);
        font-size: 14px;
    }

    .layout-viewer {
        background: #1e293b;
        height: 500px;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    #hero-img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .action-footer {
        padding: 30px;
        display: flex;
        justify-content: center;
        gap: 20px;
        background: #fff;
    }

    .btn {
        padding: 16px 32px;
        border-radius: 16px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 12px;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }

    .btn-buy {
        background: var(--secondary);
        color: white;
        box-shadow: 0 10px 20px -5px rgba(16, 185, 129, 0.4);
    }

    .btn-buy:hover { transform: translateY(-3px); box-shadow: 0 15px 30px -5px rgba(16, 185, 129, 0.5); }

    .btn-layout {
        background: var(--primary);
        color: white;
        box-shadow: 0 10px 20px -5px rgba(79, 70, 229, 0.4);
    }

    .btn-layout:hover { transform: translateY(-3px); box-shadow: 0 15px 30px -5px rgba(79, 70, 229, 0.5); }

    #loader { padding: 100px; text-align: center; }

    @media (max-width: 600px) {
        .action-footer { flex-direction: column; }
        .btn { width: 100%; justify-content: center; }
    }
</style>

<div class="event-container" id="main-card" style="display: none;">
    <div class="location-header">
        <i class="fa-solid fa-location-dot"></i>
        <!-- <h1 id="event-name-display">EVENT LAYOUT</h1> -->
        <p id="event-venue-text"></p>
    </div>

    <div class="layout-viewer">
        <img id="hero-img" src="" alt="Floor Plan">
    </div>

    <div class="action-footer">
        <a href="#" id="buy-stall-btn" class="btn btn-buy">
            <i class="fa-solid fa-shop"></i> Buy a Stall
        </a>
        <a href="#" id="view-layout-btn" target="_blank" class="btn btn-layout">
            <i class="fa-solid fa-maximize"></i> View Full Layout
        </a>
    </div>
</div>

<div id="loader">
    <p>Loading the latest layout...</p>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // 1. Get Event ID from URL query string (e.g., layout?id=5)
    const urlParams = new URLSearchParams(window.location.search);
    const eventId = urlParams.get('id');

    // 2. Define Laravel API endpoints
    // Note: We'll append the eventId to the fetch URL
    const fetchUrl = "{{ url('lasteventdetails') }}/" + (eventId || 'latest');
    const buyUrlBase = "{{ url('stalls/book') }}";

    fetch(fetchUrl)
    .then(res => res.json())
    .then(event => {
        document.getElementById("loader").style.display = "none";

        if (event && event.name) {
            document.getElementById("main-card").style.display = "block";
            // document.getElementById("event-name-display").innerText = event.name;
            document.getElementById("event-venue-text").innerText = event.venue_details || 'Venue Details Coming Soon';

            // Set Image logic
            let imgPath = event.event_image_url || "https://via.placeholder.com/800x500?text=Layout+Coming+Soon";
            
            document.getElementById("hero-img").src = imgPath;
            document.getElementById("view-layout-btn").href = imgPath;

            // Stall Buying Link
            document.getElementById("buy-stall-btn").href = buyUrlBase + "/" + event.event_id;
        } else {
            document.getElementById("loader").innerHTML = "<h3>Event details not found.</h3>";
        }
    })
    .catch(err => {
        console.error("Fetch error:", err);
        document.getElementById("loader").innerText = "Error loading layout details.";
    });
});
</script>