<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Assets</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            padding: 20px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
        }

        .card {
            background: white;
            padding: 10px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            text-align: center;
        }

        .card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 8px;
        }

        .btn {
            margin-top: 10px;
            padding: 8px 12px;
            border: none;
            background: #007bff;
            color: white;
            border-radius: 6px;
            cursor: pointer;
        }

        .btn:hover {
            background: #0056b3;
        }

        .copied {
            font-size: 12px;
            color: green;
            margin-top: 5px;
            display: none;
        }
    </style>
</head>
<body>

<h2>Assets Gallery</h2>

<div class="grid">

    <!-- Logo -->
    <div class="card">
        <img src="{{ $logo }}" alt="Logo">
        <button class="btn" onclick="copyLink('{{ $logo }}', this)">Copy Link</button>
        <div class="copied">Copied!</div>
    </div>

    <!-- Logo 2 -->
    <div class="card">
        <img src="{{ $logo2 }}" alt="Logo 2">
        <button class="btn" onclick="copyLink('{{ $logo2 }}', this)">Copy Link</button>
        <div class="copied">Copied!</div>
    </div>

    <!-- Creative -->
    <div class="card">
        <img src="{{ $creative1 }}" alt="Creative">
        <button class="btn" onclick="copyLink('{{ $creative1 }}', this)">Copy Link</button>
        <div class="copied">Copied!</div>
    </div>

</div>

<script>
    function copyLink(link, btn) {
        navigator.clipboard.writeText(link).then(() => {
            let msg = btn.nextElementSibling;
            msg.style.display = "block";

            setTimeout(() => {
                msg.style.display = "none";
            }, 1500);
        });
    }
</script>

</body>
</html>