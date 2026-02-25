<?= view('tools/side') ?>

<?php
// Run ipconfig
$output = shell_exec('ipconfig');

// Search for IPv4 address using regex
if (preg_match('/IPv4 Address[.\s]*:\s*([\d\.]+)/', $output, $matches)) {
    $local_ip = $matches[1];
} else {
    $local_ip = "127.0.0.1";
}

// Set your port
$port = 5000;

// Build full URL
$server_url = "http://{$local_ip}:{$port}";
?>
<a href="<?= base_url('tools/download-server') ?>" 
   class="download-btn" 
   style="padding:12px 20px; background:#4CAF50; color:#fff; border-radius:8px; text-decoration:none;">
    Download Server Module
</a>

<style>
.transfer-container {
    width: 100%;
    max-width: 900px;
    margin: 20px auto;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 25px rgba(0,0,0,0.15);
    background: #fff;
}
.server-frame {
    width: 100%;
    height: 700px;
    border: none;
    display: none;
}
.loading-status {
    padding: 50px;
    text-align: center;
    font-family: sans-serif;
}
.status-badge {
    padding: 5px 15px;
    border-radius: 20px;
    font-weight: bold;
    font-size: 14px;
}
.offline { background: #fee2e2; color: #991b1b; }
</style>

<div class="transfer-container">
    <div id="statusArea" class="loading-status">
        <h3>Connecting to File Transfer Server...</h3>
        <p>Checking <strong><?= $server_url ?></strong></p>
        <div id="errorMsg" style="display:none;">
            <span class="status-badge offline">OFFLINE</span>
            <p>Please ensure your local server is running and your PC is on the same network.</p>
        </div>
    </div>

    <iframe 
        id="appFrame" 
        src="<?= $server_url ?>" 
        class="server-frame"
        allow="clipboard-read; clipboard-write; geolocation">
    </iframe>
</div>

<script>
async function checkLocalServer() {
    const target = "<?= $server_url ?>";
    const frame = document.getElementById('appFrame');
    const statusArea = document.getElementById('statusArea');
    const errorMsg = document.getElementById('errorMsg');

    try {
        // Simple connectivity check
        await fetch(target, { mode: 'no-cors', cache: 'no-cache' });

        // Server is reachable
        statusArea.style.display = 'none';
        frame.style.display = 'block';
    } catch (e) {
        // Server not reachable
        statusArea.querySelector('h3').style.display = 'none';
        errorMsg.style.display = 'block';
    }
}

// Run on load
window.onload = checkLocalServer;
</script>