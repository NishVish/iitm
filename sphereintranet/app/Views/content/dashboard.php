<?php if (!isset($session)) $session = session(); ?>

<style>
    .cv-container {
        display: flex;
        width: 800px;
        max-width: 1000px;
        margin: 30px auto;
        padding: 25px;
        border: 1px solid #ddd;
        border-radius: 10px;
        font-family: Arial, sans-serif;
        background: #979797ff;
        color: black;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
    }

    .section-left {
        width: 20%;
        padding-right: 20px;
        border-right: 1px solid #eee;
    }

    .section-right {
        width: 70%;
        padding-left: 20px;
    }

    .profile-photo {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 6px;
        margin-bottom: 10px;
    }

    .cv-name {
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .cv-info {
        margin-bottom: 20px;
        color: #444;
    }

    .menu-btn {
        display: block;
        width: 100%;
        padding: 10px;
        margin: 5px 0;
        background-color: #404040ff;
        border: 1px solid #ccc;
        border-radius: 4px;
        text-align: left;
        cursor: pointer;
        font-weight: bold;
    }

    .menu-btn:hover {
        background-color: #e0e0e0;
    }

    .cv-section-content {
        display: none;
    }

    .cv-section-content.active {
        display: block;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 150px 1fr;
        row-gap: 12px;
        column-gap: 10px;
        align-items: center;
    }

    .form-grid label {
        font-weight: bold;
        text-align: right;
        padding-right: 10px;
    }

    .form-grid input {
        padding: 6px;
        width: 100%;
        border: 1px solid #aaa;
        border-radius: 4px;
    }

    .button-group {
        text-align: left;
        margin-top: 20px;
    }

    .button-group button {
        padding: 8px 18px;
        margin-right: 10px;
        border: none;
        border-radius: 4px;
        font-weight: bold;
        cursor: pointer;
    }

    .btn-primary {
        background-color: #007BFF;
        color: white;
    }

    .btn-secondary {
        background-color: #6c757d;
        color: white;
    }

    .btn-disabled {
        background-color: #ccc;
        color: #666;
        cursor: not-allowed;
    }

    input[disabled] {
        background-color: #f2f2f2;
    }

.dashboard-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 15px;
    padding: 10px 0;
}

.dashboard-item {
    background-color: #fff;
    color: #333;
    border: 1px solid #ccc;
    border-radius: 6px;
    padding: 15px;
    text-align: center;
    font-weight: bold;
    box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.1);
    cursor: pointer;
    transition: background 0.2s, transform 0.2s;
}

.dashboard-item:hover {
    background-color: #f0f0f0;
    transform: translateY(-2px);
}


</style>

<div class="cv-container">
    <!-- Section 1: Left -->
    <div class="section-left">
        <img 
            src="https://spheretravelmedia.com/wp-content/uploads/2025/03/cropped-cropped-38x38inch-Sphere-Logo-Copy-min_prev_ui-300x100.png"
            alt="Profile Photo"
            class="profile-photo"
        >
        <div class="cv-name"><?= esc($session->get('name')) ?></div>
        <div class="cv-info">
            <p><strong><?= esc($session->get('designation')) ?></strong></p>
            <p>📞 <?= esc($session->get('phone')) ?></p>
        </div>

        <!-- Menu Buttons -->
        <button class="menu-btn" onclick="loadSection('personal')">Personal Info</button>
        <button class="menu-btn" onclick="loadSection('performance')">Performance</button>
<button class="menu-btn" onclick="loadSection('x')">Dashboard</button>
    </div>

    <!-- Section 2: Right -->
    <div class="section-right">
        <div id="personal" class="cv-section-content">
            <!-- Personal Info Form -->
            <form id="profileForm" action="<?= base_url('users/updateProfile') ?>" method="post">
                <input type="hidden" name="user_id" value="<?= esc($session->get('user_id')) ?>">

                <div class="form-grid">
    <label for="employee_id">Employee ID:</label>
    <input type="text" id="employee_id" name="employee_id" value="<?= esc($session->get('employee_id')) ?>" disabled>
