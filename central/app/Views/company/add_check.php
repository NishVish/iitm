<?= view('header') ?>

<h2>Preview Company</h2>

<?php if(!empty($company_id)): ?>
    <div style="border:1px solid #ccc; padding:10px; margin-bottom:20px;">
        <p><b>Company ID:</b> <?= $company_id ?></p>
        <p><b>Company Name:</b> <?= $company_name ?></p>
        <p><b>Database Name:</b> <?= $database_name ?></p>
        <p><b>Outbound:</b> <?= $outbound ? 'Yes' : 'No' ?></p>
    </div>
<?php endif; ?>

<form action="<?= site_url('company/add_check') ?>" method="post">
    <?= csrf_field() ?>

    <label>Company Name:</label><br>
    <input type="text" name="companies[0][company_name]" value="<?= $company_name ?>" required><br><br>

    <label>Database Name:</label><br>
    <input type="text" name="companies[0][database_name]" value="<?= $database_name ?>"><br><br>

    <label>Outbound:</label>
    <input type="checkbox" name="companies[0][outbound]" value="1" <?= $outbound ? 'checked' : '' ?>><br><br>

    <button type="submit">Preview Company</button>
</form>
