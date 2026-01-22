<?php

namespace App\Models;

use CodeIgniter\Model;

class AnnouncementModel extends Model
{
    protected $table      = 'announcement';
    protected $primaryKey = 'id';

    protected $allowedFields = ['date', 'topic', 'info', 'department'];

    protected $useTimestamps = false;  // If you want, enable and add created_at/updated_at fields

    protected $returnType     = 'array';

    // Optional validation rules
    protected $validationRules = [
        'date'       => 'required|valid_date',
        'topic'      => 'required|max_length[255]',
        'info'       => 'required',
        'department' => 'required|max_length[100]',
    ];
}
