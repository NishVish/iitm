<?php
// Sort data
arsort($stateCounts);
arsort($cityCounts);
arsort($sourceCounts);
arsort($categoryCounts);
arsort($commentCounts);

// Totals
$totalUniqueStates     = count($stateCounts);
$totalUniqueCities     = count($cityCounts);
$totalUniqueSources    = count($sourceCounts);
$totalUniqueCategories = count($categoryCounts);
$totalUniqueComments   = count($commentCounts);

$uri = service('uri');
$third = 'none';
?>

<style>
/* PAGE WRAPPER */

variables
    /* Main colors */
    --nav-color: #a82324;
    --nav-color-dim: #c45a5b;

    --body-color: #f8f4f4;
    --body-color-dim: #fbf9f9;

    --button-color: #a82324;
    --button-color-dim: #c45a5b;

    --text-color: #ffffff;
    --text-color-dim: #dcdcdc;


.master-wrapper{
font-family:'Inter',system-ui,-apple-system,sans-serif;
background:var(--body-color);
padding:20px;
border-radius:12px;
}

/* SUMMARY CARDS */

.summary-cards{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(160px,1fr));
gap:18px;
margin-bottom:25px;
}

.card{
background:var(--nav-color);
color:var(--text-color);
padding:20px;
border-radius:10px;
text-align:center;
box-shadow:0 4px 10px rgba(0,0,0,.08);
}

.card-title{
font-size:12px;
text-transform:uppercase;
letter-spacing:1px;
color:var(--text-color);
}

.card-value{
font-size:30px;
font-weight:800;
margin-top:6px;
}

/* GRID LAYOUT */

.dashboard-grid{
display:grid;
grid-template-columns:repeat(5,1fr);
gap:15px;
}

/* LIST PANEL */

.list-box{
background:var(--text-color);
border-radius:10px;
display:flex;
flex-direction:column;
overflow:hidden;
box-shadow:0 2px 8px rgba(0,0,0,.05);
}

/* PANEL HEADER */

.list-box h3{
background:var(--nav-color);
color:var(--text-color);
padding:12px;
margin:0;
font-size:14px;
letter-spacing:.5px;
}

/* SCROLL AREA */

.scroll{
max-height:700px;
overflow-y:auto;
overflow-x:hidden;
}

.scroll::-webkit-scrollbar{
width:6px;
}

.scroll::-webkit-scrollbar-thumb{
background:var(--button-color);
border-radius:10px;
}

/* LIST ITEMS */

.list-item{
display:flex;
justify-content:space-between;
align-items:center;
padding:10px 12px;
text-decoration:none;
color:var(--nav-color);
border-bottom:1px solid var(--body-color);
font-size:14px;
transition:background .2s ease;
}

.list-item:hover{
background:var(--body-color-dim);
}

/* COUNT BADGE */

.list-item span{
font-weight:700;
background:var(--button-color);
color:var(--text-color);
padding:2px 8px;
border-radius:6px;
font-size:12px;
}

/* COMMENT TEXT TRUNCATION */

.truncate{
max-width:160px;
overflow:hidden;
text-overflow:ellipsis;
white-space:nowrap;
}

/* RESPONSIVE */

@media(max-width:1200px){
.dashboard-grid{
grid-template-columns:repeat(3,1fr);
}
}

@media(max-width:800px){
.dashboard-grid{
grid-template-columns:repeat(2,1fr);
}
}

@media(max-width:500px){
.dashboard-grid{
grid-template-columns:1fr;
}
}

.filter-bar{
background:white;
padding:15px;
border-radius:12px;
box-shadow:var(--shadow-soft);
margin-bottom:20px;
display:flex;
flex-wrap:wrap;
gap:10px;
align-items:center;
}


</style>
<div class="dashboard-header">
<div class="header-bar">

<style>
    .dashboard-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:15px 20px;
    background:#f5f7fb;
    border-bottom:1px solid #ddd;
}
.header-bar{
    display:flex;
    justify-content:flex-end;
    padding:10px 20px;
    background:#f4f6fa;
    border-bottom:1px solid #ddd;
}

.filters{
    display:flex;
    gap:15px;
    align-items:center;
}

.filters label{
    font-size:14px;
    display:flex;
    flex-direction:column;
}

.filter-select{
    padding:6px 10px;
    border:1px solid #ccc;
    border-radius:4px;
}

#applyFilters{
    padding:7px 14px;
    background:#1e88e5;
    color:white;
    border:none;
    border-radius:4px;
    cursor:pointer;
}
</style>
<!-- 

