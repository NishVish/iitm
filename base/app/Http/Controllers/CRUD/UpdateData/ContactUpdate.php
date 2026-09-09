<?php

namespace App\Http\Controllers\CRUD\UpdateData;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

trait ContactUpdate
{
    /*
    |--------------------------------------------------------------------------
    | Update All Contacts
    |--------------------------------------------------------------------------
    */
    public function updateAllContacts(Request $request)
    {
        $request->validate([
            'company_id' => ['required', 'string', 'max:50'],

            'bookingid' => ['nullable', 'string', 'max:50'],

            'stall_id' => ['nullable', 'string', 'max:50'],

            'contacts' => ['required', 'array'],

            'contacts.*.contact_id' => ['nullable', 'integer'],
            'contacts.*.name' => ['nullable', 'string', 'max:255'],
            'contacts.*.designation' => ['nullable', 'string', 'max:100'],
            'contacts.*.email' => ['nullable', 'email', 'max:100'],
            'contacts.*.mobile' => ['nullable', 'string', 'max:50'],

            'contacts.*.billing_contact' => ['nullable', 'boolean'],
            'contacts.*.delegate' => ['nullable', 'boolean'],
        ]);

        DB::beginTransaction();

        try {

            $companyId = $request->input('company_id');

            // Your POST field is bookingid
            $bookingId = $request->input('bookingid');

            $stallId = $request->input('stall_id');

            $billingContactId = null;


            /*
            |--------------------------------------------------------------------------
            | Remove Existing Delegates
            |--------------------------------------------------------------------------
            */

            if (!empty($stallId)) {

                DB::table('stall_delegates')
                    ->where('stall_id', $stallId)
                    ->delete();
            }


            /*
            |--------------------------------------------------------------------------
            | Save Contacts
            |--------------------------------------------------------------------------
            */

            foreach ($request->input('contacts', []) as $contact) {

                $isBilling = !empty($contact['billing_contact']);

                $isDelegate = !empty($contact['delegate']);


                /*
                |--------------------------------------------------------------------------
                | Save / Update Contact
                |--------------------------------------------------------------------------
                */

                $contactId = $this->saveContact([

                    'contact_id' => $contact['contact_id'] ?? null,

                    'company_id' => $companyId,

                    'name' => $contact['name'] ?? null,

                    'designation' => $contact['designation'] ?? null,

                    'email' => $contact['email'] ?? null,

                    'mobile' => $contact['mobile'] ?? null,

                    'billing_contact' => $isBilling ? 1 : 0,
                ]);


                /*
                |--------------------------------------------------------------------------
                | Billing Contact
                |--------------------------------------------------------------------------
                */

                if ($isBilling && !empty($contactId)) {

                    $billingContactId = $contactId;
                }


                /*
                |--------------------------------------------------------------------------
                | Stall Delegate
                |--------------------------------------------------------------------------
                */

                if (
                    $isDelegate &&
                    !empty($stallId) &&
                    !empty($contactId)
                ) {

                    DB::table('stall_delegates')
                        ->insert([
                            'stall_id' => $stallId,
                            'contact_id' => $contactId,
                            'billing_contact' => 0,
                            'stall_delegate' => 1,
                        ]);
                }
            }


            /*
            |--------------------------------------------------------------------------
            | Update Booking Billing Contact
            |--------------------------------------------------------------------------
            */

            if (!empty($bookingId)) {

                DB::table('booking_record')
                    ->where('booking_id', $bookingId)
                    ->update([
                        'billing_contact_id' => $billingContactId,
                        'updated_at' => now(),
                    ]);


                /*
                |--------------------------------------------------------------------------
                | Get Updated Booking Record
                |--------------------------------------------------------------------------
                */

                $booking = DB::table('booking_record')
                    ->where('booking_id', $bookingId)
                    ->first();


                /*
                |--------------------------------------------------------------------------
                | DEBUG
                |--------------------------------------------------------------------------
                */

                DB::commit();

                // dd($booking);
            }


            DB::commit();

            return redirect()
                ->back()
                ->with('success', 'Contacts updated successfully.');

        } catch (\Throwable $e) {

            DB::rollBack();

            dd([
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Update Single Contact
    |--------------------------------------------------------------------------
    */
    public function updateContact(Request $request)
    {
        $request->validate([
            'company_id' => ['required', 'string', 'max:50'],

            'contacts' => ['required', 'array'],

            'contacts.*.contact_id' => ['nullable', 'integer'],
            'contacts.*.name' => ['nullable', 'string', 'max:255'],
            'contacts.*.designation' => ['nullable', 'string', 'max:100'],
            'contacts.*.email' => ['nullable', 'email', 'max:100'],
            'contacts.*.mobile' => ['nullable', 'string', 'max:50'],
            'contacts.*.billing_contact' => ['nullable', 'boolean'],
            'contacts.*.delegate' => ['nullable', 'boolean'],
        ]);

        DB::beginTransaction();

        try {

            $companyId = $request->input('company_id');

            foreach ($request->input('contacts', []) as $contact) {

                $this->saveContact([

                    'contact_id' => $contact['contact_id'] ?? null,

                    'company_id' => $companyId,

                    'name' => $contact['name'] ?? null,

                    'designation' => $contact['designation'] ?? null,

                    'email' => $contact['email'] ?? null,

                    'mobile' => $contact['mobile'] ?? null,

                    'billing_contact' => $contact['billing_contact'] ?? 0,
                ]);
            }

            DB::commit();

            return redirect()
                ->back()
                ->with('success', 'Contact updated successfully.');

        } catch (\Throwable $e) {

            DB::rollBack();

            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Get Delegates By Stall
    |--------------------------------------------------------------------------
    */
    public function getDeleagte($stallid)
    {
        return DB::table('stall_delegates')
            ->where('stall_delegates.stall_id', $stallid)

            ->join(
                'contact',
                'stall_delegates.contact_id',
                '=',
                'contact.contact_id'
            )

            ->leftJoin(
                'contact_email',
                'contact.contact_id',
                '=',
                'contact_email.contact_id'
            )

            ->leftJoin(
                'contact_mobile',
                'contact.contact_id',
                '=',
                'contact_mobile.contact_id'
            )

            ->where('stall_delegates.stall_delegate', 1)

            ->select(
                'contact.contact_id',
                'contact.company_id',
                'contact.name',
                'contact.designation',
                'contact.billing_contact',
                'contact_email.email',
                'contact_mobile.mobile',
                'stall_delegates.stall_id',
                'stall_delegates.stall_delegate'
            )

            ->get();
    }


    /*
    |--------------------------------------------------------------------------
    | Save / Update Contact
    |--------------------------------------------------------------------------
    */
    private function saveContact(array $data)
    {
        $contactId = $data['contact_id'] ?? null;

        $companyId = $data['company_id'] ?? null;

        $name = $data['name'] ?? null;

        $designation = $data['designation'] ?? null;

        $emailAddress = $data['email'] ?? null;

        $mobileNumber = $data['mobile'] ?? null;

        $billingContact = !empty($data['billing_contact']) ? 1 : 0;


        /*
        |--------------------------------------------------------------------------
        | Contact
        |--------------------------------------------------------------------------
        */

        if (!empty($contactId)) {

            DB::table('contact')
                ->where('contact_id', $contactId)
                ->update([
                    'company_id' => $companyId,
                    'name' => $name,
                    'designation' => $designation,
                    'billing_contact' => $billingContact,
                    'updated_at' => now(),
                ]);

        } else {

            $contactId = DB::table('contact')
                ->insertGetId([
                    'company_id' => $companyId,
                    'name' => $name,
                    'designation' => $designation,
                    'billing_contact' => $billingContact,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Email
        |--------------------------------------------------------------------------
        */



        $email = DB::table('contact_email')
            ->where('contact_id', $contactId)
            ->where('is_primary', 1)
            ->first();

        if ($email) {

            DB::table('contact_email')
                ->where('email_id', $email->email_id)
                ->update([
                    'email' => $emailAddress,
                    'updated_at' => now(),
                ]);

        } elseif (!empty($emailAddress)) {

            DB::table('contact_email')
                ->insert([
                    'contact_id' => $contactId,
                    'email' => $emailAddress,
                    'is_primary' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Mobile
        |--------------------------------------------------------------------------
        */

        $mobile = DB::table('contact_mobile')
            ->where('contact_id', $contactId)
            ->where('is_primary', 1)
            ->first();

        if ($mobile) {

            DB::table('contact_mobile')
                ->where('mobile_id', $mobile->mobile_id)
                ->update([
                    'mobile' => $mobileNumber,
                    'updated_at' => now(),
                ]);

        } elseif (!empty($mobileNumber)) {

            DB::table('contact_mobile')
                ->insert([
                    'contact_id' => $contactId,
                    'mobile' => $mobileNumber,
                    'is_primary' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Return Contact ID
        |--------------------------------------------------------------------------
        */

        return $contactId;
    }
}
