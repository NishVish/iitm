```blade
<div class="registration-container">
    <form action="{{ route('registration.submit') }}" method="POST">
        @csrf

        {{-- Hidden Fields --}}
        <input type="hidden" name="contact_id" value="{{ session('contact.contact_id') }}">
        <input type="hidden" name="company_db_id" value="{{ session('company.id') }}">
        <input type="hidden" name="company_id_code" value="{{ session('company_id') }}">

        {{-- ================= PERSONAL PROFILE ================= --}}
        <div class="form-card">
            <h3>Personal Profile</h3>

            <div class="row">
                <div class="form-group col-6">
                    <label>Full Name</label>
                    <input type="text" name="name" value="{{ session('contact.name') }}" class="form-control">
                </div>

                <div class="form-group col-6">
                    <label>Designation</label>
                    <input type="text" name="designation" value="{{ session('contact.designation') }}"
                        class="form-control">
                </div>
            </div>

            <div class="row">
                <div class="form-group col-6">
                    <label>Mobile</label>
                    <input type="text" name="mobile" value="{{ session('contact.mobiles.0') }}" class="form-control"
                        readonly>
                </div>

                <div class="form-group col-6">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ session('contact.emails.0') }}" class="form-control">
                </div>
            </div>
        </div>

        {{-- ================= ORGANIZATION ================= --}}
        <div class="form-card">
            <h3>Organization Details</h3>

            <input type="text" name="company_name" value="{{ session('company.company_name') }}"
                class="form-control mb-2" placeholder="Company Name">

            <div class="row">
                <div class="col-4">
                    <input type="text" name="city" value="{{ session('company.city') }}" class="form-control"
                        placeholder="City">
                </div>
                <div class="col-4">
                    <input type="text" name="state" value="{{ session('company.state') }}" class="form-control"
                        placeholder="State">
                </div>
                <div class="col-4">
                    <input type="text" name="pincode" value="{{ session('company.pincode') }}" class="form-control"
                        placeholder="Pincode">
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-6">
                    <input type="text" name="country" value="{{ session('company.country') }}" class="form-control"
                        placeholder="Country">
                </div>
                <div class="col-6">
                    <input type="text" name="website" value="{{ session('company.website') }}" class="form-control"
                        placeholder="Website">
                </div>
            </div>
        </div>

        {{-- ================= TRAVEL SEGMENTS ================= --}}
        <div class="form-card">
            <h3>Travel Segments</h3>
            @php $segments = ['FIT', 'MICE', 'GIT', 'Ticketing', 'Airlines', 'Business Travel', 'Health and Wellness', 'Accommodation', 'Cruises', 'Coach', 'Religious', 'Adventure', 'Weddings', 'Railway']; @endphp

            @foreach($segments as $seg)
                <label><input type="checkbox" name="travel_segments[]" value="{{ $seg }}"> {{ $seg }}</label><br>
            @endforeach
        </div>

        {{-- ================= WHO TO MEET ================= --}}
        <div class="form-card">
            <h3>Who would you like to meet?</h3>
            @php $meet = ['Outbound Leisure', 'Domestic MICE', 'DMCs', 'Airlines', 'Tourism Board', 'Hotels', 'Travel Tech', 'Cruise']; @endphp

            @foreach($meet as $m)
                <label><input type="checkbox" name="meet_profiles[]" value="{{ $m }}"> {{ $m }}</label><br>
            @endforeach
        </div>

        {{-- ================= REGIONS ================= --}}
        <div class="form-card">
            <h3>Regions</h3>
            @php $regions = ['America', 'India', 'Europe', 'Asia', 'Middle East', 'Africa', 'Australia']; @endphp

            @foreach($regions as $r)
                <label><input type="checkbox" name="meet_regions[]" value="{{ $r }}"> {{ $r }}</label><br>
            @endforeach
        </div>

        {{-- ================= STATES ================= --}}
        <div class="form-card">
            <h3>Interested States (India)</h3>
            @php $states = ['Gujarat', 'Maharashtra', 'Kerala', 'Goa', 'Rajasthan', 'Delhi NCR', 'South India', 'North East']; @endphp

            @foreach($states as $s)
                <label><input type="checkbox" name="interested_states[]" value="{{ $s }}"> {{ $s }}</label><br>
            @endforeach
        </div>

        {{-- ================= INTENT ================= --}}
        <div class="form-card">
            <h3>Main Reason</h3>
            <label><input type="radio" name="attending_reason" value="Gather Information"> Gather Info</label>
            <label><input type="radio" name="attending_reason" value="Sell"> Sell</label>
            <label><input type="radio" name="attending_reason" value="Buy"> Buy</label>
        </div>

        {{-- ================= BUYER ROLE ================= --}}
        <div class="form-card">
            <h3>Buyer Role</h3>
            <select name="buyer_responsibility" class="form-control">
                <option>MD/CEO</option>
                <option>Middle Management</option>
                <option>Owner</option>
                <option>Junior Management</option>
            </select>
        </div>

        {{-- ================= COMPANY SIZE ================= --}}
        <div class="form-card">
            <h3>Company Size</h3>

            <label>Branch Offices</label>
            <select name="branch_offices" class="form-control">
                <option>1-5</option>
                <option>6-10</option>
                <option>11-20</option>
                <option>20+</option>
            </select>

            <label class="mt-2">Total Staff</label>
            <select name="total_staff" class="form-control">
                <option>1-10</option>
                <option>11-25</option>
                <option>26-50</option>
                <option>51-100</option>
                <option>100+</option>
            </select>
        </div>

        {{-- ================= EVENT ================= --}}
        <div class="form-card">
            <h3>Event Preferences</h3>

            <label>Attended Before?</label>
            <input type="radio" name="attended_ttf_before" value="Yes"> Yes
            <input type="radio" name="attended_ttf_before" value="No"> No

            <br>

            <label>Interested in Forum?</label>
            <input type="radio" name="interested_in_forum" value="Yes"> Yes
            <input type="radio" name="interested_in_forum" value="No"> No
        </div>

        {{-- ================= REFERRAL ================= --}}
        <div class="form-card">
            <h3>Referral</h3>
            <textarea name="referral_details" class="form-control" placeholder="Recommend someone..."></textarea>
        </div>

        <button type="submit" class="btn-submit">Finalize Registration</button>
    </form>
</div>
```