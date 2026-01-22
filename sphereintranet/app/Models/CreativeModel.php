<?php

namespace App\Models;

use CodeIgniter\Model;

class CreativeModel extends Model
{
    protected $table = 'creative';
    protected $primaryKey = 'id';

    protected $returnType = 'array';

protected $allowedFields = ['image_url', 'sender', 'department', 'message', 'created_at'];
    protected $useTimestamps = false;
}
