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
class StepByStepBookingController extends Controller
{


    public function bookingprocess($step, $bookingid)
    {
        $sql = new GetDataController();

        $bookingdata = $sql->bookingDatawithbookingid($bookingid);

        // dd($bookingdata);
        if ($bookingdata->allow_edit == 0) {
            return redirect('exhibitor/dashboard/' . $bookingdata->booking_id);
        }

        if (!$bookingdata) {
            die('Booking data not found');
        }

        $firsttime = !$bookingdata->allow_edit;

        switch ($step) {

            case 'step1':
                return $this->step1($bookingdata, $firsttime);

            case 'step2':
                return $this->step2($bookingdata, $firsttime);

            case 'step3':
                return $this->step3($bookingdata, $firsttime);

            case 'step4':
                return $this->step4($bookingdata, $firsttime);

            case 'step5':
                return $this->step5($bookingdata, $firsttime);

            case 'step6':
                return $this->step6($bookingdata, $firsttime);

            default:
                abort(404);
        }
    }

    private function step1($bookingdata, $firsttime)
    {
        // print_r($bookingdata);

        return view(
            'exhibitor.booking.index',
            compact('bookingdata', 'firsttime')
        );
    }

    private function step2($bookingdata, $firsttime)
    {
        $sql = new GetDataController();

        $contact = $sql->contactdata($bookingdata->company_id);
        // echo "<pre>";
        // print_r($contact);
        // print_r($bookingdata);

        // echo "</pre>";
        $contacttype = "billing";
        return view(
            'exhibitor.booking.index',
            compact('contact', 'firsttime', 'bookingdata', 'contacttype')
        );
    }

    private function step3($bookingdata, $firsttime)
    {
        $sql = new GetDataController();

        $company = $sql->companydata($bookingdata->company_id);

        return view(
            'exhibitor.booking.index',
            compact('bookingdata', 'company', 'firsttime')
        );
    }

    private function step4($bookingdata, $firsttime)
    {
        $sql = new GetDataController();

        $stall = $sql->stalldata($bookingdata->booking_id);

        $eventsdata = DB::table('events')
            ->select('name', 'event_id', 'stall_price')
            ->get();
        // echo "<pre>";
        // print_r($stall);
        // print_r($eventsdata);
        // print_r($bookingdata);
        // echo "</pre>";
        return view(
            'exhibitor.booking.index',
            compact('bookingdata', 'stall', 'firsttime', 'eventsdata')
        );
    }
    private function step5($bookingdata, $firsttime)
    {
        $sql = new GetDataController();
        $contact = $sql->contactdata($bookingdata->company_id);

        $stall = $sql->stalldata($bookingdata->booking_id);

        $eventsdata = DB::table('events')
            ->select('name', 'event_id', 'stall_price')
            ->get();
        // echo "<pre>";
        // print_r($stall);
        // print_r($eventsdata);
        // echo "</pre>";
        $contacttype = "delegate";

        return view(
            'exhibitor.booking.index',
            compact('bookingdata', 'stall', 'firsttime', 'eventsdata', 'contact', 'contacttype')
        );
    }
    private function step6($bookingdata, $firsttime)
    {
        $sql = new GetDataController();

        $contact = $sql->contactdata($bookingdata->company_id);

        $billingcontact = $this->getBillingContact(
            $bookingdata,
            $sql,
            $contact
        );
        $delegates = $sql->getDelegate($bookingdata->company_id);

        $company = $sql->companydata($bookingdata->company_id);
        $stall = $sql->stalldata($bookingdata->booking_id);
        $final_bookingdetails = $sql->final_bookingdetails($bookingdata->booking_id);
        $eventsdata = DB::table('events')
            ->select('name', 'event_id', 'stall_price')
            ->get();
        // echo "<pre>";
        // print_r($final_bookingdetails);

        // print_r($delegates);
        // // print_r($billingcontact);
        // // print_r($stall);
        // // print_r($eventsdata);
        // echo "</pre>";
        return view(
            'exhibitor.booking.index',
            compact(
                'bookingdata',
                'contact',
                'company',
                'stall',
                'firsttime',
                'billingcontact',
                'final_bookingdetails'
            )
        );
    }
}
?>