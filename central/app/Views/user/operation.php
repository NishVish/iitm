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
<?php foreach($users as $user): ?>
    <form action="<?= base_url('user/operation/save/'.$user['id']) ?>" method="post" style="margin-bottom:20px; border:1px solid #ccc; padding:10px;">
        <table border="0" cellpadding="3">
            <tr>
                <td>ID</td><td><?= $user['id'] ?></td>
            </tr>
            <tr><td>Employee ID</td><td><input type="text" name="employee_id" value="<?= esc($user['employee_id']) ?>"></td></tr>
            <tr><td>Name</td><td><input type="text" name="name" value="<?= esc($user['name']) ?>"></td></tr>
            <tr><td>Designation</td><td><input type="text" name="designation" value="<?= esc($user['designation']) ?>"></td></tr>
            <tr><td>Phone</td><td><input type="text" name="phone" value="<?= esc($user['phone']) ?>"></td></tr>
            <tr><td>Address</td><td><input type="text" name="address" value="<?= esc($user['address']) ?>"></td></tr>
            <tr><td>Email</td><td><input type="email" name="email" value="<?= esc($user['email']) ?>"></td></tr>
            <tr><td>Password</td><td><input type="password" name="password" placeholder="Enter new password"></td></tr>
            <tr><td>Category</td><td><input type="text" name="category" value="<?= esc($user['category']) ?>"></td></tr>
            <tr><td>Department</td><td><input type="text" name="department" value="<?= esc($user['department']) ?>"></td></tr>
            <tr><td>DOJ</td><td><input type="date" name="doj" value="<?= esc($user['doj']) ?>"></td></tr>
            <tr><td>UAN No</td><td><input type="text" name="uan_no" value="<?= esc($user['uan_no']) ?>"></td></tr>
            <tr><td>Father's Name</td><td><input type="text" name="fathers_name" value="<?= esc($user['fathers_name']) ?>"></td></tr>
            <tr><td>Aadhaar</td><td><input type="text" name="aadhaar_card" value="<?= esc($user['aadhaar_card']) ?>"></td></tr>
            <tr><td>PAN</td><td><input type="text" name="pan_card" value="<?= esc($user['pan_card']) ?>"></td></tr>
            <tr><td>Bank Account</td><td><input type="text" name="bank_account_number" value="<?= esc($user['bank_account_number']) ?>"></td></tr>
            <tr><td>IFSC</td><td><input type="text" name="ifsc_code" value="<?= esc($user['ifsc_code']) ?>"></td></tr>
            <tr><td colspan="2">
                <button type="submit">Save Changes</button>
            </td></tr>
        </table>
    </form>
<?php endforeach; ?>
</body>
</html>