<?php
namespace App\Controllers;

use CodeIgniter\Controller;

class Tools extends BaseController
{


public function index()
    {
        return view('tools/index');
    }


    public function server()
    {
        $data['servers'] = $this->scanNetwork();
        return view('network_view', $data);
    }

    private function scanNetwork()
    {
        $servers = [];
        $subnet = "192.168.1."; // Replace with your subnet

        // Scan hosts from 1 to 254
        for ($i = 1; $i <= 254; $i++) {
            $ip = $subnet . $i;

            // Ping the IP
            $pingresult = exec("ping -n 1 -w 100 $ip", $output, $status);
            if ($status == 0) {
                $servers[] = $ip;
            }
        }

        return $servers;
    }















}