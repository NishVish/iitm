<!DOCTYPE html>
<html>

<head>
    <title>Registration Layout</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #ddd;
        }

        .container {
            width: 210mm;
            margin: 20px auto;
        }


        /* Common Boxes */

        .box {
            height: 80px;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            font-weight: bold;
            border: 2px solid #333;
        }


        .registration {
            background: #3498db;
            color: white;
        }


        .help {
            background: #e74c3c;
            color: white;
        }


        .extra {
            background: #27ae60;
            color: white;
        }


        /* Registration + Facia */

        .row {
            display: flex;
            gap: 10px;
        }


        .reg-box {
            width: 300px;
        }


        .facia-box {
            width: 300px;
            background: white;
        }


        /* A4 PAGE */

        .a4-page {

            width: 210mm;
            height: 297mm;

            padding: 20mm;

            background: white;

            margin: 10px auto;

            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);

            page-break-after: always;

            overflow: hidden;
        }



        /* PRINT SETTINGS */

        @media print {


            @page {
                size: A4;
                margin: 0;
            }


            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }


            body {

                background: white;

            }


            .container {

                width: 210mm;
                margin: 0;

            }


            .a4-page {

                width: 210mm;
                height: 297mm;

                margin: 0;

                box-shadow: none;

                page-break-after: always;

            }


            .registration {

                background: #3498db !important;
                color: white !important;

            }


            .help {

                background: #e74c3c !important;
                color: white !important;

            }


            .extra {

                background: #27ae60 !important;
                color: white !important;

            }

        }
    </style>

</head>


<body>


    <div class="container">


        <!-- A4 PAGE 1 -->

        <div class="a4-page">

            <?php include('chart.php'); ?>

        </div>



        <!-- A4 PAGE 2 -->

        <div class="a4-page">

            <?php include('plan.php'); ?>

        </div>

        <div class="a4-page">

            <?php include('plan2.php'); ?>

        </div>

        <!-- A4 PAGE 3 -->

        <div class="a4-page">

            <?php include('material.php'); ?>

        </div>

        <div class="a4-page">

            <?php include('strategy.php'); ?>

        </div>
    </div>


</body>

</html>