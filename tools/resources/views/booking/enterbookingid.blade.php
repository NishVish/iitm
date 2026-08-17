<style>
    body {
        font-family: Arial;
        background: #f5f6fa;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .card {
        background: #fff;
        padding: 25px;
        width: 380px;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    .icon {
        font-size: 40px;
        margin-bottom: 10px;
    }

    input,
    button {
        width: 100%;
        padding: 10px;
        margin-top: 10px;
        border-radius: 6px;
        border: 1px solid #ddd;
    }

    button {
        background: #1a73e8;
        color: #fff;
        border: none;
        cursor: pointer;
    }

    button:hover {
        background: #1558b0;
    }

    .error-box {
        background: #ffe5e5;
        color: #b00020;
        padding: 10px;
        border-radius: 6px;
        margin-bottom: 10px;
        font-size: 14px;
    }
</style>

<div class="card">

    <h2>Find Your Booking</h2>

    {{-- ❌ ERROR ONLY --}}
    @if(session('error'))
        <div class="error-box">
            ❌ {{ session('error') }}
        </div>
    @endif

    {{-- 🔎 ALWAYS SHOW FORM --}}
    <form onsubmit="goToLead(event)">
        <input type="text" id="booking_id" placeholder="Booking ID" required>
        <input type="text" id="mobile" placeholder="Mobile Number" required>

        <button type="submit">Proceed</button>
    </form>

</div>

<script>
    function goToLead(e) {
        e.preventDefault();

        const id = document.getElementById('booking_id').value.trim();
        const mobile = document.getElementById('mobile').value.trim();

        if (!id || !mobile) return;

        window.location.href =
            "{{ url('leadsdetails') }}/" + encodeURIComponent(id) +
            "?mobile=" + encodeURIComponent(mobile);
    }
</script>