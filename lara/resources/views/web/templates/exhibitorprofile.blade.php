{{-- ── EXHIBITOR PROFILES ── --}}
<section class="ex-section">
    <div class="ex-label">Exhibitors Profile</div>

    <div class="ex-profile-intro">
        <h2 class="ex-profile-title">Key <em>Exhibitor</em><br>Categories</h2>
        <p class="ex-profile-desc">From national tourism boards to adventure sports operators, IITM brings together
            the full spectrum of the travel and tourism industry. Whether you represent a boutique resort or a
            multinational airline, there's a place for you here.</p>
    </div>

    @php
        $profiles = [
            ['icon' => '✈️', 'title' => 'Key Exhibitors', 'desc' => 'National Tourist Organizations & State Tourism Promotion Boards. Trade & Financial Institutions.'],
            ['icon' => '🚢', 'title' => 'Transportation', 'desc' => 'Airlines, Charters, Railways, Passenger Transporters, Car Rentals, Shipping, Cruise liners, Travel Agents, Tour Operators, Group Travel Operators, Foreign Exchange dealers, Destination Management Companies.'],
            ['icon' => '💻', 'title' => 'Technology Providers', 'desc' => 'Travel Portals, Hotel Reservation Networks, Hotels & Resorts, Wildlife & Golf Resorts, Eco Tourism Camps, Health Spas, Ayurvedic Centers, Time-Share Resorts, Corporate Clubs, Amusement Theme Parks.'],
            ['icon' => '🧗', 'title' => 'Adventure Sports', 'desc' => 'Aero & Aqua Sports, Terrestrial Adventure Operators including Trekking, Mountaineering, Jungle Camping, Adventure Gears, and Wildlife & Eco Tourism Resorts.'],
            ['icon' => '🎒', 'title' => 'Travel Accessories', 'desc' => 'Exchange, Baggage Manufacturers, Photography Equipment, Accessories, Handicrafts, Specialty Vehicles & Publications.'],
            ['icon' => '🏥', 'title' => 'Others', 'desc' => 'Hospitality and Tourism Institutions, Healthcare and Travel Insurance Services, MICE Operators, Conventions and Exhibition Centers, Holiday Packages & Financers.'],
        ];
    @endphp

    <div class="ex-profiles-grid">
        @foreach($profiles as $i => $profile)
            <div class="ex-profile-card ex-fade-up" style="transition-delay:{{ $i * 0.07 }}s;">
                <div class="ex-profile-icon">{{ $profile['icon'] }}</div>
                <h3>{{ $profile['title'] }}</h3>
                <p>{{ $profile['desc'] }}</p>
            </div>
        @endforeach
    </div>
</section>