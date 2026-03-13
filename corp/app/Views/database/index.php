<?php include(APPPATH . 'Views/database/side.php'); ?>
<div style="max-width:1300px">
<div class="page-container">
    <div class="page-header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h1>Company Database: <?= esc($state ? ucwords(str_replace('-', ' ', $state)) : 'All States') ?></h1>
            <button id="toggleBtn" class="state-btn">Show Company Form</button>
        </div>

        <div id="companyFormSection" style="display:none; border:2px solid #a82324; padding:15px; border-radius:12px; margin-top:10px; background:#fff;">
            <?= view('company/insert_company_form') ?>
        </div>
    </div>

    <div class="filter-section" style="padding: 20px;">
        <h3>Filter by State</h3>
        <div id="states" style="display: flex; flex-wrap: wrap; gap: 8px;">
            <a href="<?= base_url('database') ?>" 
               class="state-btn <?= empty($state) ? 'active' : '' ?>">
               All
            </a>

            <?php foreach($states as $s): ?>
                <?php 
                    $slug = str_replace(' ', '-', strtolower($s['state'])); 
                ?>
                <a href="<?= base_url('database/' . $slug) ?>" 
                   class="state-btn <?= (strtolower($state ?? '') === $slug) ? 'active' : '' ?>">
                    <?= esc($s['state']) ?>
                </a>
            <?php endforeach; ?>
        </div>

        <?php if (!empty($cities)): ?>
            <h3 style="margin-top:20px;">Filter by City</h3>
            <div id="cities-container" style="display: flex; flex-wrap: wrap; gap: 8px; margin-top: 10px;">
                <button class="city-btn active" data-city="">All Cities</button>
                <?php foreach($cities as $c): ?>
                    <button class="city-btn" data-city="<?= esc($c['city']) ?>"><?= esc($c['city']) ?></button>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <div style="margin: 20px; display: flex; justify-content: space-between; align-items: center;">
        <div style="display: flex; gap: 10px; align-items: center;">
            <input type="text" id="tableSearch" placeholder="Search across all fields..." 
                   style="width:350px; padding:10px; border: 1px solid #ddd; border-radius: 8px; box-shadow: inset 0 1px 3px rgba(0,0,0,0.1);">
            <span id="saveStatus" style="font-weight: bold; color: #a82324;"></span>
        </div>
        <div>
            <button id="exportExcel" class="state-btn" style="background: #217346; color: white; border: none;">Export to Excel</button>
        </div>
    </div>

    <div id="masterSpreadsheet" style="margin: 0 20px 50px 20px;"></div>
</div>

</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // --- Logic for Column Generation ---
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
        columns.push({ title: 'mobile_<?= ($i*2)-1 ?>', width: 120 });
        columns.push({ title: 'mobile_<?= ($i*2) ?>', width: 120 });
        columns.push({ title: 'email_<?= ($i*2)-1 ?>', width: 180 });
        columns.push({ title: 'email_<?= ($i*2) ?>', width: 180 });
    <?php endfor; ?>

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

    window.sheet = new Spreadsheet('masterSpreadsheet', {
        data: rawData.map(d => d.cells),
        columns: columns,
        editable: true,
        onAfterChange: function(changes) {
            if (!changes) return;
            saveCellChange(changes, rawData);
        }
    });

    // --- City Filter Integration ---
    document.querySelectorAll('.city-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const city = this.dataset.city;
            document.querySelectorAll('.city-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            // Spreadsheet native search works perfectly for quick city filtering
            window.sheet.search(city);
        });
    });

    document.getElementById('tableSearch').addEventListener('keyup', function() {
        window.sheet.search(this.value); 
    });

    const toggleBtn = document.getElementById('toggleBtn');
    const formSection = document.getElementById('companyFormSection');
    toggleBtn.addEventListener('click', () => {
        const isHidden = formSection.style.display === 'none';
        formSection.style.display = isHidden ? 'block' : 'none';
        toggleBtn.textContent = isHidden ? 'Hide Company Form' : 'Show Company Form';
    });
});

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
    .then(res => {
        status.innerText = "Saved";
        setTimeout(() => { status.innerText = ""; }, 1500);
    })
    .catch(err => {
        status.innerText = "Error!";
        console.error(err);
    });
}
</script>