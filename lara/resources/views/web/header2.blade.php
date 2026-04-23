<style>
    *,
    *::before,
    *::after {
        box-sizing: border-box;
    }

    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

    :root {
        --primary-red: rgb(179, 66, 65);
        --transition: all 0.35s ease;
    }

    body {
        margin: 0;
        padding-top: 64px;
    }

    .header2 {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 1000;
        background: #ffffff;
        transition: var(--transition);
        font-family: 'Inter', sans-serif;
        border-bottom: 1px solid rgba(0, 0, 0, 0.06);
    }

    .header2.scrolled {
        background: var(--primary-red);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .header-inner {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 5%;
        max-width: 1400px;
        margin: 0 auto;
        width: 100%;
        overflow: hidden;
    }

    .logo {
        height: 42px;
        display: flex;
        align-items: center;
        flex-shrink: 0;
    }

    .logo img {
        height: 100%;
        transition: var(--transition);
    }

    .nav-links {
        display: flex;
        gap: 24px;
        align-items: center;
        min-width: 0;
    }

    .nav-links a {
        text-decoration: none;
        color: var(--primary-red);
        font-size: 15px;
        font-weight: 500;
        transition: var(--transition);
        white-space: nowrap;
    }

    .header2.scrolled .nav-links a {
        color: #ffffff;
    }

    .nav-links a:hover {
        opacity: 0.7;
    }

    .cta a {
        background: transparent;
        color: var(--primary-red);
        padding: 10px 22px;
        border-radius: 999px;
        border: 2px solid var(--primary-red);
        text-decoration: none;
        font-weight: 700;
        transition: var(--transition);
        font-size: 14px;
        white-space: nowrap;
    }

    .header2.scrolled .cta a {
        background: #ffffff;
        color: var(--primary-red);
        border: 2px solid #ffffff;
    }

    .hamburger {
        display: none;
        font-size: 28px;
        cursor: pointer;
        color: var(--primary-red);
        user-select: none;
        flex-shrink: 0;
        margin-left: 12px;
    }

    .header2.scrolled .hamburger {
        color: #ffffff;
    }

    .side-menu {
        position: fixed;
        top: 0;
        right: -280px;
        width: 280px;
        height: 100%;
        background: #1a1a1a;
        padding: 80px 30px;
        display: flex;
        flex-direction: column;
        gap: 20px;
        transition: var(--transition);
        z-index: 2001;
        box-shadow: -5px 0 15px rgba(0, 0, 0, 0.2);
    }

    .side-menu.open {
        right: 0;
    }

    .side-menu a {
        color: #ffffff;
        text-decoration: none;
        font-size: 18px;
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

    .overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.6);
        opacity: 0;
        visibility: hidden;
        transition: var(--transition);
        z-index: 2000;
        backdrop-filter: blur(4px);
    }

    .overlay.show {
        opacity: 1;
        visibility: visible;
    }

    @media (max-width: 992px) {
        .nav-links {
            display: none;
        }

        .hamburger {
            display: block;
        }

        .cta a {
            padding: 8px 14px;
            font-size: 13px;
        }
    }

    @media (max-width: 400px) {
        .cta a {
            padding: 7px 10px;
            font-size: 12px;
        }

        .logo {
            height: 34px;
        }
    }
</style>

<header class="header2" id="iitmHeader">
    <div class="header-inner">
        <div class="logo">
            <img id="iitmLogoImg" src="https://iitmindia.com/assets/iitm3.png" alt="Logo">
        </div>

        <nav class="nav-links">
            <a href="{{ route('web') }}">Home</a>
            <a href="{{ route('exhibiting') }}">Exhibit</a>
            <a href="{{ route('attending') }}">Visit</a>
            <a href="/resources">Resources</a>
            <a href="{{ route('gallery') }}">Gallery</a>
            <a href="/about-us">About</a>

            <a href="/contact-us">Contact</a>
        </nav>

        <div class="cta">
            <a href="/enquiry">Connect Now</a>
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
    (function () {
        const iitmHeader = document.getElementById("iitmHeader");
        const iitmLogo = document.getElementById("iitmLogoImg");
        const iitmSideMenu = document.getElementById("iitmSideMenu");
        const iitmOverlay = document.getElementById("iitmOverlay");

        window.addEventListener("scroll", () => {
            if (window.scrollY > 50) {
                iitmHeader.classList.add("scrolled");
                iitmLogo.src = "https://iitmindia.com/assets/iitm2.png";
            } else {
                iitmHeader.classList.remove("scrolled");
                iitmLogo.src = "https://iitmindia.com/assets/iitm3.png";
            }
        });

        window.iitmToggleMenu = function () {
            iitmSideMenu.classList.toggle("open");
            iitmOverlay.classList.toggle("show");

            if (iitmSideMenu.classList.contains("open")) {
                document.body.style.overflow = "hidden";
            } else {
                document.body.style.overflow = "auto";
            }
        };
    })();
</script>