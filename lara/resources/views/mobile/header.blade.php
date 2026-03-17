
@php
    $nextEvent = $events->first();
    $eventStartDate = $nextEvent ? $nextEvent->start_date : null;
    $eventEndDate = $nextEvent ? $nextEvent->end_date : null;
@endphp

<div class="header">
    <style>
        .event-details {
            display: flex;
            flex-direction: column;
            font-family: system-ui, -apple-system, sans-serif;
        }

        .event-value {
            font-size: 2rem;
            font-weight: 600;
            color: white;
        }

        .event-label {
            font-size: 1.1rem;
            color: grey;
            letter-spacing: 0.5px;
        }
    </style>
    <div class="brand-logo">
        <img src="https://iitmindia.com/reg/iitm_chennai/logo.png" alt="Logo">
    </div>

    <div class="event-details">
        <span class="event-value" id="eventName">{{ $nextEvent->name ?? 'Loading...' }}</span>
        <span class="event-label">
            @if($eventStartDate)
                Next Event || {{ date('d', strtotime($eventStartDate)) }}-{{ date('d M', strtotime($eventEndDate)) }}
            @else
                Next Event || TBA
            @endif
        </span>
    </div>
    <div></div>
</div>

<style>
    /* --- Upgraded Stats Card with Countdown --- */
    .stats-container {
        padding: 0 20px;
        margin-top: -45px;
    }

    .stats-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border-radius: 25px;
        padding: 20px 10px;
        display: flex;
        justify-content: space-around;
        box-shadow: 0 15px 35px rgba(168, 35, 36, 0.15);
        border: 1px solid rgba(255, 255, 255, 0.5);
    }

    .stat-item {
        text-align: center;
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .stat-item:not(:last-child) {
        border-right: 1px solid rgba(168, 35, 36, 0.1);
    }

    .stat-value {
        display: block;
        font-weight: 800;
        font-size: 24px;
        color: #a82324;
        line-height: 1;
    }

    .stat-label {
        font-size: 10px;
        color: #7f8c8d;
        margin-top: 6px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
</style>

<div class="stats-container">
    <div class="stats-card">
        <div class="stat-item">
            <span class="stat-value" id="eventDays">--</span>
            <span class="stat-label">Days</span>
        </div>
        <div class="stat-item">
            <span class="stat-value" id="eventHours">--</span>
            <span class="stat-label">Hours</span>
        </div>
        <div class="stat-item">
            <span class="stat-value" id="eventMins">--</span>
            <span class="stat-label">Mins</span>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const targetDateStr = "{{ $eventStartDate }}";
        if (!targetDateStr) return;

        const eventDate = new Date(targetDateStr + " 00:00:00").getTime();
        const daysEl = document.getElementById('eventDays');
        const hoursEl = document.getElementById('eventHours');
        const minsEl = document.getElementById('eventMins');
        const nameEl = document.getElementById('eventName');

        function updateCountdown() {
            const now = new Date().getTime();
            const diff = eventDate - now;

            if (diff <= 0) {
                daysEl.innerText = "00";
                hoursEl.innerText = "00";
                minsEl.innerText = "00";
                nameEl.innerText = "Live Now!";
                return;
            }

            const days = Math.floor(diff / (1000 * 60 * 60 * 24));
            const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const mins = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));

            daysEl.innerText = String(days).padStart(2, '0');
            hoursEl.innerText = String(hours).padStart(2, '0');
            minsEl.innerText = String(mins).padStart(2, '0');
        }

        updateCountdown();
        setInterval(updateCountdown, 60000);
    });
</script>
    <div class="section-header">
    </div>
