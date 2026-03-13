<?php
$step = 4;
include 'header3.php';
?>

<h2 style="text-align:center; margin-bottom:20px;">Booking Summary</h2>

<?php
// Ensure $locations exists and is an array
$locations = $locations ?? []; 

// Calculate totals dynamically
$totalPrice = 0;
$totalGst = 0;
$grandTotal = 0;

foreach ($locations as $loc) {
    $totalPrice += $loc['price'];
    $totalGst   += $loc['gst_amount'];
    $grandTotal += $loc['grand_total'];
}
?>

<!-- Company Details -->
<table style="width:100%; border-collapse: collapse; font-family: Arial, sans-serif; margin-bottom: 25px;">
    <tr style="background-color:#f2f2f2;">
        <th colspan="2" style="padding:10px; text-align:left; border:1px solid #ddd;">Company Details</th>
    </tr>
    <tr>
        <td style="padding:8px; border:1px solid #ddd;"><strong>Company:</strong></td>
        <td style="padding:8px; border:1px solid #ddd;"><?= esc($company['company_name']) ?></td>
    </tr>
    <tr>
        <td style="padding:8px; border:1px solid #ddd;"><strong>City:</strong></td>
        <td style="padding:8px; border:1px solid #ddd;"><?= esc($company['city']) ?></td>
    </tr>
    <tr>
        <td style="padding:8px; border:1px solid #ddd;"><strong>GST:</strong></td>
        <td style="padding:8px; border:1px solid #ddd;"><?= esc($company['gst_number']) ?></td>
    </tr>
    <tr>
        <td style="padding:8px; border:1px solid #ddd;"><strong>Sales Person:</strong></td>
        <td style="padding:8px; border:1px solid #ddd;"><?= esc($lead['sales_person']) ?></td>
    </tr>
</table>

<!-- Stall Details -->
<table style="width:100%; border-collapse: collapse; font-family: Arial, sans-serif; margin-bottom: 25px;">
    <tr style="background-color:#f2f2f2;">
        <th colspan="3" style="padding:10px; text-align:left; border:1px solid #ddd;">Stall Details</th>
    </tr>
    <tr>
        <th style="padding:8px; border:1px solid #ddd;">Location</th>
        <th style="padding:8px; border:1px solid #ddd;">Stall Size (Sq.M)</th>
        <th style="padding:8px; border:1px solid #ddd;">Price (₹)</th>
    </tr>
    <?php if(!empty($locations)): ?>
        <?php foreach($locations as $loc): ?>
        <tr>
            <td style="padding:8px; border:1px solid #ddd;"><?= esc($loc['location']) ?></td>
            <td style="padding:8px; border:1px solid #ddd;"><?= esc($loc['size']) ?></td>
            <td style="padding:8px; border:1px solid #ddd;">₹<?= number_format($loc['price'],2) ?></td>
        </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="3" style="padding:8px; border:1px solid #ddd; text-align:center;">No stalls booked yet.</td>
        </tr>
    <?php endif; ?>
</table>

<!-- Payment Summary -->
<table style="width:100%; border-collapse: collapse; font-family: Arial, sans-serif;">
    <tr style="background-color:#f2f2f2;">
        <th colspan="2" style="padding:10px; text-align:left; border:1px solid #ddd;">Payment Summary</th>
    </tr>
    <tr>
        <td style="padding:8px; border:1px solid #ddd;"><strong>Total Base Price:</strong></td>
        <td style="padding:8px; border:1px solid #ddd;">₹<?= number_format($totalPrice,2) ?></td>
    </tr>
    <tr>
        <td style="padding:8px; border:1px solid #ddd;"><strong>Total GST (18%):</strong></td>
        <td style="padding:8px; border:1px solid #ddd;">₹<?= number_format($totalGst,2) ?></td>
    </tr>
    <tr style="background-color:#ffe6e6;">
        <td style="padding:8px; border:1px solid #ddd; font-weight:bold;">Grand Total:</td>
        <td style="padding:8px; border:1px solid #ddd; font-weight:bold; color:#c03b31;">₹<?= number_format($grandTotal,2) ?></td>
    </tr>
