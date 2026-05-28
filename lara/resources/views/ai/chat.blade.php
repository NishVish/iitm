<!DOCTYPE html>
<html>

<head>
    <title>AI RAG Chat</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            padding: 40px;
        }

        .chat-box {
            max-width: 900px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.08);
        }

        h1 {
            margin-top: 0;
        }

        .links {
            margin-bottom: 20px;
        }

        .links a {
            display: inline-block;
            margin-right: 15px;
            text-decoration: none;
            color: black;
            font-weight: bold;
        }

        textarea {
            width: 100%;
            height: 140px;
            padding: 12px;
            font-size: 16px;
            border-radius: 8px;
            border: 1px solid #ccc;
            resize: vertical;
            box-sizing: border-box;
        }

        button {
            padding: 12px 20px;
            background: black;
            color: white;
            border: none;
            margin-top: 15px;
            cursor: pointer;
            border-radius: 6px;
            font-size: 16px;
        }

        button:hover {
            opacity: 0.9;
        }

        #timer {
            margin-top: 15px;
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }

        #answer {
            margin-top: 30px;
            padding: 20px;
            background: #f0f0f0;
            border-radius: 10px;
            white-space: pre-wrap;
            line-height: 1.6;
            min-height: 80px;
        }

        .loading {
            color: gray;
        }
    </style>
</head>

<body>

    <div class="chat-box">

        <h1>Laravel RAG AI</h1>

        <div class="links">
            <a href="{{ url('ai/rag/ask') }}">Ask</a>

            <a href="{{ url('ai/rag/updatedata') }}">
                Update Data
            </a>
        </div>

        <textarea id="question" placeholder="Ask anything..."></textarea>

        <button onclick="askAI()">
            Ask AI
        </button>

        <div id="timer">
            ⏱ 0.0s
        </div>

        <div id="answer">
            Your AI response will appear here...
        </div>

    </div>

    <script>

        let timerInterval;

        async function askAI() {

            let question = document
                .getElementById('question')
                .value
                .trim();

            let answerBox =
                document.getElementById('answer');

            let timerBox =
                document.getElementById('timer');

            /*
            |--------------------------------------------------------------------------
            | VALIDATION
            |--------------------------------------------------------------------------
            */

            if (!question) {

                answerBox.innerHTML =
                    'Please enter a question';

                return;
            }

            /*
            |--------------------------------------------------------------------------
            | UI LOADING
            |--------------------------------------------------------------------------
            */

            answerBox.innerHTML =
                '<span class="loading">Thinking...</span>';

            /*
            |--------------------------------------------------------------------------
            | START TIMER
            |--------------------------------------------------------------------------
            */

            let startTime = Date.now();

            timerBox.innerHTML = '⏱ 0.0s';

            clearInterval(timerInterval);

            timerInterval = setInterval(() => {

                let elapsed =
                    ((Date.now() - startTime) / 1000)
                        .toFixed(1);

                timerBox.innerHTML =
                    '⏱ ' + elapsed + 's';

            }, 100);

            try {

                /*
                |--------------------------------------------------------------------------
                | FETCH REQUEST
                |--------------------------------------------------------------------------
                */

                let response = await fetch(
                    '{{ url("/ai/rag/ask") }}',
                    {
                        method: 'POST',

                        headers: {
                            'Content-Type': 'application/json',

                            'Accept': 'application/json',

                            'X-CSRF-TOKEN':
                                '{{ csrf_token() }}'
                        },

                        body: JSON.stringify({
                            question: question
                        })
                    }
                );

                /*
                |--------------------------------------------------------------------------
                | RAW RESPONSE
                |--------------------------------------------------------------------------
                */

                let text = await response.text();

                console.log(text);

                /*
                |--------------------------------------------------------------------------
                | JSON PARSE
                |--------------------------------------------------------------------------
                */

                let data = JSON.parse(text);

                /*
                |--------------------------------------------------------------------------
                | SHOW ANSWER
                |--------------------------------------------------------------------------
                */

                answerBox.innerHTML =
                    data.answer || 'No answer found';

            } catch (e) {

                console.log(e);

                answerBox.innerHTML =
                    'Server Error';

            } finally {

                /*
                |--------------------------------------------------------------------------
                | STOP TIMER
                |--------------------------------------------------------------------------
                */

                clearInterval(timerInterval);

                let finalTime =
                    ((Date.now() - startTime) / 1000)
                        .toFixed(2);

                timerBox.innerHTML =
                    '✅ Response Time: ' +
                    finalTime +
                    ' seconds';
            }
        }

    </script>

</body>

</html>