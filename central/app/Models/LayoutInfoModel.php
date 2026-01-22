<?php

namespace App\Models;

use CodeIgniter\Model;

class LayoutInfoModel extends Model
{
    protected $table      = 'layout_info';
    protected $primaryKey = 'layout_id';

    protected $allowedFields = [
        'event_id',
        'file_type',
        'file_data',
        'layout_date'
    ];

    public function getLayoutsWithEvents()
    {
        return $this->select(
                'layout_info.layout_id,
                 layout_info.layout_date,
                 events.name,
                 events.venue_details,
                 events.start_date,
                 events.end_date'
            )
            ->join('events', 'events.event_id = layout_info.event_id')
            ->orderBy('layout_info.layout_date', 'DESC')
            ->findAll();
    }
}
