<style>
    .containerstats {
        display: flex;
        background: #f7f7f7;
        /* one single background */
        padding: 20px 80px;
        gap: 20px;
        align-items: flex-start;
    }

    .box {
        flex: 1;
        background: transparent;
        border: none;
        box-shadow: none;
        padding: 0;
        margin: 0;
    }

    /* IMPORTANT: remove KPI internal box styling */
    .stat-card {
        background: transparent !important;
        border: none !important;
        box-shadow: none !important;
        padding: 8px 0;
    }

    .stats-grid {
        background: transparent !important;
    }
</style>

<div class="containerstats">
    <div class="box">
        <div>
            @php
                $lastsegment = last(request()->segments());
            @endphp
            @if($lastsegment == "attending")
                @include('web.templates.statistics.exhibitorstack')




            @elseif($lastsegment == "exhibiting")
                @include('web.templates.statistics.visitorstack')
            @endif
        </div>
    </div>

    <div class="box">
        @include('web.templates.statistics.kpistack')
    </div>
</div>



@if($lastsegment == "attending")


    <div style="text-align: center;">
        <style>
            .chart-note {
                width: 100%;
                background: #f7f7f7;

                box-shadow: 0 2px 8px rgba(0, 0, 0, .08);
            }

            .chart-note h4 {
                margin: 0 0 10px;
                color: #aa2324;
            }

            .chart-note p {
                margin: 6px 0;
                line-height: 1.5;
            }
        </style>
        <div class="chart-note">
            <h4>Exhibitor Insights</h4>
            <p><strong>Avg YoY Growth:</strong> <span id="exhibitorGrowth"></span>%</p>
            <p>Steady exhibitor participation with strong projected growth through 2026-27.</p>
        </div>
    </div>




@elseif($lastsegment == "exhibiting")


    <div style="text-align:center;">
        <div class="chart-note">
            <h4>Visitor Insights</h4>
            <p><strong>Avg YoY Growth:</strong> <span id="visitorGrowth"></span>%</p>
            <p>Consistent visitor growth with strong projected attendance through 2026-27.</p>
        </div>
</div>@endif