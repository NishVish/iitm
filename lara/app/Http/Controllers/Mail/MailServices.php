<?php

namespace App\Http\Controllers\Mail;

use App\Http\Controllers\Controller;
use Exception;

class MailServices extends Controller
{
    public function sendmail($name, $email, $templateId)
    {
        $template = $this->templateSelection($templateId);

        $view = $template['view'];
        $uid = md5(uniqid(time()));

        // 1. Render raw blade template view
        $htmlRaw = view('mail.templates')->render();

        // 2. Parse styles directly inline to ensure email engines render formatting
        $dom = new \DOMDocument();
        // Use libxml to suppress HTML5 tag warnings cleanly
        @$dom->loadHTML(mb_convert_encoding($htmlRaw, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        // Basic extraction tool matching CSS properties into elements safely
        $styles = [];
        $styleTags = $dom->getElementsByTagName('style');
        foreach ($styleTags as $tag) {
            if (preg_match_all('/\.([a-zA-Z0-9_-]+)\s*\{([^}]+)\}/', $tag->nodeValue, $matches)) {
                foreach ($matches[1] as $key => $className) {
                    $styles[$className] = trim($matches[2][$key]);
                }
            }
        }

        // Inline matching classes directly on DOM elements
        $xpath = new \DOMXPath($dom);
        foreach ($styles as $class => $rules) {
            $elements = $xpath->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $class ')]");
            foreach ($elements as $element) {
                $currentStyle = $element->getAttribute('style');
                $element->setAttribute('style', $currentStyle ? $currentStyle . '; ' . $rules : $rules);
            }
        }

        $htmlFinal = $dom->saveHTML();

        $to = "$email";
        $subject = "Confirmation Mail | India International Travel Mart | Chennai | 16 - 18 Jul 2026";

        $fromName = "Nishant Mail";
        $fromAddress = "events@iitmindia.com";

        $header = "From: {$fromName} <{$fromAddress}>\r\n";
        $header .= "MIME-Version: 1.0\r\n";
        $header .= "Content-type: multipart/mixed; boundary=\"$uid\"\r\n";

        $body = "--$uid\r\n";
        $body .= "Content-type:text/html; charset=iso-8859-1\r\n";
        $body .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
        $body .= $htmlFinal . "\r\n\r\n";
        $body .= "--$uid--";

        $status = mail($to, $subject, $body, $header);

        return [
            'status' => $status,
            'subject' => $subject,
            'view' => $view,
            'email' => $email,
            'template' => $templateId
        ];
    }
    


    public function sendRegistrationMail($data = null)
    {
      
 // VALIDATION 1: block + in email
    if (strpos($data['email'], '+') !== false) {
        return back()->with('status', 'Invalid email format');
    }

    // VALIDATION 2: block specific email
    if ($data['email'] === 'admin@iitmindia.com') {
        return back()->with('status', 'Email not allowed');
    }
        // dd($data);
        $to = $data['email'] ?? null;

        if (empty($to)) {
            return back()->with('status', 'Mail Failed: Email address missing');
        }

        $subject = 'Registration Successful';

        $html = view('mail.templates', compact('data'))->render();

        $fromName = "IITM";
        $fromAddress = "events@iitmindia.com";

        $header = "From: {$fromName} <{$fromAddress}>\r\n";
        $header .= "MIME-Version: 1.0\r\n";
        $header .= "Content-Type: text/html; charset=UTF-8\r\n";

        $status = mail($to, $subject, $html, $header);
        // $status = true;


        return back()->with(
            'status',
            $status ? 'Mail Sent' : 'Mail Failed'
        );
    }


private function templateSelection($templateId)
    {
        $jsonFile = public_path('mails/templates.json');

        if (!file_exists($jsonFile)) {
            throw new Exception(
                "Mail template configuration file not found: {$jsonFile}"
            );
        }

        $json = file_get_contents($jsonFile);

        $templates = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception(
                "Invalid JSON in mailtemplate.json: "
                . json_last_error_msg()
            );
        }

        foreach ($templates as $template) {

            if (
                isset($template['id']) &&
                $template['id'] == $templateId
            ) {
                return [
                    'id' => $template['id'],
                    'view' => $template['view'],
                    'subject' => $template['subject']
                ];
            }
        }

        throw new Exception(
            "Template ID {$templateId} not found in mailtemplate.json"
        );
    }



}