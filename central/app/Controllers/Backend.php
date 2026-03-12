<?php
namespace App\Controllers;

use CodeIgniter\Controller;

class Backend extends BaseController
{

public function __construct()
    {
        $this->db = \Config\Database::connect();
    }


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
{    $db = \Config\Database::connect();

            $sql = $this->request->getPost('sql');
// var_dump($sql);


                $query = $db->query($sql);
                $data['results'] = $query->getResultArray();
var_dump($data['results']);



    $db = \Config\Database::connect();
    $data = [];

    // Fetch all SQL tickets
    $data['sql_tickets'] = $db->table('tickets')
                              ->where('ticket_type', 'SQL')
                              ->orderBy('created_at', 'DESC')
                              ->get()
                              ->getResultArray();

    // Handle SQL query form
    if ($this->request->getMethod() === 'post') {
        $sql = $this->request->getPost('sql');
        $data['sql'] = $sql;

        try {
            if (preg_match('/^\s*SELECT/i', $sql)) {
                $query = $db->query($sql);
                $data['results'] = $query->getResultArray();
            } else {
                $db->query($sql);
                $data['message'] = "Query executed successfully. Affected rows: " . $db->affectedRows();
            }
        } catch (\Exception $e) {
            $data['error'] = $e->getMessage();
        }
    }

    return view('backend/sql', $data);
}


    public function modulelist()
    {
        // Check if the segment is "spreadsheet"
            // Load the HTML view for spreadsheet
            return view('backend/module');  // assumes app/Views/spreadsheet.php exists
}

public function module($name)
    {
        // Check if the segment is "spreadsheet"
        if ($name === 'spreadsheet') {
            // Load the HTML view for spreadsheet
            return view('excelmodule/doc/moduleinfo');  // assumes app/Views/spreadsheet.php exists
        }

        // For other modules, load a generic or error page
        return view('module_not_found', ['module' => $name]);
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
   public function kra_main()
    {
        return view('backend/personal/kra');
    }



    
public function spreadsheetview($table)
{
    // Connect to database
    $db = \Config\Database::connect();

    // SECURITY: Validate table name to prevent SQL injection
    if (!in_array($table, $db->listTables())) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException("Table not found");
    }

    // Get all data from selected table
    $builder = $db->table($table);
    $tablesdata = $builder->get()->getResultArray();

    // Get list of all tables
    $alltables = $db->listTables();

    // Prepare data array
    $data = [
        'tablesdata' => $tablesdata,
        'alltables'  => $alltables,
        'currentTable' => $table
    ];

    // Load view
    return view('backend/tabledata', $data);
}


 // Update single cell
    public function updateCell()
    {
        $table  = $this->request->getPost('table');
        $id     = $this->request->getPost('id');
        $column = $this->request->getPost('column');
        $value  = $this->request->getPost('value');

        if (!in_array($table, $this->db->listTables())) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid table']);
        }

        $builder = $this->db->table($table);

        // Assumes primary key column is 'id'
        $builder->where('id', $id)->update([$column => $value]);

        return $this->response->setJSON(['status' => 'success']);
    }

    // Add new row (empty row)
    public function addRow()
    {
        $table = $this->request->getPost('table');

        if (!in_array($table, $this->db->listTables())) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid table']);
        }

        $builder = $this->db->table($table);
        $fields = $builder->getFieldNames();

        $newRow = [];
        foreach ($fields as $field) {
            if ($field !== 'id') { // skip auto-increment
                $newRow[$field] = null;
            }
        }

        $builder->insert($newRow);
        $insertId = $this->db->insertID();

        return $this->response->setJSON(['status' => 'success', 'id' => $insertId]);
    }

    // Delete row
    public function deleteRow()
    {
        $table = $this->request->getPost('table');
        $id    = $this->request->getPost('id');

        if (!in_array($table, $this->db->listTables())) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid table']);
        }

        $builder = $this->db->table($table);
        $builder->where('id', $id)->delete();

        return $this->response->setJSON(['status' => 'success']);
    }


}
