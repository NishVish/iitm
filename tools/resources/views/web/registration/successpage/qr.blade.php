<div style="text-align:center;">
    <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&color=000000&bgcolor=ffffff&data={{ $data['mobile'] }}"
        style="width:150px; height:150px;" />

    <p style="margin:5px 0; font-size:13px;">
        You can take a print of the badge or show this QR at the registration desk.
    </p>

    <p style="margin:0; font-weight:bold;">
        {{ $data['mobile'] }}
    </p>
</div>