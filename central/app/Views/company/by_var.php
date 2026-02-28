<?php include(APPPATH . 'Views/company/side.php'); ?>

<style>
    /* Container for the entire bar */
.filter-toolbar {
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    background: #ffffff;
    padding: 12px 20px;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    border: 1px solid #e0e0e0;
}

/* Breadcrumb Section */
.breadcrumb-container {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-right: 10px;
}

.breadcrumb-main {
    text-transform: uppercase;
    font-size: 0.75rem;
    font-weight: 700;
    color: #95a5a6;
    letter-spacing: 1px;
}

.breadcrumb-sub {
    font-weight: 600;
    color: #2c3e50;
    white-space: nowrap;
}

.divider {
    height: 24px;
    width: 1px;
    background: #ddd;
    margin: 0 10px;
}

/* Home Button */
.btn-home {
    padding: 8px 14px;
    background: #007bff;
    color: #fff !important;
    text-decoration: none;
    border-radius: 6px;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 5px;
    white-space: nowrap;
    transition: background 0.2s;
}

.btn-home:hover {
    background: #0056b3;
}

/* Filters Group */
.filter-group {
    display: flex;
    gap: 6px;
    align-items: center;
}

.filter-select {
    padding: 8px;
    border: 1px solid #ced4da;
    border-radius: 6px;
    background: #f8f9fa;
    font-size: 0.9rem;
}

.filter-select:focus {
    border-color: #007bff;
}

.btn-apply {
    padding: 8px 16px;
    background: #28a745;
    color: #fff;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 600;
    white-space: nowrap;
    transition: opacity 0.2s;
}

.btn-apply:hover {
    opacity: 0.9;
}

/* Search Section */
.search-container {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-left: auto;
}

.search-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

.search-input {
    width: 200px;
    padding: 8px 8px 8px 30px;
    border: 1px solid #ced4da;
    border-radius: 6px;
    font-size: 0.9rem;
    outline: none;
}

.search-input:focus {
    width: 250px; /* Expands on focus */
    border-color: #007bff;
    transition: width 0.3s;
}

.search-icon {
    position: absolute;
    left: 10px;
    color: #999;
}

.save-status {
    font-size: 0.75rem;
    font-style: italic;
    color: #28a745;
    white-space: nowrap;
}



</style>

<?php 
    $uri = service('uri');
    $mainLabel = $uri->getSegment(3, ''); 
    $subLabel = ($uri->getTotalSegments() >= 4) ? str_replace(['-', '-and-'], [' ', ' & '], $uri->getSegment(4)) : '';
?>

<div class="filter-toolbar">
    
    <?php if ($mainLabel): ?>
        <div class="breadcrumb-container">
            <span class="breadcrumb-main"><?= esc($mainLabel) ?></span>
            <?php if ($subLabel): ?>
                <span style="color: #bdc3c7;">&rsaquo;</span>
                <span class="breadcrumb-sub"><?= esc($subLabel) ?></span>
            <?php endif; ?>
        </div>
        <div class="divider"></div>
    <?php endif; ?>

    <a href="<?= base_url('company') ?>" class="btn-home">
       <span>&#8962;</span> Home
    </a>

    <div class="filter-group">
        <select id="selDatabase" class="filter-select">
            <option value="">All Databases</option>
            <?php foreach($databases as $db): ?>
                <option value="<?= esc($db) ?>" <?= (($filters['database'] ?? '') == $db) ? 'selected' : '' ?>><?= esc($db) ?></option>
            <?php endforeach; ?>
        </select>

        <select id="selCategory" class="filter-select">
            <option value="">All Categories</option>
            <?php foreach($categories as $cat): ?>
                <option value="<?= esc($cat) ?>" <?= (($filters['category'] ?? '') == $cat) ? 'selected' : '' ?>><?= esc($cat) ?></option>
            <?php endforeach; ?>
        </select>

        <select id="selSource" class="filter-select">
            <option value="">All Sources</option>
            <?php foreach($sources as $src): ?>
                <option value="<?= esc($src) ?>" <?= (($filters['source'] ?? '') == $src) ? 'selected' : '' ?>><?= esc($src) ?></option>
            <?php endforeach; ?>
        </select>

        <button id="btnFilter" class="btn-apply">Apply</button>
    </div>

    <div class="search-container">
        <div class="search-wrapper">
            <input type="text" id="tableSearch" class="search-input" placeholder="Search...">
            <span class="search-icon">&#128269;</span>
        </div>
        <span id="saveStatus" class="save-status"></span>
    </div>
</div>



<div id="masterSpreadsheet"></div>

<style>
#masterSpreadsheet {
    max-width: 150vh;
    max-height: 70vh;
    overflow-x: auto;
    overflow-y: auto;
    border: 1px solid #ccc;
    padding: 10px;
    box-sizing: border-box;
}

#statsSpreadsheet {
    max-width: 150vh;
    border: 1px solid #ccc;
    padding: 10px;
    background: #f9f9f9;
}
</style>

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



