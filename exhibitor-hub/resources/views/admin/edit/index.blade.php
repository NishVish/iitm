<!DOCTYPE html>
<html>

<head>
    <title>Edit Booking</title>
</head>


<body>


    <h2>Edit Booking</h2>


    <form method="POST" action="{{ route('admin.update', $booking->booking_id) }}">


        @csrf

        @method('PUT')


        <label>
            Company
        </label>

        <input type="text" value="{{ $booking->company->company_name }}" readonly>


        <br><br>


        <label>
            Event
        </label>

        <input type="text" value="{{ $booking->event->event_name }}" readonly>


        <br><br>


        <label>
            Location
        </label>

        <input type="text" value="{{ $booking->event->location }}" readonly>


        <br><br>


        <label>
            Stall Number
        </label>

        <input type="text" name="stall_number" value="{{ $booking->stall_number }}">


        <br><br>


        <label>
            Stall Size
        </label>

        <input type="text" name="stall_size" value="{{ $booking->stall_size }}">


        <br><br>


        <label>
            Fascia Name
        </label>

        <input type="text" name="fascia_name" value="{{ $booking->fascia_name }}">


        <br><br>


        <label>
            Certificate Name
        </label>

        <input type="text" name="certificate_name" value="{{ $booking->certificate_name }}">


        <br><br>


        <h3>Delegates</h3>


        @foreach($booking->delegates as $delegate)

            <p>
                {{ $delegate->name }}
                -
                {{ $delegate->designation }}
                -
                {{ $delegate->mobile }}
            </p>

        @endforeach



        <h3>Branding</h3>


        @foreach($booking->branding as $brand)

            <p>
                {{ $brand->branding_type }}
                :
                {{ $brand->branding_description }}
            </p>

        @endforeach



        <h3>Payments</h3>


        @foreach($booking->payments as $payment)

            <p>
                Invoice:
                {{ $payment->invoice_number }}

                Amount:
                {{ $payment->amount }}

                Status:
                {{ $payment->payment_status }}
            </p>

        @endforeach



        <button type="submit">
            Update
        </button>


    </form>


</body>

</html>