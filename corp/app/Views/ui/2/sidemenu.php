<style>
    /* 1. LAYOUT RESET: Make wrapper vertical so sub-nav sits on top of content */
    .wrapper {
        display: flex;
        flex-direction: column; 
        min-height: auto;
    }

    /* 2. SUB-NAV CONTAINER (Formerly Sidebar) */
    .sidebar {
        width: 100% !important; /* Force full width */
        height: auto !important; /* Remove fixed height */
        background-color: var(--nav-color);
        color: #fff;
        padding: 10px 20px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        position: sticky;
        top: 0; /* Adjust this if you have a main header above it */
        z-index: 99;
        
        /* Flexbox to align items horizontally */
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        box-sizing: border-box;
    }

    /* 3. SEARCH BOX ADJUSTMENTS */
    .search-box {
        flex: 1; /* Allows search to take available space */
        max-width: 400px;
    }
    
    .search-box form {
        display: flex;
        gap: 5px;
    }

    .search-box input[type="text"] { 
        padding: 8px 12px; 
        border-radius: 6px; 
        border: none; 
        width: 100%; /* Fill the form container */
    }

    /* 4. TICKET CONTAINER ADJUSTMENTS */
    .ticket-container {
        width: auto !important; /* Override vertical 100% */
        padding-top: 0 !important; /* Remove vertical spacing */
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .btn-compact {
        min-width: 100px;
        height: 38px !important; /* Slightly taller for horizontal look */
        padding: 0 15px !important;
    }

    /* 5. CONTENT AREA */
    .content {
        padding: 20px;
        background-color: var(--body-color);
        flex-grow: 1;
    }

    /* Mobile view: Stack them if screen is too narrow */
    @media(max-width: 600px){
        .sidebar {
            flex-direction: column;
            align-items: stretch;
            gap: 10px;
        }
        .search-box {
            max-width: 100%;
        }
    }
</style>
        <?= view('ticketform') ?>

    <div class="sidebar">
        
        <div class="search-box">
            <form action="<?= base_url('search') ?>" method="get">
                <input type="text" name="q" placeholder="Search Database..." required>
                <button type="submit">🔍</button>
            </form>
        </div>

        <div class="ticket-container">
            <button type="button" class="btn-compact" onclick="openModal()">
                <span class="plus-icon">+</span> Ticket
            </button>

            <a href="<?= site_url('tools') ?>" class="btn-compact">
                Tools
            </a>
        </div>
    </div>

