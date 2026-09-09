<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\CRUD\GetData\GetDataController;

class SalesController extends Controller
{
    public function index()
    {
        if (
            session()->has('user_id') &&
            session()->get('user_type') === 'sales'
        ) {


            $user = DB::table('users')
                ->where('email', 'nishwakarma3@gamil.com')
                ->first();

            $events = DB::table('events')
                ->leftJoinSub(
                    DB::table('stall_booking_data')
                        ->select(
                            'event_id',
                            DB::raw('COUNT(*) as stall_count')
                        )
                        ->groupBy('event_id'),
                    'stall_counts',
                    function ($join) {
                        $join->on(
                            'events.event_id',
                            '=',
                            'stall_counts.event_id'
                        );
                    }
                )
                ->select(
                    'events.*',
                    DB::raw('COALESCE(stall_counts.stall_count, 0) as stall_count')
                )
                ->get();



            return view('sales.index', compact('user', 'events'));
        }

        return view('sales.login');
    }

    public function stallsbyevent($eventid)
    {
        $sql = new GetDataController();

        $stalls = $sql->stalldatabyevent($eventid);

        $data = [];

        foreach ($stalls as $stall) {

            $id = $stall->id;
            $bookingid = $stall->booking_id;

            $stallData = $sql->stalldatastallid($id);

            $payment = $sql->paymentinfobystallid($id);

            $billingContact = $sql->billingcontactbybillingid($bookingid);

            $company = $sql->companybybookingid($bookingid);

            $data[] = [
                'stall_id' => $id,
                'booking_id' => $bookingid,
                'stall' => $stallData,
                'company' => $company,
                'billing_contact' => $billingContact,
                'payment' => $payment,
            ];
        }
        $events = DB::table('events')
            ->leftJoinSub(
                DB::table('stall_booking_data')
                    ->select(
                        'event_id',
                        DB::raw('COUNT(*) as stall_count')
                    )
                    ->groupBy('event_id'),
                'stall_counts',
                function ($join) {
                    $join->on(
                        'events.event_id',
                        '=',
                        'stall_counts.event_id'
                    );
                }
            )
            ->select(
                'events.*',
                DB::raw('COALESCE(stall_counts.stall_count, 0) as stall_count')
            )
            ->get();

        // dd($events);
        $currentevent = DB::table('events')
            ->where('event_id', $eventid)
            ->first();
        // dd($currentevent);

        return view('sales.index', compact('data', 'events', 'currentevent'));
    }
    // build table companyname sales id stall size payment stauts billing contact name designatin mobile email fasica certificate delegates

    public function login_sales(Request $request)
    {


        $user = DB::table('users')
            ->where('email', 'nishwakarma3@gamil.com')
            ->first();
        // dd($user);

        $request->session()->regenerate();

        session()->put('user_id', $user->id);
        session()->put('email', $user->email);
        session()->put('user_type', 'sales');
        session()->put('user_name', $user->name);

        return redirect()->to(url('sales'));
    }
}