<?php

namespace App\Http\Controllers\CRUD\UpdateData;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

trait CompanyUpdate
{
    public function updateCompany(Request $request)
    {
        // dd("heloo");

        // dd($request->all());
        $companyid = $request->company_id;

        $data = $request->only([
            'company_name',
            'category',
            'subcategory',
            'gst_number',
            'address',
            'city',
            'pincode',
            'state',
            'country',
            'website',
            'phone',
            // 'sales_person',
        ]);

        DB::table('company_data')
            ->where('company_id', $companyid)
            ->update($data);

        return redirect()->back()->with(
            'success',
            'Company details updated successfully.'
        );
    }
}


