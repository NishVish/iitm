@include('registration.header')

<h2 style="text-align:center;">Registration Complete</h2>

<div class="container">

    <p><strong>Company:</strong> {{ $company }}</p>
    <p><strong>Mobile:</strong> {{ $mobile }}</p>
    <p><strong>Stall No:</strong> {{ $stallno }}</p>

    <h3>Delegates</h3>

    @php
        $lastsegment = basename($_SERVER['REQUEST_URI']);
        $check = !in_array($lastsegment, ['sanjay', 'usha', 'dilip', 'rohit', 'indira']);
    @endphp

    @if(!empty($delegates))
        @foreach($delegates as $d)

            <div class="delegate" style="margin-bottom:30px;">

                <h2>{{ $d['name'] }}</h2>

                @if($check)
                    <div class="qr-code" style="text-align:center;">

                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode($d['key']) }}"
                            alt="QR Code" style="display:block;margin:10px auto;">

                        <a href="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data={{ urlencode($d['key']) }}"
                            download="qr-code.png">

                            <button class="btn btn-submit" type="button" style="margin-top:10px;">
                                Download QR Code
                            </button>

                        </a>

                    </div>
                    <h2>Key: {{ $d['key'] }}</h2>

                @endif


            </div>

        @endforeach
    @else
        <p>No delegates found</p>
    @endif

    <div class="qr-code" style="text-align:center;">

        <p><strong>Registration Key QR Code:</strong></p>

        <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode($mobile) }}" alt="QR Code"
            style="display:block;margin:10px auto;">

        <a href="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data={{ urlencode($mobile) }}"
            download="qr-code.png">

            <button class="btn btn-submit" type="button" style="margin-top:10px;">
                Download QR Code
            </button>

        </a>

    </div>

    <hr>

    <h2 style="text-align:center;">🎉 You're All Set!</h2>

    <p style="font-size:1.05em;font-weight:500;text-align:center;margin:10px 0;">
        📲 <strong>Final Step:</strong> Please mention your <strong>mobile number</strong> at the
        <strong>registration counter</strong> to print your entry pass.
    </p>

    <p style="text-align:center;">
        🙌 <strong>
            We sincerely appreciate your participation as an exhibitor at the IITM Exhibition.
            We look forward to a successful and engaging event together.
        </strong>
    </p>

</div>