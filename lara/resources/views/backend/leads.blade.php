<h2>Sales Dashboard</h2>

<p>Welcome: {{ $salesPerson }}</p>

@foreach($leads as $lead)

    <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">

        <h3>Company: {{ $lead->company_id }}</h3>
        <p>Status: {{ $lead->status }}</p>
        <p>Payment: {{ $lead->payment_status }}</p>

        <h4>Locations</h4>

        @foreach($lead->locations as $loc)
            <div style="margin-left:15px;">
                📍 {{ $loc->location }} |
                🏬 {{ $loc->stall_location }} |
                💰 {{ $loc->grand_total }}
            </div>
        @endforeach

    </div>

@endforeach