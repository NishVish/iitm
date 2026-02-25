<?php
namespace App\Models;

use CodeIgniter\Model;

class ContactModel extends Model
{
    protected $table      = 'contact';
    protected $primaryKey = 'contact_id';

    protected $allowedFields = [
        'company_id',
        'priority',
        'name',
        'designation',
        'created_at',
        'updated_at'
    ];

    public function getByCompanyId($companyId)
    {
        $contacts = $this->where('company_id', $companyId)->findAll();

        foreach ($contacts as &$contact) {
            $contact['mobiles'] = $this->getMobiles($contact['contact_id']);
            $contact['emails']  = $this->getEmails($contact['contact_id']);
        }

        return $contacts;
    }

    public function getByCompanyIdOne($companyId)
    {
        return $this->where('company_id', $companyId)
                    ->orderBy('contact_id', 'DESC')
                    ->first();
    }

    public function getByMobile($mobile)
    {
        $mobileRow = $this->db->table('contact_mobile')
            ->where('mobile', $mobile)
            ->get()
            ->getRowArray();

        if (!$mobileRow) {
            return null;
        }

        $contact_id = $mobileRow['contact_id'];

        $contact = $this->find($contact_id);

        if (!$contact) {
            return null;
        }

        $company = $this->db->table('company_data')
            ->where('company_id', $contact['company_id'])
            ->get()
            ->getRowArray();

        $contact['mobiles'] = $this->getMobiles($contact_id);
        $contact['emails']  = $this->getEmails($contact_id);

        return [
            'contact' => $contact,
            'company' => $company,
        ];
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