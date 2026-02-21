<?php

namespace App\Models;

use CodeIgniter\Model;

class RegistrationModel extends Model
{
    protected $table = 'tradev';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'title', 'first_name', 'last_name', 'designation', 'organisation',
        'email', 'phone', 'address', 'city', 'state', 'pincode',
        'country', 'website', 'message'
    ];
}