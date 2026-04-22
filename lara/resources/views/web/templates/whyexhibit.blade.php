<style>
    @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=DM+Sans:wght@300;400;500&display=swap');

    :root {
        --ink: #0e0c0a;
        --cream: #f7f3ee;
        --warm: #e8e0d5;
        --red: rgb(179, 66, 65);
        --red-light: rgba(179, 66, 65, 0.08);
        --red-mid: rgba(179, 66, 65, 0.18);
        --gold: #c4a063;
        --muted: #7a7068;
    }

    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    .ex-page {
        background: var(--cream);
        color: var(--ink);
        font-family: 'DM Sans', sans-serif;
        overflow-x: hidden;
    }

    /* ── HERO ── */
    .ex-hero {
        min-height: 72vh;
        background: var(--ink);
        display: flex;
        align-items: flex-end;
        padding: 0 6vw 80px;
        position: relative;
        overflow: hidden;
    }

    .ex-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background:
            radial-gradient(ellipse 60% 60% at 80% 40%, rgba(179, 66, 65, 0.18) 0%, transparent 70%),
            radial-gradient(ellipse 40% 50% at 10% 80%, rgba(196, 160, 99, 0.12) 0%, transparent 60%);
    }

    .ex-hero-grid {
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(255, 255, 255, 0.03) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
        background-size: 60px 60px;
    }

    .ex-hero-content {
        position: relative;
        z-index: 2;
        max-width: 900px;
    }

    .ex-breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 11px;
        letter-spacing: 2.5px;
        text-transform: uppercase;
        color: var(--gold);
        margin-bottom: 32px;
        font-family: 'DM Sans', sans-serif;
        font-weight: 500;
    }

    .ex-breadcrumb span {
        color: rgba(255, 255, 255, 0.35);
    }

    .ex-hero h1 {
        font-family: 'Cormorant Garamond', serif;
        font-size: clamp(3rem, 7vw, 6.5rem);
        font-weight: 300;
        color: #fff;
        line-height: 1.05;
        letter-spacing: -1px;
        margin-bottom: 28px;
    }

    .ex-hero h1 em {
        font-style: italic;
        color: var(--gold);
    }

    .ex-hero-sub {
        font-size: 15px;
        color: rgba(255, 255, 255, 0.5);
        max-width: 520px;
        line-height: 1.7;
        letter-spacing: 0.2px;
    }

    .ex-hero-line {
        width: 48px;
        height: 1px;
        background: var(--gold);
        margin: 28px 0;
    }

    /* ── SECTION WRAPPER ── */
    .ex-section {
        padding: 100px 6vw;
    }

    .ex-section-alt {
        background: var(--ink);
        color: #fff;
    }

    /* ── SECTION LABEL ── */
    .ex-label {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        font-size: 10px;
        letter-spacing: 3px;
        text-transform: uppercase;
        font-weight: 500;
        color: var(--red);
        margin-bottom: 20px;
        font-family: 'DM Sans', sans-serif;
    }

    .ex-label::before {
        content: '';
        display: block;
        width: 32px;
        height: 1px;
        background: var(--red);
    }

    .ex-section-alt .ex-label {
        color: var(--gold);
    }

    .ex-section-alt .ex-label::before {
        background: var(--gold);
    }

    /* ── ABOUT SECTION ── */
    .ex-about-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 80px;
        align-items: start;
        margin-top: 20px;
    }

    .ex-about-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: clamp(2rem, 4vw, 3.5rem);
        font-weight: 300;
        line-height: 1.15;
        letter-spacing: -0.5px;
        color: var(--ink);
    }

    .ex-about-title strong {
        font-weight: 600;
        color: var(--red);
    }

    .ex-about-body {
        font-size: 15px;
        line-height: 1.85;
        color: var(--muted);
    }

    .ex-about-body p+p {
        margin-top: 20px;
    }

    .ex-about-body strong {
        color: var(--ink);
        font-weight: 500;
    }

    .ex-assoc {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 32px;
    }

    .ex-assoc-tag {
        font-size: 11px;
        font-weight: 500;
        letter-spacing: 1px;
        padding: 5px 14px;
        border: 1px solid rgba(179, 66, 65, 0.3);
        border-radius: 2px;
        color: var(--red);
        background: var(--red-light);
        text-transform: uppercase;
    }

    .ex-stat-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1px;
        background: var(--warm);
        border: 1px solid var(--warm);
        border-radius: 4px;
        overflow: hidden;
        margin-top: 48px;
    }

    .ex-stat {
        background: var(--cream);
        padding: 28px 24px;
        text-align: center;
    }

    .ex-stat-num {
        font-family: 'Cormorant Garamond', serif;
        font-size: 2.8rem;
        font-weight: 600;
        color: var(--red);
        line-height: 1;
    }

    .ex-stat-label {
        font-size: 11px;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: var(--muted);
        margin-top: 6px;
    }

    /* ── WHY EXHIBIT ── */
    .ex-why-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: clamp(2rem, 4vw, 3.5rem);
        font-weight: 300;
        color: #fff;
        line-height: 1.15;
        max-width: 500px;
        margin-bottom: 60px;
    }

    .ex-why-title em {
        font-style: italic;
        color: var(--gold);
    }

    .ex-why-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1px;
        background: rgba(255, 255, 255, 0.06);
    }

    .ex-why-item {
        background: var(--ink);
        padding: 36px 40px;
        position: relative;
        transition: background 0.3s ease;
    }

    .ex-why-item:hover {
        background: #161412;
    }

    .ex-why-num {
        font-family: 'Cormorant Garamond', serif;
        font-size: 3rem;
        font-weight: 300;
        color: rgba(196, 160, 99, 0.2);
        line-height: 1;
        margin-bottom: 16px;
        transition: color 0.3s ease;
    }

    .ex-why-item:hover .ex-why-num {
        color: rgba(196, 160, 99, 0.45);
    }

    .ex-why-text {
        font-size: 14px;
        line-height: 1.75;
        color: rgba(255, 255, 255, 0.6);
    }

    .ex-why-text strong {
        display: block;
        color: #fff;
        font-size: 15px;
        font-weight: 500;
        margin-bottom: 6px;
    }

    /* ── EXHIBITOR PROFILES ── */
    .ex-profile-intro {
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 60px;
        align-items: end;
        margin-bottom: 60px;
    }

    .ex-profile-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: clamp(2rem, 4vw, 3.5rem);
        font-weight: 300;
        line-height: 1.15;
        color: var(--ink);
    }

    .ex-profile-title em {
        font-style: italic;
        color: var(--red);
    }

    .ex-profile-desc {
        font-size: 15px;
        line-height: 1.8;
        color: var(--muted);
    }

    .ex-profiles-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
    }

    .ex-profile-card {
        background: #fff;
        border: 1px solid var(--warm);
        border-radius: 4px;
        padding: 32px 28px;
        position: relative;
        overflow: hidden;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    .ex-profile-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: var(--red);
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.35s ease;
    }

    .ex-profile-card:hover::before {
        transform: scaleX(1);
    }

    .ex-profile-card:hover {
        border-color: rgba(179, 66, 65, 0.2);
        box-shadow: 0 12px 40px rgba(179, 66, 65, 0.08);
    }

    .ex-profile-icon {
        width: 44px;
        height: 44px;
        background: var(--red-light);
        border-radius: 3px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
        font-size: 20px;
    }

    .ex-profile-card h3 {
        font-family: 'DM Sans', sans-serif;
        font-size: 13px;
        font-weight: 500;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: var(--red);
        margin-bottom: 14px;
    }

    .ex-profile-card p {
        font-size: 13.5px;
        line-height: 1.75;
        color: var(--muted);
    }

    /* ── CTA ── */
    .ex-cta {
        background: var(--red);
        padding: 80px 6vw;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 40px;
        flex-wrap: wrap;
    }

    .ex-cta-text h2 {
        font-family: 'Cormorant Garamond', serif;
        font-size: clamp(1.8rem, 3.5vw, 3rem);
        font-weight: 300;
        color: #fff;
        line-height: 1.2;
    }

    .ex-cta-text h2 em {
        font-style: italic;
    }

    .ex-cta-text p {
        font-size: 14px;
        color: rgba(255, 255, 255, 0.65);
        margin-top: 10px;
    }

    .ex-cta-btns {
        display: flex;
        gap: 14px;
        flex-wrap: wrap;
    }

    .ex-btn-primary {
        padding: 14px 32px;
        background: #fff;
        color: var(--red);
        border: none;
        border-radius: 2px;
        font-family: 'DM Sans', sans-serif;
        font-size: 13px;
        font-weight: 500;
        letter-spacing: 1px;
        text-transform: uppercase;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.25s ease;
    }

    .ex-btn-primary:hover {
        background: var(--ink);
        color: #fff;
    }

    .ex-btn-outline {
        padding: 14px 32px;
        background: transparent;
        color: #fff;
        border: 1px solid rgba(255, 255, 255, 0.5);
        border-radius: 2px;
        font-family: 'DM Sans', sans-serif;
        font-size: 13px;
        font-weight: 500;
        letter-spacing: 1px;
        text-transform: uppercase;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.25s ease;
    }

    .ex-btn-outline:hover {
        background: rgba(255, 255, 255, 0.1);
        border-color: #fff;
    }

    /* ── DIVIDER ── */
    .ex-divider {
        width: 100%;
        height: 1px;
        background: var(--warm);
        margin: 0;
    }

    /* ── ANIMATIONS ── */
    .ex-fade-up {
        opacity: 0;
        transform: translateY(30px);
        transition: opacity 0.7s ease, transform 0.7s ease;
    }

    .ex-fade-up.visible {
        opacity: 1;
        transform: translateY(0);
    }

    /* ── RESPONSIVE ── */
    @media (max-width: 900px) {
        .ex-about-grid {
            grid-template-columns: 1fr;
            gap: 40px;
        }

        .ex-profiles-grid {
            grid-template-columns: 1fr 1fr;
        }

        .ex-why-grid {
            grid-template-columns: 1fr;
        }

        .ex-profile-intro {
            grid-template-columns: 1fr;
            gap: 24px;
        }
    }

    @media (max-width: 600px) {
        .ex-section {
            padding: 64px 6vw;
        }

        .ex-profiles-grid {
            grid-template-columns: 1fr;
        }

        .ex-stat-row {
            grid-template-columns: 1fr;
        }

        .ex-hero {
            padding: 0 6vw 60px;
            min-height: 60vh;
        }

        .ex-cta {
            flex-direction: column;
            align-items: flex-start;
        }

        .ex-why-item {
            padding: 28px 24px;
        }
    }
