<?php include(APPPATH . 'Views/company/side.php'); ?>

<div style="margin-bottom: 20px; display: flex; gap: 10px; align-items: center;">

    <!-- Home Button -->
    <a href="<?= base_url('dashboard') ?>" 
       style="padding:8px 14px; background:#007bff; color:#fff; text-decoration:none; border-radius:4px;">
        Home
    </a>

    <!-- Raise Ticket Button -->
    <a href="<?= base_url('tickets/create') ?>" 
       style="padding:8px 14px; background:#28a745; color:#fff; text-decoration:none; border-radius:4px;">
        Raise Ticket
    </a>

    <!-- Search Input -->
    <input type="text" 
           id="tableSearch" 
           placeholder="Search across all fields..." 
           style="width:300px; padding:8px; border: 1px solid #ccc; border-radius: 4px;">

    <!-- Save Status -->
    <span id="saveStatus" style="font-style: italic; color: #666;"></span>

</div>
<div id="masterSpreadsheet">
    
</div>

<style>



#masterSpreadsheet {
    max-width: 150vh;        /* fit container width */
    max-height: 70vh;        /* maximum height for vertical scroll */
    overflow-x: auto;        /* horizontal scroll if content is wider */
    overflow-y: auto;        /* vertical scroll if content is taller than max-height */
    border: 1px solid #ccc;
    padding: 10px;
    box-sizing: border-box;
}

</style>


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
        { title: 'comments', readOnly: true }, 
        { title: 'outbound' },
        { title: 'company_name' }, 
        { title: 'address' }, 
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
    // Meta-data for AJAX updates (hidden from view)
    id: '<?= esc($d['company_id'] ?? '') ?>',
    contact_ids: <?= json_encode(array_keys($comp['contacts'])) ?>,
    
    cells: [
        '<?= esc($d['database_name'] ?? '') ?>', 
        '<?= esc($d['category'] ?? '') ?>', 
        '<?= esc($d['source_notes'] ?? '') ?>',
        '<?= esc($d['updated_by'] ?? '') ?>', 
        '<?= esc($d['updated_at'] ?? '') ?>', 
        '<?= esc($d['last_comments'] ?? '') ?>', 
        '<?= esc($d['outbound'] ?? '') ?>', 
        '<?= esc($d['company_name'] ?? '') ?>', 
        '<?= esc($d['address'] ?? '') ?>', 
        '<?= esc($d['city'] ?? '') ?>', 
        '<?= esc($d['pincode'] ?? '') ?>', 
        '<?= esc($d['state'] ?? '') ?>',
        '<?= esc($d['phone'] ?? '') ?>', 
        '',

        <?php for ($i = 0; $i < $maxContacts; $i++): 
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

// --- UPDATED STATS LOGIC ---
function calculateStats(rows) {
    const stats = {
        sources: {},
        cities: {},
        totalContacts: 0
    };

    rows.forEach(item => {
        // Support both original data and getData() format
        const row = item.cells || item;

        const source = row[2] || 'Unknown';
        const city   = row[9] || 'Unknown';

        stats.totalContacts++;

        stats.sources[source] = (stats.sources[source] || 0) + 1;
        stats.cities[city] = (stats.cities[city] || 0) + 1;
    });

    // Sort highest first
    const sourceData = Object.entries(stats.sources)
        .sort((a, b) => b[1] - a[1])
        .map(([name, count]) => ['Source', name, count]);

    const cityData = Object.entries(stats.cities)
        .sort((a, b) => b[1] - a[1])
        .map(([name, count]) => ['City', name, count]);

    const generalData = [
        ['General', 'Total Contacts', stats.totalContacts]
    ];

    return [
        ...generalData,
        ['---', '---', '---'],
        ...sourceData,
        ['---', '---', '---'],
        ...cityData
    ];
}


// // Initialize Master Spreadsheet
// window.sheet = new Spreadsheet('masterSpreadsheet', {
//     data: data.map(d => d.cells),
//     columns: columns,
//     editable: true,
//     onAfterChange: function(changes) {

//         // Get LIVE updated sheet data
//         const updatedData = window.sheet.getData();

//         // Recalculate using updated data
//         window.statsSheet.loadData(calculateStats(updatedData));
//     }
// });


// Initialize Stats Spreadsheet
const initialStats = calculateStats(data);

window.statsSheet = new Spreadsheet('statsSpreadsheet', {
    data: initialStats,
    columns: [
        { title: 'Type', readOnly: true },
        { title: 'Name', readOnly: true },
        { title: 'Count', readOnly: true }
    ],
    editable: false
});

    
    
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

<h3 style="margin-top: 30px;">Data Statistics</h3>
<div id="statsSpreadsheet"></div>

<style>
#statsSpreadsheet {
    max-width: 150vh;
    border: 1px solid #ccc;
    padding: 10px;
    background: #f9f9f9;
}
</style>