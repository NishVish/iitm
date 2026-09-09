<div class="card border mb-4">

    <div class="card-header bg-light">
        <h5 class="mb-0">1. Payment Summary</h5>
    </div>

    <div class="card-body">

        <div class="row mb-4">

            <div class="col-md-6">
                <strong>Booking ID:</strong>
                {{ $final_bookingdetails->booking->booking_id ?? '-' }}
            </div>

            <div class="col-md-6">
                <strong>Company ID:</strong>
                {{ $final_bookingdetails->booking->company_id ?? '-' }}
            </div>

        </div>

        <div class="table-responsive">

            <table class="table table-bordered table-hover align-middle">

                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Event</th>
                        <th>Stall ID</th>
                        <th>Stall Size</th>
                        <th class="text-end">Original Price</th>
                        <th class="text-end">Discount</th>
                        <th class="text-end">GST</th>
                        <th class="text-end">Final Price</th>
                        <th class="text-end">Paid</th>
                        <th class="text-end">Due</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($final_bookingdetails->stalls as $index => $stall)

                        @php
                            $original = (float) ($stall->original_amount ?? 0);
                            $discount = (float) ($stall->discount_amount ?? 0);
                            $gst = (float) ($stall->gst_amount ?? 0);
                            $final = (float) ($stall->final_price ?? 0);

                            /*
                             * Paid amount should preferably come from
                             * stall->paid_amount populated by controller.
                             */
                            $paid = (float) ($stall->paid_amount ?? 0);

                            $due = max(0, $final - $paid);

                            $totalOriginal += $original;
                            $totalDiscount += $discount;
                            $totalGst += $gst;
                            $totalFinal += $final;
                            $totalDue += $due;
                        @endphp

                        <tr>

                            <td>
                                {{ $index + 1 }}
                            </td>

                            <td>
                                {{ $stall->event_name ?? '-' }}
                            </td>

                            <td>
                                <strong>
                                    {{ $stall->stall_id ?? $stall->id ?? '-' }}
                                </strong>
                            </td>

                            <td>
                                {{ $stall->stall_size ?? '-' }}
                            </td>

                            <td class="text-end">
                                ₹{{ number_format($original, 2) }}
                            </td>

                            <td class="text-end text-danger">
                                - ₹{{ number_format($discount, 2) }}
                            </td>

                            <td class="text-end">
                                ₹{{ number_format($gst, 2) }}
                            </td>

                            <td class="text-end fw-semibold">
                                ₹{{ number_format($final, 2) }}
                            </td>

                            <td class="text-end text-success">
                                ₹{{ number_format($paid, 2) }}
                            </td>

                            <td class="text-end fw-bold {{ $due > 0 ? 'text-danger' : 'text-success' }}">
                                ₹{{ number_format($due, 2) }}
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="10" class="text-center py-4">
                                No price details found.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

                <tfoot class="table-light">

                    <tr>

                        <th colspan="4" class="text-end">
                            Total
                        </th>

                        <th class="text-end">
                            ₹{{ number_format($totalOriginal, 2) }}
                        </th>

                        <th class="text-end text-danger">
                            - ₹{{ number_format($totalDiscount, 2) }}
                        </th>

                        <th class="text-end">
                            ₹{{ number_format($totalGst, 2) }}
                        </th>

                        <th class="text-end">
                            ₹{{ number_format($totalFinal, 2) }}
                        </th>

                        <th class="text-end text-success">
                            ₹{{ number_format($totalFinal - $totalDue, 2) }}
                        </th>

                        <th class="text-end text-danger">
                            ₹{{ number_format($totalDue, 2) }}
                        </th>

                    </tr>

                </tfoot>

            </table>

        </div>

        {{-- Summary --}}
        <div class="row justify-content-end mt-4">

            <div class="col-md-5">

                <div class="card border">

                    <div class="card-header">
                        <strong>Amount Summary</strong>
                    </div>

                    <div class="card-body">

                        <div class="d-flex justify-content-between mb-2">
                            <span>Original Amount</span>
                            <strong>
                                ₹{{ number_format($totalOriginal, 2) }}
                            </strong>
                        </div>

                        <div class="d-flex justify-content-between mb-2 text-danger">
                            <span>Total Discount</span>
                            <strong>
                                - ₹{{ number_format($totalDiscount, 2) }}
                            </strong>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span>GST (18%)</span>
                            <strong>
                                ₹{{ number_format($totalGst, 2) }}
                            </strong>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between mb-2">
                            <strong>Total Amount</strong>
                            <strong>
                                ₹{{ number_format($totalFinal, 2) }}
                            </strong>
                        </div>

                        <div class="d-flex justify-content-between mb-2 text-success">
                            <strong>Paid Amount</strong>
                            <strong>
                                ₹{{ number_format($totalFinal - $totalDue, 2) }}
                            </strong>
                        </div>

                        <div class="d-flex justify-content-between text-danger">
                            <strong>Remaining Due</strong>
                            <strong class="fs-5">
                                ₹{{ number_format($totalDue, 2) }}
                            </strong>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>