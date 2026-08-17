<div style="
    width:100%;
    overflow:hidden;
    position:relative;
    font-family:Inter, sans-serif;
">

    <!-- Background Image -->
    <img src="
    
    https://iitmindia.com/assets/creatives/2.jpg
    " style="
            position:absolute;
            width:100%;
            height:100%;
            object-fit:cover;
            top:0;
            left:0;
         " />

    <!-- Dark overlay -->
    <div style="
        position:absolute;
        inset:0;
        background:rgba(255, 255, 255, 0);
    "> </div>

    <!-- Content (FIXED) -->
    <div style="
        position:relative;
        z-index:2;
        color:white;
    ">



    </div>
    <div style="
        position:relative;
        z-index:2;
        color:white;
    ">
        @include('web.participant.attending.hook2')

        <!-- <div style="margin-top:30px;">
            @include('web.templates.whyvisit')
        </div> -->

        <div style="margin-top:30px;">
            @include('web.participant.attending.hook')
        </div>

        @include('web.templates.sentiments')
    </div>
</div>