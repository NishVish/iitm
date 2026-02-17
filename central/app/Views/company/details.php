<?= view('header') ?>  <!-- loads app/Views/header.php -->

<style>
/* ===== Page Layout ===== */


h2, h3 {
    color: #2c3e50;
    margin-top: 20px;
    margin-bottom: 10px;
}

/* ===== Flex Container for Company & Contacts ===== */
.container {
    display: flex;
    gap: 20px;
    flex-wrap: wrap; /* for smaller screens */
}

.box {
    flex: 1 1 45%;
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.08);
}

/* ===== Form Inputs ===== */
input[type="text"],
input[type="number"],
input[type="date"],
input[type="datetime-local"],
select {
    width: auto;
    padding: 6px 8px;
    margin: 2px 4px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 13px;
    box-sizing: border-box;
}

/* Inputs in H2 inline fields */
h2 input {
    width: auto;
    min-width: 80px;
}

/* ===== Buttons ===== */
button {
    padding: 6px 12px;
    border: none;
    border-radius: 4px;
    font-size: 13px;
    cursor: pointer;
    transition: 0.2s;
}

button:hover {
    opacity: 0.9;
}

.btn-primary {
    background-color: #28a745;
    color: #fff;
}

#openLeadFormBtn {
    background-color: #007bff;
    color: #fff;
    margin-bottom: 10px;
}

/* ===== Lists ===== */
ul {
    padding-left: 20px;
    margin-bottom: 10px;
}

/* ===== Lead Cards ===== */
.lead-container {
    display: flex;
    gap: 16px;
    flex-wrap: wrap;
}

.lead-card {
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 12px 16px;
    min-width: 220px;
    background: #fff;
    box-shadow: 0 2px 6px rgba(0,0,0,0.08);
}

/* ===== Modal ===== */
#leadModal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    display: none; /* hidden by default */
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

.modal-content {
    background: #fff;
    padding: 20px 25px;
    border-radius: 8px;
    width: 400px;
    max-width: 90%;
    position: relative;
    box-shadow: 0 5px 15px rgba(0,0,0,0.3);
}

.close-btn {
    position: absolute;
    top: 10px;
    right: 15px;
    font-size: 20px;
    font-weight: bold;
    cursor: pointer;
}

/* ===== Updation History ===== */
#updates div {
    background: #f7f7f7;
    padding: 10px;
    border-radius: 4px;
    margin-bottom: 8px;
}

#updates hr {
    margin: 8px 0;
}

/* ===== Responsive ===== */
@media (max-width: 900px) {
    .container {
        flex-direction: column;
    }

    .box {
        width: 100%;
    }
}


.company-header {
    background: #fff;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    display: flex;
    flex-direction: column;
    gap: 15px;
    font-family: Arial, sans-serif;
}

/* Top row: ID + Label */
.company-top {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 14px;
}

/* Company Name big */
.company-name input.inline-edit {
    font-size: 20px;
    font-weight: 600;
    width: 100%;
    border: none;
    border-bottom: 2px solid #ccc;
    background: transparent;
    padding: 2px 4px;
}

.company-name input.inline-edit:focus {
    border-color: #a82324;
    outline: none;
}

