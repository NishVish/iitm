
if (!document.getElementById('cmd-sidebar')) {

    const box = document.createElement('div');

    box.id = 'cmd-sidebar';

    box.innerHTML = `
        <style>
            #cmd-sidebar{
                position:fixed;
                right:0;
                top:0;
                width:320px;
                height:100vh;
                background:#111;
                color:#00ff88;
                z-index:999999;
                font-family:monospace;
                display:flex;
                flex-direction:column;
            }

            #cmd-input{
                padding:10px;
                background:#222;
                border:none;
                color:#00ff88;
                outline:none;
            }

            #cmd-run{
                padding:10px;
                border:none;
                background:#00ff88;
                cursor:pointer;
            }

            #cmd-output{
                flex:1;
                overflow:auto;
                padding:10px;
                white-space:pre-wrap;
            }
        </style>

        <input id="cmd-input" placeholder="Enter command">
        <button id="cmd-run">Run</button>
        <pre id="cmd-output"></pre>
    `;

    document.body.appendChild(box);

    const output = document.getElementById('cmd-output');

    async function runCmd() {

        const cmd = document.getElementById('cmd-input').value;

        output.textContent += `\n> ${cmd}\n`;

        chrome.runtime.sendMessage({
            type: 'RUN_CMD',
            cmd
        }, (response) => {

            if (chrome.runtime.lastError) {
                output.textContent +=
                    chrome.runtime.lastError.message + '\\n';
                return;
            }

            if (response?.error) {
                output.textContent += response.error + '\\n';
                return;
            }

            output.textContent +=
                (response.output || 'No output') + '\\n';

            output.scrollTop = output.scrollHeight;
        });
    }

    document
        .getElementById('cmd-run')
        .addEventListener('click', runCmd);

    document
        .getElementById('cmd-input')
        .addEventListener('keydown', e => {
            if (e.key === 'Enter') runCmd();
        });
}
