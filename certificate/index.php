<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Certificate Editor</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        @font-face {
            font-family: 'Luxury';
            src: url('TAN-MON CHERI-Regular.otf') format('opentype');
        }

        @font-face {
            font-family: 'NovaQuinta';
            src: url('NovaQuinta_PERSONAL_USE_ONLY.otf') format('opentype');
        }

        @font-face {
            font-family: 'Tan Mon Cheri';
            src: url('TanMonCheri.otf') format('opentype');
        }

        @font-face {
            font-family: 'Atteron';
            src: url('Atteron.otf') format('opentype');
        }

        @font-face {
            font-family: 'Rown Berry';
            src: url('RownBerry.otf') format('opentype');
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
        }

        .panel {
            width: 320px;
            padding: 20px;
            background: #f3f3f3;
            border-right: 1px solid #ddd;
            overflow-y: auto;
            height: 100vh;
            box-sizing: border-box;
        }

        .panel h2 {
            margin-top: 0;
        }

        .panel label {
            display: block;
            margin-top: 12px;
            font-size: 14px;
        }

        .panel input,
        .panel textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            box-sizing: border-box;
        }

        .font-options label {
            display: block;
            margin: 10px 0;
            cursor: pointer;
        }

        .font-options input[type="radio"] {
            width: auto;
            margin-right: 8px;
        }

        .certificate {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #e9e9e9;
            padding: 20px;
        }

        .cert-wrapper {
            position: relative;
            width: 900px;
        }

        .cert-img {
            width: 100%;
            display: block;
        }

        .cert-name {
            position: absolute;
            top: 37.5%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 80%;
            text-align: center;
            white-space: pre-line;
            font-size: 40px;
            font-family: 'NovaQuinta';
        }

        @media print {
            .panel {
                display: none;
            }

            body {
                display: block;
            }

            .certificate {
                padding: 0;
                background: white;
            }
        }
    </style>
</head>

<body>

    <div class="panel">

        <h2>Certificate Controls</h2>

        <label>Text</label>
        <textarea id="textInput">Odhissa Tourism</textarea>

        <label>Font Size</label>
        <input type="range" id="fontSize" min="20" max="100" value="40">

        <label><b>Select Font</b></label>

        <div class="font-options">
            <label style="font-family:'Poppins';">
                <input type="radio" name="fontFamily" value="Poppins">
                Poppins
            </label>

            <label style="font-family:'Luxury';">
                <input type="radio" name="fontFamily" value="Luxury" checked>
                Luxury
            </label>

            <label style="font-family:'NovaQuinta';">
                <input type="radio" name="fontFamily" value="NovaQuinta" checked>
                NovaQuinta
            </label>

            <label style="font-family:'Cinzel Decorative';">
                <input type="radio" name="fontFamily" value="'Cinzel Decorative'">
                Luxury - Cinzel Decorative
            </label>

            <label style="font-family:'Tan Mon Cheri';">
                <input type="radio" name="fontFamily" value="'Tan Mon Cheri'">
                Celestial - Tan Mon Cheri
            </label>

            <label style="font-family:'Atteron';">
                <input type="radio" name="fontFamily" value="'Atteron'">
                Business - Atteron
            </label>

            <label style="font-family:'Rown Berry';">
                <input type="radio" name="fontFamily" value="'Rown Berry'">
                Rown Berry
            </label>

        </div>

    </div>

    <div class="certificate">
        <div class="cert-wrapper">
            <img src="template.jpg" class="cert-img">
            <div class="cert-name" id="certName">Odhissa Tourism</div>
        </div>
    </div>

    <script>
        const textInput = document.getElementById("textInput");
        const certName = document.getElementById("certName");
        const fontSize = document.getElementById("fontSize");

        textInput.addEventListener("input", () => {
            certName.innerText = textInput.value;
        });

        fontSize.addEventListener("input", () => {
            certName.style.fontSize = fontSize.value + "px";
        });

        document.querySelectorAll('input[name="fontFamily"]').forEach(radio => {
            radio.addEventListener("change", function () {
                certName.style.fontFamily = this.value;
            });
        });
    </script>

</body>

</html>