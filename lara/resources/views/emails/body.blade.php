<div style="
  margin:0;
  padding:0;
  font-family:'Plus Jakarta Sans', Helvetica, Arial, sans-serif;
  background:#f1f5f9;
  min-height:100vh;
  display:flex;
  align-items:center;
  justify-content:center;
">

    <!-- INVITATION CARD -->
    <div style="
    width:100%;
    max-width:640px;
    background:#ffffff;
    border-radius:22px;
    overflow:hidden;
    box-shadow:0 30px 80px rgba(15,23,42,0.15);
    position:relative;
  ">

        <!-- SOFT TOP IMAGE STRIP -->
        <div style="
      height:180px;
      background-image:url('https://iitmindia.com/assets/creatives/1.jpg');
      background-size:cover;
      background-position:center;
      position:relative;
    ">

            <!-- VERY LIGHT OVERLAY -->
            <div style="
        position:absolute;
        inset:0;
        background:rgba(255,255,255,0.35);
      "></div>

            <!-- LOGO -->
            <div style="
        position:absolute;
        top:20px;
        width:100%;
        text-align:center;
      ">
                <img src="https://iitmindia.com/assets/iitm2.png" style="max-width:120px;">
            </div>

        </div>

        <!-- CONTENT -->
        <div style="padding:35px 40px; text-align:center;">

            <h1 style="
        margin:0;
        font-size:32px;
        font-weight:800;
        color:#0f172a;
        letter-spacing:-0.5px;
      ">
                You’re Invited to <span style="color:#4338ca;">Bengaluru</span>
            </h1>

            <p style="
        margin-top:12px;
        font-size:15px;
        line-height:1.7;
        color:#475569;
      ">
                We are delighted to confirm your participation in
                <strong>{{ $eventName }}</strong>.
                We look forward to welcoming you at the event.
            </p>

            <!-- EVENT DETAILS CARD -->
            <div style="
        margin-top:25px;
        background:#f8fafc;
        border:1px solid #e2e8f0;
        border-radius:14px;
        padding:20px;
        text-align:left;
      ">

                <div style="
          font-size:12px;
          letter-spacing:1px;
          text-transform:uppercase;
          color:#64748b;
          font-weight:700;
          margin-bottom:10px;
        ">
                    Event Details
                </div>

                <div style="
          font-size:14px;
          line-height:1.8;
          color:#1e293b;
        ">
                    📍 <strong>Venue:</strong> Bengaluru, India<br>
                    🗓️ <strong>Dates:</strong> 23 - 25 JULY 2026<br>
                    ⚡ <strong>Status:</strong>
                    <span style="
            background:#dcfce7;
            color:#166534;
            padding:3px 10px;
            border-radius:6px;
            font-size:12px;
            font-weight:700;
          ">
                        {{ $status }}
                    </span>
                </div>

            </div>

            <!-- CTA -->
            <div style="margin-top:30px;">
                <a href="#" style="
          background:#4338ca;
          color:#ffffff;
          padding:14px 32px;
          text-decoration:none;
          border-radius:10px;
          font-weight:700;
          display:inline-block;
          box-shadow:0 12px 25px rgba(67,56,202,0.25);
        ">
                    DOWNLOAD ENTRY BADGE
                </a>
            </div>

            <!-- FOOTER NOTE -->
            <div style="
        margin-top:30px;
        padding-top:20px;
        border-top:1px solid #e2e8f0;
        font-size:13px;
        color:#64748b;
        line-height:1.6;
      ">

                <p style="margin:0 0 6px;">
                    <strong>Important:</strong> Please carry your entry badge and ID.
                </p>
                <p style="margin:0;">
                    Ref ID: #{{ rand(100000, 999999) }} | QR: Syncing...
                </p>
            </div>

        </div>

    </div>

</div>