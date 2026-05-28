<div class="sponsor-page">
    <style>
        /* =========================
   2 COLUMN SPECIAL LAYOUT
========================= */

        .sponsor-page {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
            align-items: stretch;
        }

        /* override from global flex if needed */
        .sponsor-page .page-footer {
            grid-column: 1 / -1;
        }

        /* =========================
   SECTION HEADER VARIANT
========================= */

        .section-header {
            margin-bottom: 20px;
        }

        .section-header .slot-text {
            font-size: 11px;
            letter-spacing: 2px;
            font-weight: bold;
            opacity: 0.8;
            margin-bottom: 5px;
        }

        .section-header .section-title {
            font-size: 24px;
            font-weight: 900;
            margin: 5px 0;
            text-transform: uppercase;
            line-height: 1.2;
        }

        .section-header .price {
            font-size: 18px;
            font-weight: 300;
            margin-top: 5px;
        }

        .page-subtitle {
            font-size: 12px;
            color: #777;
            margin-top: 3px;
        }

        /* =========================
   TEXT BLOCK
========================= */

        .feature-text {
            padding: 15px;
        }

        .feature-text p {
            margin-top: 0;
            font-size: 12.5px;
            line-height: 1.6;
            color: #444;
        }

        /* =========================
   MAKE CARDS BALANCED
========================= */

        .feature-card {
            justify-content: space-between;
        }

        /* optional visual separation */
        .feature-card.dark {
            border-left: 4px solid #1a1a1a;
        }

        .feature-card.gold {
            border-left: 4px solid #d4af37;
        }
    </style>
    <!-- LEFT COLUMN -->
    <div class="feature-card dark">

        <div class="section-header">
            <div class="slot-text">EXCLUSIVE EVENT</div>
            <h2 class="section-title">
                Networking Dinner<br>Branding
            </h2>
            <div class="price">Rs 3,00,000/-</div>
            <div class="page-subtitle">(1 Slot per City)</div>
        </div>

        <div class="feature-text">
            <p>
                Host a "By Invitation Only" function designed to connect you with the upper echelon of the travel trade.
            </p>

            <ul class="feature-list">
                <li><strong>10-Minute Presentation:</strong> Introduce new products directly to industry leaders before
                    dinner.</li>
                <li><strong>Stage Backdrop:</strong> Dominant branding presence throughout the evening.</li>
                <li><strong>Banner Displays:</strong> Strategic placement within the dinner venue for maximum recall.
                </li>
            </ul>
        </div>

    </div>

    <!-- RIGHT COLUMN -->
    <div class="feature-card gold">

        <div class="section-header">
            <div class="slot-text">TACTICAL VISIBILITY</div>
            <h2 class="section-title">
                Help Desk<br>Branding
            </h2>
            <div class="price">Rs 1,00,000/-</div>
            <div class="page-subtitle">(1 Slot per City)</div>
        </div>

        <div class="feature-text">
            <p>
                Capitalize on the highest-traffic service point for every exhibitor, delegate, and VIP guest.
            </p>

            <ul class="feature-list">
                <li><strong>First Point of Contact:</strong> Immediate exposure at registration zone.</li>
                <li><strong>Repeat Exposure:</strong> Most revisited location during event days.</li>
                <li><strong>Prime Location:</strong> Logo placement on help desk signage.</li>
            </ul>
        </div>

    </div>

    <!-- FOOTER -->
    <div class="page-footer">
        <span class="footer-text">WWW.IITMINDIA.COM</span>
        <span class="footer-page">06</span>
    </div>

</div>