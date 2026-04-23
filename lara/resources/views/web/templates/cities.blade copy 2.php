<div id="iitm-dossier-system">
    <style>
        #iitm-dossier-system {
            display: flex;
            max-width: 1200px;
            margin: 40px auto;
            background: #fff;
            border: 1px solid #eee;
            font-family: 'Inter', sans-serif;
            height: 600px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.05);
        }

        /* Left Side: Navigation Tabs */
        .city-nav {
            flex: 0.4;
            background: #f9f9f9;
            border-right: 1px solid #eee;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
        }

        .city-tab {
            padding: 25px 30px;
            cursor: pointer;
            border-bottom: 1px solid #eee;
            transition: all 0.3s;
            position: relative;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .city-tab:hover {
            background: #fff;
        }

        .city-tab.active {
            background: #fff;
            border-left: 5px solid #aa2324;
        }

        .city-tab b {
            font-family: Georgia, serif;
            font-size: 1.2rem;
            color: #333;
        }

        .city-tab span {
            font-size: 0.7rem;
            color: #999;
            text-transform: uppercase;
            font-weight: 700;
        }

        /* Right Side: The Master Card */
        .dossier-display {
            flex: 1;
            padding: 50px;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
        }

        .card-inner {
            width: 100%;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.5s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        .card-inner.active {
            opacity: 1;
            transform: translateY(0);
        }

        .dossier-year {
            position: absolute;
            top: -10px;
            right: 20px;
            font-size: 8rem;
            font-family: Georgia, serif;
            color: #f6f6f6;
            font-weight: 900;
            z-index: 0;
        }

        .badge-red {
            background: #aa2324;
            color: #fff;
            padding: 4px 12px;
            font-size: 0.65rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 20px;
            display: inline-block;
        }

        .dossier-name {
            font-family: Georgia, serif;
            font-size: 3.5rem;
            margin: 0 0 30px;
            color: #111;
            position: relative;
            z-index: 1;
        }

        .dossier-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            border-top: 1px solid #eee;
            padding-top: 40px;
        }

        .dossier-item b {
            display: block;
            font-size: 0.7rem;
            text-transform: uppercase;
            color: #aa2324;
            margin-bottom: 8px;
            letter-spacing: 1px;
        }

        .dossier-item p {
            font-size: 1.05rem;
            margin: 0;
            color: #444;
            line-height: 1.5;
            font-weight: 500;
        }

        /* Mobile View */
        @media (max-width: 768px) {
            #iitm-dossier-system {
                flex-direction: column;
                height: auto;
            }

            .city-nav {
                flex-direction: row;
                overflow-x: auto;
                height: 80px;
            }

            .city-tab {
                padding: 10px 20px;
                white-space: nowrap;
                border-bottom: none;
                border-right: 1px solid #eee;
            }

            .dossier-name {
                font-size: 2.5rem;
            }

            .dossier-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="city-nav" id="cityNav">
    </div>

    <div class="dossier-display">
        <div class="dossier-year" id="d-year">2026</div>
        <div class="card-inner" id="cardInner">
            <span class="badge-red">Exhibition Details</span>
            <h2 class="dossier-name" id="d-name">Loading...</h2>

            <div class="dossier-grid">
                <div class="dossier-item">
                    <b>Venue</b>
                    <p id="d-venue">--</p>
                </div>
                <div class="dossier-item">
                    <b>Schedule</b>
                    <p id="d-dates">--</p>
                </div>
                <div class="dossier-item">
                    <b>Organizer</b>
                    <p id="d-coordinator">--</p>
                </div>
                <div class="dossier-item">
                    <b>B2B Status</b>
                    <p id="d-b2b">--</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    async function initDossier() {
        const nav = document.getElementById('cityNav');
        let events = [];

        try {
            // Adjust API URL if needed
            const res = await fetch("{{ url('api/events') }}");
            if (!res.ok) throw new Error('API Error');
            events = await res.json();
        } catch (e) {
            // Fallback sample data if API fails
            events = [
                { name: "Bengaluru", year: 2026, venue_details: "Tripura Vasini, Palace Grounds", start_date: "2026-07-24", end_date: "2026-07-26", coordinator: "Zeeshan Khan", b2b_constrain: "Open for B2B/B2C" },
                { name: "Mumbai", year: 2026, venue_details: "Jio World Convention Centre", start_date: "2026-09-12", end_date: "2026-09-14", coordinator: "Anita Desai", b2b_constrain: "B2B Only" },
                { name: "Delhi", year: 2026, venue_details: "Constitution Club of India", start_date: "2026-10-05", end_date: "2026-10-07", coordinator: "Rajesh Gupta", b2b_constrain: "Open for B2B/B2C" }
            ];
        }

        events.forEach((ev, i) => {
            const tab = document.createElement('div');
            tab.className = `city-tab ${i === 0 ? 'active' : ''}`;
            tab.innerHTML = `<b>${ev.name}</b> <span>${ev.year || '2026'}</span>`;

            tab.onclick = () => {
                document.querySelectorAll('.city-tab').forEach(t => t.classList.remove('active'));
                tab.classList.add('active');
                updateCard(ev);
            };
            nav.appendChild(tab);
        });

        if (events.length > 0) updateCard(events[0]);
    }

    function updateCard(ev) {
        const inner = document.getElementById('cardInner');
        inner.classList.remove('active');

        setTimeout(() => {
            document.getElementById('d-year').innerText = ev.year || '2026';
            document.getElementById('d-name').innerText = ev.name;
            document.getElementById('d-venue').innerText = ev.venue_details || 'TBA';
            document.getElementById('d-dates').innerText = `${ev.start_date} - ${ev.end_date}`;
            document.getElementById('d-coordinator').innerText = ev.coordinator || 'IITM Exhibition Desk';
            document.getElementById('d-b2b').innerText = ev.b2b_constrain || 'Standard Entry';

            inner.classList.add('active');
        }, 200);
    }

    initDossier();
</script>