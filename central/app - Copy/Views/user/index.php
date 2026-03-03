
<?= view('user/side') ?>  <!-- loads app/Views/header.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Users List</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        a { text-decoration: none; color: blue; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>

    <h1>All Users</h1>

    <p><a href="<?= base_url('user/create') ?>">Add New User</a></p>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Employee ID</th>
                <th>Name</th>
                <th>Designation</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Department</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($users) && is_array($users)): ?>
                <?php foreach($users as $user): ?>
                    <tr>
                        <td><?= $user['id'] ?></td>
                        <td><?= esc($user['employee_id']) ?></td>
                        <td><?= esc($user['name']) ?></td>
                        <td><?= esc($user['designation']) ?></td>
                        <td><?= esc($user['email']) ?></td>
                        <td><?= esc($user['phone']) ?></td>
                        <td><?= esc($user['department']) ?></td>
                        <td>
                            <a href="<?= base_url('user/'.$user['id']) ?>">View</a> |
                            <a href="<?= base_url('user/delete/'.$user['id']) ?>" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8">No users found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html>