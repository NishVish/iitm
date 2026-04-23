<div id="auth-modal"
    style="position:fixed; inset:0; z-index:9999; display:none; align-items:center; justify-content:center; background:rgba(0,0,0,0.7);">
    <div style="width:100%; max-width:400px; background:#fff; border-radius:12px; padding:24px; color:#333;">
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <h3>Secure Login</h3>
            <button onclick="toggleModal()"
                style="border:none; background:none; font-size:24px; cursor:pointer;">&times;</button>
        </div>

        <form id="otp-form" method="POST" action="{{ url('/request-otp') }}">
            @csrf
            <input type="hidden" name="event_id" id="modal_event_id" value="">

            <label style="display:block; margin-bottom:5px;">Mobile or Email</label>
            <input type="text" id="user_input" name="input" required
                style="width:100%; padding:10px; border:1px solid #ccc; border-radius:4px;"
                placeholder="Enter mobile or email">

            <button type="submit" id="btn-send-otp"
                style="width:100%; margin-top:15px; padding:12px; background:#2563eb; color:#fff; border:none; border-radius:4px; font-weight:bold; cursor:pointer;">
                Get Started
            </button>
        </form>
    </div>
</div>