document.getElementById('run').addEventListener('click', async () => {

    const cmd = document.getElementById('cmd').value;

    try {

        const response = await fetch('http://localhost/iitm/lara/public/api/run-command', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ cmd })
        });

        const data = await response.json();

        document.getElementById('output').textContent = data.output;

    } catch (error) {

        document.getElementById('output').textContent =
            'Error connecting to Laravel API';
    }
});
