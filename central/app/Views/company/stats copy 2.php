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
        </label>

    <a id="applyFilters" href="#">Apply</a>

    </div>

</div>

</div>
<div class="master-wrapper">

<!-- SUMMARY -->
<div class="summary-cards">

<div class="card">
<div class="card-title">States</div>


<select id="selState" class="filter-select">
    <option value="">State</option>
    <?php foreach($states as $st): ?>
        <option value="<?= esc($st) ?>"><?= esc($st) ?></option>
    <?php endforeach; ?>
</select>


<div class="card-value"><?= $totalUniqueStates ?></div>
</div>

<div class="card">
<div class="card-title">Cities</div>


<select id="selCity" class="filter-select">
    <option value="">City</option>
    <?php foreach($cities as $ct): ?>
        <option value="<?= esc($ct) ?>"><?= esc($ct) ?></option>
    <?php endforeach; ?>
</select>


<div class="card-value"><?= $totalUniqueCities ?></div>
</div>

<div class="card">
<div class="card-title">Sources</div>

<select id="selSource" class="filter-select">
    <option value="">Source</option>
    <?php foreach($sources as $src): ?>
        <option value="<?= esc($src) ?>"><?= esc($src) ?></option>
    <?php endforeach; ?>
</select>



<div class="card-value"><?= $totalUniqueSources ?></div>
</div>

<div class="card">
<div class="card-title">Categories</div>
<select id="selCategory" class="filter-select">
    <option value="">Category</option>
    <?php foreach($categories as $cat): ?>
        <option value="<?= esc($cat) ?>"><?= esc($cat) ?></option>
    <?php endforeach; ?>
</select>

<div class="card-value"><?= $totalUniqueCategories ?></div>
</div>

<div class="card">
<div class="card-title">Comments</div>



<select id="selComment" class="filter-select">
    <option value="">Comment</option>
    <?php foreach($comments as $cm): ?>
        <option value="<?= esc($cm) ?>"><?= esc($cm) ?></option>
    <?php endforeach; ?>
</select>


<div class="card-value"><?= $totalUniqueComments ?></div>
</div>

</div>


<script>

    
const applyLink = document.getElementById('applyFilters');
const dropdownIds = [
    'selEntrytype',
    'selDatabase',
    'selCategory',
    'selSource',
    'selState',
    'selCity',
    'selComment'
];

/**
 * Saves all current dropdown values to localStorage
 */
function saveToLocalStorage() {
    dropdownIds.forEach(id => {
        const val = document.getElementById(id).value;
        localStorage.setItem('filter_' + id, val);
    });
}

/**
 * Loads values from localStorage and sets the dropdowns
 */
function loadFromLocalStorage() {
    dropdownIds.forEach(id => {
        const savedVal = localStorage.getItem('filter_' + id);
        if (savedVal !== null) {
            document.getElementById(id).value = savedVal;
        }
    });
}

/**
 * Constructs the URL for the Apply button
 */
function updateHref() {
    const values = dropdownIds.map(id => {
        const val = document.getElementById(id).value.trim();
        // Convert empty selection to 'all' for the URL segment
        return val === '' ? 'all' : val;
    });

    // Handle "&" to "and" conversion and URL encoding
    const encoded = values.map(v => {
        let clean = v.replace(/&/g, 'and');
        return encodeURIComponent(clean);
    });

    const hrefString = encoded.join('/');
    applyLink.href = '<?= base_url() ?>company/' + hrefString;
}

// 1. Initialize: Load saved values first
loadFromLocalStorage();

// 2. Initialize: Update the link based on loaded values
updateHref();

// 3. Listen to changes
document.querySelectorAll('.filter-select').forEach(sel => {
    sel.addEventListener('change', () => {
        saveToLocalStorage(); // Remember the choice
        updateHref();         // Update the link
    });
});

// Optional: Add a 'Reset' functionality to the Home button or a separate button
// to clear localStorage if the user wants to start over.
document.querySelector('.btn-home').addEventListener('click', () => {
    dropdownIds.forEach(id => localStorage.removeItem('filter_' + id));
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

