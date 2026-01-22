<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Search extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('company_data c');

        $builder->select('c.company_id, c.company_name, c.category, c.city, c.state, 
            GROUP_CONCAT(CONCAT(co.name, " (", co.designation, ") - ", co.mobile, " / ", co.email) SEPARATOR "\n") AS contacts', false);
        $builder->join('contact co', 'co.company_id = c.company_id', 'left');
        $builder->groupBy('c.company_id');

        // Get search query from GET parameter
        $q = $this->request->getGet('q');

        if (!empty($q)) {
            $builder->like('c.company_name', $q)
                    ->orLike('c.category', $q)
                    ->orLike('c.city', $q)
                    ->orLike('c.state', $q)
                    ->orLike('co.name', $q)
                    ->orLike('co.designation', $q)
                    ->orLike('co.email', $q)
                    ->orLike('co.mobile', $q);
        }

        $data['results'] = $builder->get()->getResultArray();
        $data['query'] = $q;

        return view('search/results', $data);
    }
}
