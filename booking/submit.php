<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['form_image'])) {

        $img = $_POST['form_image'];
        $img = str_replace('data:image/jpeg;base64,', '', $img);
        $img = str_replace(' ', '+', $img);

        $data = base64_decode($img);

        $fileName = 'booking_' . time() . '.jpg';

        header('Content-Type: image/jpeg');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Content-Length: ' . strlen($data));

        echo $data;
        exit;
    }


}

?>