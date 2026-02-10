<?php
$step = 3;
include 'header3.php';
?>
<style>


    h2 {
        margin-bottom: 20px;
        color: #2c3e50;
    }

    h3 {
        margin: 30px 0 10px;
        color: #34495e;
    }


    label {
        font-weight: 600;
        margin-bottom: 6px;
        display: inline-block;
    }

    select {
        width: 100%;
        padding: 10px;
        border-radius: 6px;
        border: 1px solid #ccc;
        font-size: 14px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
    }

    table thead {
        background: #f0f3f7;
    }

    table th, table td {
        padding: 12px;
        text-align: center;
        border: 1px solid #e0e0e0;
    }

    table tbody tr:hover {
        background: #f9fbff;
    }

    input[type="radio"] {
        transform: scale(1.2);
        cursor: pointer;
    }

    .price {
        font-weight: 600;
        color: #2c3e50;
    }

    .summary-box {
        background: #f8f9fb;
        border-radius: 10px;
        padding: 20px;
        margin-top: 25px;
        font-size: 16px;
    }

    .summary-box span {
        float: right;
        font-weight: 600;
    }

    .summary-box div {
        margin-bottom: 8px;
    }

    .summary-box .grand {
        font-size: 18px;
        color: #27ae60;
    }

    .pay-btn {
        margin-top: 25px;
        width: 100%;
        padding: 14px;
        background: linear-gradient(135deg, #27ae60, #2ecc71);
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .pay-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 8px 20px rgba(39, 174, 96, 0.3);
    }
</style>


    <h2>Step 3: Exhibition Details & Payment</h2>

    <form method="post" action="<?= site_url('booking/processPayment') ?>">

        <!-- Hidden fields -->
        <input type="hidden" name="lead_id" value="<?= esc($lead['lead_id']) ?>">
        <input type="hidden" name="company_id" value="<?= esc($company['company_id']) ?>">

        <!-- Location -->
        <label>Exhibition Location</label>
        <select name="location" required>
            <option value="">-- Select Location --</option>
            <option value="Chennai">IITM Chennai</option>
            <option value="Bengaluru">IITM Bengaluru</option>
            <option value="Pune">IITM Pune</option>
            <option value="Hyderabad">IITM Hyderabad</option>
            <option value="Kolkata">IITM Kolkata</option>
            <option value="Ahmedabad">IITM Ahmedabad</option>
        </select>

        <!-- Pricing Table -->
        <h3>Stall Space & Pricing</h3>

        <table>
            <thead>
                <tr>
                    <th>Select</th>
                    <th>Space (Sq. M)</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ([4,6,9,12,18,24] as $size): ?>
                <tr>
                    <td><input type="radio" name="stall_option" value="<?= $size ?>" required></td>
                    <td><?= $size ?> sqm</td>
                    <td class="price">-</td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Hidden auto fields -->
        <input type="hidden" name="size" id="size">
        <input type="hidden" name="price" id="price">

        <!-- Summary -->
        <div class="summary-box">
            <div>Total Amount <span>₹<span id="totalAmount">0</span></span></div>
            <div>GST (18%) <span>₹<span id="gstAmount">0</span></span></div>
            <div class="grand">Grand Total <span>₹<span id="grandTotal">0</span></span></div>
        </div>

        <button type="submit" class="pay-btn">
            Proceed to Secure Payment
        </button>

    </form>
</div>


<!-- JS to populate hidden fields and calculate GST -->
<script>
const gstRate = 0.18;

const locationRates = {
    "Chennai": 32000,
    "Bengaluru": 35000,
    "Delhi": 35000,
    "Mumbai": 35000,
    "Pune": 32000,
    "Hyderabad": 32000,
    "Kochi": 32000,
    "Kolkata": 32000,
    "Ahmedabad": 32000
};

const locationSelect = document.querySelector('select[name="location"]');
const stallRadios = document.querySelectorAll('input[name="stall_option"]');

function resetTotals() {
    document.getElementById('totalAmount').innerText = '0';
    document.getElementById('gstAmount').innerText = '0';
    document.getElementById('grandTotal').innerText = '0';
    document.getElementById('size').value = '';
    document.getElementById('price').value = '';
}

locationSelect.addEventListener('change', function () {
    const location = this.value;
    if (!location) return;

    const rate = locationRates[location];

    document.querySelectorAll('tbody tr').forEach(row => {
        const size = row.querySelector('input').value;
        const price = size * rate;
        row.querySelector('.price').innerText = `₹${price.toLocaleString('en-IN')}`;
    });

    stallRadios.forEach(r => r.checked = false);
    resetTotals();
});

stallRadios.forEach(radio => {
    radio.addEventListener('change', function () {
        const location = locationSelect.value;
        if (!location) {
            alert('Please select location first');
            this.checked = false;
            return;
        }

        const size = parseInt(this.value);
        const rate = locationRates[location];
        const price = size * rate;

        document.getElementById('size').value = size;
        document.getElementById('price').value = price;

        const gst = price * gstRate;
        const grandTotal = price + gst;

        document.getElementById('totalAmount').innerText = price.toLocaleString('en-IN');
        document.getElementById('gstAmount').innerText = gst.toLocaleString('en-IN', { maximumFractionDigits: 2 });
        document.getElementById('grandTotal').innerText = grandTotal.toLocaleString('en-IN', { maximumFractionDigits: 2 });
    });
});
</script>
