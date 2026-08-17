<style>
    .booking-footer {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        background: #fff;
        border-top: 1px solid #ddd;
        display: flex;
        justify-content: center;
        gap: 15px;
        padding: 12px 0;
        z-index: 999;
    }

    .booking-footer a {
        padding: 10px 18px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: bold;
        border: 1px solid #007bff;
        color: #007bff;
        transition: 0.2s;
    }

    .booking-footer a.active,
    .booking-footer a:hover {
        background: #007bff;
        color: #fff;
    }
</style>

<div class="booking-footer">
    <a href="{{ url('booking/step1') }}" class="{{ request()->is('booking/step1') ? 'active' : '' }}">
        Step 1
    </a>

    <a href="{{ url('booking/step2') }}" class="{{ request()->is('booking/step2') ? 'active' : '' }}">
        Step 2
    </a>

    <a href="{{ url('booking/step3') }}" class="{{ request()->is('booking/step3') ? 'active' : '' }}">
        Step 3
    </a>
</div>