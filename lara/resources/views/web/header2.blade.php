@include('web.templates.header.h2');

<header class="header2" id="iitmHeader">
    <div class="header-inner">
        <div class="logo">
            <style>
                /* LOGO */
                .logo {
                    display: flex;
                    align-items: center;
                    flex-shrink: 0;
                }

                .logo img {
                    height: clamp(90px, 5vw, 150px);
                    width: auto;
                    transition: var(--transition);
                }
            </style>
            <img id="iitmLogoImg" src="{{ asset('public/assets/iitm3.png') }}" alt="Logo">
            <!-- <img id="iitmLogoImg" src="{{ asset('public/assets/maroon.png') }}" alt="Logo"> -->
        </div>
        <nav class="nav-links">
            <style>
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

                    /* 3D text effect */
                    text-shadow:
                        1px 1px 0 rgba(0, 0, 0, 0.15),
                        2px 2px 0 rgba(0, 0, 0, 0.10),
                        3px 3px 6px rgba(0, 0, 0, 0.10);

                    transform: translateZ(0);
                    transition: var(--transition);
                }

                .header2.scrolled .nav-links a {
                    color: #ffffff;
                    text-shadow:
                        1px 1px 0 rgba(0, 0, 0, 0.25),
                        2px 2px 6px rgba(0, 0, 0, 0.25);
                }

                .nav-links a:hover {
                    opacity: 0.9;
                    transform: translateY(-2px);
                    text-shadow:
                        2px 2px 0 rgba(0, 0, 0, 0.2),
                        4px 4px 10px rgba(0, 0, 0, 0.15);
                }
            </style>

            <a href="{{ route('web') }}">Home</a>
            <a href="{{ route('exhibiting') }}">Exhibit</a>
            <a href="{{ route('attending') }}">Visit</a>
            <a href="{{ route('register.now') }}">Register</a>
            <a href="{{ route('resourcepage') }}">Resources</a>
            <a href="{{ route('gallery') }}">Gallery</a>
            <a href="{{ route('aboutus') }}">About us</a>
            <!-- <a href="{{ route('contactus') }}">Contact</a> -->
        </nav>

        <div class="cta">
            <a href="{{ route('contactus') }}">Connect Now</a>

        </div>

        <div class="hamburger" onclick="iitmToggleMenu()">☰</div>
    </div>
</header>
@include('web.templates.chatbot.chatbot')