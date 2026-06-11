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

        // Render blade file as HTML
        $html = view($view, [
            'name' => $name,
            'email' => $email,
        ])->render();

        // Generate MIME boundary
        $uid = md5(uniqid((string) microtime(), true));

        // Headers
        $headers = "From: events@iitmindia.com\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: multipart/alternative; boundary=\"{$uid}\"\r\n";

        // Body
        $body = "--{$uid}\r\n";
        $body .= "Content-Type: text/html; charset=UTF-8\r\n";
        $body .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
        $body .= $html . "\r\n\r\n";
        $body .= "--{$uid}--";

        // Send Mail
        $status = mail($email, $subject, $body, $headers);

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