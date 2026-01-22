<?php

namespace App\Models;

use CodeIgniter\Model;

class EventModel extends Model
{
    protected $table = 'events';
    protected $primaryKey = 'event_id';
    protected $allowedFields = [
        'b2b_constrain',
        'year',
        'name',
        'venue_details',
        'venue_booking_details',
        'coordinator',
        'start_date',
        'end_date',
        'created_at'
    ];

    protected $useTimestamps = true; // automatically manages created_at
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at'; // optional, add to table if needed

    public function getEventsWithLatestLayout()
{
    $subQuery = $this->db->table('layout_info')
        ->select('event_id, MAX(layout_date) AS latest_date')
        ->groupBy('event_id');

    return $this->select(
            'events.*,
             layout_info.layout_id,
             layout_info.layout_date,
             layout_info.file_type'
        )
        ->join(
            "({$subQuery->getCompiledSelect()}) latest_layout",
            'latest_layout.event_id = events.event_id',
            'left'
        )
        ->join(
            'layout_info',
            'layout_info.event_id = latest_layout.event_id
             AND layout_info.layout_date = latest_layout.latest_date',
            'left'
        )
        ->orderBy('events.start_date', 'DESC')
        ->findAll();
}

}
