@php
    $status = strtolower($leadinfo->payment_status);

    $isPaid = $status === 'paid';
    $isPending = $status === 'pending' || $status === 'unpaid';

    $headerClass = $isPaid ? 'success' : ($isPending ? 'warning' : 'danger');
    $headerText = $isPaid ? 'Booking Confirmed' : ($isPending ? 'Payment Pending' : 'Payment Failed');
    $headerIcon = $isPaid ? '✅' : ($isPending ? '⏳' : '❌');
@endphp

<div
    style="display: flex; justify-content: center; align-items: center; min-height: 100vh; background-color: #f4f7f6; padding: 20px;">

    <div style="width: 100%; max-width: 900px;">

        {{-- DOWNLOAD BUTTON --}}
        <div style="text-align:right; margin-bottom:10px;">
            <button onclick="downloadInvoice()"
                style="padding:10px 16px; background:#003366; color:#fff; border:none; border-radius:4px; cursor:pointer; font-weight: bold; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                ⬇ Download PDF
            </button>
        </div>

        {{-- INVOICE WRAPPER --}}
        <div id="invoice"
            style="background: #fff; box-shadow: 0 0 20px rgba(0,0,0,0.1); border-radius: 8px; overflow: hidden;">

            @if($isPaid)
                @include('booking.billing.invoice')
            @endif

            @if($isPending)
                @include('booking.billing.performa')

                <div style="padding: 40px; text-align: center;">
                    <h2 style="color: #fbbf24;">{{ $headerIcon }} {{ $headerText }}</h2>
                    <p>Please complete your payment to generate the final invoice.</p>
                </div>
            @endif

        </div>

    </div>
</div>

{{-- JS LIBRARY --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<script>
    function downloadInvoice() {
        const element = document.getElementById('invoice');

        const opt = {
            margin: 0.3,
            filename: 'iitm-invoice-{{ $leadinfo->lead_id }}.pdf',
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2, useCORS: true },
            jsPDF: { unit: 'in', format: 'a4', orientation: 'portrait' }
        };

        html2pdf().set(opt).from(element).save();
    }
</script>