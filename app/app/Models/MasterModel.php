<?php
namespace App\Models;

use CodeIgniter\Model;

class MasterModel extends Model
{
    protected $table = 'company_data';

    // Get all unique states
    public function getAllStates()
    {
return $this->select('state')
            ->distinct()
            ->orderBy('state', 'ASC')
            ->get()
            ->getResult(); // returns objects

    }

    // Get cities by state
    // Get unique cities for a state
    public function getCitiesByState($state)
    {
        return $this->select('city')
                    ->distinct()
                    ->where('state', $state)
                    ->orderBy('city', 'ASC')
                    ->get()
                    ->getResult(); // returns objects
    }


    
    // Get companies, optionally filtered by state and city
    public function getCompanies($state = null, $city = null)
    {
        $builder = $this->builder($this->table);

        if($state){
            $builder->where('state', $state);
        }
        if($city){
            $builder->where('city', $city);
        }

        return $builder->get()->getResult();
    }
}
