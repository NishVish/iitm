<style>
    :root {
        --primary-color: #AA2D2C;
        --dark-color: #1a1a1a;
        --grey-color: #6b7280;
        --light-bg: #f3f7fa;
    }

    * {
        box-sizing: border-box;
        font-family: 'Inter', -apple-system, sans-serif;
    }

    .process-section {
        max-width: 1100px;
        margin: auto;
        padding: 70px 20px;
        background: #fff;
    }

    .process-label {
        font-size: 11px;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: var(--primary-color);
        font-weight: 700;
        margin-bottom: 10px;
        display: block;
    }

    .process-title {
        font-size: 36px;
        font-weight: 800;
        color: var(--dark-color);
        margin: 0 0 15px;
        line-height: 1.2;
    }

    .process-title em {
        color: var(--primary-color);
        font-style: normal;
    }

    .process-subtitle {
        font-size: 15px;
        color: var(--grey-color);
        max-width: 750px;
        line-height: 1.6;
        margin-bottom: 35px;
    }

    .steps {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        margin-bottom: 40px;
    }

    .step {
        background: var(--light-bg);
        padding: 30px;
        border-radius: 16px;
        border: 1px solid rgba(0, 0, 0, 0.04);
        position: relative;
        transition: 0.3s ease;
    }

    .step:hover {
        transform: translateY(-5px);
        border-color: var(--primary-color);
        background: #fff;
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.06);
    }

    .step-num {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        background: rgba(170, 45, 44, 0.1);
        color: var(--primary-color);
        font-size: 12px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 14px;
    }

    .step strong {
        display: block;
        font-size: 20px;
        margin-bottom: 8px;
        color: var(--dark-color);
    }

    .step p {
        font-size: 14px;
        color: var(--grey-color);
        margin: 0;
        line-height: 1.6;
    }

    .step-actions {
        margin-top: 20px;
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .btn {
        padding: 12px 16px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 13px;
        cursor: pointer;
        border: none;
        text-transform: uppercase;
        text-decoration: none;
        display: inline-block;
    }

    .btn-primary {
        background: var(--primary-color);
        color: #fff;
    }

    .btn-outline {
        background: transparent;
        border: 1px solid var(--primary-color);
        color: var(--primary-color);
    }

    @media (max-width: 900px) {
        .steps {
            grid-template-columns: 1fr;
        }
    }
</style>

<section class="process-section">

    <span class="process-label">Participation Options</span>

    <h2 class="process-title">Book your <em>Stall Now</em></h2>

    <p class="process-subtitle">
        Get started with IITM in the way that suits you best. Our sales team will assist you at every step.
    </p>

    <div class="steps">

        <!-- OPTION 1 -->
        <div class="step">

            <div class="step-num">01</div>

            <strong>Fill the Enquiry Form</strong>

            <p>
                Submit your exhibition enquiry online. Our team will review your requirement
                and get back to you with stall options and details.
            </p>

            <div class="step-actions">
                <a href="{{ url("enquiry") }}" class="btn btn-primary">Send Enquiry</a>
            </div>

        </div>

        <!-- OPTION 2 -->
        <div class="step">

            <div class="step-num">02</div>

            <strong>Connect With Sales Team</strong>

            <p>
                Speak directly with our sales experts to choose the right stall,
                get pricing details, and complete your booking smoothly.
            </p>

            <div class="step-actions">
                <a href="tel:+919742942009" class="btn btn-primary">Call Sales Team</a>
                <a href="https://wa.me/+919742942009" class="btn btn-outline">WhatsApp Us</a>
            </div>

        </div>

    </div>
</section>