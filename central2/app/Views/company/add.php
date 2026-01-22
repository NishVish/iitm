<?= view('header') ?>

<!-- <h2>Add Company</h2>
  loads app/Views/header.php 

<?php if(isset($conflict)): ?>
    <div style="background:#ffeeba;padding:10px;border:1px solid #f5c6cb;margin-bottom:20px;">
        <h4>Potential Conflict Found!</h4>
        <p>Matching fields: <?= implode(', ', $matches) ?></p>
        <p>Existing Company Name: <?= esc($conflict['company_name']) ?> | GST: <?= esc($conflict['gst_number']) ?></p>
        <form method="post" action="<?= site_url('company/replace/'.$conflict['id']) ?>">
            <?php foreach($post as $k=>$v): ?>
                <input type="hidden" name="<?= esc($k) ?>" value="<?= esc($v) ?>">
            <?php endforeach; ?>
            <button type="submit">Replace Existing</button>
        </form>
        <form method="get" action="<?= site_url('company/add') ?>">
            <button type="submit">Keep Existing / Cancel</button>
        </form>
    </div>
<?php endif; ?>

<form action="" method="post">
    <h3>Company Details</h3>
    <label>Company Name</label>
    <input type="text" name="company_name" value="<?= esc($post['company_name'] ?? '') ?>" required><br>

    <label>GST Number</label>
    <input type="text" name="gst_number" value="<?= esc($post['gst_number'] ?? '') ?>"><br>

    <label>Category</label>
    <input type="text" name="category" value="<?= esc($post['category'] ?? '') ?>"><br>

    <label>City</label>
    <input type="text" name="city" value="<?= esc($post['city'] ?? '') ?>"><br>

    <label>State</label>
    <input type="text" name="state" value="<?= esc($post['state'] ?? '') ?>"><br>

    <label>Phone</label>
    <input type="text" name="phone" value="<?= esc($post['phone'] ?? '') ?>"><br>

    <label>Address</label>
    <textarea name="address"><?= esc($post['address'] ?? '') ?></textarea><br>

    <h3>Contacts</h3>
    <div id="contactsContainer">
        <div class="contactRow">
            <label>Name</label>
            <input type="text" name="contacts[0][name]">
            <label>Designation</label>
            <input type="text" name="contacts[0][designation]">
            <label>Mobile</label>
            <input type="text" name="contacts[0][mobile]">
            <label>Email</label>
            <input type="email" name="contacts[0][email]">
        </div>
    </div>
    <button type="button" id="addContactBtn">Add Another Contact</button>
    <br><br>
    <button type="submit">Submit Company</button>
</form>

<script>
// Dynamically add contact rows
let contactIndex = 1;
document.getElementById('addContactBtn').addEventListener('click', function() {
    let container = document.getElementById('contactsContainer');
    let div = document.createElement('div');
    div.classList.add('contactRow');
    div.innerHTML = `
        <label>Name</label>
        <input type="text" name="contacts[${contactIndex}][name]">
        <label>Designation</label>
        <input type="text" name="contacts[${contactIndex}][designation]">
        <label>Mobile</label>
        <input type="text" name="contacts[${contactIndex}][mobile]">
        <label>Email</label>
        <input type="email" name="contacts[${contactIndex}][email]">
    `;
    container.appendChild(div);
    contactIndex++;
});
</script> -->


<h2>Add Company</h2>

<form action="<?= site_url('company/add') ?>" method="post">
    <?= csrf_field() ?>

    <table border="1" cellpadding="5" cellspacing="0" style="width:100%; border-collapse: collapse;">
        <thead style="background:#f0f0f0;">
            <tr>
                <th>Company Name</th>
                <th>GST Number</th>
                <th>Category</th>
                <th>City</th>
                <th>State</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Contacts</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="companyTableBody">
            <tr class="companyRow">
                <td><input type="text" name="companies[0][company_name]" required></td>
                <td><input type="text" name="companies[0][gst_number]"></td>
                <td><input type="text" name="companies[0][category]"></td>
                <td><input type="text" name="companies[0][city]"></td>
                <td><input type="text" name="companies[0][state]"></td>
                <td><input type="text" name="companies[0][phone]"></td>
                <td><textarea name="companies[0][address]"></textarea></td>
                <td>
                    <div class="contactsContainer">
                        <div class="contactRow">
                            <input type="text" name="companies[0][contacts][0][name]" placeholder="Name">
                            <input type="text" name="companies[0][contacts][0][designation]" placeholder="Designation">
                            <input type="text" name="companies[0][contacts][0][mobile]" placeholder="Mobile">
                            <input type="email" name="companies[0][contacts][0][email]" placeholder="Email">
                        </div>
                    </div>
                    <button type="button" class="addContactBtn">Add Contact</button>
                </td>
                <td><button type="button" class="removeCompanyBtn">Remove</button></td>
            </tr>
        </tbody>
    </table>
    <br>
    <button type="button" id="addCompanyBtn">Add Another Company</button>
    <br><br>
    <button type="submit">Submit Companies</button>
</form>

<script>
let companyIndex = 1;

// Add new company row
document.getElementById('addCompanyBtn').addEventListener('click', function() {
    const tbody = document.getElementById('companyTableBody');
    const newRow = document.querySelector('.companyRow').cloneNode(true);

    // Reset inputs
    newRow.querySelectorAll('input, textarea').forEach(input => input.value = '');
    
    // Update name attributes
    newRow.querySelectorAll('input, textarea').forEach(input => {
        input.name = input.name.replace(/\d+/, companyIndex);
        if(input.name.includes('contacts[0]')) {
            input.name = input.name.replace('contacts[0]', 'contacts[0]'); // first contact
        }
    });

    // Add event listeners
    newRow.querySelector('.addContactBtn').addEventListener('click', addContact);
    newRow.querySelector('.removeCompanyBtn').addEventListener('click', removeCompany);

    tbody.appendChild(newRow);
    companyIndex++;
});

// Add contact row
function addContact(e) {
    const contactsDiv = e.target.parentElement.querySelector('.contactsContainer');
    let contactRows = contactsDiv.querySelectorAll('.contactRow');
    let contactIndex = contactRows.length;

    const newContact = contactRows[0].cloneNode(true);
    newContact.querySelectorAll('input').forEach(input => input.value = '');

    // Update name attributes
    newContact.querySelectorAll('input').forEach(input => {
        input.name = input.name.replace(/\d+\]$/, contactIndex + ']');
    });

    contactsDiv.appendChild(newContact);
}

// Attach to initial contact button
document.querySelectorAll('.addContactBtn').forEach(btn => btn.addEventListener('click', addContact));

// Remove company
function removeCompany(e) {
    const row = e.target.closest('tr');
    if(document.querySelectorAll('.companyRow').length > 1) {
        row.remove();
    } else {
        alert('At least one company is required');
    }
}

// Attach to initial remove button
document.querySelectorAll('.removeCompanyBtn').forEach(btn => btn.addEventListener('click', removeCompany));
</script>
