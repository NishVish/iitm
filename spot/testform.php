<form method="POST" action="submittv.php" id="editForm" style="max-width: 400px; margin: 20px auto;">
  <label>
    Name:
    <input type="text" name="name" id="nameInput" required style="width: 100%; padding: 8px; margin-bottom: 10px;" />
  </label>

  <label>
    Company Name:
    <input type="text" name="company_name" id="companyInput" required style="width: 100%; padding: 8px; margin-bottom: 10px;" />
  </label>

  <label>
    Mobile:
    <input type="text" name="mobile" id="mobileInput" required style="width: 100%; padding: 8px; margin-bottom: 10px;" />
  </label>

  <input type="hidden" name="full_page" value="no" />

  <button type="submit" style="padding: 10px 16px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;">
    Submit
  </button>
</form>
