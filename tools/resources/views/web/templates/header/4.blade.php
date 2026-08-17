@php
    $segments = request()->segments();

    $lastSegment = end($segments);
    $secondlastSegment = count($segments) > 1
        ? $segments[count($segments) - 2]
        : null;
@endphp
@include('web.templates.header.4.css')

<meta name="viewport" content="width=device-width, initial-scale=1.0">


<header class="header2" id="iitmHeader">
    <div class="header-master-container">

        <!-- Center Column Housing All 3 Rows cleanly -->
        <div class="header-inner-stack">

            <!-- ROW 1 -->
            <div class="row-1-display">
                @include('web.templates.header.4.1')
            </div>

            <!-- ROW 2 -->
            <div class="row-2-display">
                @include('web.templates.header.4.2')
            </div>

            <!-- ROW 3 (Main Menu Centered) -->
            <nav class="row-3-nav">
                <a href="{{ route('web') }}">Home</a>
                <a href="{{ route('exhibiting') }}">Exhibit</a>
                <a href="{{ route('attending') }}">Visit</a>
                <a href="{{ route('register.now') }}">Register</a>
                <a href="{{ route('resourcepage') }}">Resources</a>
                <a href="{{ route('gallery') }}">Gallery</a>
                <a href="{{ route('aboutus') }}">About us</a>
            </nav>

        </div>

        <!-- Call to Action Action Button (Aligned cleanly on right flank) -->


        <!-- Trigger Device Hamburger Menu -->
        <!-- <div class="hamburger" onclick="iitmToggleMenu()">☰</div> -->

    </div>
</header>

<!-- MOBILE DRAWER MENU OVERLAYS -->


<!-- <div class="side-menu" id="iitmSideMenu">
    <span class="close-menu" onclick="iitmToggleMenu()">&times;</span>
    <a href="{{ route('web') }}" onclick="iitmToggleMenu()">Home</a>
    <a href="/about-us" onclick="iitmToggleMenu()">About</a>
    <a href="{{ route('exhibiting') }}" onclick="iitmToggleMenu()">Exhibit</a>
    <a href="{{ route('attending') }}" onclick="iitmToggleMenu()">Visit</a>
    <a href="/resources" onclick="iitmToggleMenu()">Resources</a>
    <a href="/gallery" onclick="iitmToggleMenu()">Gallery</a>
    <a href="/contact-us" onclick="iitmToggleMenu()">Contact</a>
    <a href="/enquiry" style="color: var(--primary-red); font-weight: bold;">Connect Now</a>
</div> -->

<div class="overlay" id="iitmOverlay" onclick="iitmToggleMenu()"></div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const iitmHeader = document.getElementById("iitmHeader");
        const iitmLogo = document.getElementById("iitmLogoImg");
        const iitmSideMenu = document.getElementById("iitmSideMenu");
        const iitmOverlay = document.getElementById("iitmOverlay");

        window.addEventListener("scroll", () => {
            if (window.scrollY > 50) {
                if (iitmHeader) iitmHeader.classList.add("scrolled");
                if (iitmLogo) iitmLogo.src = "{{ asset('public/assets/iitm3.png') }}";
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

@include('web.templates.chatbot.chatbot')

<!-- Added margin container buffer to match variable template headers height spacing metrics -->
<div style="margin-top:160px"></div>