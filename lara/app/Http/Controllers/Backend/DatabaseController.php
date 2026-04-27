<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\DatabaseController as DatabaseControllerApp;

class DatabaseController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');

        // dd($query);
        // 🔐 check session
        if (!session()->has('user')) {
            return redirect('/backend')->with('error', 'Login required');
        }

        // ❌ empty search
        if (!$query) {
            return view('backend.search', [
                'results' => [],
                'query' => ''
            ]);
        }

        // 🔍 detect type (email / phone / name)
        $email = null;
        $mobile = null;
        $name = null;

        if (filter_var($query, FILTER_VALIDATE_EMAIL)) {
            $email = $query;
        } elseif (is_numeric($query)) {
            $mobile = $query;
        } else {
            $name = $query;
        }

        // 📦 use your DatabaseController
        $database = new DatabaseControllerApp();

        $contactId = null;

        if ($mobile || $email) {

            $contactId = $database->getLatestContactId($mobile, $email);
            // dd($mobile, $email, $contactId);
        }


        $result = DB::table('contact')
            ->leftJoin('company_data', 'contact.company_id', '=', 'company_data.company_id')
            ->leftJoin('contact_email', 'contact.contact_id', '=', 'contact_email.contact_id')
            ->leftJoin('contact_mobile', 'contact.contact_id', '=', 'contact_mobile.contact_id')
            ->where('contact.contact_id', $contactId)
            ->select(
                'contact.*',
                'company_data.*',
                'contact_email.*',
                'contact_mobile.*'
            )
            ->get();
        $leads = DB::table('contact')
            ->leftJoin('company_data', 'contact.company_id', '=', 'company_data.company_id')
            ->leftJoin('contact_email', 'contact.contact_id', '=', 'contact_email.contact_id')
            ->leftJoin('contact_mobile', 'contact.contact_id', '=', 'contact_mobile.contact_id')

            // ✅ leads table
            ->leftJoin('leads', 'contact.contact_id', '=', 'leads.contact_id')

            // ✅ lead locations table
            ->leftJoin('lead_locations', 'leads.lead_id', '=', 'lead_locations.lead_id')

            ->where('contact.contact_id', $contactId)
            ->where('company_data.entry_type', 'leads')

            ->select(
                // contact
                'contact.contact_id',
                'contact.name',

                // company
                'company_data.company_id',
                'company_data.company_name',
                'company_data.entry_type',

                // email/mobile
                'contact_email.email',
                'contact_mobile.mobile',

                // leads
                'leads.lead_id',
                'leads.status',
                'leads.payment_status',
                'leads.fascia',
                'leads.exhibition_year',

                // lead_locations
                'lead_locations.location_id',
                'lead_locations.location',
                'lead_locations.stall_location',
                'lead_locations.size',
                'lead_locations.price',
                'lead_locations.gst_amount',
                'lead_locations.discount_amount',
                'lead_locations.grand_total'
            )
            ->get();
        // dd($leads);

        // $salesPerson = session('user.name');
        // dd($salesPerson);

        return view('backend.index', [
            'results' => $result,
            'leads' => $leads,
            'query' => $query,
        ]);

        // Table: company_data						
