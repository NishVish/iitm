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

    .why-section {
        max-width: 1200px;
        margin: auto;
        padding: 60px 20px;
        background: #fff;
    }

    .ex-label {
        font-size: 11px;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: var(--primary-color);
        font-weight: 700;
        margin-bottom: 10px;
        display: block;
    }

    .why-title {
        font-size: 36px;
        font-weight: 800;
        color: var(--dark-color);
        margin: 0 0 30px;
        line-height: 1.2;
    }

    .why-title em {
        color: var(--primary-color);
        font-style: normal;
    }

    .why-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 18px;
    }

    .why-item {
        background: var(--light-bg);
        padding: 24px;
        border-radius: 16px;
        border: 1px solid rgba(0, 0, 0, 0.04);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .why-item:hover {
        background: #fff;
        border-color: var(--primary-color);
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.06);
    }

    .why-num {
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

    .why-item strong {
        display: block;
        font-size: 18px;
        color: var(--dark-color);
        margin-bottom: 8px;
        font-weight: 700;
    }

    .why-item p {
        font-size: 14px;
        color: var(--grey-color);
        line-height: 1.5;
        margin: 0;
    }

    .why-item::after {
        content: "";
        position: absolute;
        left: 0;
        bottom: 0;
        width: 0;
        height: 3px;
        background: var(--primary-color);
        transition: width 0.3s ease;
    }

    .why-item:hover::after {
        width: 100%;
    }

    @media (max-width: 992px) {
        .why-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 600px) {
        .why-grid {
            grid-template-columns: 1fr;
        }

        .why-title {
            font-size: 28px;
        }

        .why-section {
            padding: 45px 16px;
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
                <div class="why-num">
                    {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}
                </div>

                <strong>{{ $reason[0] }}</strong>

                <p>{{ $reason[1] }}</p>
            </div>
        @endforeach
    </div>
</section>