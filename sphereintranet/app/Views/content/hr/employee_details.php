<!DOCTYPE html>
<html>
<head>
    <title>All Employees</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8f9fa;
            padding: 20px;
        }
        a.back-link {
            display: inline-block;
            margin-bottom: 20px;
            text-decoration: none;
            color: #2a7ae2;
            font-weight: bold;
        }
        .cards-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            padding: 20px;
            width: 300px;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .card input[type="text"],
        .card input[type="email"],
        .card input[type="date"] {
            width: 100%;
            padding: 6px 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            box-sizing: border-box;
        }
        .card label {
            font-weight: 600;
            font-size: 13px;
            margin-bottom: 4px;
            color: #555;
        }
        .card button {
            margin-top: 10px;
            padding: 10px;
            background-color: #2a7ae2;
            color: white;
            border: none;
            border-radius: 4px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .card button:hover {
            background-color: #1a5cc8;
        }
    </style>
</head>
<body>

<a href="<?= site_url('home') ?>" class="back-link">← Back to Homepage</a>

<h2>All Employees</h2>

<div class="cards-container">

<?php foreach ($users as $user): ?>
    <form method="post" action="<?= site_url('users/updateProfile') ?>" class="card">
        <input type="hidden" name="reqFrom" value="hr">
        <input type="hidden" name="user_id" value="<?= esc($user['id']) ?>">

        <label for="employee_id_<?= esc($user['id']) ?>">Employee ID</label>
        <input id="employee_id_<?= esc($user['id']) ?>" type="text" name="employee_id" value="<?= esc($user['employee_id']) ?>">

        <label for="name_<?= esc($user['id']) ?>">Name</label>
        <input id="name_<?= esc($user['id']) ?>" type="text" name="name" value="<?= esc($user['name']) ?>">

        <label for="designation_<?= esc($user['id']) ?>">Designation</label>
        <input id="designation_<?= esc($user['id']) ?>" type="text" name="designation" value="<?= esc($user['designation']) ?>">

        <label for="phone_<?= esc($user['id']) ?>">Phone</label>
        <input id="phone_<?= esc($user['id']) ?>" type="text" name="phone" value="<?= esc($user['phone']) ?>">

        <label for="email_<?= esc($user['id']) ?>">Email</label>
        <input id="email_<?= esc($user['id']) ?>" type="email" name="email" value="<?= esc($user['email']) ?>">

        <label for="address_<?= esc($user['id']) ?>">Address</label>
        <input id="address_<?= esc($user['id']) ?>" type="text" name="address" value="<?= esc($user['address']) ?>">

        <label for="category_<?= esc($user['id']) ?>">Category</label>
        <input id="category_<?= esc($user['id']) ?>" type="text" name="category" value="<?= esc($user['category']) ?>">

        <label for="department_<?= esc($user['id']) ?>">Department</label>
        <input id="department_<?= esc($user['id']) ?>" type="text" name="department" value="<?= esc($user['department']) ?>">

        <label for="doj_<?= esc($user['id']) ?>">Date of Joining</label>
        <input id="doj_<?= esc($user['id']) ?>" type="date" name="doj" value="<?= esc($user['doj']) ?>">

        <label for="uan_no_<?= esc($user['id']) ?>">UAN No</label>
        <input id="uan_no_<?= esc($user['id']) ?>" type="text" name="uan_no" value="<?= esc($user['uan_no']) ?>">

        <label for="fathers_name_<?= esc($user['id']) ?>">Father's Name</label>
        <input id="fathers_name_<?= esc($user['id']) ?>" type="text" name="fathers_name" value="<?= esc($user['fathers_name']) ?>">

        <label for="aadhaar_card_<?= esc($user['id']) ?>">Aadhaar Card</label>
        <input id="aadhaar_card_<?= esc($user['id']) ?>" type="text" name="aadhaar_card" value="<?= esc($user['aadhaar_card']) ?>">

        <label for="pan_card_<?= esc($user['id']) ?>">PAN Card</label>
        <input id="pan_card_<?= esc($user['id']) ?>" type="text" name="pan_card" value="<?= esc($user['pan_card']) ?>">

        <label for="bank_account_number_<?= esc($user['id']) ?>">Bank Account Number</label>
        <input id="bank_account_number_<?= esc($user['id']) ?>" type="text" name="bank_account_number" value="<?= esc($user['bank_account_number']) ?>">

        <label for="ifsc_code_<?= esc($user['id']) ?>">IFSC Code</label>
        <input id="ifsc_code_<?= esc($user['id']) ?>" type="text" name="ifsc_code" value="<?= esc($user['ifsc_code']) ?>">

        <button type="submit">Save</button>
    </form>
<?php endforeach; ?>

</div>

</body>
</html>
