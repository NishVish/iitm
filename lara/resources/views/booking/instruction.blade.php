<div class="container">

    <?php $step = 1; ?>

    <title>Instructions Page</title>

    <h2 style="text-align:center; margin-bottom:10px;">
        Step 1: Exhibitor Instructions – IITM
    </h2>

    <!-- Welcome Card -->
    <div class="card full-width">
        <h3>Welcome</h3>
        <p>
            Thank you for your interest in exhibiting at the
            <strong>India International Travel Mart (IITM)</strong>.
        </p>
        <p>
            Please read the following instructions carefully before starting the registration process.
            This will help ensure a smooth and successful booking experience.
        </p>
    </div>

    <!-- Cards Row -->
    <div class="card-row">

        <!-- Guidelines -->
        <div class="card short-card">
            <div class="card-icon">📋</div>
            <h3>Important Guidelines</h3>
            <ul>
                <li>Complete registration within <strong>15 minutes</strong>.</li>
                <li>Keep your <strong>company details, GST, and contact information</strong> ready.</li>
                <li>Ensure all information entered is <strong>accurate and final</strong>.</li>
                <li>Stall allocation is based on <strong>availability and payment confirmation</strong>.</li>
            </ul>
        </div>

        <!-- Steps -->
        <div class="card short-card">
            <div class="card-icon">🛠️</div>
            <h3>Registration Process</h3>
            <ul>
                <li><strong>Step 1:</strong> Review instructions and guidelines.</li>
                <li><strong>Step 2:</strong> Enter company and billing details.</li>
                <li><strong>Step 3:</strong> Select stall and view GST calculation.</li>
                <li><strong>Step 4:</strong> Complete payment (minimum 25% advance).</li>
            </ul>
        </div>

        <!-- Payment -->
        <div class="card short-card">
            <div class="card-icon">💰</div>
            <h3>Payment & Confirmation</h3>
            <ul>
                <li>A minimum of <strong>25% payment</strong> is required to reserve your stall.</li>
                <li>The remaining balance must be paid as per the schedule.</li>
                <li>You will receive a confirmation notification after successful payment.</li>
            </ul>
        </div>

    </div>

    <!-- Footer Card -->
    <div class="card full-width">
        <p>
            By clicking <strong>“Proceed to Step 2”</strong>, you confirm that you have read and understood
            the instructions and agree to continue with the exhibitor registration process.
        </p>

        <div style="text-align: right; padding-right: 10px;">
            <a href="{{ route('booking.step2') }}" class="btn-next">Proceed to Step 2</a>
        </div>
    </div>

</div>