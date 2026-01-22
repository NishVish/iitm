<?php

namespace App\Models;

use CodeIgniter\Model;

class HrModel extends Model
{
    protected $table = 'system_details';      // Your actual table name
    protected $primaryKey = 'id';             // Your primary key (adjust if different)

    protected $allowedFields = [
        'employee_id',
        'name',
        'full_name',
        'years_of_using',
        'device_status',
        'device_type',
        'processor',
        'generation',
        'ram',
        'storage',
        'graphics'
    ];

    protected $useTimestamps = false; // Set to true if you have created_at / updated_at
}
