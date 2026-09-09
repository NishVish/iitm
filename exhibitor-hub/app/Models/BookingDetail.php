<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingDetail extends Model
{
    protected $table = 'booking_details';
    protected $primaryKey = 'booking_id';
    public $timestamps = false;

    protected $fillable = [
        'event_id',
        'company_id',
        'stall',
        'fascia',
        'certificate'
    ];

    public function event()
    {
        return $this->belongsTo(EventDetail::class, 'event_id');
    }

    public function company()
    {
        return $this->belongsTo(CompanyDetail::class, 'company_id');
    }

    public function branding()
    {
        return $this->hasOne(Branding::class, 'booking_id');
    }
}
