<?php
namespace App\Models;

use CodeIgniter\Model;

class ContactModel extends Model
{
    protected $table = 'contact';
    protected $primaryKey = 'contact_id';

    // Get contacts for a company, with mobiles & emails
    public function getByCompanyId($companyId)
    {
        $contacts = $this->where('company_id', $companyId)->findAll();

        // Load mobiles & emails for each contact
        foreach ($contacts as &$contact) {
            $contact['mobiles'] = $this->getMobiles($contact['contact_id']);
            $contact['emails']  = $this->getEmails($contact['contact_id']);
        }

        return $contacts;
    }

    // Get mobiles for a contact
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

    // Get emails for a contact
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
