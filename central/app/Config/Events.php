<?php

namespace App\Controllers;

use App\Models\EventModel;
use CodeIgniter\Controller;

class Events extends Controller
{
    protected $eventModel;
    protected $db;

    public function __construct()
    {
        $this->eventModel = new EventModel();
        $this->db = \Config\Database::connect();
    }
    public function upcoming($type = 'single')
    {
        $db = \Config\Database::connect();
        $today = date('Y-m-d');
        $builder = $db->table('events')
            ->where('start_date >=', $today)
            ->orderBy('start_date', 'ASC');

        // Base URL for images
        $url = "http://localhost/iitm/central/public/uploads/events/";

        if ($type === 'all') {
            $events = $builder->get()->getResultArray();

            // Process images for all events
            foreach ($events as &$e) {
                $e['event_image_url'] = !empty($e['event_image'])
                    ? $url . $e['event_image']  // <-- use $e, not $event
                    : "";
            }

            // Optional: debug
            // var_dump($events);

            return $this->response->setJSON($events);
        }

        // Default: Single nearest event
        $event = $builder->limit(1)->get()->getRowArray();
        if ($event) {
            $event['event_image_url'] = !empty($event['event_image'])
                ? $url . $event['event_image']
                : "";
        }

        return $this->response->setJSON($event);
    }

    public function testImage()
    {
        // We manually add 'public' since your FCPATH stops at 'app'
        $path = FCPATH . 'public/uploads/events/ahmedabad2026.png';

        // Normalize slashes for Windows
        $path = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path);

        if (file_exists($path)) {
            return $this->response
                ->setHeader('Content-Type', 'image/png')
                ->setBody(file_get_contents($path));
        }

        // Still failing? Let's do a hard-coded check to prove it works
        $hardPath = 'C:\\xampp\\htdocs\\iitm\\app\\public\\uploads\\events\\ahmedabad2026.png';
        if (file_exists($hardPath)) {
            return $this->response
                ->setHeader('Content-Type', 'image/png')
                ->setBody(file_get_contents($hardPath));
        }

        var_dump($path);
        exit;
        return "System path still incorrect. Target: " . $path;
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


    // public function fetchiitmdate()
// {
    public function fetchiitmdate()
    {
        $baseUrl = "https://iitmindia.com";

        // Helper function to fetch page content
        $fetchPage = function ($url) {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 15);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            $html = curl_exec($ch);
            $err = curl_error($ch);
            curl_close($ch);

            if ($err) {
                throw new \Exception("cURL Error: $err");
            }
            return $html;
        };

        // Helper function to check element visibility
        $isVisible = function ($element) {
            if (!$element)
                return false;

            $style = $element->getAttribute('style') ?? '';
            if (stripos(str_replace(' ', '', $style), 'display:none') !== false)
                return false;

            $hiddenClasses = ['hidden', 'd-none', 'elementor-hidden'];
            $classes = explode(' ', $element->getAttribute('class') ?? '');
            if (count(array_intersect($classes, $hiddenClasses)) > 0)
                return false;

            if (strtolower($element->getAttribute('aria-hidden') ?? '') === 'true')
                return false;

            return true;
        };

        // Recursive function to get text list
        $getTextList = null;
        $getTextList = function ($node) use (&$getTextList, $isVisible) {
            $texts = [];
            foreach ($node->childNodes as $child) {
                if ($child->nodeType === XML_TEXT_NODE) {
                    $t = trim($child->nodeValue);
                    if ($t !== '')
                        $texts[] = $t;
                } elseif ($child->nodeType === XML_ELEMENT_NODE && $isVisible($child)) {
                    $texts = array_merge($texts, $getTextList($child));
                }
            }
            return $texts;
        };


        $parseDates = function ($line) {
            $line = trim($line);

            // Handle TBA or postponed
            if (stripos($line, 'TBA') !== false || stripos($line, 'POSTPONED') !== false) {
                return [null, null];
            }

            // Example: "20 - 21 March 2026" or "20,21 March 2026"
            $line = str_replace(',', '-', $line); // Replace commas with dash for easier parsing
            if (preg_match('/(\d{1,2})\s*-\s*(\d{1,2})\s*([a-zA-Z]+)\s*(\d{4})/', $line, $matches)) {
                $start_day = $matches[1];
                $end_day = $matches[2];
                $month = $matches[3];
                $year = $matches[4];

                $start_date = date('Y-m-d', strtotime("$start_day $month $year"));
                $end_date = date('Y-m-d', strtotime("$end_day $month $year"));
                return [$start_date, $end_date];
            }

            // Example: single date like "16 July 2026"
            if (preg_match('/(\d{1,2})\s*([a-zA-Z]+)\s*(\d{4})/', $line, $matches)) {
                $start_date = $end_date = date('Y-m-d', strtotime("$matches[1] $matches[2] $matches[3]"));
                return [$start_date, $end_date];
            }

            return [null, null]; // fallback
        };



