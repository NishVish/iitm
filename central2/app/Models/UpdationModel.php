<?php
namespace App\Models;

use CodeIgniter\Model;
class UpdationModel extends Model
{
    protected $table = 'updation';

    public function getByCompanyId($companyId)
    {
        return $this->where('company_id', $companyId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }
}
