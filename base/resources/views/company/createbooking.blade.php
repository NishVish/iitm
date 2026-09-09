<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>Company ID</th>
            <th>Company Name</th>
            <th>Address</th>
        </tr>
    </thead>

    <tbody>
        @forelse($companydata as $company)
            <tr>
                <td>{{ $company->company_id }}</td>
                <td>{{ $company->company_name }}</td>
                <td>{{ $company->address ?? '-' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="3" class="text-center">
                    No company data found.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>


<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
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
                    <td>{{ $person->contact_id }}</td>
                    <td>{{ $person->name ?? '-' }}</td>
                    <td>{{ $person->designation ?? '-' }}</td>
                    <td>{{ $person->email ?? '-' }}</td>
                    <td>{{ $person->mobile ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">
                        No contact found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@include('booking.existingbookings')



create new booking edit stall details