/* Address / Location row */
.company-location {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.company-location input.inline-edit {
    border: none;
    border-bottom: 2px solid #ccc;
    background: transparent;
    padding: 2px 6px;
    transition: border-color 0.2s;
}

.company-location input.inline-edit:focus {
    border-color: #a82324;
    outline: none;
}

/* Contact / GST */
.company-contact {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 15px;
    font-size: 14px;
}

.company-contact input.inline-edit {
    border: none;
    border-bottom: 2px solid #ccc;
    background: transparent;
    padding: 2px 6px;
    transition: border-color 0.2s;
}

.company-contact input.inline-edit:focus {
    border-color: #a82324;
    outline: none;
}

</style>

<?php
$categoryMap = [
    'Travel Agent' => 'TA',
    'Hotel'        => 'H',
    'Restaurant'   => 'R',
    'Airline'      => 'A'
];

$category = esc($company['category']);
$label = $categoryMap[$category] ?? '';
?>


<div class="container">

  <!-- ================= COMPANY DETAILS ================= -->

<div class="box left">

<div class="company-card">

<div class="company-header">
    <div class="company-top">
        <p>
            <h1>
                            <?= esc($category ?? 'No Category') ?> | 

            <strong><?= esc($company['company_name']) ?></strong> | 
            <?= esc($company['city']) ?>

            </h1>

        </p>
    </div>

    <div class="company-location">
        <p>
            <?= esc($company['address']) ?>, 
            <?= esc($company['city']) ?>, 
            <?= esc($company['state']) ?> - <?= esc($company['pincode']) ?>
        </p>
    </div>

    <div class="company-contact">
        <p>
            Phone: <?= esc($company['phone']) ?> | 
            GST: <?= esc($company['gst_number']) ?>
        </p>
    </div>
</div>

<hr>

<h3>Sources</h3>
<table style="width:100%; text-align:left; border-collapse: collapse;">
    <thead>
        <tr>
            <th>Source ID</th>
            <th>Event Date</th>
            <th>Notes</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($sources as $source): ?>
        <tr>
            <td><?= esc($source['source_id']) ?></td>
            <td><?= esc($source['event_date']) ?></td>
            <td><?= esc($source['notes']) ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
              <!-- Button to open comparison window -->
<button type="button" onclick="openComparison()">Compare Changes</button>

<!-- Hidden Comparison Overlay -->
<div id="comparisonOverlay" style="
    display:none;
    position:fixed;
    top:0; left:0;
    width:100%; height:100%;
    background:rgba(0,0,0,0.7);
    z-index:9999;
    overflow:auto;
    padding:50px 20px;
">
    <div style="
        background:#fff; 
        max-width:1000px; 
        margin:0 auto; 
        padding:20px; 
        border-radius:10px;
        display:flex;
        gap:20px;
    ">
        <!-- Original Values -->
        <div style="flex:1; border-right:1px solid #ccc; padding-right:20px;">
            <h3>Original</h3>
            <p><strong>Category:</strong> <?= esc($label ?? '-') ?></p>
            <p><strong>Company:</strong> <?= esc($company['company_name']) ?></p>
            <p><strong>City:</strong> <?= esc($company['city']) ?></p>
            <p><strong>Address:</strong> <?= esc($company['address']) ?></p>
            <p><strong>Pincode:</strong> <?= esc($company['pincode']) ?></p>
            <p><strong>State:</strong> <?= esc($company['state']) ?></p>
            <p><strong>Phone:</strong> <?= esc($company['phone']) ?></p>
            <p><strong>GST:</strong> <?= esc($company['gst_number']) ?></p>

            <h4>Sources</h4>
            <ul>
            <?php foreach ($sources as $source): ?>
                <li>
                    <strong>ID:</strong> <?= esc($source['source_id']) ?> |
                    <strong>Date:</strong> <?= esc($source['event_date']) ?> |
                    <strong>Notes:</strong> <?= esc($source['notes']) ?>
                </li>
            <?php endforeach; ?>
            </ul>
        </div>

        <!-- Editable Inputs -->
        <div style="flex:1; padding-left:20px;">
            <h3>Editable</h3>
            <div class="company-header-hidden">
                <input type="text" name="label" value="<?= esc($label ?? '') ?>" placeholder="Category"><br>
                <input type="text" name="company_name" value="<?= esc($company['company_name']) ?>" placeholder="Company Name"><br>
                <input type="text" name="city" value="<?= esc($company['city']) ?>" placeholder="City"><br>

                <input type="text" name="address" value="<?= esc($company['address']) ?>" placeholder="Address"><br>
                <input type="text" name="pincode" value="<?= esc($company['pincode']) ?>" placeholder="Pincode"><br>
                <input type="text" name="state" value="<?= esc($company['state']) ?>" placeholder="State"><br>
                <input type="text" name="phone" value="<?= esc($company['phone']) ?>" placeholder="Phone"><br>
                <input type="text" name="gst_number" value="<?= esc($company['gst_number']) ?>" placeholder="GST Number"><br>
            </div>

            <h4>Sources</h4>
            <ul class="sources-list" style="list-style:none; padding:0;">
            <?php foreach ($sources as $i => $source): ?>
                <li style="margin-bottom:10px;">
                    <input type="hidden" name="sources[<?= $i ?>][id]" value="<?= $source['id'] ?>">
                    <input type="number" name="sources[<?= $i ?>][source_id]" value="<?= esc($source['source_id']) ?>" placeholder="Source ID">
                    <input type="date" name="sources[<?= $i ?>][event_date]" value="<?= esc($source['event_date']) ?>">
                    <input type="text" name="sources[<?= $i ?>][notes]" value="<?= esc($source['notes']) ?>" placeholder="Notes">
                </li>
            <?php endforeach; ?>
            </ul>

            <div class="save-section">
                <button type="submit">Save Changes</button>
                <button type="button" onclick="closeComparison()">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
function openComparison() {
    document.getElementById('comparisonOverlay').style.display = 'block';
}

function closeComparison() {
    document.getElementById('comparisonOverlay').style.display = 'none';
}
</script>

</div>

</div>

  <div class="box right">
<!-- ================= CONTACT DETAILS ================= -->
<h3></h3>
<br><br>



<?php if (!empty($contacts)): ?>
   <?php foreach($contacts as $contact): ?>
    <p>id - <?= $contact['contact_id'] ?>
        <?= $contact['name'] ?> (<?= $contact['designation'] ?>)<br>
        Mobiles: <?= !empty($contact['mobiles']) ? implode(', ', $contact['mobiles']) : 'N/A' ?><br>
        Emails: <?= !empty($contact['emails']) ? implode(', ', $contact['emails']) : 'N/A' ?>
    </p>
<?php endforeach; ?>

<?php else: ?>
    <p>No contacts found.</p>
<?php endif; ?>




<!-- Button to open contact comparison -->
<button type="button" onclick="openContactComparison()">Compare Contacts</button>

<!-- Hidden Contact Comparison Overlay -->
<div id="contactOverlay" style="
    display:none;
    position:fixed;
    top:0; left:0;
    width:100%; height:100%;
    background:rgba(0,0,0,0.7);
    z-index:9999;
    overflow:auto;
    padding:50px 20px;
">
    <div style="
        background:#fff; 
        max-width:900px; 
        margin:0 auto; 
        padding:20px; 
        border-radius:10px;
        display:flex;
        gap:20px;
    ">
        <!-- Original Contacts -->
        <div style="flex:1; border-right:1px solid #ccc; padding-right:20px;">
            <h3>Original Contacts</h3>
            <?php if (!empty($contacts)): ?>
                <?php foreach($contacts as $contact): ?>
                    <p>
                        <strong>ID:</strong> <?= $contact['contact_id'] ?><br>
                        <strong>Name:</strong> <?= $contact['name'] ?><br>
                        <strong>Designation:</strong> <?= $contact['designation'] ?><br>
                        <strong>Mobiles:</strong> <?= !empty($contact['mobiles']) ? implode(', ', $contact['mobiles']) : 'N/A' ?><br>
                        <strong>Emails:</strong> <?= !empty($contact['emails']) ? implode(', ', $contact['emails']) : 'N/A' ?>
                    </p>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No contacts found.</p>
            <?php endif; ?>
        </div>

        <!-- Editable Contacts -->
        <div style="flex:1; padding-left:20px;">
            <h3>Editable Contacts</h3>
            <?php if (!empty($contacts)): ?>
                <?php foreach($contacts as $i => $contact): ?>
                    <div style="margin-bottom:15px; border-bottom:1px solid #ddd; padding-bottom:10px;">
                        <input type="hidden" name="contacts[<?= $i ?>][contact_id]" value="<?= $contact['contact_id'] ?>">

                        <label>Name:</label>
                        <input type="text" name="contacts[<?= $i ?>][name]" value="<?= $contact['name'] ?>" placeholder="Name">

                        <label>Designation:</label>
                        <input type="text" name="contacts[<?= $i ?>][designation]" value="<?= $contact['designation'] ?>" placeholder="Designation">

                        <label>Mobiles:</label>
                        <input type="text" name="contacts[<?= $i ?>][mobile]" value="<?= !empty($contact['mobiles']) ? implode(', ', $contact['mobiles']) : '' ?>" placeholder="Mobiles">

                        <label>Emails:</label>
                        <input type="text" name="contacts[<?= $i ?>][email]" value="<?= !empty($contact['emails']) ? implode(', ', $contact['emails']) : '' ?>" placeholder="Emails">
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No contacts to edit.</p>
            <?php endif; ?>

            <div class="save-section" style="margin-top:10px;">
                <button type="submit">Save Changes</button>
                <button type="button" onclick="closeContactComparison()">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
function openContactComparison() {
    document.getElementById('contactOverlay').style.display = 'block';
}

function closeContactComparison() {
    document.getElementById('contactOverlay').style.display = 'none';
}
</script>






</div>
</div>




<!-- ================= UPDATION DETAILS ================= -->
<h3>Updation History</h3>

<?php if (!empty($updates)): ?>
    <?php foreach ($updates as $u): ?>
        <div>
            <strong><?= esc($u['updated_by']) ?></strong><br>
            <?= esc($u['comment']) ?><br>
            <small><?= esc($u['created_at']) ?></small>
        </div>
        <hr>
    <?php endforeach; ?>
<?php else: ?>
    <p>No updates available.</p>
<?php endif; ?>

<hr>

<!-- ================= LEAD DETAILS ================= -->
<!-- ================= LEAD DETAILS ================= -->
<h3>Leads</h3> 
<button id="openLeadFormBtn">Add Lead</button>

<a href="<?= base_url('lead/createQuick/' . $company['company_id']) ?>">
    Add Quick Lead
</a>



<!-- Existing leads (always visible) -->
<?php if (!empty($leads)): ?>
    <div class="lead-container">
        <?php foreach ($leads as $l): ?>
            <div class="lead-card">
                <div><strong>Lead ID:</strong> <?= esc($l['lead_id']) ?></div>
                <div><strong>Status:</strong> <?= esc($l['status']) ?></div>
                <div><strong>Payment:</strong> <?= esc($l['payment_status']) ?></div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>


<!-- ================= ADD LEAD MODAL ================= -->

<!-- Modal Overlay -->
<div id="leadModal" class="modal-overlay">
    <div class="modal-content">
        <span id="closeLeadFormBtn" class="close-btn">&times;</span>
        <h3>Add New Lead</h3>

        <form action="<?= site_url('leads/create') ?>" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="company_id" value="<?= esc($company['company_id']) ?>">

            <div class="form-group">
                <label for="exhibition_year">Exhibition Year</label>
                <input type="number" name="exhibition_year" id="exhibition_year" required>
            </div>

            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" name="location" id="location" maxlength="100" required>
            </div>

            <div class="form-group">
                <label for="size">Size</label>
                <input type="text" name="size" id="size" maxlength="50">
            </div>

            <div class="form-group">
                <label for="fascia">Fascia</label>
                <input type="text" name="fascia" id="fascia" maxlength="100">
            </div>

            <div class="form-group">
                <label for="stall_location">Stall Location</label>
                <input type="text" name="stall_location" id="stall_location" maxlength="100">
            </div>

            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" step="0.01" name="price" id="price">
            </div>

            <div class="form-group">
                <label for="sales_person">Sales Person</label>
                <input type="text" name="sales_person" id="sales_person" maxlength="100">
            </div>

            <div class="form-group">
                <label for="exhibitor">Exhibitor</label>
                <input type="text" name="exhibitor" id="exhibitor" maxlength="255">
            </div>

            <div class="form-group">
                <label for="booking_form">Booking Form</label>
                <input type="text" name="booking_form" id="booking_form" maxlength="255">
            </div>

            
            <label>Select Contact</label>
        <select id="contact_select" class="form-control">
            <option value="">-- Select Contact --</option>
            <?php foreach($contacts as $contact): ?>
                <option 
                    value="<?= esc($contact['contact_id']) ?>"
                    data-name="<?= esc($contact['name']) ?>">
                    <?= esc($contact['name']) ?> (<?= esc($contact['designation']) ?>)
                </option>
            <?php endforeach; ?>
        </select>
        
            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" id="status">
                    <option value="draft" selected>Draft</option>
                    <option value="confirmed">Confirmed</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>

            <div class="form-group">
                <label for="payment_status">Payment Status</label>
                <select name="payment_status" id="payment_status">
                    <option value="pending" selected>Pending</option>
                    <option value="paid">Paid</option>
                    <option value="refunded">Refunded</option>
                </select>
            </div>

            <div style="margin-top:15px; text-align:right;">
                <button type="submit" class="btn-submit">Create Lead</button>
            </div>
        </form>
    </div>
</div>
<script>
// Open modal
document.getElementById('openLeadFormBtn').addEventListener('click', function() {
    document.getElementById('leadModal').style.display = 'flex';
});

// Close modal
document.getElementById('closeLeadFormBtn').addEventListener('click', function() {
    document.getElementById('leadModal').style.display = 'none';
});

// Close modal if clicked outside content
window.addEventListener('click', function(e) {
    const modal = document.getElementById('leadModal');
    if (e.target === modal) {
        modal.style.display = 'none';
    }
});
</script>

