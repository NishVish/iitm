<div>

    <footer style="padding:15px; text-align:center; background:#0f172a; color:white;">
        &copy; <?php echo date("Y"); ?> Sphere Travelmedia. All Rights Reserved;

        <button onclick="openEntryBadge()" style="
            margin-left:12px;
            padding:8px 14px;
            border:none;
            border-radius:8px;
            cursor:pointer;
            background:#2563eb;
            color:white;
            font-weight:bold;
        ">
            Get Entry Badge
        </button>
    </footer>

    <!-- MODAL -->
    <div id="entryBadgeModal" style="
        display:none;
        position:fixed;
        inset:0;
        background:rgba(0,0,0,0.75);
        z-index:9999;
        align-items:center;
        justify-content:center;
    ">

        <div style="
            width:450px;
            max-width:90%;
            background:white;
            border-radius:14px;
            padding:20px;
        ">

            <h3 style="margin-bottom:12px;">Get Entry Badge</h3>

            <label style="font-size:13px;font-weight:bold;">Select Event</label>

            <select id="eventSelect" style="
                width:100%;
                padding:10px;
                margin-top:6px;
                margin-bottom:15px;
                border:1px solid #ccc;
                border-radius:8px;
            ">
                <option>Loading...</option>
            </select>

            <div id="eventPreview" style="
                font-size:13px;
                margin-bottom:15px;
                color:#333;
                line-height:1.5;
            "></div>

            <form method="POST" action="{{ url('/visitor-form') }}">
                @csrf

                <input type="hidden" name="event_id" id="event_id">
                <input type="hidden" name="event_name" id="event_name">
                <input type="hidden" name="venue" id="venue">
                <input type="hidden" name="start_date" id="start_date">
                <input type="hidden" name="end_date" id="end_date">

                <input type="text" name="input" required placeholder="Mobile / Email"
                    style="width:100%;padding:10px;border:1px solid #ccc;border-radius:8px;">

                <button type="submit" style="
                    margin-top:15px;
                    width:100%;
                    padding:12px;
                    border:none;
                    border-radius:8px;
                    background:#111827;
                    color:white;
                    font-weight:bold;
                    cursor:pointer;
                ">
                    Submit & Get OTP
                </button>

            </form>

            <button onclick="closeEntryBadge()" style="
                margin-top:10px;
                width:100%;
                padding:10px;
                border:none;
                border-radius:8px;
                background:#e5e7eb;
                cursor:pointer;
            ">
                Close
            </button>

        </div>

    </div>

    <script>
        let events = [];

        async function openEntryBadge() {
            document.getElementById("entryBadgeModal").style.display = "flex";

            const res = await fetch("{{ url('/api/events') }}");
            const data = await res.json();

            // remove empty / invalid only (NO TBA DISPLAYED)
            events = data.filter(e =>
                e.name &&
                e.venue_details &&
                e.start_date &&
                e.venue_details.toLowerCase() !== "tba"
            );

            const select = document.getElementById("eventSelect");

            select.innerHTML =
                `<option value="">-- Select Event --</option>` +
                events.map(e => `
                    <option value="${e.event_id || e.id}">
                        ${e.name}
                    </option>
                `).join("");

            select.onchange = function () {
                const ev = events.find(x => (x.event_id || x.id) == this.value);

                if (!ev) return;

                document.getElementById("event_id").value = ev.event_id || ev.id;
                document.getElementById("event_name").value = ev.name;
                document.getElementById("venue").value = ev.venue_details;
                document.getElementById("start_date").value = ev.start_date;
                document.getElementById("end_date").value = ev.end_date;

                document.getElementById("eventPreview").innerHTML = `
                    <b>${ev.name}</b><br>
                    ${ev.venue_details}<br>
                    ${new Date(ev.start_date).toDateString()} → ${new Date(ev.end_date).toDateString()}
                `;
            };
        }

        function closeEntryBadge() {
            document.getElementById("entryBadgeModal").style.display = "none";
        }
    </script>

</div>