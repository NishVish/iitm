<div class="loader-wrapper">

<style>
@import url('https://fonts.googleapis.com/css2?family=Syncopate:wght@400;700&family=Inter:wght@400;700&display=swap');

html, body {
    margin: 0;
    padding: 0;
    background: #000;
    font-family: 'Inter', sans-serif;
    overflow-x: hidden;
    overflow-y: auto;
}

/* ================= LOADER ================= */
.loader {
    position: fixed;
    inset: 0;
    background: radial-gradient(circle at center, #111 0%, #000 70%);
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    z-index: 99999;
}

/* LOGO WRAPPER (for ripple) */
.logo-wrap {
    position: relative;
    width: 90px;
    height: 90px;
    display: flex;
    justify-content: center;
    align-items: center;
}

/* RIPPLE EFFECT */
.logo-wrap span {
    position: absolute;
    width: 100%;
    height: 100%;
    border: 2px solid rgba(255,255,255,0.2);
    border-radius: 50%;
    animation: ripple 2s infinite;
}

.logo-wrap span:nth-child(2) {
    animation-delay: 0.5s;
}

.logo-wrap span:nth-child(3) {
    animation-delay: 1s;
}

@keyframes ripple {
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
.loader img {
    height: 60px;
    z-index: 2;
    /* animation: float 2s ease-in-out infinite; */
}

/* CITY TEXT */
.city {
    font-family: 'Syncopate', sans-serif;
    font-size: 26px;
    letter-spacing: 10px;
    color: #fff;
    text-transform: uppercase;
    opacity: 0;
    transform: scale(0.9);
    transition: all 0.4s ease;
}

.city.show {
    opacity: 1;
    transform: scale(1.05);
}

/* LOADER BAR */
.bar {
    width: 200px;
    height: 2px;
    margin-top: 25px;
    background: rgba(255, 255, 255, 0.1);
    overflow: hidden;
    position: relative;
}

.bar::after {
    content: "";
    position: absolute;
    width: 40%;
    height: 100%;
    background: #fff;
    animation: load 1s infinite ease-in-out;
}

@keyframes load {
    0% { left: -40%; }
    100% { left: 100%; }
}

/* @keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-8px); }
} */

.loader.hide {
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
    transition: opacity 1s ease, visibility 1s ease;
}
</style>

<!-- ================= LOADER ================= -->
<div id="loader" class="loader">

    <div class="logo-wrap">
        <span></span>
        <span></span>
        <span></span>

        <!-- START WITH WHITE -->
        <img id="logoImg" src="https://iitmindia.com/assets/iitm3.png" alt="Logo">
    </div>

    <div id="cityText" class="city">MUMBAI</div>
    <div class="bar"></div>

</div>

<script>
const cities = [
    "MUMBAI","DELHI","BANGALORE","HYDERABAD",
    "CHENNAI","KOLKATA","PUNE","AHMEDABAD","JAIPUR"
];

let i = 0;
const cityEl = document.getElementById("cityText");
const logo = document.getElementById("logoImg");

function showCity() {
    cityEl.classList.remove("show");

    setTimeout(() => {
        cityEl.textContent = cities[i];
        cityEl.classList.add("show");

        // 🔴 SWITCH LOGO
        if (i % 2 === 0) {
            logo.src = "https://iitmindia.com/assets/iitm3.png"; // white
        } else {
            logo.src = "https://iitmindia.com/assets/iitm2.png"; // red
        }

        i = (i + 1) % cities.length;
    }, 250);
}

showCity();
const interval = setInterval(showCity, 700);

window.onload = () => {
    setTimeout(() => {
        clearInterval(interval);

        const loader = document.getElementById("loader");
        loader.classList.add("hide");

        setTimeout(() => {
            loader.remove();
        }, 1200);

    }, 6000);
};
</script>

</div>