</table>

<!-- Proceed to Payment -->
<div style="text-align:center; margin-top:25px;">
    <a href="<?= base_url('payment/'.$lead['lead_id']) ?>" 
       class="btn-primary" 
       style="padding:12px 18px; background:#c03b31; color:#fff; border-radius:6px; text-decoration:none;">
       Proceed to Payment
    </a>
</div>

<!-- Modal -->
<div id="termsModal" class="modal">
  <div class="modal-content">
    <h3>Terms & Conditions of Participation</h3>
<div class="terms-box">
  <p><strong>Terms & Conditions of Participation</strong></p>

  <p>Participation in India International Travel Mart is subject to the following terms & conditions.</p>

  <p>1. The Registration Form should be duly filled and signed by an authorised person along with company seal and submitted with requisite payment. Alternatively, applications may be made on participant's letterhead with payment. In any case, the booking will be subject to these Terms & Conditions governing participation.</p>

  <p>2. Order acceptance shall be complete only when our written confirmation and Bill is received by the Applicants.</p>

  <p>3. The allotment and location of stands shall be at the sole discretion of the Organiser. Even if a location has been indicated, the organizer reserves the right to change the same. No stall numbers are allotted in advance.</p>

  <p>4. Exhibitors will not be allowed to sub-let or divide their stands unless a special written permission has been obtained from the organisers. Violation of this clause will lead to additional payment liability as decided by the organisers.</p>

  <p>5. Any Exhibitor failing to occupy its assigned space one hour prior to show opening or who leaves his or her space unattended during the exhibit hours forfeits their rights to the space. All exhibits must be open for business during the exhibit hours. Exhibitors should not dismantle their display until the event is officially closed by the organiser.</p>

  <p>6. Exhibits must not be placed beyond the space booked by the Exhibitor. The Organiser reserves the right to charge 200% of the rate contracted for the additional space used. The distribution of brochures from the aisles is strictly forbidden. Equipment presentations, artistic shows and other promotional activities must be consulted with the Organiser in advance and must not hinder other stands or free movement of participants and public.</p>

  <p>7. Removing furniture and electrical equipment from another booth will amount to snatching and strict action will be taken. On-the-spot requisitions will be serviced subject to stock availability at a premium of 10% on usual rates. Participants are advised to make extra requisitions in advance.</p>

  <p>8. Nameboard fascia will be exactly as per this order and no change on the spot will be entertained. If specified on the spot, it may be arranged at an additional charge of Rs. 2500/- on a first-come-first-served basis.</p>

  <p>9. The Exhibitor shall bear total financial responsibility for equipment and stand fittings provided by the Organiser. Costs of damages and losses arising from improper use of the stand shall be borne by the Exhibitor.</p>

  <p>10. Amounts due for participation charges and extra services shall be paid in full before taking possession of the stall. The Organiser may annul participation without liability if charges are unpaid before possession.</p>

  <p>11. The Organiser shall not insure or take responsibility for the Exhibitor's property. Exhibitors must insure their property against burglary, fire and Acts of God. The Organiser shall not be liable for damages resulting from theft, fire, lightning, explosion, flood, power cuts or other causes beyond their control.</p>

  <p>12. Exhibitors shall not cancel this agreement without express written permission from the organisers and on terms acceptable to them.</p>

  <p>13. All statutory liabilities arising from participants' activities at the fair (such as sales tax, VAT, octroi, customs duty, excise duty, GST or other taxes and licenses) shall be the sole responsibility of the participants.</p>

  <p>14. The exhibitor indemnifies the organisers against all actions, expenses, costs, charges or claims arising from damage or injury caused by the exhibitor, their representatives, servants, workmen or contractors.</p>

  <p>15. Any disputes arising from these Terms and Conditions shall be submitted to the jurisdiction of a competent civil court at the registered address of the Organiser. Matters not specifically covered shall be determined by the organiser, who reserves the right to add or alter regulations at any time.</p>

  <p>16. Changes in order (listing/fascia etc.) must be communicated in writing or email at least 10 days prior to the event. The Company will not be responsible for misunderstandings arising from verbal instructions given to sales executives.</p>

  <p>17. Force Majeure: The exhibition may be postponed or shortened due to causes beyond the control of the Organisers. The Organisers shall not be responsible for any loss sustained due to force majeure or government directives. Refunds, if any, shall be at the sole discretion of the Organisers.</p>

  <p>18. Use of public address systems, audiovisual systems and height of displays is subject to no inconvenience to other participants. The organiser’s decision in this regard shall be final.</p>

  <p>19. Jurisdiction of any dispute will be in the courts of Bangalore, India.</p>
