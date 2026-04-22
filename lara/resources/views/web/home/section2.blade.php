<div class="section-2" id="iitmNextSection">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap');

        :root {
            --bg-dark: #0a0a0b;
            --card-dark: #141417;
            --accent: #00f5ff;
            --border-color: #26262b;
            --text-muted: #94a3b8;
        }

        .section-2 {
            min-height: 100vh;
            width: 100%;
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-dark);
            color: #ffffff;
            line-height: 1.6;
            position: relative;
            /* Ensure this section doesn't overlap the mobile menu */
            z-index: 1;
        }

        .matte-card {
            display: block;
            width: 100%;
            background: var(--card-dark);
            border: 1px solid var(--border-color);
            box-shadow: 0 40px 100px rgba(0, 0, 0, 0.5);
        }

        /* ... other styles remain same ... */

        #iitmStickyHeader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            padding: 0;
            /* IMPORTANT: 
               Keep this lower than side-menu (usually 2000+) 
               but higher than page content.
            */
            z-index: 1000;
            background: rgba(10, 10, 11, 0.98);
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            /* Prevents ghost clicks when hidden */
            transform: translateY(-100%);
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        #iitmStickyHeader.is-active {
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
            /* Re-enable clicks when visible */
            transform: translateY(0);
        }

        /* Fix for Mobile Menu: 
           Ensure that when the side-menu is open, 
           it is ALWAYS on top of this sticky wrapper.
        */
        .side-menu {
            z-index: 9999 !important;
        }

        .overlay {
            z-index: 9998 !important;
        }
    </style>

    <div class="matte-card">
        <div class="section-wrapper">
            <style>
                .section-wrapper {
                    padding: 15px 5px;
                    text-align: center;
                    background-color: #0a0a0b;
                    font-family: 'Inter', sans-serif;
                }

                .section-header {
                    max-width: 900px;
                    margin: 0 auto;
                }

                /* Fancy Animated Title */
                .section-header h2 {
                    font-size: clamp(2.5rem, 5vw, 4rem);
                    font-weight: 900;
                    margin-bottom: 20px;
                    letter-spacing: -1px;
                    color: #ffffff;
                    line-height: 1.1;
                }

                /* Highlighting the keywords with your brand variable */
                .highlight-text {
                    color: var(--iitm-background2);
                    text-shadow: 0 0 30px color-mix(in srgb, var(--iitm-background2), transparent 60%);
                    display: inline-block;
                    position: relative;
                }

                .intro-text {
                    color: #94a3b8;
                    font-size: 1.25rem;
                    line-height: 1.6;
                    max-width: 700px;
                    margin: 0 auto;
                    position: relative;
                }

                /* Subtle decorative line under the header */
                .section-header::after {
                    content: '';
                    display: block;
                    width: 60px;
                    height: 4px;
                    background: var(--iitm-background2);
                    margin: 30px auto 0;
                    border-radius: 2px;
                    box-shadow: 0 0 15px var(--iitm-background2);
                }

                /* Animated Entrance */
                .section-header {
                    opacity: 0;
                    transform: translateY(20px);
                    animation: fadeInUp 1s ease forwards;
                }

                @keyframes fadeInUp {
                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }
            </style>

            <div class="section-header">
                <h2>
                    <span class="highlight-text">Reconnect.</span>
                    <span class="highlight-text">Network.</span>
                    <span class="highlight-text">Exhibit.</span>
                </h2>

            </div>
        </div>

        <div class="content-wrapper">
            @include('web.templates.keyperformancehighlights')
            @include('web.templates.intro')
            @include('web.templates.cities')
            @include('web.templates.whyexhibit')
            @include('web.templates.vision')
            @include('web.templates.exhibit')
            @include('web.templates.about')
            @include('web.templates.contactus')
            @include('web.templates.tourismboard')
        </div>
    </div>
</div>
<style>
    .side-menu {
        height: auto !important;
    }
</style>
<div id="iitmStickyHeader">
    @include('web.header2')
</div>

<script>
    (function () {
        const iitmStickyHeaderEl = document.getElementById('iitmStickyHeader');
        const iitmTriggerSection = document.getElementById('iitmNextSection');

        if (!iitmStickyHeaderEl || !iitmTriggerSection) return;

        const iitmSectionObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                // If the section is in view, show the sticky header
                if (entry.isIntersecting) {
                    iitmStickyHeaderEl.classList.add('is-active');
                } else {
                    iitmStickyHeaderEl.classList.remove('is-active');
                }
            });
        }, {
            // Adjust these values to control exactly when the header pops in
            rootMargin: "-5% 0px -95% 0px"
        });

        iitmSectionObserver.observe(iitmTriggerSection);
    })();
</script>