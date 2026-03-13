<?php include(APPPATH . 'Views/database/side.php'); ?>

<style>
    /* 1. Reset and Force App-like Layout */
    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
        overflow: hidden;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #e9ecef;
    }

    /* 2. Main Wrapper — centered, max 1300px */
    .page-container {
        display: flex;
        flex-direction: column;
        height: 100vh;
        width: 100%;
        max-width: 1300px;
        margin: 0 auto;
        background-color: #f8f9fa;
        box-shadow: 0 0 30px rgba(0,0,0,0.12);
    }

    /* 3. Header and Filter Sections */
    .page-header, .filter-section, .controls-row {
        flex-shrink: 0;
        background: #fff;
        padding: 10px 20px;
        border-bottom: 1px solid #dee2e6;
    }

    /* 4. Form Section — scrollable */
    #companyFormSection {
        display: none;
        max-height: 350px;
        overflow-y: auto;
        overflow-x: hidden;
        border: 2px solid #a82324;
        padding: 15px;
        border-radius: 8px;
        margin-top: 10px;
        background: #fff;
    }

    /* 5. Buttons & UI */
    .state-btn, .city-btn {
        padding: 5px 12px;
        margin: 2px;
        border: 1px solid #ccc;
        background: #fff;
        cursor: pointer;
        text-decoration: none;
        color: #333;
        border-radius: 4px;
        font-size: 13px;
        display: inline-block;
    }
    .state-btn.active, .city-btn.active {
        background: #a82324;
        color: #fff;
        border-color: #a82324;
    }

    /* Controls row layout fix */
    .controls-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
    }

    /* 6. THE SCROLLABLE SPREADSHEET AREA */
    #masterSpreadsheet {
        flex-grow: 1;
        overflow: auto; /* both horizontal and vertical scroll internally */
        margin: 15px;
        background: #fff;
        border: 1px solid #ccc;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    h1, h3 { margin: 0; padding: 5px 0; }
    h1 { font-size: 18px; }
</style>

