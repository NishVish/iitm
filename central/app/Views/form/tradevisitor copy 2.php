<style>
    /* Container & Reset */
    #companyFormMobile {
        max-width: 500px;
        margin: 0 auto;
        padding: 15px;
        font-family: sans-serif;
        background: #f9f9f9;
    }

    /* Grouping fields into logical sections */
    .form-section {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    .section-title {
        font-size: 1.1rem;
        font-weight: bold;
        margin-bottom: 15px;
        color: #333;
        border-bottom: 2px solid #eee;
        padding-bottom: 5px;
    }

    /* Layout for individual fields */
    .field-group {
        display: flex;
        flex-direction: column;
        margin-bottom: 12px;
    }

    .field-group label {
        font-size: 0.9rem;
        margin-bottom: 5px;
        color: #666;
    }

    .field-group input[type="text"],
    .field-group input[type="tel"],
    .field-group input[type="email"],
    #excelPasteArea {
        width: 100%;
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px; /* Prevents iOS auto-zoom on focus */
        box-sizing: border-box;
    }

    #excelPasteArea {
        height: 80px;
        margin-bottom: 10px;
    }

    /* Checkbox styling */
    .checkbox-group {
        flex-direction: row;
        align-items: center;
        gap: 10px;
    }

    .checkbox-group input {
        width: 20px;
        height: 20px;
    }

    /* Buttons */
    .btn-mobile {
        width: 100%;
        padding: 15px;
        border: none;
        border-radius: 5px;
        font-weight: bold;
        font-size: 1rem;
        margin-bottom: 10px;
        cursor: pointer;
    }

    .btn-submit { background-color: #28a745; color: white; }
    .btn-clear { background-color: #6c757d; color: white; }
    .btn-test { background-color: #ffc107; color: #212529; }
    .btn-remove { background-color: #dc3545; color: white; }

</style>

<form id="companyFormMobile" action="<?= site_url('company/add_details') ?>" method="post">
    <?= csrf_field() ?>

    <div class="form-section">
        <label for="excelPasteArea"><strong>Quick Import</strong></label>
        <textarea id="excelPasteArea" placeholder="Paste from Excel here..."></textarea>
        <button type="button" id="clearAllBtn" class="btn-mobile btn-clear">Clear All Data</button>
    </div>

    <div class="company-row">
        <div class="form-section">
            <div class="section-title">General Info</div>
            <div class="field-group"><label>Entry Type</label><input type="text" name="companies[0][entry_type]"></div>
            <div class="field-group"><label>Database Name</label><input type="text" name="companies[0][database_name]"></div>
            <div class="field-group checkbox-group">
                <input type="checkbox" id="outbound0" name="companies[0][outbound]" value="1">
                <label for="outbound0">Outbound</label>
            </div>
            <div class="field-group"><label>Comments</label><input type="text" name="companies[0][comments]"></div>
        </div>

        <div class="form-section">
            <div class="section-title">Company Address</div>
            <div class="field-group"><label>Company Name</label><input type="text" name="companies[0][company_name]"></div>
            <div class="field-group"><label>Address 1</label><input type="text" name="companies[0][address_1]"></div>
            <div class="field-group"><label>City</label><input type="text" name="companies[0][city]"></div>
            <div class="field-group"><label>Pincode</label><input type="tel" name="companies[0][pincode]"></div>
            <div class="field-group"><label>Phone</label><input type="tel" name="companies[0][phone]"></div>
        </div>

        <div class="form-section" style="border-left: 4px solid #007bff;">
            <div class="section-title">Primary Contact</div>
            <div class="field-group"><label>Name</label><input type="text" name="companies[0][contact1_name]"></div>
            <div class="field-group"><label>Mobile</label><input type="tel" name="companies[0][contact1_mobile1]"></div>
            <div class="field-group"><label>Email</label><input type="email" name="companies[0][contact1_email1]"></div>
        </div>

        <div class="form-section">
            <div class="section-title">Secondary Contacts</div>
            <div class="field-group"><label>Contact Name 2</label><input type="text" name="companies[0][contact2_name]"></div>
            <div class="field-group"><label>Mobile 2</label><input type="tel" name="companies[0][contact2_mobile1]"></div>
        </div>

        <button type="button" class="btn-mobile btn-remove">Remove This Company</button>
    </div>

    <button type="submit" class="btn-mobile btn-submit">Submit Details</button>
    
    <div style="margin-top: 20px;">
        <button type="button" class="btn-mobile btn-test" id="fillDummyBtn">Fill Dummy Data</button>
        <button type="button" class="btn-mobile btn-test" id="registerBtntradetest">Test Register</button>
    </div>
</form>