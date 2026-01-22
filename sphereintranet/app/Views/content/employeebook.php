<!-- app/Views/content/employeebook.php -->
<?php if (!isset($session)) $session = session(); ?>

<!-- Add Employee Button -->
<button id="openFormBtn" style="margin-bottom: 15px;">Add Employee</button>

<!-- Modal Form Container -->
<div id="popupForm" style="
  display: none;
  position: fixed;
  top: 0; left: 0;
  width: 100vw; height: 100vh;
  background: rgba(0, 0, 0, 0.5);
  backdrop-filter: blur(2px);
  justify-content: center;
  align-items: center;
  z-index: 9999;
">

  <!-- Inner Form -->
  <div style="
    background: white;
    padding: 20px;
    border-radius: 8px;
    min-width: 300px;
    position: relative;
    color:black;
  ">
<h3>Add New Employee</h3>
<form method="POST" action="<?= base_url('users/addUser') ?>" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px 24px;">

  <label>
    Employee ID:<br>
    <input type="text" name="employee_id" required>
  </label>

  <label>
    Name:<br>
    <input type="text" name="name" required>
  </label>

  <label>
    Designation:<br>
    <input type="text" name="designation" required>
  </label>

  <label>
    Phone:<br>
    <input type="text" name="phone">
  </label>

  <label>
    Address:<br>
    <input type="text" name="address">
  </label>

  <label>
    Email:<br>
    <input type="email" name="email">
  </label>

  <label>
    Password:<br>
    <input type="password" name="password">
  </label>
   <label>
    Department:<br>
    <input type="text" name="department">
  </label>

  <label>
    Date of Joining:<br>
    <input type="date" name="doj">
  </label>

  <label>
    UAN No:<br>
    <input type="text" name="uan_no">
  </label>

  <label>
    Father's Name:<br>
    <input type="text" name="fathers_name">
  </label>

<!-- 
  <label>
    Category:<br>
    <input type="text" name="category">
  </label> -->

  <label>
  Aadhaar Card:<br>
  <input type="text" name="aadhaar_card">
</label>

<label>
  PAN Card:<br>
  <input type="text" name="pan_card">
</label>

<label>
  Bank Account Number:<br>
  <input type="text" name="bank_account_number">
</label>

<label>
  IFSC Code:<br>
  <input type="text" name="ifsc_code">
</label>






  <!-- Buttons spanning full width -->
  <div style="grid-column: span 2; display: flex; gap: 10px; justify-content: flex-start;">
    <button type="submit">Submit</button>
    <button type="button" id="closeFormBtn">Cancel</button>
  </div>

</form>

  </div>
</div>
<script>
  const openFormBtn = document.getElementById('openFormBtn');
  const closeFormBtn = document.getElementById('closeFormBtn');
  const popupForm = document.getElementById('popupForm');

  openFormBtn.addEventListener('click', () => {
    popupForm.style.display = 'flex';
  });

  closeFormBtn.addEventListener('click', () => {
    popupForm.style.display = 'none';
  });

  // Optional: close popup if you click outside the form
  popupForm.addEventListener('click', (e) => {
    if (e.target === popupForm) {
      popupForm.style.display = 'none';
    }
  });
</script>