<label for="email">Email:</label>
<input type="email" id="email" name="email" value="<?= esc($session->get('email')) ?>" disabled>

<label for="address">Address:</label>
<input type="text" id="address" name="address" value="<?= esc($session->get('address')) ?>" disabled>

<label for="designation">Designation:</label>
<input type="text" id="designation" name="designation" value="<?= esc($session->get('designation')) ?>" disabled>

<label for="phone">Phone Number:</label>
<input type="text" id="phone" name="phone" value="<?= esc($session->get('phone')) ?>" disabled>

    <label for="category">Category:</label>
    <input type="text" id="category" name="category" value="<?= esc($session->get('user_type')) ?>" disabled>

    <label for="department">Department:</label>
    <input type="text" id="department" name="department" value="<?= esc($session->get('department')) ?>" disabled>

    <label for="doj">Date of Joining:</label>
    <input type="date" id="doj" name="doj" value="<?= esc($session->get('doj')) ?>" disabled>

    <label for="uan_no">UAN No:</label>
    <input type="text" id="uan_no" name="uan_no" value="<?= esc($session->get('uan_no')) ?>" disabled>

    <label for="fathers_name">Father's Name:</label>
    <input type="text" id="fathers_name" name="fathers_name" value="<?= esc($session->get('fathers_name')) ?>" disabled>

    <label for="aadhaar_card">Aadhaar Card:</label>
    <input type="text" id="aadhaar_card" name="aadhaar_card" value="<?= esc($session->get('aadhaar_card')) ?>" disabled>

    <label for="pan_card">PAN Card:</label>
    <input type="text" id="pan_card" name="pan_card" value="<?= esc($session->get('pan_card')) ?>" disabled>

    <label for="bank_account_number">Bank Account No:</label>
    <input type="text" id="bank_account_number" name="bank_account_number" value="<?= esc($session->get('bank_account_number')) ?>" disabled>

    <label for="ifsc_code">IFSC Code:</label>
    <input type="text" id="ifsc_code" name="ifsc_code" value="<?= esc($session->get('ifsc_code')) ?>" disabled>
</div>


                <!-- <div class="button-group">
                    <button type="button" class="btn-primary" onclick="enableEdit()">Edit Details</button>
                    <button type="submit" class="btn-primary" id="submitBtn" disabled>Save Changes</button>
                </div> -->
            </form>
        </div>

<div id="performance" class="cv-section-content">
            <h3>Performance Section</h3>
            <p>Performance-related data will go here.</p>
        </div>
        <div id="x" class="cv-section-content active">
            <div class="dashboard-grid">
                <div class="dashboard-item">Leave</div>
                <div class="dashboard-item">Compoff Requisition</div>
                <div class="dashboard-item">Attendance</div>
                <div class="dashboard-item">Holiday List</div>
                <div class="dashboard-item">Salary Slip Form</div>
                <div class="dashboard-item">Increment / Promotion Letter</div>
                <div class="dashboard-item">CTC Report</div>
                <div class="dashboard-item">Annual Bonus</div>
            </div>
        </div>


    </div>
</div>

<script>
function loadSection(sectionId) {
    const sections = document.querySelectorAll('.cv-section-content');
    sections.forEach(section => {
        section.classList.remove('active');
    });

    const target = document.getElementById(sectionId);
    if (target) {
        target.classList.add('active');
    }
}


    function enableEdit() {
        const form = document.getElementById('profileForm');
        const inputs = form.querySelectorAll('input');

        inputs.forEach(input => {
            if (input.type !== 'hidden') {
                input.disabled = false;
            }
        });

        const submitBtn = document.getElementById('submitBtn');
        if (submitBtn) submitBtn.disabled = false;
    }
</script>
