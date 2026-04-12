<div class="app-container">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Syncopate:wght@400;700&family=Inter:wght@400;900&display=swap');

        .app-container {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            background: #050505;
            color: white;
            min-height: 100vh;
            /* Changed from height to min-height */
            display: flex;
            flex-direction: column;
            align-items: center;
            /* justify-content: center; <- Remove this if you want it to stay at the top */
            padding-top: 50px;
            /* Gives it a consistent starting point */
        }

        /* Add this to force the Info Items to stay the same width */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            /* 3 equal columns */
            gap: 30px;
            width: 100%;
            text-align: left;
            margin-top: 20px;
        }



        /* --- MINIMAL LOADER --- */
        .loader {
            position: fixed;
            inset: 0;
            background: #000;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 100;
            transition: opacity 0.8s ease, visibility 0.8s;
        }

        .loader.hide {
            opacity: 0;
            visibility: hidden;
        }

        .loader-text {
            font-family: 'Syncopate';
            letter-spacing: 10px;
            font-size: 3rem;
            text-transform: uppercase;
            background: linear-gradient(90deg, #444, #fff, #444);
            background-size: 200%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: move-bg 2s linear infinite;
        }

        @keyframes move-bg {
            to {
                background-position: 200% center;
            }
        }

        /* --- BUTTON BAR --- */
        .content {
            text-align: center;
            width: 90%;
            max-width: 1200px;
            opacity: 0;
            transform: translateY(20px);
            transition: all 1s ease;
        }

        .content.show {
            opacity: 1;
            transform: translateY(0);
        }

        .btn-row {
            display: flex;
            flex-wrap: nowrap;
            /* Forces single row */
            justify-content: center;
            gap: 12px;
            padding: 20px;
        }

        .city-btn {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 14px 24px;
            border-radius: 100px;
            /* Pill shape */
            color: #aaa;
            font-family: 'Syncopate', sans-serif;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
            position: relative;
            white-space: nowrap;
            overflow: hidden;
        }

        /* Hover: Glow and Text Color */
        .city-btn:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: #00f5ff;
            color: #fff;
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 245, 255, 0.15);
        }

        .city-btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 120%;
            height: 120%;
            background: radial-gradient(circle, rgba(0, 245, 255, 0.2) 0%, transparent 70%);
            transform: translate(-50%, -50%) scale(0);
            transition: transform 0.5s ease;
        }

        .city-btn:hover::before {
            transform: translate(-50%, -50%) scale(1);
        }

        .title-area {
            margin-bottom: 40px;
        }

        .title-area h2 {
            font-size: 10px;
            letter-spacing: 8px;
            color: #444;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .title-area h1 {
            font-size: 3rem;
            font-weight: 900;
            margin: 0;
            letter-spacing: -1px;
        }
    </style>

    <div id="loader" class="loader">
        <div class="loader-text" id="loadText">INITIALIZING</div>
    </div>

    <div id="main" class="content">


        <div class="btn-row" id="btnRow">

            <script>
                // 1. Data and Elements (Now accessible globally)
                const DATA = {
                    cities: ["Mumbai", "Delhi", "Bangalore", "Hyderabad", "Chennai", "Kolkata", "Pune", "Ahmedabad", "Jaipur"],
                    loadInterval: 100,
                    revealDelay: 1800
                };

                const DOM = {
                    btnRow: document.getElementById("btnRow"),
                    loader: document.getElementById("loader"),
                    main: document.getElementById("main"),
                    loadText: document.getElementById("loadText")
                };

                // 2. General Functions (Can be reused with any data)

                /**
                 * Renders buttons based on a string array
                 */
                function renderButtons(list, container) {
                    if (!container) return; // Safety check
                    list.forEach(item => {
                        const btn = document.createElement("button");
                        btn.className = "city-btn";
                        btn.textContent = item.toUpperCase();
                        container.appendChild(btn);
                    });
                }

                /**
                 * Animates text swap
                 */
                function startTextAnimation(list, element, speed) {
                    if (!element) return;
                    let i = 0;
                    return setInterval(() => {
                        element.textContent = list[i].toUpperCase();
                        i = (i + 1) % list.length;
                    }, speed);
                }

                /**
                 * Switches visibility between two elements
                 */
                function switchView(hideElement, showElement, intervalToStop) {
                    if (intervalToStop) clearInterval(intervalToStop);
                    if (hideElement) hideElement.classList.add("hide");
                    if (showElement) showElement.classList.add("show");
                }

                // 3. Execution (Call them whenever you want)

                // Step 1: Create the buttons
                // renderButtons(DATA.cities, DOM.btnRow);

                // Step 2: Start the loader and save the ID
                const activeAnimation = startTextAnimation(DATA.cities, DOM.loadText, DATA.loadInterval);

                // Step 3: Set the timer to switch views
                setTimeout(() => {
                    switchView(DOM.loader, DOM.main, activeAnimation);
                }, DATA.revealDelay);


            </script>
        </div>