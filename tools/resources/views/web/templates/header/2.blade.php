@php
    $segments = request()->segments();

    $lastSegment = end($segments);
    $secondlastSegment = count($segments) > 1
        ? $segments[count($segments) - 2]
        : null;
@endphp

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
    /* Global Resets & Layout Safety */
    *,
    *::before,
    *::after {
        box-sizing: border-box;
    }

    @import url('https://fonts.googleapis.com/css2?family=Inter:wght=400;500;600;700&display=swap');

    :root {
        --primary-red: rgb(179, 66, 65);
        --transition: all 0.35s ease;
    }

    /* FIX: Prevents the off-screen mobile side menu from expanding viewport dimensions */
    html,
    body {
        margin: 0;
        padding: 0;
        overflow-x: hidden;
        width: 100%;
    }

    body {
        font-family: 'Inter', sans-serif;
    }

    /* HEADER CONTAINER */
    .header2 {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 1000;
        background: #ffffffff;
        transition: var(--transition);
        border-bottom: 2px solid rgba(0, 0, 0, 0.06);
    }

    .header2.scrolled {
        background: var(--primary-red);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .header2.hidden {
        transform: translateY(-100%);
        pointer-events: none;
    }

    .header-inner {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: clamp(10px, 2vw, 18px) 5%;
        max-width: 1400px;
        margin: 0 auto;
        width: 100%;

    }

    /* LOGO OBJECT MANAGEMENT */
    .logo {
        display: flex;
        align-items: center;
        flex-shrink: 0;
    }

    .logo img {
        height: 90px;
        /* Adjusted to prevent viewport height blowouts */
        border: 2px solid #B34241;
        width: auto;
        transition: var(--transition);
        filter: drop-shadow(1px 1px 0 rgba(0, 0, 0, 0.4)) drop-shadow(3px 3px 0 rgba(0, 0, 0, 0.25));
    }

    /* DESKTOP NAVIGATION */
    .nav-links {
        display: flex;
        gap: clamp(16px, 2vw, 28px);
        align-items: center;
    }

    .nav-links a {
        text-decoration: none;
        color: var(--primary-red);
        font-size: clamp(13px, 1.2vw, 16px);
        font-weight: 600;
        white-space: nowrap;
        transform: translateZ(0);
        transition: var(--transition);
        text-shadow: 1px 1px 0 rgba(0, 0, 0, 0.15), 3px 3px 6px rgba(0, 0, 0, 0.10);
    }

    .header2.scrolled .logo img {
        border-color: #ffffff;
    }

    .header2.scrolled .nav-links a {
        color: #ffffff;
        text-shadow: 1px 1px 0 rgba(0, 0, 0, 0.25);
    }

    .nav-links a:hover {
        transform: translateY(-2px);
    }

    /* CALL TO ACTION BUTTON */
    .cta a {
        background: transparent;
        color: var(--primary-red);
        padding: clamp(6px, 1vw, 10px) clamp(12px, 2vw, 22px);
        border-radius: 999px;
        border: 2px solid var(--primary-red);
        text-decoration: none;
        font-weight: 700;
        transition: var(--transition);
        font-size: clamp(12px, 1.2vw, 14px);
        white-space: nowrap;
    }

    .header2.scrolled .cta a {
        background: #ffffff;
        color: var(--primary-red);
        border: 2px solid #ffffff;
    }

    /* HAMBURGER BUTTON */
    .hamburger {
        display: none;
        font-size: clamp(24px, 4vw, 32px);
        cursor: pointer;
        color: var(--primary-red);
        user-select: none;
        margin-left: 15px;
    }

    .header2.scrolled .hamburger {
        color: #ffffff;

    }

    /* INTERACTIVE SIDE SLIDE MENU */
    .side-menu {
        position: fixed;
        top: 0;
        right: -300px;
        width: min(75vw, 280px);
        height: 100%;
        background: #1a1a1a;
        padding: 80px 30px;
        display: flex;
        flex-direction: column;
        gap: 20px;
        transition: var(--transition);
        z-index: 2002;
        box-shadow: -5px 0 15px rgba(0, 0, 0, 0.2);
    }

    .side-menu.open {
        right: 0;
    }

    .side-menu a {
        color: #ffffff;
        text-decoration: none;
        font-size: clamp(16px, 2vw, 18px);
        font-weight: 500;
        border-bottom: 1px solid #333;
        padding-bottom: 10px;
    }

    .close-menu {
        position: absolute;
        top: 20px;
        right: 20px;
        color: white;
        font-size: 30px;
        cursor: pointer;
    }

    /* OVERLAY BACKGROUND */
    .overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.6);
        opacity: 0;
        visibility: hidden;
        transition: var(--transition);
        z-index: 2001;
        backdrop-filter: blur(4px);
    }

    .overlay.show {
        opacity: 1;
        visibility: visible;
    }

    /* BREAKPOINTS FOR RESPONSIVITY */
    @media (max-width: 992px) {
        .nav-links {
            display: none;
        }

        .hamburger {
            display: block;
        }
    }

    @media (max-width: 480px) {
        .logo img {
            height: 45px;
            /* Clean mobile sizing restraint override */
        }

        .cta {
            display: none;
            /* Recommended for tiny viewports to avoid overlapping items */
        }
    }
