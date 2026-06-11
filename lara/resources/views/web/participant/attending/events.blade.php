<div style="width:100%; display:flex; justify-content:center; padding:30px 0;">

    <!-- MAIN SHOWCASE CARD -->
    <div style="
        max-width:1000px;
        width:100%;
        padding:25px 25px 30px;
        background:#fff;
        border:1px solid rgba(170,35,36,0.15);
        border-radius:14px;
        box-shadow:0 10px 30px rgba(0,0,0,0.06);
    ">

        <!-- HEADER -->
        <div style="text-align:center; margin-bottom:18px;">

            <div style="
                display:inline-block;
                padding:5px 12px;
                font-size:12px;
                background:#AA2324;
                color:#fff;
                border-radius:999px;
                margin-bottom:8px;
            ">
                Live Events
            </div>

            <h3 style="margin:0; font-size:24px; font-weight:800; color:#111;">
                Upcoming & Attending Listings
            </h3>

            <!-- <p style="margin:6px auto 0; font-size:13px; color:#666; max-width:500px;">
                Discover active IITM event participation in real time
            </p> -->




        </div>

        <!-- BODY (SHOWCASE AREA) -->
        <div style="
            display:flex;
            justify-content:center;
            padding:10px;
            background:#fafafa;
            border-radius:10px;
        ">
            <div style="width:100%;">

                @include('web.participant.attending.eventlisting')
            </div>
        </div>

    </div>

</div>