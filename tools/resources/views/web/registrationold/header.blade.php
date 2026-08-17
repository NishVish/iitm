<div class="frontpage">

    <!-- Header -->
    <div class="frontpage-header">

        <style>
            body {
                margin: 0;
            }

            .frontpage-header {
                display: flex;
                justify-content: center;
                align-items: center;
                padding: 30px;
                gap: 10px;
                /* background: linear-gradient(to bottom, rgba(255, 255, 255, 0.09), rgba(255, 255, 255, 0)); */
                background-color: #aa2324;
            }

            .logo-box {
                border: 2px solid #ffffffff;
                padding: 5px;
                display: flex;

                align-items: center;
                justify-content: center;
            }

            .logo-box img {
                height: 80px;
                width: auto;
                display: block;
                flex-shrink: 0;
            }

            .frontpage-text-block {
                display: flex;
                flex-direction: column;
                line-height: 1.2;
                color: #ffffffff;

            }

            .frontpage-title {
                font-size: 20px;
                font-weight: bold;
                color: white;
                color: #ffffffff;

            }

            .frontpage-sub {
                font-size: 10px;
                color: white;
                margin-top: 4px;
                color: #ffffffff;

            }
        </style>

        <div class="logo-box">
            <img src="{{   url('public/assets/iitm2.png') }}" alt="Frontpage Logo">
        </div>

        <div class="frontpage-text-block">
            <span class="frontpage-title">
                INDIA <br>INTERNATIONAL <br>TRAVEL MART
            </span>
            <span class="frontpage-sub">
                India's premier travel & toursim exhibition
            </span>
        </div>

    </div>