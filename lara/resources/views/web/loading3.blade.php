<!-- LOADING SCREEN -->
<div id="pageLoader"></div>

<style>
    #pageLoader {
        position: fixed;
        inset: 0;
        z-index: 99999;
        background: #ffffff;

        display: flex;
        align-items: center;
        justify-content: center;

        animation: fadeIn 0.3s ease;
    }

    /* subtle animated pulse */
    #pageLoader::after {
        content: "";
        width: 40px;
        height: 40px;
        border: 3px solid #B34241;
        border-top: 3px solid transparent;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    #pageLoader.hide {
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.4s ease;
    }
</style>

<script>
    window.addEventListener("load", () => {
        const loader = document.getElementById("pageLoader");

        // fixed 1.5s loader
        setTimeout(() => {
            loader.classList.add("hide");
        }, 1500);
    });
</script>