<?php

namespace App\Models;

use CodeIgniter\Model;

class IssueModel extends Model
{
    protected $table = 'issues';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'title',
        'description',
        'priority',
        'status'
    ];

    protected $useTimestamps = true;
}