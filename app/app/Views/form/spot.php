<form id="companyFormSpot" action="<?= site_url('company/add_details') ?>" method="post">
    <?= csrf_field() ?>

    <textarea id="excelPasteArea" placeholder="Paste from Excel here"></textarea>
    <button type="button" id="clearAllBtn">Clear All Data</button>

    <div class="company-row">
        <div class="field-group"><label>Entry Type</label><input type="text" name="companies[0][entry_type]"></div>

        <div class="field-group"><label>Database Name</label><input type="text" name="companies[0][database_name]"></div>
        <div class="field-group"><label>Category</label><input type="text" name="companies[0][category]"></div>
        <div class="field-group"><label>Source</label><input type="text" name="companies[0][source]"></div>
        <div class="field-group"><label>Updated By</label><input type="text" name="companies[0][updated_by]"></div>
        <div class="field-group"><label>Updated At</label><input type="datetime-local" name="companies[0][updated_at]"></div>
        <div class="field-group"><label>Outbound</label><input type="checkbox" name="companies[0][outbound]" value="1"></div>

        <div class="field-group"><label>Company Name</label><input type="text" name="companies[0][company_name]"></div>
        <div class="field-group"><label>Address 1</label><input type="text" name="companies[0][address_1]"></div>
        <div class="field-group"><label>Address 2</label><input type="text" name="companies[0][address_2]"></div>
        <div class="field-group"><label>City</label><input type="text" name="companies[0][city]"></div>
        <div class="field-group"><label>Pincode</label><input type="text" name="companies[0][pincode]"></div>
        <div class="field-group"><label>State</label><input type="text" name="companies[0][state]"></div>
        <div class="field-group"><label>Phone</label><input type="text" name="companies[0][phone]"></div>
        <div class="field-group"><label>Fax</label><input type="text" name="companies[0][fax]"></div>

        <!-- Contact 1 -->
        <div class="field-group"><label>Contact Name</label><input type="text" name="companies[0][contact1_name]"></div>
        <div class="field-group"><label>Designation</label><input type="text" name="companies[0][contact1_designation]"></div>
        <div class="field-group"><label>Mobile 1</label><input type="text" name="companies[0][contact1_mobile1]"></div>
        <div class="field-group"><label>Mobile 2</label><input type="text" name="companies[0][contact1_mobile2]"></div>
        <div class="field-group"><label>Mobile 3</label><input type="text" name="companies[0][contact1_mobile3]"></div>
        <div class="field-group"><label>Email 1</label><input type="text" name="companies[0][contact1_email1]"></div>
        <div class="field-group"><label>Email 2</label><input type="text" name="companies[0][contact1_email2]"></div>
        <div class="field-group"><label>Email 3</label><input type="text" name="companies[0][contact1_email3]"></div>

        <!-- Contact 2 -->
        <div class="field-group"><label>Contact Name 2</label><input type="text" name="companies[0][contact2_name]"></div>
        <div class="field-group"><label>Designation 2</label><input type="text" name="companies[0][contact2_designation]"></div>
        <div class="field-group"><label>Email 4</label><input type="text" name="companies[0][contact2_email1]"></div>
        <div class="field-group"><label>Email 5</label><input type="text" name="companies[0][contact2_email2]"></div>
        <div class="field-group"><label>Mobile 4</label><input type="text" name="companies[0][contact2_mobile1]"></div>
        <div class="field-group"><label>Mobile 5</label><input type="text" name="companies[0][contact2_mobile2]"></div>

        <!-- Contact 3 -->
        <div class="field-group"><label>Contact Name 3</label><input type="text" name="companies[0][contact3_name]"></div>
        <div class="field-group"><label>Designation 3</label><input type="text" name="companies[0][contact3_designation]"></div>
        <div class="field-group"><label>Email 6</label><input type="text" name="companies[0][contact3_email1]"></div>
        <div class="field-group"><label>Email 7</label><input type="text" name="companies[0][contact3_email2]"></div>
        <div class="field-group"><label>Mobile 6</label><input type="text" name="companies[0][contact3_mobile1]"></div>
        <div class="field-group"><label>Mobile 7</label><input type="text" name="companies[0][contact3_mobile2]"></div>

        <div class="field-actions">
            <button type="button" class="clearBtn">Clear</button>
            <button type="button" class="removeBtn">Remove</button>
        </div>
    </div>

    <button type="submit">Submit</button>
</form>


<!-- style for Company Side
 
<style>
form {
    width: 100%;
    overflow-x: auto;
    font-family: Arial, sans-serif;
}

textarea {
    width: 100%;
    min-height: 80px;
    margin-bottom: 10px;
    padding: 5px;
}

.company-row {
    display: flex;
    flex-wrap: nowrap; /* all fields in a single row */
    gap: 10px;
    align-items: flex-start;
    margin-bottom: 20px;
}

.field-group {
    display: flex;
    flex-direction: column;
    min-width: 120px; /* adjust field width */
}

.field-group label {
    font-size: 12px;
    font-weight: bold;
    margin-bottom: 2px;
}

.field-group input {
    padding: 3px 5px;
    font-size: 12px;
}

.field-actions {
    display: flex;
    gap: 5px;
    margin-left: 10px;
    align-items: flex-end;
}
</style> 



 <!-- Style For Tradevisitor  -->
<!--  

<style>
form {
    max-width: 800px;
    margin: 20px auto;
    font-family: Arial, sans-serif;
    padding: 15px;
    background: #f9f9f9;
    border: 1px solid #ddd;
    border-radius: 6px;
}

textarea {
    width: 100%;
    min-height: 80px;
    padding: 8px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-family: inherit;
    font-size: 14px;
}

.company-row {
    display: flex;
    flex-direction: column;
    gap: 12px;
    margin-bottom: 20px;
}

.field-group {
    display: flex;
    flex-direction: column;
}

.field-group label {
    margin-bottom: 4px;
    font-weight: bold;
    font-size: 13px;
}

.field-group input {
    padding: 6px 8px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-family: inherit;
}

.field-actions {
    display: flex;
    gap: 10px;
}

button {
    padding: 6px 12px;
    font-size: 14px;
    border: none;
    border-radius: 4px;
    background-color: #4CAF50;
    color: white;
    cursor: pointer;
}

button:hover {
    background-color: #45a049;
}

#clearAllBtn {
    background-color: #f44336;
}

#clearAllBtn:hover {
    background-color: #d32f2f;
}

h3 {
    margin: 15px 0 5px 0;
    font-size: 16px;
    font-weight: bold;
    border-bottom: 1px solid #ddd;
    padding-bottom: 3px;
}
</style>

 -->
