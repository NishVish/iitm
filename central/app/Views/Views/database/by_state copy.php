<?php include(APPPATH . 'Views/company/side.php'); ?>
<input type="text" id="tableSearch" placeholder="Search companies, city, contact..." style="margin-bottom:10px; width:300px; padding:5px;">
<script>
document.getElementById('tableSearch').addEventListener('keyup', function() {
    const searchTerm = this.value.toLowerCase();
    const table = document.querySelector('table tbody');
    const rows = table.getElementsByTagName('tr');

    for (let i = 0; i < rows.length; i++) {
        let rowText = rows[i].innerText.toLowerCase();
        if (rowText.indexOf(searchTerm) > -1) {
            rows[i].style.display = '';
        } else {
            rows[i].style.display = 'none';
        }
    }
});
</script>
<div id="masterSpreadsheet"></div>


<script>
document.addEventListener('DOMContentLoaded', function() {
    <?php
    // 1. Pre-calculate the maximum number of contacts found in any single company
    $maxContacts = 0;
    foreach ($companies as $comp) {
        $count = count($comp['contacts']);
        if ($count > $maxContacts) $maxContacts = $count;
    }
    // Fallback to at least 1 slot if database is empty
    if ($maxContacts === 0) $maxContacts = 1;
    ?>

    // 2. Dynamic Column Definition
    const columns = [
        { title: 'database_name' }, { title: 'category' }, { title: 'source' },
        { title: 'updated_by' }, { title: 'updated_at' }, { title: 'outbound' },
        { title: 'company_name' }, { title: 'address_1' }, { title: 'address_2' },
        { title: 'city' }, { title: 'pincode' }, { title: 'state' },
        { title: 'phone' }, { title: 'fax' }
    ];

    // Auto-expand contact columns based on $maxContacts
    <?php for ($i = 1; $i <= $maxContacts; $i++): ?>
        <?php $suffix = ($i === 1) ? '' : "_$i"; ?>
        columns.push({ title: 'contact_name<?= $suffix ?>' });
        columns.push({ title: 'designation<?= $suffix ?>' });
        columns.push({ title: 'mobile_<?= ($i*2)-1 ?>' });
        columns.push({ title: 'mobile_<?= ($i*2) ?>' });
        columns.push({ title: 'email_<?= ($i*2)-1 ?>' });
        columns.push({ title: 'email_<?= ($i*2) ?>' });
    <?php endfor; ?>

    // 3. Dynamic Data Mapping
    const data = [
        <?php foreach ($companies as $comp): 
            $d = $comp['details'];
            $cList = array_values($comp['contacts']); 
        ?>
        [
            'Main DB', '<?= esc($d['category']) ?>', '<?= esc($d['source_notes']) ?>',
            'Admin', '<?= esc($d['event_date']) ?>', 'Yes',
            '<?= esc($d['company_name']) ?>', '<?= esc($d['address'] ?? '') ?>', '',
            '<?= esc($d['city']) ?>', '<?= esc($d['pincode'] ?? '') ?>', '<?= esc($d['state']) ?>',
            '<?= esc($d['phone'] ?? '') ?>', '',

            <?php 
            // Loop through the slots we created in headers
            for ($i = 0; $i < $maxContacts; $i++): 
                $c = $cList[$i] ?? null;
            ?>
                '<?= esc($c['name'] ?? '') ?>', 
                '<?= esc($c['designation'] ?? '') ?>',
                '<?= $c['mobiles'][0] ?? '' ?>', 
                '<?= $c['mobiles'][1] ?? '' ?>',
                '<?= $c['emails'][0] ?? '' ?>', 
                '<?= $c['emails'][1] ?? '' ?>',
            <?php endfor; ?>
        ],
        <?php endforeach; ?>
    ];

    window.sheet = new Spreadsheet('masterSpreadsheet', { data, columns });
});
</script>