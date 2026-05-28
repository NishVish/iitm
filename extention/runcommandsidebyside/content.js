if (!document.getElementById('cmd-chat-launcher')) {

    let ollamaMode = false;
    let currentModel = 'llama3'; // Default model fallback

    const launcher = document.createElement('div');
    launcher.id = 'cmd-chat-launcher';
    launcher.innerHTML = '💻';

    const popup = document.createElement('div');
    popup.id = 'cmd-popup';

    popup.innerHTML = `
        <style>
            #cmd-chat-launcher{
                position:fixed;
                bottom:20px;
                right:20px;
                width:60px;
                height:60px;
                border-radius:50%;
                background:#111;
                color:#00ff88;
                display:flex;
                align-items:center;
                justify-content:center;
                font-size:28px;
                cursor:pointer;
                z-index:999999;
                box-shadow:0 0 15px rgba(0,0,0,0.5);
                user-select:none;
            }

            #cmd-popup{
                position:fixed;
                bottom:90px;
                right:20px;
                width:420px;
                height:550px;
                background:#111;
                color:#00ff88;
                border-radius:15px;
                overflow:hidden;
                display:none;
                flex-direction:column;
                z-index:999999;
                font-family:monospace;
                box-shadow:0 0 25px rgba(0,0,0,0.6);
                border:1px solid #222;
            }

            #cmd-header{
                padding:12px 15px;
                background:#1a1a1a;
                border-bottom:1px solid #222;
                font-size:14px;
                font-weight:bold;
                display:flex;
                justify-content:space-between;
                align-items:center;
            }

            .mode-toggle-container {
                display:flex;
                background:#111;
                padding:3px;
                border-radius:6px;
                border:1px solid #333;
            }

            .mode-label {
                padding:4px 8px;
                font-size:11px;
                cursor:pointer;
                border-radius:4px;
                color:#888;
                user-select:none;
            }

            .mode-label input {
                display:none;
            }

            .mode-label:has(input:checked) {
                background:#00ff88;
                color:#111;
                font-weight:bold;
            }

            #cmd-output{
                flex:1;
                overflow:auto;
                padding:15px;
                white-space:pre-wrap;
                font-size:13px;
            }

            #cmd-bottom{
                display:flex;
                border-top:1px solid #222;
            }

            #cmd-input{
                flex:1;
                padding:12px;
                background:#1a1a1a;
                border:none;
                outline:none;
                color:#00ff88;
                font-family:monospace;
                font-size:14px;
            }

            #cmd-run{
                width:90px;
                border:none;
                background:#00ff88;
                color:#111;
                cursor:pointer;
                font-weight:bold;
            }

            #cmd-run:hover{
                background:#00cc6a;
            }

            .cmd-ai{
                color:#00d9ff;
            }

            .cmd-user{
                color:#00ff88;
            }
        </style>

        <div id="cmd-header">
            <span>TERMINAL</span>
            <div class="mode-toggle-container">
                <label class="mode-label" id="lbl-cmd">
                    <input type="radio" name="terminal-mode" value="cmd" checked> CMD
                </label>
                <label class="mode-label" id="lbl-llama">
                    <input type="radio" name="terminal-mode" value="llama"> LLAMA
                </label>
            </div>
        </div>

        <pre id="cmd-output"></pre>

        <div id="cmd-bottom">
            <input id="cmd-input" placeholder="Enter command or ollama prompt">
            <button id="cmd-run">Run</button>
        </div>
    `;

    document.body.appendChild(launcher);
    document.body.appendChild(popup);

    // Sync mode choice on click
    const cmdRadio = popup.querySelector('input[value="cmd"]');
    const llamaRadio = popup.querySelector('input[value="llama"]');

    cmdRadio.addEventListener('change', () => {
        ollamaMode = false;
        append('Switched to system CMD mode.', 'cmd-ai');
    });

    llamaRadio.addEventListener('change', () => {
        ollamaMode = true;
        append(`Switched to Ollama mode using model: ${currentModel}`, 'cmd-ai');
    });

    launcher.addEventListener('click', () => {
        if (popup.style.display === 'flex') {
            popup.style.display = 'none';
        } else {
            popup.style.display = 'flex';
            document.getElementById('cmd-input').focus();
        }
    });

    const output = document.getElementById('cmd-output');

    function append(text, cls = '') {
        const div = document.createElement('div');
        div.className = cls;
        div.textContent = text;
        output.appendChild(div);
        output.scrollTop = output.scrollHeight;
    }

    async function handleOllamaChat(prompt) {
        append('Ollama thinking...', 'cmd-ai');
        try {
            const response = await fetch('http://localhost:11434/api/generate', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    model: currentModel,
                    prompt: prompt,
                    stream: false
                })
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();
            append(data.response || 'No response from model.', 'cmd-ai');
        } catch (error) {
            append(`Ollama Error: ${error.message}`, 'cmd-ai');
        }
    }

    function runCmd() {
        const inputEl = document.getElementById('cmd-input');
        const cmd = inputEl.value.trim();

        if (!cmd) return;

        inputEl.value = '';
        inputEl.focus();

        append(`> ${cmd}`, 'cmd-user');

        // =========================
        // OLLAMA MODE LOGIC
        // =========================

        // Exit keyword condition -> Sync UI Radio
        if (ollamaMode && cmd.toLowerCase() === 'exit ollama') {
            ollamaMode = false;
            cmdRadio.checked = true;
            append('Exited Ollama session. Returning to normal CMD.', 'cmd-ai');
            return;
        }

        // Trigger keyword condition -> Sync UI Radio
        if (!ollamaMode && cmd.startsWith('ollama run ')) {
            const modelMatch = cmd.match(/^ollama run\s+(.+)$/);
            if (modelMatch) {
                currentModel = modelMatch[1];
                ollamaMode = true;
                llamaRadio.checked = true;
                append(`Starting Ollama interactive session with model: ${currentModel}...`, 'cmd-ai');
                append(`Type "exit ollama" or click CMD to return.`, 'cmd-ai');
                return;
            }
        }

        // Active Ollama Chat Routing
        if (ollamaMode) {
            // Context injection from your page DOM content script direct query
            const pageText = document.body.innerText.slice(0, 4000);
            const finalPrompt = `[SYSTEM: The following is the live text content of the webpage the user is actively viewing. Answer using this context configuration directly.]\n\nWEBPAGE CONTENT:\n"""\n${pageText}\n"""\n\nUSER REQUEST: ${cmd}`;

            handleOllamaChat(finalPrompt);
            return;
        }

        // =========================
        // NORMAL SYSTEM CMD
        // =========================

        chrome.runtime.sendMessage({
            type: 'RUN_CMD',
            cmd
        }, (response) => {
            if (chrome.runtime.lastError) {
                append(chrome.runtime.lastError.message, 'cmd-ai');
                return;
            }

            if (response?.error) {
                append(response.error, 'cmd-ai');
                return;
            }

            append(response.output || 'No output', 'cmd-ai');
        });
    }

    document.getElementById('cmd-run').addEventListener('click', runCmd);
    document.getElementById('cmd-input').addEventListener('keydown', e => {
        if (e.key === 'Enter') {
            runCmd();
        }
    });
}