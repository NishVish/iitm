<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class LeadsController extends Controller
{
    public function index(Request $request)
    {
        // 🔐 get session user
        $user = session('user');

        // ❌ if not logged in
        if (!$user) {
            return redirect('/backend')->with('error', 'Please login first');
        }

        // ✅ correct name extraction
        $salesPerson = $user[0]->name;

        // 📦 get leads
        $leads = DB::table('leads')
            ->where('sales_person', $salesPerson)
            ->orderBy('lead_id', 'desc')
            ->get();
        $mobile = DB::table('contact_mobile')
            ->where('contact_id', $leads->contact_id)
            ->get();
        // 📦 get lead IDs
        $leadIds = $leads->pluck('lead_id');

        // 📦 get all locations (optimized)
        $locations = DB::table('lead_locations')
            ->whereIn('lead_id', $leadIds)
            ->get()
            ->groupBy('lead_id');
        $orders = DB::table('orders')
            ->whereIn('lead_id', $leadIds)
            ->get()
            ->groupBy('lead_id');


        // 🔗 attach locations
        foreach ($leads as $lead) {
            $lead->locations = $locations[$lead->lead_id] ?? collect();
            $lead->orders = $orders[$lead->lead_id] ?? collect();
        }

        dd($lead, $salesPerson, $mobile);
        return view('backend.index', [
            'leads' => $leads,
            'salesPerson' => $salesPerson,
            'mobile' => $mobile
        ]);
    }

    public function markaslead()
    {

        // dd(request()->all());
        $id = request()->contact_id;
        // $user = session('user');
        // 1. get contact
        $contact = DB::table('contact')
            ->where('contact_id', $id)
            ->first();

        if (!$contact) {
            return back()->with('error', 'Contact not found');
        }

        // 2. get company
        $company = DB::table('company_data')
            ->where('company_id', $contact->company_id)
            ->first();

        if (!$company) {
            return back()->with('error', 'Company not found');
        }

        // 3. emails + mobiles
        $emails = DB::table('contact_email')
            ->where('contact_id', $id)
            ->get();

        $mobiles = DB::table('contact_mobile')
            ->where('contact_id', $id)
            ->get();

        // 4. new IDs
        $newCompanyId = 'CMP_' . uniqid();
        $newContactId = DB::table('contact')->max('contact_id') + 1;

        // 5. duplicate company
        DB::table('company_data')->insert([
            'company_id' => $newCompanyId,
            'database_name' => $company->database_name,
            'outbound' => $company->outbound,
            'company_name' => $company->company_name,
            'category' => $company->category,
            'subcategory' => $company->subcategory,
            'address' => $company->address,
            'city' => $company->city,
            'pincode' => $company->pincode,
            'state' => $company->state,
            'country' => $company->country,
            'website' => $company->website,
            'phone' => $company->phone,
            'gst_number' => $company->gst_number,
            'sales_person' => $user ?? null,
            'active_inactive' => 'active',
            'session' => 0,
            'cross_validation' => 0,
            'entry_type' => 'lead',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 6. duplicate contact
        DB::table('contact')->insert([
            'contact_id' => $newContactId,
            'company_id' => $newCompanyId,
            'priority' => $contact->priority,
            'name' => $contact->name,
            'designation' => $contact->designation,
            'image' => $contact->image,
            'attendance_reason' => $contact->attendance_reason,
            'buyer_responsibility' => $contact->buyer_responsibility,
            'attended_past' => $contact->attended_past,
            'interest_forum' => $contact->interest_forum,
            'business_card_path' => null,
            'otp' => null,
            'otp_expiry' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 7. duplicate emails
        foreach ($emails as $email) {
            DB::table('contact_email')->insert([
                'contact_id' => $newContactId,
                'email' => $email->email,
                'is_primary' => $email->is_primary,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 8. duplicate mobiles
        foreach ($mobiles as $mobile) {
            DB::table('contact_mobile')->insert([
                'contact_id' => $newContactId,
                'mobile' => $mobile->mobile,
                'is_primary' => $mobile->is_primary,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        db::table('company_sources')->insert([
            'company_id' => $newCompanyId,
            'event_date' => null,
            'notes' => session('user')[0]->name,
            'created_at' => now(),
        ]);




        return back()->with('success', 'Contact successfully cloned as Lead');
    }


}

