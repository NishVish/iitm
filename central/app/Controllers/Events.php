<?php

namespace App\Controllers;

use App\Models\EventModel;
use CodeIgniter\Controller;

class Events extends Controller
{
    protected $eventModel;

    public function __construct()
    {
        $this->eventModel = new EventModel();
    }

    // List all events
    public function index()
    {
        $data['events'] = $this->eventModel->getEventsWithLatestLayout();
        return view('events/index', $data);
    }


    // Show create form
    public function create()
    {
        return view('events/create');
    }

    // Save new event
    public function store()
    {
        $this->eventModel->save([
            'b2b_constrain' => $this->request->getPost('b2b_constrain'),
            'year' => $this->request->getPost('year'),
            'name' => $this->request->getPost('name'),
            'venue_details' => $this->request->getPost('venue_details'),
            'venue_booking_details' => $this->request->getPost('venue_booking_details'),
            'coordinator' => $this->request->getPost('coordinator'),
            'start_date' => $this->request->getPost('start_date'),
            'end_date' => $this->request->getPost('end_date'),
        ]);

        return redirect()->to('/events');
    }

    // Show edit form
    public function edit($id)
    {
        $data['event'] = $this->eventModel->find($id);
        return view('events/edit', $data);
    }

    // Update event
    public function update($id)
    {
        $this->eventModel->update($id, [
            'b2b_constrain' => $this->request->getPost('b2b_constrain'),
            'year' => $this->request->getPost('year'),
            'name' => $this->request->getPost('name'),
            'venue_details' => $this->request->getPost('venue_details'),
            'venue_booking_details' => $this->request->getPost('venue_booking_details'),
            'coordinator' => $this->request->getPost('coordinator'),
            'start_date' => $this->request->getPost('start_date'),
            'end_date' => $this->request->getPost('end_date'),
        ]);

        return redirect()->to('/events');
    }

    // Delete event
    public function delete($id)
    {
        $this->eventModel->delete($id);
        return redirect()->to('/events');
    }

    public function getEventsWithLatestLayout()
    {
        $subQuery = $this->db->table('layout_info')
            ->select('event_id, MAX(layout_date) AS latest_date')
            ->groupBy('event_id');

        return $this->select(
                'events.*,
                layout_info.layout_id,
                layout_info.layout_date,
                layout_info.file_type'
            )
            ->join(
                "({$subQuery->getCompiledSelect()}) latest_layout",
                'latest_layout.event_id = events.event_id',
                'left'
            )
            ->join(
                'layout_info',
                'layout_info.event_id = latest_layout.event_id
                AND layout_info.layout_date = latest_layout.latest_date',
                'left'
            )
            ->orderBy('events.start_date', 'DESC')
            ->findAll();
    }

}
