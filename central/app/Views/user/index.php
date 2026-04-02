<?= view('user/side') ?> <!-- loads app/Views/header.php -->

<!DOCTYPE html>
<html>

<head>
    <title>Users List</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        a {
            text-decoration: none;
            color: blue;
        }

        a:hover {
            text-decoration: underline;
        }


        .modal {
            display: none;
            position: fixed;
            z-index: 999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background: #fff;
            padding: 20px;
            width: 500px;
            margin: 5% auto;
            border-radius: 8px;
            max-height: 80vh;
            overflow-y: auto;
        }

        .close {
            float: right;
            font-size: 20px;
            cursor: pointer;
        }

        .modal input,
        .modal textarea {
            width: 100%;
            margin-bottom: 10px;
            padding: 8px;
        }
    </style>
</head>

<body>

    <h1>All Users</h1>

    <p><button onclick="openModal()">Add New User</button></p>
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
            <?php if (!empty($users) && is_array($users)): ?>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $user['id'] ?></td>
                        <td><?= esc($user['employee_id']) ?></td>
                        <td><?= esc($user['name']) ?></td>
                        <td><?= esc($user['designation']) ?></td>
                        <td><?= esc($user['email']) ?></td>
                        <td><?= esc($user['phone']) ?></td>
                        <td><?= esc($user['department']) ?></td>
                        <td>
                            <a href="<?= base_url('user/' . $user['id']) ?>">View</a> |
                            <a href="<?= base_url('user/delete/' . $user['id']) ?>"
                                onclick="return confirm('Are you sure?')">Delete</a>
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
    <div id="userModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>

            <h2>Create User</h2>

            <form method="post" action="<?= base_url('user/store') ?>">
                <?= csrf_field() ?>

                <input type="text" name="employee_id" placeholder="Employee ID" required>
                <input type="text" name="name" placeholder="Name" required>
                <input type="text" name="designation" placeholder="Designation">
                <input type="text" name="phone" placeholder="Phone">
                <textarea name="address" placeholder="Address"></textarea>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="text" name="category" placeholder="Category">
                <input type="text" name="department" placeholder="Department">
                <input type="date" name="doj">
                <input type="text" name="uan_no" placeholder="UAN No">
                <input type="text" name="fathers_name" placeholder="Father's Name">
                <input type="text" name="aadhaar_card" placeholder="Aadhaar">
                <input type="text" name="pan_card" placeholder="PAN">
                <input type="text" name="bank_account_number" placeholder="Bank Account">
                <input type="text" name="ifsc_code" placeholder="IFSC">

                <button type="submit">Save</button>
            </form>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('userModal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('userModal').style.display = 'none';
        }

        // Close when clicking outside
        window.onclick = function (event) {
            let modal = document.getElementById('userModal');
            if (event.target === modal) {
                modal.style.display = "none";
            }
        }
    </script>


</body>

</html>