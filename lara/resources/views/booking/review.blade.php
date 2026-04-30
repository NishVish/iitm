<div class="container py-5" style="max-width: 1100px;">

    {{-- HEADER SECTION --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="fw-bold tracking-tight text-dark mb-1">Order Summary</h2>
            <p class="text-muted mb-0">Review your stall booking details and contact information.</p>
        </div>
        <div class="d-none d-md-block text-end">
            <span class="badge bg-soft-primary text-primary px-3 py-2">Step 2 of 3: Review</span>
        </div>
    </div>

    <div class="row g-4">

        {{-- LEFT SIDE: DETAILS --}}
        <div class="col-lg-8">

            {{-- COMPANY & CONTACT CARD --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3 border-bottom-0">
                    <h6 class="fw-bold mb-0 text-uppercase small text-muted tracking-wider">Company & Contact
                        Information</h6>
                </div>
                <div class="card-body pt-0">
                    <div class="row g-3">
                        <div class="col-md-6 border-end-md">
                            <div class="p-2">
                                <label class="text-muted d-block small mb-1">Company Details</label>
                                <div class="fw-bold text-dark fs-5">{{ $lead->company_name }}</div>
                                <div class="text-secondary small mt-1">
                                    <i class="bi bi-geo-alt me-1"></i> {{ $lead->address }}<br>
                                    {{ $lead->city }}, {{ $lead->state }}
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="p-2">
                                <label class="text-muted d-block small mb-1">Point of Contact</label>
                                <div class="fw-bold text-dark">{{ $lead->contact_name }}</div>
                                <div class="text-muted small mb-2">{{ $lead->designation }}</div>

                                <div class="d-flex flex-wrap gap-1 mb-2">
                                    @foreach($emails as $email)
                                        <span
                                            class="badge rounded-pill bg-light text-dark border fw-normal">{{ $email->email }}</span>
                                    @endforeach
                                </div>

                                <div class="d-flex flex-wrap gap-1">
                                    @foreach($mobiles as $mobile)
                                        <span class="badge rounded-pill bg-light text-dark border fw-normal">
                                            <i class="bi bi-telephone me-1"></i>{{ $mobile->mobile }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ITEMS / LOCATIONS CARD --}}
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold mb-0 text-uppercase small text-muted tracking-wider">Stall Selection</h6>
                        <span class="badge bg-dark">{{ count($locations) }} Items</span>
                    </div>
                </div>

                <div class="card-body p-0">
                    @php $total = 0; @endphp

                    @forelse($locations as $loc)
                        @php $total += $loc->grand_total; @endphp
                        <div class="p-4 border-bottom hover-bg-light transition-all">
                            <div class="row align-items-center">
                                <div class="col">
                                    <div class="fw-bold text-dark fs-6 mb-1">
                                        {{ $loc->location }}
                                        <span class="text-muted mx-2">|</span>
                                        <span class="text-primary">{{ $loc->stall_location }}</span>
                                    </div>
                                    <div class="d-flex flex-wrap gap-3 small text-muted">
                                        <span><strong>Size:</strong> {{ $loc->size }}</span>
                                        <span><strong>GST:</strong> ₹{{ number_format($loc->gst_amount, 2) }}</span>
                                        @if($loc->discount_amount > 0)
                                            <span class="text-danger"><strong>Discount:</strong>
                                                -₹{{ number_format($loc->discount_amount, 2) }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-auto text-end">
                                    <div class="fw-bold fs-5 text-dark">
                                        ₹{{ number_format($loc->grand_total, 2) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-5 text-center">
                            <i class="bi bi-cart-x display-4 text-muted mb-3 d-block"></i>
                            <p class="text-muted">No items added to your booking.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- RIGHT SIDE: PAYMENT SUMMARY --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm sticky-top" style="top: 24px;">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-4 text-uppercase small text-muted tracking-wider">Order Summary</h6>

                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-secondary">Subtotal</span>
                        <span class="text-dark fw-medium">₹ {{ number_format($total, 2) }}</span>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-secondary">Taxes (GST)</span>
                        <span class="text-success small fw-medium">Inclusive</span>
                    </div>

                    <hr class="my-3 opacity-10">

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <span class="fw-bold text-dark">Total Amount</span>
                        <div class="text-end">
                            <span class="fw-bold fs-4 text-dark d-block">₹ {{ number_format($total, 2) }}</span>
                            <small class="text-muted" style="font-size: 0.7rem;">Secure Checkout</small>
                        </div>
                    </div>

                    <a href="{{ url('payment/' . $lead->lead_id) }}"
                        class="btn btn-primary w-100 py-3 fw-bold shadow-sm mb-3">
                        Proceed to Secure Payment
                    </a>

                    <a href="{{ url()->previous() }}" class="btn btn-outline-light text-muted w-100 border-0 small">
                        <i class="bi bi-arrow-left me-1"></i> Edit Booking Details
                    </a>
                </div>
                <div class="card-footer bg-light border-0 py-3">
                    <div class="d-flex align-items-center justify-content-center gap-3 opacity-50">
                        <i class="bi bi-shield-check h4 mb-0"></i>
                        <span class="small">SSL Encrypted Payment</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
    body {
        background-color: #f8f9fa;
    }

    .card {
        border-radius: 12px;
    }

    .hover-bg-light:hover {
        background-color: #fafafa;
    }

    .transition-all {
        transition: all 0.2s ease-in-out;
    }

    .bg-soft-primary {
        background-color: #e7f1ff;
    }

    .tracking-tight {
        letter-spacing: -0.025em;
    }

    .tracking-wider {
        letter-spacing: 0.05em;
    }

    @media (min-width: 768px) {
        .border-end-md {
            border-right: 1px solid #dee2e6 !important;
        }
    }
</style>

@include('booking.payment')