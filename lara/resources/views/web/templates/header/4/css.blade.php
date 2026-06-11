<style>
    :root {
        --primary-red: #A62322;
        --primary-red-hover: #821b1a;
        --text-dark: #1e293b;
        --text-muted: #64748b;
        --bg-white: #ffffff;
        --border-color: #f1f5f9;
        --transition-fast: 0.25s ease;
    }

    body {

        margin: 0;
    }

    /* HEADER CONTAINER */
    .header2 {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        background: var(--bg-white);
        border-bottom: 1px solid var(--border-color);
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
        z-index: 1000;
        transition: all var(--transition-fast);
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }

    .header2.scrolled {
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    }

    /* MASTER BAR CONTAINER */
    .header-master-container {
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
    }

    /* CENTERED MAIN COLUMN */
    .header-inner-stack {
        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    /* TOP EXTRA ROWS (ROW 1 & 2) */
    .row-1-display,
    .row-2-display {
        width: 100%;
        font-size: 0.85rem;
        color: var(--text-muted);
        display: flex;
        justify-content: center;
        align-items: center;
    }

    /* NAVIGATION LINKS ROW (ROW 3) */
    .row-3-nav {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 24px;
        flex-wrap: wrap;
        background: white;
        border-bottom: 2px solid lightgrey;
        width: 100%;

    }

    .row-3-nav a {
        color: var(--text-dark);
        text-decoration: none;
        font-size: 0.95rem;
        font-weight: 500;
        padding: 6px 4px;
        position: relative;
        transition: color var(--transition-fast);
    }

    .row-3-nav a:hover {
        color: var(--primary-red);
    }

    /* Hover underline effect */
    .row-3-nav a::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        width: 0;
        height: 2px;
        background: var(--primary-red);
        transition: all var(--transition-fast);
        transform: translateX(-50%);
    }

    .row-3-nav a:hover::after {
        width: 100%;
    }

    /* FIXED ABSOLUTE CONNECT BUTTON */
    .cta-container {
        position: absolute;
        right: 24px;
        bottom: 14px;
        /* Perfectly aligned to the bottom navigation bar row */
    }

    .cta-container a {
        background: var(--primary-red);
        color: #ffffff !important;
        text-decoration: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-size: 0.9rem;
        font-weight: 600;
        box-shadow: 0 4px 6px -1px rgba(166, 35, 34, 0.2);
        transition: all var(--transition-fast);
        display: inline-block;
    }

    .cta-container a:hover {
        background: var(--primary-red-hover);
        transform: translateY(-1px);
        box-shadow: 0 6px 12px -1px rgba(166, 35, 34, 0.3);
    }

    /* HAMBURGER (MOBILE ONLY) */
    .hamburger {
        display: none;
        font-size: 24px;
        cursor: pointer;
        color: var(--text-dark);
        position: absolute;
        right: 24px;
        top: 50%;
        transform: translateY(-50%);
        user-select: none;
    }

    /* --- SIDE MOBILE SLIDEOUT MENU --- */
    .side-menu {
        top: 0;
        right: -300px;
        width: 300px;
        height: 100%;
        background: var(--bg-white);
        box-shadow: -4px 0 20px rgba(0, 0, 0, 0.05);
        z-index: 1100;
        transition: right 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        padding: 40px 24px;
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .side-menu.open {
        right: 0;
    }

    .side-menu a {
        color: var(--text-dark);
        text-decoration: none;
        font-size: 1.1rem;
        font-weight: 500;
        padding: 12px 0;
        border-bottom: 1px solid var(--border-color);
        transition: color var(--transition-fast);
    }

    .side-menu a:hover {
        color: var(--primary-red);
    }

    .close-menu {
        font-size: 32px;
        cursor: pointer;
        align-self: flex-end;
        color: var(--text-muted);
        margin-bottom: 20px;
        line-height: 1;
    }

    /* OVERLAY SHADOW */
    .overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(15, 23, 42, 0.3);
        backdrop-filter: blur(4px);
        z-index: 1050;
        opacity: 0;
        visibility: hidden;
        transition: all 0.25s ease;
    }

    .overlay.show {
        opacity: 1;
        visibility: visible;
    }

    /* RESPONSIVE LAYOUT breakpoints */
    @media (max-width: 991px) {
        .cta-container {
            position: static;
            margin-top: 10px;
        }

        .header-master-container {}
    }

    @media (max-width: 768px) {
        .header-inner-stack {
            align-items: flex-start;
            text-align: left;
        }

        .row-1-display,
        .row-2-display {
            justify-content: flex-start;
        }

        .row-3-nav,
        .cta-container {
            display: none;
            /* Hidden on mobile device viewports */
        }

        .hamburger {
            display: block;
        }

        .header-master-container {
            padding: 16px 24px;
            flex-direction: row;
            justify-content: space-between;
        }
    }
</style>