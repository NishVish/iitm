<div class="form-section">
    <div class="row">
        <div class="column" style="height: 240px;">

            <img src="side-image.png" style="width: 100%; height: 100%;" crossorigin="anonymous">
        </div>
        <div class="column">
            <div class="form-line"><label for="area">Area Required (m²):</label><input type="number" id="area"
                    name="area" required>
            </div>
            <div class="form-line"><label for="amount">Amount Rs:</label><input type="number" id="amount" name="amount"
                    required>
            </div>
            <div class="form-line">
                <label for="gst-amount">18% GST of the Amount:</label>
                <input type="number" id="gst-amount" name="gst-amount" readonly>
            </div>

            <div class="form-line">
                <label for="total">Total Amount with 18%:</label>
                <input type="number" id="total" name="total" readonly>
            </div>

            <div class="form-line"><label>A-Rs:</label><input type="number" id="a-rs" name="a-rs"> +
                <label>B-Rs:</label><input type="number" id="b-rs" name="b-rs">
            </div>
            <div class="form-line"><label><strong>Grand Total:</strong></label><input type="number" id="grand-total"
                    name="grand-total"></div>
        </div>
    </div>
</div>

<div class="form-section">
    <div class="row">
        <div class="column">
            <h3>Bank Transfer Details:</h3>
            <div class="account-info">
                A/C Name: Sphere Travelmedia & Exhibitions Pvt. Ltd.<br>
                A/C No: 0184 2320 0013 32<br>
                Bank: HDFC Bank, CMH Road, Indiranagar, Bangalore - 08<br>
                IFSC: HDFC0000184 <br>
                RTGS/NEFT/IFSC Code:HDFC0000184
            </div>

        </div>
        <div class="column">
            <h3>Payment Particulars:</h3>

            <div class="form-line" style="flex-wrap: nowrap;">
                <label for="cheque-no" style="min-width: 120px;">Cheque/DD No:</label>
                <input type="text" id="cheque-no" name="cheque-no" style="flex: 1;">
                <label for="cheque-date" style="min-width: 60px;">Dated:</label>
                <input type="date" id="cheque-date" name="cheque-date" style="min-width: 180px;">
            </div>

            <div class="form-line"><label for="payment-amount">Amount Rs:</label><input type="number"
                    id="payment-amount" name="payment-amount"></div>
            <div class="form-line"><label for="drawn-on">Drawn on:</label><input type="text" id="drawn-on"
                    name="drawn-on">
            </div>
            <p>In Favour of "Sphere Travelmedia & Exhibitions Pvt. Ltd."<br>
                (Payable at Bangalore)</p>
        </div>
    </div>
</div>

<h3>Organisation Details</h3>

<div class="form-line inline-fields">
    <label for="org-name">Name of Organisation:</label>
    <input type="text" id="org-name" name="org-name" required>
</div>

<div class="form-line inline-fields">
    <label for="contact-person">Contact Person & Designation:</label>
    <input type="text" id="contact-person" name="contact-person" required>
</div>

<div class="form-line">
    <label for="address">Address:</label>
    <textarea id="address" name="address" rows="3" required></textarea>
</div>

<div class="form-line inline-fields">
    <label for="telephone">Telephone:</label>
    <input type="text" id="telephone" name="telephone" required>

    <label for="fax">Fax:</label>
    <input type="text" id="fax" name="fax">

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>
</div>

<div class="form-line inline-fields">
    <label for="gst">GST No:</label>
    <input type="text" id="gst" name="gst" required>

    <label for="website">Website:</label>
    <input type="text" id="website" name="website">

    <label for="product-category">Product Category:</label>
    <input type="text" id="product-category" name="product-category" required>
</div>

<div class="form-line">
    <label for="fascia">Fascia Name:</label>
    <input type="text" id="fascia" name="fascia" maxlength="60" required>
</div>

<!-- 
<div class="note">
  <p><strong>Note:</strong> Fascia must be in English, max 30 characters.</p>
  <p>Email the following to <strong>events@iitmindia.com</strong>:</p>
  <ol>
    <li>Company Profile (200 words max)</li>
    <li>Representative Office / Agent Addresses (if any)</li>
  </ol>
</div> -->
<div class="form-line inline-fields">

    <table style="width: 100%; table-layout: fixed;">
        <tr>
            <td style="width: 50%;">
                <input type="text">
            </td>
            <td style="width: 50%; text-align: center;">
                <img id="company-seal-preview" src="" alt="Company Seal"
                    style="width: 100px; height: 100px; display: none; margin: 0 auto;">
                <!-- Upload Image for Company Seal -->
                <input type="file" id="company-seal-upload" accept="image/*"
                    onchange="displayImage('company-seal-preview', this)">
            </td>
            <td style="width: 50%; text-align: center;">
                <img id="signature-preview" src="" alt="Signature"
                    style="width: 100px; height: 100; display: none; margin: 0 auto;">
                <!-- Upload Image for Signature -->
                <input type="file" id="signature-upload" accept="image/*"
                    onchange="displayImage('signature-preview', this)">
            </td>
        </tr>
        <tr>
            <td><label for="date">Date</label></td>
            <td><label for="company-seal">Company Seal</label></td>
            <td><label for="signature">Signature</label></td>
        </tr>
    </table>


</div>




<div class="footer">
    <button type="submit" id="submit-btn">Submit</button>
    <br><br>

    <div style="display: inline-flex; align-items: center; gap: 20px; text-align: left;">

        <!-- <img src="sphere.png" style="width: 200px; height: auto;">
    <img src="sphere2.png" style="width: 200px; height: auto;"> -->
        <img src="sphere3.png" style="width: 200px; height: auto;">

        <div style="line-height: 1.5;">
            <strong>Sphere Travelmedia & Exhibitions Pvt Ltd</strong><br>
            #245, “Shivashakthi”, 7th Main, Amarjyothi Layout, Domlur, Bangalore - 560071, India<br>
            Ph: +91-80-4083 4100 | Fax: +91-80-4083 4101<br>
            Email: <a href="mailto:info@iitmindia.com">info@iitmindia.com</a>
        </div>

    </div>
</div>


<button type="button" id="autofill-btn" onclick="fillSampleData()"
    style="background: #0284c7; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; margin-right: 10px;">
    Autofill Sample Data
</button>


</div>