        try {
            // Step 1: Get homepage and find "Trade Visitor" link
            $homeHtml = $fetchPage($baseUrl);
            $dom = new \DOMDocument();
            libxml_use_internal_errors(true);
            $dom->loadHTML($homeHtml);
            libxml_clear_errors();
            $xpath = new \DOMXPath($dom);

            $tradeLinkNode = null;
            foreach ($xpath->query('//a') as $a) {
                if (stripos($a->nodeValue, 'Trade Visitor') !== false) {
                    $tradeLinkNode = $a;
                    break;
                }
            }

            if (!$tradeLinkNode) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Trade Visitor link not found']);
            }

            $tradeUrl = $tradeLinkNode->getAttribute('href');
            if (!preg_match('/^https?:\/\//', $tradeUrl)) {
                $tradeUrl = rtrim($baseUrl, '/') . '/' . ltrim($tradeUrl, '/');
            }

            // Step 2: Get the Trade Visitor page
            $tradeHtml = $fetchPage($tradeUrl);
            $dom2 = new \DOMDocument();
            libxml_use_internal_errors(true);
            $dom2->loadHTML($tradeHtml);
            libxml_clear_errors();
            $xpath2 = new \DOMXPath($dom2);

            // Step 3: Extract event containers
            $eventContainers = $xpath2->query('//div[contains(@class,"elementor-column")]');
            $seen = [];

            foreach ($eventContainers as $col) {
                if (!$isVisible($col))
                    continue;

                $texts = $getTextList($col);
                if (!$texts)
                    continue;

                if (in_array(strtoupper($texts[0]), ["HOME", "ESCALATE YOUR BRAND VISIBILITY WITH \u{200b}"]))
                    continue;

                $eventName = $texts[0];
                if (in_array($eventName, $seen))
                    continue;
                $seen[] = $eventName;

                // Initialize fields
                $name = $eventName;
                $dates = null;
                $location = null;
                $time = null;
                $registration = null;
                $status = null;

                foreach (array_slice($texts, 1) as $line) {
                    $lineUpper = strtoupper($line);
                    if (stripos($line, 'AM') !== false || stripos($line, 'PM') !== false) {
                        $time = $line;
                    } elseif (stripos($lineUpper, 'POSTPONED') !== false || stripos($lineUpper, 'SUCCESSFULLY COMPLETED') !== false) {
                        $status = $line;
                    } elseif (preg_match('/Jan|Feb|Mar|April|May|June|July|Aug|Sept|Sep|Oct|Nov|Dec|TBA/i', $line)) {
                        $dates = $line;
                    } elseif (preg_match('/Hall|Ground|Center|Centre|Stadium|Complex|Gate/i', $line)) {
                        $location = $line;
                    } elseif (stripos($line, 'Trade Visitor') !== false) {
                        $registration = $line;
                    } else {
                        if (!$location) {
                            $location = $line;
                        } else {
                            $status = $line;
                        }
                    }
                }

                // Parse dates
                // Use robust date parsing
                list($start_date, $end_date) = $parseDates($dates ?? '');

                // Insert into database
                $this->eventModel->insert([
                    'name' => $name,
                    'venue_details' => $location,
                    'venue_booking_details' => $registration ?? '',
                    'coordinator' => '',
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'b2b_constrain' => '',
                    'year' => $start_date ? date('Y', strtotime($start_date)) : null,
                ]);
            }

            return $this->response->setJSON(['status' => 'success', 'message' => 'Events fetched and saved.']);

        } catch (\Exception $e) {
            return $this->response->setJSON(['status' => 'error', 'message' => $e->getMessage()]);
        }
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
    public function deletebyid($id)
    {
        $db = \Config\Database::connect();

        $sql = "DELETE FROM events WHERE event_id = ?";
        $db->query($sql, [$id]);

        return redirect()->to('/events');
    }
    // Delete event
    public function delete()
    {
        // Option 1: Delete all rows via model
// Delete all events safely
        $this->eventModel->db->query('SET FOREIGN_KEY_CHECKS = 0');
        $this->eventModel->db->table('events')->truncate();
        $this->eventModel->db->query('SET FOREIGN_KEY_CHECKS = 1');    // Option 2 (alternative, directly via DB)
        // $this->eventModel->db->table('events')->truncate();

        // Redirect to index instead of just returning view
        return redirect()->to('/events'); // ensures page reloads with updated data
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
    public function updateCell()
    {
        $eventId = $this->request->getPost('id');
        $field = $this->request->getPost('field');
        $value = $this->request->getPost('value');

        $allowedFields = [
            'name',
            'year',
            'venue_details',
            'coordinator',
            'start_date',
            'end_date',
            'b2b_constrain'
        ];

        if (!in_array($field, $allowedFields)) {
            return $this->response->setJSON(['status' => 'error']);
        }

        $this->eventModel->update($eventId, [
            $field => $value
        ]);

        return $this->response->setJSON(['status' => 'success']);
    }




}
