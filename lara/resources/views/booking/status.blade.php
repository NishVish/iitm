<form method="POST" action="{{ url('lead/save') }}">
    @csrf

    <div class="ticket">

        <!-- HEADER -->
        <div class="ticket-header">
            <h2>Lead Ticket #{{ $lead->lead_id ?? 'NEW' }}</h2>
            <span>Status: {{ $lead->status ?? 'Pending' }}</span>
        </div>

        <!-- COMPANY SECTION -->
        <div class="ticket-section">
            <h3>🏢 Company Details</h3>

            <div class="grid">
                <div class="field">
                    <label>Company Name</label>
                    <input type="text" name="company_name" value="{{ $lead->company_name }}">
                </div>

                <div class="field">
                    <label>GST Number</label>
                    <input type="text" name="gst_number" value="{{ $lead->gst_number }}">
                </div>

                <div class="field">
                    <label>Phone</label>
                    <input type="text" name="phone" value="{{ $lead->phone }}">
                </div>

                <div class="field">
                    <label>Website</label>
                    <input type="text" name="website" value="{{ $lead->website }}">
                </div>
            </div>

            <div class="field full">
                <label>Address</label>
                <textarea name="address">{{ $lead->address }}</textarea>
            </div>
        </div>

        <!-- CONTACT SECTION -->
        <div class="ticket-section">
            <h3>👤 Contact Person</h3>

            <div class="grid">
                <div class="field">
                    <label>Name</label>
                    <input type="text" name="contact_name" value="{{ $lead->contact_name }}">
                </div>

                <div class="field">
                    <label>Designation</label>
                    <input type="text" name="designation" value="{{ $lead->designation }}">
                </div>
            </div>

            <h4>Emails</h4>
            @foreach($emails as $email)
                <input type="email" name="emails[]" value="{{ $email->email }}">
            @endforeach
            <input type="email" name="emails[]" placeholder="Add email">

            <h4>Mobile Numbers</h4>
            @foreach($mobiles as $mobile)
                <input type="text" name="mobiles[]" value="{{ $mobile->mobile }}">
            @endforeach
            <input type="text" name="mobiles[]" placeholder="Add mobile">
        </div>

        <!-- LEAD INFO -->
        <div class="ticket-section">
            <h3>📌 Lead Details</h3>

            <div class="grid">
                <input type="text" name="company_id" value="{{ $lead->company_id ?? '' }}" placeholder="Company ID">
                <input type="text" name="lead_id" value="{{ $lead->lead_id ?? '' }}" placeholder="Lead ID">
                <input type="text" name="contact_id" value="{{ $lead->contact_id ?? '' }}" placeholder="Contact ID">
                <input type="text" name="exhibition_year" value="{{ $lead->exhibition_year ?? '' }}" placeholder="Year">
                <input type="text" name="fascia" value="{{ $lead->fascia ?? '' }}" placeholder="Fascia">
                <input type="text" name="sales_person" value="{{ $lead->sales_person ?? '' }}"
                    placeholder="Sales Person">
                <input type="text" name="exhibitor" value="{{ $lead->exhibitor ?? '' }}" placeholder="Exhibitor">
                <input type="text" name="booking_form" value="{{ $lead->booking_form ?? '' }}"
                    placeholder="Booking Form">
                <input type="text" name="payment_status" value="{{ $lead->payment_status ?? '' }}"
                    placeholder="Payment Status">
            </div>
        </div>

        <!-- LOCATIONS (TICKET STYLE CARDS) -->
        <div class="ticket-section">
            <h3>📍 Locations</h3>

            <div id="locations">
                @foreach($leadloaction ?? [] as $index => $loc)
                    <div class="location-card">
                        <h4>Location #{{ $index + 1 }}</h4>

                        <div class="grid">
                            <input type="text" name="locations[{{ $index }}][location]" value="{{ $loc->location }}">
                            <input type="text" name="locations[{{ $index }}][stall_location]"
                                value="{{ $loc->stall_location }}">
                            <input type="text" name="locations[{{ $index }}][size]" value="{{ $loc->size }}">
                            <input type="text" name="locations[{{ $index }}][price]" value="{{ $loc->price }}">
                            <input type="text" name="locations[{{ $index }}][gst_amount]" value="{{ $loc->gst_amount }}">
                            <input type="text" name="locations[{{ $index }}][discount_amount]"
                                value="{{ $loc->discount_amount }}">
                            <input type="text" name="locations[{{ $index }}][grand_total]" value="{{ $loc->grand_total }}">
                        </div>

                        <button type="button" onclick="this.parentElement.remove()">Remove</button>
                    </div>
                @endforeach
            </div>

            <button type="button" onclick="addLocation()">+ Add Location</button>
        </div>

        <!-- FOOTER -->
        <div class="ticket-footer">
            <button type="submit">💾 Save Ticket</button>
        </div>

    </div>
