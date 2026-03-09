<?php include(APPPATH . 'Views/company/side.php'); ?>
<?php //include(APPPATH . 'Views/company/filter.php'); ?>

    
<!-- Toggle Button -->
<button id="toggleBtn">Show/Hide Company Form</button>

<!-- Form Container -->
<div id="companyFormWrapper" class="form-container">
    <?= view('company/insert_company_form') ?>
</div>

<?php

$stateCounts      = [];
$cityCounts       = [];
$sourceCounts     = [];
$categoryCounts   = [];
$commentCounts    = [];


// var_dump($companies);
?>







<script>

    document.getElementById('btnFilter').addEventListener('click', function() {
    const db = document.getElementById('selDatabase').value;
    const cat = document.getElementById('selCategory').value;
    const src = document.getElementById('selSource').value;

    // Build query params
    let params = new URLSearchParams();
    if (db) params.append('database', db);
    if (cat) params.append('category', cat);
    if (src) params.append('source', src);

    // Redirect to the multi-filter route
    window.location.href = "<?= base_url('company/filter') ?>?" + params.toString();
});

</script>


<script>
document.addEventListener('DOMContentLoaded', function() {

    const maxContacts = <?= $maxContacts ?? 1 ?>;

    // --- Define Columns ---
    const columns = [
        { title: 'view', type: 'html', readOnly: true },
        { title: 'database' },
        { title: 'category' },
        { title: 'source', type: 'html', readOnly: true },
        { title: 'updated_by', readOnly: true },
        { title: 'updated_at', readOnly: true },
        { title: 'comments', readOnly: true },
        { title: 'outbound' },
        { title: 'company_name', type: 'html' },
        { title: 'address' },
        { title: 'city' },
        { title: 'pincode' },
        { title: 'state' },
        { title: 'phone' },
        { title: 'fax' }
    ];

    for (let i = 1; i <= maxContacts; i++) {
        const suffix = i === 1 ? '' : `_${i}`;
        columns.push({ title: `contact_name${suffix}` });
        columns.push({ title: `designation${suffix}` });
        columns.push({ title: `mobile_${i*2-1}` });
        columns.push({ title: `mobile_${i*2}` });
        columns.push({ title: `email_${i*2-1}` });
        columns.push({ title: `email_${i*2}` });
    }

const data = [


<?php 


foreach ($companies as $comp):



    $d = $comp['details'];
    $cList = array_values($comp['contacts']);
   
    // --- States ---
if (!empty($d['state'])) {
    $state = strtolower(trim($d['state']));
    if ($state !== 'state') {
        $stateCounts[$state] = ($stateCounts[$state] ?? 0) + 1;
    }
}

// --- Cities ---
if (!empty($d['city'])) {
    $city = strtolower(trim($d['city']));
    if ($city !== 'city') {
        $cityCounts[$city] = ($cityCounts[$city] ?? 0) + 1;
    }
}

// --- Sources (Handles comma-separated values) ---
if (!empty($d['source_notes'])) {
    foreach (explode(',', $d['source_notes']) as $s) {
        $source = strtolower(trim($s));
        if (!empty($source)) {
            $sourceCounts[$source] = ($sourceCounts[$source] ?? 0) + 1;
        }
    }
}

// --- Categories ---
if (!empty($d['category'])) {
    $cat = strtolower(trim($d['category']));
    $categoryCounts[$cat] = ($categoryCounts[$cat] ?? 0) + 1;
}

// --- Comments ---
if (!empty($d['last_comments'])) {
    $comment = strtolower(trim($d['last_comments']));
    $commentCounts[$comment] = ($commentCounts[$comment] ?? 0) + 1;
}



    // Source Processing
    $rawSources = explode(', ', $d['source_notes'] ?? '');
    $linkedSources = [];
    foreach ($rawSources as $source) {
        $cleanSource = trim($source);
        if (!empty($cleanSource)) {
            // Add to Stats
            $stats['sources'][$cleanSource] = ($stats['sources'][$cleanSource] ?? 0) + 1;
            
            // Format for HTML
            // $slug = urlencode(str_replace([' & ', ' '], ['-and-', '-'], $cleanSource));
            $url = base_url("company/byvar/source/");
            $linkedSources[] = '<a href="'.$url.'" style="color:#007bff;text-decoration:none;">'.esc($cleanSource).'</a>';
        }
    }
    $sourceHtml = implode(', ', $linkedSources);
?>
    {
        contact_ids: <?= json_encode(array_keys($comp['contacts'])) ?>,
        cells: [
            '<a href="<?= base_url('company/details/') . esc($d['company_id']) ?>">View</a>',
            <?= json_encode($d['database_name'] ?? '') ?>,
            <?= json_encode($d['category'] ?? '') ?>,
            <?= json_encode($sourceHtml) ?>,
            '<?= esc($d['updated_by'] ?? '') ?>',
            '<?= esc($d['updated_at'] ?? '') ?>',
            '<?= esc($d['last_comments'] ?? '') ?>',
            '<?= esc($d['outbound'] ?? '') ?>',
            <?= json_encode('<a href="' . base_url("company/details/" . ($filters['entry_type'] ?? 'general') . "/" . $d['company_id']) . '">' . esc($d['company_name'] ?? 'View') . '</a>') ?>,
            '<?= esc($d['address'] ?? '') ?>',
            '<?= esc($d['city'] ?? '') ?>',
            '<?= esc($d['pincode'] ?? '') ?>',
            '<?= esc($d['state'] ?? '') ?>',
            '<?= esc($d['phone'] ?? '') ?>',
            '<?= esc($d['fax'] ?? '') ?>',
            <?php for ($i=0; $i < $maxContacts; $i++):
                $c = $cList[$i] ?? [];
            ?>
                '<?= esc($c['name'] ?? '') ?>',
                '<?= esc($c['designation'] ?? '') ?>',
                '<?= esc($c['mobiles'][0] ?? '') ?>',
                '<?= esc($c['mobiles'][1] ?? '') ?>',
                '<?= esc($c['emails'][0] ?? '') ?>',
                '<?= esc($c['emails'][1] ?? '') ?>',
            <?php endfor; ?>
        ]
    },
<?php endforeach; ?>


];


});

</script>

<div style="margin-bottom: 20px;"></div>
<?php include(APPPATH . 'Views/company/stats.php'); ?>

<?php


if ($all == "super"): ?>




    <?php // include(APPPATH . 'Views/company/spreadsheet.php'); ?>


<?php 

// var_dump($companies) ;
endif; ?>