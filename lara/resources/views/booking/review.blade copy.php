<style>
    .summary-box {
        background: #f9fafc;
        border-radius: 12px;
        padding: 20px;
        box-shadow: inset 0 0 0 1px #eee;
    }

    .summary-title {
        font-size: 20px;
        margin-bottom: 15px;
        font-weight: 600;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #eee;
        font-size: 15px;
    }

    .summary-row:last-child {
        border-bottom: none;
    }

    .summary-label {
        color: #666;
    }

    .summary-value {
        font-weight: 500;
        color: #111;
    }

    .summary-total {
        margin-top: 15px;
        padding-top: 15px;
        border-top: 2px solid #ddd;
        font-size: 17px;
        font-weight: 600;
        display: flex;
        justify-content: space-between;
    }
</style>

<div class="summary-box">
    <div class="summary-title">Order Summary</div>

    <div class="summary-row">
        <div class="summary-label">Name</div>
        <div class="summary-value" id="summary-name">-</div>
    </div>

    <div class="summary-row">
        <div class="summary-label">Email</div>
        <div class="summary-value" id="summary-email">-</div>
    </div>

    <div class="summary-row">
        <div class="summary-label">Phone</div>
        <div class="summary-value" id="summary-phone">-</div>
    </div>

    <div class="summary-row">
        <div class="summary-label">Date</div>
        <div class="summary-value" id="summary-date">-</div>
    </div>

    <div class="summary-row">
        <div class="summary-label">Slot</div>
        <div class="summary-value" id="summary-slot">-</div>
    </div>

    <div class="summary-total">
        <div>Total</div>
        <div id="summary-total">₹0</div>
    </div>
</div>

<script>
    function updateSummary() {
        document.getElementById('summary-name').innerText =
            document.querySelector('[name="name"]')?.value || '-';

        document.getElementById('summary-email').innerText =
            document.querySelector('[name="email"]')?.value || '-';

        document.getElementById('summary-phone').innerText =
            document.querySelector('[name="phone"]')?.value || '-';

        document.getElementById('summary-date').innerText =
            document.querySelector('[name="date"]')?.value || '-';

        document.getElementById('summary-slot').innerText =
            document.querySelector('[name="slot"]')?.value || '-';

        // Example static price (replace with your logic)
        document.getElementById('summary-total').innerText = '₹500';
    }

    // Call when step 4 is opened
    document.getElementById('tab-4').addEventListener('click', updateSummary);
</script>