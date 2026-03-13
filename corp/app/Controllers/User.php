<?php
namespace App\Controllers;
use CodeIgniter\Controller;


class User extends Controller
{
    public function companyDetails()
    {
        $session = session();

        // var_dump($session);
        // exit;
        $companyId = $session->get('company_id');
        $contactId = $session->get('contact_id');

        $db = \Config\Database::connect();

        $builder = $db->table('company_data cd');

        $builder->select('
    cd.company_id,
    cd.company_name,
    cd.database_name,
    cd.city,
    cd.state,
    cd.entry_type,
    c.contact_id,
    c.name,
    c.designation,
    c.image,
    ce.email,
    cm.mobile
');

        $builder->join('contact c', 'c.company_id = cd.company_id', 'left');
        $builder->join('contact_email ce', 'ce.contact_id = c.contact_id AND ce.is_primary = 1', 'left');
        $builder->join('contact_mobile cm', 'cm.contact_id = c.contact_id AND cm.is_primary = 1', 'left');

        $builder->where('cd.company_id', $companyId);
        $builder->where('c.contact_id', $contactId);

$query = $builder->get();
$data = $query->getRowArray();

// Return JSON explicitly
return $this->response->setJSON($data ?? []);

    }

 public function uploadProfileImage()
{
    $file = $this->request->getFile('image');

    if ($file && $file->isValid() && !$file->hasMoved()) {
        // Generate a unique name and move the file
        $newName = $file->getRandomName();
        $file->move(WRITEPATH . 'uploads/contacts/', $newName);

        // Optionally, save $newName to the database for this contact
        $session = session();
        $contactId = $session->get('contact_id');
        $db = \Config\Database::connect();
        $builder = $db->table('contact');
        $builder->where('contact_id', $contactId);
        $builder->update(['image' => $newName]);

        return $this->response->setJSON([
            'success' => true,
            'path' => base_url('writable/uploads/contacts/' . $newName)
        ]);
    }

    return $this->response->setJSON([
        'success' => false,
        'message' => 'Invalid file upload'
    ]);
}


// In User.php
public function contactImage($filename)
{
    $path = WRITEPATH . 'uploads/contacts/' . $filename;
    if (file_exists($path)) {
        return $this->response->setHeader('Content-Type', mime_content_type($path))
                              ->setBody(file_get_contents($path));
    } else {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }
}



}