</div>


    <div style="margin-top:15px;">
      <input type="checkbox" id="acceptTerms" onchange="enablePayment()">
      <label for="acceptTerms">I accept the Terms & Conditions</label>
    </div>

    <br>
    <button id="acceptBtn" disabled onclick="closeModal()">Continue</button>
  </div>
</div>

<style>






/* Background overlay */
.modal {
  position: fixed;
  inset: 0;
  background: linear-gradient(135deg, rgba(0,0,0,0.75), rgba(0,0,0,0.6));
  backdrop-filter: blur(8px);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 9999;
  animation: fadeIn 0.3s ease-in-out;
}

/* Modal card */
.modal-content {
  background: #ffffff;
  width: 75%;
  max-width: 900px;
  max-height: 85vh;
  margin: auto;
  padding: 30px;
  border-radius: 18px;
  box-shadow: 0 30px 80px rgba(0,0,0,0.35);
  display: flex;
  flex-direction: column;
  animation: slideUp 0.4s ease;
}

/* Heading styling */
.modal-content h3 {
  font-size: 22px;
  font-weight: 600;
  margin-bottom: 5px;
}

.modal-content h3::after {
  content: "";
  display: block;
  width: 60px;
  height: 3px;
  background: linear-gradient(135deg, #c03b31, #bd3b08);
  margin-top: 8px;
  border-radius: 2px;
}

/* Scrollable terms box */
.terms-box {
  flex: 1;
  overflow-y: auto;
  margin-top: 20px;
  padding: 20px;
  border-radius: 12px;
  background: #f9fafc;
  border: 1px solid #e0e6ed;
  font-size: 14px;
  line-height: 1.7;
  color: #333;
  box-shadow: inset 0 0 10px rgba(0,0,0,0.03);
}

/* Custom Scrollbar */
.terms-box::-webkit-scrollbar {
  width: 8px;
}

.terms-box::-webkit-scrollbar-thumb {
  background: linear-gradient(#e0e0e0, #c03b31);
  border-radius: 10px;
}

.terms-box::-webkit-scrollbar-track {
  background: #f1f1f1;
}

/* Checkbox styling */
input[type="checkbox"] {
  width: 18px;
  height: 18px;
  accent-color: #c03b31;
  cursor: pointer;
}

label {
  font-size: 14px;
  cursor: pointer;
}

/* Button styling */
button {
  padding: 12px 18px;
  background: linear-gradient(135deg, #c03b31, #bd3b08);
  border: none;
  color: #fff;
  font-size: 15px;
  border-radius: 8px;
  cursor: pointer;
  transition: 0.3s ease;
}

button:hover:not(:disabled) {
  transform: translateY(-2px);
  box-shadow: 0 6px 15px rgba(172, 64, 31, 0.35);
}

button:disabled {
  background: #aaa;
  cursor: not-allowed;
}

/* Animations */
@keyframes fadeIn {
  from {opacity: 0;}
  to {opacity: 1;}
}

@keyframes slideUp {
  from {transform: translateY(30px); opacity: 0;}
  to {transform: translateY(0); opacity: 1;}
}




</style>

<script>
window.onload = function() {
  document.getElementById("termsModal").style.display = "block";
};

function enablePayment() {
  const checkbox = document.getElementById("acceptTerms");
  const btn = document.getElementById("acceptBtn");
  btn.disabled = !checkbox.checked;
}

function closeModal() {
  document.getElementById("termsModal").style.display = "none";
  const paymentLink = document.getElementById("mainPaymentLink");
  paymentLink.style.pointerEvents = "auto";
  paymentLink.style.opacity = "1";
}
</script>
