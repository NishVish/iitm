<style>
    * {
        box-sizing: border-box;
        font-family: Arial, Helvetica, sans-serif;
    }

    body {
        margin: 0;
        padding: 25px;
        background: #f4f6f9;
        color: #333;
        line-height: 1.6;
    }

    .section {
        background: #fff;
        padding: 25px;
        margin-bottom: 25px;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, .08);
    }

    .container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 25px;
        align-items: start;
    }

    .box {
        background: #fff;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, .08);
        border-top: 5px solid #003366;
    }

    h1,
    h2,
    h3 {
        color: #003366;
        margin-top: 0;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
    }

    th,
    td {
        border: 1px solid #ddd;
        padding: 10px;
        vertical-align: top;
    }

    th {
        background: #003366;
        color: #fff;
    }

    ul,
    ol {
        padding-left: 20px;
    }

    .workflow {
        text-align: center;
        font-size: 18px;
        font-weight: bold;
        line-height: 2;
    }

    @media (max-width:768px) {
        body {
            padding: 15px;
        }

        .container {
            grid-template-columns: 1fr;
        }

        .box,
        .section {
            padding: 18px;
        }
    }
</style>

<div class="section">
    <h1>Volunteer Briefing Manual</h1>

    <?php include('intro.php'); ?>
</div>

<div class="container">

    <div class="box">
        <?php include('screeningdesk.php'); ?>
    </div>

    <div class="box">
        <?php include('registration.php'); ?>
    </div>

    <div class="box">
        <?php include('hostess.php'); ?>
    </div>

</div>

<div class="section">
    <?php include('settelments.php'); ?>
</div>

<div class="section">
    <?php include('workflow.php'); ?>
</div>