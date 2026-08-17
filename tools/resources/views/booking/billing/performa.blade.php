@include('booking.header')

<div class="container" style="max-width:1100px; padding:20px; font-family: 'Segoe UI', Tahoma, sans-serif;">

    <div style="display:flex; justify-content: space-between; align-items: flex-end; margin-bottom: 20px; border-bottom: 3px solid #a4221e; padding-bottom: 10px;">
        <div>
            <h1 style="color: #a4221e; margin: 0; font-size: 28px;">PROFORMA INVOICE</h1>
            <p style="margin: 5px 0; color: #003366; font-weight: bold;">India International Travel Mart — Official Portal</p>
        </div>
        <div style="text-align: right;">
            <img src="https://iitmindia.com/assets/iitm3.png" alt="Logo" style="height: 50px; margin-bottom: 5px;">
            <div style="font-size: 12px; color: #666;">Date: {{ date('d-M-Y') }}</div>
        </div>
    </div>

    <div style="display:flex; gap:30px;">

        <div style="flex:2; background: #fff; padding: 10px;">
            
            <div style="display: flex; gap: 20px; margin-bottom: 30px;">
                <div style="flex: 1;">
                    <h4 style="color: #003366; border-bottom: 1px solid #ddd; padding-bottom: 5px; margin-bottom: 10px;">Exhibitor Details</h4>
                    <p style="margin: 0; font-size: 15px;"><strong>{{ strtoupper($lead->company_name) }}</strong></p>
                    <p style="margin: 2px 0; color: #555;">{{ $lead->address }}</p>
                    <p style="margin: 2px 0; color: #555;">{{ $lead->city }}, {{ $lead->state }}</p>
                    <p style="margin: 5px 0;"><strong>GSTIN:</strong> {{ $lead->gst_number ?? 'N/A' }}</p>
                </div>
                <div style="flex: 1;">
                    <h4 style="color: #003366; border-bottom: 1px solid #ddd; padding-bottom: 5px; margin-bottom: 10px;">Contact Person</h4>
                    <p style="margin: 0;"><strong>{{ $lead->contact_name }}</strong></p>
                    <p style="margin: 2px 0; color: #555;">{{ $emails[0]->email ?? '' }}</p>
                    <p style="margin: 2px 0; color: #555;">{{ $mobiles[0]->mobile ?? '' }}</p>
                </div>
            </div>

            <h4 style="color: #003366; margin-bottom: 10px;">Participation Schedule</h4>
            <table class="invoice-table" width="100%" cellpadding="12">
                <thead>
                    <tr style="background: #003366; color: #fff;">
                        <th>Location</th>
                        <th>Stall Type</th>
                        <th>Size (sqm)</th>
                        <th style="text-align: right;">Base Amount</th>
                        <th style="text-align: right;">GST</th>
                        <th style="text-align: right;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @php $grandTotal = 0; $totalGst = 0; $totalBase = 0; @endphp
                    @foreach($locations as $loc)
                        <tr>
                            <td><strong>{{ $loc->location }}</strong></td>
                            <td>{{ $loc->stall_location }}</td>
                            <td>{{ $loc->size }}</td>
                            <td style="text-align: right;">{{ number_format($loc->amount, 2) }}</td>
                            <td style="text-align: right;">{{ number_format($loc->gst, 2) }}</td>
                            <td style="text-align: right; font-weight: bold;">{{ number_format($loc->amount + $loc->gst, 2) }}</td>
                        </tr>
                        @php 
                            $totalBase += $loc->amount;
                            $totalGst += $loc->gst;
                            $grandTotal += ($loc->amount + $loc->gst); 
                        @endphp
                    @endforeach
                </tbody>
            </table>

            <div style="margin-top: 20px; background: #f9f9f9; padding: 15px; border: 1px solid #eee;">
                <p style="font-size: 12px; color: #666; margin: 0;"><strong>Note:</strong> This is a computer-generated Proforma Invoice. Participation is subject to stall availability and realization of payment.</p>
            </div>
        </div>

        {{-- SIDEBAR PAYMENT PANEL --}}
        <div style="flex: 0.8;">
            <div class="payment-box">
                <h3 style="margin-top: 0; color: #003366;">Payment Summary</h3>
                
                <div class="summary-row">
                    <span>Total Base Value:</span>
                    <span>₹{{ number_format($totalBase, 2) }}</span>
                </div>
                <div class="summary-row">
                    <span>Service Tax/GST:</span>
                    <span>₹{{ number_format($totalGst, 2) }}</span>
                </div>
                <hr>
                <div class="summary-row" style="font-size: 22px; font-weight: bold; color: #a4221e; padding: 10px 0;">
                    <span>Grand Total:</span>
                    <span>₹{{ number_format($grandTotal, 2) }}</span>
                </div>

                <div style="margin: 20px 0; padding: 15px; border: 1px solid #fbbf24; background: #fffbeb; border-radius: 4px;">
                    <p style="margin: 0 0 10px 0; font-weight: bold; font-size: 13px;">Select Payment Option:</p>
                    <label style="display: block; margin-bottom: 8px; cursor: pointer;">
                        <input type="radio" name="pay_type" value="full" checked> <strong>Full Payment</strong> (100%)
                    </label>
                    <label style="display: block; cursor: pointer;">
                        <input type="radio" name="pay_type" value="partial"> <strong>Token Payment</strong> (50%)
                    </label>
                </div>

                <button onclick="payNow()" class="btn-pay">
                    Secure Checkout with Razorpay
                </button>

                <div style="text-align: center; margin-top: 15px;">
                    <a href="{{ url()->previous() }}" style="color: #666; text-decoration: none; font-size: 13px;">← Back to Modify Booking</a>
                </div>
            </div>

            <div style="margin-top: 20px; font-size: 11px; color: #999; text-align: center;">
                Official Events by Sphere Travelmedia & Exhibitions Pvt. Ltd.
            </div>
        </div>

    </div>
