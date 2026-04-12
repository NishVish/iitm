<!-- LOADER -->
<div id="loader" class="loader">
    <h1 id="loaderText">Loading...</h1>
</div>

<style>
    .loader {
        position: fixed;
        inset: 0;
        background: #000;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        transition: opacity 0.6s ease, visibility 0.6s ease;
    }

    .loader.hide {
        opacity: 0;
        visibility: hidden;
    }

    .loader h1 {
        font-size: 44px;
        font-weight: 900;
        background: linear-gradient(90deg, #00f5ff, #ff00d4, #ffe600);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        transition: transform 0.2s ease, opacity 0.2s ease;
    }
</style>

<script>
    const loader = document.getElementById("loader");
    const text = document.getElementById("loaderText");

    const messages = [
        "Connect. Create. Collaborate.",
        "Networking powers success.",
        "Where connections grow.",
        "Ideas meet opportunity."
    ];

    let i = 0;

    window.addEventListener("DOMContentLoaded", () => {

        const interval = setInterval(() => {

            text.style.opacity = 0;
            text.style.transform = "scale(0.95)";

            setTimeout(() => {
                text.textContent = messages[i];
                text.style.opacity = 1;
                text.style.transform = "scale(1)";
                i++;

                if (i >= messages.length) {
                    clearInterval(interval);

                    setTimeout(() => {
                        loader.classList.add("hide");
                    }, 800); // smooth exit delay
                }
            }, 300);

        }, 300); // ⬅️ slower, stable timing
    });
</script>