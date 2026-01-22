<?php

namespace App\Models;

use CodeIgniter\Model;

class EventModel extends Model
{
    protected $table      = 'events';
    protected $primaryKey = 'event_id';

    protected $allowedFields = [
        'confirmation',
        'name',
        'year',
        'location',
        'data',
        'multiple_days',
        'timing',
        'day1',
        'day2',
        'day3',
        'card_received',
        'card_typing',
        'validation',
        'merging_with_database',
        'putting_in_folder'
    ];

    protected $useTimestamps = false; // set to true if using created_at / updated_at fields

    protected $returnType    = 'array'; // or 'object' if you prefer
}
