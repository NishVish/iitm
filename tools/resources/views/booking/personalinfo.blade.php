<h3>Contact Person</h3>

<div class="form-grid">

    <!-- Contact Info -->
    <label>Contact Name</label>
    <input type="text" name="contact_name" value="{{ $lead->contact_name }}" placeholder="Contact Name">

    <label>Designation</label>
    <input type="text" name="designation" value="{{ $lead->designation }}" placeholder="Designation">

    <!-- Emails -->
    <div style="grid-column: 1 / -1;">
        <h4>Emails</h4>

        @foreach($emails as $email)
            <input type="email" name="emails[]" value="{{ $email->email }}">
        @endforeach

        <input type="email" name="emails[]" placeholder="Add new email">
    </div>

    <!-- Mobile Numbers -->
    <div style="grid-column: 1 / -1;">
        <h4>Mobile Numbers</h4>

        @foreach($mobiles as $mobile)
            <input type="text" name="mobiles[]" value="{{ $mobile->mobile }}">
        @endforeach

        <input type="text" name="mobiles[]" placeholder="Add new mobile">
    </div>

</div>