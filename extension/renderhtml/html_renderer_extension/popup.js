
function injectHTML() {
    let html = document.getElementById("htmlInput").value;

    chrome.tabs.query({ active: true, currentWindow: true }, function (tabs) {
        chrome.scripting.executeScript({
            target: { tabId: tabs[0].id },
            function: replaceRenderHTML,
            args: [html]
        });
    });
}

function replaceRenderHTML(html) {
    let body = document.body.innerHTML;

    // Replace keyword renderhtml()
    body = body.replaceAll("renderhtml()", html);

    document.body.innerHTML = body;
}
