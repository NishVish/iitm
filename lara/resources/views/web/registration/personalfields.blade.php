<div class="form-card active" id="step2">
    <h3>Personal Profile</h3>
    <div class="row g-3">
        <div class="col-md-6 form-group">
            <label>Full Name</label>
            <input type="text" name="name" value="{{ $contact['name'] }}" class="form-control">
        </div>
        <div class="col-md-6 form-group">
            <label>Designation</label>
            <input type="text" name="designation" value="{{ $contact['designation'] }}" class="form-control">
        </div>
        <div class="col-md-6 form-group">
            <label>Mobile</label>
            <input type="text" name="mobile" value="{{ $contact['mobiles'][0] ?? '' }}" class="form-control">
        </div>
        <div class="col-md-6 form-group">
            <label>Email</label>
            <input type="email" name="email" value="{{ $contact['emails'][0] ?? '' }}" class="form-control">
        </div>
    </div>
    <div class="d-flex justify-content-end mt-4">
        <button type="button" class="btn-next" onclick="goToStep(3)">Organization Details →</button>
    </div>
</div>