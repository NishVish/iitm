<?php

namespace App\Controllers;

use App\Models\EventModel;
use App\Models\LayoutInfoModel;

class LayoutInfo extends BaseController
{
    public function index()
    {
        $layoutModel = new \App\Models\LayoutInfoModel();

        $data['layouts'] = $layoutModel->getLayoutsWithEvents();

        return view('events/layout_info/index', $data);
    }


    public function create()
    {
        $eventModel = new EventModel();

        $data['events'] = $eventModel
            ->select('event_id, name, venue_details')
            ->orderBy('name', 'ASC')
            ->findAll();

        return view('layout_info/create', $data);
    }

    public function store()
    {
        $layoutModel = new LayoutInfoModel();

        $file = $this->request->getFile('layout_file');

        if ($file && $file->isValid()) {
            $layoutModel->insert([
                'event_id'  => $this->request->getPost('event_id'),
                'file_type' => $file->getClientMimeType(),
                'file_data' => file_get_contents($file->getTempName())
            ]);
        }

        return redirect()->to('/layout-info/create')->with('success', 'Layout saved');
    }

}