<div style="margin: 50px; padding: 20px; border: 2px dashed #1e88e5; background: #fff;">
    <h3>Test AJAX Endpoint: company/getDynamicFilters</h3>
    <form id="testFilterForm">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
            <label>Entry Type: <input type="text" name="selEntrytype" value="Exporter"></label>
            <label>Database: <input type="text" name="selDatabase" value="test_db"></label>
            <label>Category: <input type="text" name="selCategory" value="Textiles"></label>
            <label>Source: <input type="text" name="selSource" value="all"></label>
            <label>State: <input type="text" name="selState" value="Gujarat"></label>
            <label>City: <input type="text" name="selCity" value="Rajkot"></label>
            <label>Comment: <input type="text" name="selComment" value="all"></label>
        </div>
        <button type="submit" style="margin-top: 15px; padding: 10px; background: #1e88e5; color: white; border: none; cursor: pointer;">
            Send AJAX Request
        </button>
    </form>

    <div style="margin-top: 20px;">
        <strong>Server Response:</strong>
        <pre id="testResponse" style="background: #eee; padding: 10px; border-radius: 5px; min-height: 50px; overflow: auto;"></pre>
    </div>
</div>

<script>
document.getElementById('testFilterForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const responseBox = document.getElementById('testResponse');
    responseBox.innerText = "Sending...";

    const formData = new FormData(this);

    try {
        const response = await fetch('<?= base_url("company/getDynamicFilters") ?>', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest' // Helps CI4 identify AJAX
            }
        });

        if (!response.ok) {
            const errorText = await response.text();
            responseBox.innerText = "Error " + response.status + ":\n" + errorText;
            return;
        }

        const data = await response.json();
        responseBox.innerText = JSON.stringify(data, null, 4);
    } catch (err) {
        responseBox.innerText = "Fetch Error: " + err.message;
    }
});
</script> -->

    
<div class="filters">
        <label>
            Entry Type
            <select id="selEntrytype" class="filter-select">
                <option value="">All</option>
                <?php foreach($entry_types as $et): ?>
                    <option value="<?= esc($et) ?>"><?= esc($et) ?></option>
                <?php endforeach; ?>
            </select>
        </label>

        <label>
            Database
            <select id="selDatabase" class="filter-select">
                <option value="">All</option>
                <?php foreach($databases as $db): ?>
                    <option value="<?= esc($db) ?>"><?= esc($db) ?></option>
                <?php endforeach; ?>
            </select>
            <span id="count-selDatabase" style="display:none;"></span>
        </label>

        <a id="applyFilters" href="#" class="btn-apply">Apply</a>
    </div>
</div>

</div>
<div class="master-wrapper">


