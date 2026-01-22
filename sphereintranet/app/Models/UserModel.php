<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';          // Your table name
    protected $primaryKey = 'id';         // Primary key column

protected $allowedFields = [
    'employee_id',
    'name',
    'designation',
    'phone',
    'address',
    'email',
    'password',
    'category',
    'department',
    'doj',
    'uan_no',
    'fathers_name',
    'aadhaar_card',
    'pan_card',
    'bank_account_number',
    'ifsc_code',
];


    // Disable timestamps if you don't have created_at/updated_at columns
    protected $useTimestamps = false;
}
