<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\BookingDetail;
use App\Models\EventDetail;
use App\Models\CompanyDetail;
use App\Models\DelegateAttending;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Http\Controllers\CRUD\GetData\GetDataController;
use App\Http\Controllers\CRUD\CreateData\CreateDataController;
class BookingController extends Controller
{

    public function add_booking_page()
    {

        return view('booking.index');
    }


    public function open_booking_page($id = Null)
    {
        $usersdata = DB::table('users')
            ->select('name', 'id')
            ->get();
        $eventsdata = DB::table('events')->get();


        // echo "<pre>";
        // // print_r($company);
        // print_r($eventsdata);


        // // // echo $bookingdata;
        // echo "<pre>";

        $url = url('booking/process/' . $id);
        return view('sales.index', compact('usersdata', 'eventsdata'));
    }
    public function createbooking_new(Request $request)
    {
        dd($request->all());


    }
    public function create_booking($companyid)
    {
        $bookingId = 'BK' . strtoupper(Str::random(10));

        $companyId = request('company_id', $companyid);

        $inserted = DB::table('booking_record')->insert([
            'booking_id' => $bookingId,
            'company_id' => $companyId,
            'sales_id' => '1',
            'allow_edit' => '1',
        ]);

        if (!$inserted) {
            dd([
                'status' => 'INSERT FAILED',
                'booking_id' => $bookingId,
                'company_id' => $companyId,
            ]);
        }

        $booking = DB::table('booking_record')
            ->where('booking_id', $bookingId)
            ->first();

        if (!$booking) {
            dd([
                'status' => 'INSERT RETURNED TRUE BUT RECORD NOT FOUND',
                'booking_id' => $bookingId,
            ]);
        }

        $url = "sales/booking/" . $bookingId;
        return redirect($url);
    }
    public function bookingdata($bookingId)
    {
        $data = new GetDataController();

        $bookingdata = $data->bookingDatawithbookingid($bookingId);

        $companyid = $bookingdata->company_id;
        // dd($companyid);

        // get the data where company_id = $companyid
        $company = $data->companydata($companyid);
        // echo $companydata;
        $contactdata = $data->contactdata($companyid);
        $contact = $contactdata;

        $usersdata = DB::table('users')
            ->select('name', 'id')
            ->get();
        $eventsdata = DB::table('events')
            ->select('name', 'event_id', 'stall_price')
            ->get();
        // $bookingdata = $bookingsData->bookingDatawithbookingid($id);
        // echo "<pre>";
        // // print_r($company);
        // print_r($contact);


        // // // echo $bookingdata;
        // echo "<pre>";

        return view('sales.index', compact('bookingdata', 'company', 'eventsdata'));
        // $url = "sales/bookingdata/" . $bookingId;
        // return redirect($url);

    }

    public function bookingprocess($bookingid)
    {

        if ($bookingid == null) {
            return redirect('/');
        }

        $sql = new GetDataController();

        // Get booking data using booking ID
        $bookingdata = $sql->bookingDatawithbookingid($bookingid);

        // dd($bookingdata);

        if ($bookingdata->allow_edit == 0) {


            return redirect('exhibitor/dashboard/' . $bookingid);
        }
        if (!$bookingdata) {
            return redirect('/')->with('error', 'Booking not found');
        }
        $final_bookingdetails = $sql->final_bookingdetails($bookingdata->booking_id);


        // dd($final_bookingdetails);

        // return view('exhibitor.index', compact('final_bookingdetails', 'bookingdata'));




        $sql = new GetDataController();
        $eventsdata = DB::table('events')
            ->select('name', 'event_id', 'stall_price')
            ->get();


        $companyid = $bookingdata->company_id;
        // dd($companyid);

        // get the data where company_id = $companyid
        $company = $sql->companydata($companyid);
        $companydata = $sql->companydata($companyid);
        // echo "<pre>";
        // print_r($bookingdata);

        // // print_r($final_bookingdetails);
        // // print_r($final_bookingdetails);
        // // print_r($final_bookingdetails);
        // // echo $bookingdata;
        // echo "<pre>";        $contactdata = $data->contactdata($companyid);
        $contactdata = $sql->contactdata($bookingdata->company_id);
        $contact = $contactdata;
        // echo "<pre>";
        // // print_r($eventsdata);
        // print_r($bookingdata);
        // // print_r($contact);

        // // // print_r($final_bookingdetails);
        // // // print_r($final_bookingdetails);
        // // // print_r($final_bookingdetails);
        // // echo $bookingdata;
        // echo "<pre>";

        return view('exhibitor.bookingprocess.index', compact('companydata', 'eventsdata', 'bookingdata', 'contact', 'company'));

    }

    public function bookingsummary($company_id, $booking_id)
    {
        $sql = new GetDataController();

        $final_bookingdetails = $sql->final_bookingdetails($booking_id);
        dd($booking_id);

    }
    public function closebooking($id)
    {

        $allowedit = 0;
        DB::table('booking_record')->where('booking_id', $id)->update(['allow_edit' => $allowedit]);
        return redirect('exhibitor/dashboard/' . $id);

    }

    public function openbooking($id)
    {
        // dd($id);

        $allowedit = 1;
        DB::table('booking_record')->where('booking_id', $id)->update(['allow_edit' => $allowedit]);
        return redirect('exhibitor/dashboard/' . $id);

    }

    private function getBillingContact($bookingdata, $sql, $contact)
    {
        if (!empty($bookingdata->billing_contact_id)) {
            return $sql->billingcontact(
                $bookingdata->billing_contact_id
            );
        }

        $billingcontact = collect($contact)->first(function ($item) {
            return (int) ($item->billing_contact ?? 0) === 1;
        });

        if ($billingcontact) {
            DB::table('booking_record')
                ->where('booking_id', $bookingdata->booking_id)
                ->update([
                    'billing_contact_id' => $billingcontact->contact_id,
                ]);
        }

        return $billingcontact;
    }
}
