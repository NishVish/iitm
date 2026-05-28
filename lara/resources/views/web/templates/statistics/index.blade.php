<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    .iitm-dashboard-wrapper {
        max-width: 1200px;
        margin: 0 auto;
        font-family: 'Segoe UI', Arial, sans-serif;
    }

    .iitm-main-card {
        background: #fff;
        border: 1px solid #eee;
        border-top: 5px solid #A92324;
        padding: 30px;
        border-radius: 4px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }

    .iitm-box-label {
        color: #A92324;
        font-weight: 800;
        text-transform: uppercase;
        font-size: 14px;
        letter-spacing: 1px;
        margin-bottom: 25px;
        display: block;
        border-bottom: 2px solid #f9f9f9;
        padding-bottom: 10px;
    }

    .divider-line {
        border-top: 1px solid #eee;
        margin: 30px 0;
        width: 100%;
    }

    /* Stack vertical spacing for the side column */
    .side-column-content>div:not(:last-child) {
        margin-bottom: 20px;
    }
</style>

<div class="iitm-dashboard-wrapper">

    <div class="mb-4">
        @include('web.templates.statistics.internalkpi')
    </div>

    <div class="iitm-main-card">
        <span class="iitm-box-label">Exhibition Statistics & Global Overview</span>

        <div class="row g-4">
            <div class="col-lg-7">
                <div class="chart-container">
                    @include('web.templates.statistics.bothseprated')
                </div>

            </div>
            <div class="col-lg-5" style="margin-top:0px">
                <div class="side-column-content d-flex flex-column h-100">


                    <div class="pie-wrapper mt-auto">
                        <style>
                            .mt-auto {
                                margin-top: 30px !important;
                            }

                            .pie-wrapper {
                                padding-top: 10px;
                            }
                        </style>
                        @include('web.templates.statistics.piechart')
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-12">
                <div class="stats-wrapper">
                    <!-- @include('web.templates.statistics.stats') -->
                </div>
                @include('web.templates.statistics.gobalinfo')
            </div>
        </div>
    </div>

</div>