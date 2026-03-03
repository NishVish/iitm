<?= view('header') ?>


<?php
$segment1 = service('uri')->getSegment(1);
?>
<!-- Companies Section -->
<!-- Companies Section -->
<?php if ($segment1 == 'registration') : ?>
<div class="submenu">
        <a href="<?= base_url('registration/view/tradevisitor') ?>">Visitors</a>
    <a href="<?= base_url('registration/publicformtv') ?>">TV Form Only</a>
    <a href="<?= base_url('registration/publicformex') ?>">Exhibitor Form Only</a>
    <a href="<?= base_url('registration/publicformspot') ?>">Spot Form Only</a>
    <a href="<?= base_url('registration/spotinterface/1') ?>"> Spot Interface</a>
    
    <div style="margin-top:20px;">
        <button type="button" id="registerBtnexhibitor" class="btn btn-primary">
            Register as Exhibitor
        </button>

        <button type="button" id="registerBtntradetest" class="btn btn-success">
            Register as Trade Visitor
        </button>
        <button type="button" id="registerBtnspottest" class="btn btn-success">
           Spot Test
        </button>
    </div>
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
<script>
function applyButtonColors() {
    const primary = document.getElementById("primaryColor").value;
    const primaryHover = document.getElementById("primaryHover").value;
    const danger = document.getElementById("dangerColor").value;
    const dangerHover = document.getElementById("dangerHover").value;
    const warning = document.getElementById("warningColor").value;
    const warningHover = document.getElementById("warningHover").value;

    const exhibitorBtn = document.getElementById("registerBtnexhibitor");
    const tradeBtn = document.getElementById("registerBtntradetest");
    const spotBtn = document.getElementById("registerBtnspottest");

    // Primary Button
    exhibitorBtn.style.backgroundColor = primary;
    exhibitorBtn.style.borderColor = primary;
    exhibitorBtn.onmouseover = () => exhibitorBtn.style.backgroundColor = primaryHover;
    exhibitorBtn.onmouseout = () => exhibitorBtn.style.backgroundColor = primary;

    // Danger Button
    tradeBtn.style.backgroundColor = danger;
    tradeBtn.style.borderColor = danger;
    tradeBtn.onmouseover = () => tradeBtn.style.backgroundColor = dangerHover;
    tradeBtn.onmouseout = () => tradeBtn.style.backgroundColor = danger;

    // Warning Button
    spotBtn.style.backgroundColor = warning;
    spotBtn.style.borderColor = warning;
    spotBtn.onmouseover = () => spotBtn.style.backgroundColor = warningHover;
    spotBtn.onmouseout = () => spotBtn.style.backgroundColor = warning;
}

// Listen for color changes
document.querySelectorAll("input[type='color']").forEach(input => {
    input.addEventListener("input", applyButtonColors);
});

// Apply once on load
applyButtonColors();
</script>
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


