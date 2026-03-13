<?= view('header') ?>


<?php
$segment1 = service('uri')->getSegment(1);
?>
<!-- Companies Section -->
<!-- Companies Section -->
<?php if ($segment1 == 'tools') : ?>
<div class="submenu">
    <a href="<?= base_url('tools/ftp') ?>">FTP</a>
    <a href="<?= base_url('tools/network') ?>">Add Company</a>
    <a href="<?= base_url('tools/webscraper') ?>">Web Scraper</a>
    
    <?php endif; ?>
    </div>
    </div>
<div class="content">