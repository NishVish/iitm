<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Event extends Model
{
    protected $table = 'events';
    protected $primaryKey = 'event_id';

    public static function getEventsWithLatestLayout($limit = true)
{
    
    if($limit == true){
        $limit = 1;
    }else{
        $limit = 10;
    }   
    $today = date('Y-m-d');

    $subQuery = DB::table('layout_info')
        ->select('event_id', DB::raw('MAX(layout_date) AS latest_date'))
        ->groupBy('event_id');

    return self::select('events.*', 'layout_info.layout_id', 'layout_info.layout_date', 'layout_info.file_type')
        ->leftJoinSub($subQuery, 'latest_layout', function ($join) {
            $join->on('events.event_id', '=', 'latest_layout.event_id');
        })
        ->leftJoin('layout_info', function ($join) {
            $join->on('layout_info.event_id', '=', 'latest_layout.event_id')
                 ->on('layout_info.layout_date', '=', 'latest_layout.latest_date');
        })
        /* This logic sorts:
           1. Events happening today or in the future first (closest date first)
           2. Past events last (most recent past event first)
        */
        ->orderByRaw("CASE 
            WHEN start_date >= '$today' THEN 1 
            ELSE 2 
        END ASC")
        ->orderByRaw("ABS(DATEDIFF(start_date, '$today')) ASC")  
        ->limit($limit)
        ->get();
}
}