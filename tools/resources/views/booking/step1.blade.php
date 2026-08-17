<h3>Contact Person</h3>

<input type="text" name="contact_name" value="{{ $lead->contact_name }}" placeholder="Contact Name">

<input type="text" name="designation" value="{{ $lead->designation }}" placeholder="Designation">

<!-- Emails -->
<h4>Emails</h4>
@foreach($emails as $email)
    <input type="email" name="emails[]" value="{{ $email->email }}">
@endforeach
<input type="email" name="emails[]" placeholder="Add new email">


<!-- Mobiles -->
<h4>Mobile Numbers</h4>
@foreach($mobiles as $mobile)
    <input type="text" name="mobiles[]" value="{{ $mobile->mobile }}">
@endforeach
<input type="text" name="mobiles[]" placeholder="Add new mobile">