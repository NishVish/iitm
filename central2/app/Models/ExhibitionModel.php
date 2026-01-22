<?php

namespace App\Models;

use CodeIgniter\Model;

class ExhibitionModel extends Model
{
    protected $table = 'exhibitions';
    protected $primaryKey = 'exhibition_id';
    protected $allowedFields = [
        'name', 'year', 'location', 'start_date', 'end_date', 'created_at'
    ];
}
