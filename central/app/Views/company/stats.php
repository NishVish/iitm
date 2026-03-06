
<?php
// Sort data so highest counts appear first
arsort($stateCounts);
arsort($cityCounts);
arsort($sourceCounts);
arsort($categoryCounts);

// Calculate totals for the summary cards
$totalUniqueStates     = count($stateCounts);
$totalUniqueCities     = count($cityCounts);
$totalUniqueSources    = count($sourceCounts);
$totalUniqueCategories = count($categoryCounts);

$totalUniqueCategories = count($categoryCounts);
$totalUniqueComments   = count($commentCounts);

// Sort them so the most frequent ones are at the top
arsort($categoryCounts);
arsort($commentCounts);
?>

<style>
    :root {
        --nav-color: #a82324;
        --nav-color-dim: #c45a5b;
        --body-color: #f8f4f4;
        --body-color-dim: #fbf9f9;
        --button-color: #a82324;
        --button-color-dim: #c45a5b;
        --text-color: #ffffff;
        --text-color-dim: #dcdcdc;
        --border-color: #e2e8f0;
        --dark-text: #1e293b;
    }

    .master-wrapper {
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
        background: var(--body-color);
        padding: 20px;
        border-radius: 12px;
    }

    /* The Top Total Counts Table */
    .totals-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
        background: var(--nav-color);
        color: var(--text-color);
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(168, 35, 36, 0.2);
    }

    .totals-table th {
        padding: 15px;
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: 1px;
        color: var(--text-color-dim);
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }

    .totals-table td {
        padding: 15px;
        text-align: center;
        font-size: 1.8rem;
        font-weight: 800;
        color: var(--text-color);
    }

    /* The Main Data Grid Table */
    .main-grid-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 15px 0;
        table-layout: fixed;
    }

    .main-grid-table > tbody > tr > td {
        vertical-align: top;
        background: var(--body-color);
        border-radius: 12px;
        padding: 0;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        border: 1px solid var(--border-color);
    }

    /* Sub-tables inside each column */
    .inner-table {
        width: 100%;
        border-collapse: collapse;
    }

    .inner-table thead th {
        background: var(--nav-color);
        padding: 12px;
        text-align: left;
        border-radius: 10px 10px 0 0;
        font-size: 13px;
        color: var(--text-color);
        border-bottom: 2px solid var(--border-color);
        position: sticky;
        top: 0;
        z-index: 1;
    }

    .inner-table td {
        padding: 10px 12px;
        font-size: 15px;
        border-bottom: 1px solid var(--body-color);
            color: var(--text-color);

    }
    .inner-table td a{
        
            color: var(--text-color);

    }

    .inner-table tr:hover { 
        background: var(--body-color-dim); 
    }

    /* Count Badge using your Button Color */
    .badge {
        background: var(--body-color);
        color: var(--text-color);
        padding: 2px 8px;
        font-weight: 700;
        font-size: 11px;
        float: right;
        border: none;
    }

    /* Scrollable container */
    .scroll-box {
        max-height: 800px;
        overflow-y: auto;
    }

    /* Custom Scrollbar for better UI */
    .scroll-box::-webkit-scrollbar {
        width: 6px;
    }
    .scroll-box::-webkit-scrollbar-thumb {
        background: var(--nav-color-dim);
        border-radius: 10px;
    }
</style>

<div class="master-wrapper">

    <table class="totals-table">
        <thead>
            <tr>
                <th>States</th>
                <th>Cities</th>
                <th>Sources</th>
                <th>Categories</th>
                <th>Comments</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?= $totalUniqueStates ?></td>
                <td><?= $totalUniqueCities ?></td>
                <td><?= $totalUniqueSources ?></td>
                <td><?= $totalUniqueCategories ?></td>
                <td><?= $totalUniqueComments ?></td>
            </tr>
        </tbody>
    </table>
<?php

$uri = service('uri');
$first  = (string) ($uri->getSegment(1) ?? '');

        $second = (string) ($uri->getSegment(2) ?? '');

if($first !="all"){ 
$third  = (string) ($uri->getSegment(2) ?? '');
}else{
    $third = (string) ($uri->getSegment(3) ?? '');
}


// // Use getSegment() with a 1-based index to get the string directly
// if($first !="all"){

// $third  = (string) ($uri->getSegment(3) ?? '');

// }else{
//     $second = (string) ($uri->getSegment(3) ?? '');
// }


var_dump($first, $second, $third);
echo $first,    $second,    $third;
?>
    <table class="main-grid-table">
        <tbody>
            <tr>
                <td>
                    <div class="scroll-box">
                        <table class="inner-table">
                            <thead><tr><th>State Name</th></tr></thead>
                            <?php foreach ($stateCounts as $name => $count): ?>
                                <tr><td><a href="<?= base_url() ."company/".$third."/" . "state/" . urlencode(str_replace(' ', '-', $name))?>"><?= htmlspecialchars($name) ?> <span class="badge"><?= $count ?></span></a></td></tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                </td>

                <td>
                    <div class="scroll-box">
                        <table class="inner-table">
                            <thead><tr><th>City Name</th></tr></thead>
                            <?php foreach ($cityCounts as $name => $count): ?>
                                <tr><td><a href="<?= base_url() ."company/".$third."/" . "city/" . urlencode(str_replace(' ', '-', $name))?>"><?= htmlspecialchars($name) ?> <span class="badge"><?= $count ?></span></a></td></tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                </td>

                <td>
                    <div class="scroll-box">
                        <table class="inner-table">
                            <thead><tr><th>Source</th></tr></thead>
                            <?php foreach ($sourceCounts as $name => $count): ?>
                                <tr><td><a href="<?= base_url() ."company/".$third."/" . "source/" . urlencode(str_replace(' ', '-', $name))?>"><?= htmlspecialchars($name) ?> <span class="badge"><?= $count ?></span></a></td></tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                </td>

                <td>
                    <div class="scroll-box">
                        <table class="inner-table">
                            <thead><tr><th>Category</th></tr></thead>
                            <?php foreach ($categoryCounts as $name => $count): ?>
                                <tr><td><a href="<?= base_url() ."company/".$third."/" . "category/" . urlencode(str_replace(' ', '-', $name))?>"><?= htmlspecialchars($name) ?> <span class="badge"><?= $count ?></span></a></td></tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                </td>

                <td>
                    <div class="scroll-box">
                        <table class="inner-table">
                            <thead><tr><th>Comment</th></tr></thead>
                            <?php foreach ($commentCounts as $name => $count): ?>
                                <tr><td>
                                    <div style="max-width:180px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;" title="<?= htmlspecialchars($name) ?>">
                                <tr><td><a href="<?= base_url() ."company/".$third."/" . "last_comments/" . urlencode(str_replace(' ', '-', $name))?>"><?= htmlspecialchars($name) ?> <span class="badge"><?= $count ?></span></a></td></tr>
                                    </div>
                                    <span class="badge"><?= $count ?></span>
                                </td></tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>

</div>