<style>
    :root {
        --iitm-text: #AA2324;
        --iitm-background: #ffffff;
        --iitm-text2: #ffffff;
        --iitm-background2: #AA2324;
    }

    /* =========================
   GLOBAL LAYOUT (more expo feel)
========================= */
    .split-layout {
        display: flex;
        width: 100%;
        font-family: system-ui, sans-serif;
        background: var(--iitm-background);
        color: var(--iitm-text);
    }

    /* =========================
   LEFT - EXHIBITOR NAV (UPGRADED)
========================= */
    .left {
        width: 28%;
        background: var(--iitm-background);
        padding: 24px;
        border-right: 2px solid var(--iitm-background2);
        overflow-y: auto;
    }

    /* section header feel (expo catalog style) */
    .left::before {
        /* content: "EXHIBITORS"; */
        display: block;
        font-size: 12px;
        letter-spacing: 2px;
        margin-bottom: 15px;
        color: var(--iitm-background2);
        font-weight: 700;
    }

    #btnRow {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    /* premium card-like buttons */
    .city-btn {
        padding: 14px;
        border-radius: 8px;
        border: 1px solid var(--iitm-background2);
        background: var(--iitm-background);
        color: var(--iitm-text);
        cursor: pointer;
        transition: 0.25s ease;
        text-align: left;
        position: relative;
    }

    .city-btn::after {
        content: "→";
        position: absolute;
        right: 12px;
        opacity: 0.5;
    }

    .city-btn:hover {
        background: var(--iitm-background2);
        color: var(--iitm-text2);
        transform: translateX(6px);
    }

    /* =========================
   RIGHT - MAIN STAGE
========================= */
    .right {
        width: 72%;
        display: flex;
        flex-direction: column;
    }




    /* =========================
   INFO BADGES (more structured)
========================= */

    /* =========================
   INFO STRIP (expo footer bar)
========================= */
    .info {
        padding-top: 5px;
        border-top: 1px solid var(--iitm-background2);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        /* prevents overflow */
        gap: 12px;
    }

    /* =========================
   RESPONSIVE (kept clean)
========================= */
    @media(max-width:900px) {

        .split-layout {
            flex-direction: column;
            height: auto;
        }

        .left,
        .right {
            width: 100%;
        }

        .hero {
            flex-direction: column;
            text-align: center;
            padding: 30px;
            gap: 20px;
        }

        #eventImage {
            width: 100%;
            height: 220px;
        }

        #eventDate,
        #eventVenueDetails,
        #eventAccessInfo {
            position: static;
            transform: none;
            margin-top: 8px;
            display: inline-block;
        }

        .info {
            flex-direction: column;
            gap: 12px;
            text-align: center;
        }

    }
</style>


<style>
    /* IITM Style Button Refinement */
    .primary-btn {
        background: #aa2324;
        /* IITM Red */
        color: white;
        border: none;
        padding: 12px 25px;
        font-family: 'Inter', sans-serif;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .primary-btn:hover {
        background: #ffffffff;
        border: 1px solid #aa2324;
        color: var(--iitm-text);
        /* IITM Gold on hover */
    }

    .tagline {
        font-size: 0.75rem;
        color: #888;
        margin-top: 10px;
        letter-spacing: 1px;
    }
</style>