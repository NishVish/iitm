<div class="container">

    <h2>Lead Details</h2>

    <div class="card">

        <p><strong>Lead ID:</strong> {{ $lead->lead_id }}</p>
        <p><strong>Company ID:</strong> {{ $lead->company_id }}</p>
        <p><strong>Contact ID:</strong> {{ $lead->contact_id }}</p>
        <p><strong>Sales Person:</strong> {{ $lead->sales_person }}</p>
        <p><strong>Status:</strong> {{ $lead->status }}</p>
        <p><strong>Payment Status:</strong> {{ $lead->payment_status }}</p>
        <p><strong>Created At:</strong> {{ $lead->created_at }}</p>

    </div>

</div>