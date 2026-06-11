<style>
    .container {
        display: flex;
        width: 100%;
        /* stretch forces both flex items (.box) to match the height of the tallest item */
        align-items: stretch;
        justify-content: center;
    }

    .box {
        width: 50%;
        display: flex;
        flex-direction: column;
    }

    /* Left box children take up 100% height to stretch background colors */
    .box.left {
        /* Matched to your header color to keep layout seamless */
    }

    .box.right {
        display: flex;
        justify-content: left;
        align-items: left;
        text-align: left;
    }

    .frontpage-header {
        width: 100%;
        height: 100%;
        /* Forces internal block to fill out the stretched container height */
        display: flex;
        justify-content: center;
        align-items: center;
        /* Slightly increased padding for balanced composition */
        color: #aa2324;
        gap: 16px;
        text-align: center;
    }

    .logo {
        display: flex;
        align-items: center;
        flex-shrink: 0;
    }

    .logo img {
        height: 90px;
        border: 2px solid #B34241;
        width: auto;
        filter: drop-shadow(1px 1px 0 rgba(0, 0, 0, 0.4)) drop-shadow(3px 3px 0 rgba(0, 0, 0, 0.25));
    }

    .frontpage-text-block {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        text-align: left;
        line-height: 1.3;
        color: #aa2324;
    }

    .frontpage-title {
        font-size: 20px;
        font-weight: bold;
        letter-spacing: 0.5px;
    }

    .frontpage-sub {
        font-size: 11px;
        margin-top: 6px;
        opacity: 0.9;
    }

    /* Responsive Mobile Overrides */
    @media (max-width: 768px) {
        .container {
            flex-direction: column;
            align-items: clip;
            /* Removes stretch constraint on mobile devices */
        }

        .box {
            width: 100%;
        }

        .frontpage-header {
            padding: 24px 18px;
        }
    }
</style>

<div class="container">

    <!-- LEFT COMPONENT -->
    <div class="box left">
        <div class="frontpage-header">
            <div class="logo">
                <img id="iitmLogoImg" src="{{ asset('public/assets/iitm3.png') }}" alt="Logo">
            </div>
            <div class="frontpage-text-block">
                <span class="frontpage-title">
                    INDIA <br>INTERNATIONAL <br>TRAVEL MART
                </span>
                <span class="frontpage-sub">
                    India's premier travel & tourism exhibition
                </span>
            </div>
        </div>
    </div>

    <!-- RIGHT COMPONENT -->
    <div class="box right">

        @include('web.templates.bookyourstallcompact')
    </div>

</div>