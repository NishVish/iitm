<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premium Event Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
            --glass-bg: rgba(255, 255, 255, 0.8);
            --glass-border: rgba(255, 255, 255, 0.3);
        }

        body {
            font-family: 'Inter', sans-serif;
            background: radial-gradient(circle at top right, #e0e7ff, #f8fafc);
            min-height: 100vh;
            color: #1e293b;
        }

        .main-container {
            max-width: 800px;
            padding-top: 5rem;
        }

        h1 {
            font-weight: 800;
            letter-spacing: -1px;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 2rem;
        }

        .section-label {
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 700;
            color: #64748b;
            margin-bottom: 1.5rem;
        }

        .city-btn {
            border-radius: 50px;
            padding: 8px 20px;
            border: 1px solid #e2e8f0;
            background: white;
            color: #475569;
            font-weight: 500;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            margin-right: 8px;
            margin-bottom: 8px;
        }

        .city-btn:hover:not(.unavailable) {
            border-color: #6366f1;
            color: #6366f1;
            transform: translateY(-2px);
        }

        .city-btn.active {
            background: #6366f1;
            color: white !important;
            border-color: #6366f1;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }

        .unavailable {
            opacity: 0.4;
            background: #f1f5f9;
            cursor: not-allowed;
            border-style: dashed;
        }

        .event-card {
            background: var(--glass-bg);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.05);
            padding: 2rem;
            margin-bottom: 2rem;
            animation: slideUp 0.5s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .event-title {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1.5rem;
            margin: 1.5rem 0;
        }

        .info-label {
            font-size: 0.75rem;
            color: #94a3b8;
            text-transform: uppercase;
            display: block;
        }

        .info-value {
            font-weight: 600;
            color: #1e293b;
        }

        .register-btn {
            background: var(--primary-gradient);
            border: none;
            border-radius: 12px;
            padding: 12px 30px;
            font-weight: 600;
            color: white;
            width: 100%;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .register-btn:hover {
            transform: scale(1.02);
            box-shadow: 0 10px 20px rgba(124, 58, 237, 0.3);
            color: white;
        }

        .nav-btn {
            background: white;
            border: 1px solid #e2e8f0;
            color: #64748b;
            border-radius: 10px;
            padding: 8px 16px;
            font-weight: 600;
            transition: all 0.2s;
        }

        .nav-btn:hover {
            background: #f8fafc;
            color: #1e293b;
        }
    </style>
</head>

<body>
    <div class="container main-container">
        <h1 class="text-center">Discover Events</h1>

        <p class="section-label text-center">Select your location</p>
        <div class="d-flex flex-wrap justify-content-center mb-5" id="city-container"></div>

        <div class="event-card" id="event-card" style="display:none;">
            <div class="badge bg-primary mb-3" style="background: var(--primary-gradient) !important;">Upcoming Event
            </div>
            <h2 class="event-title" id="event-name"></h2>
            <div class="info-grid">
                <div>
                    <span class="info-label">Date Range</span>
                    <span class="info-value"><span id="event-start"></span> — <span id="event-end"></span></span>
                </div>
                <div>
                    <span class="info-label">Location</span>
                    <span class="info-value" id="event-venue"></span>
                </div>
            </div>
            <button class="btn register-btn mt-3" id="register-btn">Secure Your Spot</button>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-4">
            <button class="nav-btn" id="prev-event">← Previous</button>
            <span class="text-muted small fw-bold" id="event-counter"></span>
            <button class="nav-btn" id="next-event">Next →</button>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const majorCities = ["Mumbai", "Delhi", "Bengaluru", "Chennai", "Kolkata", "Hyderabad", "Pune", "Ahmedabad", "Jaipur"];
            const cityContainer = document.getElementById("city-container");
            const eventCard = document.getElementById("event-card");
            const eventName = document.getElementById("event-name");
            const eventVenue = document.getElementById("event-venue");
            const eventStart = document.getElementById("event-start");
            const eventEnd = document.getElementById("event-end");
            const registerBtn = document.getElementById("register-btn");
            const eventCounter = document.getElementById("event-counter");
            let events = [];
            let currentIndex = 0;

            // Fetch events from API
            fetch("{{ url('api/events') }}")
                .then(res => res.json())
                .then(data => {
                    events = data;

                    // Build city buttons
                    majorCities.forEach(city => {
                        const hasEvent = events.some(ev =>
                            (ev.venue_details && ev.venue_details.toLowerCase().includes(city.toLowerCase())) ||
                            (ev.name && ev.name.toLowerCase().includes(city.toLowerCase()))
                        );

                        const btn = document.createElement("button");
                        btn.className = `city-btn ${hasEvent ? "" : "unavailable"}`;
                        btn.innerText = city;
                        btn.dataset.city = city;

                        btn.onclick = () => {
                            if (hasEvent) {
                                currentIndex = events.findIndex(ev =>
                                    (ev.venue_details && ev.venue_details.toLowerCase().includes(city.toLowerCase())) ||
                                    (ev.name && ev.name.toLowerCase().includes(city.toLowerCase()))
                                );
                                updateUI();
                            }
                        };
                        cityContainer.appendChild(btn);
                    });

                    if (events.length > 0) updateUI();
                })
                .catch(err => {
                    console.error("Failed to fetch events:", err);
                    eventCard.style.display = "none";
                });

            function updateUI() {
                const ev = events[currentIndex];
                if (!ev) return;

                eventName.innerText = ev.name;
                eventVenue.innerText = ev.venue_details || "TBA";
                eventStart.innerText = new Date(ev.start_date).toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
                eventEnd.innerText = new Date(ev.end_date).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
                eventCounter.innerText = `${currentIndex + 1} of ${events.length}`;
                eventCard.style.display = "block";

                // Update register button to forward to /register/{id}
                registerBtn.onclick = () => {
                    window.location.href = "{{ url('register') }}/" + ev.name;
                };

                // Highlight active city pill
                document.querySelectorAll('.city-btn').forEach(b => b.classList.remove('active'));
                const activeCity = majorCities.find(c => (ev.venue_details && ev.venue_details.includes(c)) || (ev.name && ev.name.includes(c)));
                if (activeCity) {
                    document.querySelector(`[data-city="${activeCity}"]`).classList.add('active');
                }
            }

            document.getElementById("prev-event").onclick = () => {
                if (events.length === 0) return;
                currentIndex = (currentIndex - 1 + events.length) % events.length;
                updateUI();
            };
            document.getElementById("next-event").onclick = () => {
                if (events.length === 0) return;
                currentIndex = (currentIndex + 1) % events.length;
                updateUI();
            };
        });
    </script>
</body>

</html>