</div>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>
    function payNow() {
        // Logic to check for partial payment
        let amountToPay = {{ $grandTotal }};
        const payType = document.querySelector('input[name="pay_type"]:checked').value;
        
        if(payType === 'partial') {
            amountToPay = amountToPay / 2;
        }

        var options = {
            key: "rzp_test_SjJuZPt7y1odXP",
            amount: (amountToPay * 100).toFixed(0),
            currency: "INR",
            name: "IITM India",
            description: "Booking - {{ $lead->company_name }} (" + payType + ")",
            image: "https://iitmindia.com/assets/iitm3.png",
            prefill: {
                name: "{{ $lead->contact_name }}",
                email: "{{ $emails[0]->email ?? '' }}",
                contact: "{{ $mobiles[0]->mobile ?? '' }}"
            },
            theme: { color: "#a4221e" },
            handler: function (response) {
                window.location.href = "{{ url('/payment-success') }}"
                    + "?payment_id=" + response.razorpay_payment_id
                    + "&lead_id={{ $lead->lead_id }}"
                    + "&amount=" + amountToPay;
            }
        };

        new Razorpay(options).open();
    }
</script>

<style>
    .payment-box {
        border: 1px solid #003366;
        padding: 20px;
        background: #f8faff;
        border-radius: 8px;
        position: sticky;
        top: 20px;
    }

    .invoice-table {
        border-collapse: collapse;
        margin-top: 10px;
        font-size: 14px;
    }

    .invoice-table th {
        text-transform: uppercase;
        font-size: 12px;
        letter-spacing: 0.5px;
    }

    .invoice-table td {
        border-bottom: 1px solid #eee;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        margin: 8px 0;
        font-size: 14px;
    }

    .btn-pay {
        width: 100%;
        padding: 15px;
        background: #a4221e;
        color: #fff;
        border: none;
        border-radius: 5px;
        font-weight: bold;
        font-size: 16px;
        cursor: pointer;
        transition: 0.3s;
    }

    .btn-pay:hover {
        background: #003366;
    }

    hr {
        border: 0;
        border-top: 1px solid #ccc;
        margin: 15px 0;
    }
</style>