<?php

namespace App\Http\Controllers\Mail;

use App\Http\Controllers\Controller;
use Exception;

class MailServices extends Controller
{
    public function sendmail($name, $email, $templateId)
    {
        // Get template configuration
        $template = $this->templateSelection($templateId);

        $view = $template['view'];
        $subject = $template['subject'];
        $uid = md5(uniqid(time()));
        $html2 = view('mail.test');

        $file_name = "hello";

        $to = "$email";
        $subject = "Confirmation Mail | India International Travel Mart | Chennai | 16 - 18 Jul 2026";
        $message = "<b>$html2</b>";
        $header = "From: events@iitmindia.com\r\n";
        $header .= "Cc: harish@iitmindia.com\r\n";
        $header .= "MIME-Version: 1.0\r\n";
        $header .= "Content-type: multipart/mixed; boundary=\"$uid\"\r\n";
        $body = "--$uid\r\n";
        $body .= "Content-type:text/html; charset=iso-8859-1\r\n";
        $body .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
        $body .= $message . "\r\n\r\n";
        $body .= "--$uid\r\n";
        $body .= "Content-Type: application/pdf; name=\"$file_name\"\r\n";
        $body .= "Content-Transfer-Encoding: base64\r\n";
        $body .= "Content-Disposition: attachment; filename=\"$file_name\"\r\n\r\n";
        $body .= "--$uid--";
        // $retval = mail($to, $subject, $body, $header);

        // Send Mail
        $status = mail($to, $subject, $body, $header);

        return [
            'status' => $status,
            'subject' => $subject,
            'view' => $view,
            'email' => $email,
            'template' => $templateId
        ];
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