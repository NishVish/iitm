<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'exhibitor_bookings';

    protected $fillable = [
        'event_details',
        'company_details',
        'billing_contact',
        'delegate_details',
        'booking_details',
        'branding_extra_requirements',
    ];

    public $timestamps = true;
}