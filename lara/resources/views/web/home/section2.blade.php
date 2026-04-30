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
                    padding: 30px 10px 20px;
                    /* Increased breathing room */
                    text-align: center;
                    background-color: #ffffff;
                    /* Prestigious white background */
                    font-family: 'Inter', sans-serif;
                    background-image: radial-gradient(#eee 1px, transparent 1px);
                    background-size: 30px 30px;
                    /* Subtle architectural grid */
                }

                .section-header {
                    max-width: 1000px;
                    margin: 0 auto;
                }

                /* High-End Serif Title */
                .section-header h2 {
                    height: 10vh;
                    font-family: Georgia, serif;
                    font-size: clamp(2.5rem, 6vw, 4.5rem);
                    font-weight: normal;
                    margin-bottom: 10px;
                    margin-top: 10px;
                    letter-spacing: -1px;
                    color: #111;
                    /* Sharp black */
                    line-height: 1;
                }

                /* The IITM Crimson Highlight */
                .highlight-text {
                    color: #aa2324;
                    /* Official IITM Red */
                    display: inline-block;
                    position: relative;
                    padding: 0 5px;
                }

                /* Clean Corporate Subtext */
                .intro-textx {
                    color: #aa2324;
                    font-size: 1.35rem;
                    line-height: 1.8;
                    max-width: 750px;
                    margin: 0 auto;
                    font-weight: 300;
                }

                /* Formal decorative line - No Glow, just Solid Brand Red */
                .section-header::after {
                    content: '';
                    display: block;
                    width: 80%;
                    height: 4px;
                    background: #aa2324;
                    margin: 20px auto 0;
                    border-radius: 0px;
                    /* Sharp, professional edges */
                }

                /* Subtle Professional Entrance */
                .section-header {
                    opacity: 0;
                    transform: translateY(15px);
                    animation: formalFadeIn 1.2s ease-out forwards;
                }

                @keyframes formalFadeIn {
                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }

                /* Container for the included templates */
                .content-wrapper {
                    background: #fff;
                    position: relative;
                    z-index: 2;
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
            @include('web.templates.stats2')
            @include('web.templates.statistics')
            @include('web.templates.keyperformancehighlights')
            @include('web.templates.intro')
            @include('web.templates.cities')
            @include('web.templates.whyexhibit')
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