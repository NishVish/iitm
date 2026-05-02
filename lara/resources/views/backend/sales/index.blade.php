@include('backend/header')

<div style="display:flex; justify-content:space-between; margin-bottom:10px;">
    <div style="background:#e2e8f0; padding:10px; border-radius:6px; width:49%;">
        <strong>Total Leads:</strong> 150
    </div>

    <div style="background:#cce5ff; padding:10px; border-radius:6px; width:49%;">
        <strong>Converted:</strong> 45
    </div>
</div>


<div style="background:#f0fff4; padding:10px; border-radius:6px;">
    <strong>Open Leads:</strong> 105
</div>


Open <button>All Leads</button>
Closed <button>Converted Leads</button>

2026
2027
2028
"MUMBAI", "DELHI", "BANGALORE", "HYDERABAD",
"CHENNAI", "KOLKATA", "PUNE", "AHMEDABAD", "KOCHI"



@php
    // echo "<pre>";
    // print_r(session()->all());
    // echo "</pre>";
@endphp
@include('backend/search')

@include('backend/sales/leadstable')

@include('backend/sales/mail')