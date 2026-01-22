<?php
namespace App\Models;

use CodeIgniter\Model;
class ContactModel extends Model
{
    protected $table = 'contact';
    protected $primaryKey = 'contact_id';

    public function getByCompanyId($companyId)
    {
        return $this->where('company_id', $companyId)->findAll();
    }
}
