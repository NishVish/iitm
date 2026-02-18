<?php
namespace App\Controllers;

use CodeIgniter\Controller;

class Backend extends BaseController
{
    public function index()
    {
        
        $db = \Config\Database::connect();
        $tables = $db->listTables();

        $dbSchema = [];
        foreach ($tables as $table) {
            $dbSchema[$table] = $db->getFieldData($table);
        }

        return view('backend/index', ['dbSchema' => $dbSchema]);
    }

    public function sql()
    {
        return view('backend/sql');
        log_message('error', 'THIS IS A TEST ERROR LOG');

    }

    public function runSql()
    {
        $db = \Config\Database::connect();
        $query = $this->request->getPost('sql');

        try {
            $result = $db->query($query);

            // If SELECT query
            if (stripos(trim($query), 'select') === 0) {
                $data['results'] = $result->getResultArray();
            } else {
                $data['message'] = 'Query executed successfully.';
            }
        } catch (\Throwable $e) {
            $data['error'] = $e->getMessage();
        }

        $data['sql'] = $query;

        return view('backend/sql', $data);
    }

        public function plan()
    {
        return view('backend/plan');
    }

    public function games()
{
    return view('backend/game');
}
    public function tv()
{
    return view('backend/tv');
}
public function project_summary()
    {
        return view('backend/project_summary');
    }

    public function profile()
    {
        return view('backend/profile');
    }

    public function project_summary_main()
    {
        return view('backend/personal/project_summary');
    }

    public function profile_main()
    {
        return view('backend/personal/profile');
    }


}
