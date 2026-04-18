<div class="section-2" id="next-section">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap');

        :root {
            --bg-dark: #0a0a0b;
            /* True deep matte black */
            --card-dark: #141417;
            /* Slightly lighter surface */
            --accent: #00f5ff;
            /* Sharp cyan for focus */
            --border-color: #26262b;
            /* Subtle solid border */
            --text-muted: #94a3b8;
        }

        .section-2 {
            min-height: 100vh;
            width: 100%;
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-dark);
            /* Solid dark background */
            color: #ffffff;
            line-height: 1.6;
        }

        /* Replaced Glass Card with Matte Card */
        .matte-card {
            display: block;
            width: 100%;

            /* Sharper corners for pro look */
            background: var(--card-dark);
            border: 1px solid var(--border-color);
            box-shadow: 0 40px 100px rgba(0, 0, 0, 0.5);
            transition: transform 0.3s ease;
        }

        .section-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-header h2 {
            font-size: 2.5rem;
            font-weight: 700;
            letter-spacing: -1px;
            margin-bottom: 20px;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .intro-text {
            max-width: 700px;
            margin: 0 auto;
            font-size: 1.1rem;
            color: var(--text-muted);
        }

        .image-container {
            width: 100%;
            margin: 40px 0;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid var(--border-color);
        }

        .image-hover {
            width: 100%;
            height: auto;
            display: block;
            filter: grayscale(20%);
            transition: all 0.5s ease;
        }

        .image-hover:hover {
            filter: grayscale(0%);
            transform: scale(1.02);
        }

        /* Adjusting the sticky header to match */
        #sticky-header-2 {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            padding: 0;
            text-align: center;
            z-index: 10000;
            background: rgba(10, 10, 11, 0.98);
            /* Near solid */
            opacity: 0;
            visibility: hidden;
            transform: translateY(-100%);
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        #sticky-header-2.is-active {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
    </style>

    <div class="matte-card">
        <div class="section-header">
            <h2>Thank You for Your Support</h2>
            <p class="intro-text">
                IITM is India's premier platform for travel-trade exhibitions, fostering meaningful B2B and B2C
                interactions across major metropolitan hubs.
            </p>
        </div>

        <div class="image-container">
        </div>

        <div class="content-wrapper">
            @include('web.components.cities')
            @include('web.components.whyexhibit')
            @include('web.components.vision')
            @include('web.components.exhibit')
            @include('web.components.about')
            @include('web.components.keyperformancehighlights')
            @include('web.components.contactus')
            @include('web.components.tourismboard')
        </div>
    </div>
</div>

<div id="sticky-header-2">
    @include('web.header2')
</div>
<script>
    const secondHeader = document.getElementById('sticky-header-2');
    const triggerSection = document.getElementById('next-section');

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            // When Section 2 top enters the screen
            if (entry.isIntersecting) {
                secondHeader.classList.add('is-active');
            } else {
                // Remove when scrolling back up to Section 1
                secondHeader.classList.remove('is-active');
            }
        });
    }, {
        rootMargin: "-10% 0px -90% 0px" // Triggers when Section 2 is near the top
    });

    observer.observe(triggerSection);
</script>