<style>
    #qrimage {
        height: auto;
        width: 120px;
        display: block;
        margin: 0px auto 0 auto;
    }
</style>

<div style="text-align: center; ">

    <img id="qrimage"
        src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&color=170-35-36&bgcolor=255-255-255&data=BEGIN:VCARD%0AVERSION:3.0%0AFN:{{ urlencode($data['contactName']) }}%0AORG:{{ urlencode($data['companyName']) }}%0ATEL;TYPE=CELL:{{ $data['mobile'] }}%0AEMAIL:{{ urlencode($data['email']) }}%0ANOTE:Met at IITM Exhibition%0AEND:VCARD"
        alt="Contact QR">
</div>