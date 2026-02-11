<?php 
$step = 2;
include 'header3.php'; 
?>

<title>General Details</title>

<style>
/* Layout */
.form-row {
  display: flex;
  gap: 20px;
  flex-wrap: wrap;
  margin-top: 20px;
}

.card {
  flex: 1;
  min-width: 300px;
  padding: 20px;
  border: 1px solid #ddd;
  border-radius: 8px;
  background: #f9f9f9;
}

/* Contact item */
.contact-item {
  border-bottom: 1px solid #ccc;
  margin-bottom: 10px;
  padding-bottom: 10px;
}

/* Inputs */
.input-full {
  width: 100%;
  padding: 6px 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

.company-title {
  width: 100%;
  font-size: 18px;
  padding: 6px 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
}


</style>

<h2>Step 2: Confirm Company & Contact Details</h2>

<form method="post" action="<?= site_url('company/update/'.$company['company_id']) ?>">
<?= csrf_field() ?>

<div class="form-row">

    <!-- Contacts Card -->
    <div class="card">
person icon
        <?php if (!empty($contacts)): ?>
            <?php foreach ($contacts as $i => $c): ?>
                <div class="contact-item">

                    <input type="hidden"
                           name="contacts[<?= $i ?>][contact_id]"
                           value="<?= esc($c['contact_id']) ?>">

                    <p>
                        <strong>Name:</strong>
                        <input type="text"
                               class="input-full"
                               name="contacts[<?= $i ?>][name]"
                               value="<?= esc($c['name']) ?>">
                    </p>

                    <p>
                        <strong>Designation:</strong>
                        <input type="text"
                               class="input-full"
                               name="contacts[<?= $i ?>][designation]"
                               value="<?= esc($c['designation']) ?>">
                    </p>

                    <p>
                        <strong>Mobile:</strong>
                        <input type="text"
                               class="input-full"
                               name="contacts[<?= $i ?>][mobile]"
                               value="<?= esc($c['mobile'] ?? '') ?>">
                    </p>

                    <p>
                        <strong>Email:</strong>
                        <input type="email"
                               class="input-full"
                               name="contacts[<?= $i ?>][email]"
                               value="<?= esc($c['email'] ?? '') ?>">
                    </p>

                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No contacts found.</p>
        <?php endif; ?>

    </div>

    <!-- Company Card -->
    <div class="card">
             company icon

        <h3>
            <input type="text"
                   class="company-title"
                   name="company_name"
                   value="<?= esc($company['company_name']) ?>">
        </h3>

        <p>
            <strong>Category:</strong>
            <input type="text"
                   class="input-full"
                   name="category"
                   value="<?= esc($company['category']) ?>">
        </p>

        <p>
            <strong>City:</strong>
            <input type="text"
                   class="input-full"
                   name="city"
                   value="<?= esc($company['city']) ?>">
        </p>

        <p>
            <strong>State:</strong>
            <input type="text"
                   class="input-full"
                   name="state"
                   value="<?= esc($company['state'] ?? '') ?>">
        </p>

        <p>
            <strong>Phone:</strong>
            <input type="text"
                   class="input-full"
                   name="phone"
                   value="<?= esc($company['phone'] ?? '') ?>">
        </p>

        <p>
            <strong>GST:</strong>
            <input type="text"
                   class="input-full"
                   name="gst_number"
                   value="<?= esc($company['gst_number'] ?? '') ?>">
        </p>

          <p>
    <strong>Fascia</strong>
<input type="text"
       class="input-full"
       name="fascia"
       value="<?= esc(strtoupper($company['fascia'] ?? '')) ?>">


    <small style="color:#666; display:block; margin-top:6px;">
        * The Fascia name will be printed exactly as entered above on the stall name board. 
        Please ensure correct spelling, spacing, and capitalization.
    </small>
</p>

    </div>

</div>

<!-- Buttons -->
<div style="margin-top:20px;">
    <a href="<?= site_url('company/update/'.$company['company_id']) ?>"
       class="btn-primary"
       >
        Save & Continue
    </a>
    <a href="<?= site_url('booking/booking_details/'.$lead['lead_id']) ?>"
       class="btn-secondary">
        Skip to Step 3
    </a>
</div>

</form>
