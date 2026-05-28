<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>IITM FAQ + RAG Generator</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f7fb;
            padding: 30px;
            max-width: 1200px;
            margin: auto;
        }

        h1 {
            color: #1a237e;
        }

        .toolbar {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }

        button {
            background: #1a237e;
            color: white;
            border: none;
            padding: 10px 18px;
            border-radius: 8px;
            cursor: pointer;
        }

        button:hover {
            background: #3949ab;
        }

        .faq-card {
            background: white;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .question {
            font-weight: bold;
            margin-bottom: 12px;
            font-size: 18px;
        }

        textarea {
            width: 100%;
            min-height: 120px;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #ccc;
            resize: vertical;
            font-size: 14px;
        }

        .meta {
            margin-top: 15px;
            font-size: 13px;
            color: #555;
            background: #f8f8f8;
            padding: 10px;
            border-radius: 8px;
        }

        .loading {
            color: #1976d2;
            font-weight: bold;
            margin-top: 10px;
        }

        .success {
            color: green;
            margin-top: 10px;
        }

        .error {
            color: red;
            margin-top: 10px;
        }

        .matched-files {
            margin-top: 10px;
        }

        .badge {
            display: inline-block;
            background: #e8eaf6;
            color: #1a237e;
            padding: 5px 10px;
            border-radius: 20px;
            margin-right: 8px;
            margin-top: 5px;
            font-size: 12px;
        }
    </style>
</head>

<body>

    <h1>IITM FAQ + RAG Answer Generator</h1>

    <div class="toolbar">
        <button onclick="generateAllAnswers()">
            Generate All Answers
        </button>

        <button onclick="saveAnswersJSON()">
            Save JSON
        </button>
    </div>

    <div id="faqContainer"></div>

    <script>

        const RAG_API = '{{ url("/ai/rag/ask") }}';
        console.log(RAG_API);
        // example:
        // const RAG_API = "http://127.0.0.1:8000/api/rag-search";

        const questions = [
            "What is IITM India?",
            "What does IITM stand for?",
            "Where are IITM events conducted?",
            "What are the upcoming IITM event dates?",
            "How can visitors register for IITM?",
            "Is visitor registration free?",
            "Who can attend IITM exhibitions?",
            "Can students attend IITM events?",
            "What documents are required for entry?",
            "Are children allowed at the event?",
            "How can companies exhibit at IITM?",
            "What are the exhibitor charges?",
            "What booth sizes are available?",
            "How do I book a stall?",
            "Can international exhibitors participate?",
            "What industries can participate?",
            "What marketing support is provided?",
            "Are networking opportunities available?",
            "Can startups participate?",
            "Can travel tech companies exhibit?",
            "Are tourism boards allowed to participate?",
            "How many visitors attend IITM?",
            "What are the event timings?",
            "Is parking available?",
            "Are hotels available near the venue?",
            "Is the venue wheelchair accessible?",
            "Are food courts available?",
            "Is Wi-Fi available?",
            "How can media professionals register?",
            "Can influencers attend IITM?",
            "Are sponsorship opportunities available?",
            "How can brands collaborate with IITM?",
            "Where can I download the brochure?",
            "How do I contact IITM support?",
            "How can I become a partner?",
            "Can I edit my registration details?",
            "Do exhibitors need separate registration?",
            "Is there a QR code entry system?",
            "Can I attend multiple days?",
            "How can I receive event updates?"
        ];

        let faqData = [];

        function renderQuestions() {

            const container = document.getElementById("faqContainer");

            questions.forEach((question, index) => {

                faqData.push({
                    question,
                    answer: "",
                    matched_files: [],
                    top_matches: []
                });

                const div = document.createElement("div");

                div.className = "faq-card";

                div.innerHTML = `
      <div class="question">
        ${index + 1}. ${question}
      </div>

      <button onclick="generateAnswer(${index})">
        Generate Answer
      </button>

      <div id="status-${index}" class="loading"></div>

      <textarea id="answer-${index}" placeholder="Generated answer will appear here..."></textarea>

      <div class="meta">
        <strong>Matched Files:</strong>
        <div id="files-${index}" class="matched-files"></div>

        <br>

        <strong>Top Matches:</strong>
        <pre id="matches-${index}"></pre>
      </div>
    `;

                container.appendChild(div);

            });

        }

        async function generateAnswer(index) {

            const question = questions[index];

            const status = document.getElementById(`status-${index}`);

            status.innerHTML = "Generating answer from RAG...";

            try {

                const response = await fetch(
                    "http://localhost/iitm/lara/ai/rag/ask",
                    {
                        method: "POST",

                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json",

                            "X-CSRF-TOKEN":
                                document
                                    .querySelector('meta[name="csrf-token"]')
                                    .getAttribute("content")
                        },

                        body: JSON.stringify({
                            question: question
                        })
                    }
                );

                const text = await response.text();

                console.log(text);

                const data = JSON.parse(text);
                console.log(data);

                if (data.status) {

                    faqData[index] = data;

                    document.getElementById(`answer-${index}`).value = data.answer || "";

                    const filesContainer = document.getElementById(`files-${index}`);

                    filesContainer.innerHTML = "";

                    if (data.matched_files) {

                        data.matched_files.forEach(file => {

                            filesContainer.innerHTML += `
            <span class="badge">${file}</span>
          `;

                        });

                    }

                    document.getElementById(`matches-${index}`).innerText =
                        JSON.stringify(data.top_matches, null, 2);

                    status.innerHTML = "Answer generated successfully.";
                    status.className = "success";

                } else {

                    status.innerHTML = "Failed to generate answer.";
                    status.className = "error";

                }

            } catch (err) {

                console.error(err);

                status.innerHTML = "API Error";
                status.className = "error";

            }

        }

        async function generateAllAnswers() {

            for (let i = 0; i < questions.length; i++) {

                await generateAnswer(i);

            }

        }

        function saveAnswersJSON() {

            faqData.forEach((item, index) => {

                item.answer = document.getElementById(`answer-${index}`).value;

            });

            const blob = new Blob(
                [JSON.stringify(faqData, null, 2)],
                { type: "application/json" }
            );

            const url = URL.createObjectURL(blob);

            const a = document.createElement("a");

            a.href = url;
            a.download = "iitm-faq-rag.json";

            a.click();

            URL.revokeObjectURL(url);

        }

        renderQuestions();

    </script>

</body>

</html>