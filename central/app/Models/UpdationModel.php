<?php
namespace App\Models;

use CodeIgniter\Model;

class UpdationModel extends Model
{
    protected $table      = 'updation';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'company_id',
        'updated_by',
        'comment'
    ];

    // Turn off timestamps completely
    protected $useTimestamps = false;


    public function getByCompanyId($companyId)
    {
        return $this->where('company_id', $companyId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    /**
     * Add a new update for a company
     */
    public function addUpdate($companyId, $updatedBy, $comment)
    {
        return $this->insert([
            'company_id' => $companyId,
            'updated_by' => $updatedBy,
            'comment'    => $comment
        ]);
    }
}