</style>

<header class="header2" id="iitmHeader">
    <div class="header-inner" id="iitminnerheader">
        <div class="logo">
            <img id="iitmLogoImg" src="{{ asset('public/assets/iitm3.png') }}" alt="Logo">
        </div>

        <nav class="nav-links">
            <a href="{{ route('web') }}">Home</a>
            <a href="{{ route('exhibiting') }}">Exhibit</a>
            <a href="{{ route('attending') }}">Visit</a>
            <a href="{{ route('register.now') }}">Register</a>
            <a href="{{ route('resourcepage') }}">Resources</a>
            <a href="{{ route('gallery') }}">Gallery</a>
            <a href="{{ route('aboutus') }}">About us</a>
        </nav>
        <?php

// echo $lastSegment;
// echo $secondlastSegment;

?>
        <div class="cta">
            <a href="{{ route('contactus') }}">Connect Now</a>
        </div>

        <div class="hamburger" onclick="iitmToggleMenu()">☰</div>
    </div>
</header>

<div class="side-menu" id="iitmSideMenu">
    <span class="close-menu" onclick="iitmToggleMenu()">&times;</span>
    <a href="{{ route('web') }}" onclick="iitmToggleMenu()">Home</a>
    <a href="/about-us" onclick="iitmToggleMenu()">About</a>
    <a href="{{ route('exhibiting') }}" onclick="iitmToggleMenu()">Exhibit</a>
    <a href="{{ route('attending') }}" onclick="iitmToggleMenu()">Visit</a>
    <a href="/resources" onclick="iitmToggleMenu()">Resources</a>
    <a href="/gallery" onclick="iitmToggleMenu()">Gallery</a>
    <a href="/contact-us" onclick="iitmToggleMenu()">Contact</a>
    <a href="/enquiry" style="color: var(--primary-red); font-weight: bold;">Connect Now</a>
</div>

<div class="overlay" id="iitmOverlay" onclick="iitmToggleMenu()"></div>

<script>
    // Initialized safely on DOM contents ready to avoid element targeting failures
    document.addEventListener("DOMContentLoaded", function () {
        const iitmHeader = document.getElementById("iitmHeader");
        const iitmHeaderinner = document.getElementById("iitminnerheader");
        const iitmLogo = document.getElementById("iitmLogoImg");
        const iitmSideMenu = document.getElementById("iitmSideMenu");
        const iitmOverlay = document.getElementById("iitmOverlay");

        window.addEventListener("scroll", () => {
            if (window.scrollY > 50) {
                if (iitmHeader) iitmHeader.classList.add("scrolled");

                if (iitmLogo) iitmLogo.src = "{{ asset('public/assets/iitm2.png') }}";
            } else {
                if (iitmHeader) iitmHeader.classList.remove("scrolled");
                if (iitmLogo) iitmLogo.src = "{{ asset('public/assets/iitm3.png') }}";
            }
        });

        window.iitmToggleMenu = function () {
            if (iitmSideMenu && iitmOverlay) {
                iitmSideMenu.classList.toggle("open");
                iitmOverlay.classList.toggle("show");

                if (iitmSideMenu.classList.contains("open")) {
                    document.body.style.overflow = "hidden";
                } else {
                    document.body.style.overflow = "auto";
                    document.body.style.overflowX = "hidden";
                }
            }
        };
    });
</script>

@if(env('CHATBOT', false))
    @include('web.templates.chatbot.chatbot')

@endif


<div style="margin-top:125px"></div>