<?php
// Define the mapping between Display Label => [Select ID, PHP Variable, Count Variable]
$cardMapping = [
    'States'     => ['id' => 'selState',    'data' => $states,     'count' => $totalUniqueStates],
    'Cities'     => ['id' => 'selCity',     'data' => $cities,     'count' => $totalUniqueCities],
    'Sources'    => ['id' => 'selSource',   'data' => $sources,    'count' => $totalUniqueSources],
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
            <div id="count-<?= $info['id'] ?>" class="card-value"><?= $info['count'] ?></div>
        </div>
    <?php endforeach; ?>
</div>
<script>
/**
 * Configuration: All dropdown IDs in the exact order 
 * required by your PHP Controller Route.
 */
const dropdownIds = [
    'selEntrytype',     
    'selDatabase',
    'selCategory',
    'selSource',
    'selState',
    'selCity',
    'selComment'
];

const applyLink = document.getElementById('applyFilters');

/**
 * 1. MASTER SYNC FUNCTION (AJAX)
 * Fetches updated options and counts from the server.
 */

async function syncFilters(changedId = null) {
    let formData = new FormData();
    
    // 1. Collect current values from ALL dropdowns
    dropdownIds.forEach(id => {
        const el = document.getElementById(id);
        if (el) formData.append(id, el.value);
    });

    try {
        // 2. Fetch the updated data from the server
        let response = await fetch('<?= base_url("company/getDynamicFilters") ?>', {
            method: 'POST',
            body: formData
        });
        
        if (!response.ok) throw new Error('Network response was not ok');
        let data = await response.json();

        // 3. Update the UI in ONE clean loop
        dropdownIds.forEach(id => {
            // Update the big number in the Summary Cards (if count ID exists)
            const countEl = document.getElementById('count-' + id);
            if (countEl) {
                countEl.innerText = data.counts[id] || 0;
            }

            // Update the dropdown options
            // LOGIC: 
            // - Don't update the one the user just clicked (changedId)
            // - Don't update Entry Type (id === 'selEntrytype')
            if (id !== changedId && id !== 'selEntrytype') {
                const select = document.getElementById(id);
                if (!select || !data.options[id]) return;

                const currentVal = select.value;
                const placeholder = select.options[0].text; 

                // Rebuild the dropdown list
                let newHtml = `<option value="">${placeholder}</option>`;
                data.options[id].forEach(val => {
                    const isSelected = (val === currentVal) ? 'selected' : '';
                    newHtml += `<option value="${val}" ${isSelected}>${val}</option>`;
                });
                select.innerHTML = newHtml;
            }
        });

        // 4. Update the "Apply" button link
        updateApplyHref();

    } catch (e) {
        console.error("Filter sync failed:", e);
    }
}

/**
 * 2. LOCAL STORAGE LOGIC
 * Remembers user choices across page refreshes.
 */
function saveToLocalStorage() {
    dropdownIds.forEach(id => {
        const val = document.getElementById(id).value;
        localStorage.setItem('filter_' + id, val);
    });
}

function loadFromLocalStorage() {
    dropdownIds.forEach(id => {
        const savedVal = localStorage.getItem('filter_' + id);
        const element = document.getElementById(id);
        if (savedVal !== null && element) {
            element.value = savedVal;
        }
    });
}

/**
 * 3. URL BUILDER
 * Constructs the /company/main/all/all... style URL.
 */
function updateApplyHref() {
    const segments = dropdownIds.map(id => {
        const val = document.getElementById(id).value.trim();
        // Use 'all' for empty segments
        if (val === '') return 'all';
        // Convert '&' to 'and' and URL encode
        return encodeURIComponent(val.replace(/&/g, 'and'));
    });

    const finalPath = segments.join('/');
    applyLink.href = '<?= base_url("company") ?>/' + finalPath;
}

/**
 * 4. INITIALIZATION & EVENT LISTENERS
 */
document.addEventListener('DOMContentLoaded', () => {
    // Load what the user picked last time
    loadFromLocalStorage();

    // Trigger initial sync to update counts and cascading options based on load
    syncFilters();

    // Attach "Change" listener to every dropdown
    document.querySelectorAll('.filter-select').forEach(sel => {
        sel.addEventListener('change', (e) => {
            saveToLocalStorage();
            syncFilters(e.target.id);
        });
    });

    // Reset Logic (Optional: bind to a Home or Reset button)
    const btnHome = document.querySelector('.btn-home');
    if (btnHome) {
        btnHome.addEventListener('click', () => {
            dropdownIds.forEach(id => localStorage.removeItem('filter_' + id));
        });
    }
});
</script>
<!-- GRID -->

<div class="dashboard-grid">

<!-- STATES -->
<div class="list-box">
<!-- <h3>States</h3> -->
<div class="scroll">
<?php foreach ($stateCounts as $name => $count): ?>
<a class="list-item" href="<?= base_url().'company/'.$third.'/state/'.urlencode(str_replace(' ','-',$name)) ?>">
<?= htmlspecialchars($name) ?>
<span><?= $count ?></span>
</a>
<?php endforeach; ?>
</div>
</div>


<!-- CITIES -->
<div class="list-box">
<!-- <h3>Cities</h3> -->
<div class="scroll">
<?php foreach ($cityCounts as $name => $count): ?>
<a class="list-item" href="<?= base_url().'company/'.$third.'/city/'.urlencode(str_replace(' ','-',$name)) ?>">
<?= htmlspecialchars($name) ?>
<span><?= $count ?></span>
</a>
<?php endforeach; ?>
</div>
</div>


<!-- SOURCES -->
<div class="list-box">
<!-- <h3>Sources</h3> -->
<div class="scroll">
<?php foreach ($sourceCounts as $name => $count): ?>
<a class="list-item" href="<?= base_url().'company/'.$third.'/source/'.urlencode(str_replace(' ','-',$name)) ?>">
<?= htmlspecialchars($name) ?>
<span><?= $count ?></span>
</a>
<?php endforeach; ?>
</div>
</div>


<!-- CATEGORIES -->
<div class="list-box">
<!-- <h3>Categories</h3> -->
<div class="scroll">
<?php foreach ($categoryCounts as $name => $count): ?>
<a class="list-item" href="<?= base_url().'company/'.$third.'/category/'.urlencode(str_replace(' ','-',$name)) ?>">
<?= htmlspecialchars($name) ?>
<span><?= $count ?></span>
</a>
<?php endforeach; ?>
</div>
</div>


<!-- COMMENTS -->
<div class="list-box">
<!-- <h3>Comments</h3> -->
<div class="scroll">
<?php foreach ($commentCounts as $name => $count): ?>
<a class="list-item" href="<?= base_url().'company/'.$third.'/last_comments/'.urlencode(str_replace(' ','-',$name)) ?>">
<div class="truncate" title="<?= htmlspecialchars($name) ?>">
<?= htmlspecialchars($name) ?>
</div>
<span><?= $count ?></span>
</a>
<?php endforeach; ?>
</div>
</div>

</div>

</div>

