<!DOCTYPE html>
<html>

<head>
    <title>Laravel AI Bot</title>

    <style>
        body {
            font-family: Arial;
            width: 600px;
            margin: 50px auto;

            transition: background-color 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        textarea {
            width: 100%;
            height: 120px;
            padding: 10px;
        }

        button {
            padding: 10px 20px;
            margin-top: 10px;
            cursor: pointer;
        }

        #response {
            margin-top: 20px;
            padding: 15px;
            background: #f4f4f4;
            border-radius: 5px;
            white-space: pre-wrap;
        }
    </style>
</head>

<body>

    <h2>Laravel Ollama Bot</h2>

    <textarea id="message" placeholder="Ask something..."></textarea>

    <br>

    <button onclick="sendMessage()">Send</button>

    <div id="response"></div>
    <script>
        const textarea = document.getElementById('message');
        const responseBox = document.getElementById('response');

        textarea.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                sendMessage();
            }
        });
        async function sendMessage() {
            const message = textarea.value.trim();
            if (!message) return;

            // Reset UI for the new interaction
            responseBox.innerHTML = 'Thinking...';
            textarea.value = '';
            // STEP 1: Get emotion
            const emotion = await getEmotion(message);
            console.log('Emotion:', emotion);

            // STEP 2: Change background based on emotion
            // We don't 'await' this so the text can start generating 
            // while the color is still fading in (Parallel Action)
            changeBackground(emotion);
            try {


                // STEP 3: Get bot response via STREAM
                responseBox.innerHTML = ''; // Clear 'Thinking...' to start typing

                const response = await fetch("{{ url('/chat') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({ message: message })
                });

                // The Magic: Stream Reader
                const reader = response.body.getReader();
                const decoder = new TextDecoder();

                while (true) {
                    const { value, done } = await reader.read();
                    if (done) break;

                    // Decode the chunk and append it immediately
                    const chunk = decoder.decode(value, { stream: true });
                    responseBox.innerHTML += chunk;

                    // Keep scrolling to the bottom as text grows
                    window.scrollTo(0, document.body.scrollHeight);
                }

            } catch (error) {
                console.error(error);
                responseBox.innerHTML = 'Something went wrong!';
            }
        }
        // async function sendMessage() {
        //     const message = textarea.value.trim();
        //     if (!message) return;

        //     responseBox.innerHTML = 'Thinking...';

        //     try {
        //         // STEP 1: Get emotion
        //         const emotion = await getEmotion(message);
        //         console.log('Emotion:', emotion);

        //         // STEP 2: Change background based on emotion
        //         await changeBackground(emotion);

        //         // STEP 3: Get bot response
        //         const botReply = await getBotResponse(message);

        //         responseBox.innerHTML = botReply;

        //     } catch (error) {
        //         console.error(error);
        //         responseBox.innerHTML = 'Something went wrong!';
        //     }

        //     textarea.value = '';
        // }

        async function getEmotion(message) {
            const url = `{{ url('/emotionofthis') }}/${encodeURIComponent(message)}`;
            const res = await fetch(url);
            return (await res.text()).toLowerCase().trim();
        }

        async function getBotResponse(message) {
            const url = `{{ url('/bot') }}/${encodeURIComponent(message)}`;
            const res = await fetch(url);
            return await res.text();
        }

        async function changeBackground(emotion) {
            try {
                const url = `{{ url('/colorofthisemotion') }}/${encodeURIComponent(emotion)}`;
                const res = await fetch(url);
                const color = (await res.text()).trim();

                if (!color.startsWith('#')) {
                    document.body.style.backgroundColor = '#ffffff';
                    return;
                }

                const start = getComputedStyle(document.body).backgroundColor;
                const end = hexToRgb(color);

                const startRgb = parseRgb(start);
                const duration = 600;
                const t0 = performance.now();

                function animate(now) {
                    const p = Math.min((now - t0) / duration, 1);

                    const r = Math.round(startRgb.r + (end.r - startRgb.r) * p);
                    const g = Math.round(startRgb.g + (end.g - startRgb.g) * p);
                    const b = Math.round(startRgb.b + (end.b - startRgb.b) * p);

                    document.body.style.backgroundColor = `rgb(${r}, ${g}, ${b})`;

                    if (p < 1) requestAnimationFrame(animate);
                }

                requestAnimationFrame(animate);

            } catch (error) {
                console.error("Color fetch failed:", error);
                document.body.style.backgroundColor = '#ffffff';
            }
        }

        /* helpers */
        function hexToRgb(hex) {
            hex = hex.replace('#', '');
            return {
                r: parseInt(hex.substring(0, 2), 16),
                g: parseInt(hex.substring(2, 4), 16),
                b: parseInt(hex.substring(4, 6), 16)
            };
        }

        function parseRgb(rgb) {
            const nums = rgb.match(/\d+/g);
            return {
                r: parseInt(nums[0]),
                g: parseInt(nums[1]),
                b: parseInt(nums[2])
            };
        }
    </script>
</body>

</html>