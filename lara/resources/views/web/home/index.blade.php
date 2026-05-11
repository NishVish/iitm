@include('css')

<!-- LOADER -->
<div id="loader">
    <div class="spinner"></div>
</div>

@include('web.home.header')

<style>
    .side-menu {
        height: auto !important;
    }

    /* Loader overlay */
    #loader {
        position: fixed;
        inset: 0;
        background: #ffffff;
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 99999;
        transition: opacity 0.3s ease;
    }

    /* Spinner */
    .spinner {
        width: 55px;
        height: 55px;
        border: 6px solid #eee;
        border-top: 6px solid #3498db;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }
</style>

<div id="iitmStickyHeader">
    @include('web.header2')
</div>

@include('web.home.section1')


<div class="container">

    <div class="section1">
        @include('web.home.video')
    </div>

    <div class="section2">
        <img id="frontlogo" src="https://iitmindia.com/wp-content/uploads/2024/03/image-1.png">

        <h1>
            India’s Premier Travel Show
        </h1>

        <p class="bottom-text">
            Escalate Your Brand Visibility With IITM Exhibition And Event
        </p>
    </div>

</div>




<div>
    <!-- section 3 -->
    <div class="content-wrapper">


        <!-- quick info -->
        @include('web.templates.quickinfo')

        @include('web.templates.statistics.index')
        @include('web.templates.intro')
        @include('web.templates.keyhighlights')
        @include('web.templates.cities')
        @include('web.templates.whyexhibit')
        @include('web.templates.tourismboard')
    </div>
    <style>
        .content-wrapper {
            background-color: white;
        }
    </style>


</div>
@include('web.footer')

<script>
    window.addEventListener("load", function () {
        const loader = document.getElementById("loader");
        loader.style.opacity = "0";
        setTimeout(() => loader.style.display = "none", 300);
    });
</script>