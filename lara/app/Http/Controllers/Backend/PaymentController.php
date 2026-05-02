<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Backend\Sales\LeadController;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function handleSuccess(Request $request)
    {
        $leadId = $request->lead_id;

        // update payment status
        DB::table('leads')
            ->where('lead_id', $leadId)
            ->update([
                'payment_status' => 'paid',
            ]);
        $rediction = new LeadController;
        return $rediction->getdetails($request->lead_id, false);
    }



    // public function getdetails($leadId, $found = true)
    // {
    //     if ($found) {
    //         return view('booking.index', compact('found'));
    //     } else {
    //         return view('booking.index', compact('found'));
    //     }
    // }
}