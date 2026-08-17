<div class="thank-you-wrapper" style="min-height: 100vh; display: flex; align-items: center; justify-content: center; 
    background: #f4f4f4 url('https://iitmindia.com/assets/creatives/4.jpg') center/cover no-repeat; 
    padding: 20px; font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">

    <div style="position: fixed; inset: 0; background: rgba(0,0,0,0.6); z-index: 1;"></div>

    <div class="container" style="max-width: 550px; width: 100%; position: relative; z-index: 2;
        background: #ffffff; 
        border-radius: 12px; 
        overflow: hidden; 
        box-shadow: 0 30px 60px rgba(0,0,0,0.4); 
        animation: iitmFadeIn 0.8s ease-out;">

        <div style="background: #aa2324; height: 6px; width: 100%;"></div>

        <div style="padding: 30px 0 10px; text-align: center;">
            <img src="https://iitmindia.com/assets/iitm3.png" width="140" alt="IITM Logo"
                style="display: inline-block;">
            <div
                style="font-size: 10px; letter-spacing: 3px; color: #aa2324; font-weight: bold; margin-top: 10px; text-transform: uppercase;">
                India International Travel Mart
            </div>
        </div>

        <div style="padding: 40px; text-align: center;">

            <div style="margin-bottom: 25px;">
                <h1
                    style="color: #111; font-size: 26px; margin: 0 0 10px; font-family: Georgia, serif; font-weight: normal;">
                    Enquiry Received
                </h1>
                <div style="width: 40px; border-bottom: 3px solid #aa2324; margin: 0 auto;"></div>
            </div>

            <p style="font-size: 16px; color: #444; line-height: 1.6; margin-bottom: 25px;">
                Thank you, <strong style="color: #111;">{{ $contact_name ?? 'User' }}</strong>. <br>
                Your enquiry for the upcoming event has been successfully submitted to our team.
            </p>


            <div style="display: flex; flex-direction: column; gap: 12px; align-items: center;">
                <a href="{{url('/')}}" class="iitm-btn" style="display: inline-block; 
                    padding: 14px 40px; 
                    background: #aa2324; 
                    color: #ffffff; 
                    text-decoration: none; 
                    border-radius: 4px; 
                    font-weight: bold; 
                    font-size: 14px;
                    text-transform: uppercase;
                    letter-spacing: 1px;
                    transition: all 0.3s ease;">
                    Back to Home
                </a>

                <a href="{{url('/exhibiting')}}" style="color: #666; font-size: 13px; text-decoration: underline;">
                    Explore more events
                </a>
            </div>
        </div>
        <div
            style="background: #fff7f7; border: 1px solid #ffd1d1; padding: 18px; border-radius: 8px; margin-bottom: 25px; text-align: center;">

            <div style="font-size: 14px; color: #aa2324; font-weight: 600; margin-bottom: 6px;">
                Need a Quick Update?
            </div>

            <div style="font-size: 13px; color: #555; margin-bottom: 12px; line-height: 1.5;">
                Our team is available for faster assistance. Call us now for any enquiry updates or support.
            </div>

            <a href="tel:+917909075195" style="display: inline-block;
        padding: 12px 22px;
        background: #aa2324;
        color: #fff;
        text-decoration: none;
        border-radius: 4px;
        font-weight: bold;
        font-size: 13px;
        letter-spacing: 0.5px;">
                📞 Call for Quick Update
            </a>

        </div>
        <div style="background: #f9f9f9; padding: 20px; text-align: center; border-top: 1px solid #eee;">
            <p style="margin: 0; font-size: 11px; color: #999; text-transform: uppercase; letter-spacing: 1px;">
                © 2026 IITM India | Sphere Travelmedia & Exhibitions Pvt. Ltd.
            </p>
        </div>
    </div>
</div>

<style>
    @keyframes iitmFadeIn {
        from {
            opacity: 0;
            transform: translateY(15px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .iitm-btn:hover {
        background: #8e1d1e !important;
        box-shadow: 0 4px 12px rgba(170, 35, 36, 0.3);
    }
</style>