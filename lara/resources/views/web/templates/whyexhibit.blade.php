<style>
    :root {
        --red: #aa2324;
        --gold: #c5a059;
        --muted: #666;
        --soft: #f7f5f2;
    }

    * {
        box-sizing: border-box;
        font-family: Inter, sans-serif;
    }

    .why-section {
        max-width: 1100px;
        margin: auto;
        padding: 60px 20px;
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
        color: var(--red);
        font-style: normal;
    }

    .why-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 18px;
    }

    .why-item {
        background: var(--soft);
        padding: 18px;
        border-radius: 12px;
        transition: .2s;
    }

    .why-item:hover {
        background: #fff;
        box-shadow: 0 10px 20px rgba(0, 0, 0, .06);
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
    }

    @media(max-width:900px) {
        .why-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<section class="why-section">

    <div class="ex-label">The Advantage</div>
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