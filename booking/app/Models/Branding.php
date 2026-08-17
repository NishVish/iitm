<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branding extends Model
{
    protected $table = 'branding';
    protected $primaryKey = 'branding_id';
    public $timestamps = false;

    protected $fillable = [
        'booking_id',
        'fascia_name',
        'certificate_name'
    ];

    public function booking()
    {
        return $this->belongsTo(BookingDetail::class, 'booking_id');
    }
}
