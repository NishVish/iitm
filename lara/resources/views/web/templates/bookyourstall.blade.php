<style>
    .iitm-vp-box {
        max-width: 800px;
        margin: 20px auto;
        padding: 15px;
        border: 1px solid #eee;
        border-radius: 12px;
        font-family: sans-serif
    }

    .iitm-vp-tabs {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        margin-bottom: 15px
    }

    .iitm-vp-tabs button {
        padding: 8px 12px;
        border: 1px solid #A62322;
        background: #fff;
        border-radius: 6px;
        cursor: pointer
    }

    .iitm-vp-tabs button.active {
        background: #A62322;
        color: #fff
    }

    .iitm-vp-content {
        display: flex;
        gap: 20px;
        align-items: center
    }

    .iitm-vp-content img {
        width: 280px;
        height: 180px;
        object-fit: cover;
        border-radius: 10px
    }

    .iitm-vp-info h3 {
        margin: 0 0 10px;
        color: #A62322
    }

    .iitm-vp-info p {
        margin: 5px 0
    }

    @media(max-width:768px) {
        .iitm-vp-content {
            flex-direction: column
        }

        .iitm-vp-content img {
            width: 100%
        }
    }
</style>

<div class="iitm-vp-box">

    <div class="iitm-vp-content">
        <!-- <img id="iitmImg" src=""> -->
        <div class="iitm-vp-info">
            <h3 id="iitmName"></h3>
            <p><b>Year:</b> <span id="iitmYear"></span></p>
            <p><b>Venue:</b> <span id="iitmVenue"></span></p>
            <p><b>Access:</b> <span id="iitmAccess"></span></p>
            <p><b>Date:</b> <span id="iitmDate"></span></p>
            <button>Enquiry Now</button>
        </div>
    </div>
</div>

<script>
    let events = [], current = 0, slider;

    fetch("{{ url('api/events') }}")
        .then(r => r.json())
        .then(data => {
            events = data || [];

            // iitmTabs.innerHTML = events.map((e, i) =>
            //     `<button onclick="showEvent(${i},1)">${e.name || 'Event'}</button>`
            // ).join('');

            if (events.length) {
                showEvent(0);
                slider = setInterval(() => showEvent((current + 1) % events.length), 3000);
            }
        });

    function showEvent(i, restart = 0) {
        current = i;
        let e = events[i];

        iitmName.textContent = e.name || '';
        iitmYear.textContent = e.year || '';
        iitmVenue.textContent = e.venue_details || '';
        iitmAccess.textContent = e.venue_booking_details || '';
        // iitmImg.src = e.event_image || 'https://via.placeholder.com/600x300';

        iitmDate.textContent = (e.start_date && e.end_date)
            ? `${new Date(e.start_date).toDateString()} - ${new Date(e.end_date).toDateString()}`
            : 'TBA';

        document.querySelectorAll('#iitmTabs button')
            .forEach((b, x) => b.classList.toggle('active', x === i));

        if (restart) {
            clearInterval(slider);
            slider = setInterval(() => showEvent((current + 1) % events.length), 3000);
        }
    }
</script>