<style>
    :root {
        --primary-color: #AA2D2C;
        --dark-color: #1a1a1a;
        --grey-color: #6b7280;
        --light-bg: #f3f7fa;
    }

    * {
        box-sizing: border-box;
        font-family: 'Inter', -apple-system, sans-serif;
    }

    .who-section {
        max-width: 1200px;
        margin: auto;
        padding: 60px 20px;
        background: #fff;
    }

    .who-label {
        font-size: 11px;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: var(--primary-color);
        font-weight: 700;
        margin-bottom: 10px;
        display: block;
    }

    .who-title {
        font-size: 36px;
        font-weight: 800;
        color: var(--dark-color);
        margin: 0 0 30px;
        line-height: 1.2;
    }

    .who-title em {
        color: var(--primary-color);
        font-style: normal;
    }

    .who-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 18px;
    }

    .who-item {
        background: var(--light-bg);
        padding: 24px;
        border-radius: 16px;
        border: 1px solid rgba(0, 0, 0, 0.04);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .who-item:hover {
        background: #fff;
        border-color: var(--primary-color);
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.06);
    }

    .who-num {
        width: 30px;
        height: 30px;
        border-radius: 8px;
        background: rgba(170, 45, 44, 0.1);
        color: var(--primary-color);
        font-size: 12px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 14px;
    }

    .who-item strong {
        display: block;
        font-size: 18px;
        color: var(--dark-color);
        margin-bottom: 8px;
        font-weight: 700;
    }

    .who-item p {
        font-size: 14px;
        color: var(--grey-color);
        line-height: 1.5;
        margin: 0;
    }

    .who-item::after {
        content: "";
        position: absolute;
        left: 0;
        bottom: 0;
        width: 0;
        height: 3px;
        background: var(--primary-color);
        transition: width 0.3s ease;
    }

    .who-item:hover::after {
        width: 100%;
    }

    @media (max-width: 992px) {
        .who-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 600px) {
        .who-grid {
            grid-template-columns: 1fr;
        }

        .who-title {
            font-size: 28px;
        }

        .who-section {
            padding: 45px 16px;
        }
    }
</style>

<section class="who-section">

    <span class="who-label">Exhibitor Profile</span>

    <h2 class="who-title"><em>Beneficial</em> for</h2>

    @php
        $whoItems = [
            ['Destinations', 'National & State Tourism Boards, Tourism Promotion Organizations.'],
            ['Travel Trade', 'Travel Agents, Tour Operators, DMCs, Group Travel Operators, Forex Dealers.'],
            ['Hospitality', 'Hotels, Resorts, Eco Camps, Spas, Ayurvedic Centres, Theme Parks, Clubs.'],
            ['Adventure Tourism', 'Aero & Aqua Sports, Trekking, Camping, Wildlife & Eco Tourism Operators.'],
            ['Transportation', 'Airlines, Railways, Cruise Lines, Car Rentals, Transport Operators.'],
            ['MICE Sector', 'Meetings, Incentives, Conferences, Exhibitions & Convention Centres.'],
            ['Technology', 'Travel Portals, Booking Systems, Hotel Reservation Networks.'],
            ['Others', 'Tourism Institutes, Insurance, Handicrafts, Photography, Publications, Forex.']
        ];
    @endphp

    <div class="who-grid">

        @foreach($whoItems as $i => $item)
            <div class="who-item">

                <div class="who-num">
                    {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}
                </div>

                <strong>{{ $item[0] }}</strong>

                <p>{{ $item[1] }}</p>

            </div>
        @endforeach

    </div>

</section>