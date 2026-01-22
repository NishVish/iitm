<?php

namespace App\Models;

use CodeIgniter\Model;

class TradeVisitorModel extends Model
{
    protected $table      = 'tradevisitor'; // Table name
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'person_key', 'name', 'designation', 'company_name', 
        'category', 'address', 'city', 'pin', 'state', 
        'mobile', 'email', 'created_at'
    ];
}
