<div id="mailPopup"
    style="display:none; position:fixed; top:20%; left:35%; width:400px; background:#fff; border:1px solid #ccc; padding:20px; z-index:999;">
    <h3>Send Mail</h3>

    <p><strong>Lead ID:</strong> <span id="m_lead_id"></span></p>

    <form method="POST" action="{{ url('sendmail') }}">
        @csrf

        <input type="hidden" name="lead_id" id="lead_id">
        <input type="hidden" name="company_id" id="company_id">
        <input type="hidden" name="contact_id" id="contact_id">

        <label>Select Mail Type</label><br>
        <select name="type" id="mail_type">
            <option value="reminder">Reminder Mail</option>
            <option value="proposal">Proposal Mail</option>
            <option value="thankyou">Thank You Mail</option>
        </select>

        <br><br>

        <textarea name="message" id="mail_message" rows="5" style="width:100%;"
            placeholder="Write message..."></textarea>

        <br><br>

        <button type="submit">Send</button>
        <button type="button" onclick="closeMailPopup()">Close</button>
    </form>
</div>

<script>
    let selectedLead = null;

    function openMailPopup(lead) {
        selectedLead = lead;

        document.getElementById('mailPopup').style.display = 'block';

        document.getElementById('m_lead_id').innerText = lead.lead_id;

        document.getElementById('lead_id').value = lead.lead_id;
        document.getElementById('company_id').value = lead.company_id;
        document.getElementById('contact_id').value = lead.contact_id;

        document.getElementById('mail_type').value = 'reminder';
        document.getElementById('mail_message').value = '';
    }

    function closeMailPopup() {
        document.getElementById('mailPopup').style.display = 'none';
    }
</script>