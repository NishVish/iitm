<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class DatabaseController extends Controller
{


    public function index()
    {


        return view("web.database");
    }

    public function getAllCompanyData($mobileNumber)
    {
        $data = DB::table('contact_mobile')
            ->join('contact', 'contact_mobile.contact_id', '=', 'contact.contact_id')
            ->join('company_data', 'contact.company_id', '=', 'company_data.company_id')
            ->where('contact_mobile.mobile', $mobileNumber)
            ->select(
                'contact.*',
                'company_data.*',
                'contact_mobile.mobile'
            )
            ->orderBy('contact.updated_at', 'desc')
            ->get();

        // dd($data);
        if ($data->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'No data found',
                'count' => 0,
                'data' => []
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data found',
            'count' => $data->count(),
            'data' => $data
        ]);
    }

    public function checkifleadexists($contactid)
    {

        $data = DB::table('leads')->where('contact_id', $contactid)->first();
        // $dataall = DB::table('leads')->get();

        // dd($data);
        echo "<pre>";
        // print_r($data);
        // print_r($dataall);
        print_r($contactid);
        print_r("Super");
        echo "</pre>";

        // if()
        return $data;
    }

    public function Updateeamilandcontact($contactid, $data)
    {

        DB::table('contact')->where('contact_id', $contactid)->update($data);
        db::table('contact_email')->where('contact_id', $contactid)->update($data);


    }

    // use Illuminate\Support\Facades\DB;

    public function mergeOnUpdate($mobile = null, $email = null)
    {
        if (!$mobile && !$email) {
            return null;
        }

        DB::beginTransaction();

        try {
            // Step 1: Find all contact_ids that match the given email or mobile
            $contactIdsFromEmail = collect();
            $contactIdsFromMobile = collect();

            if ($email) {
                $contactIdsFromEmail = DB::table('contact_email')
                    ->where('email', $email)
                    ->pluck('contact_id');
            }

            if ($mobile) {
                $contactIdsFromMobile = DB::table('contact_mobile')
                    ->where('mobile', $mobile)
                    ->pluck('contact_id');
            }

            $allContactIds = $contactIdsFromEmail->merge($contactIdsFromMobile)->unique()->values();

            if ($allContactIds->isEmpty()) {
                DB::rollBack();
                return null;
            }

            // Step 2: Pull all contacts and their company_ids
            $contacts = DB::table('contact')
                ->whereIn('contact_id', $allContactIds)
                ->get();

            $allCompanyIds = $contacts->pluck('company_id')->unique()->filter()->values();

            // ---------------------------------------------------------------
            // COMPANY MERGE
            // ---------------------------------------------------------------

            $masterCompanyId = null;

            if ($allCompanyIds->count() > 1) {

                // Step 3: Pick master company — prefer the one with a company_name,
                //         then most data filled, then earliest created_at
                $companies = DB::table('company_data')
                    ->where('entry_type', 'main')
                    ->whereIn('company_id', $allCompanyIds)
                    ->get();

                $masterCompany = $companies
                    ->sortByDesc(fn($c) => [
                        !empty($c->company_name) ? 1 : 0,   // has name wins
                        collect((array) $c)->filter(fn($v) => !is_null($v) && $v !== '')->count(), // most filled fields
                    ])
                    ->first();

                $masterCompanyId = $masterCompany->company_id;
                $duplicateCompanyIds = $allCompanyIds->reject(fn($id) => $id === $masterCompanyId)->values();

                // Step 4: Fill NULL fields on master company from duplicates
                $fillableCompanyFields = [
                    'company_name',
                    'database_name',
                    'category',
                    'address',
                    'city',
                    'pincode',
                    'state',
                    'country',
                    'website',
                    'phone',
                    'gst_number',
                    'sales_person',
                    'travel_segments',
                    'meet_profiles',
                    'meet_regions',
                    'interested_states',
                    'branch_offices',
                    'total_staff',
                    'association_membership',
                    'last_comments',
                    'pin',
                ];

                $masterData = (array) $masterCompany;
                $dupCompanies = $companies
                    ->whereIn('company_id', $duplicateCompanyIds->toArray())
                    ->sortBy('created_at');

                $companyUpdates = [];
                foreach ($fillableCompanyFields as $field) {
                    if (empty($masterData[$field])) {
                        foreach ($dupCompanies as $dup) {
                            if (!empty($dup->$field)) {
                                $companyUpdates[$field] = $dup->$field;
                                break;
                            }
                        }
                    }
                }

                if (!empty($companyUpdates)) {
                    $companyUpdates['updated_at'] = now();
                    DB::table('company_data')
                        ->where('company_id', $masterCompanyId)
                        ->update($companyUpdates);
                }

                // Step 5: Re-point all contacts from duplicate companies → master company
                DB::table('contact')
                    ->whereIn('company_id', $duplicateCompanyIds->toArray())
                    ->update(['company_id' => $masterCompanyId]);

                // Step 6: Re-point company_sources rows → master company
                DB::table('company_sources')
                    ->whereIn('company_id', $duplicateCompanyIds->toArray())
                    ->update(['company_id' => $masterCompanyId]);

                // Step 7: Delete duplicate company_sources duplicates that now clash
                //         (same company_id + source_id + event_date)
                $sources = DB::table('company_sources')
                    ->where('company_id', $masterCompanyId)
                    ->get();

                $seenSources = [];
                foreach ($sources as $src) {
                    $key = $src->source_id . '_' . $src->event_date;
                    if (in_array($key, $seenSources, true)) {
                        DB::table('company_sources')->where('id', $src->id)->delete();
                        continue;
                    }
                    $seenSources[] = $key;
                }

                // Step 8: Delete duplicate company records
                DB::table('company_data')
                    ->whereIn('company_id', $duplicateCompanyIds->toArray())
                    ->delete();

            } elseif ($allCompanyIds->count() === 1) {
                $masterCompanyId = $allCompanyIds->first();

                // Still fill any NULLs on the single company if needed
                $company = DB::table('company_data')
                    ->where('company_id', $masterCompanyId)
                    ->first();

                // company_name missing — flag or auto-fill if any contact has a hint
                if (empty($company->company_name)) {
                    // Optionally log or flag for manual review
                    \Log::warning("company_id {$masterCompanyId} has no company_name after merge.");
                }
            }

            // ---------------------------------------------------------------
            // CONTACT MERGE (same as before, now all contacts share masterCompanyId)
            // ---------------------------------------------------------------

            // Refresh contact list after company re-pointing
            $allContactIds = DB::table('contact')
                ->where('company_id', $masterCompanyId)
                ->whereIn('contact_id', $allContactIds)
                ->pluck('contact_id');

            $masterContact = DB::table('contact')
                ->whereIn('contact_id', $allContactIds)
                ->orderByRaw("CASE WHEN priority = 1 THEN 0 ELSE 1 END")
                ->orderBy('created_at', 'asc')
                ->first();

            if (!$masterContact) {
                DB::rollBack();
                return null;
            }

            $masterId = $masterContact->contact_id;
            $duplicateIds = $allContactIds->reject(fn($id) => $id === $masterId)->values();

            // Emails
            $allEmails = DB::table('contact_email')->whereIn('contact_id', $allContactIds)->get();
            $seenEmails = [];
            $hasPrimary = false;

            foreach ($allEmails as $row) {
                $normalised = strtolower(trim($row->email));
                if (in_array($normalised, $seenEmails, true)) {
                    DB::table('contact_email')->where('email_id', $row->email_id)->delete();
                    continue;
                }
                $seenEmails[] = $normalised;
                if ((int) $row->contact_id !== (int) $masterId) {
                    DB::table('contact_email')->where('email_id', $row->email_id)
                        ->update(['contact_id' => $masterId]);
                }
                if ($row->is_primary)
                    $hasPrimary = true;
            }

            if (!$hasPrimary) {
                $first = DB::table('contact_email')->where('contact_id', $masterId)
                    ->orderBy('email_id')->first();
                if ($first)
                    DB::table('contact_email')->where('email_id', $first->email_id)
                        ->update(['is_primary' => 1]);
            }

            // Mobiles
            $allMobiles = DB::table('contact_mobile')->whereIn('contact_id', $allContactIds)->get();
            $seenMobiles = [];
            $hasPrimaryMobile = false;

            foreach ($allMobiles as $row) {
                $normalised = preg_replace('/\D/', '', $row->mobile);
                if (in_array($normalised, $seenMobiles, true)) {
                    DB::table('contact_mobile')->where('mobile_id', $row->mobile_id)->delete();
                    continue;
                }
                $seenMobiles[] = $normalised;
                if ((int) $row->contact_id !== (int) $masterId) {
                    DB::table('contact_mobile')->where('mobile_id', $row->mobile_id)
                        ->update(['contact_id' => $masterId]);
                }
                if ($row->is_primary)
                    $hasPrimaryMobile = true;
            }

            if (!$hasPrimaryMobile) {
                $first = DB::table('contact_mobile')->where('contact_id', $masterId)
                    ->orderBy('mobile_id')->first();
                if ($first)
                    DB::table('contact_mobile')->where('mobile_id', $first->mobile_id)
                        ->update(['is_primary' => 1]);
            }

            // Fill NULL contact fields from duplicates
            if ($duplicateIds->isNotEmpty()) {
                $fillableContactFields = [
                    'name',
                    'designation',
                    'image',
                    'attendance_reason',
                    'buyer_responsibility',
                    'attended_past',
                    'interest_forum',
                    'business_card_path',
                ];

                $masterData = (array) $masterContact;
                $duplicates = DB::table('contact')
                    ->whereIn('contact_id', $duplicateIds)
                    ->orderBy('created_at')->get();

                $contactUpdates = [];
                foreach ($fillableContactFields as $field) {
                    if (empty($masterData[$field])) {
                        foreach ($duplicates as $dup) {
                            if (!empty($dup->$field)) {
                                $contactUpdates[$field] = $dup->$field;
                                break;
                            }
                        }
                    }
                }

                if (!empty($contactUpdates)) {
                    $contactUpdates['updated_at'] = now();
                    DB::table('contact')->where('contact_id', $masterId)->update($contactUpdates);
                }

                DB::table('contact')->whereIn('contact_id', $duplicateIds)->delete();
            }

            DB::commit();

            return DB::table('contact')
                ->where('contact_id', $masterId)
                // ->with('company') // if using Eloquent model instead
                ->first();

        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }
    // public function mergeOnUpdate2($mobile = null, $email = null)
    // {

    //     // echo ($mobile . "<br>");
    //     // echo ($email . "<br>");
    //     // $mobile_id = DB::table('contact_mobile')->where('mobile', $mobile)->first();
    //     // // dd($mid->contact_id);
    //     // $mid = $mobile_id->contact_id;
    //     // $email_id = DB::table('contact_email')->where('email', $email)->first();
    //     // $eid = $email_id->contact_id;
    //     // // dd($mid, $eid);
    //     // if ($mid == $eid) {
    //     //     return [$mid, true];
    //     // }
    //     // exit;
    //     // echo 'SuperDanger';
    //     // dd($mobile, $email);
    //     if (!$mobile && !$email) {
    //         return null;
    //     }

    //     DB::beginTransaction();

    //     try {
    //         // ---------------------------------------------------------------
    //         // STEP 1: Gather ALL contact_ids matching the given email OR mobile
    //         // ---------------------------------------------------------------
    //         $contactIdsFromEmail = collect();
    //         $contactIdsFromMobile = collect();

    //         if ($email) {
    //             $contactIdsFromEmail = DB::table('contact_email')
    //                 ->where('email', $email)
    //                 ->pluck('contact_id');
    //         }

    //         if ($mobile) {
    //             $contactIdsFromMobile = DB::table('contact_mobile')
    //                 ->where('mobile', $mobile)
    //                 ->pluck('contact_id');
    //         }

    //         $allContactIds = $contactIdsFromEmail
    //             ->merge($contactIdsFromMobile)
    //             ->unique()
    //             ->filter()
    //             ->values();

    //         if ($allContactIds->isEmpty()) {
    //             DB::rollBack();
    //             return null;
    //         }

    //         // ---------------------------------------------------------------
    //         // STEP 2: Cross-expand — for each contact found, pull ALL their
    //         //         emails and mobiles, then find MORE contacts sharing those
    //         //         values. Repeat until no new contacts are discovered.
    //         // ---------------------------------------------------------------
    //         $resolved = collect();

    //         do {
    //             $newIds = $allContactIds->diff($resolved);
    //             if ($newIds->isEmpty())
    //                 break;

    //             // All emails belonging to these contacts
    //             $emails = DB::table('contact_email')
    //                 ->whereIn('contact_id', $newIds)
    //                 ->pluck('email')
    //                 ->unique();

    //             // All mobiles belonging to these contacts
    //             $mobiles = DB::table('contact_mobile')
    //                 ->whereIn('contact_id', $newIds)
    //                 ->pluck('mobile')
    //                 ->map(fn($m) => preg_replace('/\D/', '', $m))
    //                 ->unique()
    //                 ->filter();

    //             // Find more contacts sharing those emails
    //             $moreFromEmails = DB::table('contact_email')
    //                 ->whereIn('email', $emails)
    //                 ->pluck('contact_id');

    //             // Find more contacts sharing those mobiles (normalised)
    //             $moreFromMobiles = collect();
    //             if ($mobiles->isNotEmpty()) {
    //                 $allMobileRows = DB::table('contact_mobile')->get();
    //                 $moreFromMobiles = $allMobileRows
    //                     ->filter(fn($r) => $mobiles->contains(preg_replace('/\D/', '', $r->mobile)))
    //                     ->pluck('contact_id');
    //             }

    //             $resolved = $resolved->merge($newIds)->unique()->values();

    //             $allContactIds = $allContactIds
    //                 ->merge($moreFromEmails)
    //                 ->merge($moreFromMobiles)
    //                 ->unique()
    //                 ->filter()
    //                 ->values();

    //         } while ($allContactIds->count() > $resolved->count());

    //         // ---------------------------------------------------------------
    //         // STEP 3: Load all contacts, pick MASTER contact
    //         //         Priority: has most recent updated_at, then priority=1,
    //         //         then most filled fields, then earliest created_at
    //         // ---------------------------------------------------------------
    //         $contacts = DB::table('contact')
    //             ->whereIn('contact_id', $allContactIds)
    //             ->get();

    //         $masterContact = $contacts->sortByDesc(function ($c) {
    //             return [
    //                 $c->updated_at ? strtotime($c->updated_at) : 0,   // latest updated
    //                 (int) ($c->priority == 1),                          // priority flag
    //                 collect((array) $c)->filter(fn($v) => !is_null($v) && $v !== '')->count(), // richest
    //                 -strtotime($c->created_at),                         // earliest created (inverted)
    //             ];
    //         })->first();

    //         $masterId = $masterContact->contact_id;
    //         $duplicateIds = $allContactIds->reject(fn($id) => $id == $masterId)->values();

    //         // ---------------------------------------------------------------
    //         // STEP 4: COMPANY MERGE
    //         //         Pick master company, fill NULLs, re-point all relations
    //         // ---------------------------------------------------------------
    //         $allCompanyIds = $contacts->pluck('company_id')->unique()->filter()->values();

    //         $masterCompanyId = null;

    //         if ($allCompanyIds->isNotEmpty()) {
    //             $companies = DB::table('company_data')
    //                 ->whereIn('company_id', $allCompanyIds)
    //                 ->get();

    //             // Master company: latest updated → has company_name → most filled → earliest
    //             $masterCompany = $companies->sortByDesc(function ($c) {
    //                 return [
    //                     $c->updated_at ? strtotime($c->updated_at) : 0,
    //                     !empty($c->company_name) ? 1 : 0,
    //                     collect((array) $c)->filter(fn($v) => !is_null($v) && $v !== '')->count(),
    //                     -strtotime($c->created_at),
    //                 ];
    //             })->first();

    //             $masterCompanyId = $masterCompany->company_id;
    //             $dupCompanyIds = $allCompanyIds->reject(fn($id) => $id == $masterCompanyId)->values();

    //             // Fill NULL fields on master company from duplicates
    //             $fillableCompanyFields = [
    //                 'company_name',
    //                 'database_name',
    //                 'category',
    //                 'address',
    //                 'city',
    //                 'pincode',
    //                 'state',
    //                 'country',
    //                 'website',
    //                 'phone',
    //                 'gst_number',
    //                 'sales_person',
    //                 'travel_segments',
    //                 'meet_profiles',
    //                 'meet_regions',
    //                 'interested_states',
    //                 'branch_offices',
    //                 'total_staff',
    //                 'association_membership',
    //                 'last_comments',
    //                 'pin',
    //             ];

    //             $masterCompanyData = (array) $masterCompany;
    //             $dupCompanies = $companies
    //                 ->whereIn('company_id', $dupCompanyIds->toArray())
    //                 ->sortByDesc(fn($c) => $c->updated_at ? strtotime($c->updated_at) : 0);

    //             $companyUpdates = [];
    //             foreach ($fillableCompanyFields as $field) {
    //                 if (empty($masterCompanyData[$field])) {
    //                     foreach ($dupCompanies as $dup) {
    //                         if (!empty($dup->$field)) {
    //                             $companyUpdates[$field] = $dup->$field;
    //                             break;
    //                         }
    //                     }
    //                 }
    //             }

    //             if (!empty($companyUpdates)) {
    //                 $companyUpdates['updated_at'] = now();
    //                 DB::table('company_data')
    //                     ->where('company_id', $masterCompanyId)
    //                     ->update($companyUpdates);
    //             }

    //             // Re-point contacts and sources to master company
    //             if ($dupCompanyIds->isNotEmpty()) {
    //                 DB::table('contact')
    //                     ->whereIn('company_id', $dupCompanyIds->toArray())
    //                     ->update(['company_id' => $masterCompanyId]);

    //                 DB::table('company_sources')
    //                     ->whereIn('company_id', $dupCompanyIds->toArray())
    //                     ->update(['company_id' => $masterCompanyId]);

    //                 // De-dup company_sources after re-pointing
    //                 $sources = DB::table('company_sources')
    //                     ->where('company_id', $masterCompanyId)
    //                     ->orderBy('created_at', 'desc')
    //                     ->get();

    //                 $seenSources = [];
    //                 foreach ($sources as $src) {
    //                     $key = $src->source_id . '_' . $src->event_date;
    //                     if (in_array($key, $seenSources, true)) {
    //                         DB::table('company_sources')->where('id', $src->id)->delete();
    //                         continue;
    //                     }
    //                     $seenSources[] = $key;
    //                 }

    //                 DB::table('company_data')
    //                     ->whereIn('company_id', $dupCompanyIds->toArray())
    //                     ->delete();
    //             }
    //         }

    //         // ---------------------------------------------------------------
    //         // STEP 5: EMAIL MERGE
    //         //         Re-assign all emails to master contact, deduplicate,
    //         //         ensure one primary. Prefer latest updated email row.
    //         // ---------------------------------------------------------------
    //         $allEmails = DB::table('contact_email')
    //             ->whereIn('contact_id', $allContactIds)
    //             // Use COALESCE to fallback to created_at if updated_at is NULL
    //             ->orderByRaw('COALESCE(updated_at, created_at) DESC')
    //             ->get();
    //         // Also pull emails from contacts in the same company that share
    //         // email/mobile — already covered by cross-expand above, but
    //         // re-check company-level orphans with no mobile
    //         if ($masterCompanyId) {
    //             $companyContactIds = DB::table('contact')
    //                 ->where('company_id', $masterCompanyId)
    //                 ->pluck('contact_id');

    //             $allContactIds = $allContactIds->merge($companyContactIds)->unique()->values();

    //             $allEmails = DB::table('contact_email')
    //                 ->whereIn('contact_id', $allContactIds)
    //                 ->get();
    //         }

    //         $seenEmails = [];
    //         $hasPrimary = false;

    //         // Sort: is_primary first, then by email_id desc (latest entry)
    //         $sortedEmails = $allEmails->sortByDesc(fn($r) => [$r->is_primary, $r->email_id]);

    //         foreach ($sortedEmails as $row) {
    //             $normalised = strtolower(trim($row->email));

    //             if (in_array($normalised, $seenEmails, true)) {
    //                 DB::table('contact_email')->where('email_id', $row->email_id)->delete();
    //                 continue;
    //             }

    //             $seenEmails[] = $normalised;

    //             if ((int) $row->contact_id !== (int) $masterId) {
    //                 DB::table('contact_email')
    //                     ->where('email_id', $row->email_id)
    //                     ->update(['contact_id' => $masterId]);
    //             }

    //             if ($row->is_primary) {
    //                 $hasPrimary = true;
    //             }
    //         }

    //         if (!$hasPrimary) {
    //             $first = DB::table('contact_email')
    //                 ->where('contact_id', $masterId)
    //                 ->orderBy('email_id', 'asc')
    //                 ->first();
    //             if ($first) {
    //                 DB::table('contact_email')
    //                     ->where('email_id', $first->email_id)
    //                     ->update(['is_primary' => 1]);
    //             }
    //         }

    //         // ---------------------------------------------------------------
    //         // STEP 6: MOBILE MERGE
    //         //         Same logic — re-assign, deduplicate, ensure one primary
    //         //         Check cross-matched contacts for missing mobiles
    //         // ---------------------------------------------------------------
    //         $allMobileRows = DB::table('contact_mobile')
    //             ->whereIn('contact_id', $allContactIds)
    //             ->get();

    //         $seenMobiles = [];
    //         $hasPrimaryMobile = false;

    //         $sortedMobiles = $allMobileRows->sortByDesc(fn($r) => [$r->is_primary, $r->mobile_id]);

    //         foreach ($sortedMobiles as $row) {
    //             $normalised = preg_replace('/\D/', '', $row->mobile);

    //             if (empty($normalised)) {
    //                 DB::table('contact_mobile')->where('mobile_id', $row->mobile_id)->delete();
    //                 continue;
    //             }

    //             if (in_array($normalised, $seenMobiles, true)) {
    //                 DB::table('contact_mobile')->where('mobile_id', $row->mobile_id)->delete();
    //                 continue;
    //             }

    //             $seenMobiles[] = $normalised;

    //             if ((int) $row->contact_id !== (int) $masterId) {
    //                 DB::table('contact_mobile')
    //                     ->where('mobile_id', $row->mobile_id)
    //                     ->update(['contact_id' => $masterId]);
    //             }

    //             if ($row->is_primary) {
    //                 $hasPrimaryMobile = true;
    //             }
    //         }

    //         if (!$hasPrimaryMobile) {
    //             $first = DB::table('contact_mobile')
    //                 ->where('contact_id', $masterId)
    //                 ->orderBy('mobile_id', 'asc')
    //                 ->first();
    //             if ($first) {
    //                 DB::table('contact_mobile')
    //                     ->where('mobile_id', $first->mobile_id)
    //                     ->update(['is_primary' => 1]);
    //             }
    //         }

    //         // ---------------------------------------------------------------
    //         // STEP 7: CONTACT FIELD MERGE
    //         //         Fill NULLs on master from duplicates (latest updated first)
    //         //         Also fill company_id if master contact has none
    //         // ---------------------------------------------------------------
    //         $fillableContactFields = [
    //             'name',
    //             'designation',
    //             'image',
    //             'attendance_reason',
    //             'buyer_responsibility',
    //             'attended_past',
    //             'interest_forum',
    //             'business_card_path',
    //             'company_id',
    //         ];

    //         $masterData = (array) DB::table('contact')->where('contact_id', $masterId)->first();

    //         $dupContacts = DB::table('contact')
    //             ->whereIn('contact_id', $duplicateIds)
    //             ->orderByDesc('updated_at')
    //             ->get();

    //         $contactUpdates = [];
    //         foreach ($fillableContactFields as $field) {
    //             if (empty($masterData[$field])) {
    //                 foreach ($dupContacts as $dup) {
    //                     if (!empty($dup->$field)) {
    //                         $contactUpdates[$field] = $dup->$field;
    //                         break;
    //                     }
    //                 }
    //             }
    //         }

    //         // If master still has no company_id, assign masterCompanyId
    //         if (empty($contactUpdates['company_id']) && empty($masterData['company_id']) && $masterCompanyId) {
    //             $contactUpdates['company_id'] = $masterCompanyId;
    //         }

    //         if (!empty($contactUpdates)) {
    //             $contactUpdates['updated_at'] = now();
    //             DB::table('contact')
    //                 ->where('contact_id', $masterId)
    //                 ->update($contactUpdates);
    //         }

    //         // ---------------------------------------------------------------
    //         // STEP 8: DELETE duplicate contacts
    //         // ---------------------------------------------------------------
    //         if ($duplicateIds->isNotEmpty()) {
    //             DB::table('contact')
    //                 ->whereIn('contact_id', $duplicateIds)
    //                 ->delete();
    //         }

    //         DB::commit();

    //         return DB::table('contact')
    //             ->where('contact_id', $masterId)
    //             ->first();

    //     } catch (\Throwable $e) {
    //         DB::rollBack();
    //         throw $e;
    //     }
    // }


    // public function mergeOnUpdate2($mobile = null, $email = null)
    // {
    //     if (!$mobile && !$email) {
    //         return null;
    //     }

    //     DB::beginTransaction();

    //     try {
    //         // ---------------------------------------------------------------
    //         // STEP 1: Gather ALL contact_ids matching the given email OR mobile
    //         // ---------------------------------------------------------------
    //         $contactIdsFromEmail = collect();
    //         $contactIdsFromMobile = collect();

    //         if ($email) {
    //             $contactIdsFromEmail = DB::table('contact_email')
    //                 ->where('email', $email)
    //                 ->pluck('contact_id');
    //         }

    //         if ($mobile) {
    //             $contactIdsFromMobile = DB::table('contact_mobile')
    //                 ->where('mobile', $mobile)
    //                 ->pluck('contact_id');
    //         }

    //         $allContactIds = $contactIdsFromEmail
    //             ->merge($contactIdsFromMobile)
    //             ->unique()
    //             ->filter()
    //             ->values();

    //         if ($allContactIds->isEmpty()) {
    //             DB::rollBack();
    //             return null;
    //         }

    //         // ---------------------------------------------------------------
    //         // STEP 2: Cross-expand — for each contact found, pull ALL their
    //         //         emails and mobiles, then find MORE contacts sharing those
    //         //         values. Repeat until no new contacts are discovered.
    //         // ---------------------------------------------------------------
    //         $resolved = collect();

    //         do {
    //             $newIds = $allContactIds->diff($resolved);
    //             if ($newIds->isEmpty())
    //                 break;

    //             $emails = DB::table('contact_email')
    //                 ->whereIn('contact_id', $newIds)
    //                 ->pluck('email')
    //                 ->unique();

    //             $mobiles = DB::table('contact_mobile')
    //                 ->whereIn('contact_id', $newIds)
    //                 ->pluck('mobile')
    //                 ->map(fn($m) => preg_replace('/\D/', '', $m))
    //                 ->unique()
    //                 ->filter();

    //             $moreFromEmails = DB::table('contact_email')
    //                 ->whereIn('email', $emails)
    //                 ->pluck('contact_id');

    //             $moreFromMobiles = collect();
    //             if ($mobiles->isNotEmpty()) {
    //                 $allMobileRows = DB::table('contact_mobile')->get();
    //                 $moreFromMobiles = $allMobileRows
    //                     ->filter(fn($r) => $mobiles->contains(preg_replace('/\D/', '', $r->mobile)))
    //                     ->pluck('contact_id');
    //             }

    //             $resolved = $resolved->merge($newIds)->unique()->values();

    //             $allContactIds = $allContactIds
    //                 ->merge($moreFromEmails)
    //                 ->merge($moreFromMobiles)
    //                 ->unique()
    //                 ->filter()
    //                 ->values();

    //         } while ($allContactIds->count() > $resolved->count());

    //         // ---------------------------------------------------------------
    //         // STEP 3: Load all contacts, pick MASTER contact
    //         // ---------------------------------------------------------------
    //         $contacts = DB::table('contact')
    //             ->whereIn('contact_id', $allContactIds)
    //             ->get();

    //         $masterContact = $contacts->sortByDesc(function ($c) {
    //             return [
    //                 $c->updated_at ? strtotime($c->updated_at) : 0,
    //                 (int) ($c->priority == 1),
    //                 collect((array) $c)->filter(fn($v) => !is_null($v) && $v !== '')->count(),
    //                 -strtotime($c->created_at),
    //             ];
    //         })->first();

    //         $masterId = $masterContact->contact_id;
    //         $duplicateIds = $allContactIds->reject(fn($id) => $id == $masterId)->values();

    //         // ---------------------------------------------------------------
    //         // STEP 4: COMPANY MERGE
    //         //         Only operate on company_data rows where entry_type = 'main'
    //         // ---------------------------------------------------------------
    //         $allCompanyIds = $contacts->pluck('company_id')->unique()->filter()->values();

    //         $masterCompanyId = null;

    //         if ($allCompanyIds->isNotEmpty()) {
    //             // *** KEY CHANGE: only load companies with entry_type = 'main' ***
    //             $companies = DB::table('company_data')
    //                 ->whereIn('company_id', $allCompanyIds)
    //                 ->where('entry_type', 'main')
    //                 ->get();

    //             // If none of the linked companies have entry_type = 'main',
    //             // skip company merge entirely to avoid touching non-main records
    //             if ($companies->isNotEmpty()) {
    //                 $masterCompany = $companies->sortByDesc(function ($c) {
    //                     return [
    //                         $c->updated_at ? strtotime($c->updated_at) : 0,
    //                         !empty($c->company_name) ? 1 : 0,
    //                         collect((array) $c)->filter(fn($v) => !is_null($v) && $v !== '')->count(),
    //                         -strtotime($c->created_at),
    //                     ];
    //                 })->first();

    //                 $masterCompanyId = $masterCompany->company_id;

    //                 // Only reject duplicate IDs that are also 'main' entries
    //                 $dupCompanyIds = $companies
    //                     ->pluck('company_id')
    //                     ->reject(fn($id) => $id == $masterCompanyId)
    //                     ->values();

    //                 $fillableCompanyFields = [
    //                     'company_name',
    //                     'database_name',
    //                     'category',
    //                     'address',
    //                     'city',
    //                     'pincode',
    //                     'state',
    //                     'country',
    //                     'website',
    //                     'phone',
    //                     'gst_number',
    //                     'sales_person',
    //                     'travel_segments',
    //                     'meet_profiles',
    //                     'meet_regions',
    //                     'interested_states',
    //                     'branch_offices',
    //                     'total_staff',
    //                     'association_membership',
    //                     'last_comments',
    //                     'pin',
    //                 ];

    //                 $masterCompanyData = (array) $masterCompany;
    //                 $dupCompanies = $companies
    //                     ->whereIn('company_id', $dupCompanyIds->toArray())
    //                     ->sortByDesc(fn($c) => $c->updated_at ? strtotime($c->updated_at) : 0);

    //                 $companyUpdates = [];
    //                 foreach ($fillableCompanyFields as $field) {
    //                     if (empty($masterCompanyData[$field])) {
    //                         foreach ($dupCompanies as $dup) {
    //                             if (!empty($dup->$field)) {
    //                                 $companyUpdates[$field] = $dup->$field;
    //                                 break;
    //                             }
    //                         }
    //                     }
    //                 }

    //                 if (!empty($companyUpdates)) {
    //                     $companyUpdates['updated_at'] = now();
    //                     DB::table('company_data')
    //                         ->where('company_id', $masterCompanyId)
    //                         ->where('entry_type', 'main') // safety guard
    //                         ->update($companyUpdates);
    //                 }

    //                 if ($dupCompanyIds->isNotEmpty()) {
    //                     DB::table('contact')
    //                         ->whereIn('company_id', $dupCompanyIds->toArray())
    //                         ->update(['company_id' => $masterCompanyId]);

    //                     DB::table('company_sources')
    //                         ->whereIn('company_id', $dupCompanyIds->toArray())
    //                         ->update(['company_id' => $masterCompanyId]);

    //                     // De-dup company_sources after re-pointing
    //                     $sources = DB::table('company_sources')
    //                         ->where('company_id', $masterCompanyId)
    //                         ->orderBy('created_at', 'desc')
    //                         ->get();

    //                     $seenSources = [];
    //                     foreach ($sources as $src) {
    //                         $key = $src->source_id . '_' . $src->event_date;
    //                         if (in_array($key, $seenSources, true)) {
    //                             DB::table('company_sources')->where('id', $src->id)->delete();
    //                             continue;
    //                         }
    //                         $seenSources[] = $key;
    //                     }

    //                     // *** KEY CHANGE: only delete duplicate companies that are 'main' ***
    //                     DB::table('company_data')
    //                         ->whereIn('company_id', $dupCompanyIds->toArray())
    //                         ->where('entry_type', 'main')
    //                         ->delete();
    //                 }
    //             }
    //         }

    //         // ---------------------------------------------------------------
    //         // STEP 5: EMAIL MERGE
    //         // ---------------------------------------------------------------
    //         $allEmails = DB::table('contact_email')
    //             ->whereIn('contact_id', $allContactIds)
    //             ->orderByRaw('COALESCE(updated_at, created_at) DESC')
    //             ->get();

    //         if ($masterCompanyId) {
    //             $companyContactIds = DB::table('contact')
    //                 ->where('company_id', $masterCompanyId)
    //                 ->pluck('contact_id');

    //             $allContactIds = $allContactIds->merge($companyContactIds)->unique()->values();

    //             $allEmails = DB::table('contact_email')
    //                 ->whereIn('contact_id', $allContactIds)
    //                 ->get();
    //         }

    //         $seenEmails = [];
    //         $hasPrimary = false;

    //         $sortedEmails = $allEmails->sortByDesc(fn($r) => [$r->is_primary, $r->email_id]);

    //         foreach ($sortedEmails as $row) {
    //             $normalised = strtolower(trim($row->email));

    //             if (in_array($normalised, $seenEmails, true)) {
    //                 DB::table('contact_email')->where('email_id', $row->email_id)->delete();
    //                 continue;
    //             }

    //             $seenEmails[] = $normalised;

    //             if ((int) $row->contact_id !== (int) $masterId) {
    //                 DB::table('contact_email')
    //                     ->where('email_id', $row->email_id)
    //                     ->update(['contact_id' => $masterId]);
    //             }

    //             if ($row->is_primary) {
    //                 $hasPrimary = true;
    //             }
    //         }

    //         if (!$hasPrimary) {
    //             $first = DB::table('contact_email')
    //                 ->where('contact_id', $masterId)
    //                 ->orderBy('email_id', 'asc')
    //                 ->first();
    //             if ($first) {
    //                 DB::table('contact_email')
    //                     ->where('email_id', $first->email_id)
    //                     ->update(['is_primary' => 1]);
    //             }
    //         }

    //         // ---------------------------------------------------------------
    //         // STEP 6: MOBILE MERGE
    //         // ---------------------------------------------------------------
    //         $allMobileRows = DB::table('contact_mobile')
    //             ->whereIn('contact_id', $allContactIds)
    //             ->get();

    //         $seenMobiles = [];
    //         $hasPrimaryMobile = false;

    //         $sortedMobiles = $allMobileRows->sortByDesc(fn($r) => [$r->is_primary, $r->mobile_id]);

    //         foreach ($sortedMobiles as $row) {
    //             $normalised = preg_replace('/\D/', '', $row->mobile);

    //             if (empty($normalised)) {
    //                 DB::table('contact_mobile')->where('mobile_id', $row->mobile_id)->delete();
    //                 continue;
    //             }

    //             if (in_array($normalised, $seenMobiles, true)) {
    //                 DB::table('contact_mobile')->where('mobile_id', $row->mobile_id)->delete();
    //                 continue;
    //             }

    //             $seenMobiles[] = $normalised;

    //             if ((int) $row->contact_id !== (int) $masterId) {
    //                 DB::table('contact_mobile')
    //                     ->where('mobile_id', $row->mobile_id)
    //                     ->update(['contact_id' => $masterId]);
    //             }

    //             if ($row->is_primary) {
    //                 $hasPrimaryMobile = true;
    //             }
    //         }

    //         if (!$hasPrimaryMobile) {
    //             $first = DB::table('contact_mobile')
    //                 ->where('contact_id', $masterId)
    //                 ->orderBy('mobile_id', 'asc')
    //                 ->first();
    //             if ($first) {
    //                 DB::table('contact_mobile')
    //                     ->where('mobile_id', $first->mobile_id)
    //                     ->update(['is_primary' => 1]);
    //             }
    //         }

    //         // ---------------------------------------------------------------
    //         // STEP 7: CONTACT FIELD MERGE
    //         // ---------------------------------------------------------------
    //         $fillableContactFields = [
    //             'name',
    //             'designation',
    //             'image',
    //             'attendance_reason',
    //             'buyer_responsibility',
    //             'attended_past',
    //             'interest_forum',
    //             'business_card_path',
    //             'company_id',
    //         ];

    //         $masterData = (array) DB::table('contact')->where('contact_id', $masterId)->first();

    //         $dupContacts = DB::table('contact')
    //             ->whereIn('contact_id', $duplicateIds)
    //             ->orderByDesc('updated_at')
    //             ->get();

    //         $contactUpdates = [];
    //         foreach ($fillableContactFields as $field) {
    //             if (empty($masterData[$field])) {
    //                 foreach ($dupContacts as $dup) {
    //                     if (!empty($dup->$field)) {
    //                         $contactUpdates[$field] = $dup->$field;
    //                         break;
    //                     }
    //                 }
    //             }
    //         }

    //         if (empty($contactUpdates['company_id']) && empty($masterData['company_id']) && $masterCompanyId) {
    //             $contactUpdates['company_id'] = $masterCompanyId;
    //         }

    //         if (!empty($contactUpdates)) {
    //             $contactUpdates['updated_at'] = now();
    //             DB::table('contact')
    //                 ->where('contact_id', $masterId)
    //                 ->update($contactUpdates);
    //         }

    //         // ---------------------------------------------------------------
    //         // STEP 8: DELETE duplicate contacts
    //         // ---------------------------------------------------------------
    //         if ($duplicateIds->isNotEmpty()) {
    //             DB::table('contact')
    //                 ->whereIn('contact_id', $duplicateIds)
    //                 ->delete();
    //         }

    //         DB::commit();

    //         return DB::table('contact')
    //             ->where('contact_id', $masterId)
    //             ->first();

    //     } catch (\Throwable $e) {
    //         DB::rollBack();
    //         throw $e;
    //     }
    // }


    public function mergeOnUpdate2($mobile = null, $email = null)
    {
        if (!$mobile && !$email) {
            return null;
        }

        DB::beginTransaction();

        try {
            // ---------------------------------------------------------------
            // STEP 1: Gather ALL contact_ids matching the given email OR mobile
            // ---------------------------------------------------------------
            $contactIdsFromEmail = collect();
            $contactIdsFromMobile = collect();

            if ($email) {
                $contactIdsFromEmail = DB::table('contact_email')
                    ->where('email', $email)
                    ->pluck('contact_id');
            }

            if ($mobile) {
                $contactIdsFromMobile = DB::table('contact_mobile')
                    ->where('mobile', $mobile)
                    ->pluck('contact_id');
            }

            $allContactIds = $contactIdsFromEmail
                ->merge($contactIdsFromMobile)
                ->unique()
                ->filter()
                ->values();

            if ($allContactIds->isEmpty()) {
                DB::rollBack();
                return null;
            }

            // ---------------------------------------------------------------
            // STEP 2: Cross-expand — for each contact found, pull ALL their
            //         emails and mobiles, then find MORE contacts sharing those
            //         values. Repeat until no new contacts are discovered.
            // ---------------------------------------------------------------
            $resolved = collect();

            do {
                $newIds = $allContactIds->diff($resolved);
                if ($newIds->isEmpty())
                    break;

                $emails = DB::table('contact_email')
                    ->whereIn('contact_id', $newIds)
                    ->pluck('email')
                    ->unique();

                $mobiles = DB::table('contact_mobile')
                    ->whereIn('contact_id', $newIds)
                    ->pluck('mobile')
                    ->map(fn($m) => preg_replace('/\D/', '', $m))
                    ->unique()
                    ->filter();

                $moreFromEmails = DB::table('contact_email')
                    ->whereIn('email', $emails)
                    ->pluck('contact_id');

                $moreFromMobiles = collect();
                if ($mobiles->isNotEmpty()) {
                    $allMobileRows = DB::table('contact_mobile')->get();
                    $moreFromMobiles = $allMobileRows
                        ->filter(fn($r) => $mobiles->contains(preg_replace('/\D/', '', $r->mobile)))
                        ->pluck('contact_id');
                }

                $resolved = $resolved->merge($newIds)->unique()->values();

                $allContactIds = $allContactIds
                    ->merge($moreFromEmails)
                    ->merge($moreFromMobiles)
                    ->unique()
                    ->filter()
                    ->values();

            } while ($allContactIds->count() > $resolved->count());

            // ---------------------------------------------------------------
            // STEP 3: Load all contacts, pick MASTER contact
            //         Priority: latest updated_at, then priority=1,
            //         then most filled fields, then earliest created_at
            // ---------------------------------------------------------------
            $contacts = DB::table('contact')
                ->whereIn('contact_id', $allContactIds)
                ->get();

            $masterContact = $contacts->sortByDesc(function ($c) {
                return [
                    $c->updated_at ? strtotime($c->updated_at) : 0,
                    (int) ($c->priority == 1),
                    collect((array) $c)->filter(fn($v) => !is_null($v) && $v !== '')->count(),
                    -strtotime($c->created_at),
                ];
            })->first();

            $masterId = $masterContact->contact_id;
            $duplicateIds = $allContactIds->reject(fn($id) => $id == $masterId)->values();

            // ---------------------------------------------------------------
            // STEP 4: COMPANY MERGE
            //         Only operate on company_data rows where entry_type = 'main'
            //         Fill NULLs on master, re-point relations — NO deletes
            // ---------------------------------------------------------------
            $allCompanyIds = $contacts->pluck('company_id')->unique()->filter()->values();

            $masterCompanyId = null;

            if ($allCompanyIds->isNotEmpty()) {
                $companies = DB::table('company_data')
                    ->whereIn('company_id', $allCompanyIds)
                    ->where('entry_type', 'main')
                    ->get();

                if ($companies->isNotEmpty()) {
                    $masterCompany = $companies->sortByDesc(function ($c) {
                        return [
                            $c->updated_at ? strtotime($c->updated_at) : 0,
                            !empty($c->company_name) ? 1 : 0,
                            collect((array) $c)->filter(fn($v) => !is_null($v) && $v !== '')->count(),
                            -strtotime($c->created_at),
                        ];
                    })->first();

                    $masterCompanyId = $masterCompany->company_id;

                    $dupCompanyIds = $companies
                        ->pluck('company_id')
                        ->reject(fn($id) => $id == $masterCompanyId)
                        ->values();

                    $fillableCompanyFields = [
                        'company_name',
                        'database_name',
                        'category',
                        'address',
                        'city',
                        'pincode',
                        'state',
                        'country',
                        'website',
                        'phone',
                        'gst_number',
                        'sales_person',
                        'travel_segments',
                        'meet_profiles',
                        'meet_regions',
                        'interested_states',
                        'branch_offices',
                        'total_staff',
                        'association_membership',
                        'last_comments',
                        'pin',
                    ];

                    $masterCompanyData = (array) $masterCompany;
                    $dupCompanies = $companies
                        ->whereIn('company_id', $dupCompanyIds->toArray())
                        ->sortByDesc(fn($c) => $c->updated_at ? strtotime($c->updated_at) : 0);

                    $companyUpdates = [];
                    foreach ($fillableCompanyFields as $field) {
                        if (empty($masterCompanyData[$field])) {
                            foreach ($dupCompanies as $dup) {
                                if (!empty($dup->$field)) {
                                    $companyUpdates[$field] = $dup->$field;
                                    break;
                                }
                            }
                        }
                    }

                    if (!empty($companyUpdates)) {
                        $companyUpdates['updated_at'] = now();
                        DB::table('company_data')
                            ->where('company_id', $masterCompanyId)
                            ->where('entry_type', 'main')
                            ->update($companyUpdates);
                    }

                    if ($dupCompanyIds->isNotEmpty()) {
                        // Re-point all contacts to master company
                        DB::table('contact')
                            ->whereIn('company_id', $dupCompanyIds->toArray())
                            ->update(['company_id' => $masterCompanyId]);

                        // Re-point all sources to master company
                        DB::table('company_sources')
                            ->whereIn('company_id', $dupCompanyIds->toArray())
                            ->update(['company_id' => $masterCompanyId]);

                        // De-dup company_sources after re-pointing
                        $sources = DB::table('company_sources')
                            ->where('company_id', $masterCompanyId)
                            ->orderBy('created_at', 'desc')
                            ->get();

                        $seenSources = [];
                        foreach ($sources as $src) {
                            $key = $src->source_id . '_' . $src->event_date;
                            if (in_array($key, $seenSources, true)) {
                                DB::table('company_sources')->where('id', $src->id)->delete();
                                continue;
                            }
                            $seenSources[] = $key;
                        }

                        // NO DELETE — duplicate company_data rows are kept as-is
                    }
                }
            }

            // ---------------------------------------------------------------
            // STEP 5: EMAIL MERGE
            //         Re-assign all emails to master contact, deduplicate,
            //         ensure one primary.
            // ---------------------------------------------------------------
            $allEmails = DB::table('contact_email')
                ->whereIn('contact_id', $allContactIds)
                ->orderByRaw('COALESCE(updated_at, created_at) DESC')
                ->get();

            if ($masterCompanyId) {
                $companyContactIds = DB::table('contact')
                    ->where('company_id', $masterCompanyId)
                    ->pluck('contact_id');

                $allContactIds = $allContactIds->merge($companyContactIds)->unique()->values();

                $allEmails = DB::table('contact_email')
                    ->whereIn('contact_id', $allContactIds)
                    ->get();
            }

            $seenEmails = [];
            $hasPrimary = false;

            $sortedEmails = $allEmails->sortByDesc(fn($r) => [$r->is_primary, $r->email_id]);

            foreach ($sortedEmails as $row) {
                $normalised = strtolower(trim($row->email));

                if (in_array($normalised, $seenEmails, true)) {
                    DB::table('contact_email')->where('email_id', $row->email_id)->delete();
                    continue;
                }

                $seenEmails[] = $normalised;

                if ((int) $row->contact_id !== (int) $masterId) {
                    DB::table('contact_email')
                        ->where('email_id', $row->email_id)
                        ->update(['contact_id' => $masterId]);
                }

                if ($row->is_primary) {
                    $hasPrimary = true;
                }
            }

            if (!$hasPrimary) {
                $first = DB::table('contact_email')
                    ->where('contact_id', $masterId)
                    ->orderBy('email_id', 'asc')
                    ->first();
                if ($first) {
                    DB::table('contact_email')
                        ->where('email_id', $first->email_id)
                        ->update(['is_primary' => 1]);
                }
            }

            // ---------------------------------------------------------------
            // STEP 6: MOBILE MERGE
            //         Re-assign all mobiles to master contact, deduplicate,
            //         ensure one primary.
            // ---------------------------------------------------------------
            $allMobileRows = DB::table('contact_mobile')
                ->whereIn('contact_id', $allContactIds)
                ->get();

            $seenMobiles = [];
            $hasPrimaryMobile = false;

            $sortedMobiles = $allMobileRows->sortByDesc(fn($r) => [$r->is_primary, $r->mobile_id]);

            foreach ($sortedMobiles as $row) {
                $normalised = preg_replace('/\D/', '', $row->mobile);

                if (empty($normalised)) {
                    DB::table('contact_mobile')->where('mobile_id', $row->mobile_id)->delete();
                    continue;
                }

                if (in_array($normalised, $seenMobiles, true)) {
                    DB::table('contact_mobile')->where('mobile_id', $row->mobile_id)->delete();
                    continue;
                }

                $seenMobiles[] = $normalised;

                if ((int) $row->contact_id !== (int) $masterId) {
                    DB::table('contact_mobile')
                        ->where('mobile_id', $row->mobile_id)
                        ->update(['contact_id' => $masterId]);
                }

                if ($row->is_primary) {
                    $hasPrimaryMobile = true;
                }
            }

            if (!$hasPrimaryMobile) {
                $first = DB::table('contact_mobile')
                    ->where('contact_id', $masterId)
                    ->orderBy('mobile_id', 'asc')
                    ->first();
                if ($first) {
                    DB::table('contact_mobile')
                        ->where('mobile_id', $first->mobile_id)
                        ->update(['is_primary' => 1]);
                }
            }

            // ---------------------------------------------------------------
            // STEP 7: CONTACT FIELD MERGE
            //         Fill NULLs on master from duplicates (latest updated first)
            //         NO deletes — duplicate contacts are kept as-is
            // ---------------------------------------------------------------
            $fillableContactFields = [
                'name',
                'designation',
                'image',
                'attendance_reason',
                'buyer_responsibility',
                'attended_past',
                'interest_forum',
                'business_card_path',
                'company_id',
            ];

            $masterData = (array) DB::table('contact')->where('contact_id', $masterId)->first();

            $dupContacts = DB::table('contact')
                ->whereIn('contact_id', $duplicateIds)
                ->orderByDesc('updated_at')
                ->get();

            $contactUpdates = [];
            foreach ($fillableContactFields as $field) {
                if (empty($masterData[$field])) {
                    foreach ($dupContacts as $dup) {
                        if (!empty($dup->$field)) {
                            $contactUpdates[$field] = $dup->$field;
                            break;
                        }
                    }
                }
            }

            if (empty($contactUpdates['company_id']) && empty($masterData['company_id']) && $masterCompanyId) {
                $contactUpdates['company_id'] = $masterCompanyId;
            }

            if (!empty($contactUpdates)) {
                $contactUpdates['updated_at'] = now();
                DB::table('contact')
                    ->where('contact_id', $masterId)
                    ->update($contactUpdates);
            }

            // STEP 8: SKIPPED — no deletes, all duplicate contacts are kept

            DB::commit();

            return DB::table('contact')
                ->where('contact_id', $masterId)
                ->first();

        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }
    public function getLatestContactId($mobile = null, $email = null)
    {

        $this->mergeOnUpdate2($mobile, $email);
        // [$id, $is_match] = $this->mergeOnUpdate2($mobile, $email);
        // if ($is_match) {
        //     return $id;
        // }
        // dd((;))
        // $this->mergeOnUpdate2($mobile, $email);
        // If both are null, we can't match anything

        // dd('merger companle     done');
        if (!$mobile && !$email) {
            return null;
        }


        $query = DB::table('contact as c')
            ->leftJoin('contact_mobile as cm', 'c.contact_id', '=', 'cm.contact_id')
            ->leftJoin('contact_email as ce', 'c.contact_id', '=', 'ce.contact_id')
            // Join company_data to ensure the contact is actually linked to a valid company
            ->join('company_data as cd', 'c.company_id', '=', 'cd.company_id');

        $query->where(function ($q) use ($mobile, $email) {
            if ($mobile) {
                $q->where('cm.mobile', $mobile);
            }

            // Using orWhere inside this closure keeps the logic grouped:
            // (mobile = 'X' OR email = 'Y')
            if ($email) {
                $q->orWhere('ce.email', $email);
            }
        });

        // Order by created_at to get the most recent entry
        // and return just the contact_id value
        return $query->orderByDesc('c.created_at')
            ->select('c.contact_id')
            ->value('c.contact_id');
    }

    //     public function getlatestcontactid($mobile = null, $email = null)
//     {


    // // final all the matching companydata and contact data linked then merge them

    //         $query = DB::table('contact as c')
//             ->leftJoin('contact_mobile as cm', 'c.contact_id', '=', 'cm.contact_id')
//             ->leftJoin('contact_email as ce', 'c.contact_id', '=', 'ce.contact_id');

    //         if ($mobile) {
//             $query->where('cm.mobile', $mobile);
//         }

    //         if ($email) {
//             $query->orWhere('ce.email', $email);
//         }

    //         return $query->orderByDesc('c.created_at')
//             ->value('c.contact_id');
//     }
    public function getlatestcontactidbymobile($mobileNumber)
    {
        // echo "this is checking the numer and returnign COntact id";
        $contactId = DB::table('contact as c')
            ->join('contact_mobile as cm', 'c.contact_id', '=', 'cm.contact_id')
            ->where('cm.mobile', $mobileNumber)
            ->orderBy('c.created_at', 'desc')
            ->value('c.contact_id');

        return $contactId;
    }
    public function getLatestCompanyDatabymobile($mobileNumber, $fullquery = null, $city = null, $returntype = null)
    {
        $query = DB::table('contact_mobile')
            ->join('contact', 'contact_mobile.contact_id', '=', 'contact.contact_id')
            ->join('company_data', 'contact.company_id', '=', 'company_data.company_id')
            ->where('company_data.entry_type', 'main')
            ->where('contact_mobile.mobile', $mobileNumber);

        // Select fields based on fullquery flag
        if ($fullquery) {
            $query->select(
                'contact.*',
                'company_data.*',
                'contact_mobile.mobile'
            );
        } else {
            $query->select(
                'contact.*'
            );
        }

        if ($city && $city != "null") {
            $query->where('company_data.city', $city);
        }

        $data = $query->orderBy('contact.updated_at', 'desc')->first();

        // dd($data);

        if ($data) {

            if ($returntype == Null || $returntype == "false") {
                return response()->json([
                    'status' => true,
                    'message' => 'Data found',
                    'data' => $data
                ]);
            } else {
                return $data->contact_id;
                return response()->json([
                    'status' => true,
                    'message' => 'Data found',
                    'data' => $data->contact_id
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'No data found',
                'data' => null
            ]);
        }
    }

    public function getDetails($value)
    {

        dd($value);
        // 1. Try mobile
        $mobileRow = DB::table('contact_mobile')
            ->where('mobile', $value)
            ->first();

        $contact = null;

        // 2. Try email
        if (!$mobileRow) {
            $emailRow = DB::table('contact_email')
                ->where('email', $value)
                ->first();

            if ($emailRow) {
                $mobileRow = DB::table('contact_mobile')
                    ->where('contact_id', $emailRow->contact_id)
                    ->first();
            }
        }

        // 3. Try contact name
        if (!$mobileRow) {
            $contact = DB::table('contact')
                ->where('name', 'like', "%$value%")
                ->first();

            if ($contact) {
                $mobileRow = DB::table('contact_mobile')
                    ->where('contact_id', $contact->contact_id)
                    ->first();
            }
        }

        // 4. Try company name
        if (!$mobileRow) {
            $company = DB::table('company_data')
                ->where('company_name', 'like', "%$value%")
                ->first();

            if ($company) {
                $contact = DB::table('contact')
                    ->where('company_id', $company->company_id)
                    ->first();

                if ($contact) {
                    $mobileRow = DB::table('contact_mobile')
                        ->where('contact_id', $contact->contact_id)
                        ->first();
                }
            }
        }

        // ❌ nothing found
        if (!$mobileRow) {
            return response()->json([
                'mobile' => null,
                'contact' => null,
                'company' => null,
                'email' => null,
                'othercontacts' => []
            ]);
        }

        // resolve full data
        $contact = DB::table('contact')
            ->where('contact_id', $mobileRow->contact_id)
            ->first();

        $email = DB::table('contact_email')
            ->where('contact_id', $mobileRow->contact_id)
            ->first();

        $company = DB::table('company_data')
            ->where('company_id', $contact->company_id)
            ->first();

        $othercontacts = DB::table('contact_mobile')
            ->where('contact_id', $mobileRow->contact_id)
            ->get();

        return response()->json([
            'mobile' => $mobileRow,
            'contact' => $contact,
            'company' => $company,
            'email' => $email,
            'othercontacts' => $othercontacts
        ]);
    }
    public function updatedetails(request $request)
    {
        // dd($request->all());

        $leadcolumns = Schema::getColumnListing('leads');

        // dd($leadcolumns);

        return view('booking.step3', compact('leadcolumns'));


    }






}