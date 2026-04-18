<div class="app-container">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Syncopate:wght@400;700&family=Inter:wght@400;900&display=swap');

        body,
        html {
            margin: 0;
            padding: 0;
            background: #000;
            overflow: hidden;
            /* Kept hidden until loader finishes */
        }

        .app-container {
            font-family: 'Inter', sans-serif;
            background: #000;
            color: white;
            height: 100vh;
        }

        /* --- THE LOADER --- */
        .loader {
            position: fixed;
            inset: 0;
            background: #000;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 10000;
            transition: opacity 1s ease-in-out, visibility 1s;
        }

        .loader.hide {
            opacity: 0;
            visibility: hidden;
        }

        .loader-text {
            font-family: 'Syncopate', sans-serif;
            letter-spacing: 12px;
            font-size: clamp(1.2rem, 4vw, 2rem);
            font-weight: 700;
            text-transform: uppercase;
            background: linear-gradient(90deg, #222, #fff, #222);
            background-size: 200%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: move-bg 1.5s linear infinite;
            margin-bottom: 20px;
            text-align: center;
        }

        .loader-bar {
            width: 150px;
            height: 1px;
            background: rgba(255, 255, 255, 0.1);
            position: relative;
            overflow: hidden;
        }

        .loader-bar::after {
            content: '';
            position: absolute;
            left: -100%;
            width: 100%;
            height: 100%;
            background: #fff;
            animation: progress-slide 1s infinite ease-in-out;
        }

        @keyframes move-bg {
            to {
                background-position: 200% center;
            }
        }

        @keyframes progress-slide {
            0% {
                left: -100%;
            }

            100% {
                left: 100%;
            }
        }

        /* --- IMMERSIVE CONTENT --- */
        .content {
            opacity: 0;
            transition: opacity 1.5s ease;
            height: 100vh;
            overflow-y: scroll;
            scroll-snap-type: y mandatory;
            scrollbar-width: none;
        }

        .content::-webkit-scrollbar {
            display: none;
        }

        .content.ready {
            opacity: 1;
        }

        .city-section {
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            scroll-snap-align: start;
            position: relative;
            text-align: center;
        }

        .bg-number {
            position: absolute;
            font-size: 35vw;
            font-weight: 900;
            color: rgba(255, 255, 255, 0.03);
            z-index: 1;
            pointer-events: none;
        }

        .city-content {
            z-index: 2;
        }

        .city-name {
            font-size: 8vw;
            font-weight: 900;
            text-transform: uppercase;
            margin: 0;
            letter-spacing: -2px;
        }

        .phase-tag {
            font-size: 12px;
            letter-spacing: 5px;
            color: #00f5ff;
            margin-bottom: 15px;
        }

        /* Nav Controls */
        .nav-overlay {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 5000;
            display: flex;
            gap: 10px;
        }

        .nav-btn {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            padding: 15px;
            border-radius: 50%;
            cursor: pointer;
            backdrop-filter: blur(5px);
        }
    </style>

    <div id="loader" class="loader">
        <div class="loader-text" id="loadText">INITIALIZING</div>
        <div class="loader-bar"></div>
    </div>

    <div class="nav-overlay">
        <button class="nav-btn" onclick="navigate( -1 )">↑</button>
        <button class="nav-btn" onclick="navigate( 1 )">↓</button>
    </div>

    <div id="main" class="content">
    </div>

    <script>
        const DATA = {
            cities: ["Mumbai", "Delhi", "Bangalore", "Hyderabad", "Chennai", "Kolkata", "Pune", "Ahmedabad", "Jaipur"],
            speed: 80
        };

        const DOM = {
            loader: document.getElementById("loader"),
            main: document.getElementById("main"),
            loadText: document.getElementById("loadText")
        };

        // 1. Render City Sections
        function renderSections() {
            DOM.main.innerHTML = DATA.cities.map((city, i) => `
                <section class="city-section" id="city-${i}" style="background-color: hsl(${i * 30}, 20%, 5%)">
                    <div class="bg-number">0${i + 1}</div>
                    <div class="city-content">
                        <div class="phase-tag">PHASE 0${i + 1}</div>
                        <h1 class="city-name">${city}</h1>
                        <a href="#" style="color:white; border: 1px solid white; padding: 10px 20px; text-decoration:none; display:inline-block; margin-top:20px;">ENQUIRE</a>
                    </div>
                </section>
            `).join('');
        }

        // 2. Navigation Logic
        let currentIdx = 0;
        function navigate(dir) {
            currentIdx = Math.max(0, Math.min(DATA.cities.length - 1, currentIdx + dir));
            document.getElementById(`city-${currentIdx}`).scrollIntoView({ behavior: 'smooth' });
        }

        // 3. Loader Logic
        let i = 0;
        const cityCycle = setInterval(() => {
            DOM.loadText.textContent = DATA.cities[i % DATA.cities.length].toUpperCase();
            i++;
        }, DATA.speed);

        window.addEventListener('load', () => {
            renderSections(); // Build the page while loading

            setTimeout(() => {
                clearInterval(cityCycle);
                DOM.loadText.textContent = "ACCESS GRANTED";

                setTimeout(() => {
                    DOM.loader.classList.add("hide");
                    DOM.main.classList.add("ready");
                }, 600);
            }, 2500);
        });
    </script>
</div>