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

<form method="post" action="<?= site_url('company/update/' . $company['company_id']) ?>"
>
    <?= csrf_field() ?>

    <h2>
        <input type="text" name="company_id" value="<?= esc($company['company_id']) ?>" readonly style="width:120px;"> |
        <input type="text" name="label" value="<?= esc($label ?? '') ?>" style="width:120px;"> |
        <input type="text" name="company_name" value="<?= esc($company['company_name']) ?>">
        |
        <input type="text" name="city" value="<?= esc($company['city']) ?>" style="width:120px;">
        |
        <input type="text" name="state" value="<?= esc($company['state']) ?>" style="width:80px;">
    </h2>

    <h3>Sources</h3>

    <ul>
    <?php foreach ($sources as $i => $source): ?>
        <li>
            <input type="hidden" name="sources[<?= $i ?>][id]" value="<?= $source['id'] ?>">

            Source ID:
            <input type="number" name="sources[<?= $i ?>][source_id]"
                   value="<?= esc($source['source_id']) ?>" style="width:80px;">

            Event Date:
            <input type="date" name="sources[<?= $i ?>][event_date]"
                   value="<?= esc($source['event_date']) ?>">

            Notes:
            <input type="text" name="sources[<?= $i ?>][notes]"
                   value="<?= esc($source['notes']) ?>" style="width:300px;">
        </li>
    <?php endforeach; ?>
    </ul>

    <p>
        <strong>Phone:</strong>
        <input type="text" name="phone" value="<?= esc($company['phone']) ?>">

        | <strong>GST:</strong>
        <input type="text" name="gst_number" value="<?= esc($company['gst_number']) ?>">
    </p>

    <button type="submit" class="btn btn-primary">💾 Save Changes</button>
</form>

<hr>
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
<div id="leadModal" style="display: none;">
    <div class="modal-content">
        <span id="closeLeadFormBtn" class="close-btn">&times;</span>
        <h3>Add New Lead</h3>

        <form action="<?= site_url('leads/create') ?>" method="post">
            <?= csrf_field() ?>
            <!-- Pre-fill company ID -->
            <input type="hidden" name="company_id" value="<?= esc($company['company_id']) ?>">

            <div>
                <label for="exhibition_year">Exhibition Year</label>
                <input type="number" name="exhibition_year" id="exhibition_year" required>
            </div>

            <div>
                <label for="location">Location</label>
                <input type="text" name="location" id="location" maxlength="100" required>
            </div>

            <div>
                <label for="size">Size</label>
                <input type="text" name="size" id="size" maxlength="50">
            </div>

            <div>
                <label for="fascia">Fascia</label>
                <input type="text" name="fascia" id="fascia" maxlength="100">
            </div>

            <div>
                <label for="stall_location">Stall Location</label>
                <input type="text" name="stall_location" id="stall_location" maxlength="100">
            </div>

            <div>
                <label for="price">Price</label>
                <input type="number" step="0.01" name="price" id="price">
            </div>

            <div>
                <label for="sales_person">Sales Person</label>
                <input type="text" name="sales_person" id="sales_person" maxlength="100">
            </div>

            <div>
                <label for="exhibitor">Exhibitor</label>
                <input type="text" name="exhibitor" id="exhibitor" maxlength="255">
            </div>

            <div>
                <label for="booking_form">Booking Form</label>
                <input type="text" name="booking_form" id="booking_form" maxlength="255">
            </div>

            <div>
                <label for="status">Status</label>
                <select name="status" id="status">
                    <option value="draft" selected>Draft</option>
                    <option value="confirmed">Confirmed</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>

            <div>
                <label for="payment_status">Payment Status</label>
                <select name="payment_status" id="payment_status">
                    <option value="pending" selected>Pending</option>
                    <option value="paid">Paid</option>
                    <option value="refunded">Refunded</option>
                </select>
            </div>

            <div style="margin-top:10px;">
                <button type="submit">Create Lead</button>
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

