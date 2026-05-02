@php
    $status = strtolower($leadinfo->payment_status);

    $isPaid = $status === 'paid';
    $isPending = $status === 'pending' || $status === 'unpaid';

    $headerClass = $isPaid ? 'success' : ($isPending ? 'warning' : 'danger');
    $headerText = $isPaid ? 'Booking Confirmed' : ($isPending ? 'Payment Pending' : 'Payment Failed');
    $headerIcon = $isPaid ? '✅' : ($isPending ? '⏳' : '❌');
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Booking Status</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6f9;
        }

        .ticket-card {
            max-width: 750px;
            margin: 40px auto;
            border-radius: 15px;
            overflow: hidden;
        }

        .ticket-header.success {
            background: linear-gradient(135deg, #28a745, #218838);
        }

        .ticket-header.warning {
            background: linear-gradient(135deg, #ffc107, #e0a800);
            color: #000;
        }

        .ticket-header.danger {
            background: linear-gradient(135deg, #dc3545, #b02a37);
        }

        .ticket-header {
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        .ticket-body {
            padding: 25px;
            background: #fff;
        }

        .stall-box {
            border: 1px dashed #ccc;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 10px;
        }

        .total-box {
            font-size: 20px;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class="card shadow-lg ticket-card">

        {{-- Header --}}
        <div class="ticket-header {{ $headerClass }}">
            <h2>{{ $headerIcon }} {{ $headerText }}</h2>

            @if($isPaid)
                <p class="mb-0">Your stall has been successfully booked</p>
            @elseif($isPending)
                <p class="mb-0">Please complete payment to confirm booking</p>
            @else
                <p class="mb-0">There was an issue with your payment</p>
            @endif
        </div>

        {{-- Body --}}
        <div class="ticket-body">

            {{-- Basic Info --}}
            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>Booking ID:</strong> #{{ $leadinfo->lead_id }}</p>
                    <p><strong>Exhibitor:</strong> {{ $leadinfo->exhibitor }}</p>
                </div>

                <div class="col-md-6 text-md-end">
                    <p><strong>Year:</strong> {{ $leadinfo->exhibition_year }}</p>
                    <p>
                        <strong>Status:</strong>
                        <span class="badge bg-{{ $headerClass }}">
                            {{ ucfirst($leadinfo->payment_status) }}
                        </span>
                    </p>
                </div>
            </div>

            {{-- Stall Details --}}
            <h5 class="mb-3">🎟️ Stall Details</h5>

            @php $grandTotal = 0; @endphp

            @foreach($locations as $item)
                @php
                    $total = $item->amount + $item->gst;
                    $grandTotal += $total;
                @endphp

                <div class="stall-box d-flex justify-content-between">
                    <div>
                        <strong>{{ $item->location }}</strong><br>
                        Stall: {{ $item->stall_location }}<br>
                        Size: {{ $item->size }}
                    </div>

                    <div class="text-end">
                        ₹{{ number_format($total, 2) }}
                    </div>
                </div>
            @endforeach

            {{-- Total --}}
            <div class="d-flex justify-content-between border-top pt-3 mt-3 total-box">
                <span>{{ $isPaid ? 'Total Paid' : 'Total Amount' }}</span>
                <span class="{{ $isPaid ? 'text-success' : 'text-warning' }}">
                    ₹{{ number_format($grandTotal, 2) }}
                </span>
            </div>

            {{-- Warning Message --}}
            @if($isPending)
                <div class="alert alert-warning mt-3">
                    Your booking is not confirmed yet. Please complete payment.
                </div>
            @endif

            @if(!$isPaid && !$isPending)
                <div class="alert alert-danger mt-3">
                    Payment failed. Please try again.
                </div>
            @endif

            {{-- Footer --}}
            <div class="text-muted mt-3">
                <small>
                    Confirmation for: {{ $leadinfo->contact_name ?? 'N/A' }}
                </small>
            </div>

            @if($isPaid)

                <hr class="my-4">

                <div class="card border-success">
                    <div class="card-header bg-success text-white">
                        🎉 Booking Benefits (Paid Only)
                    </div>

                    <div class="card-body">

                        <div class="row">

                            {{-- Add Attendee --}}
                            <div class="col-md-6 mb-3">
                                <h6>Add Attendee</h6>

                                <form action="{{ url('add-attendee') }}" method="post">
                                    @csrf

                                    <input type="hidden" name="lead_id" value="{{ $leadinfo->lead_id }}">

                                    <input class="form-control mb-2" type="text" name="name" placeholder="Name" required>
                                    <input class="form-control mb-2" type="text" name="designation"
                                        placeholder="Designation">
                                    <input class="form-control mb-2" type="text" name="mobile" placeholder="Mobile">
                                    <input class="form-control mb-2" type="email" name="email" placeholder="Email">

                                    <button class="btn btn-success w-100" type="submit">
                                        Add Attendee
                                    </button>
                                </form>
                            </div>

                            {{-- Invoice + Favorites --}}
                            <div class="col-md-6 mb-3">

                                <h6>Actions</h6>

                                <a href="{{ url('download-invoice/' . $leadinfo->lead_id) }}"
                                    class="btn btn-outline-primary w-100 mb-2">
                                    📄 Download Invoice
                                </a>

                                <a href="{{ url('favorite-stall/' . $leadinfo->lead_id) }}"
                                    class="btn btn-outline-secondary w-100">
                                    ⭐ Add Stall to Favorites
                                </a>

                            </div>

                        </div>

                    </div>
                </div>

            @endif
            {{-- Actions --}}
            <!-- <div class="text-center mt-4">

                <a href="{{ url('/') }}" class="btn btn-primary">Home</a>

                @if(!$isPaid)
                    <a href="{{ url('/retry-payment?lead_id=' . $leadinfo->lead_id) }}" class="btn btn-warning">
                        Retry Payment
                    </a>
                @endif

                <button onclick="window.print()" class="btn btn-outline-secondary">
                    Print
                </button>

            </div> -->

        </div>
    </div>

</body>

</html>