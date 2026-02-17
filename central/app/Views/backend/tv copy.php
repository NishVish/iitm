<?= view('header') ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Retro TV Console Deluxe</title>
    <script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
    <style>
        body { background-color: #1a1a1a; font-family: 'Courier New', monospace; color: #eee; display: flex; flex-direction: column; align-items: center; padding: 50px 20px; }
        
        /* The Antennae */
        .antenna-container { width: 400px; height: 100px; position: relative; margin-bottom: -15px; }
        .antenna { position: absolute; bottom: 0; width: 4px; height: 150px; background: #888; border-radius: 2px; }
        .antenna.left { left: 40%; transform: rotate(-30deg); transform-origin: bottom; }
        .antenna.right { right: 40%; transform: rotate(30deg); transform-origin: bottom; }
        .antenna::after { content: ''; position: absolute; top: 0; left: -4px; width: 12px; height: 12px; background: #aaa; border-radius: 50%; }

        /* The Cabinet */
        .tv-cabinet { 
            background: #5d3a1a; padding: 30px; border-radius: 25px; 
            border: 12px solid #3d2610; display: flex; gap: 15px; 
            box-shadow: 0 30px 60px rgba(0,0,0,0.9); position: relative;
        }

        /* Screen Section */
        .screen-area { 
            width: 550px; height: 420px; background: #000; 
            border: 15px solid #222; border-radius: 12% / 6%; 
            position: relative; overflow: hidden; 
        }
        video, iframe { width: 100%; height: 100%; border: none; display: none; }
        .active { display: block !important; }

        /* Side Control Panel (EPG & Buttons) */
        .side-panel {
            width: 220px; background: #4a2e15; border-radius: 15px;
            padding: 15px; display: flex; flex-direction: column;
            border-left: 4px solid #3d2610; box-shadow: inset 5px 0 10px rgba(0,0,0,0.3);
        }

        /* Channel List Styling */
        .channel-guide {
            background: #111; height: 250px; overflow-y: scroll;
            border: 3px solid #222; margin-bottom: 15px; padding: 5px;
            font-size: 11px; color: #0f0; /* Green phosphor look */
        }
        .channel-guide div { 
            padding: 5px; cursor: pointer; border-bottom: 1px solid #222; 
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .channel-guide div:hover { background: #004400; }
        .channel-guide .selected { background: #006600; color: #fff; }

        /* Physical Buttons */
        .button-row { display: flex; justify-content: center; gap: 10px; margin-bottom: 15px; }
        .retro-button {
            width: 45px; height: 45px; background: #333; border: 3px solid #111;
            border-bottom: 6px solid #000; border-radius: 5px; color: #fff;
            font-size: 10px; cursor: pointer; display: flex; align-items: center; justify-content: center;
        }
        .retro-button:active { border-bottom-width: 2px; transform: translateY(4px); }

        /* Input Switch (Game/TV) */
        .mode-switch {
            background: #222; padding: 5px; border-radius: 5px;
            display: flex; justify-content: space-around; margin-top: auto;
        }
        .mode-switch label { font-size: 10px; cursor: pointer; padding: 5px; }
        .mode-switch input { display: none; }
        .mode-switch input:checked + span { color: #f0ad4e; font-weight: bold; }

        /* Scrollbar */
        .channel-guide::-webkit-scrollbar { width: 5px; }
        .channel-guide::-webkit-scrollbar-thumb { background: #333; }
    </style>
</head>
<body>

    <div class="antenna-container">
        <div class="antenna left"></div>
        <div class="antenna right"></div>
    </div>

    <div class="tv-cabinet">
        <div class="screen-area">
            <video id="tvVideo" class="active"></video>
            <iframe id="gameFrame" src=""></iframe>
        </div>

        <div class="side-panel">
            <div style="text-align:center; font-size:12px; margin-bottom:5px; color:#f0ad4e;">PROGRAM GUIDE</div>
            
            <div class="channel-guide" id="guide">
                <div>Loading Satellites...</div>
            </div>

            <div class="button-row">
                <button class="retro-button" onclick="changeChannel(-1)">CH-</button>
                <button class="retro-button" onclick="changeChannel(1)">CH+</button>
            </div>

            <div style="height:40px; background:radial-gradient(#111 25%, transparent 25%); background-size:6px 6px;"></div>

            <div class="mode-switch">
                <label><input type="radio" name="mode" value="tv" checked onchange="switchMode('tv')"><span>LIVE TV</span></label>
                <label><input type="radio" name="mode" value="game" onchange="switchMode('game')"><span>GAME</span></label>
            </div>
        </div>
    </div>

<script>
    let channels = [];
    let currentIndex = 0;
    const video = document.getElementById('tvVideo');
    const iframe = document.getElementById('gameFrame');
    const guide = document.getElementById('guide');
    const hls = new Hls();

    // 1. Fetch Channels
    async function loadIPTV() {
        try {
            const res = await fetch('https://iptv-org.github.io/iptv/index.m3u');
            const data = await res.text();
            const lines = data.split('\n');
            guide.innerHTML = '';
            
            for (let i = 0; i < lines.length; i++) {
                if (lines[i].startsWith('#EXTINF')) {
                    const name = lines[i].split(',')[1].trim() || "Unknown";
                    const url = lines[i+1].trim();
                    channels.push({ name, url });
                    
                    const el = document.createElement('div');
                    el.innerText = `${channels.length}. ${name}`;
                    el.onclick = () => playChannel(channels.length - 1);
                    guide.appendChild(el);
                }
            }
        } catch (e) { guide.innerText = "Signal Interference (CORS Error)"; }
    }

    // 2. Playback Logic
    function playChannel(index) {
        if (index < 0 || index >= channels.length) return;
        currentIndex = index;
        
        // Update Guide UI
        Array.from(guide.children).forEach((el, i) => {
            el.className = i === index ? 'selected' : '';
            if(i === index) el.scrollIntoView({ block: 'nearest' });
        });

        if (Hls.isSupported()) {
            hls.loadSource(channels[index].url);
            hls.attachMedia(video);
            video.play();
        }
    }

    function changeChannel(direction) {
        playChannel(currentIndex + direction);
    }

    // 3. Input Switch
    function switchMode(mode) {
        if (mode === 'tv') {
            video.classList.add('active');
            iframe.classList.remove('active');
            iframe.src = "";
        } else {
            video.pause();
            video.classList.remove('active');
            iframe.classList.add('active');
            iframe.src = "https://console-classics.com/retro-games/mario-bros/?embed=1";
        }
    }

    loadIPTV();
</script>
</body>
</html>