@include('web.home.video')


<style>
    .section-1 {
        height: 100vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        color: white;
        text-align: center;
        transition: filter 0.8s ease, opacity 0.8s ease;
        /* Makes the blur/unblur smooth */

    }

    .section-1.idle {
        filter: blur(15px) grayscale(20%);
        /* Blurs and slightly fades color */
        pointer-events: none;
        /* Prevents accidental clicks while blurred */
    }

    /* Animate children only (not container) */
    .section-1>* {
        opacity: 0;
        transform: translateY(40px);
        filter: blur(8px);
        transition: all 0.8s ease;
    }

    /* Visible state */
    .section-1.show>* {
        opacity: 1;
        transform: translateY(0);
        filter: blur(0);
    }

    /* Stagger delays */
    .section-1.show img {
        transition-delay: 0.2s;
    }

    .section-1.show h1 {
        transition-delay: 0.4s;
    }

    .section-1.show p {
        transition-delay: 0.6s;
    }

    .section-1.show div {
        transition-delay: 0.8s;
    }

    button:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(35, 166, 213, 0.4);
        filter: brightness(1.1);
    }
</style>

<div class="section-1" id="hero">
    <style>
        @keyframes coolGradient {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }
    </style>
    <script>
        const hero = document.getElementById('hero');
        let idleTimer;

        // This function runs every time the mouse moves
        document.addEventListener('mousemove', () => {
            // 1. Remove the blur immediately when movement is detected
            hero.classList.remove('idle');

            // 2. Clear the previous timer
            clearTimeout(idleTimer);

            // 3. Start a new timer for 2 seconds (2000ms)
            idleTimer = setTimeout(() => {
                hero.classList.add('idle');
            }, 2000);
        });

        // Also remove blur on touch for mobile users
        document.addEventListener('touchstart', () => {
            hero.classList.remove('idle');
        });
    </script>
    <img src="https://iitmindia.com/wp-content/uploads/2024/03/image-1.png" width="200px"
        style="display: block; margin: 0 auto; filter: drop-shadow(0 5px 15px rgba(0,0,0,0.1));">

    <h1 style="
    text-align: center; 
    font-family: 'Montserrat', sans-serif; /* Recommended modern font */
    font-size: 3rem; 
    margin: 20px 0 10px;
    
    /* Gradient Color Settings */
    background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
    background-size: 400% 400%; /* Important for the movement effect */
    
    /* Clip gradient to text */
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent; 
    
    /* Attach the animation defined in the <style> tag */
    animation: coolGradient 10s ease infinite; 
">
        IITM India Biggest Travel Show
    </h1>

    <p
        style="text-align: center; font-family: 'Arial', sans-serif; color: #555; font-size: 1.1rem; letter-spacing: 1px; text-transform: uppercase; margin-bottom: 30px;">
        Escalate Your Brand Visibility With IITM Exhibition And Event
    </p>
    <!-- //         <button onclick="location.href='{{ route('exhibitor') }}'" style="
 -->
    <div style="text-align: center;">
        <button onclick="location.href='{{ route('exhibiting') }}'" style="
            padding: 12px 28px; 
            background: #23a6d5; 
            color: white; 
            border: none; 
            border-radius: 50px; 
            font-weight: bold; 
            cursor: pointer; 
            box-shadow: 0 4px 15px rgba(35, 166, 213, 0.3); 
            margin-right: 10px; 
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        " onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 20px rgba(35, 166, 213, 0.5)';"
            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(0,0,0,0.2)';">
            Stall Booking
        </button>

        <button onclick="location.href='{{ route('attending') }}'" style="
            padding: 12px 28px; 
            background: white; 
            color: #23a6d5; 
            border: 2px solid #23a6d5; 
            border-radius: 50px; 
            font-weight: bold; 
            cursor: pointer; 
            transition: all 0.3s ease;
        " onmouseover="this.style.background='#f0f9ff'; this.style.transform='translateY(-3px)';"
            onmouseout="this.style.background='white'; this.style.transform='translateY(0)';">
            Trade Visitor
        </button>
    </div>
</div>

<script>
    window.addEventListener('DOMContentLoaded', () => {
        const section = document.getElementById('hero');

        setTimeout(() => {
            section.classList.add('show');
        }, 3000); // 3 seconds
    });
</script>