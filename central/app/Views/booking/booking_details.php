<?php
$step = 3;
include 'header3.php';
?>

<title>Stall Details</title>

<style>
h2 { margin-bottom: 20px; color: #2c3e50; }
h3 { margin: 20px 0 10px; color: #34495e; }
label { font-weight: 600; margin-bottom: 6px; display: inline-block; }
select { width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #ccc; font-size: 14px; }
table { width: 100%; border-collapse: collapse; margin-top: 15px; }
table thead { background: #f0f3f7; }
table th, table td { padding: 12px; text-align: center; border: 1px solid #e0e0e0; }
table tbody tr:hover { background: #f9fbff; }
.summary-box { background: #f8f9fb; border-radius: 10px; padding: 20px; margin-top: 25px; font-size: 16px; }
.summary-box span { float: right; font-weight: 600; }
.summary-box .grand { font-size: 18px; color: #aa1313; }
.add-location { margin-top: 15px; cursor: pointer; color: #007bff; text-decoration: underline; }
.remove-location { cursor: pointer; color: #aa1313; text-decoration: underline; }

/* Container holds columns horizontally */
.location-container {
    display: flex;
    flex-wrap: wrap; /* allows multiple columns to wrap */
    gap: 20px;       /* space between columns */
}

/* Each location is a column */
.location-column {
    display: flex;
    flex-direction: column; /* stack label + select vertically */
    border: 1px solid #ccc;
    padding: 10px;
    border-radius: 5px;
    min-width: 200px;
}

/* Optional: style remove button */
.remove-location {
    cursor: pointer;
    color: red;
    margin-top: 10px;
}
</style>

<h2>Step 3: Space & Location Details</h2>

<form method="post" action="<?= site_url('booking/savebookingdetails/'.$lead['lead_id']) ?>">

    <!-- Hidden fields -->
    <input type="hidden" name="lead_id" value="<?= esc($lead['lead_id']) ?>">
    <input type="hidden" name="company_id" value="<?= esc($lead['company_id']) ?>">

    <div id="locationsContainer" class="location-container">

<?php if (!empty($savedLocations)): ?>

    <?php foreach ($savedLocations as $index => $row): ?>
        <div class="location-column">
            <label>Exhibition Location</label>
            <select name="locations[]" class="location-select" required>
                <option value="">-- Select Location --</option>
                <?php
                $allLocations = ["Chennai","Bengaluru","Pune","Hyderabad","Kolkata","Ahmedabad"];
                foreach ($allLocations as $loc):
                ?>
                    <option value="<?= $loc ?>" 
                        <?= ($row['location'] == $loc) ? 'selected' : '' ?>>
                        IITM <?= $loc ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label>Stall Size (Sq. M)</label>
            <select name="sizes[]" class="size-select" required>
                <option value="">-- Select Size --</option>
                <?php foreach ([4,6,9,12,18,24] as $size): ?>
                    <option value="<?= $size ?>" 
                        <?= ($row['size'] == $size) ? 'selected' : '' ?>>
                        <?= $size ?> sqm
                    </option>
                <?php endforeach; ?>
            </select>

            <input type="hidden" 
                   name="price[]" 
                   class="price-input" 
                   value="<?= esc($row['price']) ?>">

            <span class="remove-location" <?= $index == 0 ? 'style="display:none;"' : '' ?>>
                Remove
            </span>
        </div>
    <?php endforeach; ?>

<?php else: ?>

    <!-- Default empty row -->
    <div class="location-column">
        <label>Exhibition Location</label>
        <select name="locations[]" class="location-select" required>
            <option value="">-- Select Location --</option>
            <option value="Chennai">IITM Chennai</option>
            <option value="Bengaluru">IITM Bengaluru</option>
            <option value="Pune">IITM Pune</option>
            <option value="Hyderabad">IITM Hyderabad</option>
            <option value="Kolkata">IITM Kolkata</option>
            <option value="Ahmedabad">IITM Ahmedabad</option>
        </select>

        <label>Stall Size (Sq. M)</label>
        <select name="sizes[]" class="size-select" required>
            <option value="">-- Select Size --</option>
            <?php foreach ([4,6,9,12,18,24] as $size): ?>
                <option value="<?= $size ?>"><?= $size ?> sqm</option>
            <?php endforeach; ?>
        </select>

        <input type="hidden" name="price[]" class="price-input">
        <span class="remove-location" style="display:none;">Remove</span>
    </div>

<?php endif; ?>

</div>


    <div class="add-location">+ Add Another Location</div>

    <h3>Selected Locations & Pricing</h3>
    <table id="pricingTable">
        <thead>
            <tr>
                <th>Location</th>
                <th>Size (Sq. M)</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

    <!-- Summary -->
    <div class="summary-box">
        <div>Total Amount <span>₹<span id="totalAmount">0</span></span></div>
        <div>GST (18%) <span>₹<span id="gstAmount">0</span></span></div>
        <div class="grand">Grand Total <span>₹<span id="grandTotal">0</span></span></div>
    </div>

    <button type="submit" class="pay-btn">Proceed to Secure Payment</button>
</form>

<script>

    // 🔥 Auto calculate when page loads (for saved data)
document.addEventListener("DOMContentLoaded", function() {
    updatePricingTable();
});

const gstRate = 0.18;
const locationRates = {
    "Chennai": 32000,
    "Bengaluru": 35000,
    "Pune": 32000,
    "Hyderabad": 32000,
    "Kolkata": 32000,
    "Ahmedabad": 32000
};

const container = document.getElementById('locationsContainer');
const addBtn = document.querySelector('.add-location');
const pricingTableBody = document.querySelector('#pricingTable tbody');

function updatePricingTable() {
    const locations = document.querySelectorAll('.location-select');
    const sizes = document.querySelectorAll('.size-select');
    const priceInputs = document.querySelectorAll('.price-input');

    pricingTableBody.innerHTML = '';
    let total = 0;

    locations.forEach((loc, i) => {
        const size = sizes[i].value;
        if (!loc.value || !size) return;

        const price = size * locationRates[loc.value];
        total += price;

        // Update hidden input
        if(priceInputs[i]){
            priceInputs[i].value = price;
        }

        const tr = document.createElement('tr');
        tr.innerHTML = `<td>${loc.value}</td>
                        <td>${size} sqm</td>
                        <td>₹${price.toLocaleString('en-IN')}</td>`;
        pricingTableBody.appendChild(tr);
    });

    const gst = total * gstRate;
    const grand = total + gst;

    document.getElementById('totalAmount').innerText = total.toLocaleString('en-IN');
    document.getElementById('gstAmount').innerText = gst.toLocaleString('en-IN', {maximumFractionDigits:2});
    document.getElementById('grandTotal').innerText = grand.toLocaleString('en-IN', {maximumFractionDigits:2});
}

// Update pricing on any change
container.addEventListener('change', updatePricingTable);

// Add new location column
addBtn.addEventListener('click', function() {
    const newColumn = container.querySelector('.location-column').cloneNode(true);
    newColumn.querySelectorAll('select').forEach(s => s.value = '');
    newColumn.querySelector('.remove-location').style.display = 'inline';
    container.appendChild(newColumn);
    updatePricingTable();
});

// Remove location column
container.addEventListener('click', function(e) {
    if(e.target.classList.contains('remove-location')){
        const columns = container.querySelectorAll('.location-column');
        if(columns.length > 1){ // prevent removing last row
            e.target.parentElement.remove();
            updatePricingTable();
        }
    }
});
</script>
