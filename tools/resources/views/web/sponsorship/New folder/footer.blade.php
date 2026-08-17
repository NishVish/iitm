<style>
    .footer {
        position: absolute;
        bottom: 20px;
        left: 0;
        right: 0;

        display: flex;
        justify-content: space-between;
        padding: 0 25px;

        font-size: 12px;
        color: #666;
        letter-spacing: 1px;
    }

    .footer .left {
        color: #AA2D2C;
        font-weight: 600;
    }

    .footer .right {
        font-weight: 700;
        color: #333;
    }
</style>
@php
    $page = 1;
@endphp
<div class="footer">
    <div class="left">iitmindia.com</div>
    <div class="right">Page {{ $page }}</div>
</div>