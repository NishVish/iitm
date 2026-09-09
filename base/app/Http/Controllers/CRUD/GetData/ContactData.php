<?php

namespace App\Http\Controllers\CRUD\GetData;
use Illuminate\Support\Facades\DB;

trait ContactData
{
    public function billingcontact($id)
    {
        return DB::table('contact')
            ->where('contact.contact_id', $id)
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
            ->select(
                'contact.contact_id',
                'contact.company_id',
                'contact.name',
                'contact.designation',
                'contact.billing_contact',
                'contact_email.email',
                'contact_mobile.mobile'
            )
            ->first();
    }

    public function billingcontactbybillingid($bookingid)
    {
        $contact = DB::table('booking_record as br')
            ->leftJoin(
                'contact as c',
                'br.billing_contact_id',
                '=',
                'c.contact_id'
            )
            ->leftJoin(
                'contact_email as ce',
                function ($join) {
                    $join->on(
                        'c.contact_id',
                        '=',
                        'ce.contact_id'
                    )->where('ce.is_primary', 1);
                }
            )
            ->leftJoin(
                'contact_mobile as cm',
                function ($join) {
                    $join->on(
                        'c.contact_id',
                        '=',
                        'cm.contact_id'
                    )->where('cm.is_primary', 1);
                }
            )
            ->where('br.booking_id', $bookingid)
            ->select(
                'br.booking_id',
                'br.billing_contact_id',

                'c.contact_id',
                'c.company_id',
                'c.name',
                'c.designation',
                'c.image',

                'ce.email as contact_email',
                'cm.mobile as contact_mobile'
            )
            ->first();

        return $contact;
    }

    public function contactdata($companyid)
    {
        /*
        |--------------------------------------------------------------------------
        | Find contacts for company
        |--------------------------------------------------------------------------
        */

        $contact = DB::table('contact')
            ->where('contact.company_id', $companyid)

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

            ->select(
                'contact.contact_id',
                'contact.company_id',
                'contact.name',
                'contact.designation',
                'contact.billing_contact',
                'contact_email.email',
                'contact_mobile.mobile'
            )

            ->get();

        /*
        |--------------------------------------------------------------------------
        | Delete completely empty contacts
        |--------------------------------------------------------------------------
        |
        | If name, designation, email and mobile are all empty,
        | delete the contact and its related email/mobile records.
        |
        */

        foreach ($contact as $contactData) {

            $name = trim((string) ($contactData->name ?? ''));
            $designation = trim((string) ($contactData->designation ?? ''));
            $email = trim((string) ($contactData->email ?? ''));
            $mobile = trim((string) ($contactData->mobile ?? ''));

            if (
                $name === '' &&
                $designation === '' &&
                $email === '' &&
                $mobile === ''
            ) {

                /*
                |--------------------------------------------------------------------------
                | Delete email
                |--------------------------------------------------------------------------
                */

                DB::table('contact_email')
                    ->where('contact_id', $contactData->contact_id)
                    ->delete();

                /*
                |--------------------------------------------------------------------------
                | Delete mobile
                |--------------------------------------------------------------------------
                */

                DB::table('contact_mobile')
                    ->where('contact_id', $contactData->contact_id)
                    ->delete();

                /*
                |--------------------------------------------------------------------------
                | Delete contact
                |--------------------------------------------------------------------------
                */

                DB::table('contact')
                    ->where('contact_id', $contactData->contact_id)
                    ->delete();
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Return only contacts that still exist
        |--------------------------------------------------------------------------
        */

        return DB::table('contact')
            ->where('contact.company_id', $companyid)

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

            ->select(
                'contact.contact_id',
                'contact.company_id',
                'contact.name',
                'contact.designation',
                'contact.billing_contact',
                'contact_email.email',
                'contact_mobile.mobile'
            )

            ->get();
    }

    function getBillingContact($bookingdata, $sql, $contact)
    {
        $billingcontact = null;

        if (!empty($bookingdata->billing_contact_id)) {
            $billingcontact = $sql->billingcontact(
                $bookingdata->billing_contact_id
            );
        } else {
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
        }

        return $billingcontact;
    }

    public function getDelegate($stallid)
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

}
