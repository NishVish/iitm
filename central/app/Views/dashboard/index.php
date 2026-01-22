<?= view('header') ?>  <!-- loads app/Views/header.php -->

    <h1>Dashboard</h1>

    <h2>Companies by Location</h2>
<table>
    <tr>
        <th>Location (State)</th>
        <th>Total Count</th>
        <th>Travel Agents</th>
        <th>Hotels</th>
    </tr>
    <?php foreach($count_by_state as $s): ?>
        <tr>
            <td><?= $s->state ?></td>
            <td><?= $s->total_count ?></td>
            <td><?= $s->travel_agents ?></td>
            <td><?= $s->hotels ?></td>
        </tr>
    <?php endforeach; ?>
    <tr style="font-weight:bold;">
        <td>Total</td>
        <td><?= $totals['total_companies'] ?></td>
        <td><?= $totals['total_travel_agents'] ?></td>
        <td><?= $totals['total_hotels'] ?></td>
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
                headers: {'Content-Type':'application/x-www-form-urlencoded'},
                body: 'search=' + encodeURIComponent(this.value)
            })
            .then(res => res.json())
            .then(data => {
                let html = '<ul>';
                data.forEach(c => {
                    html += '<li>' + c.company_name + ' (' + c.category + ')</li>';
                });
                html += '</ul>';
                resultsDiv.innerHTML = html;
            });
        });
    </script>
</body>
</html>
