<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventDetail extends Model
{
    protected $table = 'event_details';
    protected $primaryKey = 'event_id';
    public $timestamps = false;

    protected $fillable = [
        'year',
        'location',
        'city'
    ];

    public function bookings()
    {
        return $this->hasMany(BookingDetail::class, 'event_id');
    }
}
