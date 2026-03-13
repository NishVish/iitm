<?php

namespace App\Models;

use CodeIgniter\Model;

class MatchingSessionModel extends Model
{
    protected $table      = 'matching_session';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'company_id',
        'matching_company_id',
        'matching_type',
        'name',
        'address',
        'pin',
        'created_at'
    ];

    protected $useTimestamps = true; // if you want CI to auto-update created_at/updated_at
    protected $createdField  = 'created_at';
    protected $updatedField  = ''; // not used, table doesn't have updated_at
}
