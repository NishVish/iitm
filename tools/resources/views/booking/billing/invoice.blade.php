@include('booking.header')

@php
    $invoiceNo = 'IITM-' . date('Y') . '-' . rand(10000, 99999);
@endphp

<div class="container" style="max-width:1100px; padding:20px; font-family: 'Segoe UI', Tahoma, sans-serif;">

    {{-- HEADER --}}
    <div
        style="display:flex; justify-content: space-between; align-items: flex-end; margin-bottom: 20px; border-bottom: 3px solid #a4221e; padding-bottom: 10px;">
        <div>
            <h1 style="color: #a4221e; margin: 0; font-size: 28px;">TAX INVOICE</h1>
            <p style="margin: 5px 0; color: #003366; font-weight: bold;">
                India International Travel Mart — Official Portal
            </p>
            <p style="margin:0; font-size:13px; color:#666;">
                Invoice No: <strong>{{ $invoiceNo }}</strong>
            </p>
        </div>

        <div style="text-align:right;">
            <img src="https://iitmindia.com/assets/iitm3.png" style="height:50px;">
            <div style="font-size:12px; color:#666;">Date: {{ date('d-M-Y') }}</div>
        </div>
    </div>

    {{-- BILLING INFO --}}
    <div style="display:flex; gap:30px; margin-bottom:20px;">

        <div style="flex:1; border:1px solid #eee; padding:15px;">
            <h4 style="color:#003366; margin-top:0;">Billed To</h4>
            <p style="margin:0;"><strong>{{ strtoupper($lead->company_name) }}</strong></p>
            <p style="margin:3px 0;">{{ $lead->address }}</p>
            <p style="margin:3px 0;">{{ $lead->city }}, {{ $lead->state }}</p>
            <p style="margin:5px 0;"><strong>GSTIN:</strong> {{ $lead->gst_number ?? 'N/A' }}</p>
        </div>

        <div style="flex:1; border:1px solid #eee; padding:15px;">
            <h4 style="color:#003366; margin-top:0;">Contact</h4>
            <p style="margin:0;"><strong>{{ $lead->contact_name }}</strong></p>
            <p style="margin:3px 0;">{{ $emails[0]->email ?? '' }}</p>
            <p style="margin:3px 0;">{{ $mobiles[0]->mobile ?? '' }}</p>
        </div>

    </div>

    {{-- TABLE --}}
    <h4 style="color:#003366;">Invoice Details</h4>

    <table width="100%" cellpadding="10" style="border-collapse:collapse; font-size:14px;">
        <thead>
            <tr style="background:#003366; color:#fff;">
                <th align="left">Location</th>
                <th>Stall Type</th>
                <th>Size (sqm)</th>
                <th align="right">Amount</th>
                <th align="right">GST</th>
                <th align="right">Total</th>
            </tr>
        </thead>

        <tbody>
            @php
                $base = 0;
                $gst = 0;
                $grand = 0;
            @endphp

            @foreach($locations as $loc)
                @php
                    $rowTotal = $loc->amount + $loc->gst;
                    $base += $loc->amount;
                    $gst += $loc->gst;
                    $grand += $rowTotal;
                @endphp

                <tr style="border-bottom:1px solid #eee;">
                    <td><strong>{{ $loc->location }}</strong></td>
                    <td align="center">{{ $loc->stall_location }}</td>
                    <td align="center">{{ $loc->size }}</td>
                    <td align="right">{{ number_format($loc->amount, 2) }}</td>
                    <td align="right">{{ number_format($loc->gst, 2) }}</td>
                    <td align="right"><strong>{{ number_format($rowTotal, 2) }}</strong></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- TOTALS --}}
    <div style="margin-top:20px; display:flex; justify-content:flex-end;">
        <div style="width:320px; border:1px solid #ddd; padding:15px; background:#fafafa;">

            <div style="display:flex; justify-content:space-between;">
                <span>Subtotal</span>
                <strong>₹{{ number_format($base, 2) }}</strong>
            </div>

            <div style="display:flex; justify-content:space-between;">
                <span>GST</span>
                <strong>₹{{ number_format($gst, 2) }}</strong>
            </div>

            <hr>

            <div style="display:flex; justify-content:space-between; font-size:18px; color:#a4221e;">
                <span><strong>Grand Total</strong></span>
                <strong>₹{{ number_format($grand, 2) }}</strong>
            </div>

        </div>
    </div>

    {{-- FOOTER --}}
    <div style="margin-top:25px; font-size:12px; color:#666; border-top:1px solid #eee; padding-top:10px;">
        <p><strong>Note:</strong> This is a computer-generated tax invoice.</p>
        <p>Sphere Travelmedia & Exhibitions Pvt. Ltd.</p>
    </div>

</div>