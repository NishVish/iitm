<style>
    .container {
        position: relative;
        overflow: hidden;
    }

    .section1 {
        height: 60vh;
        overflow: hidden;
    }

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
        gap: 8px;
        width: 90%;

        animation: smoothReveal 1.5s ease-out;
    }

    #frontlogo {
        width: 120px;

        filter:
            drop-shadow(2px 2px 0px rgba(0, 0, 0, 0.5)) drop-shadow(4px 4px 10px rgba(0, 0, 0, 0.7));

        animation: logoGlow 4s ease-in-out infinite;
    }

    .section2 h1 {
        margin: 0;
        font-size: 2.8rem;
        font-weight: 800;
        color: #fff;
        letter-spacing: 1px;

        text-shadow:
            1px 1px 0 #999,
            2px 2px 0 #888,
            3px 3px 0 #777,
            4px 4px 0 #666,
            5px 5px 12px rgba(0, 0, 0, 0.7);

        animation: textGlow 4s ease-in-out infinite;
    }

    .bottom-text {
        font-size: 0.9rem;
        letter-spacing: 2px;
        text-transform: uppercase;
        margin: 0;
        max-width: 600px;

        text-shadow:
            1px 1px 0 #666,
            2px 2px 6px rgba(0, 0, 0, 0.8);

        animation: fadeText 2s ease;
    }

    @keyframes smoothReveal {
        from {
            opacity: 0;
            transform: translate(-50%, -48%);
        }

        to {
            opacity: 1;
            transform: translate(-50%, -50%);
        }
    }

    @keyframes logoGlow {
        0% {
            filter:
                drop-shadow(2px 2px 0px rgba(0, 0, 0, 0.5)) drop-shadow(4px 4px 10px rgba(0, 0, 0, 0.6));
        }

        50% {
            filter:
                drop-shadow(2px 2px 0px rgba(255, 255, 255, 0.2)) drop-shadow(0 0 18px rgba(255, 255, 255, 0.4));
        }

        100% {
            filter:
                drop-shadow(2px 2px 0px rgba(0, 0, 0, 0.5)) drop-shadow(4px 4px 10px rgba(0, 0, 0, 0.6));
        }
    }

    @keyframes textGlow {
        0% {
            text-shadow:
                1px 1px 0 #999,
                2px 2px 0 #888,
                3px 3px 0 #777,
                4px 4px 0 #666,
                5px 5px 12px rgba(0, 0, 0, 0.7);
        }

        50% {
            text-shadow:
                1px 1px 0 #bbb,
                2px 2px 0 #aaa,
                3px 3px 0 #999,
                4px 4px 0 #888,
                0 0 20px rgba(255, 255, 255, 0.5);
        }

        100% {
            text-shadow:
                1px 1px 0 #999,
                2px 2px 0 #888,
                3px 3px 0 #777,
                4px 4px 0 #666,
                5px 5px 12px rgba(0, 0, 0, 0.7);
        }
    }

    @keyframes fadeText {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    @media (max-width: 768px) {

        .section2 h1 {
            font-size: 1.8rem;
        }

        .bottom-text {
            font-size: 0.8rem;
        }

        #frontlogo {
            width: 90px;
        }
    }
</style>