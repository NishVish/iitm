<div id="auth-modal"
    style="display:none; position:fixed; inset:0; z-index:9999; align-items:center; justify-content:center; background:rgba(0,0,0,0.7); font-family:sans-serif;">
    <div
        style="background:white; padding:25px; border-radius:12px; width:100%; max-width:400px; position:relative; color:#333; box-shadow: 0 10px 25px rgba(0,0,0,0.2);">
        <button onclick="toggleModal()"
            style="position:absolute; right:15px; top:15px; border:none; background:none; font-size:24px; cursor:pointer; color:#888;">&times;</button>

        <h3 style="margin-top:0; color:#1e3a8a;">Register Interest</h3>

        <div
            style="background:#f8fafc; padding:15px; border-radius:8px; margin-bottom:20px; border:1px solid #e2e8f0; font-size:14px;">
            <div style="margin-bottom:8px;"><strong>Event:</strong> <span id="view_event_name"></span></div>
            <div style="margin-bottom:8px;"><strong>Year:</strong> <span id="view_year"></span></div>
            <div style="margin-bottom:8px;"><strong>Venue:</strong> <span id="view_venue"></span></div>
            <div style="margin-bottom:8px;"><strong>Date:</strong> <span id="view_date"></span></div>
            <div><strong>Coordinator:</strong> <span id="view_coordinator"></span></div>
        </div>

        <form method="POST" action="{{ url('/request-otp') }}">
            @csrf
            <input type="hidden" name="event_id" id="modal_event_id">
            <input type="hidden" name="event_name" id="modal_event_name">
            <input type="hidden" name="year" id="modal_year">
            <input type="hidden" name="venue_details" id="modal_venue_details">
            <input type="hidden" name="coordinator" id="modal_coordinator">
            <input type="hidden" name="start_date" id="modal_start_date">

            <div style="margin-bottom:15px;">
                <label style="display:block; font-size:13px; font-weight:bold; margin-bottom:8px;">Your Mobile or
                    Email</label>
                <input type="text" name="input" required placeholder="Ex: 9876543210 or mail@example.com"
                    style="width:100%; padding:12px; border:1px solid #cbd5e1; border-radius:6px; box-sizing:border-box; font-size:15px;">
            </div>

            <button type="submit"
                style="width:100%; padding:14px; background:#2563eb; color:white; border:none; border-radius:6px; font-weight:bold; cursor:pointer; font-size:16px;">
                Submit Registration
            </button>
        </form>
    </div>
</div>