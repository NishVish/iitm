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

<form method="post" action="<?= site_url('booking/updatefrombooking/'.$lead['lead_id']) ?>">
<?= csrf_field() ?>

<div class="form-row">

    <!-- Contacts Card -->
    <div class="card">
👤 
<div class="form-group">
    <label for="contact_select">Select Contact</label>
    <select name="primary_contact" id="contact_select">
    <?php foreach ($allcontact as $c): ?>
        <option value="<?= esc($c['contact_id']) ?>"
                    data-id="<?= esc($c['contact_id']) ?>"

            data-name="<?= esc($c['name']) ?>"
            data-designation="<?= esc($c['designation']) ?>"
            data-mobile="<?= esc(!empty($c['mobiles']) ? implode(', ', $c['mobiles']) : '') ?>"
            data-email="<?= esc(!empty($c['emails']) ? implode(', ', $c['emails']) : '') ?>"
            <?= $c['contact_id'] == $lead['contact_id'] ? 'selected' : '' ?>>
            <?= esc($c['name']) ?> (<?= esc($c['designation']) ?>)
        </option>
    <?php endforeach; ?>
</select>

</div>

<div class="contact-item">
    <input type="hidden" name="contact_id" id="contact_id" 
           value="<?= esc($primaryContact['contact_id'] ?? '') ?>">

    <p>
        <strong>Name:</strong>
        <input type="text" class="input-full" name="name" id="name" 
               value="<?= esc($primaryContact['name'] ?? '') ?>">
    </p>

    <p>
        <strong>Designation:</strong>
        <input type="text" class="input-full" name="designation" id="designation" 
               value="<?= esc($primaryContact['designation'] ?? '') ?>">
    </p>

    <p>
        <strong>Mobile:</strong>
        <input type="text" class="input-full" name="mobile" id="mobile" 
               value="<?= esc(!empty($primaryContact['mobiles']) ? implode(', ', $primaryContact['mobiles']) : '') ?>">
    </p>

    <p>
        <strong>Email:</strong>
        <input type="email" class="input-full" name="email" id="email" 
               value="<?= esc(!empty($primaryContact['emails']) ? implode(', ', $primaryContact['emails']) : '') ?>">
    </p>



    <div id="qr-container">
    <h4>QR Codes:</h4>

    <!-- Contact QR -->
    <div>
        <p>Contact QR:</p>
        <div id="contact_qr"></div>
    </div>

    <!-- Number QR Codes -->
    <div id="number-qr-container">
        <h4>Number QR Codes:</h4>
    </div>
</div>
</div>

<!-- Include QRCode.js library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
const select = document.getElementById('contact_select');

function updateContactDetails() {
    if (!select) return;

    const selected = select.options[select.selectedIndex];

    // -------- Update Form Fields --------
    document.getElementById('contact_id').value = selected.getAttribute('data-id') || '';;
    document.getElementById('name').value = selected.getAttribute('data-name') || '';
    document.getElementById('designation').value = selected.getAttribute('data-designation') || '';
    document.getElementById('mobile').value = selected.getAttribute('data-mobile') || '';
    document.getElementById('email').value = selected.getAttribute('data-email') || '';

    // -------- Generate Contact QR --------
    const contactText = selected.getAttribute('data-email') || selected.getAttribute('data-name');
    const contactDiv = document.getElementById('contact_qr');
    contactDiv.innerHTML = '';

    if (contactText) {
        new QRCode(contactDiv, {
            text: contactText,
            width: 150,
            height: 150
        });
    }

    // -------- Generate WhatsApp QR Codes --------
    let rawNumbers = selected.getAttribute('data-mobile') || '';
    let numbers = rawNumbers
        .split(/[\/,]+/)
        .map(n => n.trim())
        .filter(n => n.length > 0);

    const container = document.getElementById('number-qr-container');
    container.innerHTML = '<h4>Number QR Codes:</h4>';

    numbers.forEach(num => {
        const qrDiv = document.createElement('div');
        qrDiv.style.display = 'inline-block';
        qrDiv.style.margin = '10px';

        const label = document.createElement('p');
        label.innerText = num;
        qrDiv.appendChild(label);

        let cleanNum = num.replace(/\D/g, '');
        let waLink = `https://wa.me/${cleanNum}`;

        new QRCode(qrDiv, {
            text: waLink,
            width: 120,
            height: 120
        });

        container.appendChild(qrDiv);
    });
}

// Run on page load
updateContactDetails();

// Run when dropdown changes
select.addEventListener('change', updateContactDetails);
</script>


    </div>

    <!-- Company Card -->
    <div class="card">
🏢 
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
            <strong>GSTIN:</strong>
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


<button type="submit" class="btn-primary">Save & Continue</button>

    <a href="<?= site_url('booking/booking_details/'.$lead['lead_id']) ?>"
       class="btn-secondary">
        Skip to Step 3
    </a>
</div>

</form>
