<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\BookingDetail;
use App\Models\EventDetail;
use App\Models\CompanyDetail;
use App\Models\DelegateAttending;
use Illuminate\Support\Facades\DB;


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
    public function verify()
    {
        session()->put('booking_id', 1);
        session()->put('type', "exhibitor");

        return redirect()->route('dashboard');
    }

    public function dashboard()
    {
        if (session('type') !== "exhibitor") {
            return redirect('/');
        }
        $booking_id = session('booking_id');

        $booking = DB::select("
        SELECT 
            bd.booking_id,
            bd.stall,
            bd.fascia,
            bd.certificate,

            ed.event_id,
            ed.year AS event_year,
            ed.location AS event_location,

            cd.company_id,
            cd.billing_contact,
            cd.company_name,
            cd.stall_number,
            cd.address,
            cd.pin,
            cd.state,
            cd.name AS contact_name,
            cd.designation,
            cd.mobile,
            cd.email,

            br.branding_id,
            br.fascia_name,
            br.certificate_name,

            da.delegate_id,
            da.name AS delegate_name,
            da.designation AS delegate_designation,
            da.mobile AS delegate_mobile,
            da.email AS delegate_email

        FROM booking_details bd

        LEFT JOIN event_details ed
            ON ed.event_id = bd.event_id

        LEFT JOIN company_details cd
            ON cd.company_id = bd.company_id

        LEFT JOIN branding br
            ON br.booking_id = bd.booking_id

        LEFT JOIN delegates_attending da
            ON da.company_id = cd.company_id

        WHERE bd.booking_id = ?
    ", [$booking_id]);

        return view('exhibitor.index', compact('booking'));
    }

    /**
     * Open booking panel for company
     */
    public function panel($id)
    {
        if (session('type') !== "exhibitor") {
            return redirect('/');
        }
        $bookings = BookingDetail::with([
            'event',
            'company'
        ])
            ->where('company_id', $id)
            ->get();


        return view(
            'exhibitor.bookingform.form',
            compact('bookings')
        );

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