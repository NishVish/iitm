<!-- FLOATING BUTTON -->
<div id="chatbot-button-wrapper" onmouseenter="showTip()" onmouseleave="hideTip()">
    <div id="chatbot-button" onclick="toggleChat()">🦉</div>
    <div id="chatbot-tip">Need help? Chat with us 👋</div>
</div>

<!-- CHATBOX -->
<div id="chatbox">
    <div id="chat-header">
        Help Service
        <span onclick="toggleChat()" style="float:right; cursor:pointer;">✖</span>
    </div>

    <div id="chat-body" style="color:black;">
        <p>Hi this is Usha from iitm 👋</p>
        <p>Contacts</p>
        <p>Email : info@iitmindia.com</p>
        <p>Call : +91 9742942009</p>
    </div>

    <div id="chat-footer">
        <input type="text" id="chat-input" placeholder="Type a message..." />
        <button onclick="sendMessage()">Send</button>
    </div>
</div>

<style>
    /* FLOAT BUTTON WRAPPER */
    #chatbot-button-wrapper {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 9999;
    }

    /* BUTTON */
    #chatbot-button {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #aa2324, #ff4d4d);
        color: #fff;
        font-size: 26px;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 50%;
        cursor: pointer;
        box-shadow: 0 0 15px rgba(170, 35, 36, 0.6);
        animation: pulse 1.8s infinite;
        transition: transform 0.2s ease;
    }

    #chatbot-button:hover {
        transform: scale(1.1);
    }

    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(170, 35, 36, 0.6);
        }

        70% {
            box-shadow: 0 0 0 15px rgba(170, 35, 36, 0);
        }

        100% {
            box-shadow: 0 0 0 0 rgba(170, 35, 36, 0);
        }
    }

    /* TOOLTIP */
    #chatbot-tip {
        position: absolute;
        right: 70px;
        bottom: 15px;
        background: #222;
        color: #fff;
        padding: 8px 12px;
        font-size: 13px;
        border-radius: 6px;
        white-space: nowrap;
        opacity: 0;
        transform: translateX(10px);
        transition: 0.3s ease;
        pointer-events: none;
    }

    #chatbot-tip.show {
        opacity: 1;
        transform: translateX(0);
    }

    /* CHATBOX */
    #chatbox {
        position: fixed;
        bottom: 80px;
        right: 20px;
        width: 300px;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
        display: none;
        overflow: hidden;
        z-index: 9999;
    }

    #chat-header {
        background: #aa2324;
        color: #fff;
        padding: 10px;
        font-weight: bold;
    }

    #chat-body {
        height: 40vh;
        overflow-y: auto;
        padding: 10px;
        font-size: 14px;
    }

    #chat-footer {
        display: flex;
        border-top: 1px solid #eee;
    }

    #chat-footer input {
        flex: 1;
        border: none;
        padding: 10px;
        outline: none;
    }

    #chat-footer button {
        background: #aa2324;
        color: #fff;
        border: none;
        padding: 10px;
        cursor: pointer;
    }
</style>
<script>

    let idleTimer;

    function toggleChat() {

        let box = document.getElementById("chatbox");

        box.style.display =
            (box.style.display === "none" || box.style.display === "")
                ? "block"
                : "none";
    }

    function showTip() {
        document
            .getElementById("chatbot-tip")
            .classList
            .add("show");
    }

    function hideTip() {
        document
            .getElementById("chatbot-tip")
            .classList
            .remove("show");
    }

    function resetIdleTimer() {

        clearTimeout(idleTimer);

        idleTimer = setTimeout(() => {

            let tip =
                document.getElementById("chatbot-tip");

            tip.innerText =
                "👋 Need help? I'm here!";

            tip.classList.add("show");

            setTimeout(() => {
                tip.classList.remove("show");
            }, 4000);

        }, 8000);
    }

    window.addEventListener("mousemove", resetIdleTimer);
    window.addEventListener("keydown", resetIdleTimer);

    resetIdleTimer();

    /*
    |--------------------------------------------------------------------------
    | SEND MESSAGE
    |--------------------------------------------------------------------------
    */

    async function sendMessage() {

        let input =
            document.getElementById("chat-input");

        let message =
            input.value.trim();

        if (!message) return;

        let body =
            document.getElementById("chat-body");

        /*
        |--------------------------------------------------------------------------
        | USER MESSAGE
        |--------------------------------------------------------------------------
        */

        body.innerHTML += `
            <p>
                <b>You:</b> ${message}
            </p>
        `;

        input.value = "";

        /*
        |--------------------------------------------------------------------------
        | BOT PLACEHOLDER
        |--------------------------------------------------------------------------
        */

        let botMsg = document.createElement("p");

        botMsg.innerHTML =
            "<b>Bot:</b> <i>Thinking...</i>";

        body.appendChild(botMsg);

        body.scrollTop = body.scrollHeight;

        /*
        |--------------------------------------------------------------------------
        | STOPWATCH
        |--------------------------------------------------------------------------
        */

        let startTime = Date.now();

        try {

            /*
            |--------------------------------------------------------------------------
            | CALL RAG API
            |--------------------------------------------------------------------------
            */

            let response = await fetch(
                "{{ url('api/ai/rag/ask') }}",
                {
                    method: "POST",

                    headers: {
                        "Content-Type": "application/json",

                        "Accept": "application/json",

                        "X-CSRF-TOKEN":
                            "{{ csrf_token() }}"
                    },

                    body: JSON.stringify({
                        question: message
                    })
                }
            );

            let data = await response.json();

            /*
            |--------------------------------------------------------------------------
            | RESPONSE TIME
            |--------------------------------------------------------------------------
            */

            let seconds =
                ((Date.now() - startTime) / 1000)
                    .toFixed(2);

            /*
            |--------------------------------------------------------------------------
            | SHOW ANSWER
            |--------------------------------------------------------------------------
            */

            if (data.status) {

                botMsg.innerHTML = `
                    <b>Bot:</b>
                    ${data.answer}

                    <br><br>

                    <small style="color:gray;">
                        ⏱ ${seconds}s
                    </small>
                `;
            }
            else {

                botMsg.innerHTML = `
                    <b>Bot:</b>
                    ${data.message || 'No answer found'}
                `;
            }

        } catch (err) {

            console.log(err);

            botMsg.innerHTML =
                "<b>Bot:</b> Server Error";

        }

        body.scrollTop = body.scrollHeight;
    }

    /*
    |--------------------------------------------------------------------------
    | ENTER KEY SUPPORT
    |--------------------------------------------------------------------------
    */

    document
        .getElementById("chat-input")
        .addEventListener("keydown", function (event) {

            if (event.key === "Enter") {

                event.preventDefault();

                sendMessage();
            }
        });

</script>
<script>

    document.getElementById("chat-input").addEventListener("keydown", function (event) {
        if (event.key === "Enter") {
            event.preventDefault();
            sendMessage();
        }
    });
</script>