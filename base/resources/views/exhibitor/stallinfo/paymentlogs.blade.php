{{-- PAYMENT LOG --}}
<div class="card shadow-sm">

    <div class="card-header">
        <h5 class="mb-0">
            Payment History
        </h5>
    </div>

    <div class="card-body p-0">

        @if($payment && $payment->count())

            <div class="table-responsive">

                <table class="table table-hover mb-0">

                    <thead class="table-light">

                        <tr>
                            <th>#</th>
                            <th>Payment For</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>UTR / Transaction</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>

                    </thead>

                    <tbody>

                        @foreach($payment as $item)

                            <tr>

                                <td>
                                    {{ $item->id }}
                                </td>

                                <td>
                                    {{ ucwords(str_replace('_', ' ', $item->payment_for ?? '-')) }}
                                </td>

                                <td>
                                    ₹{{ number_format((float) ($item->amount ?? 0), 2) }}
                                </td>

                                <td>
                                    {{ strtoupper($item->payment_method ?? '-') }}
                                </td>

                                <td>

                                    @if($item->utr_id)
                                        <div>
                                            UTR:
                                            {{ $item->utr_id }}
                                        </div>
                                    @endif

                                    @if($item->transaction_id)
                                        <div>
                                            Transaction:
                                            {{ $item->transaction_id }}
                                        </div>
                                    @endif

                                    @if(!$item->utr_id && !$item->transaction_id)
                                        -
                                    @endif

                                </td>

                                <td>

                                    @if($item->status === 'approved' || $item->status === 'success')

                                        <span class="badge bg-success">
                                            {{ ucfirst($item->status) }}
                                        </span>

                                    @elseif($item->status === 'pending')

                                        <span class="badge bg-warning text-dark">
                                            Pending
                                        </span>

                                    @elseif($item->status === 'rejected')

                                        <span class="badge bg-danger">
                                            Rejected
                                        </span>

                                    @else

                                        <span class="badge bg-secondary">
                                            {{ ucfirst($item->status ?? '-') }}
                                        </span>

                                    @endif

                                </td>

                                <td>
                                    {{ $item->payment_date ?? $item->created_at ?? '-' }}
                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="p-4 text-center text-muted">
                No payment records found.
            </div>

        @endif

    </div>

</div>

</div>