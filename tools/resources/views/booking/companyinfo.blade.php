<h3>Company Details</h3>

<div class="form-grid">
    <label>Company Name</label>
    <input type="text" name="company_name" value="{{ $lead->company_name }}" placeholder="Company Name" required>

    <label>GST Number</label>
    <input type="text" name="gst_number" value="{{ $lead->gst_number }}" placeholder="GST Number">

    <label>Company Phone</label>
    <input type="text" name="phone" value="{{ $lead->phone }}" placeholder="Company Phone">

    <label>Website</label>
    <input type="text" name="website" value="{{ $lead->website }}" placeholder="Website">

    <label>Address</label>
    <textarea name="address" placeholder="Address">{{ $lead->address }}</textarea>
</div>