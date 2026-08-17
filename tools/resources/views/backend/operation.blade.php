<style>
    body {
        margin: 0;
        font-family: Arial;
        background: #f4f6f9;
    }

    .dashboard {
        display: grid;
        grid-template-rows: auto 1fr;
        height: 90vh;
    }

    .top {
        padding: 10px;
        background: #fff;
        border-bottom: 1px solid #ddd;
    }

    .main {
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 10px;
        padding: 10px;

        /* IMPORTANT */
        height: 100%;
        min-height: 0;
    }

    /* ✅ FIXED HEIGHT */
    .left,
    .right {
        overflow-y: auto;
        background: #fff;
        border-radius: 10px;
        padding: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .left {
        border-right: 1px solid #eee;
    }
</style>
@include('backend.sql')
<div class="dashboard">

    <!-- TOP: SQL -->


    <!-- LEFT + RIGHT -->
    <div class="main">

        <!-- LEFT: ROUTES -->
        <div class="left">
            @include('backend.allroutes')
        </div>

        <!-- RIGHT: TABLES -->
        <div class="right">
            @include('backend.table')
        </div>

    </div>

</div>