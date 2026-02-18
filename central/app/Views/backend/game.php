<?= view('backend/sidemenu') ?>  <!-- loads app/Views/header.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ultimate Retro CRT TV</title>
    <style>
        
        gamebody {
            font-family: 'Courier New', monospace;
            color: #eee;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h1 { color: #f0ad4e; text-shadow: 2px 2px #000; }

        /* The Wooden Cabinet */
        .tv-cabinet {
            background: #5d3a1a; /* Wood color */
            padding: 40px 20px;
            border-radius: 30px;
            border: 8px solid #3d2610;
            box-shadow: 0 20px 50px rgba(0,0,0,0.8);
            display: flex;
            align-items: center;
            gap: 20px;
            position: relative;
        }

        /* The CRT Screen Housing */
        .screen-area {
            width: 600px;
            height: 450px;
            background: #111;
            border: 15px solid #222;
            border-radius: 15% / 8%; /* Creates the curved CRT look */
            position: relative;
            overflow: hidden;
            box-shadow: inset 0 0 40px #000;
        }

        /* Scanline Overlay */
        .screen-area::after {
            content: " ";
            position: absolute;
            top: 0; left: 0; bottom: 0; right: 0;
            background: linear-gradient(rgba(18, 16, 16, 0) 50%, rgba(0, 0, 0, 0.25) 50%), 
                        linear-gradient(90deg, rgba(255, 0, 0, 0.06), rgba(0, 255, 0, 0.02), rgba(0, 0, 255, 0.06));
            background-size: 100% 4px, 3px 100%;
            pointer-events: none;
            z-index: 10;
        }

        iframe {
            width: 100%;
            height: 100%;
            border: none;
            filter: brightness(1.1) contrast(1.2) saturate(1.2);
        }

        /* Physical Controls Panel */
        .controls {
            display: flex;
            flex-direction: column;
            justify-content: space-around;
            height: 400px;
            width: 100px;
            background: #4a2e15;
            padding: 10px;
            border-radius: 10px;
            border-left: 4px solid #3d2610;
        }

        .knob {
            width: 50px;
            height: 50px;
            background: #222;
            border-radius: 50%;
            margin: 0 auto;
            border: 4px solid #444;
            position: relative;
            box-shadow: 2px 2px 5px rgba(0,0,0,0.5);
        }

        .knob::after {
            content: '';
            position: absolute;
            top: 5px; left: 50%;
            width: 4px; height: 15px;
            background: #f0ad4e;
            transform: translateX(-50%);
        }

        .speaker-grill {
            width: 60px;
            height: 100px;
            margin: 0 auto;
            background-image: radial-gradient(#111 20%, transparent 20%);
            background-size: 8px 8px;
        }

        select {
            margin-bottom: 20px;
            padding: 10px;
            background: #222;
            color: #f0ad4e;
            border: 2px solid #5d3a1a;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <gamebody>

<h1>VINTAGE BROADCAST</h1>

<select id="gameSelect">
    <option value="">-- Tune Channel --</option>
    <option value="contra">Channel 03: Contra</option>
    <option value="mario">Channel 05: Super Mario</option>
</select>

<div class="tv-cabinet">
    <div class="screen-area">
        <iframe id="gameFrame" src=""></iframe>
    </div>

    <div class="controls">
        <div class="knob"></div> <div class="knob" style="transform: rotate(45deg);"></div> <div class="speaker-grill"></div>
        <div class="speaker-grill"></div>
    </div>
</div>

<script>
    const gameURLs = {
        contra: "https://console-classics.com/retro-games/contra/?embed=1",
        mario: "https://console-classics.com/retro-games/mario-bros/?embed=1"
    };

    document.getElementById('gameSelect').addEventListener('change', function() {
        const gameKey = this.value;
        const iframe = document.getElementById('gameFrame');
        iframe.src = gameKey ? gameURLs[gameKey] : '';
    });
</script>
</gamebody>

</body>
</html>