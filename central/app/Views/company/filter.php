<style>
/* Make toolbar flex wrap */
.filter-toolbar {
    margin-bottom: 20px;
    display: flex;
    flex-wrap: wrap;       /* Allow items to wrap to next line */
    align-items: center;
    background: #ffffff;
    padding: 12px 20px;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    border: 1px solid #e0e0e0;
    gap: 10px;             /* spacing between items */
}

/* Breadcrumb section */
.breadcrumb-container {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-shrink: 1;        /* prevent overflow */
    min-width: 0;          /* allow truncation */
}

.breadcrumb-main {
    text-transform: uppercase;
    font-size: 0.75rem;
    font-weight: 700;
    color: #95a5a6;
    letter-spacing: 1px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.breadcrumb-sub {
    font-weight: 600;
    color: #2c3e50;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* Divider */
.divider {
    height: 24px;
    width: 1px;
    background: #ddd;
    margin: 0 10px;
    flex-shrink: 0;
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
    flex-shrink: 0;
}

.btn-home:hover {
    background: #0056b3;
}

/* Filter group */
.filter-group {
    display: flex;
    gap: 6px;
    flex-wrap: wrap;        /* wrap dropdowns if needed */
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

/* Apply button */
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
    flex-shrink: 0;
}

.btn-apply:hover {
    opacity: 0.9;
}

/* Search container */
.search-container {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-left: auto;
    flex-shrink: 0;
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
    transition: width 0.3s;
}

.search-input:focus {
    width: 250px;
    border-color: #007bff;
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

/* Responsive adjustments */
@media (max-width: 1024px) {
    .filter-toolbar {
        gap: 8px;
        padding: 10px;
    }
    .search-input {
        width: 150px;
    }
    .search-input:focus {
        width: 200px;
    }
}

@media (max-width: 768px) {
    .filter-toolbar {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }
    .search-container {
        margin-left: 0;
        width: 100%;
    }
    .filter-group {
        width: 100%;
        flex-wrap: wrap;
    }
}
</style>

<?php 
$uri = service('uri');

$segments = [];

for ($i = 2; $i <= 5; $i++) {
    $seg = $uri->getSegment($i);
    if ($seg) {
        $segments[] = $seg;
    }
}

// // store
$data['segments'] = $segments;

// // print
// foreach ($segments as $key => $value) {
//     echo "Segment " . ($key + 2) . ": " . esc($value) . "<br>";
// }

$mainLabel = $uri->getSegment(2, '').' '. $uri->getSegment(3, ''); 
$subLabel = $uri->getSegment(4);
// // ADD ONE OF THESE:
// var_dump($mainLabel, $subLabel);   // detailed
// // OR
// echo $mainLabel . ' | ' . $subLabel;  // quick check
// // 
// dd($mainLabel, $subLabel);  // CodeIgniter/Laravel die-dump
 
 
 
 ?>
<div class="filter-toolbar">

<?php if ($mainLabel): ?>
    <div class="breadcrumb-container">
        <span class="breadcrumb-main"><?= esc($mainLabel) ?></span>
        <?php if ($subLabel): ?>
            <span style="color: #bdc3c7;">&rsaquo;</span>
            <span class="breadcrumb-sub">
                <?php
                // Only show subLabel if there are at least 4 URI segments

    $entrytype = $uri->getSegment(2);
    $bystateordatabase = $uri->getSegment(3);
    $value = $uri->getSegment(4);
    echo '<a href="' . base_url('company/download/' .$entrytype.'/'. $bystateordatabase . '/' . $value) . '">'
        . str_replace(['-', '-and-'], [' ', ' & '], $value)
        . '</a>';

                ?>
            </span>
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