document.addEventListener('DOMContentLoaded', function() {

    // --- Determine max number of contacts dynamically from PHP data ---
    const maxContacts = <?= $maxContacts ?? 1 ?>;

    // --- Define Columns ---
    // --- Define Columns ---
const columns = [
    { title: 'DB', readOnly: true },
    { title: 'category' },
    { title: 'source', type: 'html', readOnly: true }, // Add type: 'html'
    
    { title: 'updated_by', readOnly: true },
    // ... rest of columns
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

    for (let i = 1; i <= maxContacts; i++) {
        const suffix = i === 1 ? '' : `_${i}`;
        columns.push({ title: `contact_name${suffix}` });
        columns.push({ title: `designation${suffix}` });
        columns.push({ title: `mobile_${i*2-1}` });
        columns.push({ title: `mobile_${i*2}` });
        columns.push({ title: `email_${i*2-1}` });
        columns.push({ title: `email_${i*2}` });
    }

    // --- Prepare Data ---
const data = [
<?php foreach ($companies as $comp):
    $d = $comp['details'];
    $cList = array_values($comp['contacts']);
    
    // Create Hyperlinks for Source Notes
    $rawSources = explode(', ', $d['source_notes'] ?? '');
    $linkedSources = [];
    foreach ($rawSources as $source) {
        if (!empty(trim($source))) {
            // URL Friendly version of the source name
            $slug = urlencode(str_replace([' & ', ' '], ['-and-', '-'], trim($source)));
            $url = base_url("company/byvar/source/$slug");
            $linkedSources[] = '<a href="'.$url.'" style="color:#007bff;text-decoration:none;">'.esc($source).'</a>';
        }
    }
    $sourceHtml = implode(', ', $linkedSources);
?>
    {
        id: '<?= esc($d['company_id'] ?? '') ?>',
        contact_ids: <?= json_encode(array_keys($comp['contacts'])) ?>,
        cells: [
            <?= json_encode($d['database_name'] ?? '') ?>,
            <?= json_encode($d['category'] ?? '') ?>,
            <?= json_encode($sourceHtml) ?>, // <--- This now contains HTML links
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

    // --- Stats Calculation ---
    function calculateStats(rows) {
        const stats = { sources: {}, cities: {}, totalContacts: 0 };
        rows.forEach(item => {
            const row = item.cells || item;
            const sourceIndex = columns.findIndex(c => c.title === 'source');
            const cityIndex = columns.findIndex(c => c.title === 'city');

            const sourceString = row[sourceIndex] || '';
            const city = row[cityIndex] || '';

            stats.totalContacts += (item.contact_ids?.length || 1);

            const sources = sourceString.split(',').map(s => s.trim()).filter(s => s);
            sources.forEach(src => stats.sources[src] = (stats.sources[src] || 0) + 1);

            if (city) stats.cities[city] = (stats.cities[city] || 0) + 1;
        });

        const sourceData = Object.entries(stats.sources)
            .sort((a,b) => b[1]-a[1])
            .map(([name,count]) => ['Source', name, count]);

        const cityData = Object.entries(stats.cities)
            .sort((a,b) => b[1]-a[1])
            .map(([name,count]) => ['City', name, count]);

        return [
            ['General','Total Contacts', stats.totalContacts],
            ['---','---','---'],
            ...sourceData,
            ['---','---','---'],
            ...cityData
        ];
    }

    // --- Initialize Stats Spreadsheet ---
    window.statsSheet = new Spreadsheet('statsSpreadsheet', {
        data: calculateStats(data),
        columns: [
            { title: 'Type', readOnly: true },
            { title: 'Name', readOnly: true },
            { title: 'Count', readOnly: true }
        ],
        editable: false
    });

    // --- Initialize Master Spreadsheet ---
    window.sheet = new Spreadsheet('masterSpreadsheet', {
        data: data.map(d => d.cells),
        columns: columns,
        editable: true,
        onAfterChange: function(changes) {
            if (!changes) return;
            const status = document.getElementById('saveStatus');
            status.innerText = "Saving changes...";

            const change = changes[0];
            const colTitle = columns[change.col].title;

            // Determine contact index if column is contact-related
            let contactIndex = null;
            let contactField = null;
            if (colTitle.startsWith('contact_name') || colTitle.startsWith('designation') ||
                colTitle.startsWith('mobile_') || colTitle.startsWith('email_')) {
                if (colTitle.match(/\d+$/)) {
                    contactIndex = parseInt(colTitle.match(/\d+$/)[0], 10) - 1;
                } else {
                    contactIndex = 0;
                }
                if (colTitle.startsWith('contact_name')) contactField = 'name';
                if (colTitle.startsWith('designation')) contactField = 'designation';
                if (colTitle.startsWith('mobile_')) contactField = 'mobiles';
                if (colTitle.startsWith('email_')) contactField = 'emails';
            }

            fetch('<?= base_url('company/update_cell') ?>', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    company_id: data[change.row].id,
                    contact_ids: data[change.row].contact_ids,
                    column: colTitle,
                    newValue: change.newValue,
                    contactIndex: contactIndex,
                    contactField: contactField
                })
            })
            .then(res => res.json())
            .then(resData => {
                status.innerText = "All changes saved.";
                setTimeout(() => { status.innerText = ""; }, 2000);
            })
            .catch(err => {
                status.innerText = "Error saving!";
                console.error(err);
            });
        }
    });

    // --- Search ---
    document.getElementById('tableSearch').addEventListener('keyup', function() {
        window.sheet.search(this.value);
    });

});
</script>

<h3 style="margin-top: 30px;">Data Statistics</h3>
<div id="statsSpreadsheet"></div>