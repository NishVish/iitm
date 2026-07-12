<div id="iitm-event-cards">
    <style>
        #iitm-event-cards {
            max-width: 1200px;
            margin: 0 auto;
            font-family: 'Inter', sans-serif;
        }

        .event-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
        }

        .event-card {
            background: #fff;
            border: 1px solid #e8e8e8;
            border-radius: 14px;
            padding: 22px;
            transition: .25s ease;
            position: relative;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0, 0, 0, .05);
        }

        .event-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: #aa2324;
        }

        .event-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 18px 40px rgba(0, 0, 0, .12);
        }

        .event-city {
            font-size: 1.35rem;
            font-weight: 700;
            color: #111;
            margin-bottom: 15px;
        }

        .event-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            font-size: .95rem;
        }

        .event-label {
            color: #777;
            font-weight: 600;
        }

        .event-value {
            color: #222;
            font-weight: 600;
            text-align: right;
        }

        .event-year {
            display: inline-block;
            margin-top: 18px;
            background: #aa2324;
            color: #fff;
            padding: 7px 16px;
            border-radius: 30px;
            font-size: .85rem;
            font-weight: 700;
        }

        .button {
            text-align: center;
            margin: 35px 0 20px;
        }

        .enquire-btn {
            display: inline-block;
            padding: 12px 30px;
            background: #aa2324;
            color: #fff;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: .3s;
        }

        .enquire-btn:hover {
            background: #8f1d1e;
            transform: translateY(-2px);
        }

        @media (max-width:768px) {
            .event-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div id="event-grid" class="event-grid"></div>

    <div class="button">
        <a href="{{ url('enquiry') }}" class="enquire-btn">
            Enquire Now
        </a>
    </div>
</div>

<script>
    async function loadCompactLedger() {
        const body = document.getElementById('event-grid');
        let events = [];

        try {
            const res = await fetch("{{ url('api/events') }}");
            events = await res.json();
        } catch (e) {
            events = [
                { name: "Bengaluru", start_date: "24 July", end_date: "26 July", year: "2026" },
                { name: "Mumbai", start_date: "12 Sept", end_date: "14 Sept", year: "2026" },
                { name: "Delhi", start_date: "05 Oct", end_date: "07 Oct", year: "2026" },
                { name: "Chennai", start_date: "15 Nov", end_date: "17 Nov", year: "2026" },
                { name: "Kochi", start_date: "22 Jan", end_date: "24 Jan", year: "2027" }
            ];
        }

        body.innerHTML = "";
        events.forEach(ev => {
            const city = (ev.name || "").replace(/^IITM\s+/i, "");

            const card = document.createElement("div");
            card.className = "event-card";

            card.innerHTML = `
        <div class="event-city">${city}</div>

        <div class="event-info">
            <span class="event-label">Dates</span>
            <span class="event-value">${ev.start_date} - ${ev.end_date}</span>
        </div>

        <div class="event-info">
            <span class="event-label">Venue</span>
            <span class="event-value">${ev.venue_details || "TBA"}</span>
        </div>

        <div style="display:flex;justify-content:space-between;align-items:center;margin-top:18px;">
            <span class="event-year">${ev.year || "2026"}</span>

<a href="{{ url('trade') }}/${encodeURIComponent(city).toLowerCase()}" class="register-btn">
    Register
</a>        </div>
    `;

            body.appendChild(card);
        });
    }
    loadCompactLedger();
</script>