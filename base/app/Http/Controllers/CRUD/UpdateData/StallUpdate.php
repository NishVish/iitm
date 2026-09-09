<?php

namespace App\Http\Controllers\CRUD\UpdateData;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

trait StallUpdate
{
    public function fx(Request $request)
    {
    }
    // create stall if
    // dd($request->all());


    public function stallBookingUpdate(Request $request)
    {
        $bookingId = $request->booking_id;
        $stalls = $request->stalls ?? [];

        DB::transaction(function () use ($bookingId, $stalls) {

            $existingStalls = DB::table('stall_booking_data')
                ->where('booking_id', $bookingId)
                ->get();

            $submittedStallIds = [];

            foreach ($stalls as $stall) {

                $stallId = $stall['stall_id'] ?? null;

                $originalAmount = (float) ($stall['original_amount'] ?? 0);
                $discountAmount = (float) ($stall['discount_amount'] ?? 0);

                $finalPrice = max(
                    0,
                    $originalAmount - $discountAmount
                );

                /*
                |--------------------------------------------------------------------------
                | INSERT NEW STALL
                |--------------------------------------------------------------------------
                */

                if (empty($stallId)) {

                    $newStallId = uniqid();

                    DB::table('stall_booking_data')->insert([
                        'id' => $newStallId,
                        'booking_id' => $bookingId,
                        'event_id' => $stall['event_id'] ?? null,
                        'stall_size' => $stall['stall_size'] ?? null,
                        'stall_type' => $stall['stall_type'] ?? null,
                        'gst_amount' => $stall['gst_amount'] ?? 0,
                        'original_amount' => $originalAmount,
                        'discount_amount' => $discountAmount,
                        'final_price' => $finalPrice,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    $submittedStallIds[] = $newStallId;

                    continue;
                }

                /*
                |--------------------------------------------------------------------------
                | UPDATE EXISTING STALL
                |--------------------------------------------------------------------------
                */

                $stallExists = DB::table('stall_booking_data')
                    ->where('id', $stallId)
                    ->where('booking_id', $bookingId)
                    ->exists();

                if (!$stallExists) {
                    continue;
                }

                $submittedStallIds[] = $stallId;

                DB::table('stall_booking_data')
                    ->where('id', $stallId)
                    ->where('booking_id', $bookingId)
                    ->update([
                        'event_id' => $stall['event_id'] ?? null,
                        'stall_size' => $stall['stall_size'] ?? null,
                        'stall_type' => $stall['stall_type'] ?? null,
                        'gst_amount' => $stall['gst_amount'] ?? 0,
                        'original_amount' => $originalAmount,
                        'discount_amount' => $discountAmount,
                        'final_price' => $finalPrice,
                        'updated_at' => now(),
                    ]);
            }

            /*
            |--------------------------------------------------------------------------
            | DELETE STALLS REMOVED FROM THE FORM
            |--------------------------------------------------------------------------
            */

            foreach ($existingStalls as $existingStall) {

                if (!in_array($existingStall->id, $submittedStallIds, true)) {

                    DB::table('stall_booking_data')
                        ->where('id', $existingStall->id)
                        ->where('booking_id', $bookingId)
                        ->delete();
                }
            }
        });

        return redirect()
            ->back()
            ->with('success', 'Stall booking updated successfully.');
    }

    public function UpdateFaciaCertificate(Request $request)
    {
        dd($request->all());
    }
    public function stallDetailsIdUpdate(Request $request)
    {
        $fields = [
            'event_id',
            'stall_size',
            'stall_location',
            'stall_type',
            'fascia',
            'certificate',
            'branding',
            'discount_code',
            'discount_amount',
            'final_price',
            'original_amount',
            'gst_amount',
            'due_amount',
        ];

        $updateData = $request->only(
            array_intersect($fields, array_keys($request->all()))
        );

        if (!empty($updateData)) {
            $updateData['updated_at'] = now();

            DB::table('stall_booking_data')
                ->where('id', $request->stall_id)
                ->where('booking_id', $request->booking_id)
                ->update($updateData);
        }

        return redirect()
            ->back()
            ->with('success', 'Stall details updated successfully.');
    }


    public function stallDetailsUpdate(Request $request)
    {
        // dd($request->all());

        $bookingId = $request->booking_id;
        $stalls = $request->stalls ?? [];

        foreach ($stalls as $stall) {

            if (empty($stall['stall_id'])) {
                continue;
            }

            DB::table('stall_booking_data')
                ->where('id', $stall['stall_id'])
                ->where('booking_id', $bookingId)
                ->update([
                    'event_id' => $stall['event_id'] ?? null,
                    'stall_size' => $stall['stall_size'] ?? null,
                    'stall_location' => $stall['stall_location'] ?? null,
                    'stall_type' => $stall['stall_type'] ?? null,
                    'fascia' => $stall['fascia'] ?? null,
                    'certificate' => $stall['certificate'] ?? null,
                    'branding' => $stall['branding'] ?? 0,
                    'updated_at' => now(),
                ]);
        }

        return redirect()
            ->back()
            ->with('success', 'Stall details updated successfully.');
    }
}