<style>

/* Theme Variables */
:root{
    --nav-color: #a82324;
    --nav-color-dim: #c45a5b;

    --body-color: #f8f4f4;
    --body-color-dim: #fbf9f9;

    --button-color: #a82324;
    --button-color-dim: #c45a5b;

    --text-color: #ffffff;
    --text-color-dim: #dcdcdc;
}

/* Toolbar Container */
.filter-toolbar{
    margin-bottom:18px;
    display:flex;
    flex-wrap:nowrap;
    align-items:center;

    background:var(--body-color);
    padding:6px 12px;
    border-radius:8px;

    border:1px solid #e4dede;

    gap:8px;
    overflow-x:auto;

    scrollbar-width:none;
}

.filter-toolbar::-webkit-scrollbar{
    display:none;
}

/* Groups */
.breadcrumb-container,
.filter-group,
.search-container{
    display:flex;
    align-items:center;
    gap:6px;
    flex-shrink:0;
}

/* Breadcrumb */
.breadcrumb-main{
    font-size:12px;
    font-weight:700;
    color:var(--nav-color-dim);
}

.breadcrumb-sub a{
    font-size:13px;
    color:var(--nav-color);
    text-decoration:none;
    font-weight:600;
    white-space:nowrap;
}

/* Divider */
.divider{
    height:18px;
    width:1px;
    background:#ddd;
}

/* Home Button */
.btn-home{
    padding:5px 10px;
    background:var(--nav-color);
    color:var(--text-color);
    text-decoration:none;
    border-radius:5px;

    font-size:13px;
    display:flex;
    align-items:center;
    gap:4px;

    transition:.2s;
}

.btn-home:hover{
    background:var(--nav-color-dim);
}

/* Select filters */
.filter-select{

    padding:5px 8px;
    border:1px solid #ddd;
    border-radius:4px;

    background:#fff;
    font-size:12px;

    cursor:pointer;

    max-width:120px;
}

.filter-select:focus{
    border-color:var(--nav-color);
}

/* Apply Button */
.btn-apply{

    padding:5px 12px;

    background:var(--button-color);
    color:var(--text-color);

    border:none;
    border-radius:4px;

    cursor:pointer;

    font-weight:600;
    font-size:12px;
}

.btn-apply:hover{
    background:var(--button-color-dim);
}

/* Search */
.search-container{
    width:100%;
}

.search-wrapper{
    position:relative;
    width:100%;
}

.search-input{

width: 100%;
    padding:5px 8px 5px 0px;

    border:1px solid #ddd;
    border-radius:15px;

    font-size:12px;
}

.search-icon{

    position:absolute;
    left:60px;
    top:50%;
    transform:translateY(-50%);
    font-size:12px;
    color:#aaa;
}

.save-status{
    font-size:11px;
    color:var(--button-color);
}

</style>


<div class="filter-toolbar">

    <!-- Breadcrumb -->

<!-- Home -->
<a href="<?= base_url('company') ?>" class="btn-home">
    <span>⌂</span> Home
</a>

<div class="divider"></div>

<!-- Dropdowns -->
<select id="selEntrytype" class="filter-select">
    <option value="">Entry Type</option>
    <?php foreach($entry_types as $et): ?>
        <option value="<?= esc($et) ?>"><?= esc($et) ?></option>
    <?php endforeach; ?>
</select>

<select id="selDatabase" class="filter-select">
    <option value="">Database</option>
    <?php foreach($databases as $db): ?>
        <option value="<?= esc($db) ?>"><?= esc($db) ?></option>
    <?php endforeach; ?>
</select>

<select id="selCategory" class="filter-select">
    <option value="">Category</option>
    <?php foreach($categories as $cat): ?>
        <option value="<?= esc($cat) ?>"><?= esc($cat) ?></option>
    <?php endforeach; ?>
</select>

<select id="selSource" class="filter-select">
    <option value="">Source</option>
    <?php foreach($sources as $src): ?>
        <option value="<?= esc($src) ?>"><?= esc($src) ?></option>
    <?php endforeach; ?>
</select>

<select id="selState" class="filter-select">
    <option value="">State</option>
    <?php foreach($states as $st): ?>
        <option value="<?= esc($st) ?>"><?= esc($st) ?></option>
    <?php endforeach; ?>
</select>

<select id="selCity" class="filter-select">
    <option value="">City</option>
    <?php foreach($cities as $ct): ?>
        <option value="<?= esc($ct) ?>"><?= esc($ct) ?></option>
    <?php endforeach; ?>
</select>

<select id="selComment" class="filter-select">
    <option value="">Comment</option>
    <?php foreach($comments as $cm): ?>
        <option value="<?= esc($cm) ?>"><?= esc($cm) ?></option>
    <?php endforeach; ?>
</select>

    <a id="applyFilters" href="#">Apply</a>

<!-- Apply link -->

<!-- Script -->



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




</div>










<div class="search-container">

    <div class="search-wrapper">
        <span class="search-icon">🔍</span>
        <input type="text" id="tableSearch" class="search-input" placeholder="Search...">
    </div>
    <span id="saveStatus" class="save-status"></span>
</div>
