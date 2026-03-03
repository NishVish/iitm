<?= view('backend/sidemenu') ?>  <!-- loads app/Views/header.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Retro Console Deluxe</title>
    <script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
    <style>
        tvbody { 
            
            font-family: 'Courier New', monospace;
             color: #eee; display: flex; flex-direction: column;
             align-items: center; 
             
             padding: 20px;
            
            }
        
        /* Cabinet */
        .tv-cabinet { 
            background: #5d3a1a; padding: 30px; border-radius: 25px; 
            border: 12px solid #3d2610; display: flex; gap: 15px; 
            box-shadow: 0 30px 60px rgba(0,0,0,0.9); position: relative;
        }

        /* Screen */
        .screen-area { 
            width: 550px; height: 420px; background: #000; 
            border: 15px solid #222; border-radius: 12% / 6%; 
            position: relative; overflow: hidden; 
        }

        /* Static & Game Menu Overlays */
        #static {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            z-index: 10; background: url('https://upload.wikimedia.org/wikipedia/commons/5/5a/Static_noise.gif');
            opacity: 0.2; pointer-events: none; display: block;
        }

        #gameMenu {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            z-index: 15; background: #0000aa; display: none; /* Blue screen of games */
            flex-direction: column; align-items: center; justify-content: center;
        }

        .game-option {
            color: #fff; padding: 10px; cursor: pointer; font-size: 20px;
        }
        .game-option:hover { background: #fff; color: #0000aa; }

        video, iframe { width: 100%; height: 100%; border: none; display: none; }
        .active { display: block !important; }

        /* Side Panel */
        .side-panel {
            width: 240px; background: #4a2e15; border-radius: 15px;
            padding: 15px; display: flex; flex-direction: column;
            border-left: 4px solid #3d2610;
        }

        .channel-guide {
            background: #000; height: 260px; overflow-y: scroll;
            border: 3px solid #222; margin-bottom: 10px; padding: 5px;
            font-size: 11px; color: #0f0;
        }
        .channel-guide div { padding: 6px; cursor: pointer; border-bottom: 1px solid #111; }
        .channel-guide .selected { background: #004400; color: #fff; }

        .load-more {
            background: #333; color: #f0ad4e; border: 1px solid #f0ad4e;
            font-size: 10px; padding: 5px; cursor: pointer; margin-bottom: 10px;
        }

        .retro-button {
            width: 50px; height: 50px; background: #333; border: 3px solid #111;
            border-bottom: 6px solid #000; border-radius: 8px; color: #fff;
            cursor: pointer; margin: 0 5px;
        }

        .mode-switch { background: #222; padding: 10px; border-radius: 5px; display: flex; justify-content: space-around; }
        .mode-switch input:checked + span { color: #f0ad4e; font-weight: bold; }
    </style>
</head>
<tvbody>

<div class="tv-cabinet">
    <div class="screen-area">
        <div id="static"></div>
        
        <div id="gameMenu">
            <h2 style="color: #f0ad4e;">SELECT SYSTEM</h2>
            <div class="game-option" onclick="loadGame('mario')">SUPER MARIO BROS</div>
            <div class="game-option" onclick="loadGame('contra')">CONTRA</div>
            <div class="game-option" onclick="loadGame('pacman')">PAC-MAN</div>
        </div>

        <video id="tvVideo" class="active"></video>
        <iframe id="gameFrame" src=""></iframe>
    </div>

    <div class="side-panel">
        <div style="text-align:center; font-size:12px; margin-bottom:5px; color:#f0ad4e;">LIVE CHANNELS</div>
        <div class="channel-guide" id="guide"><div>Scanning...</div></div>
        
        <button class="load-more" onclick="renderChannels()">LOAD NEXT 100 ↻</button>

        <div style="display:flex; justify-content:center; margin-bottom:15px;">
            <button class="retro-button" onclick="changeChannel(-1)">CH-</button>
            <button class="retro-button" onclick="changeChannel(1)">CH+</button>
        </div>

        <div class="mode-switch">
            <label><input type="radio" name="mode" value="tv" checked onchange="switchMode('tv')"><span>TV</span></label>
            <label><input type="radio" name="mode" value="game" onchange="switchMode('game')"><span>GAME</span></label>
        </div>
    </div>
</div>

<script>
    let allData = [];
    let channels = [];
    let displayedCount = 0;
    let currentIndex = 0;
    const video = document.getElementById('tvVideo');
    const iframe = document.getElementById('gameFrame');
    const gameMenu = document.getElementById('gameMenu');
    const guide = document.getElementById('guide');
    const staticOverlay = document.getElementById('static');
    const hls = new Hls();

    // 1. Fetch Master List (VLC Style)
    async function fetchMasterList() {
        try {
            const res = await fetch('https://iptv-org.github.io/iptv/index.m3u');
            const text = await res.text();
            allData = text.split('\n');
            renderChannels();
        } catch (e) { guide.innerText = "CORS Blocked. Use proxy."; }
    }

    // 2. Load Next 100
    function renderChannels() {
        let found = 0;
        if (displayedCount === 0) guide.innerHTML = '';
        
        for (let i = displayedCount; i < allData.length && found < 100; i++) {
            if (allData[i].startsWith('#EXTINF')) {
                const name = allData[i].split(',')[1]?.trim() || "Unknown Channel";
                const url = allData[i+1]?.trim();
                if(url && url.startsWith('http')) {
                    const channelObj = { name, url };
                    channels.push(channelObj);
                    
                    const el = document.createElement('div');
                    const cIdx = channels.length - 1;
                    el.innerText = `${cIdx + 1}. ${name}`;
                    el.onclick = () => playChannel(cIdx);
                    guide.appendChild(el);
                    found++;
                }
            }
            displayedCount = i;
        }
    }

    // 3. Channel Control
    function playChannel(index) {
        if (index < 0 || index >= channels.length) return;
        currentIndex = index;
        staticOverlay.style.display = 'block';
        
        Array.from(guide.children).forEach((el, i) => {
            el.className = i === index ? 'selected' : '';
            if(i === index) el.scrollIntoView({ block: 'nearest' });
        });

        if (Hls.isSupported()) {
            hls.loadSource(channels[index].url);
            hls.attachMedia(video);
            video.play().then(() => staticOverlay.style.display = 'none')
                       .catch(() => staticOverlay.style.display = 'block');
        }
    }

    function changeChannel(dir) { playChannel(currentIndex + dir); }

    // 4. Mode & Game Logic
    function switchMode(mode) {
        staticOverlay.style.display = 'block';
        if (mode === 'tv') {
            gameMenu.style.display = 'none';
            iframe.style.display = 'none';
            video.style.display = 'block';
            playChannel(currentIndex);
        } else {
            video.pause();
            video.style.display = 'none';
            gameMenu.style.display = 'flex'; // Show Game Selection on TV
            iframe.style.display = 'none';
        }
    }

    function loadGame(game) {
        const urls = {
            mario: "https://console-classics.com/retro-games/mario-bros/?embed=1",
            contra: "https://console-classics.com/retro-games/contra/?embed=1",
            pacman: "https://console-classics.com/retro-games/pacman/?embed=1"
        };
        gameMenu.style.display = 'none';
        iframe.style.display = 'block';
        iframe.src = urls[game];
        staticOverlay.style.display = 'none';
    }

    fetchMasterList();
</script>
</tvbody>
</html>