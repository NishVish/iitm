<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\BookingDetail;
use App\Models\EventDetail;
use App\Models\CompanyDetail;
use App\Models\Branding;

class AdminController extends Controller
{

    /**
     * Display all bookings
     */

    public function logout()
    {
        session()->flush();

        return redirect()->route('admin.login');
    }

    public function login()
    {
        return view('admin.index');
    }

    public function verify(Request $request)
    {

        // dd($request->all());
        $username = $request->input('username');
        $password = $request->input('password');

        if ($username === 'admin' && $password === 'admin') {
            session(['type' => "admin"]);

            return redirect()->route('admin.index');
        }

        return redirect()
            ->route('admin.login')
            ->with('error', 'Invalid username or password.');
    }

    public function index()
    {
        if (session('type') !== "admin") {
            return redirect('admin/login');
        }
        $cities = DB::select("
        SELECT
            ed.city,

            COUNT(bd.booking_id) AS total_bookings,

            SUM(
                CASE
                    WHEN bd.certificate IS NULL OR bd.certificate = ''
                    THEN 1
                    ELSE 0
                END
            ) AS pending,

            SUM(
                CASE
                    WHEN bd.certificate IS NOT NULL
                         AND bd.certificate <> ''
                    THEN 1
                    ELSE 0
                END
            ) AS completed

        FROM event_details ed

        LEFT JOIN booking_details bd
            ON bd.event_id = ed.event_id

        GROUP BY ed.city

        ORDER BY ed.city
    ");

        return view('admin.dashboard.index', compact('cities'));
    }


    public function listbycity($city)
    {
        $bookings = DB::select("
        SELECT 
            bd.booking_id,
            bd.stall,
            bd.fascia,
            bd.certificate,

            ed.event_id,
            ed.year AS event_year,
            ed.city,
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

        WHERE ed.city = ?

        ORDER BY bd.booking_id DESC
    ", [$city]);

        return response()->json($bookings);
    }

    public function tables()
    {
        $bookings = BookingDetail::with([
            'event',
            'company',
            'branding'
        ])->get();

        $schema = DB::select("
        SELECT
            TABLE_NAME,
            COLUMN_NAME,
            ORDINAL_POSITION,
            COLUMN_TYPE,
            DATA_TYPE,
            CHARACTER_MAXIMUM_LENGTH,
            IS_NULLABLE,
            COLUMN_DEFAULT,
            COLUMN_KEY,
            EXTRA,
            COLUMN_COMMENT
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE TABLE_SCHEMA = DATABASE()
        ORDER BY TABLE_NAME, ORDINAL_POSITION
    ");

        return view('admin.index', compact('bookings', 'schema'));
    }


    /**
     * Edit booking
     */
    public function edit($id)
    {
        $booking = BookingDetail::with([
            'event',
            'company',
            'branding'
        ])->findOrFail($id);

        return view('admin.edit.index', compact('booking'));
    }


    /**
     * Show bookings by event location
     */
    public function eventdetails($location)
    {
        $bookings = BookingDetail::with([
            'event',
            'company'
        ])
            ->whereHas('event', function ($query) use ($location) {

                $query->where('location', $location);

            })
            ->get();


        return view('admin.index', compact('bookings'));
    }



    /**
     * Add new booking form
     */
    public function add($location)
    {
        $events = EventDetail::where('location', $location)->get();

        return view('exhibitor.bookingform.form', compact('events'));
    }



    /**
     * Store new booking
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



        // Create Branding
        Branding::create([

            'booking_id' => $booking->booking_id,
            'fascia_name' => $request->fascia_name,
            'certificate_name' => $request->certificate_name,

        ]);



        return redirect()
            ->route('admin.index')
            ->with('success', 'Booking created successfully');

    }




    /**
     * Delete booking
     */
    public function destroy($id)
    {

        $booking = BookingDetail::findOrFail($id);

        $booking->delete();


        return redirect()
            ->back()
            ->with('success', 'Booking deleted successfully');

    }

}