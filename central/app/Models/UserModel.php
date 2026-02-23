<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id';

    // Fields that can be inserted/updated
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
        'user_type',  // add this
        'journal'

    ];

    // Enable timestamps for created_at/updated_at if you want
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Optional: custom method to get a user by email
    public function getByEmail($email)
    {
        return $this->where('email', $email)->first();
    }
   public function getByPin($password)
{
    $result = $this->where('password', $password)->first();
    
    return $result ?: null;
}


}