<?php
namespace App\Models;

use CodeIgniter\Model;

class ContactModel extends Model
{
    protected $table = 'contact';
    protected $primaryKey = 'contact_id';

    // Add this:
    protected $allowedFields = [
        'company_id',
        'priority',
        'name',
        'designation',
        'created_at',
        'updated_at'
    ];

    // Get contacts for a company, with mobiles & emails
    public function getByCompanyId($companyId)
    {
        $contacts = $this->where('company_id', $companyId)->findAll();

        foreach ($contacts as &$contact) {
            $contact['mobiles'] = $this->getMobiles($contact['contact_id']);
            $contact['emails']  = $this->getEmails($contact['contact_id']);
        }

        return $contacts;
    }

    public function getMobiles($contact_id)
    {
        return array_column(
            $this->db->table('contact_mobile')
                ->select('mobile')
                ->where('contact_id', $contact_id)
                ->get()
                ->getResultArray(),
            'mobile'
        );
    }

    public function getEmails($contact_id)
    {
        return array_column(
            $this->db->table('contact_email')
                ->select('email')
                ->where('contact_id', $contact_id)
                ->get()
                ->getResultArray(),
            'email'
        );
    }
}
