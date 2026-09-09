<!-- Left Column: Company & Billing Contact -->

<!-- Company Card -->
<div class="card company-card">
    <div class="company-card-header">
        <h3>Company Profile</h3>
        <div class="company-name">{{ $final_bookingdetails->company->company_name }}</div>
    </div>

    <div class="company-card-body">
        <div class="info-group">
            <span class="label">Category</span>
            <span class="value-box">{{ $final_bookingdetails->company->category ?? 'N/A' }}</span>
        </div>

        <div class="info-group">
            <span class="label">GST Number</span>
            <span class="mono-box">{{ $final_bookingdetails->company->gst_number }}</span>
        </div>

        <div class="info-group">
            <span class="label">Registered Address</span>
            <p class="address-text">
                {{ $final_bookingdetails->company->address }}<br>
                <strong>{{ $final_bookingdetails->company->city }}, {{ $final_bookingdetails->company->state }}
                    - {{ $final_bookingdetails->company->pincode }}</strong>
            </p>
        </div>
    </div>
</div>

<!-- Billing Contact Card -->
<div class="card contact-card">
    <h2>Billing Contact</h2>

    <div class="contact-wrapper">
        <div class="avatar">
            {{ strtoupper(substr($final_bookingdetails->billingcontact->name, 0, 1)) }}
        </div>

        <div class="contact-details">
            <div class="contact-name">{{ $final_bookingdetails->billingcontact->name }}</div>
            <div class="contact-title">{{ $final_bookingdetails->billingcontact->designation }}</div>

            <div class="info-group">
                <span class="label">Email</span>
                <a href="mailto:{{ $final_bookingdetails->billingcontact->email }}" class="contact-link">
                    {{ $final_bookingdetails->billingcontact->email }}
                </a>
            </div>

            <div class="info-group">
                <span class="label">Mobile</span>
                <span class="mono-box">{{ $final_bookingdetails->billingcontact->mobile }}</span>
            </div>
        </div>
    </div>
</div>