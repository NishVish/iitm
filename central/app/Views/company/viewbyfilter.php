<?php include(APPPATH . 'Views/company/side.php'); ?>





<div class="filter-header">
    <div class="filters">
        <label>
            Entry Type (Static)
            <select id="selEntrytype" class="filter-select">
                <option value="">All</option>
                <?php foreach($entry_types as $et): ?>
                    <option value="<?= esc($et) ?>"><?= esc($et) ?></option>
                <?php endforeach; ?>
            </select>
        </label>

        <label>
            Database (Dynamic)
            <select id="selDatabase" class="filter-select">
                <option value="">All</option>
                <?php foreach($databases as $db): ?>
                    <option value="<?= esc($db) ?>"><?= esc($db) ?></option>
                <?php endforeach; ?>
            </select>
        </label>

        <a id="applyFilters" href="#" class="btn-apply">Apply Filters</a>
    </div>
</div>

<hr>

<?php
$cardMapping = [
    'States'     => ['id' => 'selState',    'data' => $states,     'count' => $totalUniqueStates],
    'Cities'     => ['id' => 'selCity',     'data' => $cities,     'count' => $totalUniqueCities],
    'Sources'    => ['id' => 'selSource',   'data' => $sources,    'count' => $totalUniqueSources], // Uses sales_person
    'Categories' => ['id' => 'selCategory', 'data' => $categories, 'count' => $totalUniqueCategories],
    'Comments'   => ['id' => 'selComment',  'data' => $comments,   'count' => $totalUniqueComments],
];
?>

<div class="summary-cards">
    <?php foreach ($cardMapping as $label => $info): ?>
        <div class="card">
            <div class="card-title"><?= $label ?></div>
            
            <select id="<?= $info['id'] ?>" class="filter-select">
                <option value=""><?= rtrim($label, 's') ?></option>
                <?php foreach (($info['data'] ?? []) as $val): ?>
                    <option value="<?= esc($val) ?>"><?= esc($val) ?></option>
                <?php endforeach; ?>
            </select>

            <div id="count-<?= $info['id'] ?>" class="card-value">
                <?= $info['count'] ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<script>
// IDs must match exactly what the Controller expects
const dropdownIds = ['selEntrytype', 'selDatabase', 'selCategory', 'selSource', 'selState', 'selCity', 'selComment'];
const applyLink = document.getElementById('applyFilters');

/**
 * 1. Sync Logic
 */
async function syncFilters(changedId = null) {
    let formData = new FormData();
    dropdownIds.forEach(id => {
        const el = document.getElementById(id);
        if (el) formData.append(id, el.value);
    });

    try {
        let response = await fetch('<?= base_url("company/getDynamicFilters") ?>', {
            method: 'POST',
            body: formData
        });
        
        let data = await response.json();

        dropdownIds.forEach(id => {
            // Update Counts
            const countEl = document.getElementById('count-' + id);
            if (countEl) countEl.innerText = data.counts[id] || 0;

            // Update Options (Skip EntryType and currently changed dropdown)
            if (id !== changedId && id !== 'selEntrytype') {
                const select = document.getElementById(id);
                if (!select || !data.options[id]) return;

                const currentVal = select.value;
                const placeholder = select.options[0].text; 

                let newHtml = `<option value="">${placeholder}</option>`;
                data.options[id].forEach(val => {
                    const isSelected = (val === currentVal) ? 'selected' : '';
                    newHtml += `<option value="${val}" ${isSelected}>${val}</option>`;
                });
                select.innerHTML = newHtml;
            }
        });

        updateApplyHref();
    } catch (e) {
        console.error("Sync Error:", e);
    }
}

/**
 * 2. URL Builder (Fixed Double Slashes)
 */
function updateApplyHref() {
    const segments = dropdownIds.map(id => {
        const el = document.getElementById(id);
        const val = el ? el.value.trim() : 'all';
        return (val === '') ? 'all' : encodeURIComponent(val.replace(/&/g, 'and'));
    });

    const finalPath = segments.join('/');
    // Clean base URL to prevent // errors
    const baseUrl = '<?= rtrim(base_url("company"), "/") ?>';
    applyLink.href = baseUrl + '/' + finalPath;
}

/**
 * 3. Local Storage & Initialization
 */
function saveToLocalStorage() {
    dropdownIds.forEach(id => {
        localStorage.setItem('filter_' + id, document.getElementById(id).value);
    });
}

function loadFromLocalStorage() {
    dropdownIds.forEach(id => {
        const savedVal = localStorage.getItem('filter_' + id);
        const element = document.getElementById(id);
        if (savedVal !== null && element) element.value = savedVal;
    });
}

document.addEventListener('DOMContentLoaded', () => {
    loadFromLocalStorage();
    syncFilters(); // Initial sync to catch up on load

    document.querySelectorAll('.filter-select').forEach(sel => {
        sel.addEventListener('change', (e) => {
            saveToLocalStorage();
            syncFilters(e.target.id);
        });
    });
});
</script>

<style>
/* Basic layout to keep filters in header and cards below */
.filter-header { background: #f4f4f4; padding: 20px; margin-bottom: 20px; border-radius: 8px; }
.filters { display: flex; gap: 20px; align-items: flex-end; flex-wrap: wrap; }
.summary-cards { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; }
.card { border: 1px solid #ddd; padding: 15px; border-radius: 8px; text-align: center; background: #fff; }
.card-title { font-weight: bold; margin-bottom: 10px; color: #555; }
.card-value { font-size: 24px; font-weight: bold; margin-top: 10px; color: #007bff; }
.btn-apply { background: #28a745; color: #fff; padding: 8px 16px; border-radius: 4px; text-decoration: none; }
</style>