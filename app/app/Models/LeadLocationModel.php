<?php
namespace App\Models;

use CodeIgniter\Model;

class LeadLocationModel extends Model
{
    protected $table = 'lead_locations';
    protected $primaryKey = 'location_id';
    protected $allowedFields = [
        'lead_id', 
        'location', 
        'stall_location', 
        'size', 
        'price', 
        'gst_amount', 
        'discount_amount', 
        'grand_total'
    ];

    public function getByLeadId($leadId)
    {
        return $this->where('lead_id', $leadId)->findAll();
    }
}