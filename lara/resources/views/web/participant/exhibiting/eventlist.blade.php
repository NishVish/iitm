<style>
    /* Scope wrapper box layout styles */
    .iitm-vp-slider-box {
        max-width: 1000px;
        margin: 30px auto;
        padding: 24px;
        background: #ffffff;
        border: 1px solid rgba(166, 35, 34, 0.2);
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
    }

    .iitm-vp-btn-wrapper {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        padding-bottom: 20px;
        border-bottom: 1px solid #eeeeee;
        margin-bottom: 24px;
    }

    .iitm-vp-btn-wrapper button {
        padding: 10px 16px;
        border: 1px solid rgba(166, 35, 34, 0.3);
        border-radius: 8px;
        cursor: pointer;
        background: #ffffff;
        color: #222222;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .iitm-vp-btn-wrapper button.iitm-vp-active-btn {
        background: #A62322;
        color: #ffffff;
        border-color: #A62322;
    }

    .iitm-vp-columns {
        display: flex;
        gap: 30px;
        align-items: center;
    }

    .iitm-vp-col-image {
        width: 45%;
        flex-shrink: 0;
    }

    .iitm-vp-img-element {
        width: 100%;
        height: 300px;
        object-fit: cover;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }

    .iitm-vp-col-details {
        flex: 1;
    }

    .iitm-vp-col-details h2 {
        margin: 0 0 15px 0;
        font-size: 24px;
        color: #A62322;
        font-weight: 800;
    }

    .iitm-vp-col-details p {
        margin: 10px 0;
        color: #555555;
        font-size: 15px;
        line-height: 1.5;
    }

    .iitm-vp-col-details strong {
        color: #222222;
        display: inline-block;
        width: 80px;
    }

    /* Responsive scaling for compact viewports */
    @media (max-width: 768px) {
        .iitm-vp-columns {
            flex-direction: column;
            gap: 20px;
        }

        .iitm-vp-col-image {
            width: 100%;
        }
    }
</style>

<div class="iitm-vp-slider-box">

    <div id="iitm-vp-eventButtons" class="iitm-vp-btn-wrapper"></div>

    <div id="iitm-vp-eventPage" class="iitm-vp-columns">

        <div class="iitm-vp-col-image">
            <img id="iitm-vp-eventImage" class="iitm-vp-img-element" src="" alt="Event Presentation Display">
        </div>

        <div class="iitm-vp-col-details">
            <h2 id="iitm-vp-eventName"></h2>
            <p><strong>Year:</strong> <span id="iitm-vp-eventYear"></span></p>
            <p><strong>Venue:</strong> <span id="iitm-vp-eventVenue"></span></p>
            <p><strong>Access:</strong> <span id="iitm-vp-eventAccess"></span></p>
            <p><strong>Date:</strong> <span id="iitm-vp-eventDate"></span></p>
            <style>
                .iitm-enquiry-btn {
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                    background: linear-gradient(135deg, #A62322, #c92c2a);
                    color: #fff;
                    border: 2px solid #A62322;
                    padding: 12px 22px;
                    font-size: 16px;
                    font-weight: 700;
                    border-radius: 10px;
                    cursor: pointer;
                    text-decoration: none;
                    transition: all 0.25s ease;
                    box-shadow: 0 4px 10px rgba(166, 35, 34, 0.25);
                    gap: 8px;
                }

                .iitm-enquiry-btn:hover {
                    background: #fff;
                    color: #A62322;
                    transform: translateY(-2px);
                    box-shadow: 0 10px 22px rgba(166, 35, 34, 0.35);
                }

                .iitm-enquiry-btn:active {
                    transform: translateY(0);
                    box-shadow: 0 3px 8px rgba(166, 35, 34, 0.2);
                }

                .iitm-enquiry-btn a {
                    text-decoration: none;
                    color: inherit;
                    display: block;
                    width: 100%;
                    height: 100%;
                }
            </style>

            <a class="iitm-enquiry-btn" href="{{ url('enquiry') }}">
                Enquiry Now
            </a>
        </div>

    </div>

</div>

<script>
    let iitmVpEvents = [];
    let iitmVpIndex = 0;
    let iitmVpSliderInterval = null;

    fetch("{{ url('api/events') }}")
        .then(res => res.json())
        .then(data => {
            iitmVpEvents = data || [];
            renderIitmVpButtons();

            if (iitmVpEvents.length) {
                showIitmVpEvent(0);
                startIitmVpAutoSlide();
            }
        })
        .catch(err => console.error(err));

    /* ---------------- BUTTONS ---------------- */
    function renderIitmVpButtons() {
        const wrap = document.getElementById("iitm-vp-eventButtons");
        wrap.innerHTML = "";

        iitmVpEvents.forEach((ev, i) => {
            const btn = document.createElement("button");
            btn.innerText = ev.name || "Event";

            btn.onclick = () => {
                iitmVpIndex = i;
                showIitmVpEvent(iitmVpIndex);
                restartIitmVpAutoSlide();
            };

            wrap.appendChild(btn);
        });
    }

    /* ---------------- SHOW EVENT WITH ACTIVE CLASS ---------------- */
    function showIitmVpEvent(i) {
        const ev = iitmVpEvents[i];
        if (!ev) return;

        // Toggle active styling states across buttons
        const buttons = document.querySelectorAll("#iitm-vp-eventButtons button");
        buttons.forEach((btn, bIndex) => {
            if (bIndex === i) {
                btn.classList.add("iitm-vp-active-btn");
            } else {
                btn.classList.remove("iitm-vp-active-btn");
            }
        });

        document.getElementById("iitm-vp-eventName").innerText = ev.name || "Untitled Event";
        document.getElementById("iitm-vp-eventYear").innerText = ev.year || "2026";
        document.getElementById("iitm-vp-eventVenue").innerText = ev.venue_details || "TBA";
        document.getElementById("iitm-vp-eventAccess").innerText = ev.venue_booking_details || "General Access";

        document.getElementById("iitm-vp-eventImage").src =
            ev.event_image || "https://via.placeholder.com/600x300";

        if (ev.start_date && ev.end_date) {
            const start = new Date(ev.start_date).toDateString();
            const end = new Date(ev.end_date).toDateString();
            document.getElementById("iitm-vp-eventDate").innerText = `${start} - ${end}`;
        } else {
            document.getElementById("iitm-vp-eventDate").innerText = "TBA";
        }
    }

    /* ---------------- AUTO SLIDER ---------------- */
    function startIitmVpAutoSlide() {
        iitmVpSliderInterval = setInterval(() => {
            iitmVpIndex = (iitmVpIndex + 1) % iitmVpEvents.length;
            showIitmVpEvent(iitmVpIndex);
        }, 3000);
    }

    function restartIitmVpAutoSlide() {
        clearInterval(iitmVpSliderInterval);
        startIitmVpAutoSlide();
    }
</script>