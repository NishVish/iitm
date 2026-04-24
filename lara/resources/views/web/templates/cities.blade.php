<div id="iitm-compact-ledger">
    <style>
        #iitm-compact-ledger {
            max-width: 900px;
            margin: 0px auto;
            font-family: 'Inter', sans-serif;
            background: #fff;
            border: 1px solid #e0e0e0;
        }

        /* Header: High Density */
        .ledger-head {
            display: grid;
            grid-template-columns: 1.5fr 1fr 0.5fr;
            background: #f4f4f4;
            padding: 12px 25px;
            border-bottom: 2px solid #aa2324;
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: 800;
            color: #555;
        }

        /* Rows: Ultra Slim */
        .ledger-row {
            display: grid;
            grid-template-columns: 1.5fr 1fr 0.5fr;
            align-items: center;
            padding: 15px 25px;
            border-bottom: 1px solid #f0f0f0;
            transition: background 0.2s;
            cursor: pointer;
        }

        .ledger-row:hover {
            background: #fffcfc;
        }

        .ledger-row:last-child {
            border-bottom: none;
        }

        /* City Style */
        .l-city {
            font-family: Georgia, serif;
            font-size: 1.2rem;
            font-weight: 700;
            color: #111;
        }

        /* Date Style */
        .l-date {
            font-size: 0.9rem;
            font-weight: 500;
            color: #444;
        }

        /* Year Style */
        .l-year {
            text-align: right;
            font-size: 0.85rem;
            font-weight: 700;
            color: #aa2324;
            /* IITM Red */
        }

        /* Accent left border on hover */
        .ledger-row {
            position: relative;
        }

        .ledger-row::after {
            content: '';
            position: absolute;
            left: 0;
            width: 0;
            height: 100%;
            background: #aa2324;
            transition: width 0.2s;
        }

        .ledger-row:hover::after {
            width: 4px;
        }

        @media (max-width: 600px) {
            .ledger-head {
                display: none;
            }

            .ledger-row {
                padding: 15px;
            }

            .l-city {
                font-size: 1.1rem;
            }
        }
    </style>

    <div class="ledger-head">
        <div>Location</div>
        <div>Dates</div>
        <div style="text-align: right;">Year</div>
    </div>

    <div id="ledger-body">
    </div>
    <div class="button" style="text-align: center;">
        <a href="{{ url('enquiry') }}" class="enquire-btn">
            Enquire Now
        </a>
    </div>

    <style>
        .enquire-btn {
            display: inline-block;
            padding: 12px 28px;
            background: #aa2324;
            color: #fff;
            text-decoration: none;
            font-weight: 600;
            letter-spacing: 1px;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .enquire-btn:hover {
            background: #8f1d1e;
            transform: translateY(-2px);
        }
    </style>
</div>

<script>
    async function loadCompactLedger() {
        const body = document.getElementById('ledger-body');
        let events = [];

        try {
            const res = await fetch("{{ url('api/events') }}");
            events = await res.json();
        } catch (e) {
            // Fallback sample data
            events = [
                { name: "Bengaluru", start_date: "24 July", end_date: "26 July", year: "2026" },
                { name: "Mumbai", start_date: "12 Sept", end_date: "14 Sept", year: "2026" },
                { name: "Delhi", start_date: "05 Oct", end_date: "07 Oct", year: "2026" },
                { name: "Chennai", start_date: "15 Nov", end_date: "17 Nov", year: "2026" },
                { name: "Kochi", start_date: "22 Jan", end_date: "24 Jan", year: "2027" }
            ];
        }

        events.forEach(ev => {
            const row = document.createElement('div');
            row.className = 'ledger-row';
            row.innerHTML = `
                <div class="l-city">${ev.name}</div>
                <div class="l-date">${ev.start_date} - ${ev.end_date}</div>
                <div class="l-year">${ev.year || '2026'}</div>
            `;
            body.appendChild(row);
        });
    }

    loadCompactLedger();
</script>