<style>
    body {
        margin: 0;
    }
</style>

<div class="thank-you-wrapper" style="min-height: 100vh; display: flex; align-items: center; justify-content: center; 
    background: #f4f4f4 url('https://iitmindia.com/assets/creatives/4.jpg') center/cover no-repeat; 
    padding: 10px; font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">

    <div style="position: fixed; inset: 0; background: rgba(0,0,0,0.6); z-index: 1;"></div>

    <div style="max-width: 460px; width: 100%; position: relative; z-index: 2;
        background: #ffffff; 
        border-radius: 10px; 
        overflow: hidden; 
        box-shadow: 0 20px 40px rgba(0,0,0,0.35); 
        animation: iitmFadeIn 0.6s ease-out;">

        <div style="background: #aa2324; height: 5px;"></div>

        <!-- Logo -->
        <div style="padding: 20px 0 5px; text-align: center;">
            <img src="https://iitmindia.com/assets/iitm3.png" width="110" alt="IITM Logo">
            <div style="font-size: 9px; letter-spacing: 2px; color: #aa2324; font-weight: bold; margin-top: 6px;">
                India International Travel Mart
            </div>
        </div>

        <!-- Content -->
        <div style="padding: 25px; text-align: center;">

            <h1
                style="color: #111; font-size: 22px; margin: 0 0 8px; font-family: Georgia, serif; font-weight: normal;">
                Enquiry Received
            </h1>
            <div style="width: 35px; border-bottom: 2px solid #aa2324; margin: 0 auto 18px;"></div>

            <p style="font-size: 14px; color: #444; line-height: 1.5; margin-bottom: 20px;">
                Thank you, <strong>{{ $contact_name ?? 'User' }}</strong>.<br>
                Your enquiry has been successfully submitted.
            </p>

            <div style="display: flex; flex-direction: column; gap: 10px; align-items: center;">
                <a href="{{url('/')}}" style="padding: 10px 28px; background: #aa2324; color: #fff; text-decoration: none; 
                    border-radius: 4px; font-weight: bold; font-size: 12px; letter-spacing: 0.5px;">
                    Back to Home
                </a>

                <a href="{{url('/exhibiting')}}" style="color: #666; font-size: 12px;">
                    Explore more events
                </a>
            </div>
        </div>

        <!-- Quick Update Box -->
        <div style="background: #fff7f7; border-top: 1px solid #ffd1d1; padding: 15px; text-align: center;">
            <div style="font-size: 13px; color: #aa2324; font-weight: 600;">
                Need a Quick Update?
            </div>
            <div style="font-size: 12px; color: #555; margin: 6px 0 10px;">
                Call us for faster assistance.
            </div>

            <a href="tel:+917909075195" style="padding: 9px 16px; background: #aa2324; color: #fff; 
                text-decoration: none; border-radius: 4px; font-size: 12px;">
                📞 Call Now
            </a>
        </div>

        <!-- Footer -->
        <div style="background: #f9f9f9; padding: 12px; text-align: center; border-top: 1px solid #eee;">
            <p style="margin: 0; font-size: 10px; color: #999;">
                © 2026 IITM India
            </p>
        </div>
    </div>
</div>

<style>
    @keyframes iitmFadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>