<style>
    /* =========================
   BASE LAYOUT
========================= */

    .sponsor,
    .sponsor-page,
    .pricing-page {
        height: 100%;
        box-sizing: border-box;
        font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
        position: relative;
        display: flex;
        flex-direction: column;
    }

    .sponsor-page {

        padding: 15mm 20mm;
        background: #ffffff;
        color: #AA2D2C;
        border-top: 10px solid #AA2D2C;
    }

    .pricing-page {
        padding: 15mm;
        background: #FFFFFF;
        color: #AA2D2C;
    }

    .sponsor {
        padding: 20mm;
        background: linear-gradient(135deg, #AA2D2C 0%, #AA2D2C 100%);
        color: #fff;
        justify-content: center;
        border-left: 15px solid #AA2D2C;
        overflow: hidden;
    }


    /* =========================
   COMMON ELEMENTS
========================= */

    .highlight {
        color: #AA2D2C;
    }

    .page-header,
    .section-header {
        margin-bottom: 25px;
    }

    .page-title,
    .section-title {
        margin: 0;
        font-weight: 800;
        text-transform: uppercase;
        color: #AA2D2C;
    }

    .page-title {
        font-size: 24px;
        letter-spacing: 2px;
    }

    .section-title {
        font-size: 28px;
        letter-spacing: 1px;
    }

    .page-subtitle,
    .feature-text,
    .description {
        color: #AA2D2C;
    }

    .page-subtitle {
        font-size: 14px;
        margin: 5px 0 0;
    }

    .header-line,
    .section-line,
    .accent {
        background-color: #AA2D2C;
    }

    .header-line {
        width: 60px;
        height: 3px;
        margin: 10px auto;
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


    /* =========================
   HERO PAGE
========================= */

    .bg-shape {
        position: absolute;
        right: -50px;
        top: -50px;
        width: 300px;
        height: 300px;
        background: rgba(212, 175, 55, 0.05);
        border-radius: 50%;
    }

    .content {
        letter-spacing: 2px;
        text-transform: uppercase;
        z-index: 1;
    }

    .subtitle {
        margin: 0;
        font-size: 22px;
        font-weight: 300;
        color: #AA2D2C;
        letter-spacing: 6px;
    }

    .title {
        font-size: 58px;
        line-height: 1;
        margin: 15px 0;
        font-weight: 800;
        letter-spacing: -1px;
    }

    .divider {
        width: 400px;
        height: 1px;
        margin: 30px 0;
        background: linear-gradient(135deg, #AA2D2C 0%, #AA2D2C 100%);
    }

    .tagline {
        font-size: 24px;
        font-weight: 600;
        margin-bottom: 40px;
        color: #FFFFFF;
        letter-spacing: 8px;
    }

    .footer {
        margin-top: 20px;
    }

    .description {
        font-size: 16px;
        font-weight: 300;
        margin-bottom: 10px;
        letter-spacing: 1px;
    }

    .website {
        color: #AA2D2C;
        text-decoration: none;
        font-size: 14px;
        font-weight: bold;
        letter-spacing: 2px;
        border-bottom: 1px solid #AA2D2C;
        padding-bottom: 3px;
    }

    .page-note {
        position: absolute;
        bottom: 20px;
        right: 40px;
        font-size: 12px;
        color: rgba(255, 255, 255, 0.3);
        letter-spacing: 2px;
    }


    /* =========================
   GRID SYSTEMS
========================= */

    .feature-grid,
    .pricing-grid {
        display: grid;
        flex-grow: 1;
    }

    .feature-grid {
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        align-items: stretch;
    }

    .pricing-grid {
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
    }


    /* =========================
   CARDS
========================= */

    .feature-card,
    .pricing-card,
    .event-card {
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .feature-card {
        padding: 20px;
        background: #FFFFFF;
        justify-content: center;
    }

    .pricing-card {
        background: #fff;
        border: 1px solid #FFFFFF;
    }

    .event-card {
        background: #FFFFFF;
        border: 1px solid #FFFFFF;
    }

    .feature-card.gold,
    .pricing-card.gold {
        border-left: 4px solid #AA2D2C;
    }

    .feature-card.dark,
    .pricing-card.platinum {
        border-left: 4px solid #AA2D2C;
    }

    .pricing-card.platinum {
        border-top: 6px solid #AA2D2C;
    }

    .pricing-card.gold {
        border-top: 6px solid #AA2D2C;
    }

    .pricing-card.silver {
        border-top: 6px solid #AA2D2C;
    }


    /* =========================
   CARD HEADERS
========================= */

    .card-header {
        padding: 15px;
        text-align: center;
        color: #fff;
    }

    .dark {
        background: #AA2D2C;
        color: #AA2D2C;
    }

    .gold-bg {
        background: #AA2D2C;
    }

    .silver-bg {
        background: #AA2D2C;
    }

    .slot-text {
        font-size: 11px;
        font-weight: bold;
        letter-spacing: 2px;
        opacity: 0.9;
    }

    .plan-name {
        font-size: 20px;
        font-weight: 900;
        margin: 5px 0;
    }

    .price {
        font-size: 18px;
        font-weight: 300;
    }


    /* =========================
   TEXT CONTENT
========================= */

    .feature-title {
        display: block;
        font-size: 17px;
        color: #AA2D2C;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .feature-text,
    .event-card-body,
    .feature-list {
        font-size: 11.5px;
        line-height: 1.6;
        color: #AA2D2C;
    }

    .feature-text {
        margin: 0;
    }

    .feature-list,
    .event-card-body {
        padding: 20px 25px;
    }

    .feature-list {
        margin: 0;
        list-style-type: square;
    }

    .event-list,
    .benefit-list {
        padding-left: 18px;
    }

    .event-list li,
    .benefit-list li {
        margin-bottom: 6px;
    }


    /* =========================
   QUOTE / BENEFITS
========================= */

    .quote-box,
    .benefit-box {
        background: #FFFFFF;
        padding: 15px;
    }

    .quote-box {
        border: 1px dashed #AA2D2C;
        margin-top: 25px;
        text-align: center;
        background: #FFFFFF;
    }

    .quote-text {
        margin: 0;
        font-size: 15px;
        font-style: italic;
        color: #AA2D2C;
    }

    .benefit-box {
        border: 1px solid #FFFFFF;
        margin-top: 10px;
    }

    .benefit-title {
        font-size: 10px;
        text-transform: uppercase;
        color: #AA2D2C;
    }


    /* =========================
   FOOTERS
========================= */

    .page-footer {
        margin-top: 20px;
        padding-top: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top: 1px solid #FFFFFF;
    }

    .footer-text,
    .footer-site {
        font-size: 10px;
        font-weight: bold;
        letter-spacing: 1px;
        color: #AA2D2C;
        text-transform: uppercase;
    }

    .footer-page {
        font-size: 14px;
        font-weight: 800;
        color: #AA2D2C;
    }

    /* =========================
   VIP LOUNGE HEADER STYLE
========================= */

    .section-header {
        text-align: center;
        margin-bottom: 25px;
    }

    .section-header .slot-text {
        font-size: 11px;
        letter-spacing: 3px;
        font-weight: bold;
        color: #AA2D2C;
        margin-bottom: 10px;
    }

    .section-header .section-title {
        font-size: 30px;
        font-weight: 900;
        text-transform: uppercase;
        margin: 0;
        line-height: 1.2;
    }

    .section-header .price {
        margin-top: 10px;
        font-size: 18px;
        font-weight: 300;
    }

    .header-line {
        width: 80px;
        height: 3px;
        background: #AA2D2C;
        margin: 10px auto;
    }

    /* =========================
   BENEFITS GRID FIX
========================= */

    .feature-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
    }

    /* =========================
   CARD TEXT STYLE
========================= */

    .feature-card {
        padding: 18px;
        background: #FFFFFF;
        border-left: 4px solid #AA2D2C;
        display: flex;
        align-items: center;
    }

    .feature-card .feature-text {
        font-size: 13px;
        line-height: 1.5;
        color: #AA2D2C;
    }

    .feature-card strong {
        display: block;
        font-size: 14px;
        margin-bottom: 5px;
        color: #AA2D2C;
    }

    /* =========================
   FOOTER ALIGNMENT
========================= */

    .page-footer {
        margin-top: 20px;
        display: flex;
        justify-content: space-between;
        border-top: 1px solid #FFFFFF;
        padding-top: 10px;
    }

    .vip-sponsor {
        height: 100%;
        position: relative;
        background: #AA2D2C;
        color: #fff;
        font-family: 'Helvetica Neue', Arial, sans-serif;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    /* decorative gradient */
    .vip-bg-1 {
        position: absolute;
        top: 0;
        right: 0;
        width: 40%;
        height: 100%;
        background: linear-gradient(135deg, #AA2D2C 0%, #AA2D2C 100%);
    }

    /* circle accent */
    .vip-bg-2 {
        position: absolute;
        bottom: -60px;
        left: -60px;
        width: 220px;
        height: 220px;
        border: 2px solid rgba(212, 175, 55, 0.2);
        border-radius: 50%;
    }

    /* content */
    .vip-content {
        width: 80%;
        max-width: 850px;
        text-align: center;
        z-index: 2;
    }

    .vip-tag {
        display: inline-block;
        border: 1px solid #AA2D2C;
        color: #AA2D2C;
        padding: 6px 18px;
        font-size: 12px;
        letter-spacing: 4px;
        text-transform: uppercase;
        margin-bottom: 20px;
    }

    .vip-title {
        font-size: 52px;
        font-weight: 800;
        margin: 0;
        text-transform: uppercase;
        line-height: 1;
    }

    .vip-line {
        width: 100px;
        height: 2px;
        background: #AA2D2C;
        margin: 25px auto;
    }

    .vip-price {
        font-size: 28px;
        font-weight: 300;
        margin-bottom: 35px;
    }

    .vip-note {
        font-size: 14px;
        color: #AA2D2C;
        margin-left: 10px;
    }

    /* grid (kept your original feel) */
    .vip-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 25px;
        text-align: left;
        background: rgba(255, 255, 255, 0.05);
        padding: 30px;
        border-radius: 6px;
        backdrop-filter: blur(10px);
    }

    .vip-item {
        display: flex;
        gap: 15px;
        color: #ccc;
        font-size: 14px;
        line-height: 1.5;
    }

    .vip-item strong {
        display: block;
        color: #fff;
        margin-bottom: 5px;
    }

    .vip-icon {
        color: #AA2D2C;
        font-size: 18px;
    }

    /* footer */
    .vip-footer {
        position: absolute;
        bottom: 15mm;
        left: 15mm;
        right: 15mm;
        display: flex;
        justify-content: space-between;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        padding-top: 12px;
        font-size: 11px;
        color: #777;
    }
</style>