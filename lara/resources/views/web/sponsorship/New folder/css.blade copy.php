<style>
    /* =========================
       BASE LAYOUT & PAGES
    ========================= */
    .sponsor,
    .sponsor-page,
    .pricing-page,
    .vip-sponsor {
        height: 100%;
        box-sizing: border-box;
        font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
        position: relative;
        display: flex;
        flex-direction: column;
    }

    .sponsor-page,
    .sponsor-class-14 {
        padding: 15mm 20mm;
        background: #ffffff;
        color: #333;
        border-top: 10px solid #1a1a1a;
    }

    .pricing-page {
        padding: 15mm;
        background: #f4f4f4;
        color: #333;
    }

    .sponsor {
        padding: 20mm;
        background: linear-gradient(135deg, #1a1a1a 0%, #2c3e50 100%);
        color: #fff;
        justify-content: center;
        border-left: 15px solid #d4af37;
        overflow: hidden;
    }

    .vip-sponsor {
        background: #1a1a1a;
        color: #fff;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    /* =========================
       TYPOGRAPHY & HEADERS
    ========================= */
    .highlight,
    .subtitle,
    .website,
    .vip-icon,
    .vip-tag,
    .section-header .slot-text {
        color: #d4af37;
    }

    .page-title,
    .section-title,
    .vip-title {
        margin: 0;
        font-weight: 800;
        text-transform: uppercase;
        color: #1a1a1a;
    }

    .page-title {
        font-size: 24px;
        letter-spacing: 2px;
    }

    .section-title {
        font-size: 28px;
        letter-spacing: 1px;
    }

    .vip-title {
        font-size: 52px;
        line-height: 1;
    }

    .section-header .section-title {
        font-size: 30px;
        font-weight: 900;
        line-height: 1.2;
    }

    .page-subtitle,
    .feature-text,
    .description {
        color: #666;
    }

    .page-subtitle {
        font-size: 14px;
        margin: 5px 0 0;
    }

    /* =========================
       ELEMENTS & ACCENTS
    ========================= */
    .header-line,
    .section-line,
    .accent,
    .vip-line {
        background-color: #d4af37;
    }

    .header-line {
        width: 60px;
        height: 3px;
        margin: 10px auto;
    }

    .vip-line {
        width: 100px;
        height: 2px;
        margin: 25px auto;
    }

    .section-line,
    .accent {
        width: 80px;
        height: 4px;
    }

    .section-line {
        margin-top: 12px;
    }

    .accent {
        margin-bottom: 25px;
    }

    .divider {
        width: 400px;
        height: 1px;
        margin: 30px 0;
        background: linear-gradient(90deg, #d4af37, transparent);
    }

    /* =========================
       GRID & CARDS
    ========================= */
    .feature-grid,
    .pricing-grid,
    .vip-grid {
        display: grid;
    }

    /* Feature Grid (Standard & VIP versions) */
    .feature-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
        flex-grow: 1;
    }

    .pricing-grid {
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
        flex-grow: 1;
    }

    .vip-grid {
        grid-template-columns: 1fr 1fr;
        gap: 25px;
        text-align: left;
        background: rgba(255, 255, 255, 0.05);
        padding: 30px;
        border-radius: 6px;
        backdrop-filter: blur(10px);
    }

    .feature-card,
    .pricing-card,
    .event-card {
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .feature-card {
        padding: 18px;
        background: #f9f9f9;
        border-left: 4px solid #1a1a1a;
        align-items: center;
    }

    .pricing-card {
        background: #fff;
        border: 1px solid #ddd;
    }

    .event-card {
        background: #fdfdfd;
        border: 1px solid #e0e0e0;
    }

    /* Border Logic */
    .pricing-card.platinum {
        border-top: 6px solid #1a1a1a;
        border-left: 4px solid #1a1a1a;
    }

    .pricing-card.gold {
        border-top: 6px solid #d4af37;
        border-left: 4px solid #d4af37;
    }

    .pricing-card.silver {
        border-top: 6px solid #a0a0a0;
    }

    /* =========================
       CARD INTERIORS & TEXT
    ========================= */
    .card-header {
        padding: 15px;
        text-align: center;
        color: #fff;
    }

    .dark {
        background: #1a1a1a;
        color: #d4af37;
    }

    .gold-bg {
        background: #d4af37;
    }

    .silver-bg {
        background: #a0a0a0;
    }

    .feature-text,
    .event-card-body,
    .feature-list,
    .vip-item {
        font-size: 11.5px;
        line-height: 1.6;
        color: #444;
    }

    .feature-card .feature-text {
        font-size: 13px;
        line-height: 1.5;
    }

    .feature-card strong {
        display: block;
        font-size: 14px;
        margin-bottom: 5px;
        color: #1a1a1a;
    }

    .vip-item {
        font-size: 14px;
        color: #ccc;
        display: flex;
        gap: 15px;
    }

    .vip-item strong {
        display: block;
        color: #fff;
        margin-bottom: 5px;
    }

    /* =========================
       FOOTERS & NOTES
    ========================= */
    .page-footer,
    .vip-footer {
        margin-top: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top: 1px solid #eee;
        padding-top: 10px;
    }

    .vip-footer {
        position: absolute;
        bottom: 15mm;
        left: 15mm;
        right: 15mm;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        font-size: 11px;
        color: #777;
    }

    .footer-text,
    .footer-site {
        font-size: 10px;
        font-weight: bold;
        letter-spacing: 1px;
        color: #888;
        text-transform: uppercase;
    }

    .footer-page {
        font-size: 14px;
        font-weight: 800;
        color: #1a1a1a;
    }

    .page-note {
        position: absolute;
        bottom: 20px;
        right: 40px;
        font-size: 12px;
        color: rgba(255, 255, 255, 0.3);
        letter-spacing: 2px;
    }
</style>