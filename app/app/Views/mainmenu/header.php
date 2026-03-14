
    <div class="header">
       <style>
.event-details{
    display:flex;
    flex-direction:column;
    font-family:system-ui, -apple-system, sans-serif;
}

.event-value{
    font-size:2rem;
    font-weight:600;
    color:white;
}

.event-label{
    font-size:1.1rem;
    color:grey;
    letter-spacing:0.5px;
}
</style>
<div class="brand-logo">
            <img src="https://iitmindia.com/reg/iitm_chennai/logo.png" alt="Logo">
        </div>

<div class="event-details">
    <span class="event-value" id="eventName">Loading...</span>
    <span class="event-label">Next Event || 20-21 March</span>
</div>
<div>

</div>
        
    </div>


    <style>
/* --- Upgraded Stats Card with Countdown --- */
.stats-container {
    padding: 0 20px;
    margin-top: -45px;
}

.stats-card {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border-radius: 25px;
    padding: 20px 10px;
    display: flex;
    justify-content: space-around;
    box-shadow: 0 15px 35px rgba(168, 35, 36, 0.15);
    border: 1px solid rgba(255, 255, 255, 0.5);
}

.stat-item { 
    text-align: center; 
    flex: 1; 
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.stat-item:not(:last-child) { 
    border-right: 1px solid rgba(168, 35, 36, 0.1); 
}

.stat-value { 
    display: block; 
    font-weight: 800; 
    font-size: 24px; 
    color: #a82324; /* Your IITM Maroon */
    line-height: 1;
}

.stat-label { 
    font-size: 10px; 
    color: #7f8c8d; 
    margin-top: 6px; 
    font-weight: 700; 
    text-transform: uppercase; 
    letter-spacing: 0.5px;
}

/* Pulse animation for the event name */

</style>
<div class="stats-container">
    <div class="stats-card">
        <div class="stat-item">
            <span class="stat-value" id="eventDays">--</span>
            <span class="stat-label">Days</span>
        </div>
        <div class="stat-item">
            <span class="stat-value" id="eventHours">--</span>
            <span class="stat-label">Hours</span>
        </div>
        <div class="stat-item">
            <span class="stat-value" id="eventMins">--</span>
            <span class="stat-label">Mins</span>
        </div>
       
    </div>
</div>

<script>

    let eventId = null; // global variable

// Replace 'events/upcoming' with your actual full URL if necessary
fetch('events/upcoming')
.then(res => res.json())
.then(event => {
    eventId = event.event_id;   // set global variable

    console.log(event);
    const eventNameEl = document.getElementById('eventName');
    const daysEl = document.getElementById('eventDays');
    const hoursEl = document.getElementById('eventHours');
    const minsEl = document.getElementById('eventMins');

    // Set the Name
    eventNameEl.innerText = event.name;

    // Parse the start date from your JSON
    const eventDate = new Date(event.start_date);

    function updateCountdown() {
        const now = new Date();
        const diff = eventDate - now;

        if (diff <= 0) {
            daysEl.innerText = "00";
            hoursEl.innerText = "00";
            minsEl.innerText = "00";
            eventNameEl.innerText = "Live Now!";
            return;
        }

        const days = Math.floor(diff / (1000 * 60 * 60 * 24));
        const hours = Math.floor((diff / (1000 * 60 * 60)) % 24);
        const mins = Math.floor((diff / (1000 * 60)) % 60);

        // padStart adds a '0' if the number is less than 10 for a cleaner look
        daysEl.innerText = String(days).padStart(2, '0');
        hoursEl.innerText = String(hours).padStart(2, '0');
        minsEl.innerText = String(mins).padStart(2, '0');
    }

    // Initial call
    updateCountdown();
    // Update every minute (60000ms) to save battery/performance
    setInterval(updateCountdown, 60000);
})
.catch(err => {
    console.error("Countdown Error:", err);
    document.getElementById('eventName').innerText = "TBA";
});
</script>

    <div class="section-header">
    </div>