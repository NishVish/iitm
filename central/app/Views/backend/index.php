

<?= view('backend/sidemenu') ?>  <!-- loads app/Views/header.php -->


    <h1>Database Schema | <a href="<?= site_url('backend/sql') ?>" class="btn btn-primary">
    SQL Runner
</a>
</h1>

    <?php foreach ($dbSchema as $table => $columns): ?>
       
       
      
    
    <h2>Table:  <a href="<?= base_url('backend/tabledata' . '/' . urlencode($table)) ?>">
      <?= $table ?>
    
    </a>
    
  </h2>
       <table border="1" cellpadding="8">
    <tr>
        <th>Column Name</th>
        <th>Type</th>
        <th>Max Length</th>
        <th>Primary Key</th>
        <th>Nullable</th>
        <th>Default</th>
    </tr>

    <?php foreach ($columns as $col): ?>
        <tr>
            <td><?= $col->name ?></td>
            <td><?= $col->type ?></td>
            <td><?= $col->max_length ?></td>
            <td><?= $col->primary_key ? 'Yes' : 'No' ?></td>

            <!-- ✅ Nullable Column -->
            <td><?= $col->nullable ? 'Yes' : 'No' ?></td>

            <!-- ✅ Default with NULL fix -->
            <td><?= is_null($col->default) ? 'NULL' : $col->default ?></td>
        </tr>
    <?php endforeach; ?>
</table>
    <?php endforeach; ?>
<!-- my hr has asked me give over view of what i do so i have this table and schema 
our company is travel and toursim exhibiton organizig company and i am implementing this system there is nothing previously i am making the transition from excel to sql and system.... -->

</body>
</html>
