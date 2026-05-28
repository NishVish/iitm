
function run() {
    const html = document.getElementById("htmlInput").value;

    chrome.tabs.query({ active: true, currentWindow: true }, function (tabs) {
        chrome.scripting.executeScript({
            target: { tabId: tabs[0].id },
            function: injectHTML,
            args: [html]
        });
    });
}

function injectHTML(html) {

    // Find all text nodes containing renderhtml()
    const walker = document.createTreeWalker(
        document.body,
        NodeFilter.SHOW_TEXT,
        null,
        false
    );

    let node;

    while (node = walker.nextNode()) {
        if (node.nodeValue.includes("renderhtml()")) {

            // Create wrapper
            const wrapper = document.createElement("span");

            // Split text around keyword
            const parts = node.nodeValue.split("renderhtml()");

            wrapper.innerHTML = parts.join(html);

            node.parentNode.replaceChild(wrapper, node);
        }
    }
}
