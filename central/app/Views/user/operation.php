<!DOCTYPE html>
<html>
<head>
    <title>Edit Users</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ccc; padding: 6px; }
        input { width: 100%; box-sizing: border-box; }
    </style>
</head>
<body>

<h1>Edit Users</h1>

<form action="<?= base_url('user/operation/save') ?>" method="post">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Employee ID</th>
                <th>Name</th>
                <th>Designation</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Email</th>
                <th>Password</th>
                <th>Category</th>
                <th>Department</th>
                <th>DOJ</th>
                <th>UAN No</th>
                <th>Father's Name</th>
                <th>Aadhaar</th>
                <th>PAN</th>
                <th>Bank Account</th>
                <th>IFSC</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($users as $user): ?>
                <tr>
                    <td>
                        <?= $user['id'] ?>
                        <input type="hidden" name="id[]" value="<?= $user['id'] ?>">
                    </td>
                    <td><input type="text" name="employee_id[]" value="<?= esc($user['employee_id']) ?>"></td>
                    <td><input type="text" name="name[]" value="<?= esc($user['name']) ?>"></td>
                    <td><input type="text" name="designation[]" value="<?= esc($user['designation']) ?>"></td>
                    <td><input type="text" name="phone[]" value="<?= esc($user['phone']) ?>"></td>
                    <td><input type="text" name="address[]" value="<?= esc($user['address']) ?>"></td>
                    <td><input type="text" name="email[]" value="<?= esc($user['email']) ?>"></td>
                    <td><input type="text" name="password[]" placeholder="Enter new password"></td>
                    <td><input type="text" name="category[]" value="<?= esc($user['category']) ?>"></td>
                    <td><input type="text" name="department[]" value="<?= esc($user['department']) ?>"></td>
                    <td><input type="date" name="doj[]" value="<?= esc($user['doj']) ?>"></td>
                    <td><input type="text" name="uan_no[]" value="<?= esc($user['uan_no']) ?>"></td>
                    <td><input type="text" name="fathers_name[]" value="<?= esc($user['fathers_name']) ?>"></td>
                    <td><input type="text" name="aadhaar_card[]" value="<?= esc($user['aadhaar_card']) ?>"></td>
                    <td><input type="text" name="pan_card[]" value="<?= esc($user['pan_card']) ?>"></td>
                    <td><input type="text" name="bank_account_number[]" value="<?= esc($user['bank_account_number']) ?>"></td>
                    <td><input type="text" name="ifsc_code[]" value="<?= esc($user['ifsc_code']) ?>"></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <p><button type="submit">Save Changes</button></p>
</form>

</body>
</html>