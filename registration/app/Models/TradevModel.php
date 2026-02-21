<?php

namespace App\Models;

use CodeIgniter\Model;

class TradevModel extends Model
{
    protected $table = 'tradev';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'title', 'select2', 'name', 'designation', 'organisation', 
        'email', 'phone', 'mobile', 'address', 'city', 'state',
        'pincode', 'country', 'website', 'city_name'
    ];
    protected $useTimestamps = true; // auto-manage created_at/updated_at
    protected $createdField  = 'date_reg';
    protected $updatedField  = '';
    protected $useSoftDeletes = false;
}