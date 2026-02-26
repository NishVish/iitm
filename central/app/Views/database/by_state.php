<?php include(APPPATH . 'Views/company/side.php'); ?>

<div style="margin-bottom: 20px; display: flex; gap: 10px; align-items: center;">
    <input type="text" id="tableSearch" placeholder="Search across all fields..." style="width:300px; padding:8px; border: 1px solid #ccc; border-radius: 4px;">
    <span id="saveStatus" style="font-style: italic; color: #666;"></span>
</div>

<div id="masterSpreadsheet"></div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    <?php
    $maxContacts = 0;
    foreach ($companies as $comp) {
        $count = count($comp['contacts']);
        if ($count > $maxContacts) $maxContacts = $count;
    }
    if ($maxContacts === 0) $maxContacts = 1;
    ?>

    const columns = [
        { title: 'DB', readOnly: true }, 
        { title: 'category' }, 
        { title: 'source' },
        { title: 'updated_by', readOnly: true }, 
        { title: 'updated_at', readOnly: true }, 
        { title: 'outbound' },
        { title: 'company_name' }, 
        { title: 'address_1' }, 
        { title: 'address_2' },
        { title: 'city' }, 
        { title: 'pincode' }, 
        { title: 'state' },
        { title: 'phone' }, 
        { title: 'fax' }
    ];

    <?php for ($i = 1; $i <= $maxContacts; $i++): ?>
        <?php $suffix = ($i === 1) ? '' : "_$i"; ?>
        columns.push({ title: 'contact_name<?= $suffix ?>' });
        columns.push({ title: 'designation<?= $suffix ?>' });
        columns.push({ title: 'mobile_<?= ($i*2)-1 ?>' });
        columns.push({ title: 'mobile_<?= ($i*2) ?>' });
        columns.push({ title: 'email_<?= ($i*2)-1 ?>' });
        columns.push({ title: 'email_<?= ($i*2) ?>' });
    <?php endfor; ?>

    const data = [
        <?php foreach ($companies as $comp): 
            $d = $comp['details'];
            $cList = array_values($comp['contacts']); 
        ?>
        {
            // Meta-data for AJAX updates (Hidden from view)
            id: '<?= $d['company_id'] ?>',
            contact_ids: <?= json_encode(array_keys($comp['contacts'])) ?>,
            
            cells: [
                'Main DB', '<?= esc($d['category']) ?>', '<?= esc($d['source_notes']) ?>',
                'Admin', '<?= esc($d['event_date']) ?>', 'Yes',
                '<?= esc($d['company_name']) ?>', '<?= esc($d['address'] ?? '') ?>', '',
                '<?= esc($d['city']) ?>', '<?= esc($d['pincode'] ?? '') ?>', '<?= esc($d['state']) ?>',
                '<?= esc($d['phone'] ?? '') ?>', '',

                <?php for ($i = 0; $i < $maxContacts; $i++): 
                    $c = $cList[$i] ?? null;
                ?>
                    '<?= esc($c['name'] ?? '') ?>', '<?= esc($c['designation'] ?? '') ?>',
                    '<?= $c['mobiles'][0] ?? '' ?>', '<?= $c['mobiles'][1] ?? '' ?>',
                    '<?= $c['emails'][0] ?? '' ?>', '<?= $c['emails'][1] ?? '' ?>',
                <?php endfor; ?>
            ]
        },
        <?php endforeach; ?>
    ];

    // Initialize Spreadsheet
    window.sheet = new Spreadsheet('masterSpreadsheet', {
        data: data.map(d => d.cells), // Load only the cell data
        columns: columns,
        editable: true,
        onAfterChange: function(changes) {
            if (!changes) return;
            
            const status = document.getElementById('saveStatus');
            status.innerText = "Saving changes...";

            // Send change to Backend
            fetch('<?= base_url('company/update_cell') ?>', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    company_id: data[changes.row].id,
                    contact_ids: data[changes.row].contact_ids,
                    column: columns[changes.col].title,
                    newValue: changes.newValue
                })
            })
            .then(res => res.json())
            .then(data => {
                status.innerText = "All changes saved.";
                setTimeout(() => { status.innerText = ""; }, 2000);
            })
            .catch(err => {
                status.innerText = "Error saving!";
                console.error(err);
            });
        }
    });

    // Search logic
    document.getElementById('tableSearch').addEventListener('keyup', function() {
        window.sheet.search(this.value); 
    });
});
</script>