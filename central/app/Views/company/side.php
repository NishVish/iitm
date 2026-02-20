<?= view('header') ?>


<?php
$segment1 = service('uri')->getSegment(1);
?>
<!-- Companies Section -->
<!-- Companies Section -->
<?php if ($segment1 == 'company') : ?>
<div class="submenu">
    <a href="<?= base_url('company') ?>">View Companies</a>
    <a href="<?= base_url('company/add') ?>">Add Company</a>
    <a href="<?= base_url('company/stats') ?>">Stats</a>
    
    <a href="<?= site_url('clear-matching') ?>" class="action-btn danger">Clear Matching</a>
    <a href="<?= site_url('clear-contacts') ?>" class="action-btn danger">Clear Contacts</a>
    <a href="<?= site_url('clear-companies') ?>" class="action-btn danger">Clear Companies</a>

    <a href="<?= site_url('crossvalidation/crossValidate') ?>" class="action-btn primary">Company Cross Validation</a>
    <a href="<?= site_url('company/dummy') ?>" class="action-btn primary">Insert Data</a>
    <a href="<?= site_url('crossvalidation/crossValidateContact') ?>" class="action-btn primary">Contact Cross Validation</a>

    <a href="<?= site_url('crossvalidation/clear') ?>" class="action-btn warning">Clear Matches</a>
    <a href="<?= site_url('crossvalidation/clearcontact') ?>" class="action-btn warning">Clear Contact Matches</a>

    <!-- Color Pickers -->
    <div style="margin-top:10px;">
        <label>Primary Color:</label>
        <input type="color" id="primaryColor" value="#486887">

        <label>Primary Hover:</label>
        <input type="color" id="primaryHover" value="#6c93bc">

        <label>Danger Color:</label>
        <input type="color" id="dangerColor" value="#ab7a7f">

        <label>Danger Hover:</label>
        <input type="color" id="dangerHover" value="#a71d2a">

        <label>Warning Color:</label>
        <input type="color" id="warningColor" value="#ff9800">

        <label>Warning Hover:</label>
        <input type="color" id="warningHover" value="#e68900">
    </div>

    <button type="button" id="compareBtn">Compare Selected</button>
</div>
<?php endif; ?>

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