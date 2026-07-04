<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Certificate Editor</title>

    <style>
        @font-face {
            font-family: 'NovaQuinta';
            src: url('NovaQuinta_PERSONAL_USE_ONLY.otf') format('opentype');
        }

        /* Layout */
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
        }

        /* Control panel */
        .panel {
            width: 300px;
            padding: 20px;
            background: #f3f3f3;
            border-right: 1px solid #ddd;
        }

        .panel h2 {
            margin-top: 0;
        }

        .panel label {
            display: block;
            margin-top: 15px;
            font-size: 14px;
        }

        .panel input,
        .panel textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            font-size: 14px;
        }

        /* Certificate area */
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
            font-size: 40px;
            font-family: 'NovaQuinta', serif;
            color: #000;
            text-align: center;
            white-space: pre-line;
            width: 80%;
        }

        /* Print only certificate */
        @media print {
            body {
                display: block;
            }

            .panel {
                display: none;
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
        <h2>Controls</h2>

        <label>Text</label>
        <textarea id="textInput">Odhissa Tourism</textarea>

        <label>Font Size</label>
        <input type="range" id="fontSize" min="20" max="100" value="40">
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
    </script>

</body>

</html>