<div class="page-container">
    <div class="page-header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h1>Company Database: <?= esc($state ? ucwords(str_replace('-', ' ', $state)) : 'All States') ?></h1>
            <button id="toggleBtn" class="state-btn">Show Company Form</button>
        </div>
        <div id="companyFormSection">
            <?= view('company/insert_company_form') ?>
        </div>
    </div>

    <div class="filter-section">
        <div id="states">
            <a href="<?= base_url('database') ?>" class="state-btn <?= empty($state) ? 'active' : '' ?>">All</a>
            <?php foreach($states as $s): ?>
                <?php $slug = str_replace(' ', '-', strtolower($s['state'])); ?>
                <a href="<?= base_url('database/' . $slug) ?>" 
                   class="state-btn <?= (strtolower($state ?? '') === $slug) ? 'active' : '' ?>">
                    <?= esc($s['state']) ?>
                </a>
            <?php endforeach; ?>
        </div>

        <?php if (!empty($cities)): ?>
            <div id="cities-container" style="margin-top: 10px; padding-top: 10px; border-top: 1px dashed #eee;">
                <button class="city-btn active" data-city="">All Cities</button>
                <?php foreach($cities as $c): ?>
                    <button class="city-btn" data-city="<?= esc($c['city']) ?>"><?= esc($c['city']) ?></button>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="controls-row">
        <div style="display: flex; gap: 15px; align-items: center;">
            <input type="text" id="tableSearch" placeholder="Search across all fields..." 
                   style="width:350px; padding:8px; border: 1px solid #ddd; border-radius: 6px;">
            <span id="saveStatus" style="font-weight: bold; color: #a82324;"></span>
        </div>
        <button id="exportExcel" class="state-btn" style="background: #217346; color: white;">Export Excel</button>
    </div>

    <div id="masterSpreadsheet"></div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Calculate Columns based on Contacts
    <?php
    $maxContacts = 0;
    foreach ($companies as $comp) {
        $count = count($comp['contacts']);
        if ($count > $maxContacts) $maxContacts = $count;
    }
    if ($maxContacts === 0) $maxContacts = 1;
    ?>

    const columns = [
        { title: 'DB', readOnly: true, width: 80 }, 
        { title: 'category', width: 120 }, 
        { title: 'source', width: 150 },
        { title: 'updated_by', readOnly: true, width: 100 }, 
        { title: 'updated_at', readOnly: true, width: 120 }, 
        { title: 'outbound', width: 80 },
        { title: 'company_name', width: 250 }, 
        { title: 'address_1', width: 300 }, 
        { title: 'city', width: 120 }, 
        { title: 'pincode', width: 100 }, 
        { title: 'state', width: 120 },
        { title: 'phone', width: 150 }
    ];

    <?php for ($i = 1; $i <= $maxContacts; $i++): ?>
        <?php $suffix = ($i === 1) ? '' : "_$i"; ?>
        columns.push({ title: 'contact<?= $suffix ?>', width: 150 });
        columns.push({ title: 'designation<?= $suffix ?>', width: 150 });
        columns.push({ title: 'mobile_<?= ($i*2)-1 ?>', width: 120 }, { title: 'mobile_<?= ($i*2) ?>', width: 120 });
        columns.push({ title: 'email_<?= ($i*2)-1 ?>', width: 180 }, { title: 'email_<?= ($i*2) ?>', width: 180 });
    <?php endfor; ?>

    // 2. Map PHP Data to Spreadsheet Rows
    const rawData = [
        <?php foreach ($companies as $comp): 
            $d = $comp['details'];
            $cList = array_values($comp['contacts']); 
        ?>
        {
            id: '<?= $d['company_id'] ?>',
            contact_ids: <?= json_encode(array_keys($comp['contacts'])) ?>,
            cells: [
                'Main DB', '<?= esc($d['category']) ?>', '<?= esc($d['source_notes']) ?>',
                'Admin', '<?= esc($d['event_date']) ?>', 'Yes',
                '<?= esc($d['company_name']) ?>', '<?= esc($d['address'] ?? '') ?>',
                '<?= esc($d['city']) ?>', '<?= esc($d['pincode'] ?? '') ?>', '<?= esc($d['state']) ?>',
                '<?= esc($d['phone'] ?? '') ?>',
                <?php for ($i = 0; $i < $maxContacts; $i++): $c = $cList[$i] ?? null; ?>
                    '<?= esc($c['name'] ?? '') ?>', '<?= esc($c['designation'] ?? '') ?>',
                    '<?= $c['mobiles'][0] ?? '' ?>', '<?= $c['mobiles'][1] ?? '' ?>',
                    '<?= $c['emails'][0] ?? '' ?>', '<?= $c['emails'][1] ?? '' ?>',
                <?php endfor; ?>
            ]
        },
        <?php endforeach; ?>
    ];

    // 3. Initialize Spreadsheet
    window.sheet = new Spreadsheet('masterSpreadsheet', {
        data: rawData.map(d => d.cells),
        columns: columns,
        editable: true,
        tableOverflow: true,
        height: '100%', 
        onAfterChange: function(changes) {
            if (changes) saveCellChange(changes, rawData);
        }
    });

    // 4. City Filter Buttons
    document.querySelectorAll('.city-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.city-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            window.sheet.search(this.dataset.city);
        });
    });

    // 5. Search Box
    document.getElementById('tableSearch').addEventListener('keyup', function() {
        window.sheet.search(this.value); 
    });

    // 6. Toggle Company Form
    const toggleBtn = document.getElementById('toggleBtn');
    const formSection = document.getElementById('companyFormSection');
    toggleBtn.addEventListener('click', () => {
        const isHidden = formSection.style.display === 'none' || formSection.style.display === '';
        formSection.style.display = isHidden ? 'block' : 'none';
        toggleBtn.textContent = isHidden ? 'Hide Company Form' : 'Show Company Form';
    });
});

// 7. AJAX Save on Cell Change
function saveCellChange(changes, metadata) {
    const status = document.getElementById('saveStatus');
    status.innerText = "Saving...";
    fetch('<?= base_url('company/update_cell') ?>', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            company_id: metadata[changes.row].id,
            contact_ids: metadata[changes.row].contact_ids,
            column: window.sheet.columns[changes.col].title,
            newValue: changes.newValue
        })
    })
    .then(res => res.json())
    .then(() => {
        status.innerText = "Saved ✓";
        setTimeout(() => { status.innerText = ""; }, 1500);
    })
    .catch(() => {
        status.innerText = "Save failed!";
        status.style.color = "red";
        setTimeout(() => { status.innerText = ""; status.style.color = "#a82324"; }, 2000);
    });
}
</script>