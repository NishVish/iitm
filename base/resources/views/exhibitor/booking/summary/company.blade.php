{{-- Company Details --}}
<h6 class="mb-3">Company Details</h6>

@if($company && $company->count())
    @php
        $companyData = $company->first();
    @endphp

    <div class="table-responsive mb-4">
        <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <th width="25%">Company Name</th>
                    <td>{{ $companyData->company_name ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Category</th>
                    <td>{{ $companyData->category ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Subcategory</th>
                    <td>{{ $companyData->subcategory ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Address</th>
                    <td>{{ $companyData->address ?? '-' }}</td>
                </tr>
                <tr>
                    <th>City</th>
                    <td>{{ $companyData->city ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Pincode</th>
                    <td>{{ $companyData->pincode ?? '-' }}</td>
                </tr>
                <tr>
                    <th>State</th>
                    <td>{{ $companyData->state ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Country</th>
                    <td>{{ $companyData->country ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Website</th>
                    <td>{{ $companyData->website ?? '-' }}</td>
                </tr>
                <tr>
                    <th>GST Number</th>
                    <td>{{ $companyData->gst_number ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Phone</th>
                    <td>{{ $companyData->phone ?? '-' }}</td>
                </tr>
            </tbody>
        </table>
    </div>
@endif