<script>
document.addEventListener("DOMContentLoaded", function () {

    // const registerBtntradetest = document.getElementById("registerBtntradetest");
    // const companyFormTv = document.getElementById("companyFormTv");

    // registerBtntradetest.addEventListener("click", function () {

    //     console.log("Button clicked"); // 🔎 check in browser console

    //     // 🔹 Insert dummy data
    //     companyFormTv.querySelector('[name="companies[0][company_name]"]').value = "Test Company Pvt Ltd";
    //     companyFormTv.querySelector('[name="companies[0][address_1]"]').value = "123 Test Street";
    //     companyFormTv.querySelector('[name="companies[0][city]"]').value = "Ahmedabad";
    //     companyFormTv.querySelector('[name="companies[0][state]"]').value = "Gujarat";
    //     companyFormTv.querySelector('[name="companies[0][pincode]"]').value = "380001";
    //     companyFormTv.querySelector('[name="companies[0][phone]"]').value = "9876543210";

    //     companyFormTv.querySelector('[name="companies[0][contact1_name]"]').value = "John Doe";
    //     companyFormTv.querySelector('[name="companies[0][contact1_designation]"]').value = "Manager";
    //     companyFormTv.querySelector('[name="companies[0][contact1_email1]"]').value = "john@test.com";
    //     companyFormTv.querySelector('[name="companies[0][contact1_mobile1]"]').value = 7909075195;

    //     companyFormTv.querySelector('[name="companies[0][database_name]"]').value = "onlineregistrationtradevisitor";
    //     companyFormTv.querySelector('[name="companies[0][category]"]').value = "TradeVisitor";
    //     companyFormTv.querySelector('[name="companies[0][source]"]').value = "tradevisitor";
    //     companyFormTv.querySelector('[name="companies[0][updated_by]"]').value = "System";
    //     companyFormTv.querySelector('[name="companies[0][updated_at]"]').value = new Date().toISOString().slice(0,16);

    //     // 🔹 Submit hidden form
    //     companyFormTv.submit();

    // });

    const registerBtnexhibitor = document.getElementById("registerBtnexhibitor");
    const companyFormEx = document.getElementById("companyFormEx");

    registerBtnexhibitor.addEventListener("click", function () {

        console.log("Exhibitor clicked"); // 🔎 check in browser console

        // 🔹 Insert dummy data
        companyFormEx.querySelector('[name="companies[0][company_name]"]').value = "Test Company Pvt Ltd";
        companyFormEx.querySelector('[name="companies[0][address_1]"]').value = "123 Test Street";
        companyFormEx.querySelector('[name="companies[0][city]"]').value = "Ahmedabad";
        companyFormEx.querySelector('[name="companies[0][state]"]').value = "Gujarat";
        companyFormEx.querySelector('[name="companies[0][pincode]"]').value = "380001";
        companyFormEx.querySelector('[name="companies[0][phone]"]').value = "9876543210";

        companyFormEx.querySelector('[name="companies[0][contact1_name]"]').value = "John Doe";
        companyFormEx.querySelector('[name="companies[0][contact1_designation]"]').value = "Manager";
        companyFormEx.querySelector('[name="companies[0][contact1_email1]"]').value = "john@test.com";
        companyFormTv.querySelector('[name="companies[0][contact1_mobile1]"]').value = 7909075195;

        companyFormEx.querySelector('[name="companies[0][database_name]"]').value = "onlineregistrationexhibitor";
        companyFormEx.querySelector('[name="companies[0][category]"]').value = "";
        companyFormEx.querySelector('[name="companies[0][source]"]').value = "exhibitor";
        companyFormEx.querySelector('[name="companies[0][updated_by]"]').value = "System";
        companyFormEx.querySelector('[name="companies[0][updated_at]"]').value = new Date().toISOString().slice(0,16);

    companyFormEx.querySelector('[name="companies[0][fascia]"]').value = "Standard Fascia";
    // companyFormEx.querySelector('[name="companies[0][location]"]').value = "[Mumbai,Pune,Chennai]";
// 🔹 Grab all checked "Interested In" checkboxes (REAL selection)
        const selectedCheckboxes = companyFormEx.querySelectorAll('input[name="companies[0][interested_in][]"]:checked');
        const selectedValues = Array.from(selectedCheckboxes).map(cb => cb.value);

        // 🔹 Set hidden location input dynamically
        companyFormEx.querySelector('[name="companies[0][location]"]').value = selectedValues.join(',');





    companyFormEx.querySelector('[name="companies[0][size]"]').value = "3x3";
    companyFormEx.querySelector('[name="companies[0][price]"]').value = "1000.00";
    companyFormEx.querySelector('[name="companies[0][gst_amount]"]').value = "180.00";
    companyFormEx.querySelector('[name="companies[0][discount_amount]"]').value = "50.00";
    companyFormEx.querySelector('[name="companies[0][grand_total]"]').value = "1130.00";
        // 🔹 Submit hidden form
        companyFormEx.submit();

    });

    const registerBtnspottest = document.getElementById("registerBtnspottest");
    const companyFormspot = document.getElementById("companyFormSpot");

    registerBtnspottest.addEventListener("click", function () {

        console.log("Spot clicked"); // 🔎 check in browser console

        // 🔹 Insert dummy data
        companyFormspot.querySelector('[name="companies[0][company_name]"]').value = "Test Company Pvt Ltd";
        companyFormspot.querySelector('[name="companies[0][address_1]"]').value = "123 Test Street";
        companyFormspot.querySelector('[name="companies[0][city]"]').value = "Ahmedabad";
        companyFormspot.querySelector('[name="companies[0][state]"]').value = "Gujarat";
        companyFormspot.querySelector('[name="companies[0][pincode]"]').value = "380001";
        companyFormspot.querySelector('[name="companies[0][phone]"]').value = "9876543210";

        companyFormspot.querySelector('[name="companies[0][contact1_name]"]').value = "John Doe";
        companyFormspot.querySelector('[name="companies[0][contact1_designation]"]').value = "Manager";
        companyFormspot.querySelector('[name="companies[0][contact1_email1]"]').value = "john@test.com";
        companyFormspot.querySelector('[name="companies[0][contact1_mobile1]"]').value = 7909075195;

        companyFormspot.querySelector('[name="companies[0][database_name]"]').value = "onlineregistrationtradevisitor";
        companyFormspot.querySelector('[name="companies[0][category]"]').value = "";
        companyFormspot.querySelector('[name="companies[0][source]"]').value = "Spot";
        companyFormspot.querySelector('[name="companies[0][updated_by]"]').value = "System";
        companyFormspot.querySelector('[name="companies[0][updated_at]"]').value = new Date().toISOString().slice(0,16);

        // 🔹 Submit hidden form
        companyFormspot.submit();

    });

});
</script>
</div>
<div class="content">