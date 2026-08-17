<div class="custom-loader-wrapper">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Syncopate:wght@400;700&family=Inter:wght@400;700&display=swap');

        /* SCOPE EVERYTHING */
        .custom-loader-wrapper {
            font-family: 'Inter', sans-serif;
        }

        /* ================= LOADER ================= */
        .custom-loader {
            position: fixed;
            inset: 0;
            background: radial-gradient(circle at center, #111 0%, #000 70%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 99999;
        }

        /* LOGO WRAPPER */
        .custom-logo-wrap {
            position: relative;
            width: 90px;
            height: 90px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* RIPPLE EFFECT */
        .custom-logo-wrap span {
            position: absolute;
            width: 100%;
            height: 100%;
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            animation: custom-ripple 2s infinite;
        }

        .custom-logo-wrap span:nth-child(2) {
            animation-delay: 0.5s;
        }

        .custom-logo-wrap span:nth-child(3) {
            animation-delay: 1s;
        }

        @keyframes custom-ripple {
            0% {
                transform: scale(0.6);
                opacity: 0.6;
            }

            100% {
                transform: scale(2);
                opacity: 0;
            }
        }

        /* LOGO */
        .custom-loader img {
            height: 60px;
            z-index: 2;
        }

        /* CITY TEXT */
        .custom-city {
            font-family: 'Syncopate', sans-serif;
            font-size: 26px;
            letter-spacing: 10px;
            color: #fff;
            text-transform: uppercase;
            opacity: 0;
            transform: scale(0.9);
            transition: all 0.4s ease;
        }

        .custom-city.show {
            opacity: 1;
            transform: scale(1.05);
        }

        /* LOADER BAR */
        .custom-bar {
            width: 200px;
            height: 2px;
            margin-top: 25px;
            background: rgba(255, 255, 255, 0.1);
            overflow: hidden;
            position: relative;
        }

        .custom-bar::after {
            content: "";
            position: absolute;
            width: 40%;
            height: 100%;
            background: #fff;
            animation: custom-load 1s infinite ease-in-out;
        }

        @keyframes custom-load {
            0% {
                left: -40%;
            }

            100% {
                left: 100%;
            }
        }

        /* HIDE */
        .custom-loader.hide {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            transition: opacity 1s ease, visibility 1s ease;
        }
    </style>

    <!-- ================= LOADER ================= -->
    <div id="customLoader" class="custom-loader">

        <div class="custom-logo-wrap">
            <span></span>
            <span></span>
            <span></span>

            <img id="customLogoImg" src="https://iitmindia.com/assets/iitm3.png" alt="Logo">
        </div>

        <div id="customCityText" class="custom-city">MUMBAI</div>
        <div class="custom-bar"></div>

    </div>

    <script>
        const cities = [
            "MUMBAI", "DELHI", "BANGALORE", "HYDERABAD",
            "CHENNAI", "KOLKATA", "PUNE", "AHMEDABAD", "KOCHI"
        ];

        let i = 0;
        const cityEl = document.getElementById("customCityText");
        const logo = document.getElementById("customLogoImg");

        function showCity() {
            cityEl.classList.remove("show");

            setTimeout(() => {
                cityEl.textContent = cities[i];
                cityEl.classList.add("show");

                logo.src = (i % 2 === 0)
                    ? "https://iitmindia.com/assets/iitm3.png"
                    : "https://iitmindia.com/assets/iitm2.png";

                i = (i + 1) % cities.length;
            }, 250);
        }

        showCity();
        const interval = setInterval(showCity, 700);

        window.onload = () => {
            setTimeout(() => {
                clearInterval(interval);

                const loader = document.getElementById("customLoader");
                loader.classList.add("hide");

                setTimeout(() => {
                    loader.remove();
                }, 1200);

            }, 6000);
        };
    </script>

</div>