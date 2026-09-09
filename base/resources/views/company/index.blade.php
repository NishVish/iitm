<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap');

    .company-wrapper {
        font-family: 'Poppins', sans-serif;
        background: #f8f9fa;
        padding: 30px 0;
        min-height: 100vh;
    }

    .company-card {
        background: #fff;
        border: 1px solid #e9ecef;
        border-radius: 10px;
        margin-bottom: 24px;
        overflow: hidden;
    }

    .section-title {
        padding: 18px 22px;
        border-bottom: 1px solid #e9ecef;
        background: #fff;
    }

    .section-title h5 {
        margin: 0;
        font-size: 17px;
        font-weight: 600;
        color: #212529;
    }

    .section-title p {
        margin: 4px 0 0;
        color: #6c757d;
        font-size: 13px;
        font-weight: 400;
    }

    .simple-table {
        margin: 0;
    }

    .simple-table thead th {
        background: #f8f9fa;
        color: #495057;
        font-size: 12px;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: .3px;
        border-top: 0;
        border-bottom: 1px solid #dee2e6;
        padding: 13px 18px;
    }

    .simple-table tbody td {
        padding: 14px 18px;
        color: #343a40;
        font-size: 13px;
        font-weight: 400;
        border-color: #f0f0f0;
        vertical-align: middle;
    }

    .simple-table tbody tr:hover {
        background: #fafafa;
    }

    .company-id {
        color: #6c757d;
        font-weight: 400;
    }

    .company-name {
        font-weight: 500;
        color: #212529;
    }

    .designation {
        color: #495057;
        font-weight: 400;
    }

    .email {
        color: #495057;
        text-decoration: none;
    }

    .email:hover {
        color: #0d6efd;
    }

    .empty-row {
        text-align: center;
        color: #868e96 !important;
        padding: 30px 18px !important;
    }

    .action-bar {
        padding: 16px 22px;
        border-top: 1px solid #e9ecef;
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .btn-simple {
        display: inline-block;
        padding: 8px 16px;
        border-radius: 6px;
        font-family: 'Poppins', sans-serif;
        font-size: 13px;
        font-weight: 500;
        text-decoration: none;
        transition: .2s ease;
    }

    .btn-booking {
        background: #212529;
        color: #fff;
    }

    .btn-booking:hover {
        background: #343a40;
        color: #fff;
    }

    .btn-stall {
        background: #fff;
        color: #343a40;
        border: 1px solid #ced4da;
    }

    .btn-stall:hover {
        background: #f8f9fa;
        color: #212529;
        border-color: #adb5bd;
    }

    .existing-bookings {
        padding: 0;
    }

    @media (max-width: 768px) {
        .company-wrapper {
            padding: 15px 0;
        }

        .simple-table {
            min-width: 650px;
        }

        .company-card {
            border-radius: 8px;
        }
    }
</style>

<div class="company-wrapper">
    <div class="container">

        {{-- Company Details --}}
        <div class="company-card">

            <div class="section-title">
                <h5>Company Details</h5>
                <p>Company information</p>
            </div>

            <div class="table-responsive">
                <table class="table simple-table">
                    <thead>
                        <tr>
                            <th>Company ID</th>
                            <th>Company Name</th>
                            <th>Address</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($companydata as $company)
                            <tr>
                                <td class="company-id">
                                    {{ $company->company_id }}
                                </td>

                                <td class="company-name">
                                    {{ $company->company_name }}
                                </td>

                                <td>
                                    {{ $company->address ?? '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="empty-row">
                                    No company data found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($companydata->count())
                @php
                    $currentCompany = $companydata->first();
                @endphp

                <div class="action-bar">

                    <a href="{{ url('create_booking/' . $currentCompany->company_id) }}" class="btn-simple btn-booking">
                        + Create New Booking
                    </a>

                    <a href="{{ url('edit_stall/' . $currentCompany->company_id) }}" class="btn-simple btn-stall">
                        Edit Stall Details
                    </a>

                </div>
            @endif

        </div>


        {{-- Contact Details --}}
        <div class="company-card">

            <div class="section-title">
                <h5>Contact Details</h5>
                <p>Company contact persons</p>
            </div>

            <div class="table-responsive">
                <table class="table simple-table">
                    <thead>
                        <tr>
                            <th>Contact ID</th>
                            <th>Name</th>
                            <th>Designation</th>
                            <th>Email</th>
                            <th>Mobile</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($contact as $person)
                            <tr>
                                <td class="company-id">
                                    {{ $person->contact_id }}
                                </td>

                                <td class="company-name">
                                    {{ $person->name ?? '-' }}
                                </td>

                                <td class="designation">
                                    {{ $person->designation ?? '-' }}
                                </td>

                                <td>
                                    @if($person->email)
                                        <a href="mailto:{{ $person->email }}" class="email">
                                            {{ $person->email }}
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>

                                <td>
                                    {{ $person->mobile ?? '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="empty-row">
                                    No contact found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>


        {{-- Existing Bookings --}}
        <div class="company-card">

            <div class="section-title">
                <h5>Existing Bookings</h5>
                <p>Previous and current bookings</p>
            </div>

            <div class="existing-bookings">
                @include('company.existingbookings')
            </div>

        </div>

    </div>
</div>