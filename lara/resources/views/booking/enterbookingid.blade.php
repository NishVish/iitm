<style>
    * {
        box-sizing: border-box;
    }

    body {
        font-family: Arial, sans-serif;
        background: url("https://iitmindia.com/assets/creatives/1.jpg") no-repeat center/cover;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        position: relative;
    }

    /* dark overlay for readability */
    body::before {
        content: "";
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.45);
    }

    .card {
        position: relative;
        background: #fff;
        padding: 30px 28px;
        width: 380px;
        border-radius: 14px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        text-align: center;
        z-index: 1;
        backdrop-filter: blur(4px);
    }

    .logo {
        width: 90px;
        margin-bottom: 12px;
    }

    h2 {
        margin-bottom: 20px;
        font-size: 20px;
        color: #202124;
        font-weight: 600;
    }

    label {
        display: block;
        text-align: left;
        font-size: 13px;
        margin-bottom: 6px;
        color: #5f6368;
    }

    input {
        width: 100%;
        padding: 12px 14px;
        border: 1px solid #dadce0;
        border-radius: 8px;
        font-size: 14px;
        outline: none;
        margin-bottom: 14px;
        transition: 0.2s ease;
    }

    input:focus {
        border-color: #1a73e8;
        box-shadow: 0 0 0 3px rgba(26, 115, 232, 0.2);
    }

    button {
        width: 100%;
        padding: 12px;
        background: linear-gradient(135deg, #1a73e8, #1558b0);
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 15px;
        font-weight: 500;
        transition: 0.2s ease;
    }

    button:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 14px rgba(26, 115, 232, 0.25);
    }

    button:active {
        transform: translateY(0);
    }
</style>

<div class="card">
    <img class="logo" src="https://iitmindia.com/assets/iitm3.png" alt="Logo">

    <h2>Find Your Booking</h2>

    <form onsubmit="goToLead(event)">
        <label>Booking ID</label>
        <input type="text" id="booking_id" placeholder="e.g. BK12345" required>

        <label>Mobile Number</label>
        <input type="text" id="mobile" placeholder="e.g. 9876543210" required>

        <button type="submit">Proceed</button>
    </form>
</div>

<script>
    function goToLead(e) {
        e.preventDefault();

        const id = document.getElementById('booking_id').value.trim();
        const mobile = document.getElementById('mobile').value.trim();

        if (!id || !mobile) return;

        window.location.href = "{{ url('leadsdetails') }}/" + id + "?mobile=" + mobile;
    }
</script>