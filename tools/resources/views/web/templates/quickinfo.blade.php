<div class="iitm-main-wrapper">
    <style>
        /* Scoped styles to prevent interference with your other site CSS */
        .iitm-main-wrapper {
            width: 100%;
            background: #ffffff;
            border-bottom: 2px solid #f0f0f0;
            padding: 20px 10px;
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        }

        .iitm-event-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 40px;
        }

        /* Branding Colors */
        :root {
            --iitm-maroon: #A92324;
            --iitm-dark: #222222;
        }

        /* Button Styling */
        .iitm-btn {
            padding: 14px 28px;
            border: 2px solid var(--iitm-maroon);
            border-radius: 6px;
            cursor: pointer;
            font-weight: 700;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            white-space: nowrap;
            background: #ffffff;
            color: var(--iitm-maroon);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
        }

        .iitm-btn:hover {
            background: var(--iitm-maroon);
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(169, 35, 36, 0.2);
        }

        /* Event Box Styling */
        .iitm-event-box {
            text-align: center;
            min-width: 300px;
        }

        .iitm-event-title {
            font-size: 28px;
            font-weight: 800;
            color: var(--iitm-maroon);
            margin: 0;
            line-height: 1.1;
            text-transform: uppercase;
        }

        .iitm-event-dates {
            margin-top: 8px;
            font-size: 16px;
            font-weight: 500;
            color: #666;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .iitm-date-arrow {
            color: var(--iitm-maroon);
            font-weight: bold;
        }

        /* Responsive Design for Mobile */
        @media (max-width: 900px) {
            .iitm-event-container {
                flex-direction: column;
                gap: 20px;
                text-align: center;
            }

            .iitm-event-box {
                order: -1;
                /* Keeps Title/Date at the top on mobile */
            }

            .iitm-btn {
                width: 100%;
                max-width: 300px;
            }
        }
    </style>

    <div class="iitm-event-container">
        <a href="{{ url('exhibiting') }}" class="iitm-btn">
            Book Stall & Promote
        </a>

        <div id="iitmDynamicEvent">
            <div class="iitm-event-box">
                <div class="iitm-event-title">IITM EXHIBITION</div>
                <div class="iitm-event-dates">Loading Event Details...</div>
            </div>
        </div>

        <a href="{{ url('attending') }}" class="iitm-btn">
            Visit & Grow Network
        </a>
    </div>

    <script>
        (function () {
            const displayDiv = document.getElementById("iitmDynamicEvent");

            fetch("{{ url('api/events') }}")
                .then(res => {
                    if (!res.ok) throw new Error('API Offline');
                    return res.json();
                })
                .then(data => {
                    // Adjust this based on your API structure (e.g., data[0] or data.events[0])
                    const event = Array.isArray(data) ? data[0] : data;

                    if (!event || !event.name) {
                        renderMessage("Next Event Coming Soon");
                        return;
                    }

                    displayDiv.innerHTML = `
                        <div class="iitm-event-box">
                            <div class="iitm-event-title">${event.name}</div>
                            <div class="iitm-event-dates">
                                <span>${event.start_date}</span>
                                <span class="iitm-date-arrow">&rarr;</span>
                                <span>${event.end_date}</span>
                            </div>
                        </div>
                    `;
                })
                .catch(err => {
                    console.error("IITM API Error:", err);
                    renderMessage("India International Travel Mart");
                });

            function renderMessage(msg) {
                displayDiv.innerHTML = `
                    <div class="iitm-event-box">
                        <div class="iitm-event-title">${msg}</div>
                        <div class="iitm-event-dates">Global Travel & Tourism Exhibition</div>
                    </div>
                `;
            }
        })();
    </script>
</div>