// Column Name	Type	Max Length	Primary Key	Nullable	Default	
// id	int		Yes	No	NULL	
// company_id	varchar	50	No	No	NULL	
// database_name	varchar	100	No	Yes	NULL	
// outbound	tinyint		No	Yes	0	
// company_name	varchar	255	No	No	NULL	
// category	varchar	100	No	Yes	NULL	
// address	text		No	Yes	NULL	
// city	varchar	100	No	Yes	NULL	
// pincode	varchar	20	No	Yes	NULL	
// state	varchar	100	No	Yes	NULL	
// country	varchar	100	No	Yes	NULL	
// website	varchar	255	No	Yes	NULL	
// phone	varchar	50	No	Yes	NULL	
// gst_number	varchar	50	No	Yes	NULL	
// sales_person	varchar	100	No	Yes	NULL	
// active_inactive	enum		No	Yes	active	
// created_at	timestamp		No	No	CURRENT_TIMESTAMP	
// updated_at	varchar	25	No	Yes	NULL	
// last_confirmed_at	datetime		No	Yes	NULL	
// session	int		No	No	0	
// cross_validation	tinyint	1	No	No	NULL	
// last_comments	text		No	Yes	NULL	
// second_last_comments	text		No	Yes	NULL	
// updated_by	text		No	Yes	NULL	
// second_last_comments_updated_by	text		No	Yes	NULL	
// entry_type	enum		No	No	NULL	
// pin	varchar	20	No	Yes	NULL	
// travel_segments	text		No	Yes	NULL	
// meet_profiles	text		No	Yes	NULL	
// meet_regions	text		No	Yes	NULL	
// interested_states	text		No	Yes	NULL	
// branch_offices	varchar	50	No	Yes	NULL	
// total_staff	varchar	50	No	Yes	NULL	
// association_membership	varchar	255	No	Yes	NULL	
// subcategory	varchar	100	No	Yes	NULL	
// Table: company_sources						
// Column Name	Type	Max Length	Primary Key	Nullable	Default	
// id	int		Yes	No	NULL	
// company_id	varchar	50	No	No	NULL	
// source_id	int		No	Yes	NULL	
// event_date	date		No	Yes	NULL	
// notes	varchar	255	No	Yes	NULL	
// created_at	timestamp		No	No	CURRENT_TIMESTAMP	
// Table: contact						
// Column Name	Type	Max Length	Primary Key	Nullable	Default	
// contact_id	int		Yes	No	NULL	
// company_id	varchar	50	No	No	NULL	
// priority	tinyint		No	Yes	1	
// name	varchar	255	No	Yes	NULL	
// designation	varchar	100	No	Yes	NULL	
// image	varchar	255	No	Yes	NULL	
// created_at	timestamp		No	No	CURRENT_TIMESTAMP	
// updated_at	datetime		No	Yes	NULL	
// attendance_reason	varchar	100	No	Yes	NULL	
// buyer_responsibility	varchar	100	No	Yes	NULL	
// attended_past	enum		No	Yes	No	
// interest_forum	enum		No	Yes	No	
// business_card_path	varchar	255	No	Yes	NULL	
// otp	varchar	6	No	Yes	NULL	
// otp_expiry	datetime		No	Yes	NULL	
// self_verified	tinyint	1	No	Yes	NULL	
// Table: contact_email						
// Column Name	Type	Max Length	Primary Key	Nullable	Default	
// email_id	int		Yes	No	NULL	
// contact_id	int		No	No	NULL	
// email	varchar	100	No	No	NULL	
// is_primary	tinyint		No	Yes	0	
// created_at	timestamp		No	No	CURRENT_TIMESTAMP	
// updated_at	timestamp		No	Yes	NULL	
// Table: contact_mobile						
// Column Name	Type	Max Length	Primary Key	Nullable	Default	
// mobile_id	int		Yes	No	NULL	
// contact_id	int		No	No	NULL	
// mobile	varchar	50	No	No	NULL	
// is_primary	tinyint		No	Yes	0	
// created_at	timestamp		No	No	CURRENT_TIMESTAMP	
// updated_at	timestamp		No	Yes	NULL	


        // Table: lead_locations						
// Column Name	Type	Max Length	Primary Key	Nullable	Default	
// location_id	int		No	No	NULL	
// lead_id	int		No	No	NULL	
// location	varchar	100	No	Yes	NULL	
// stall_location	varchar	100	No	Yes	NULL	
// size	varchar	50	No	Yes	NULL	
// price	decimal	10	No	Yes	0	
// gst_amount	decimal	10	No	Yes	0	
// discount_amount	decimal	10	No	Yes	0	
// grand_total	decimal	10	No	Yes	0	
// created_at	timestamp		No	No	CURRENT_TIMESTAMP	
// updated_at	datetime		No	Yes	CURRENT_TIMESTAMP	
// Table: leads						
// Column Name	Type	Max Length	Primary Key	Nullable	Default	
// lead_id	int		Yes	No	NULL	
// company_id	varchar	50	No	No	NULL	
// contact_id	int		No	Yes	NULL	
// exhibition_year	int		No	Yes	NULL	
// fascia	varchar	100	No	Yes	NULL	
// sales_person	varchar	100	No	Yes	NULL	
// exhibitor	varchar	255	No	Yes	NULL	
// booking_form	varchar	255	No	Yes	NULL	
// status	enum		No	Yes	draft	
// payment_status	enum		No	Yes	pending	
// created_at	timestamp		No	No	CURRENT_TIMESTAMP	
// updated_at	datetime		No	Yes	NULL	



        // return view('backend.index', [
        //     'results' => $leads,
        //     'query' => $query
        // ]);
    }
}