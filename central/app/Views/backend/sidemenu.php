<?= view('header') ?>  <!-- loads app/Views/header.php -->


<?php
$segment1 = service('uri')->getSegment(1);

if ($segment1 == 'backend') : ?>
    <div class="submenu">
        <a href="<?= base_url('backend/plan') ?>">Plan</a>
        <a href="<?= base_url('backend/project_summary') ?>">Project Summary</a>
        <a href="<?= base_url('backend/profile') ?>">Profile</a>
        <!-- <a href="<?= base_url('backend/games') ?>">Play Games</a> -->
        <a href="<?= base_url('backend/sql') ?>">SQL</a>
        <!-- <a href="<?= base_url('backend/tv') ?>">TV</a> -->
        <a href="<?= base_url('backend/kra') ?>">KRA</a>
    </div>
<?php endif; ?>



</div>
<div class="content">