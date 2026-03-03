<!-- view.php -->
<?php include(APPPATH . 'Views/header.php'); ?>



<!-- Companies Section -->
<!-- Companies Section -->
<?php 
$segment1 = service('uri')->getSegment(1);




if ($segment1 == 'company') : ?>
<div class="submenu">
    <a href="<?= base_url('company') ?>">View Companies</a>
<a href="<?= base_url('company/operation') ?>" >Operation</a>

    <a href="<?= base_url('company/add') ?>">Add Company</a>
    <a href="<?= base_url('company/addexhibitor') ?>">Add Exhibitor</a>
    <a href="<?= base_url('company/stats') ?>">Stats</a>
    <h2>

</h2>
    <?php if (isset($user_type) && ($user_type === 'admin' || $user_type === 'superuser')): ?>
        


       <!-- Container for the form -->
<div id="clearDatabaseContainer" style="display:inline-block;">
    <select id="databaseDropdown" required>
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
        <a href="<?= site_url('crossvalidation/crossValidate') ?>" class="action-btn primary">Company Cross Validation</a>
        <a href="<?= site_url('company/dummy') ?>" class="action-btn primary">Insert Data</a>
        <a href="<?= site_url('crossvalidation/crossValidateContact') ?>" class="action-btn primary">Contact Cross Validation</a>

        <a href="<?= site_url('crossvalidation/clear') ?>" class="action-btn warning">Clear Matches</a>
        <a href="<?= site_url('crossvalidation/clearcontact') ?>" class="action-btn warning">Clear Contact Matches</a>
<!-- 
        <div class="compact-customizer">
            <style>
                .compact-customizer {
                    display: inline-grid; /* Container only takes space it needs */
                    grid-template-columns: auto auto; /* Two perfect columns based on content */
                    align-items: center;
                    gap: 8px 15px; /* Vertical and horizontal spacing */
                    padding: 12px;
                    background: #fff;
                    border: 1px solid #ddd;
                    border-radius: 8px;
                    font-family: system-ui, sans-serif;
                }

                .compact-customizer label {
                    font-size: 13px;
                    color: #444;
                    white-space: nowrap; /* Prevents text from wrapping */
                }

                .input-box {
                    display: flex;
                    align-items: center;
                    gap: 5px;
                    border: 1px solid #eee;
                    padding: 2px 5px;
                    border-radius: 4px;
                }

                .input-box input[type="color"] {
                    border: none;
                    width: 22px;
                    height: 22px;
                    cursor: pointer;
                    background: none;
                    padding: 0;
                }

                .input-box span {
                    font-family: monospace;
                    font-size: 11px;
                    color: #888;
                }

                #compareBtn {
                    grid-column: span 2; /* Spans across both columns */
                    margin-top: 5px;
                    padding: 8px;
                    background: #486887;
                    color: white;
                    border: none;
                    border-radius: 4px;
                    cursor: pointer;
                    font-size: 13px;
                }
            </style>

            <label>Primary</label>
            <div class="input-box">
                <input type="color" id="primaryColor" value="#486887" oninput="updateHex(this)">
                <span>#486887</span>
            </div>

            <label>P-Hover</label>
            <div class="input-box">
                <input type="color" id="primaryHover" value="#6c93bc" oninput="updateHex(this)">
                <span>#6C93BC</span>
            </div>

            <label>Danger</label>
            <div class="input-box">
                <input type="color" id="dangerColor" value="#ab7a7f" oninput="updateHex(this)">
                <span>#AB7A7F</span>
            </div>

            <label>D-Hover</label>
            <div class="input-box">
                <input type="color" id="dangerHover" value="#a71d2a" oninput="updateHex(this)">
                <span>#A71D2A</span>
            </div>

            <button type="button" id="compareBtn">Apply Theme</button>
        </div>

        <script>
            function updateHex(picker) {
                picker.nextElementSibling.innerText = picker.value.toUpperCase();
            }
        </script> -->
    <?php endif; ?>

    
<?php endif; ?>
</div>

<style>
    :root {
    --primary-color: #4a90e2;    /* softer blue */
    --primary-hover: #357ab8;    /* slightly darker on hover */

    --danger-color: #d66a6a;     /* muted red */
    --danger-hover: #b04e4e;     /* darker muted red on hover */

    --warning-color: #f0b450;    /* soft amber */
    --warning-hover: #d69c39;    /* darker amber on hover */

    --btn-text-color: #ffffff;   /* white text stays */
}

.action-btn {
    padding: 8px 14px;
    border-radius: 8px;
    text-decoration: none;
    font-size: 13px;
    font-weight: 600;
    transition: all 0.3s ease;
    display: inline-block;
    color: var(--btn-text-color);
}

/* Primary */
.action-btn.primary {
    background: var(--primary-color);
}

.action-btn.primary:hover {
    background: var(--primary-hover);
}

/* Danger */
.action-btn.danger {
    background: var(--danger-color);
}

.action-btn.danger:hover {
    background: var(--danger-hover);
}

/* Warning */
.action-btn.warning {
    background: var(--warning-color);
}

.action-btn.warning:hover {
    background: var(--warning-hover);
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