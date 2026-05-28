<!DOCTYPE html>
<html>

<head>
    <title>RAG Dashboard</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>

    <h2>RAG Question</h2>

    <form id="ragForm">
        <input type="text" id="question" placeholder="Ask something..." style="width:300px;">
        <button type="submit">Ask</button>
    </form>

    <hr>

    <h2>RAG Answer</h2>
    <div id="answerBox">No answer yet</div>

    <script>
        document.getElementById("ragForm").addEventListener("submit", async function (e) {
            e.preventDefault();

            let question = document.getElementById("question").value;

            // 1. Send question to Laravel → Python RAG
            let res = await fetch("rag/question", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    question: question
                })
            });

            let data = await res.json();

            if (data.status !== "success") {
                document.getElementById("answerBox").innerHTML =
                    "Error: " + data.message;
                return;
            }

            // 2. Fetch formatted answer from Laravel
            let answerRes = await fetch("rag/answer");
            let answerData = await answerRes.json();

            if (answerData.status === "success") {
                document.getElementById("answerBox").innerHTML =
                    "<b>" + answerData.answer + "</b>";
            } else {
                document.getElementById("answerBox").innerHTML =
                    "No answer found";
            }
        });
    </script>

</body>

</html>