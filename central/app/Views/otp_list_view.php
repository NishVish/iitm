<!DOCTYPE html>
<html>
<head>
    <title>Active OTP List</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #f4f4f4; }
        .expired { color: red; }
    </style>
</head>
<body>
    <h2>Users with Active OTPs</h2>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Mobile</th>
                <th>OTP</th>
                <th>Expiry Time</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($otps)): ?>
                <?php foreach ($otps as $row): ?>
                <tr>
                    <td><?= esc($row['name']) ?></td>
                    <td><?= esc($row['mobile']) ?></td>
                    <td><strong><?= esc($row['otp']) ?></strong></td>
                    <td><?= esc($row['otp_expiry']) ?></td>
                    <td>
                        <?php 
                        if (strtotime($row['otp_expiry']) < time()) {
                            echo '<span class="expired">Expired</span>';
                        } else {
                            echo '<span style="color: green;">Valid</span>';
                        }
                        ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No active OTPs found in the database.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>