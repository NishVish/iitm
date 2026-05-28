chrome.runtime.onMessage.addListener((request, sender, sendResponse) => {

    if (request.type === 'RUN_CMD') {
        fetch("http://127.0.0.1:5050", {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ cmd: request.cmd })
        })
            .then(async (res) => {
                const text = await res.text();
                try {
                    sendResponse(JSON.parse(text));
                } catch (e) {
                    sendResponse({ error: text });
                }
            })
            .catch(err => sendResponse({ error: err.message }));

        return true;
    }

    if (request.type === 'GET_PAGE_TEXT') {
        chrome.tabs.query({ active: true, currentWindow: true }, (tabs) => {
            const tabId = tabs[0]?.id;
            if (!tabId) return sendResponse({ text: '' });

            chrome.scripting.executeScript(
                {
                    target: { tabId },
                    func: () => document.body.innerText.slice(0, 4000),
                },
                (results) => {
                    sendResponse({ text: results?.[0]?.result || '' });
                }
            );
        });

        return true;
    }
});