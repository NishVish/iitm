
document.addEventListener("DOMContentLoaded", function () {

    document.getElementById("renderBtn").addEventListener("click", function () {

        const html = document.getElementById("htmlInput").value;

        chrome.tabs.query({ active: true, currentWindow: true }, function (tabs) {

            chrome.scripting.executeScript({
                target: { tabId: tabs[0].id },
                function: injectRenderHTML,
                args: [html]
            });

        });

    });

});

function injectRenderHTML(html) {

    const walker = document.createTreeWalker(
        document.body,
        NodeFilter.SHOW_TEXT,
        null,
        false
    );

    let node;

    while ((node = walker.nextNode())) {

        if (node.nodeValue && node.nodeValue.includes("renderhtml()")) {

            const wrapper = document.createElement("span");

            const parts = node.nodeValue.split("renderhtml()");

            wrapper.innerHTML = parts.join(html);

            node.parentNode.replaceChild(wrapper, node);
        }
    }
}
