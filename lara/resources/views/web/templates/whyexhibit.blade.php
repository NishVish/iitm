<style>
    :root {
        --iitm-blue: #8F1D1E;
        --iitm-dark: #1a1a1a;
        --iitm-grey: #6b7280;
        --iitm-light-bg: #f3f7fa;
        /* Light blueish grey */
        --iitm-accent: #00a8ff;
    }

    * {
        box-sizing: border-box;
        font-family: 'Inter', -apple-system, sans-serif;
    }

    .why-section {
        max-width: 1200px;
        margin: auto;
        padding: 80px 20px;
        background-color: #ffffff;
    }

    .ex-label {
        font-size: 13px;
        letter-spacing: 3px;
        text-transform: uppercase;
        color: var(--iitm-blue);
        font-weight: 700;
        margin-bottom: 12px;
        display: block;
    }

    .why-title {
        font-size: 42px;
        font-weight: 800;
        color: var(--iitm-dark);
        margin: 0 0 40px;
        letter-spacing: -1px;
        line-height: 1.2;
    }

    .why-title em {
        color: var(--iitm-blue);
        font-style: normal;
        position: relative;
    }

    /* Modern Bento-style Grid */
    .why-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
    }

    .why-item {
        background: var(--iitm-light-bg);
        padding: 35px;
        border-radius: 20px;
        border: 1px solid rgba(0, 118, 189, 0.05);
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        display: flex;
        flex-direction: column;
        position: relative;
        overflow: hidden;
    }

    .why-item:hover {
        background: #fff;
        box-shadow: 0 20px 40px rgba(0, 118, 189, 0.1);
        transform: translateY(-8px);
        border-color: var(--iitm-blue);
    }

    /* Subtle number accent behind the text */
    .why-num {
        font-size: 14px;
        font-weight: 800;
        color: var(--iitm-blue);
        background: rgba(0, 118, 189, 0.1);
        width: 35px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .why-item strong {
        display: block;
        font-size: 20px;
        color: var(--iitm-dark);
        margin-bottom: 12px;
        font-weight: 700;
    }

    .why-item p {
        font-size: 15px;
        color: var(--iitm-grey);
        line-height: 1.6;
        margin: 0;
    }

    /* Bottom accent line on hover */
    .why-item::after {
        content: "";
        position: absolute;
        bottom: 0;
        left: 0;
        width: 0;
        height: 4px;
        background: var(--iitm-blue);
        transition: width 0.3s ease;
    }

    .why-item:hover::after {
        width: 100%;
    }

    @media(max-width:992px) {
        .why-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media(max-width:600px) {
        .why-grid {
            grid-template-columns: 1fr;
        }

        .why-title {
            font-size: 32px;
        }
    }
</style>

<section class="why-section">
    <span class="ex-label">The Advantage</span>
    <h2 class="why-title">Why Exhibit <em>With Us</em></h2>

    <div class="why-grid">
        @php
            $reasons = [
                ['Brand Presence', 'Develop and enhance your global brand presence on an international level.'],
                ['New Sales Leads', 'Generate fresh revenue pipelines through direct engagement with decision makers.'],
                ['Market Intelligence', 'Understand your competition and emerging trends more efficiently than ever before.'],
                ['Global Networking', 'Connect with decision makers, buyers, and industry experts worldwide.'],
                ['Business Growth', 'Expand your reach and grow your business in the global travel ecosystem.'],
                ['Industry Exposure', 'Gain maximum visibility in the travel and hospitality industry.']
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