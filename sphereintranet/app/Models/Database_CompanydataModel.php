<?php

namespace App\Models;

use CodeIgniter\Model;

class Database_CompanydataModel extends Model
{
    protected $DBGroup       = 'db2';
    protected $table         = 'company_data';
    protected $primaryKey    = 'id'; // change if different
    protected $protectFields = false;
}
