
<style>
    .active {
    font-weight: bold;
    color: #007bff;
}

</style>

<style>
/* Flex container for sidebar + main content */
.wrapper {
    display: flex;
    min-height: 100vh; /* full viewport height */
}

/* Left sidebar styling */
.sidebar {
    width: 220px;
    background-color: var(--nav-color);
    color: #fff;
    padding: 20px;
    box-shadow: 2px 0 5px rgba(0,0,0,0.1);
    flex-shrink: 0;
}

.sidebar h3 {
    margin-top: 0;
    font-size: 18px;
    margin-bottom: 15px;
}

.sidebar a {
    display: block;
    color: white;
    text-decoration: none;
    margin-bottom: 10px;
    padding: 8px 12px;
    border-radius: 6px;
    transition: 0.3s;
}

.sidebar a:hover {
    background-color: #8b1d20;
}

/* Main content area */
.content {
    flex-grow: 1;
    padding: 20px;
    background-color: var(--body-color);
}
.sidebar {
    position: sticky;
    top: 50px; /* leave space for the nav */
    height: calc(100vh - 60px); /* full viewport height minus nav */
    overflow-y: auto; /* scroll if content exceeds height */
}

/* Responsive: collapse sidebar on small screens */
@media(max-width: 768px){
    .wrapper {
        flex-direction: column;
    }
    .sidebar {
        width: 100%;
    }
}


        /* Search box styling */
        .search-box input[type="text"] { 
            padding: 6px 10px; 
            border-radius: 8px; 
            border: none; 
            outline: none;
            width: 70%;
            transition: all 0.3s ease;
        }

        .search-box input[type="text"]:focus {
            box-shadow: 0 0 8px rgba(168, 35, 36, 0.7); /* glow effect in red palette */
        }

        .search-box button { 
            padding: 6px 5%; 
            border: none; 
            border-radius: 8px; 
    background: var(--button-color);
            color: #fff; 
            cursor: pointer; 
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .search-box button:hover { 
            background: #8b1d20; /* darker red hover */
            transform: translateY(-2px);
            box-shadow: 0 3px 8px rgba(0,0,0,0.2);
        }
</style>


<?= view('ticketform')?>


<div class="sidebar">


<div class="search-box">
    <form action="<?= base_url('search') ?>" method="get">
        <input type="text" name="q" placeholder="Search..." required>
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

<style>
    .ticket-container {
        width: 100%;
        padding-top: 15px;
        display: flex;
        gap: 8px;
        /* Ensures both children stretch to the same height */
        align-items: stretch; 
    }

    .btn-compact {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        
        /* Fixed sizing for perfect symmetry */
        height: 34px; /* Explicit height for identical look */
        padding: 0 5px; /* Horizontal padding only */
        box-sizing: border-box; /* Includes border/padding in height calculation */
        
        /* Aesthetic */
        background-color: var(--button-color); 
        color: #ffffff !important;
        text-decoration: none;
        font-size: 0.85rem;
        font-weight: 500;
        
        /* Shape */
        border: none;
        border-radius: 4px;
        cursor: pointer;
        white-space: nowrap;
        
        /* Interactions */
        transition: opacity 0.2s ease, transform 0.1s ease;
    }

    .btn-tools {
        background-color: #6c757d;
    }

    .btn-compact:hover {
        opacity: 0.9; 
    }

    .btn-compact:active {
        transform: scale(0.96);
    }

    .plus-icon {
        font-size: 1rem;
        /* Helps center the icon vertically with text */
        display: inline-flex;
        align-items: center;
        height: 100%;
    }
</style>

<style>
    .submenu{
        text-align:center;
        padding-top:20px;
    }
</style>
