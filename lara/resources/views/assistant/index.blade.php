<!DOCTYPE html>
<html>

<head>
    <title>Assistant</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            max-width: 900px;
            margin: auto;
        }

        textarea {
            width: 100%;
            height: 120px;
            padding: 10px;
        }

        button {
            padding: 10px 15px;
            margin: 5px;
            cursor: pointer;
        }

        #response {
            margin-top: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            min-height: 150px;
            white-space: pre-wrap;
        }

        .section {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

    <h2>Assistant</h2>

    <div class="section">
        <a href="{{ url('trainassistant/web') }}">
            Train Web
        </a>
        <br>

        <a href="{{ url('trainassistant/workspace') }}">
            Train Workspace
        </a>
    </div>

    <div class="section">
        <strong>Mode</strong>
        <br>

        <label>
            <input type="radio" name="mode" value="web" checked>
            Web
        </label>


    </div>

    <div class="section">
        <textarea id="question" placeholder="Ask a question..."></textarea>

        <br>

        <button onclick="askAssistant()">
            Ask
        </button>
    </div>

    <div id="response">
        Response will appear here...
    </div>

    <script>

        function selectedMode() {
            return document.querySelector(
                'input[name="mode"]:checked'
            ).value;
        }



        async function askAssistant() {
            const question =
                document.getElementById('question').value;

            const mode =
                selectedMode();

            document.getElementById('response').innerHTML =
                'Thinking...';

            const askUrl = "{{ url('assistant/ask') }}";

            const response = await fetch(
                askUrl + '/' + "web",
                {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN':
                            document.querySelector(
                                'meta[name="csrf-token"]'
                            ).content
                    },
                    body: JSON.stringify({
                        question: question
                    })
                }
            );

            const data = await response.json();

            document.getElementById('response').innerHTML =
                data.answer
                ?? JSON.stringify(data, null, 2);
        }

    </script>

</body>

</html>