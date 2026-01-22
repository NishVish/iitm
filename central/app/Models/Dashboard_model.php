<?php
namespace App\Models;

use CodeIgniter\Model;

class Dashboard_model extends Model
{
    protected $table = 'company_data';
    protected $primaryKey = 'id';
    protected $allowedFields = ['company_id','company_name','category','address','city','pincode','state','country','phone','gst_number','sales_person','active_inactive'];

    protected $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    // Total companies
    public function get_company_count($search = null)
    {
        $builder = $this->db->table('company_data');
        if($search){
            $builder->like('company_name', $search);
        }
        return $builder->countAllResults();
    }

    // Fetch companies list with optional search & pagination
    public function get_companies($search = null, $limit = 50, $offset = 0)
    {
        $builder = $this->db->table('company_data');
        if($search){
            $builder->like('company_name', $search);
        }
        $builder->orderBy('created_at', 'DESC');
        $builder->limit($limit, $offset);
        return $builder->get()->getResult(); // CI4
    }

    // Total leads/bookings
    public function get_total_leads()
    {
        return $this->db->table('leads')->countAllResults();
    }

    // Payments summary
    public function get_payment_summary()
    {
        $builder = $this->db->table('payments');
        $builder->select('payment_status, COUNT(*) as total, SUM(amount) as total_amount');
        $builder->groupBy('payment_status');
        return $builder->get()->getResult();
    }
}
