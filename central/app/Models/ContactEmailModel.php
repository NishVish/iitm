<?php
namespace App\Models;

use CodeIgniter\Model;

class ContactEmailModel extends Model
{
    protected $table = 'contact_email';
    protected $primaryKey = 'email_id';
    protected $allowedFields = ['contact_id', 'email', 'is_primary', 'created_at'];
}
