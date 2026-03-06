<?= view('header') ?>  <!-- loads app/Views/header.php -->
<?php

$segment1 = service('uri')->getSegment(1);

if ($segment1 == 'home') : ?>
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
<!-- Example inside your big page -->

<?php
        $session = session();
// var_dump($session);
// view('dashboard/index')
?>
