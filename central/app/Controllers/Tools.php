<?php
namespace App\Controllers;
use CodeIgniter\Controller;

class Tools extends BaseController {
        public function index() {

        return view('tools/index');
    }
    public function ftp() {
        $data['subnet'] = $this->getSubnet();
        return view('tools/ftp', $data);
    }

    public function checkIp() {
        $ip   = $this->request->getGet('ip');
        $port = $this->request->getGet('port') ?? 5000;
        
        // Very short timeout for local network (100ms)
        $timeout = 0.1; 
        $fp = @fsockopen($ip, $port, $errno, $errstr, $timeout);
        
        if ($fp) {
            fclose($fp);
            return $this->response->setJSON(['active' => true, 'ip' => $ip, 'port' => $port]);
        }
        return $this->response->setJSON(['active' => false]);
    }

    private function getSubnet() {
        $output = (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') ? shell_exec('ipconfig') : shell_exec('hostname -I');
        if (preg_match('/IPv4 Address[.\s]*:\s*([\d\.]+)/', $output, $matches)) {
            $octets = explode('.', $matches[1]);
            return "$octets[0].$octets[1].$octets[2]";
        }
        return '192.168.1';
    }
}