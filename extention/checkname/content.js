(function () {

    const keywords = [
        "mice",
        "meetings",
        "meeting",
        "incentives",
        "conferences",
        "conference",
        "exhibitions",
        "exhibition",
        "corporate",
        "corporate events",
        "event management",
        "events",
        "wedding",
        "weddings",
        "wedding planner",
        "wedding planning"
    ];

    const pageText = document.body.innerText.toLowerCase();

    const foundKeywords = keywords.filter(k =>
        pageText.includes(k.toLowerCase())
    );

    const found = foundKeywords.length > 0;

    // ---------- TOP BAR ----------
    const bar = document.createElement("div");

    bar.className =
        "keyword-checker-bar " + (found ? "found" : "not-found");

    bar.innerHTML = found
        ? `
            <span>✅ Keywords Found: ${foundKeywords.join(", ")}</span>
            <button id="highlight-keywords-btn">
                Highlight
            </button>
        `
        : `❌ No MICE / Wedding Keywords Found`;

    // ---------- STYLES ----------
    const style = document.createElement("style");

    style.innerHTML = `
        .keyword-checker-bar {
            position: fixed;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
            width: fit-content;
            padding: 12px 20px;
            z-index: 999999;
            text-align: center;
            font-size: 14px;
            font-family: Arial, sans-serif;
            font-weight: bold;
            color: white;
            box-sizing: border-box;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .keyword-checker-bar.found {
            background: #16a34a;
        }

        .keyword-checker-bar.not-found {
            background: #dc2626;
        }

        #highlight-keywords-btn {
            background: white;
            color: #111;
            border: none;
            padding: 6px 12px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 13px;
            font-weight: bold;
        }

        #highlight-keywords-btn:hover {
            background: #f3f4f6;
        }

        .keyword-highlight {
            background: yellow;
            color: black;
            padding: 1px 2px;
            border-radius: 2px;
        }
    `;

    // ---------- HIGHLIGHT FUNCTION ----------
    function highlightKeywords() {

        const walker = document.createTreeWalker(
            document.body,
            NodeFilter.SHOW_TEXT,
            null,
            false
        );

        const textNodes = [];

        while (walker.nextNode()) {
            textNodes.push(walker.currentNode);
        }

        textNodes.forEach(node => {

            const parentTag = node.parentNode.tagName;

            if (
                ["SCRIPT", "STYLE", "NOSCRIPT", "TEXTAREA"].includes(parentTag)
            ) {
                return;
            }

            let text = node.nodeValue;
            let replaced = false;

            keywords.forEach(keyword => {

                const regex = new RegExp(`(${keyword})`, "gi");

                if (regex.test(text)) {
                    replaced = true;

                    text = text.replace(
                        regex,
                        `<span class="keyword-highlight">$1</span>`
                    );
                }
            });

            if (replaced) {
                const span = document.createElement("span");
                span.innerHTML = text;
                node.parentNode.replaceChild(span, node);
            }
        });
    }

    // ---------- APPEND ----------
    document.head.appendChild(style);
    document.body.appendChild(bar);

    document.body.style.paddingBottom = "60px";

    // ---------- BUTTON EVENT ----------
    const btn = document.getElementById("highlight-keywords-btn");

    if (btn) {
        btn.addEventListener("click", highlightKeywords);
    }

})();