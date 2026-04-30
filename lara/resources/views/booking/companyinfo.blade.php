<h3>Company Details</h3>

<input type="text" name="company_name" value="{{ $lead->company_name }}" placeholder="Company Name" required>

<input type="text" name="gst_number" value="{{ $lead->gst_number }}" placeholder="GST Number">

<input type="text" name="phone" value="{{ $lead->phone }}" placeholder="Company Phone">

<input type="text" name="website" value="{{ $lead->website }}" placeholder="Website">

<textarea name="address" placeholder="Address">{{ $lead->address }}</textarea>