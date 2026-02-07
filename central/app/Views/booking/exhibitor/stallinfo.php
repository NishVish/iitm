<?php
include 'header3.php';
?>

<style>


    .container {
        max-width: 500px;
        padding: 30px;
        background-color: #fff;
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        border-radius: 10px;
    }

    h2 {
        color: #4CAF50;
        margin-bottom: 20px;
        text-align: center;
    }



    form label {
        display: block;
        font-weight: 600;
    }

    form input {
        width: 100%;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ccc;
        box-sizing: border-box;
        font-size: 1rem;
    }

    form input[readonly] {
        background-color: #e9ecef;
    }

    .btn {
        display: inline-block;
        padding: 12px 25px;
        background-color: #4CAF50;
        color: white;
        font-size: 1rem;
        border: none;
        border-radius: 5px;
        text-decoration: none;
        cursor: pointer;
        transition: background 0.3s ease;
        text-align: center;
    }

    .btn:hover {
        background-color: #45a049;
    }

    .note {
        font-size: 0.9rem;
        color: #555;
        margin-bottom: 20px;
    }
</style>

<div class="container">
    <h2>Step 2: Stall Requirements</h2>

    <p>We offer standard stall sizes with fixed dimensions measured in square meters (sqm). Each stall is priced based on the selected size.</p>

    <p>The following facilities are <strong>included at no extra cost</strong>:</p>

    <ul>
        <li>LED lights</li>
        <li>Table and chairs</li>
        <li>Power socket</li>
        <li>Fascia name display</li>
    </ul>

    <form method="post" action="processPayment">

<!-- 
        <label>Stall No</label>
        <input type="text" name="stall_no" required> -->

        <label>Stall Size (sqm)</label>
        <input type="number" name="size" required>

        <label>Fascia Name </label>
        <input type="text" name="fascia_name" required>

        <!-- <label>Price</label>
        <input type="number" step="0.01" name="price" required> -->

        <a href="<?= site_url('booking/exhibitor_booking/details') ?>" class="btn">Proceed</a>
    </form>
</div>
