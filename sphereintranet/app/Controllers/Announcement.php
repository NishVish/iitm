<?php

namespace App\Controllers;

use App\Models\AnnouncementModel;
use CodeIgniter\Controller;

class Announcement extends Controller
{
    protected $announcementModel;

    public function __construct()
    {
        $this->announcementModel = new AnnouncementModel();
    }

    public function fetchAnnouncements()
    {
        $announcements = $this->announcementModel->findAll();

        return $this->response->setJSON($announcements);
    }



    // Insert a new announcement (example)
    public function create()
    {
        $newData = [
            'date'       => '2025-08-23',
            'topic'      => 'New Policy Update',
            'info'       => 'Details about the new policy...',
            'department' => 'HR',
        ];

        $this->announcementModel->insert($newData);

        return redirect()->to('/home')->with('message', 'Announcement added successfully.');
    }


}