</form>
<div style="background:#f8f9fa; padding:20px; border-radius:12px; font-family:monospace;">

    <h3 style="margin-bottom:15px; color:#333;">Debug Data</h3>

    <div style="background:#fff; padding:15px; border-radius:10px; margin-bottom:15px; border:1px solid #e5e5e5;">
        <strong>Lead</strong>
        <pre style="margin-top:10px; white-space:pre-wrap;">
{{ print_r($lead, true) }}
        </pre>
    </div>

    <div style="background:#fff; padding:15px; border-radius:10px; margin-bottom:15px; border:1px solid #e5e5e5;">
        <strong>Emails</strong>
        <pre style="margin-top:10px; white-space:pre-wrap;">
{{ print_r($emails, true) }}
        </pre>
    </div>

    <div style="background:#fff; padding:15px; border-radius:10px; margin-bottom:15px; border:1px solid #e5e5e5;">
        <strong>Mobiles</strong>
        <pre style="margin-top:10px; white-space:pre-wrap;">
{{ print_r($mobiles, true) }}
        </pre>
    </div>

    <div style="background:#fff; padding:15px; border-radius:10px; border:1px solid #e5e5e5;">
        <strong>Locations</strong>
        <pre style="margin-top:10px; white-space:pre-wrap;">
{{ print_r($locations, true) }}
        </pre>
    </div>

    <div style="background:#fff; padding:15px; border-radius:10px; border:1px solid #e5e5e5;">
        <strong>Company</strong>
        <pre style="margin-top:10px; white-space:pre-wrap;">
{{ print_r($company, true) }}
        </pre>
    </div>
    <div style="background:#fff; padding:15px; border-radius:10px; border:1px solid #e5e5e5;">
        <strong>Contact</strong>
        <pre style="margin-top:10px; white-space:pre-wrap;">
{{ print_r($contact, true) }}
        </pre>
    </div>
    <div style="background:#fff; padding:15px; border-radius:10px; border:1px solid #e5e5e5;">
        <strong>LeadInfo</strong>
        <pre style="margin-top:10px; white-space:pre-wrap;">
{{ print_r($leadinfo, true) }}
        </pre>
    </div>

</div>

<style>
    .ticket {
        max-width: 900px;
        margin: auto;
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 20px;
        font-family: Arial;
    }

    .ticket-header {
        display: flex;
        justify-content: space-between;
        border-bottom: 2px dashed #ccc;
        margin-bottom: 15px;
    }

    .ticket-section {
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    }

    .grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
    }

    .field label {
        font-size: 12px;
        color: #666;
    }

    .field input,
    textarea {
        width: 100%;
        padding: 6px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .location-card {
        border: 1px dashed #aaa;
        padding: 10px;
        margin-bottom: 10px;
        border-radius: 8px;
        background: #fafafa;
    }

    .ticket-footer {
        text-align: right;
    }
</style>