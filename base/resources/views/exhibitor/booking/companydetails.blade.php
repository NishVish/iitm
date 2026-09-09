@php
    $companyData = $company->first();
@endphp

<style>
    .ui-card {
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        border: 1px solid #f0f0f0;
        padding: 30px;
        max-width: 900px;
        margin: 0 auto;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }

    .ui-card-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #111827;
        margin-bottom: 24px;
        padding-bottom: 12px;
        border-bottom: 2px solid #f3f4f6;
    }

    .ui-section-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-weight: 700;
        color: #6b7280;
        margin: 20px 0 12px 0;
    }

    .ui-form-group {
        margin-bottom: 16px;
    }

    .ui-label {
        display: block;
        font-size: 0.85rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 6px;
    }

    .ui-input {
        width: 100%;
        padding: 10px 14px;
        border-radius: 8px;
        border: 1px solid #d1d5db;
        background-color: #f9fafb;
        font-size: 0.95rem;
        color: #1f2937;
        transition: all 0.2s ease;
        outline: none;
    }

    .ui-input:focus {
        background-color: #ffffff;
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    }

    .ui-btn {
        background-color: #4f46e5;
        color: #ffffff;
        font-weight: 600;
        padding: 12px 28px;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        font-size: 0.95rem;
        transition: background-color 0.2s ease;
    }

    .ui-btn:hover {
        background-color: #4338ca;
    }
</style>

<div class="ui-card">
    <div class="ui-card-title">Company Details</div>

    <form action="{{ url('updateCompany') }}" method="POST">
        @csrf
        <input type="hidden" name="company_id" value="{{ $companyData->company_id ?? '' }}">

        <!-- Company Info -->
        <div class="row">
            <div class="col-md-6 ui-form-group">
                <label class="ui-label">Company Name</label>
                <input type="text" class="ui-input" name="company_name" value="{{ $companyData->company_name ?? '' }}">
            </div>
            <div class="col-md-6 ui-form-group">
                <label class="ui-label">GST Number</label>
                <input type="text" class="ui-input" name="gst_number" value="{{ $companyData->gst_number ?? '' }}">
            </div>

        </div>

        <div class="ui-section-label">Address Details</div>

        <!-- Address Info -->
        <div class="row">
            <div class="col-12 ui-form-group">
                <label class="ui-label">Street Address</label>
                <textarea class="ui-input" name="address" rows="2">{{ $companyData->address ?? '' }}</textarea>
            </div>
            <div class="col-md-4 ui-form-group">
                <label class="ui-label">City</label>
                <input type="text" class="ui-input" name="city" value="{{ $companyData->city ?? '' }}">
            </div>
            <div class="col-md-4 ui-form-group">
                <label class="ui-label">State</label>
                <input type="text" class="ui-input" name="state" value="{{ $companyData->state ?? '' }}">
            </div>
            <div class="col-md-4 ui-form-group">
                <label class="ui-label">Pincode</label>
                <input type="text" class="ui-input" name="pincode" value="{{ $companyData->pincode ?? '' }}">
            </div>
            <div class="col-12 ui-form-group">
                <label class="ui-label">Country</label>
                <input type="text" class="ui-input" name="country" value="{{ $companyData->country ?? '' }}">
            </div>
        </div>

        <div class="ui-section-label">Contact</div>

        <!-- Contact Info -->
        <div class="row">
            <div class="col-md-6 ui-form-group">
                <label class="ui-label">Phone</label>
                <input type="text" class="ui-input" name="phone" value="{{ $companyData->phone ?? '' }}">
            </div>
            <div class="col-md-6 ui-form-group">
                <label class="ui-label">Website</label>
                <input type="text" class="ui-input" name="website" value="{{ $companyData->website ?? '' }}">
            </div>
        </div>

        <!-- Action Button -->
        <div style="text-align: right; margin-top: 24px;">
            <button type="submit" class="ui-btn">Save Company Details</button>
        </div>
    </form>
</div>