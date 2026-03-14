
<?php 

    include(APPPATH . 'Views/mainmenu/header.php');


?>




<div class="menu-grid">
        <a href="<?= base_url('calendar') ?>" class="menu-item">
    <div class="icon-box">
        <span class="material-icons-round">event_available</span>
    </div>
    <div class="menu-content">
        <span class="menu-label">My Events</span>
        <span class="menu-sub">View upcoming shows</span>
    </div>
</a>
        <a href="#" class="menu-item">
            <div class="icon-box">
                <span class="material-icons-round">qr_code_scanner</span>
            </div>
            <span class="menu-label">Scan Leads</span>
            <span class="menu-sub">Capture visitor info</span>
        </a>
        <a href="#" class="menu-item">
            <div class="icon-box">
                <span class="material-icons-round">confirmation_number</span>
            </div>
            <span class="menu-label">Stall Booking</span>
            <span class="menu-sub">Reserve your space</span>
        </a>
        <a href="#" class="menu-item">
            <div class="icon-box">
                <span class="material-icons-round">groups</span>
            </div>
            <span class="menu-label">B2B Meetings</span>
            <span class="menu-sub">Networking schedule</span>
        </a>
    <a href="<?= base_url('layout') ?>" class="menu-item">
            <div class="icon-box">
                <span class="material-icons-round">file_download</span>
            </div>
            <span class="menu-label">Floor Plan</span>
            <span class="menu-sub">Download layouts</span>
        </a>
        <a href="#" class="menu-item">
            <div class="icon-box">
                <span class="material-icons-round">badge</span>
            </div>
            <span class="menu-label">E-Badge</span>
            <span class="menu-sub">Digital entry pass</span>
        </a>
    </div>
