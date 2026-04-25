<div style="
    width:100%;
    min-height:100svh;
    position:relative;
    overflow:hidden;
    font-family:'Inter', system-ui, -apple-system, sans-serif !important;
    color:white;
    isolation:isolate;
">

    <!-- Background Image -->
    <img src="https://iitmindia.com/assets/creatives/2.jpg" style="
        position:absolute;
        inset:0;
        width:100%;
        height:100%;
        object-fit:cover;
        transform:scale(1.05);
        z-index:0;
        pointer-events:none;
        user-select:none;
    " />

    <!-- Overlay -->
    <div style="
        position:absolute;
        inset:0;
        background:linear-gradient(
            to bottom,
            rgba(0,0,0,0.35),
            rgba(0,0,0,0.70)
        );
        z-index:1;
    "></div>

    <!-- Content -->
    <div style="
        position:relative;
        z-index:2;
        min-height:100svh;
        display:flex;
        flex-direction:column;
        justify-content:center;
        padding:clamp(40px, 6vw, 80px);
        max-width:1100px;
        margin:0 auto;
        box-sizing:border-box;
    ">

        <div style="font-size:14px; opacity:0.8; margin-bottom:10px;">
            ⚡ Visitor Portal
        </div>

        <div style="
            font-size:clamp(32px, 5vw, 52px);
            font-weight:800;
            letter-spacing:-1px;
            line-height:1.1;
        ">
            A Marketplace that Satisfies all your
            <span style="color: #AA2324; text-shadow: 2px 2px 0px #ffffff;">
                Business Needs
            </span>
        </div>

        <div style="
            margin-top:20px;
            font-size:clamp(16px, 2vw, 20px);
            opacity:0.9;
            max-width:700px;
            line-height:1.5;
        ">
            Persistently striving to strengthen the travel & tourism community through India's largest trade platform.
        </div>

        <div style="margin-top:40px;">
        </div>

        <div style="margin-top:20px;">
            @include('web.templates.whyvisit')
        </div>

        <div style="margin-top:20px;">
            @include('web.templates.sentiments')
        </div>

    </div>
</div>