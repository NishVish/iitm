<?php

function generateContactQR($row)
{
    $vcard = "BEGIN:VCARD\n";
    $vcard .= "VERSION:3.0\n";

    $get = function ($key) use ($row) {
        if (!isset($row[$key]))
            return null;
        if (!is_string($row[$key]) && !is_numeric($row[$key]))
            return null;

        $val = trim((string) $row[$key]);

        if ($val === '' || strtoupper($val) === 'NA')
            return null;

        return $val;
    };

    if ($val = $get('name')) {
        $vcard .= "FN:{$val}\n";
    }

    if ($val = $get('designation')) {
        $vcard .= "TITLE:{$val}\n";
    }

    if ($val = $get('company_name')) {
        $vcard .= "ORG:{$val}\n";
    }

    // if ($val = $get('email')) {
    //     $vcard .= "EMAIL:{$val}\n";
    // }

    // if ($val = $get('city')) {
    //     $vcard .= "ADR:;;{$val};;;;India\n";
    // }

    if ($val = $get('mobile')) {
        $val = preg_replace('/\D+/', '', $val);
        if ($val !== '') {
            $val = "";
            $vcard .= "TEL:+91{$val}\n";
        }
    }

    $vcard .= "NOTE:iitmExhibition2026\n";


    $vcard .= "END:VCARD";


    return "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=" . urlencode($vcard);
}

?>