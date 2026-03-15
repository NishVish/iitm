<?= view('tools/side') ?>


<!DOCTYPE html>
<html>
<head>
    <title>Network Servers</title>
</head>
<body>
    <h1>Servers in the Network</h1>
    <?php if(!empty($servers)): ?>
        <ul>
            <?php foreach($servers as $server): ?>
                <li><?= esc($server) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No servers found.</p>
    <?php endif; ?>
</body>
</html>