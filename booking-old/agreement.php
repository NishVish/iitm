<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Terms Modal</title>

    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
        }

        .modal-content {
            background: #fff;
            margin: 5% auto;
            padding: 20px;
            width: 60%;
            max-height: 85%;
            overflow-y: auto;
            border-radius: 8px;
            text-align: center;
        }

        .header-logo {
            max-width: 180px;
            margin-bottom: 10px;
        }

        .terms-box {
            max-height: 300px;
            overflow-y: scroll;
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
    </style>

    <script>
        function showModal() {
            document.getElementById("termsModal").style.display = "block";
        }

        function closeModal() {
            document.getElementById("termsModal").style.display = "none";
        }

        function enablePayment() {
            const checkbox = document.getElementById("acceptTerms");
            const button = document.getElementById("acceptBtn");
            button.disabled = !checkbox.checked;
        }

        window.onload = showModal;
    </script>

</head>

<body>

    <!-- Modal -->
    <div id="termsModal" class="modal">
        <div class="modal-content">

            <!-- Logo -->
            <img src="https://iitmindia.com/assets/iitm3.png" alt="IITM Logo" class="header-logo">

            <h3>Terms & Conditions of Participation</h3>

            <?php include 'termsandconditions.php'; ?>

            <div style="margin-top:15px;">
                <input type="checkbox" id="acceptTerms" onchange="enablePayment()">
                <label for="acceptTerms">I accept the Terms & Conditions</label>
            </div>

            <br>
            <button id="acceptBtn" disabled onclick="closeModal()">Continue</button>
        </div>
    </div>

</body>

</html>