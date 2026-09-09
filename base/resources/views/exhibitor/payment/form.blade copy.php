<div class="container py-4">

    {{-- Payment Amount --}}
    <div class="card shadow-sm mb-4">

        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Make Payment</h5>
        </div>

        <div class="card-body">

            <form action="{{ route('updatePayment') }}" method="POST">
                @csrf

                <input type="hidden" name="booking_id" value="{{ $final_bookingdetails->booking->booking_id }}">
                <input type="hidden" name="payment_for" value="stall">

                <div class="row align-items-end">

                    <div class="col-md-6">
                        <label class="form-label">
                            Amount to Pay
                        </label>

                        <div class="input-group">
                            <span class="input-group-text">₹</span>

                            <input type="number" name="amount" class="form-control" step="0.01" min="0.01" required
                                placeholder="Enter amount">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <button type="submit" class="btn btn-success">
                            Pay Now
                        </button>
                    </div>

                </div>

            </form>

        </div>
    </div>


    {{-- Previous Payments --}}
    <div class="card shadow-sm">

        <div class="card-header">
            <h5 class="mb-0">Previous Payment Details</h5>
        </div>

        <div class="card-body">

            @if($final_bookingdetails->payments->count() > 0)

                <div class="table-responsive">

                    <table class="table table-bordered table-hover align-middle">

                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Booking ID</th>
                                <th>Payment For</th>
                                <th class="text-end">Amount</th>
                                <th>UTR ID</th>
                                <th>Status</th>
                                <th>Payment Date</th>
                                <th>Payment Method</th>
                                <th>Transaction ID</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach($final_bookingdetails->payments as $index => $payment)

                                <tr>

                                    <td>
                                        {{ $index + 1 }}
                                    </td>

                                    <td>
                                        {{ $payment->booking_id ?? '-' }}
                                    </td>

                                    <td>
                                        {{ $payment->payment_for ?? '-' }}
                                    </td>

                                    <td class="text-end fw-semibold">
                                        ₹{{ number_format((float) $payment->amount, 2) }}
                                    </td>

                                    <td>
                                        {{ $payment->utr_id ?? '-' }}
                                    </td>

                                    <td>
                                        @if($payment->status === 'approved')
                                            <span class="badge bg-success">
                                                Approved
                                            </span>
                                        @elseif($payment->status === 'rejected')
                                            <span class="badge bg-danger">
                                                Rejected
                                            </span>
                                        @else
                                            <span class="badge bg-warning text-dark">
                                                {{ ucfirst($payment->status ?? 'Pending') }}
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        {{ $payment->payment_date ?? '-' }}
                                    </td>

                                    <td>
                                        {{ $payment->payment_method ?? '-' }}
                                    </td>

                                    <td>
                                        {{ $payment->transaction_id ?? '-' }}
                                    </td>

                                    <td>
                                        {{ $payment->remarks ?? '-' }}
                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                        <tfoot class="table-light">

                            <tr>
                                <th colspan="3" class="text-end">
                                    Total Paid
                                </th>

                                <th class="text-end">
                                    ₹{{ number_format($final_bookingdetails->payments->sum('amount'), 2) }}
                                </th>

                                <th colspan="6"></th>
                            </tr>

                        </tfoot>

                    </table>

                </div>

            @else

                <div class="alert alert-info mb-0">
                    No previous payment records found for this booking.
                </div>

            @endif

        </div>
    </div>

</div>