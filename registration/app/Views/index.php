<?= view('header') ?>
This is Index Pagesdfsdfsdfsdf
<h1>Analytics Dashboard</h1>

<p><strong>Total Entries:</strong> <?= $totalEntries; ?></p>

<h2>Entries by Country</h2>
<ul>
    <?php foreach($entriesByCountry as $country): ?>
        <li><?= $country['country'] ?>: <?= $country['total'] ?></li>
    <?php endforeach; ?>
</ul>

<h2>Entries by City</h2>
<ul>
    <?php foreach($entriesByCity as $city): ?>
        <li><?= $city['city_name'] ?>: <?= $city['total'] ?></li>
    <?php endforeach; ?>
</ul>