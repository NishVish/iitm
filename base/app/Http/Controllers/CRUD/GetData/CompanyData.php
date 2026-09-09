<?php

namespace App\Http\Controllers\CRUD\GetData;
use Illuminate\Support\Facades\DB;

trait CompanyData
{
    public function companydata($companyid)
    {
        return DB::table('company_data')
            ->where('company_id', $companyid)
            ->get();
    }

    public function companybybookingid($bookingid)
    {
        $company = DB::table('booking_record as br')
            ->leftJoin(
                'company_data as cd',
                'br.company_id',
                '=',
                'cd.company_id'
            )
            ->where('br.booking_id', $bookingid)
            ->select(
                'br.booking_id',
                'br.company_id',
                'cd.*'
            )
            ->first();

        return $company;
    }


}
