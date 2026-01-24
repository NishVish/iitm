<?php
namespace App\Models;

use CodeIgniter\Model;

class SourceModel extends Model
{
    protected $table = 'company_sources';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'company_id',
        'source_id',
        'event_date',
        'notes'
    ];
}
