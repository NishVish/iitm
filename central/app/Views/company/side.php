<!-- view.php -->
<?php include(APPPATH . 'Views/header.php'); ?>



<!-- Companies Section -->
<!-- Companies Section -->
<?php 
$segment1 = service('uri')->getSegment(1);



if ($segment1 == 'company') : ?>
<div class="submenu">
    <a href="<?= base_url('company/all') ?>">All Companies</a>

    <a href="<?= base_url('company/main') ?>">View Companies</a>
    <a href="<?= base_url('company/lead') ?>">Leads Companies</a>
    <a href="<?= base_url('company/participant') ?>">Participant Companies</a>
    <a href="<?= base_url('company/online_registration') ?>">Online Registration Companies</a>
    <a href="<?= base_url('company/spot') ?>">Spot Regisrataion</a>
<a href="<?= base_url('company/operation') ?>" >Operation</a>

    <a href="<?= base_url('company/add') ?>">Add Company</a>
    <a href="<?= base_url('company/addexhibitor') ?>">Add Exhibitor</a>
    <a href="<?= base_url('company/stats') ?>">Stats</a>
    <h2>

</h2>
    <?php if (isset($user_type) && ($user_type === 'admin' || $user_type === 'superuser')): ?>
        


       <!-- Container for the form -->
<div id="clearDatabaseContainer" style="max-width:auto; margin-top:10px;">
    <select id="databaseDropdown" style="max-width:150px" required>
        <option value="" disabled selected>Loading databases...</option>
    </select>
</div>

<script>
const container = document.getElementById('clearDatabaseContainer');
const dropdown = document.getElementById('databaseDropdown');

// Fetch database names dynamically
fetch('<?= site_url('api/databases') ?>')
    .then(response => response.json())
    .then(databases => {
        // Clear placeholder
        dropdown.innerHTML = '<option value="" disabled selected>Select Database</option>';

        databases.forEach(db => {
            const option = document.createElement('option');
            option.value = db.db_name;
            option.textContent = db.db_name;
            dropdown.appendChild(option);
        });
    })
    .catch(err => {
        console.error('Failed to fetch databases:', err);
        dropdown.innerHTML = '<option value="" disabled>Error loading databases</option>';
    });

// Listen for selection change
dropdown.addEventListener('change', function() {
    const selectedDb = this.value;
    if (!selectedDb) return;

    // Remove any existing form
    const existingForm = document.getElementById('dynamicClearForm');
    if (existingForm) existingForm.remove();

    // Create new form with action pointing to the selected database
    const form = document.createElement('form');
    form.id = 'dynamicClearForm';
    form.action = '<?= site_url('clear-companies') ?>/' + encodeURIComponent(selectedDb);
    form.method = 'GET'; // or POST if you change the route
    form.style.display = 'inline-block';

    // Create submit button
    const button = document.createElement('button');
    button.type = 'submit';
    button.className = 'action-btn danger';
    button.textContent = 'Clear Selected Database';
    button.onclick = function() {
        return confirm('⚠️ You are about to clear all companies and related data for "' + selectedDb + '". This cannot be undone. Proceed?');
    };

    form.appendChild(button);

    // Append form after dropdown
    container.appendChild(form);
});
</script>
   <!-- <button type="submit" class="action-btn danger"
        onclick="return confirm('⚠️ You are about to clear all companies and related data for the selected database. This cannot be undone. Proceed?');">
        Clear Selected Database
    </button> -->
<!-- Existing buttons -->
<a href="<?= site_url('clear-matching') ?>" class="action-btn danger">Clear Matching</a>
<a href="<?= site_url('clear-contacts') ?>" class="action-btn danger">Clear Matching</a>

<a href="<?= site_url('clear-companies/yes') ?>" 
   class="action-btn danger"
   onclick="return confirm('🚨 DANGER ZONE 🚨\n\nThis action will permanently delete ALL companies.\nThis cannot be undone.\n\nClick OK only if you are absolutely sure.');">
   Clear Companies
</a>

<!-- New button with dropdown for database selection -->

 
</form>
        <!-- <a href="<?= site_url('crossvalidation/crossValidate') ?>" class="action-btn primary">Company Cross Validation</a> -->
        <!-- <a href="<?= site_url('company/dummy') ?>" class="action-btn primary">Insert Data</a> -->
        <!-- <a href="<?= site_url('crossvalidation/crossValidateContact') ?>" class="action-btn primary">Contact Cross Validation</a> -->

        <!-- <a href="<?= site_url('crossvalidation/clear') ?>" class="action-btn warning">Clear Matches</a> -->
        <!-- <a href="<?= site_url('crossvalidation/clearcontact') ?>" class="action-btn warning">Clear Contact Matches</a> -->

    <?php endif; ?>

    
<?php endif; ?>
</div>

<style>
    <style>
:root {
    /* Main colors */
    --nav-color: #a82324;
    --nav-color-dim: #c45a5b;

    --body-color: #f8f4f4;
    --body-color-dim: #fbf9f9;

    --button-color: #a82324;
    --button-color-dim: #c45a5b;

    --text-color: #ffffff;
    --text-color-dim: #dcdcdc;
}

/* Action Button Base */
.action-btn {
    padding: 8px 14px;
    border-radius: 8px;
    text-decoration: none;
    font-size: 13px;
    font-weight: 600;
    transition: all 0.25s ease;
    display: inline-block;
    color: var(--text-color);
    background: var(--button-color);
    border: 1px solid var(--button-color);
}

/* Hover */
.action-btn:hover {
    background: var(--button-color-dim);
    border-color: var(--button-color-dim);
}

/* Primary (same as main button color) */
.action-btn.primary {
    background: var(--button-color);
}

/* Danger */
.action-btn.danger {
    background: #c0392b;
    border-color: #c0392b;
}

.action-btn.danger:hover {
    background: #e74c3c;
    border-color: #e74c3c;
}

/* Warning */
.action-btn.warning {
    background: #f39c12;
    border-color: #f39c12;
}

.action-btn.warning:hover {
    background: #f1c40f;
    border-color: #f1c40f;
}
</style>

<script>
    
document.addEventListener("DOMContentLoaded", function () {
    const primaryPicker = document.getElementById("primaryColor");
    const primaryHoverPicker = document.getElementById("primaryHover");
    const dangerPicker = document.getElementById("dangerColor");
    const dangerHoverPicker = document.getElementById("dangerHover");
    const warningPicker = document.getElementById("warningColor");
    const warningHoverPicker = document.getElementById("warningHover");

    // Function to update CSS variable
    const updateVar = (varName, input) => {
        document.documentElement.style.setProperty(varName, input.value);
    }

    // Initialize variables on page load
    updateVar("--primary-color", primaryPicker);
    updateVar("--primary-hover", primaryHoverPicker);
    updateVar("--danger-color", dangerPicker);
    updateVar("--danger-hover", dangerHoverPicker);
    updateVar("--warning-color", warningPicker);
    updateVar("--warning-hover", warningHoverPicker);

    // Update on input change
    primaryPicker.addEventListener("input", () => updateVar("--primary-color", primaryPicker));
    primaryHoverPicker.addEventListener("input", () => updateVar("--primary-hover", primaryHoverPicker));

    dangerPicker.addEventListener("input", () => updateVar("--danger-color", dangerPicker));
    dangerHoverPicker.addEventListener("input", () => updateVar("--danger-hover", dangerHoverPicker));

    warningPicker.addEventListener("input", () => updateVar("--warning-color", warningPicker));
    warningHoverPicker.addEventListener("input", () => updateVar("--warning-hover", warningHoverPicker));
});



</script>
</div>
<div class="content">