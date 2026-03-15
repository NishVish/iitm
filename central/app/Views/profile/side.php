<?php include(APPPATH . 'Views/header.php'); ?>


<?php
$segment1 = service('uri')->getSegment(1);

if ($segment1 == 'user') : ?> 
    <div class="submenu">

        <a href="<?= base_url('user') ?>">User</a>
<?php if ($user_type === "superuser"): ?>
    <a href="<?= base_url('user/operation') ?>">Edit</a>
<?php endif; ?>


<a href="#" onclick="document.getElementById('dummyForm').submit(); return false;">Test Users</a>
    </div>
<?php endif; ?>

<!-- Hidden form for dummy data -->
<form id="dummyForm" action="<?= base_url('user/store') ?>" method="post" style="display:none;">
    <input type="hidden" name="employee_id" value="EMP123">
    <input type="hidden" name="name" value="John Doe">
    <input type="hidden" name="designation" value="Developer">
    <input type="hidden" name="phone" value="9876543210">
    <input type="hidden" name="address" value="123 Main Street">
    <input type="hidden" name="email" value="john.doe@example.com">
    <input type="hidden" name="password" value="password123">
    <input type="hidden" name="category" value="Full-Time">
    <input type="hidden" name="department" value="IT">
    <input type="hidden" name="doj" value="<?= date('Y-m-d') ?>">
    <input type="hidden" name="uan_no" value="UAN123456">
    <input type="hidden" name="fathers_name" value="Robert Doe">
    <input type="hidden" name="aadhaar_card" value="123412341234">
    <input type="hidden" name="pan_card" value="ABCDE1234F">
    <input type="hidden" name="bank_account_number" value="1234567890">
    <input type="hidden" name="ifsc_code" value="IFSC0001">
    <input type="hidden" name="user_type" value="general">
</form>


</div>
<div class="content">