</style>

<div class="ex-page">

    {{-- ── HERO ── --}}
    <section class="ex-hero">
        <div class="ex-hero-grid"></div>
        <div class="ex-hero-content">
            <div class="ex-breadcrumb">
                <a href="{{ route('web') }}" style="color:var(--gold);text-decoration:none;">Home</a>
                <span>/</span>
                Exhibit at IITM
            </div>
            <h1>Exhibit at<br><em>IITM</em></h1>
            <div class="ex-hero-line"></div>
            <p class="ex-hero-sub">India's largest travel trade platform — connecting exhibitors with 22,000+ trade
                visitors across 9 major cities.</p>
        </div>
    </section>

    {{-- ── ABOUT SECTION ── --}}
    <section class="ex-section">
        <div class="ex-label">Exhibit at IITM</div>
        <div class="ex-about-grid">
            <div class="ex-fade-up">
                <h2 class="ex-about-title">
                    Persistently Striving to<br>
                    <strong>Strengthen</strong> the Travel<br>
                    & Tourism Community
                </h2>

                <div class="ex-stat-row" style="margin-top:40px;">
                    <div class="ex-stat">
                        <div class="ex-stat-num">2469+</div>
                        <div class="ex-stat-label">Exhibitors</div>
                    </div>
                    <div class="ex-stat">
                        <div class="ex-stat-num">22K+</div>
                        <div class="ex-stat-label">Trade Visitors</div>
                    </div>
                    <div class="ex-stat">
                        <div class="ex-stat-num">39</div>
                        <div class="ex-stat-label">Countries</div>
                    </div>
                </div>
            </div>

            <div class="ex-fade-up" style="transition-delay:0.15s;">
                <div class="ex-about-body">
                    <p>IITM is <strong>India's largest travel trade platform</strong> organizing varied B2B and B2C
                        exhibitions and events. It is one of the leading travel & tourism Exhibition Companies in India
                        organizing a wide range of events in <strong>9 major cities of India</strong>.</p>
                    <p>It aims to amplify its reach to include in its ambit maximum number of domestic as well as
                        international trade visitors and travel enthusiasts, thereby, unlocking new doors of inbound and
                        outbound business potentials.</p>
                    <p>It is supported by the State Tourism Boards, Union Territories of India, International Tourism
                        Boards and their representative companies, along with most of the Travel Associations of India.
                    </p>
                </div>

                <div class="ex-assoc">
                    <span class="ex-assoc-tag">TAAI</span>
                    <span class="ex-assoc-tag">OTOAI</span>
                    <span class="ex-assoc-tag">ETAA</span>
                    <span class="ex-assoc-tag">IATO</span>
                    <span class="ex-assoc-tag">ADTOI</span>
                    <span class="ex-assoc-tag">ATOAI</span>
                    <span class="ex-assoc-tag">SKAL</span>
                </div>
            </div>
        </div>
    </section>

    <div class="ex-divider"></div>

    {{-- ── WHY EXHIBIT ── --}}
    <section class="ex-section ex-section-alt">
        <div class="ex-label">Why Exhibit</div>
        <h2 class="ex-why-title">Why Exhibit <em>With Us</em></h2>

        <div class="ex-why-grid">
            @php
                $reasons = [
                    ['Mass Audience', 'Showcase your existing products/services and launch new ones to a massive, targeted audience all gathered in one place.'],
                    ['Business Relationships', 'Strengthen existing business relationships and forge powerful new connections with key players across the industry.'],
                    ['Market Intelligence', 'Learn about what is happening in the industry, build market intelligence, and stay ahead of emerging trends.'],
                    ['India\'s Largest Platform', 'Participate at India\'s Largest Travel Exhibition — 2469+ Exhibitors, 22,000+ Trade Visitors from 39 Countries and 36 Indian States/UTs.'],
                    ['Establish Contacts', 'Create a market for yourself and establish contacts with various travel trade businesses, partners, suppliers and buyers.'],
                    ['Understand Your Market', 'Understand your hold in the market, your competition, challenges and scope more efficiently than ever before.'],
                    ['Potential Customers', 'Exhibition visitors are generally potential customers and businesses — meet them all under one roof.'],
                    ['Brand Presence', 'Develop and enhance your brand presence by reaching out to the global travel community on an international level.'],
                    ['New Sales Leads', 'Generate new sales leads and create fresh revenue pipelines for your business through direct engagement.'],
                    ['Network with Decision Makers', 'Network with prominent decision makers and experts of the industry who can open new doors for your business.'],
                ];
            @endphp

            @foreach($reasons as $i => $reason)
                <div class="ex-why-item ex-fade-up" style="transition-delay:{{ $i * 0.05 }}s;">
                    <div class="ex-why-num">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</div>
                    <div class="ex-why-text">
                        <strong>{{ $reason[0] }}</strong>
                        {{ $reason[1] }}
                    </div>
                </div>
            @endforeach
        </div>
    </section>

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

    {{-- ── CTA ── --}}
    <div class="ex-cta">
        <div class="ex-cta-text">
            <h2>Ready to <em>Exhibit</em><br>at IITM?</h2>
            <p>Join 2469+ exhibitors and connect with 22,000+ trade visitors from across the globe.</p>
        </div>
        <div class="ex-cta-btns">
            <a href="/enquiry" class="ex-btn-primary">Book Your Stall</a>
            <a href="/contact-us" class="ex-btn-outline">Get in Touch</a>
        </div>
    </div>

</div>

<script>
    (function () {
        const iitmExFadeEls = document.querySelectorAll('.ex-fade-up');

        const iitmExObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    iitmExObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12 });

        iitmExFadeEls.forEach(el => iitmExObserver.observe(el));
    })();
</script>