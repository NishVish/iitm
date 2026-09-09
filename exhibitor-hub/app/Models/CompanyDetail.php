<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyDetail extends Model
{
    protected $table = 'company_details';
    protected $primaryKey = 'company_id';
    public $timestamps = false;

    protected $fillable = [
        'billing_contact',
        'company_name',
        'stall_number',
        'address',
        'pin',
        'state',
        'name',
        'designation',
        'mobile',
        'email'
    ];

    public function bookings()
    {
        return $this->hasMany(BookingDetail::class, 'company_id');
    }

    public function delegates()
    {
        return $this->hasMany(DelegateAttending::class, 'company_id');
    }
}
