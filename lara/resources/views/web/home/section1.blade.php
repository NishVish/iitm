<style>
    .container {
        position: relative;
    }

    .section1 {
        height: 60vh;
        overflow: hidden;
    }

    /* Center content properly */
    .section2 {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 2;
        color: white;
        text-align: center;

        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 5px;
        /* 👈 controls spacing cleanly */
        width: 90%;
    }

    /* Logo */
    #frontlogo {
        width: 120px;
        /* fixed instead of % for better control */
    }

    /* Heading */
    .section2 h1 {
        margin: 0;
        font-size: 2.5rem;
    }

    /* Text BELOW heading (no absolute positioning) */
    .bottom-text {
        font-size: 0.8rem;
        letter-spacing: 1px;
        text-transform: uppercase;
        margin: 0;
        max-width: 600px;
    }

    /* Responsive tweak */
    @media (max-width: 768px) {
        .section2 h1 {
            font-size: 1.8rem;
        }

        .bottom-text {
            font-size: 1rem;
        }

        #frontlogo {
            width: 90px;
        }
    }
</style>