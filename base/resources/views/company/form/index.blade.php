<style>
    .company-form {
        width: 100%;
        max-width: 800px;
        margin: 15px auto;
        padding: 20px;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.04);
        box-sizing: border-box;
    }

    .company-form>h2 {
        margin: 0 0 16px;
        padding-bottom: 10px;
        border-bottom: 2px solid #f1f3f5;
        color: #1f2937;
        font-size: 18px;
        font-weight: 700;
    }

    .form-section {
        margin-bottom: 16px;
        padding: 14px 16px;
        background: #fafafa;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
    }

    .form-section h3 {
        margin: 0 0 12px;
        color: #1f2937;
        font-size: 15px;
        font-weight: 700;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .form-group.full {
        grid-column: 1 / -1;
    }

    .form-group label {
        color: #374151;
        font-size: 12px;
        font-weight: 600;
    }

    .form-group label span {
        color: #dc3545;
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
        width: 100%;
        padding: 7px 10px;
        box-sizing: border-box;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        background: #ffffff;
        color: #111827;
        font-size: 13px;
        outline: none;
        transition: all 0.2s ease;
    }

    .form-group textarea {
        resize: vertical;
        min-height: 52px;
    }

    .form-group input::placeholder,
    .form-group textarea::placeholder {
        color: #9ca3af;
    }

    .form-group input:hover,
    .form-group textarea:hover,
    .form-group select:hover {
        border-color: #9ca3af;
    }

    .form-group input:focus,
    .form-group textarea:focus,
    .form-group select:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.12);
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 10px;
        margin-top: 16px;
        padding-top: 14px;
        border-top: 1px solid #e5e7eb;
    }

    .save-btn {
        min-width: 120px;
        padding: 8px 16px;
        border: none;
        border-radius: 6px;
        background: #2563eb;
        color: #ffffff;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .save-btn:hover {
        background: #1d4ed8;
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(37, 99, 235, 0.2);
    }

    .save-btn:active {
        transform: translateY(0);
    }

    @media (max-width: 768px) {
        .company-form {
            margin: 10px;
            padding: 14px;
        }

        .form-section {
            padding: 12px;
        }

        .form-grid {
            grid-template-columns: 1fr;
            gap: 10px;
        }

        .form-group.full {
            grid-column: auto;
        }

        .form-actions {
            justify-content: stretch;
        }

        .save-btn {
            width: 100%;
        }
    }

    @media (max-width: 480px) {
        .company-form {
            margin: 5px;
            padding: 10px;
            border-radius: 8px;
        }

        .form-section {
            padding: 10px;
        }

        .company-form>h2 {
            font-size: 16px;
        }
    }
</style>

@php
    /*
    |--------------------------------------------------------------------------
    | COMPANY
    |--------------------------------------------------------------------------
    */

    $company = isset($companydata)
        ? ($companydata instanceof \Illuminate\Support\Collection
            ? $companydata->first()
            : $companydata)
        : null;


    /*
    |--------------------------------------------------------------------------
    | CONTACTS
    |--------------------------------------------------------------------------
    */

    $contacts = isset($contact)
        ? ($contact instanceof \Illuminate\Support\Collection
            ? $contact
            : collect($contact ?? []))
        : collect();


    /*
    |--------------------------------------------------------------------------
    | ORIGINAL COMPANY ID
    |--------------------------------------------------------------------------
    */

    $sourceCompanyId = $company->company_id ?? null;

    $segments = request()->segments();
    $lastSegment = $segments[count($segments) - 1] ?? null;
    $secondLastSegment = $segments[count($segments) - 2] ?? null;

@endphp


<form action="{{ route('company.create_company') }}" method="POST" id="companyForm">

    @csrf
    @if($secondLastSegment === 'booking')
        <input type="hidden" name="bookingid" value="{{ $lastSegment }}">
    @endif

    @if($sourceCompanyId)

        <input type="hidden" name="source_company_id" value="{{ $sourceCompanyId }}">

        <input type="hidden" name="page" value="{{ request()->segment(count(request()->segments()) - 1) }}">

    @endif





    <!-- =====================================================
             COMPANY DETAILS
        ====================================================== -->

    <div class="form-section">

        <h3>
            Company Details
        </h3>

        <div class="form-grid">

            <div class="form-group">

                <label for="company_name">
                    Company Name <span>*</span>
                </label>

                <input type="text" id="company_name" name="company_name" placeholder="Enter company name"
                    value="{{ old('company_name', $company->company_name ?? '') }}" required>

            </div>


            <div class="form-group">

                <label for="category">
                    Category
                </label>

                <input type="text" id="category" name="category" placeholder="Enter category"
                    value="{{ old('category', $company->category ?? '') }}">

            </div>


            <div class="form-group full">

                <label for="address">
                    Address
                </label>

                <textarea id="address" name="address" rows="2"
                    placeholder="Enter company address">{{ old('address', $company->address ?? '') }}</textarea>

            </div>


            <div class="form-group">

                <label for="pincode">
                    Pincode
                </label>

                <input type="text" id="pincode" name="pincode" placeholder="Enter pincode" maxlength="20"
                    value="{{ old('pincode', $company->pincode ?? '') }}">

            </div>


            <div class="form-group">

                <label for="city">
                    City
                </label>

                <input type="text" id="city" name="city" placeholder="Enter city"
                    value="{{ old('city', $company->city ?? '') }}">

            </div>


            <div class="form-group">

                <label for="state">
                    State
                </label>

                <input type="text" id="state" name="state" placeholder="Enter state"
                    value="{{ old('state', $company->state ?? '') }}">

            </div>


            <div class="form-group">

                <label for="country">
                    Country
                </label>

                <input type="text" id="country" name="country" placeholder="Enter country"
                    value="{{ old('country', $company->country ?? '') }}">

            </div>


            <div class="form-group">

                <label for="website">
                    Website
                </label>

                <input type="text" id="website" name="website" placeholder="https://example.com"
                    value="{{ old('website', $company->website ?? '') }}">

            </div>


            <div class="form-group">

                <label for="phone">
                    Phone
                </label>

                <input type="text" id="phone" name="phone" placeholder="Enter phone number"
                    value="{{ old('phone', $company->phone ?? '') }}">

            </div>

        </div>

    </div>


    <!-- =====================================================
             CONTACTS
        ====================================================== -->

    @include('company.form.contact')


    <!-- =====================================================
             ACTIONS
        ====================================================== -->

    <div class="form-actions">

        <button type="submit" class="save-btn">
            {{ $company ? 'Save Details' : 'Save Details' }}
        </button>

    </div>


</form>