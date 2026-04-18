<h3>Company & Business Interests</h3>

<div class="section-title">General Information</div>
<div class="row g-3">
    <div class="col-12 form-group">
        <label>Company Name</label>
        <input type="text" name="company_name" value="{{ $company['company_name'] ?? '' }}" class="form-control">
    </div>

    <div class="col-md-4 form-group">
        <label>City</label>
        <input type="text" name="city" value="{{ $company['city'] ?? '' }}" class="form-control">
    </div>

    <div class="col-md-4 form-group">
        <label>State</label>
        <input type="text" name="state" value="{{ $company['state'] ?? '' }}" class="form-control">
    </div>

    <div class="col-md-4 form-group">
        <label>Country</label>
        <input type="text" name="country" value="{{ $company['country'] ?? '' }}" class="form-control">
    </div>

    <div class="col-md-12 form-group">
        <label>Address</label>
        <textarea name="address" class="form-control">{{ $company['address'] ?? '' }}</textarea>
    </div>

    <div class="col-md-4 form-group">
        <label>Pincode</label>
        <input type="text" name="pincode" value="{{ $company['pincode'] ?? '' }}" class="form-control">
    </div>

    <div class="col-md-4 form-group">
        <label>Phone</label>
        <input type="text" name="phone" value="{{ $company['phone'] ?? '' }}" class="form-control">
    </div>

    <div class="col-md-4 form-group">
        <label>Website</label>
        <input type="text" name="website" value="{{ $company['website'] ?? '' }}" class="form-control">
    </div>
</div>

<div class="section-title">Business Details</div>
<div class="row g-3">
    <div class="col-md-4 form-group">
        <label>Category</label>
        <input type="text" name="category" value="{{ $company['category'] ?? '' }}" class="form-control">
    </div>

    <!-- <div class="col-md-4 form-group">
        <label>GST Number</label>
        <input type="text" name="gst_number" value="{{ $company['gst_number'] ?? '' }}" class="form-control">
    </div> -->
    <!-- 
    <div class="col-md-4 form-group">
        <label>Sales Person</label>
        <input type="text" name="sales_person" value="{{ $company['sales_person'] ?? '' }}" class="form-control">
    </div> -->

    <!-- <div class="col-md-4 form-group">
        <label>Branch Offices</label>
        <input type="text" name="branch_offices" value="{{ $company['branch_offices'] ?? '' }}" class="form-control">
    </div> -->

    <div class="col-md-4 form-group">
        <label>Total Staff</label>
        <input type="text" name="total_staff" value="{{ $company['total_staff'] ?? '' }}" class="form-control">
    </div>

    <div class="col-md-4 form-group">
        <label>Association Membership</label>
        <input type="text" name="association_membership" value="{{ $company['association_membership'] ?? '' }}"
            class="form-control">
    </div>
</div>

<div class="section-title">Business Profile</div>
<div class="row g-3">
    <!-- <div class="col-md-6 form-group">
        <label>Buyer Responsibility</label>
        <select name="buyer_responsibility" class="form-control">
            <option value="Owner" {{ ($contact->buyer_responsibility ?? '') == 'Owner' ? 'selected' : '' }}>Owner</option>
            <option value="MD/CEO" {{ ($contact->buyer_responsibility ?? '') == 'MD/CEO' ? 'selected' : '' }}>MD/CEO
            </option>
            <option value="Middle Management" {{ ($contact->buyer_responsibility ?? '') == 'Middle Management' ? 'selected' : '' }}>Middle Management</option>
        </select>
    </div> -->

    <div class="col-md-6 form-group">
        <label>Reason for Attending</label>
        <div class="d-flex gap-4 pt-2">
            <label>
                <input type="radio" name="attending_reason" value="Buy" {{ ($contact->attending_reason ?? '') == 'Buy' ? 'checked' : '' }}>
                Buy
            </label>

            <label>
                <input type="radio" name="attending_reason" value="Sell" {{ ($contact->attending_reason ?? '') == 'Sell' ? 'checked' : '' }}>
                Sell
            </label>
        </div>
    </div>
</div>

<div class="section-title">Travel Segments</div>
<div class="row g-3">
    <div class="col-md-12">
        @php $segments = explode(',', $company['travel_segments'] ?? ''); @endphp

        @foreach(['FIT', 'MICE', 'GIT', 'Ticketing', 'Airlines', 'Cruises', 'Adventure', 'Wellness', 'Religious'] as $seg)
            <label style="margin-right:10px;">
                <input type="checkbox" name="travel_segments[]" value="{{ $seg }}" {{ in_array($seg, $segments) ? 'checked' : '' }}>
                {{ $seg }}
            </label>
        @endforeach
    </div>
</div>

<div class="section-title">Meeting Preferences</div>
<div class="row g-3">
    <div class="col-md-6 form-group">
        <label>Meet Profiles</label>
        <input type="text" name="meet_profiles" value="{{ $company['meet_profiles'] ?? '' }}" class="form-control">
    </div>

    <div class="col-md-6 form-group">
        <label>Meet Regions</label>
        <input type="text" name="meet_regions" value="{{ $company['meet_regions'] ?? '' }}" class="form-control">
    </div>

    <div class="col-md-12 form-group">
        <label>Interested States</label>
        <input type="text" name="interested_states" value="{{ $company['interested_states'] ?? '' }}"
            class="form-control">
    </div>
</div>

<div class="section-title">Event Preferences</div>
<div class="row">
    <div class="col-md-6">
        <label>Attended Past Events?</label><br>
        <label>
            <input type="radio" name="attended_past" value="Yes" {{ ($contact->attended_past ?? '') == 'Yes' ? 'checked' : '' }}>
            Yes
        </label>
        <label>
            <input type="radio" name="attended_past" value="No" {{ ($contact->attended_past ?? '') == 'No' ? 'checked' : '' }}>
            No
        </label>
    </div>

    <div class="col-md-6">
        <label>Interested in Forum?</label><br>
        <label>
            <input type="radio" name="interest_forum" value="Yes" {{ ($contact->interest_forum ?? '') == 'Yes' ? 'checked' : '' }}>
            Yes
        </label>
        <label>
            <input type="radio" name="interest_forum" value="No" {{ ($contact->interest_forum ?? '') == 'No' ? 'checked' : '' }}>
            No
        </label>
    </div>
</div>