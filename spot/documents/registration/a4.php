<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            margin: 0;
            background: #ddd;
            font-family: Arial, sans-serif;
        }

        .a4-page {
            width: 210mm;
            height: 297mm;
            padding: 20mm;
            margin: 20px auto;
            background: white;
            box-sizing: border-box;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);

            page-break-after: always;
        }


        /* Printing setup */
        @media print {

            body {
                background: white;
            }

            .a4-page {
                margin: 0;
                box-shadow: none;
                width: 210mm;
                height: 297mm;
                page-break-after: always;
            }

        }
    </style>
</head>

<body>


    <!-- A4 PAGE 1 -->
    <div class="a4-page">

        <h1>Registration Setup</h1>

        <p>
            Put your first page content here.
        </p>

    </div>


    <!-- A4 PAGE 2 -->
    <div class="a4-page">

        <h1>Volunteer Allocation</h1>

        <p>
            Put your second page content here.
        </p>

    </div>


    <!-- A4 PAGE 3 -->
    <div class="a4-page">

        <h1>Support Plan</h1>

        <p>
            Put your third page content here.
        </p>

    </div>


</body>

</html>