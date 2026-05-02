<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        $leads = DB::table('leads')

            // company + contact (unchanged)
            ->leftJoin('contact', 'leads.contact_id', '=', 'contact.contact_id')
            ->leftJoin('company_data', 'leads.company_id', '=', 'company_data.company_id')

            // latest mobile
            ->leftJoin(DB::raw('(
        SELECT cm1.contact_id, cm1.mobile
        FROM contact_mobile cm1
        INNER JOIN (
            SELECT contact_id, MAX(mobile_id) as max_id
            FROM contact_mobile
            GROUP BY contact_id
        ) cm2
        ON cm1.contact_id = cm2.contact_id AND cm1.mobile_id = cm2.max_id
    ) as contact_mobile'), function ($join) {
                $join->on('leads.contact_id', '=', 'contact_mobile.contact_id');
            })

            // latest email
            ->leftJoin(DB::raw('(
        SELECT ce1.contact_id, ce1.email
        FROM contact_email ce1
        INNER JOIN (
            SELECT contact_id, MAX(email_id) as max_id
            FROM contact_email
            GROUP BY contact_id
        ) ce2
        ON ce1.contact_id = ce2.contact_id AND ce1.email_id = ce2.max_id
    ) as contact_email'), function ($join) {
                $join->on('leads.contact_id', '=', 'contact_email.contact_id');
            })

            // NEW: quotation summary (from new structure)
            ->leftJoin('lead_quotations', 'leads.lead_id', '=', 'lead_quotations.lead_id')

            // NEW: payment summary (total paid per lead)
            ->leftJoin(DB::raw('(
        SELECT lead_id, SUM(amount) as total_paid
        FROM payments
        GROUP BY lead_id
    ) as payments_summary'), function ($join) {
                $join->on('leads.lead_id', '=', 'payments_summary.lead_id');
            })

            // NEW: location count (optional useful dashboard field)
            ->leftJoin(DB::raw('(
        SELECT lead_id, COUNT(*) as total_locations
        FROM lead_locations
        GROUP BY lead_id
    ) as locations_summary'), function ($join) {
                $join->on('leads.lead_id', '=', 'locations_summary.lead_id');
            })



            ->select(
                'leads.*',
                'contact.name as contact_name',
                'contact.designation',
                'company_data.company_name',

                'contact_mobile.mobile',
                'contact_email.email',

                // NEW FIELDS FROM NEW STRUCTURE
                'lead_quotations.grand_total',
                'lead_quotations.status as quotation_status',

                DB::raw('COALESCE(payments_summary.total_paid,0) as total_paid'),
                DB::raw('COALESCE(locations_summary.total_locations,0) as total_locations')
            )

            ->get();
        // echo "<pre>";
        // print_r($leads);
        // echo "</pre>";
        // die;
        $users = DB::table('users')->select('name', 'id')->get();
        // dd($users);
        return view('backend.admin.index', compact('leads', 'users'));
    }

    public function assignlead(Request $request)
    {
        $request->validate([
            'lead_id' => 'required|integer',
            'field_name' => 'required|string',
            'field_value' => 'nullable|string'
        ]);

        // safety whitelist (IMPORTANT)
        $allowedFields = ['sales_person'];

        if (!in_array($request->field_name, $allowedFields)) {
            return redirect()->back()->with('error', 'Invalid field');
        }

        DB::table('leads')
            ->where('lead_id', $request->lead_id)
            ->update([
                $request->field_name => $request->field_value,
                'updated_at' => now()
            ]);

        return redirect()->back()->with('success', 'Lead updated successfully!');
    }
    // 🔐 LOGIN PAGE
}
