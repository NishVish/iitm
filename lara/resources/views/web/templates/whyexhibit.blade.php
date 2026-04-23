<style>
    @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600&family=Inter:wght@300;400;600;700&display=swap');

    :root {
        --red: #aa2324;
        --gold: #c5a059;
        --dark: #111;
        --muted: #666;
        --soft: #f7f5f2;
        --white: #fff;
    }

    * {
        box-sizing: border-box;
    }

    body {
        margin: 0;
        font-family: Inter, sans-serif;
        background: #fff;
        color: var(--dark);
    }

    /* WRAP */
    .iitm-wrap {
        max-width: 1100px;
        margin: auto;
        padding: 60px 20px;
    }

    /* HERO */
    .ex-hero {
        display: grid;
        grid-template-columns: 1.2fr 1fr 1fr;
        gap: 40px;
        margin-bottom: 70px;
        align-items: start;
    }

    .ex-breadcrumb {
        font-size: 12px;
        letter-spacing: 1px;
        color: var(--muted);
        margin-bottom: 10px;
    }

    .ex-hero h1 {
        font-family: "Cormorant Garamond", serif;
        font-size: 54px;
        line-height: 1.05;
        margin: 0 0 12px;
    }

    .ex-hero h1 em {
        font-style: normal;
        color: var(--red);
    }

    .ex-hero-sub {
        font-size: 14px;
        color: var(--muted);
        max-width: 320px;
        line-height: 1.6;
    }

    /* TEXT BLOCKS */
    .vision-main,
    .vision-side {
        font-size: 14px;
        line-height: 1.7;
        color: #444;
    }

    .vision-main p,
    .vision-side p {
        margin: 0 0 12px;
    }

    /* WHY SECTION */
    .why-section {
        padding-top: 10px;
    }

    .ex-label {
        font-size: 12px;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: var(--gold);
        margin-bottom: 8px;
    }

    .why-title {
        font-size: 34px;
        font-family: "Cormorant Garamond", serif;
        margin: 0 0 30px;
    }

    .why-title em {
        font-style: normal;
        color: var(--red);
    }

    /* GRID */
    .why-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 18px;
    }

    .why-item {
        background: var(--soft);
        padding: 18px 16px;
        border-radius: 12px;
        transition: .25s ease;
        border: 1px solid transparent;
    }

    .why-item:hover {
        background: #fff;
        border-color: #eee;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.06);
        transform: translateY(-3px);
    }

    .why-num {
        font-size: 12px;
        color: var(--gold);
        margin-bottom: 6px;
    }

    .why-item strong {
        display: block;
        font-size: 15px;
        margin-bottom: 6px;
    }

    .why-item p {
        font-size: 13px;
        color: var(--muted);
        line-height: 1.5;
        margin: 0;
    }

    /* CTA */
    .ex-cta {
        margin-top: 70px;
        text-align: center;
        padding: 50px 20px;
        border-radius: 16px;
        background: linear-gradient(135deg, #fff7f7, #fff);
    }

    .ex-cta h2 {
        font-size: 32px;
        font-family: "Cormorant Garamond", serif;
        margin: 0 0 18px;
    }

    .ex-cta h2 em {
        font-style: normal;
        color: var(--red);
    }

    .ex-btn-primary {
        display: inline-block;
        padding: 12px 26px;
        border-radius: 30px;
        background: var(--red);
        color: #fff;
        text-decoration: none;
        font-size: 14px;
        transition: .2s ease;
    }

    .ex-btn-primary:hover {
        background: #8f1d1e;
    }

    /* RESPONSIVE */
    @media(max-width:900px) {
        .ex-hero {
            grid-template-columns: 1fr;
            gap: 25px;
        }

        .why-grid {
            grid-template-columns: 1fr;
        }

        .ex-hero h1 {
            font-size: 40px;
        }
    }
</style>

<div class="iitm-wrap">

    <section class="ex-hero">

        <div class="ex-hero-content">
            <div class="ex-breadcrumb">Home / Exhibit at IITM</div>
            <h1>Exhibit at<br><em>IITM India</em></h1>
            <p class="ex-hero-sub">
                The ultimate biosphere for travel producers, sellers, and buyers to connect and grow.
            </p>
        </div>

        <div class="vision-main">
            <p>We envision building a viable and thrilling platform facilitating high-end services for the growth of the
                travel and tourism industry.</p>
            <p>IITM is dedicated to bringing about a change by ensuring a constant flow of knowledge, ideas, and
                services among global members.</p>
        </div>

        <div class="vision-side">
            <p>With an experience of more than 20 Years, IITM extends an enriching platform for knowledge sharing and
                exchange of thoughts & values.</p>
            <p>We welcome exhibitors from every part of the globe to experience the most ravishing travel events and
                connect with global businesses.</p>
        </div>

    </section>

    <section class="why-section">

        <div class="ex-label">The Advantage</div>
        <h2 class="why-title">Why Exhibit <em>With Us</em></h2>

        <div class="why-grid">

            @php
                $reasons = [
                    ['Mass Audience', 'Showcase existing services and launch new products to a targeted, massive audience.'],
                    ['Business Relationships', 'Strengthen existing bonds and forge powerful new connections with industry leaders.'],
                    ['India\'s Largest Platform', 'Join 2,469+ Exhibitors and 22,000+ Trade Visitors from 39 Countries.'],
                    ['Brand Presence', 'Develop and enhance your global brand presence on an international level.'],
                    ['New Sales Leads', 'Generate fresh revenue pipelines through direct engagement with decision makers.'],
                    ['Market Intelligence', 'Understand your competition and emerging trends more efficiently than ever before.']
                ];
            @endphp

            @foreach($reasons as $i => $reason)
                <div class="why-item">
                    <div class="why-num">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</div>
                    <strong>{{ $reason[0] }}</strong>
                    <p>{{ $reason[1] }}</p>
                </div>
            @endforeach

        </div>

    </section>

    <section class="ex-cta">
        <h2>Ready to <em>Exhibit</em>?</h2>
        <a href="/enquiry" class="ex-btn-primary">Book Your Stall Now</a>
    </section>

</div>