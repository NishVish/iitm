<div class="registration-plan">

    <h2>REGISTRATION DESK STRUCTURE</h2>

    <div class="chart">

        <!-- Main -->
        <div class="chart-box main-box">
            REGISTRATION
        </div>


        <!-- Level 1 Split -->
        <div class="chart-row">

            <div class="chart-item">

                <div class="chart-box trade">
                    TRADE
                </div>
                <!-- Exhibitor Split -->
                <div class="chart-row inner-row">

                    <div class="chart-item">

                        <div class="chart-box spot">

                            SPOT + Pre Registered<br>

                            <br><br>
                            Lead: Nishant

                        </div>

                    </div>
                </div>
            </div>



            <div class="chart-item">

                <div class="chart-box exhibitor">
                    EXHIBITOR
                </div>


                <!-- Exhibitor Split -->
                <div class="chart-row inner-row">

                    <div class="chart-item">

                        <div class="chart-box spot">

                            SPOT<br>
                            REGISTRATION
                            <br><br>
                            Lead: Indira

                        </div>

                    </div>



                    <div class="chart-item">

                        <div class="chart-box pre">

                            PRE<br>
                            REGISTRATION
                            <br><br>
                            Lead: Usha

                        </div>

                    </div>


                </div>

            </div>

        </div>



        <!-- Support -->

        <div class="support-box">

            <h3>DISTRIBUTION SUPPORT</h3>

            <p>
                <b>Lead:</b> Usha
                <br>
                Support: Sangeetha + 3 Volunteers From Registration Desk
            </p>

        </div>


        <h2>Pre printed Badge Distribution Strategy</h2>
        <p>Arrange Sales Person wise By Box then arrange alphabatical Company Wise</p>


    </div>


</div>



<style>
    .registration-plan {

        font-family: Arial, sans-serif;
        width: 100%;

    }


    .chart {

        width: 100%;
        max-width: 700px;
        margin: auto;
        text-align: center;

    }


    .chart-row {

        display: flex;
        gap: 15px;
        justify-content: center;
        margin-top: 20px;

    }


    .chart-item {

        flex: 1;
        min-width: 0;

    }


    .chart-box {

        border: 3px solid #333;
        border-radius: 12px;

        padding: 20px;

        font-size: 18px;
        font-weight: bold;

        display: flex;
        align-items: center;
        justify-content: center;

        text-align: center;

        min-height: 90px;

        overflow-wrap: break-word;

    }



    .main-box {

        background: #2c3e50;
        color: white;

        font-size: 24px;

    }



    .trade {

        background: #3498db;
        color: white;

    }



    .exhibitor {

        background: #27ae60;
        color: white;

    }



    .inner-row {

        margin-top: 20px;

    }



    .spot {

        background: #e74c3c;
        color: white;

    }



    .pre {

        background: #f39c12;
        color: white;

    }



    .support-box {

        margin-top: 30px;

        padding: 20px;

        border: 3px dashed #555;

        background: #f8f8f8;

        font-size: 18px;

    }



    /* A4 print adjustment */

    @media print {

        .chart {

            width: 100%;

        }


        .chart-box {

            font-size: 16px;
            padding: 12px;

        }


    }
</style>