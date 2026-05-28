
chrome.runtime.onMessage.addListener((request, sender, sendResponse) => {

    if (request.type === 'RUN_CMD') {

        fetch('http://localhost/iitm/lara/run-command', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                cmd: request.cmd
            })
        })
        .then(res => res.json())
        .then(data => sendResponse(data))
        .catch(err => sendResponse({
            error: err.message
        }));

        return true;
    }
});
