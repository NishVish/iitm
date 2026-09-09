<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Ollama AI Chat</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            margin: 0;
            padding: 40px;
        }

        .chat-container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        #messages {
            height: 500px;
            overflow-y: auto;
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 8px;
        }

        .message {
            padding: 12px;
            margin-bottom: 10px;
            border-radius: 8px;
        }

        .user {
            background: #e3f2fd;
            text-align: right;
        }

        .ai {
            background: #f1f1f1;
        }

        form {
            display: flex;
            gap: 10px;
        }

        input {
            flex: 1;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
        }

        button {
            padding: 12px 20px;
            background: #000;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        button:disabled {
            background: #888;
        }
    </style>
</head>

<body>

    <div class="chat-container">

        <h2>Qwen 2.5 AI</h2>

        <div id="messages"></div>

        <form id="chatForm">

            <input type="text" id="message" placeholder="Ask something..." autocomplete="off" required>

            <button type="submit" id="sendButton">
                Send
            </button>

        </form>

    </div>

    <script>

        const form = document.getElementById('chatForm');
        const input = document.getElementById('message');
        const messages = document.getElementById('messages');
        const sendButton = document.getElementById('sendButton');

        form.addEventListener('submit', async function (e) {

            e.preventDefault();

            const message = input.value.trim();

            if (!message) {
                return;
            }

            // Show user message
            messages.innerHTML += `
        <div class="message user">
            ${escapeHtml(message)}
        </div>
    `;

            input.value = '';

            sendButton.disabled = true;
            sendButton.innerText = 'Thinking...';

            try {

                const response = await fetch(
                    "{{ route('ai.respond') }}",
                    {
                        method: 'POST',

                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document
                                .querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },

                        body: JSON.stringify({
                            message: message
                        })
                    }
                );

                const data = await response.json();

                if (data.success) {

                    messages.innerHTML += `
                <div class="message ai">
                    ${escapeHtml(data.response)}
                </div>
            `;

                } else {

                    messages.innerHTML += `
                <div class="message ai">
                    Error: ${escapeHtml(data.message)}
                </div>
            `;
                }

            } catch (error) {

                messages.innerHTML += `
            <div class="message ai">
                Failed to connect to Laravel/Ollama.
            </div>
        `;

                console.error(error);
            }

            messages.scrollTop = messages.scrollHeight;

            sendButton.disabled = false;
            sendButton.innerText = 'Send';

        });

        function escapeHtml(text) {

            const div = document.createElement('div');

            div.textContent = text;

            return div.innerHTML;
        }

    </script>

</body>

</html>