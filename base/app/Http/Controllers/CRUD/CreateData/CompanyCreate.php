<?php

namespace App\Http\Controllers\CRUD\CreateData;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Http\Controllers\CRUD\UpdateData\UpdateDataController;
trait CompanyCreate
{
    /*
    |--------------------------------------------------------------------------
    | CREATE COMPANY
    |--------------------------------------------------------------------------
    */

    public function createCompany(Request $request)
    {
        // dd(request()->all());
        $sourceCompanyId = $request->input('source_company_id');

        if (!empty($sourceCompanyId)) {

            $updatecontroller = new UpdateDataController();
            /*
            |--------------------------------------------------------------------------
            | UPDATE COMPANY
            |--------------------------------------------------------------------------
            */

            $companyRequest = new Request([
                'company_id' => $sourceCompanyId,
                'company_name' => $request->input('company_name'),
                'category' => $request->input('category'),
                'address' => $request->input('address'),
                'pincode' => $request->input('pincode'),
                'city' => $request->input('city'),
                'state' => $request->input('state'),
                'country' => $request->input('country'),
                'website' => $request->input('website'),
                'phone' => $request->input('phone'),
                'use' => 'internal'
            ]);

            $updatecontroller->updateCompany($companyRequest);


            /*
            |--------------------------------------------------------------------------
            | UPDATE CONTACTS
            |--------------------------------------------------------------------------
            */

            $contacts = $request->input('contacts', []);
            // dd($contacts);

            if (!empty($contacts)) {

                $contactsRequest = new Request([
                    'company_id' => $sourceCompanyId,
                    'contacts' => $contacts,
                    'use' => 'internal',
                    'bookingid' => $request->input('bookingid')


                ]);

                $updatecontroller->updateAllContacts($contactsRequest);
            }


            /*
            |--------------------------------------------------------------------------
            | RETURN BACK
            |--------------------------------------------------------------------------
            */

            return back();
        }
        $validated = $this->validateCompanyRequest($request);

        try {

            $companyId = DB::transaction(function () use ($validated) {

                // Generate new company ID
                $companyId = $this->generateCompanyId();

                // Insert company
                $this->insertCompany(
                    $validated,
                    $companyId
                );

                // Insert contacts
                $this->insertContacts(
                    $validated['contacts'],
                    $companyId
                );

                return $companyId;
            });

            // $this->companyCreateSuccess($companyId);
            return redirect()->to(url('sales/company_details/' . $companyId));

        } catch (\Throwable $e) {

            return $this->companyCreateError(
                $request,
                $e
            );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | VALIDATE COMPANY REQUEST
    |--------------------------------------------------------------------------
    */

    protected function validateCompanyRequest(Request $request)
    {
        return $request->validate([

            /*
            |--------------------------------------------------------------------------
            | Company
            |--------------------------------------------------------------------------
            */

            'company_name' => [
                'required',
                'string',
                'max:255',
            ],

            'category' => [
                'nullable',
                'string',
                'max:100',
            ],

            'address' => [
                'nullable',
                'string',
            ],

            'pincode' => [
                'nullable',
                'string',
                'max:20',
            ],

            'city' => [
                'nullable',
                'string',
                'max:100',
            ],

            'state' => [
                'nullable',
                'string',
                'max:100',
            ],

            /*
            |--------------------------------------------------------------------------
            | Contacts
            |--------------------------------------------------------------------------
            */

            'contacts' => [
                'required',
                'array',
                'min:1',
            ],

            'contacts.*.name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'contacts.*.designation' => [
                'nullable',
                'string',
                'max:100',
            ],

            'contacts.*.mobile' => [
                'nullable',
                'string',
                'max:50',
            ],

            'contacts.*.email' => [
                'nullable',
                'email',
                'max:100',
            ],
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | GENERATE UNIQUE COMPANY ID
    |--------------------------------------------------------------------------
    */

    protected function generateCompanyId()
    {
        do {

            $companyId = 'COMP-' . strtoupper(
                Str::random(10)
            );

        } while (
            DB::table('company_data')
                ->where('company_id', $companyId)
                ->exists()
        );

        return $companyId;
    }


    /*
    |--------------------------------------------------------------------------
    | INSERT COMPANY
    |--------------------------------------------------------------------------
    */

    protected function insertCompany(
        array $company,
        string $companyId
    ) {
        return DB::table('company_data')->insert([

            'company_id' => $companyId,

            'company_name' => $company['company_name'],

            'category' => $company['category'] ?? null,

            'address' => $company['address'] ?? null,

            'city' => $company['city'] ?? null,

            'pincode' => $company['pincode'] ?? null,

            'state' => $company['state'] ?? null,

            /*
            |--------------------------------------------------------------------------
            | Default Values
            |--------------------------------------------------------------------------
            */

            'outbound' => 0,

            'active_inactive' => 'active',

            'session' => 0,

            'cross_validation' => 0,

            'entry_type' => 'main',

            'created_at' => now(),
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | INSERT CONTACTS
    |--------------------------------------------------------------------------
    */

    protected function insertContacts(
        array $contacts,
        string $companyId
    ) {
        foreach ($contacts as $index => $contact) {

            // Insert contact
            $contactId = $this->insertContact(
                $contact,
                $companyId,
                $index
            );

            // Insert mobile
            $this->insertContactMobile(
                $contact,
                $contactId
            );

            // Insert email
            $this->insertContactEmail(
                $contact,
                $contactId
            );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | INSERT SINGLE CONTACT
    |--------------------------------------------------------------------------
    */

    protected function insertContact(
        array $contact,
        string $companyId,
        int $index
    ) {
        return DB::table('contact')->insertGetId([

            'company_id' => $companyId,

            'priority' => $index + 1,

            'name' => $contact['name'] ?? null,

            'designation' => $contact['designation'] ?? null,

            'created_at' => now(),

        ], 'contact_id');
    }


    /*
    |--------------------------------------------------------------------------
    | INSERT CONTACT MOBILE
    |--------------------------------------------------------------------------
    */

    protected function insertContactMobile(
        array $contact,
        int $contactId
    ) {
        if (empty($contact['mobile'])) {
            return null;
        }

        return DB::table('contact_mobile')->insert([

            'contact_id' => $contactId,

            'mobile' => $contact['mobile'],

            'is_primary' => 1,

            'created_at' => now(),

        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | INSERT CONTACT EMAIL
    |--------------------------------------------------------------------------
    */

    protected function insertContactEmail(
        array $contact,
        int $contactId
    ) {
        if (empty($contact['email'])) {
            return null;
        }

        return DB::table('contact_email')->insert([

            'contact_id' => $contactId,

            'email' => $contact['email'],

            'is_primary' => 1,

            'created_at' => now(),

        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | DUPLICATE COMPANY AS LEAD
    |--------------------------------------------------------------------------
    |
    | Existing company:
    |
    |     COMP-ABC123
    |     entry_type = main
    |
    | New company:
    |
    |     COMP-XYZ789
    |     entry_type = lead
    |
    | All contacts, mobiles and emails are copied.
    |
    */

    public function duplicateCompanyAsLead(
        string $companyId
    ) {
        try {

            $newCompanyId = DB::transaction(function () use ($companyId) {

                /*
                |--------------------------------------------------------------------------
                | Get Existing Company
                |--------------------------------------------------------------------------
                */

                $existingCompany = DB::table('company_data')
                    ->where('company_id', $companyId)
                    ->first();

                if (!$existingCompany) {

                    throw new \Exception(
                        'Company not found: ' . $companyId
                    );
                }


                /*
                |--------------------------------------------------------------------------
                | Generate New Company ID
                |--------------------------------------------------------------------------
                */

                $newCompanyId = $this->generateCompanyId();


                /*
                |--------------------------------------------------------------------------
                | Duplicate Company
                |--------------------------------------------------------------------------
                */

                $this->duplicateCompanyData(
                    $existingCompany,
                    $newCompanyId
                );


                /*
                |--------------------------------------------------------------------------
                | Duplicate Contacts
                |--------------------------------------------------------------------------
                */

                $this->duplicateCompanyContacts(
                    $companyId,
                    $newCompanyId
                );


                return $newCompanyId;
            });


            return $newCompanyId;

        } catch (\Throwable $e) {

            Log::error(
                'Company duplication failed',
                [
                    'old_company_id' => $companyId,
                    'error' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                ]
            );

            throw $e;
        }
    }


    /*
    |--------------------------------------------------------------------------
    | DUPLICATE COMPANY DATA
    |--------------------------------------------------------------------------
    */

    protected function duplicateCompanyData(
        object $existingCompany,
        string $newCompanyId
    ) {
        /*
        |--------------------------------------------------------------------------
        | Convert database object to array
        |--------------------------------------------------------------------------
        */

        $companyData = (array) $existingCompany;


        /*
        |--------------------------------------------------------------------------
        | Remove Auto Increment ID
        |--------------------------------------------------------------------------
        */

        unset($companyData['id']);


        /*
        |--------------------------------------------------------------------------
        | Set New Company ID
        |--------------------------------------------------------------------------
        */

        $companyData['company_id'] = $newCompanyId;


        /*
        |--------------------------------------------------------------------------
        | Change Entry Type
        |--------------------------------------------------------------------------
        */

        $companyData['entry_type'] = 'lead';


        /*
        |--------------------------------------------------------------------------
        | Reset Created / Updated
        |--------------------------------------------------------------------------
        */

        $companyData['created_at'] = now();

        $companyData['updated_at'] = null;


        /*
        |--------------------------------------------------------------------------
        | Insert Duplicate
        |--------------------------------------------------------------------------
        */

        return DB::table('company_data')
            ->insert($companyData);
    }


    /*
    |--------------------------------------------------------------------------
    | DUPLICATE COMPANY CONTACTS
    |--------------------------------------------------------------------------
    */

    protected function duplicateCompanyContacts(
        string $oldCompanyId,
        string $newCompanyId
    ) {
        $contacts = DB::table('contact')
            ->where('company_id', $oldCompanyId)
            ->orderBy('priority')
            ->get();


        foreach ($contacts as $contact) {

            /*
            |--------------------------------------------------------------------------
            | Duplicate Contact
            |--------------------------------------------------------------------------
            */

            $newContactId = $this->duplicateContact(
                $contact,
                $newCompanyId
            );


            /*
            |--------------------------------------------------------------------------
            | Duplicate Mobiles
            |--------------------------------------------------------------------------
            */

            $this->duplicateContactMobiles(
                $contact->contact_id,
                $newContactId
            );


            /*
            |--------------------------------------------------------------------------
            | Duplicate Emails
            |--------------------------------------------------------------------------
            */

            $this->duplicateContactEmails(
                $contact->contact_id,
                $newContactId
            );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | DUPLICATE SINGLE CONTACT
    |--------------------------------------------------------------------------
    */

    protected function duplicateContact(
        object $contact,
        string $newCompanyId
    ) {
        $contactData = (array) $contact;


        /*
        |--------------------------------------------------------------------------
        | Remove Auto Increment ID
        |--------------------------------------------------------------------------
        */

        unset($contactData['contact_id']);


        /*
        |--------------------------------------------------------------------------
        | Assign New Company ID
        |--------------------------------------------------------------------------
        */

        $contactData['company_id'] = $newCompanyId;


        /*
        |--------------------------------------------------------------------------
        | Reset Timestamps
        |--------------------------------------------------------------------------
        */

        $contactData['created_at'] = now();

        $contactData['updated_at'] = null;


        /*
        |--------------------------------------------------------------------------
        | Insert
        |--------------------------------------------------------------------------
        */

        return DB::table('contact')
            ->insertGetId(
                $contactData,
                'contact_id'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | DUPLICATE CONTACT MOBILES
    |--------------------------------------------------------------------------
    */

    protected function duplicateContactMobiles(
        int $oldContactId,
        int $newContactId
    ) {
        $mobiles = DB::table('contact_mobile')
            ->where('contact_id', $oldContactId)
            ->get();


        foreach ($mobiles as $mobile) {

            $mobileData = (array) $mobile;


            /*
            |--------------------------------------------------------------------------
            | Remove Auto Increment ID
            |--------------------------------------------------------------------------
            */

            unset($mobileData['mobile_id']);


            /*
            |--------------------------------------------------------------------------
            | Assign New Contact ID
            |--------------------------------------------------------------------------
            */

            $mobileData['contact_id'] = $newContactId;


            /*
            |--------------------------------------------------------------------------
            | Reset Timestamp
            |--------------------------------------------------------------------------
            */

            $mobileData['created_at'] = now();

            $mobileData['updated_at'] = null;


            /*
            |--------------------------------------------------------------------------
            | Insert
            |--------------------------------------------------------------------------
            */

            DB::table('contact_mobile')
                ->insert($mobileData);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | DUPLICATE CONTACT EMAILS
    |--------------------------------------------------------------------------
    */

    protected function duplicateContactEmails(
        int $oldContactId,
        int $newContactId
    ) {
        $emails = DB::table('contact_email')
            ->where('contact_id', $oldContactId)
            ->get();


        foreach ($emails as $email) {

            $emailData = (array) $email;


            /*
            |--------------------------------------------------------------------------
            | Remove Auto Increment ID
            |--------------------------------------------------------------------------
            */

            unset($emailData['email_id']);


            /*
            |--------------------------------------------------------------------------
            | Assign New Contact ID
            |--------------------------------------------------------------------------
            */

            $emailData['contact_id'] = $newContactId;


            /*
            |--------------------------------------------------------------------------
            | Reset Timestamp
            |--------------------------------------------------------------------------
            */

            $emailData['created_at'] = now();

            $emailData['updated_at'] = null;


            /*
            |--------------------------------------------------------------------------
            | Insert
            |--------------------------------------------------------------------------
            */

            DB::table('contact_email')
                ->insert($emailData);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | SUCCESS RESPONSE
    |--------------------------------------------------------------------------
    */

    protected function companyCreateSuccess(
        string $companyId
    ) {
        return redirect()
            ->back()
            ->with(
                'success',
                'Company created successfully. Company ID: ' . $companyId
            );
    }


    /*
    |--------------------------------------------------------------------------
    | ERROR RESPONSE
    |--------------------------------------------------------------------------
    */

    protected function companyCreateError(
        Request $request,
        \Throwable $e
    ) {
        Log::error(
            'Company creation failed',
            [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]
        );

        return redirect()
            ->back()
            ->withInput()
            ->with(
                'error',
                'Unable to create company. Please try again.'
            );
    }
}
