<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Fairfest Events Registration</title>
    <meta name="description" content="Register for Fairfest's leading events - OTM, WTE, BLTM, TTF & Municipalika." />

    <!-- Open Graph -->
    <meta property="og:title" content="Fairfest Events Registration" />
    <meta property="og:description" content="Join India's top trade events - OTM, WTE, BLTM, TTF & Municipalika." />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://tickets.fairfest.in/" />
    <meta property="og:image" content="https://www.fairfest.com/wte-emailv2/Fairfest%20Logo.png" />

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image" />

    <!-- Icons -->
    <link rel="icon" href="https://fairfest-website-1-alt.s3.ap-south-1.amazonaws.com/Fairfest+FavIcon.png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!-- Preload -->
    <link rel="preload" href="/assets/logo-d78532f0.png" as="image">

    <!-- Styles -->
    <link rel="stylesheet" href="/assets/index-00c04180.css">

    <!-- Base Styling -->
    <style>
        body {
            margin: 0;
            font-family: 'Inter', system-ui, sans-serif;
            background: #0f172a;
            color: #e5e7eb;
        }

        #loader {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            flex-direction: column;
            gap: 16px;
        }

        .spinner {
            width: 40px;
            height: 40px;
            border: 4px solid #334155;
            border-top: 4px solid #3b82f6;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .logo {
            width: 120px;
            opacity: 0.9;
        }
    </style>

    <!-- Scripts -->
    <script defer src="https://checkout.razorpay.com/v1/checkout.js"></script>

    <!-- Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-GNSQ86JE2C"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());
        gtag('config', 'G-GNSQ86JE2C');
    </script>

    <!-- Facebook Pixel -->
    <script async src="https://connect.facebook.net/en_US/fbevents.js"></script>
    <script>
        window.fbq = window.fbq || function () {
            fbq.callMethod ?
            fbq.callMethod.apply(fbq, arguments) : fbq.queue.push(arguments)
        };
        fbq.queue = [];
        fbq('init', '601643682557384');
        fbq('track', 'PageView');
    </script>

    <!-- LinkedIn -->
    <script async src="https://snap.licdn.com/li.lms-analytics/insight.min.js"></script>

    <!-- App -->
    <script type="module" crossorigin src="/assets/index-9c28ca3d.js"></script>
</head>

<body>

    <!-- Loading UI -->
    <div id="loader">
        <img src="/assets/logo-d78532f0.png" alt="Fairfest Logo" class="logo" />
        <div class="spinner"></div>
        <p>Loading Events...</p>
    </div>

    <!-- React Mount -->
    <div id="root"></div>

    <script>
        // Hide loader when React mounts
        const observer = new MutationObserver(() => {
            if (document.getElementById('root').children.length > 0) {
                document.getElementById('loader').style.display = 'none';
                observer.disconnect();
            }
        });
        observer.observe(document.getElementById('root'), { childList: true });
    </script>

    <!-- Noscript fallback -->
    <noscript>
        <div style="padding:20px; text-align:center;">
            Please enable JavaScript to use this site.
        </div>
    </noscript>

</body>

</html>