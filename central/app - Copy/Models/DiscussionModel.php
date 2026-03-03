<?php
namespace App\Models;
use CodeIgniter\Model;

class DiscussionModel extends Model
{
    protected $table = 'discussion';
    protected $primaryKey = 'discussion_id';
    protected $allowedFields = ['lead_id','action','message','discussion_date'];

    public function getByLeadId($leadID = null)
    {
        if (!$leadID) return [];
        return $this->where('lead_id', $leadID)
                    ->orderBy('discussion_date', 'DESC')
                    ->findAll();
    }
}
