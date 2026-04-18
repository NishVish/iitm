<style>
    .section-title {
        text-align: center;
        font-size: 2rem;
        font-weight: 800;
        margin: 60px 0 30px;
        color: #fff;
    }

    .slider-wrap {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 40px 0 60px;
        overflow: hidden;
    }

    .slider-track {
        display: flex;
        transition: transform 0.6s ease;
    }

    .glass {
        position: relative;
        width: 180px;
        height: 220px;
        margin: 0 10px;
        border-radius: 10px;
        overflow: hidden;
        background: linear-gradient(#ffffff12, transparent);
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 25px 25px rgba(0, 0, 0, 0.25);
        backdrop-filter: blur(10px);

        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
    }

    .glass-bg {
        position: absolute;
        inset: 0;
        background-size: cover;
        background-position: center;
        opacity: 0.25;
    }

    .glass-content {
        position: relative;
        z-index: 2;
        text-align: center;

        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 4px;
    }

    .glass-phase {
        font-size: 0.7rem;
        letter-spacing: 1px;
        text-transform: uppercase;
        opacity: 0.8;
    }

    .glass-title {
        font-size: 1rem;
        font-weight: 700;
    }

    .glass-sub {
        font-size: 0.75rem;
        opacity: 0.7;
    }

    .enquiry-btn {
        display: inline-block;
        margin-top: 8px;
        padding: 6px 14px;
        font-size: 10px;
        letter-spacing: 1px;
        text-transform: uppercase;
        color: #000;
        background: #fff;
        border-radius: 20px;
        text-decoration: none;
        transition: 0.3s;
    }

    .enquiry-btn:hover {
        transform: scale(1.05);
        background: #00f5ff;
    }
</style>

<h2 class="section-title">The 9 City Roadmap</h2>

<div class="slider-wrap">
    <div class="slider-track" id="sliderTrack"></div>
</div>

<script>
    let index = 0;
    let cards = [];
    const track = document.getElementById("sliderTrack");

    async function fetchCities() {
        const res = await fetch("{{ url('api/events') }}");
        cards = await res.json();

        renderCards();
        startSlider();
    }

    /* RENDER */
    function renderCards() {
        track.innerHTML = "";
        cards.forEach((ev, i) => {
            const div = document.createElement("div");
            div.className = "glass";
            div.innerHTML = `
                <div class="glass-bg" 
                    style="background-image:url('${ev.event_image || "https://images.unsplash.com/photo-1548013146-72479768bbaa?auto=format&fit=crop&q=80&w=500"}')">
                </div>
                <div class="glass-content">
                    <div class="glass-phase">Phase 0${i + 1}</div>
                    <div class="glass-title">${ev.name || "Event"}</div>
                    <div class="glass-sub">Premier B2B Expo</div>
                    <a href="{{ url('enquiry') }}" class="enquiry-btn">Enquiry</a>
                </div>
            `;
            track.appendChild(div);
        });
    }

    /* SLIDE */
    function slide() {
        // cardWidth includes width (180px) + margins (10px left + 10px right) = 200px
        const cardWidth = 200;

        index++;

        // If index reaches the end, reset to start
        if (index > cards.length - 1) {
            index = 0;
        }

        track.style.transform = `translateX(-${index * cardWidth}px)`;
    }

    function startSlider() {
        // Only start the interval if there are more than 4 cards
        // If 4 or fewer cards are present, they fit on most screens and don't need to slide
        if (cards.length > 4) {
            setInterval(slide, 2000);
        } else {
            // Optional: Reset transform just in case
            track.style.transform = `translateX(0)`;
        }
    }

    fetchCities();
</script>