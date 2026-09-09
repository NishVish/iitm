<?php

namespace App\Http\Controllers\Exhibitor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\BookingDetail;
use App\Models\EventDetail;
use App\Models\CompanyDetail;
use App\Models\DelegateAttending;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\CRUD\GetData\GetDataController;


class ExhibitorController extends Controller
{

    /**
     * Customer landing page
     */
    public function index()
    {
        if (session('type') !== "exhibitor") {
            return redirect()->route('dashboard');
        }

        $events = EventDetail::all();

        return view('exhibitor.index', compact('events'));
    }




    public function enteryoudetails()
    {
        if (session('type') !== "exhibitor") {
            return view('exhibitor.login');

        }

    }
    /**
     * Open booking panel for company
     */
    public function stallinfo($id)
    {

        // dd(compact('stall', 'payment'));

    }



    public function main($page, $id)
    {
        if ($page == "stall" || $page == "invoice") {

            $sql = new GetDataController();
            $stall = $sql->stalldatastallid($id);
            $payment = $sql->paymentinfobystallid($id);

            if ($page == "invoice") {

                $id = $stall->id;
                $bookingid = $stall->booking_id;

                $stallData = $sql->stalldatastallid($id);

                $payment = $sql->paymentinfobystallid($id);

                $billingContact = $sql->billingcontactbybillingid($bookingid);

                $company = $sql->companybybookingid($bookingid);

                // print_r(compact('page', 'stallData', 'payment', 'billingContact', 'company'));
                return view(
                    'exhibitor.invoice.index',
                    compact(
                        'page',
                        'stallData',
                        'payment',
                        'billingContact',
                        'company'
                    )
                );
            }

            // dd(compact('stall', 'payment'));
            return view('exhibitor.index', compact('page', 'stall', 'payment'));

        }
        if (!$id) {
            return redirect('/');
        }

        $sql = new GetDataController();

        /*
        |--------------------------------------------------------------------------
        | Common booking data
        |--------------------------------------------------------------------------
        */

        $bookingdata = $sql->bookingDatawithbookingid($id);

        if (!$bookingdata) {
            return redirect('/')
                ->with('error', 'Booking not found');
        }

        /*
        |--------------------------------------------------------------------------
        | Booking still editable
        |--------------------------------------------------------------------------
        */

        if ($bookingdata->allow_edit == 1) {
            return redirect('exhibitor/booking/' . $id);
        }

        $bookingId = $bookingdata->booking_id;

        /*
        |--------------------------------------------------------------------------
        | Common data used by exhibitor.index
        |--------------------------------------------------------------------------
        */

        $final_bookingdetails = $sql->final_bookingdetails($bookingId);

        $contact = $sql->contactdata(
            $bookingdata->company_id
        );

        $stall = (object) $sql->stalldata($bookingId);

        $eventsdata = DB::table('events')
            ->select(
                'name',
                'event_id',
                'stall_price'
            )
            ->get();

        $payment = DB::table('payment_records')
            ->where('booking_id', $bookingId)
            ->orderByDesc('id')
            ->get();

        $contacttype = 'delegate';

        /*
        |--------------------------------------------------------------------------
        | Page-specific data
        |--------------------------------------------------------------------------
        */



        $payment = $sql->paymentinfo($bookingdata->booking_id);


        /*
        |--------------------------------------------------------------------------
        | Page
        |--------------------------------------------------------------------------
        // */
        // echo "<pre>";
        // print_r(compact(
        //     // 'page',
        //     'final_bookingdetails',
        //     // 'bookingdata',
        //     // 'payment',
        //     // 'paymentinfo',
        //     // 'stall',
        //     // 'eventsdata',
        //     // 'contact',
        //     // 'contacttype'
        // ));
        // echo "<pre>";

        /*
        |--------------------------------------------------------------------------
        | Everything goes to ONE view
        |--------------------------------------------------------------------------
        */

        return view(
            'exhibitor.index',
            compact(
                'page',
                'final_bookingdetails',
                'bookingdata',
                'payment',
                // 'paymentinfo',
                'stall',
                'eventsdata',
                'contact',
                'contacttype'
            )
        );
    }

