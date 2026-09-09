<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Payment Requests</h4>
            <p class="text-muted mb-0">
                Review, approve or reject pending payments.
            </p>
        </div>

        <span class="badge bg-warning text-dark">
            {{ $payment->count() }} Pending
        </span>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
            </button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">

            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
            </button>

        </div>
    @endif

    @if($payment->isEmpty())

        <div class="card shadow-sm">
            <div class="card-body text-center py-5">

                <h5>No Pending Payments</h5>

                <p class="text-muted mb-0">
                    There are currently no payment requests waiting for approval.
                </p>

            </div>
        </div>

    @else

        <div class="row">

            @foreach($payment as $item)

                <div class="col-md-6 col-xl-4 mb-4">

                    <div class="card h-100 shadow-sm">

                        <div class="card-header d-flex justify-content-between align-items-center">

                            <strong>
                                Payment #{{ $item->id }}
                            </strong>

                            <span class="badge bg-warning text-dark">
                                {{ ucfirst($item->status) }}
                            </span>

                        </div>

                        <div class="card-body">

                            <div class="mb-3">
                                <small class="text-muted d-block">
                                    Payment ID
                                </small>

                                <strong>
                                    {{ $item->id }}
                                </strong>
                            </div>

                            <div class="mb-3">
                                <small class="text-muted d-block">
                                    Booking ID
                                </small>

                                <strong>
                                    {{ $item->booking_id }}
                                </strong>
                            </div>

                            <div class="mb-3">
                                <small class="text-muted d-block">
                                    Stall ID
                                </small>

                                <strong>
                                    {{ $item->stall_id ?? '-' }}
                                </strong>
                            </div>

                            <div class="mb-3">
                                <small class="text-muted d-block">
                                    Payment For
                                </small>

                                <span>
                                    {{ ucwords(str_replace('_', ' ', $item->payment_for)) }}
                                </span>
                            </div>

                            <div class="mb-3">
                                <small class="text-muted d-block">
                                    Amount
                                </small>

                                <h5 class="mb-0 text-success">
                                    ₹{{ number_format((float) $item->amount, 2) }}
                                </h5>
                            </div>

                            <div class="mb-3">
                                <small class="text-muted d-block">
                                    Payment Method
                                </small>

                                <span>
                                    {{ strtoupper($item->payment_method ?? '-') }}
                                </span>
                            </div>

                            <div class="mb-3">
                                <small class="text-muted d-block">
                                    UTR ID
                                </small>

                                <span>
                                    {{ $item->utr_id ?? '-' }}
                                </span>
                            </div>

                            <div class="mb-3">
                                <small class="text-muted d-block">
                                    Transaction ID
                                </small>

                                <span>
                                    {{ $item->transaction_id ?? '-' }}
                                </span>
                            </div>

                            <div class="mb-3">
                                <small class="text-muted d-block">
                                    Payment Date
                                </small>

                                <span>
                                    {{ $item->payment_date ?? '-' }}
                                </span>
                            </div>

                            <div class="mb-3">
                                <small class="text-muted d-block">
                                    Existing Remarks
                                </small>

                                <span>
                                    {{ $item->remarks ?? '-' }}
                                </span>
                            </div>

                            @if($item->rejection_reason)

                                <div class="alert alert-danger py-2 mb-3">

                                    <small class="fw-bold d-block">
                                        Rejection Reason
                                    </small>

                                    {{ $item->rejection_reason }}

                                </div>

                            @endif

                            <hr>

                            <form method="POST" action="{{ url('admin/paymentstatusupdate') }}"
                                onsubmit="return confirmPaymentAction(this);">

                                @csrf

                                <input type="hidden" name="payment_id" value="{{ $item->id }}">

                                <div class="mb-3">

                                    <label class="form-label fw-semibold">
                                        Payment ID
                                    </label>

                                    <input type="text" class="form-control" value="{{ $item->id }}" readonly>

                                </div>

                                <div class="mb-3">

                                    <label class="form-label fw-semibold">
                                        Admin Comment
                                    </label>

                                    <textarea name="remarks" class="form-control" rows="3"
                                        placeholder="Add a comment about this payment...">{{ old('remarks') }}</textarea>

                                </div>

                                <div class="mb-3">

                                    <label class="form-label fw-semibold">
                                        Rejection Reason
                                    </label>

                                    <textarea name="rejection_reason" class="form-control" rows="3"
                                        placeholder="Required when rejecting the payment...">{{ old('rejection_reason') }}</textarea>

                                </div>

                                <div class="d-flex gap-2">

                                    <button type="submit" name="action" value="approved" class="btn btn-success flex-fill">

                                        <i class="fas fa-check me-1"></i>
                                        Approve

                                    </button>

                                    <button type="submit" name="action" value="rejected" class="btn btn-danger flex-fill">

                                        <i class="fas fa-times me-1"></i>
                                        Reject

                                    </button>

                                </div>

                            </form>

                        </div>

                        <div class="card-footer bg-light">

                            <small class="text-muted">
                                Submitted:
                                {{ $item->created_at ?? '-' }}
                            </small>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    @endif

</div>

<script>
    function confirmPaymentAction(form) {

        const submitter = document.activeElement;

        const action = submitter &&
            submitter.name === 'action'
            ? submitter.value
            : null;

        const rejectionReason = form.querySelector(
            'textarea[name="rejection_reason"]'
        ).value.trim();

        if (action === 'rejected' && rejectionReason === '') {
            alert('Please enter a rejection reason before rejecting the payment.');
            return false;
        }

        if (action === 'approved') {
            return confirm(
                'Are you sure you want to approve Payment #' +
                form.querySelector('input[name="payment_id"]').value +
                '?'
            );
        }

        if (action === 'rejected') {
            return confirm(
                'Are you sure you want to reject Payment #' +
                form.querySelector('input[name="payment_id"]').value +
                '?'
            );
        }

        return false;
    }
</script>