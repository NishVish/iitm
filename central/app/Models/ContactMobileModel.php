<?php
namespace App\Models;

use CodeIgniter\Model;

class ContactMobileModel extends Model
{
    protected $table = 'contact_mobile';
    protected $primaryKey = 'mobile_id';
    protected $allowedFields = ['contact_id', 'mobile', 'is_primary', 'created_at'];
}
