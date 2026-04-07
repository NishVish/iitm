<div class="registration-container">
    <form action="{{ route('registration.submit') }}" method="POST">
        @csrf

        <input type="hidden" name="contact_id" value="{{ session('contact.contact_id') }}">
        <input type="hidden" name="priority" value="{{ session('contact.priority') }}">
        <input type="hidden" name="contact_created_at" value="{{ session('contact.created_at') }}">
        <input type="hidden" name="contact_updated_at" value="{{ session('contact.updated_at') }}">
        <input type="hidden" name="attendance_reason" value="{{ session('contact.attendance_reason') }}">
        <input type="hidden" name="buyer_responsibility" value="{{ session('contact.buyer_responsibility') }}">
        <input type="hidden" name="business_card_path" value="{{ session('contact.business_card_path') }}">
        <input type="hidden" name="image_path" value="{{ session('contact.image') }}">

        <input type="hidden" name="company_db_id" value="{{ session('company.id') }}">
        <input type="hidden" name="company_id_code" value="{{ session('company_id') }}"> <input type="hidden"
            name="database_name" value="{{ session('company.database_name') }}">
        <input type="hidden" name="outbound_flag" value="{{ session('company.outbound') }}">
        <input type="hidden" name="category_code" value="{{ session('company.category') }}">
        <input type="hidden" name="active_status" value="{{ session('company.active_inactive') }}">
        <input type="hidden" name="comp_created_at" value="{{ session('company.created_at') }}">
        <input type="hidden" name="comp_updated_at" value="{{ session('company.updated_at') }}">
        <input type="hidden" name="last_confirmed" value="{{ session('company.last_confirmed_at') }}">
        <input type="hidden" name="session_val" value="{{ session('company.session') }}">
        <input type="hidden" name="cross_val" value="{{ session('company.cross_validation') }}">
        <input type="hidden" name="last_comments" value="{{ session('company.last_comments') }}">
        <input type="hidden" name="sec_last_comments" value="{{ session('company.second_last_comments') }}">
        <input type="hidden" name="updated_by" value="{{ session('company.updated_by') }}">
        <input type="hidden" name="entry_type" value="{{ session('company.entry_type') }}">
        <input type="hidden" name="total_staff" value="{{ session('company.total_staff') }}">

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
                    <label>Mobile (Verified)</label>
                    <input type="text" name="mobile" value="{{ session('contact.mobiles.0') }}" class="form-control"
                        readonly>
                </div>
                <div class="form-group col-6">
                    <label>Email ID</label>
                    <input type="email" name="email" value="{{ session('contact.emails.0') }}" class="form-control">
                </div>
            </div>
        </div>

        <div class="form-card">
            <h3>Organization Details</h3>
            <div class="form-group">
                <label>Company Name</label>
                <input type="text" name="company_name" value="{{ session('company.company_name') }}"
                    class="form-control">
            </div>

            <div class="row">
                <div class="form-group col-4">
                    <label>City</label>
                    <input type="text" name="city" value="{{ session('company.city') }}" class="form-control">
                </div>
                <div class="form-group col-4">
                    <label>State</label>
                    <input type="text" name="state" value="{{ session('company.state') }}" class="form-control">
                </div>
                <div class="form-group col-4">
                    <label>Pincode</label>
                    <input type="text" name="pincode" value="{{ session('company.pincode') }}" class="form-control">
                </div>
            </div>

            <div class="row">
                <div class="form-group col-6">
                    <label>Country</label>
                    <input type="text" name="country" value="{{ session('company.country') }}" class="form-control">
                </div>
                <div class="form-group col-6">
                    <label>Website</label>
                    <input type="text" name="website" value="{{ session('company.website') }}" class="form-control">
                </div>
            </div>
        </div>

        <div class="form-card">
            <label>Attended Past Events?</label>
            <input type="radio" name="attended_past" value="Yes" {{ session('contact.attended_past') == 'Yes' ? 'checked' : '' }}> Yes
            <input type="radio" name="attended_past" value="No" {{ session('contact.attended_past') == 'No' ? 'checked' : '' }}> No

            <br>

            <label>Interested in Forum?</label>
            <input type="radio" name="interest_forum" value="Yes" {{ session('contact.interest_forum') == 'Yes' ? 'checked' : '' }}> Yes
            <input type="radio" name="interest_forum" value="No" {{ session('contact.interest_forum') == 'No' ? 'checked' : '' }}> No
        </div>

        <button type="submit" class="btn-submit">Update & Finalize Registration</button>
    </form>
</div>