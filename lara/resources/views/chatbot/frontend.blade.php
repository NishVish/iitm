<style>
    /* 1976 INDUSTRIAL DESIGN SYSTEM */
    body {
        margin: 0;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        background: #0a0a0a;
        font-family: "Courier New", monospace;
    }

    .crt-unit {
        width: 680px;
        height: 850px;
        background: linear-gradient(135deg, #d6c7a6 0%, #a89573 100%);
        border-radius: 60px;
        position: relative;
        box-shadow: 0 50px 100px rgba(0, 0, 0, 0.8), inset -5px -5px 15px rgba(0, 0, 0, 0.4), inset 5px 5px 15px rgba(255, 255, 255, 0.3);
        border: 10px solid #5c4c38;
    }

    .vents {
        position: absolute;
        top: 25px;
        right: 80px;
        width: 100px;
        height: 20px;
        background: repeating-linear-gradient(90deg, #5c4c38, #5c4c38 4px, transparent 4px, transparent 8px);
        opacity: 0.5;
    }

    .bevel {
        position: absolute;
        top: 60px;
        left: 50%;
        transform: translateX(-50%);
        width: 560px;
        height: 460px;
        background: #1a1612;
        border-radius: 40px;
        box-shadow: inset 0 20px 40px rgba(0, 0, 0, 1);
        padding: 30px;
        box-sizing: border-box;
    }

    .screen-glass {
        width: 100%;
        height: 100%;
        background: #000;
        border-radius: 25px;
        position: relative;
        overflow: hidden;
        border: 4px solid #080808;
    }

    /* THIS IS YOUR responseBox */
    #response {
        width: 100%;
        height: 100%;
        background: radial-gradient(circle at center, #0a2b0a 0%, #000 100%);
        color: #00ff41;
        padding: 20px;
        box-sizing: border-box;
        overflow-y: auto;
        font-size: 15px;
        text-shadow: 0 0 8px rgba(0, 255, 65, 0.7);
        position: relative;
        z-index: 1;
        white-space: pre-wrap;
        /* Critical for terminal formatting */
        margin: 0;
    }

    .overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(rgba(18, 16, 16, 0) 50%, rgba(0, 0, 0, 0.1) 50%);
        background-size: 100% 3px;
        pointer-events: none;
        z-index: 2;
    }

    .lower-panel {
        position: absolute;
        bottom: 80px;
        left: 50%;
        transform: translateX(-50%);
        width: 520px;
    }

    /* THIS IS YOUR chatForm */
    #chatForm {
        background: #2a241c;
        padding: 15px;
        border-radius: 8px;
        border: 3px solid #3b2f1f;
        box-shadow: inset 0 0 15px #000;
        display: flex;
        gap: 10px;
        margin-top: 20px;
    }

    /* THIS IS YOUR message input */
    #message {
        flex-grow: 1;
        background: #050505;
        border: 1px solid #5c4c38;
        color: #d6c7a6;
        padding: 12px;
        font-family: inherit;
        outline: none;
        border-radius: 4px;
    }

    .btn-transmit {
        background: linear-gradient(#8a6d3a, #5a4424);
        border: 1px solid #000;
        color: #f1e6c8;
        padding: 0 25px;
        border-radius: 4px;
        cursor: pointer;
        text-transform: uppercase;
        font-weight: bold;
        box-shadow: 0 4px 0 #2a241c;
    }

    .btn-transmit:active {
        box-shadow: 0 0 0 #000;
        transform: translateY(4px);
    }

    .led {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #440000;
        border: 2px solid #222;
    }

    .led.active {
        background: #ff0000;
        box-shadow: 0 0 10px #ff0000;
    }
</style>

<div class="crt-unit">
    <div class="vents"></div>

    <div class="bevel">
        <div class="screen-glass">
            <div class="overlay"></div>
            <pre id="response">TERMINAL ONLINE. AWAITING INPUT...
----------------------------------</pre>
        </div>
    </div>

    <div class="lower-panel">
        <div style="display: flex; align-items: center; gap: 15px;">
            <div class="led active"></div>
            <span style="color: #5c4c38; font-size: 11px; font-weight: bold;">POWER</span>
            <div class="led"></div>
            <span style="color: #5c4c38; font-size: 11px; font-weight: bold;">LINK</span>
        </div>

        <form id="chatForm">
            <input type="text" id="message" placeholder="ENTER COMMAND..." autocomplete="off">
            <button type="submit" class="btn-transmit">TRANSMIT</button>
        </form>
    </div>
</div>