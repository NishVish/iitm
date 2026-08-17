<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>A4 Page with Two Divs</title>
  <style>
    /* A4 page setup */
    body {
      margin: 0;
      padding: 0;
      background: #eee; /* just for screen visibility */
    }

    .a4 {
      width: 21cm;
      height: 29.7cm;
      padding: 1cm;
      box-sizing: border-box;
      background: white;
      margin: auto;
    }

    .box {
      width: 9.2cm;
      height: 13.4cm;
      border: 1px solid black;
      display: inline-block;
      margin: 0.5cm;
    }

    /* Print settings */
    @media print {
      body {
        background: none;
      }
      .a4 {
        margin: 0;
        width: 21cm;
        height: 29.7cm;
      }
    }
  </style>
</head>
<body>

  <div class="a4">
    <div class="box"></div>
    <div class="box"></div>
  </div>

</body>
</html>