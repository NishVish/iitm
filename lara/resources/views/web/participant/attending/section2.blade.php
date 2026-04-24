<style>
    .event-module {
        max-width: 1100px;
        margin: 40px auto;
        padding: 30px;
        border: 1px solid rgba(170, 35, 36, .25);
        border-radius: 16px;
        background: #fff;
        font-family: Inter, sans-serif;
    }

    .event-module__header {
        text-align: center;
        margin-bottom: 25px;
    }

    .event-module__badge {
        display: inline-block;
        padding: 5px 10px;
        font-size: 11px;
        border-radius: 999px;
        background: #AA2324;
        color: #fff;
        margin-bottom: 8px;
    }

    .event-module__header h3 {
        margin: 0;
        font-size: 24px;
        color: #AA2324;
        font-weight: 800;
    }

    .event-module__header p {
        margin-top: 6px;
        font-size: 13px;
        opacity: .7;
    }

    .event-module__body {
        margin-top: 20px;
    }
</style>

<div class="event-module">

    <div class="event-module__header">
        <div class="event-module__badge">Live Events</div>
        <h3>Upcoming & Attending Listings</h3>
        <p>Discover active IITM event participation in real time</p>
    </div>

    <div class="event-module__body">
        @include('web.participant.attending.eventlisting')
    </div>


</div>