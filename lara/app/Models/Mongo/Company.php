<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Company extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'companies';

    protected $fillable = [
        'company_name',
        'company_address',
        'company_city',
        'company_state',
        'company_zip',
        'company_phone',
        'company_email',
        'company_website',

    ];
}