
<?= view('dashboard/side') ?>  <!-- loads app/Views/header.php -->

<h1>Dashboard</h1>
<?php
echo "<p>";

// Run ipconfig
$output = shell_exec('ipconfig');

// Search for IPv4 address using regex
if (preg_match('/IPv4 Address[.\s]*:\s*([\d\.]+)/', $output, $matches)) {
    echo $matches[1]."/iitm/central/";
} else {
    echo "IPv4 Address not found";
}

echo "</p>";
?>

<h3>Duplicate Companies</h3>
<?php if (!empty($duplicate_companies)) : ?>
    <ul>
        <?php foreach ($duplicate_companies as $dup) : ?>
            <li>
                <?= esc($dup['company_name']) ?> - <?= $dup['total'] ?> entries
            </li>
        <?php endforeach; ?>
    </ul>
<?php else : ?>
    <p>No duplicate company names found.</p>
<?php endif; ?>

<h2>Companies by Location</h2>
<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>State</th>
        <th>Category</th>
        <th>Total Count</th>
        <th>Travel Agents</th>
        <th>Hotels</th>
    </tr>
    <?php foreach ($count_by_state as $s) : ?>
        <tr>
            <td><?= esc($s->state) ?></td>
            <td><?= esc($s->total_count) ?></td>
            <td><?= esc($s->travel_agents) ?></td>
            <td><?= esc($s->hotels) ?></td>
        </tr>
    <?php endforeach; ?>
    <tr style="font-weight:bold;">
        <td colspan="2">Total</td>
        <td><?= esc($totals['total_companies']) ?></td>
        <td><?= esc($totals['total_travel_agents']) ?></td>
        <td><?= esc($totals['total_hotels']) ?></td>
<p>Total duplicate entries: <?= esc($duplicate_companies_count) ?></p>

    </tr>
</table>

<h2>Search Company</h2>
<input type="text" id="search" placeholder="Type company name">
<div id="search_results"></div>

<script>
    const searchInput = document.getElementById('search');
    const resultsDiv = document.getElementById('search_results');

    searchInput.addEventListener('keyup', function() {
        fetch('<?= site_url("dashboard/search") ?>', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'search=' + encodeURIComponent(this.value)
        })
        .then(res => res.json())
        .then(data => {
            if (!data.length) {
                resultsDiv.innerHTML = '<p>No results found</p>';
                return;
            }
            let html = '<ul>';
            data.forEach(c => {
                html += '<li>' + c.company_name + ' (' + c.category + ')</li>';
            });
            html += '</ul>';
            resultsDiv.innerHTML = html;
        });
    });
</script>
<?= view('company/stats/stats') ?>

