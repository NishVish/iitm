@php
    $booking = $final_bookingdetails->booking;
    $company = $final_bookingdetails->company;
    $stalls = $final_bookingdetails->stalls;
    $billing = $final_bookingdetails->billingcontact;

    /*
    |--------------------------------------------------------------------------
    | PAYMENT DATA
    |--------------------------------------------------------------------------
    */

    $payments = $final_bookingdetails->payments ?? collect();

    // ALL payment records for this booking
    $totalPaid = $payments->sum(function ($payment) {
        return (float) ($payment->amount ?? 0);
    });

    // Only APPROVED payments are considered actually paid
    $paidAmount = $payments
        ->where('status', 'approved')
        ->sum(function ($payment) {
            return (float) ($payment->amount ?? 0);
        });

    // Pending payments
    $pendingAmount = $payments
        ->where('status', 'pending')
        ->sum(function ($payment) {
            return (float) ($payment->amount ?? 0);
        });

    /*
    |--------------------------------------------------------------------------
    | STALL DATA
    |--------------------------------------------------------------------------
    */

    $eventsBooked = $stalls->count();

    $totalStallValue = $stalls->sum(function ($s) {
        return (float) ($s->final_price ?? $s->stall_price ?? 0);
    });

    /*
    |--------------------------------------------------------------------------
    | BALANCE
    |--------------------------------------------------------------------------
    */

    $totalDue = max(
        0,
        $totalStallValue - $paidAmount
    );

    /*
    |--------------------------------------------------------------------------
    | MONEY FORMAT
    |--------------------------------------------------------------------------
    */

    $money = fn($n) => '₹' . number_format((float) $n, 0);

    /*
    |--------------------------------------------------------------------------
    | DATE FORMAT
    |--------------------------------------------------------------------------
    */

    $formatDate = function ($date) {
        if (!$date) {
            return null;
        }

        try {
            return \Carbon\Carbon::parse($date)->format('d M');
        } catch (\Throwable $e) {
            return null;
        }
    };

    $formatDateYear = function ($date) {
        if (!$date) {
            return null;
        }

        try {
            return \Carbon\Carbon::parse($date)->format('d M Y');
        } catch (\Throwable $e) {
            return null;
        }
    };

    /*
    |--------------------------------------------------------------------------
    | UPDATED DATE
    |--------------------------------------------------------------------------
    */

    $updatedAt = null;

    if (!empty($booking->updated_at)) {
        try {
            $updatedAt = \Carbon\Carbon::parse($booking->updated_at)
                ->format('d M Y');
        } catch (\Throwable $e) {
            $updatedAt = null;
        }
    }
@endphp