    public function dashboard($id)
    {
        // dd($id);
        if ($id == null) {
            return redirect('/');
        }

        $sql = new GetDataController();

        // Get booking data using booking ID
        $bookingdata = $sql->bookingDatawithbookingid($id);

        // dd($bookingdata);

        if ($bookingdata->allow_edit == 1) {


            return redirect('exhibitor/booking/' . $id);
        }
        if (!$bookingdata) {
            return redirect('/')->with('error', 'Booking not found');
        }
        $final_bookingdetails = $sql->final_bookingdetails($bookingdata->booking_id);


        $payment = DB::select(
            'SELECT * FROM payment_records WHERE booking_id = ? ORDER BY id DESC',
            [$id]
        );
        // print_r($final_bookingdetails);
        $contactdata = $sql->contactdata($bookingdata->company_id);
        $contact = $contactdata;

        $contact = $sql->contactdata($bookingdata->company_id);

        $stall = (object) $sql->stalldata($bookingdata->booking_id);

        $eventsdata = DB::table('events')
            ->select('name', 'event_id', 'stall_price')
            ->get();
        echo "<pre>";
        print_r($stall);
        // print_r($eventsdata);
        echo "</pre>";
        $contacttype = "delegate";


        return view('exhibitor.index', compact('final_bookingdetails', 'bookingdata', 'payment', 'stall', 'eventsdata', 'contact', 'contacttype'));

        // return view('exhibitor.index', compact('final_bookingdetails', 'bookingdata'));
    }
    public function payment($id)
    {
        // dd($id);
        if ($id == null) {
            return redirect('/');
        }

        $sql = new GetDataController();

        // Get booking data using booking ID
        $bookingdata = $sql->bookingDatawithbookingid($id);

        // dd($bookingdata);

        if ($bookingdata->allow_edit == 1) {


            return redirect('exhibitor/booking/' . $id);
        }
        if (!$bookingdata) {
            return redirect('/')->with('error', 'Booking not found');
        }
        $final_bookingdetails = $sql->final_bookingdetails($bookingdata->booking_id);
        $payment = $sql->paymentinfo($bookingdata->booking_id);



        // dd($payment);

        return view('exhibitor.index', compact('final_bookingdetails', 'bookingdata', 'payment'));
    }

    public function invoice($id)
    {

        // dd($id);
        if ($id == null) {
            return redirect('/');
        }

        $sql = new GetDataController();

        // Get booking data using booking ID
        $bookingdata = $sql->bookingDatawithbookingid($id);

        // dd($bookingdata);

        if ($bookingdata->allow_edit == 1) {


            return redirect('exhibitor/booking/' . $id);
        }
        if (!$bookingdata) {
            return redirect('/')->with('error', 'Booking not found');
        }
        $final_bookingdetails = $sql->final_bookingdetails($bookingdata->booking_id);
        $payment = DB::select(
            'SELECT * FROM payment_records WHERE booking_id = ? ORDER BY id DESC',
            [$id]
        );
        // echo "<pre>";
        // print_r($final_bookingdetails);
        // print_r($bookingdata);
        // print_r($payment);


        // // // echo $bookingdata;
        // echo "<pre>";
        // if (payment = 1 
        // else return redirect url('exhibitor/performa')

        return view('exhibitor.index', compact('final_bookingdetails', 'bookingdata', 'payment'));

    }

    public function panel($id)
    {
        if ($id !== "dashboard") {

            return redirect('/');
        }
        $bookingsData = new GetDataController();
        $bookingdata = $bookingsData->bookingDatawithbookingid($id);
        dd($bookingdata);
        $firsttime = true;
        return view('exhibitor.index', compact('firsttime'));
    }



    /**
     * Store company and booking details
     */
    public function store(Request $request)
    {

        $request->validate([

            'event_id' => 'required',

            'company_name' => 'required',

            'stall_number' => 'required',

        ]);



        // Create Company

        $company = CompanyDetail::create([

            'billing_contact' => $request->billing_contact,

            'company_name' => $request->company_name,

            'stall_number' => $request->stall_number,

            'address' => $request->address,

            'pin' => $request->pin,

            'state' => $request->state,

            'name' => $request->name,

            'designation' => $request->designation,

            'mobile' => $request->mobile,

            'email' => $request->email,

        ]);




        // Create Booking

        $booking = BookingDetail::create([

            'event_id' => $request->event_id,

            'company_id' => $company->company_id,

            'stall' => $request->stall_number,

            'fascia' => $request->fascia_name,

            'certificate' => $request->certificate_name,

        ]);




        return redirect()
            ->route('exhibitor.delegates', $booking->booking_id);

    }




    /**
     * Delegate form
     */
    public function delegates($booking_id)
    {

        $booking = BookingDetail::findOrFail($booking_id);


        return view(
            'exhibitor.delegates',
            compact('booking')
        );

    }





    /**
     * Save delegates
     */
    public function storeDelegates(Request $request, $booking_id)
    {

        $booking = BookingDetail::findOrFail($booking_id);



        foreach ($request->delegates as $delegate) {

            DelegateAttending::create([

                'company_id' => $booking->company_id,

                'name' => $delegate['name'],

                'designation' => $delegate['designation'],

                'mobile' => $delegate['mobile'],

                'email' => $delegate['email'],

            ]);

        }



        return view(
            'exhibitor.wecome',
            compact('booking')
        );

    }





    /**
     * Final welcome page
     */
    public function wecome()
    {
        return view('exhibitor.wecome');
    }

}