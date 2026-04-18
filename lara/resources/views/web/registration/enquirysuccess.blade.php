<div class="thank-you-wrapper" style="min-height: 100vh; display: flex; align-items: center; justify-content: center;
    background: radial-gradient(circle at top, #e0f7ff, #f8f9fa);
    padding: 40px 20px; font-family: 'Inter', sans-serif;">

    <div class="container" style="max-width: 620px; width: 100%;
        background: rgba(255,255,255,0.85);
        backdrop-filter: blur(12px);
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0,0,0,0.12);
        transform: translateY(0);
        animation: floatIn 0.6s ease-out;">

        <!-- HERO -->
        <div style="height: 200px; position: relative; overflow: hidden;">
            <div style="position:absolute; inset:0;
                background: linear-gradient(135deg, #4facfe, #00f2fe);
                opacity: 0.85;">
            </div>

            <div style="position:absolute; inset:0; display:flex; align-items:center; justify-content:center;">
                <div style="font-size: 60px; color: white; animation: pulse 1.8s infinite;">
                    ✓
                </div>
            </div>
        </div>

        <!-- CONTENT -->
        <div class="content" style="padding: 40px; text-align: center;">

            <h1 style="color: #1a1a1a; margin-bottom: 10px; font-weight: 700;">
                Thank You, {{ $contactDataArr['name'] ?? 'User' }}!
            </h1>

            <p style="font-size: 16px; color: #555; line-height: 1.7; margin-bottom: 20px;">
                Your enquiry has been successfully received and is now being
                <strong style="color:#007bff;">reviewed by our team</strong>.
            </p>

            <div style="background: #f1f5ff; padding: 15px; border-radius: 12px; margin-bottom: 20px;">
                <p style="margin:0; font-size: 14px; color:#444;">
                    We will contact you shortly regarding your request.
                </p>
            </div>

            <a href="/" style="display: inline-block;
                padding: 12px 28px;
                background: linear-gradient(135deg, #007bff, #00c6ff);
                color: #fff;
                text-decoration: none;
                border-radius: 10px;
                font-weight: 600;
                box-shadow: 0 10px 25px rgba(0,123,255,0.25);
                transition: transform 0.2s ease;">
                Return Home
            </a>
        </div>
    </div>
</div>

<style>
    @keyframes floatIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
            opacity: 1;
        }

        50% {
            transform: scale(1.15);
            opacity: 0.8;
        }

        100% {
            transform: scale(1);
            opacity: 1;
        }
    }

    a:hover {
        transform: translateY(-2px);
    }
</style>