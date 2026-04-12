<div class="container">
    <div class="intro" id="introText">Explore Major Cities</div>

    <div class="city-row" id="cityRow">
        <button>New York</button>
        <button>London</button>
        <button>Paris</button>
        <button>Tokyo</button>
        <button>Dubai</button>
        <button>Singapore</button>
        <button>Mumbai</button>
        <button>Sydney</button>
        <button>Toronto</button>
    </div>
</div>

<style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background: linear-gradient(135deg, #1e1e2f, #3a3a5f);
        color: white;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .container {
        text-align: center;
    }

    .intro {
        font-size: 32px;
        font-weight: bold;
        opacity: 0;
        transform: translateY(30px);
        animation: fadeSlideIn 1.5s ease forwards;
    }

    @keyframes fadeSlideIn {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .city-row {
        margin-top: 40px;
        display: flex;
        gap: 15px;
        opacity: 0;
        transform: translateY(30px);
    }

    .city-row.show {
        animation: fadeSlideIn 1s ease forwards;
    }

    button {
        padding: 10px 18px;
        border: none;
        border-radius: 20px;
        background: #ff6b6b;
        color: white;
        cursor: pointer;
        transition: 0.3s;
    }

    button:hover {
        background: #ff3b3b;
        transform: scale(1.1);
    }
</style>

<script>
    // Show city buttons after intro animation
    setTimeout(() => {
        document.getElementById("cityRow").classList.add("show");
    }, 1600);
</script>