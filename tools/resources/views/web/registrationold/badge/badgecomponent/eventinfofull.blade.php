<div class="event-wrapper">

    <style>
        .event-wrapper {
            width: 100%;
            font-family: "Playfair Display", "Georgia", serif;
            display: flex;
            justify-content: center;
        }

        .event-card {
            width: 100%;
            max-width: 600px;
            padding: 24px 0;
        }

        .event-card-body {
            display: flex;
            flex-direction: column;
            gap: 18px;
            text-align: center;
            align-items: center;
        }

        .event-name {
            font-size: 22px;
            font-weight: 700;
            color: #aa2324;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            line-height: 1.2;
            margin: 0;
            text-align: center;
        }

        /* center meta row */
        .event-meta {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 14px;
            flex-wrap: wrap;
        }

        .meta-venue-name {
            padding: 0px 10px;
            font-size: 15px;
            font-weight: 700;
            color: #aa2324;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            margin: 0;
            text-align: center;
        }

        .meta-days {
            font-size: 18px;
            font-weight: 700;
            color: #aa2324;
            letter-spacing: 0.08em;
            margin: 0;
            text-align: center;
            text-transform: uppercase;
        }



        .meta-month {
            font-size: 18px;
            font-weight: 700;
            color: #aa2324;
            letter-spacing: 0.08em;
            margin: 0;
            text-align: center;
            text-transform: uppercase;
            opacity: 0.75;
        }

        .meta-days,
        .meta-month {
            font-size: 18px;
            font-weight: 500;
            color: #aa2324;
            margin: 0;
            text-align: center;
            letter-spacing: 0.02em;
            text-transform: uppercase;
        }
    </style>

    @php
        $days = [];
        $month = '';

        foreach ($data['all_dates'] as $d) {
            $days[] = \Carbon\Carbon::parse($d)->format('d');
            $month = \Carbon\Carbon::parse($d)->format('F');
        }
    @endphp

    <div class="event-card">

        <div class="event-card-body">

            <p class="event-name">
                {{ $data['eventname'] }}
            </p>

            <div class="event-meta">

                <p class="meta-venue-name">
                    {{ $data['venue'] }}
                </p>

                <p class="meta-days">
                    {{ implode(' · ', $days) }}
                </p>

                <p class="meta-month">
                    {{ strtoupper($month) }}
                </p>

            </div>

        </div>

    </div>

</div>