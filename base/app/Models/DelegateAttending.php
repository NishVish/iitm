<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DelegateAttending extends Model
{
    protected $table = 'delegates_attending';
    protected $primaryKey = 'delegate_id';
    public $timestamps = false;

    protected $fillable = [
        'company_id',
        'name',
        'designation',
        'mobile',
        'email'
    ];

    public function company()
    {
        return $this->belongsTo(CompanyDetail::class, 'company_id');
    }
}
