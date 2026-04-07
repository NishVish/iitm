```blade id="qz8j3h"
<!DOCTYPE html>
<html>

<head>
    <title>Form Data Preview</title>
    <style>
        body {
            font-family: Arial;
            padding: 20px;
        }

        .card {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
        }

        h3 {
            margin-bottom: 10px;
        }

        .row {
            margin-bottom: 8px;
        }

        .label {
            font-weight: bold;
        }
    </style>
</head>

<body>

    <h2>Submitted Registration Data</h2>

    {{-- ================= PERSONAL ================= --}}
    <div class="card">
        <h3>Personal Info</h3>

        <div class="row"><span class="label">Name:</span> {{ $request->name }}</div>
        <div class="row"><span class="label">Designation:</span> {{ $request->designation }}</div>
        <div class="row"><span class="label">Mobile:</span> {{ $request->mobile }}</div>
        <div class="row"><span class="label">Email:</span> {{ $request->email }}</div>
    </div>

    {{-- ================= COMPANY ================= --}}
    <div class="card">
        <h3>Company Info</h3>

        <div class="row"><span class="label">Company:</span> {{ $request->company_name }}</div>
        <div class="row"><span class="label">City:</span> {{ $request->city }}</div>
        <div class="row"><span class="label">State:</span> {{ $request->state }}</div>
        <div class="row"><span class="label">Pincode:</span> {{ $request->pincode }}</div>
        <div class="row"><span class="label">Country:</span> {{ $request->country }}</div>
        <div class="row"><span class="label">Website:</span> {{ $request->website }}</div>
    </div>

    {{-- ================= TRAVEL ================= --}}
    <div class="card">
        <h3>Travel Segments</h3>

        @if(!empty($request->travel_segments))
            <ul>
                @foreach($request->travel_segments as $item)
                    <li>{{ $item }}</li>
                @endforeach
            </ul>
        @else
            <p>No selection</p>
        @endif
    </div>

    {{-- ================= MEET PROFILES ================= --}}
    <div class="card">
        <h3>Meet Preferences</h3>

        @if(!empty($request->meet_profiles))
            <ul>
                @foreach($request->meet_profiles as $item)
                    <li>{{ $item }}</li>
                @endforeach
            </ul>
        @else
            <p>No selection</p>
        @endif
    </div>

    {{-- ================= REGIONS ================= --}}
    <div class="card">
        <h3>Regions</h3>

        @if(!empty($request->meet_regions))
            <ul>
                @foreach($request->meet_regions as $item)
                    <li>{{ $item }}</li>
                @endforeach
            </ul>
        @else
            <p>No selection</p>
        @endif
    </div>

    {{-- ================= STATES ================= --}}
    <div class="card">
        <h3>Interested States</h3>

        @if(!empty($request->interested_states))
            <ul>
                @foreach($request->interested_states as $item)
                    <li>{{ $item }}</li>
                @endforeach
            </ul>
        @else
            <p>No selection</p>
        @endif
    </div>

    {{-- ================= BUSINESS ================= --}}
    <div class="card">
        <h3>Business Info</h3>

        <div class="row"><span class="label">Attending Reason:</span> {{ $request->attending_reason }}</div>
        <div class="row"><span class="label">Buyer Role:</span> {{ $request->buyer_responsibility }}</div>
        <div class="row"><span class="label">Branch Offices:</span> {{ $request->branch_offices }}</div>
        <div class="row"><span class="label">Total Staff:</span> {{ $request->total_staff }}</div>
    </div>

    {{-- ================= EVENT ================= --}}
    <div class="card">
        <h3>Event Info</h3>

        <div class="row"><span class="label">Attended Before:</span> {{ $request->attended_ttf_before }}</div>
        <div class="row"><span class="label">Interested in Forum:</span> {{ $request->interested_in_forum }}</div>
    </div>

    {{-- ================= REFERRAL ================= --}}
    <div class="card">
        <h3>Referral</h3>

        <div class="row">{{ $request->referral_details ?? 'N/A' }}</div>
    </div>

</body>

</html>
```