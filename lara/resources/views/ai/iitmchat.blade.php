<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IITM Travel AI</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            /* Fast GPU transition for background colors */
            transition: background-color 0.8s cubic-bezier(0.4, 0, 0.2, 1);
            background-color: #f0f2f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .main-stage {
            width: 100%;
            height: 100vh;
            background: linear-gradient(rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.1)),
                url('https://iitmindia.com/assets/creatives/1.jpg') no-repeat center center;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .chat-card {
            width: 450px;
            height: 600px;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .header {
            background: #004a99;
            padding: 15px;
            text-align: center;
        }

        .header img {
            height: 40px;
        }

        #response {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .bubble {
            max-width: 80%;
            padding: 12px 16px;
            border-radius: 15px;
            font-size: 14px;
            line-height: 1.4;
            word-wrap: break-word;
        }

        .user {
            align-self: flex-end;
            background: #004a99;
            color: white;
            border-bottom-right-radius: 2px;
        }

        .ai {
            align-self: flex-start;
            background: #fff;
            color: #333;
            border-bottom-left-radius: 2px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            white-space: pre-wrap;
        }

        .footer {
            padding: 20px;
            display: flex;
            gap: 10px;
            background: rgba(255, 255, 255, 0.5);
        }

        #message {
            flex: 1;
            padding: 10px 15px;
            border-radius: 25px;
            border: 1px solid #ccc;
            outline: none;
        }

        .send-btn {
            background: #ed1c24;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 25px;
            cursor: pointer;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class="main-stage">
        <a href="{{ url('/api/ai/rag/train') }}">Train</a>
        <div class="chat-card">
            <div class="header">
                <img src="https://iitmindia.com/assets/iitm3.png" alt="IITM Logo">
            </div>

            <div id="response">
                <div class="bubble ai">Welcome to IITM AI. Type your travel mood!</div>
            </div>

            <form id="chatForm" class="footer">
                <input type="text" id="message" placeholder="How do you feel about traveling?" autocomplete="off">
                <button type="submit" class="send-btn">SEND</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('chatForm');
            const input = document.getElementById('message');
            const responseBox = document.getElementById('response');

            /**
             * VISUAL LOGIC: Runs in background
             */
            async function handleVisuals(text) {
                try {
                    // 1. Get Emotion
                    const emoRes = await fetch(`{{ url('/emotionofthis') }}/${encodeURIComponent(text)}`);
                    const emotion = (await emoRes.text()).toLowerCase().trim();

                    // 2. Get Color
                    const colorRes = await fetch(`{{ url('/colorofthisemotion') }}/${encodeURIComponent(emotion)}`);
                    const hexCode = (await colorRes.text()).trim();

                    if (hexCode.startsWith('#')) {
                        document.body.style.backgroundColor = hexCode;
                    }
                } catch (err) {
                    console.log("Visuals error:", err);
                }
            }

            const appendMsg = (text, type) => {
                const div = document.createElement('div');
                div.className = `bubble ${type}`;
                div.innerText = text;
                responseBox.appendChild(div);
                responseBox.scrollTop = responseBox.scrollHeight;
                return div;
            };

            form.addEventListener('submit', async (e) => {
                e.preventDefault();
                const msg = input.value.trim();
                if (!msg) return;

                appendMsg(msg, 'user');
                input.value = "";

                // FIRE VISUALS IMMEDIATELY (Do not await)
                handleVisuals(msg);

                // Give visuals a 50ms head start to beat the single-threaded PHP queue
                await new Promise(r => setTimeout(r, 50));

                // CREATE AI BUBBLE FOR STREAMING
                const aiBubble = appendMsg("...", 'ai');
                aiBubble.innerText = "";

                try {
                    const response = await fetch('{{ url("api/ai/rag/ask") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ question: msg })
                    });

                    const data = await response.json();
                    console.log(data);
                    aiBubble.innerText = data.answer;

                } catch (err) {
                    try {
                        const response = await fetch('{{ url("api/ai/rag/ask") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ question: "Give Brief Info About the Company" })
                        });

                        const data = await response.json();
                        console.log(data);
                        aiBubble.innerText = data.answer;

                    } catch (err) {
                        aiBubble.innerText = "Please Provide more info";
                    }
                }
            });
        });
    </script>
</body>

</html>