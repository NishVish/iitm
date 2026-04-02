<?= view('header') ?> <!-- loads app/Views/header.php -->
<?php

$segment1 = service('uri')->getSegment(1);

if ($segment1 == 'home'): ?>
    <div class="submenu">
        <a href="<?= base_url('plan') ?>">Plan</a>
        <!-- <a href="<?= base_url('games') ?>">Play Games</a> -->
        <a href="<?= base_url('tv') ?>">TV</a>
        <a href="<?= base_url('company') ?>">View Companies</a>
        <a href="<?= base_url('company/add') ?>">Add Company</a>
    </div>

<?php endif; ?>

</div>

<div class="content">
    <!-- get curretn user task and tickets  -->

    <!-- echo session(); -->
    <!-- Example inside your big page -->
    <?php
    $session = session();

    $data = [
        'user_id' => $session->get('user_id'),
        'employee_id' => $session->get('employee_id'),
        'name' => ucfirst(strtolower($session->get('name'))),
        'designation' => $session->get('designation'),
        'phone' => $session->get('phone'),
        'address' => $session->get('address'),
        'email' => $session->get('email'),
        'category' => $session->get('category'),
        'department' => $session->get('department'),
        'doj' => $session->get('doj'),
        'uan_no' => $session->get('uan_no'),
        'fathers_name' => $session->get('fathers_name'),
        'aadhaar_card' => $session->get('aadhaar_card'),
        'pan_card' => $session->get('pan_card'),
        'bank_account_number' => $session->get('bank_account_number'),
        'ifsc_code' => $session->get('ifsc_code'),
        'user_type' => $session->get('user_type'),
        'journal' => $session->get('journal') ?? '',
        'server' => $session->get('server') ?? '',
    ];

    print_r($data); // debug print
    
    view('dashboard/index')
        ?>