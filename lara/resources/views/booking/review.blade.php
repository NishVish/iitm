@include('booking.header')

<div class="container" style="max-width:1100px; padding:20px;">

    <h2>Booking Review</h2>
    <p>India International Travel Mart — Official Portal</p>

    <div style="display:flex; gap:20px;">

        {{-- LEFT --}}
        <div style="flex:2;">

            <div class="box">
                <h3>Exhibitor Details</h3>

                <p><b>{{ strtoupper($lead->company_name) }}</b></p>
                <p>{{ $lead->address }}, {{ $lead->city }}</p>
                <p>GST: {{ $lead->gst_number ?? 'N/A' }}</p>

                <hr>

                <p><b>Contact</b></p>
                <p>{{ $lead->contact_name }}</p>
                <p>{{ $emails[0]->email ?? '' }}</p>
                <p>{{ $mobiles[0]->mobile ?? '' }}</p>
            </div>

            <div class="box">
                <h3>Lead Locations</h3>

                <table border="1" width="100%" cellpadding="8">
                    <tr>
                        <th>Location</th>
                        <th>Stall</th>
                        <th>Size</th>
                        <th>Amount</th>
                        <th>GST</th>
                    </tr>

                    @php $total = 0; @endphp

                    @foreach($locations as $loc)
                        <tr>
                            <td>{{ $loc->location }}</td>
                            <td>{{ $loc->stall_location }}</td>
                            <td>{{ $loc->size }}</td>
                            <td>{{ $loc->amount }}</td>
                            <td>{{ $loc->gst }}</td>
                        </tr>

                        @php $total += ($loc->amount ?? 0) + ($loc->gst ?? 0); @endphp
                    @endforeach
                </table>

            </div>

        </div>

        {{-- RIGHT --}}
        <div style="flex:1;">

            <div class="box">
                <h3>Total</h3>

                <p>Subtotal: ₹{{ number_format($total / 1.18, 2) }}</p>
                <p>GST Included</p>

                <hr>

                <h2>₹ {{ number_format($total, 2) }}</h2>

                <button onclick="payNow()" style="width:100%; padding:10px; background:#0054a6; color:#fff;">
                    Pay Now
                </button>

                <br><br>

                <a href="{{ url()->previous() }}">Modify</a>
            </div>

        </div>

    </div>
</div>


<div>

    full payment
    partial payment

</div>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>
    function payNow() {

        var options = {
            key: "rzp_test_SjJuZPt7y1odXP",
            amount: {{ $total * 100 }},
            currency: "INR",
            name: "IITM India",
            description: "Booking - {{ $lead->company_name }}",
            image: "https://iitmindia.com/assets/iitm3.png",
            prefill: {
                name: "{{ $lead->contact_name }}",
                email: "{{ $emails[0]->email ?? '' }}",
                contact: "{{ $mobiles[0]->mobile ?? '' }}"
            },
            method: {
                upi: true
            },
            handler: function (response) {
                window.location.href = "{{ url('/payment-success') }}"
                    + "?payment_id=" + response.razorpay_payment_id
                    + "&lead_id={{ $lead->lead_id }}";
            }
        };

        new Razorpay(options).open();
    }
</script>

<style>
    .box {
        border: 1px solid #ddd;
        padding: 15px;
        margin-bottom: 15px;
        background: #fff;
    }

    table {
        border-collapse: collapse;
    }

    th,
    td {
        text-align: left;
    }
</style>