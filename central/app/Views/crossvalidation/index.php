<?= view('header') ?>

<form action="<?= site_url('crossvalidation/crossValidate') ?>" method="get">
    <button type="submit" class="btn btn-primary">Company Cross Validation</button>
</form>
<form action="<?= site_url('crossvalidation/crossValidateContact') ?>" method="get">
    <button type="submit" class="btn btn-primary">Contact Cross Validation</button>
</form>
<form action="<?= site_url('crossvalidation/clear') ?>" method="get">
    <button type="submit" class="btn btn-primary">clear Matches</button>
</form>
<form action="<?= site_url('crossvalidation/clearcontact') ?>" method="get">
    <button type="submit" class="btn btn-primary">clear Contact Matches</button>
</form>

<h2>Company Matches</h2>
<table>
    <thead>
        <tr>            
            
            <th>Fielfs</th>
            <th>Original</th>
            <th> Action</th>
            <th>Matched</th>

        </tr>
    </thead>
    <tbody>
    <?php foreach($company_matches as $match): ?>

        <tr>
<tr>
<td>company_id</td>
<td><?= $match['company_id'] ?></td>
<td>
<form method="post" action="<?= site_url('crossvalidation/action') ?>">
    <input type="hidden" name="type" value="company_id">
    <input type="hidden" name="id" value="<?= $match['company_id'] ?>">
    <input type="hidden" name="match_id" value="<?= $match['matched_company_id'] ?>">
    <button type="submit" name="action" value="overwrite">Overwrite</button>

</form>
</td>
<td>
<span style="color: <?= ($match['matched_company_id'] == $match['company_id']) ? 'green' : 'red' ?>">
    <?= $match['matched_company_id'] ?>
</span>
</td>
</tr>
<tr>
<td>company_name</td>
<td><?= $match['original_company_name'] ?></td>
<td>
<form method="post" action="<?= site_url('crossvalidation/action') ?>">
    <input type="hidden" name="type" value="company_name">
    <input type="hidden" name="id" value="<?= $match['company_id'] ?>">
    <input type="hidden" name="match_id" value="<?= $match['matched_company_id'] ?>">
    <button type="submit" name="action" value="overwrite">Overwrite</button>

</form>
</td>
<td>
<span style="color: <?= ($match['matched_company_name'] == $match['original_company_name']) ? 'green' : 'red' ?>">
    <?= $match['matched_company_name'] ?>
</span>
</td>
</tr>
<tr>
<td>database_name</td>
<td><?= $match['original_database_name'] ?></td>
<td>
<form method="post" action="<?= site_url('crossvalidation/action') ?>">
    <input type="hidden" name="type" value="database_name">
    <input type="hidden" name="id" value="<?= $match['company_id'] ?>">
    <input type="hidden" name="match_id" value="<?= $match['matched_company_id'] ?>">
    <button type="submit" name="action" value="overwrite">Overwrite</button>

</form>
</td>
<td>
<span style="color: <?= ($match['matched_database_name'] == $match['original_database_name']) ? 'green' : 'red' ?>">
    <?= $match['matched_database_name'] ?>
</span>
</td>
</tr>
<tr>
<td>category</td>
<td><?= $match['original_category'] ?></td>
<td>
<form method="post" action="<?= site_url('crossvalidation/action') ?>">
    <input type="hidden" name="type" value="category">
    <input type="hidden" name="id" value="<?= $match['company_id'] ?>">
    <input type="hidden" name="match_id" value="<?= $match['matched_company_id'] ?>">
    <button type="submit" name="action" value="overwrite">Overwrite</button>

</form>
</td>
<td>
<span style="color: <?= ($match['matched_category'] == $match['original_category']) ? 'green' : 'red' ?>">
    <?= $match['matched_category'] ?>
</span>
</td>
</tr>
<tr>
<td>address</td>
<td><?= $match['original_address'] ?></td>
<td>
<form method="post" action="<?= site_url('crossvalidation/action') ?>">
    <input type="hidden" name="type" value="address">
    <input type="hidden" name="id" value="<?= $match['company_id'] ?>">
    <input type="hidden" name="match_id" value="<?= $match['matched_company_id'] ?>">
    <button type="submit" name="action" value="overwrite">Overwrite</button>

</form>
</td>
<td>
<span style="color: <?= ($match['matched_address'] == $match['original_address']) ? 'green' : 'red' ?>">
    <?= $match['matched_address'] ?>
</span>
</td>
</tr>
<tr>
<td>city</td>
<td><?= $match['original_city'] ?></td>
<td>
<form method="post" action="<?= site_url('crossvalidation/action') ?>">
    <input type="hidden" name="type" value="city">
    <input type="hidden" name="id" value="<?= $match['company_id'] ?>">
    <input type="hidden" name="match_id" value="<?= $match['matched_company_id'] ?>">
    <button type="submit" name="action" value="overwrite">Overwrite</button>

</form>
</td>
<td>
<span style="color: <?= ($match['matched_city'] == $match['original_city']) ? 'green' : 'red' ?>">
    <?= $match['matched_city'] ?>
</span>
</td>
</tr>
<tr>
<td>pincode</td>
<td><?= $match['original_pincode'] ?></td>
<td>
<form method="post" action="<?= site_url('crossvalidation/action') ?>">
    <input type="hidden" name="type" value="pincode">
    <input type="hidden" name="id" value="<?= $match['company_id'] ?>">
    <input type="hidden" name="match_id" value="<?= $match['matched_company_id'] ?>">
    <button type="submit" name="action" value="overwrite">Overwrite</button>

</form>
</td>
<td>
<span style="color: <?= ($match['matched_pincode'] == $match['original_pincode']) ? 'green' : 'red' ?>">
    <?= $match['matched_pincode'] ?>
</span>
</td>
</tr>
<tr>
<td>state</td>
<td><?= $match['original_state'] ?></td>
<td>
<form method="post" action="<?= site_url('crossvalidation/action') ?>">
    <input type="hidden" name="type" value="state">
    <input type="hidden" name="id" value="<?= $match['company_id'] ?>">
    <input type="hidden" name="match_id" value="<?= $match['matched_company_id'] ?>">
    <button type="submit" name="action" value="overwrite">Overwrite</button>

</form>
</td>
<td>
<span style="color: <?= ($match['matched_state'] == $match['original_state']) ? 'green' : 'red' ?>">
    <?= $match['matched_state'] ?>
</span>
</td>
</tr>
<tr>
<td>country</td>
<td><?= $match['original_country'] ?></td>
<td>
<form method="post" action="<?= site_url('crossvalidation/action') ?>">
    <input type="hidden" name="type" value="country">
    <input type="hidden" name="id" value="<?= $match['company_id'] ?>">
    <input type="hidden" name="match_id" value="<?= $match['matched_company_id'] ?>">
    <button type="submit" name="action" value="overwrite">Overwrite</button>

</form>
</td>
<td>
<span style="color: <?= ($match['matched_country'] == $match['original_country']) ? 'green' : 'red' ?>">
    <?= $match['matched_country'] ?>
</span>
</td>
</tr>
<tr>
<td>phone</td>
<td><?= $match['original_phone'] ?></td>
<td>
<form method="post" action="<?= site_url('crossvalidation/action') ?>">
    <input type="hidden" name="type" value="phone">
    <input type="hidden" name="id" value="<?= $match['company_id'] ?>">
    <input type="hidden" name="match_id" value="<?= $match['matched_company_id'] ?>">
    <button type="submit" name="action" value="overwrite">Overwrite</button>

</form>
</td>
<td>
<span style="color: <?= ($match['matched_phone'] == $match['original_phone']) ? 'green' : 'red' ?>">
    <?= $match['matched_phone'] ?>
</span>
</td>
</tr>
<tr>
<td>gst_number</td>
<td><?= $match['original_gst_number'] ?></td>
<td>
<form method="post" action="<?= site_url('crossvalidation/action') ?>">
    <input type="hidden" name="type" value="gst_number">
    <input type="hidden" name="id" value="<?= $match['company_id'] ?>">
    <input type="hidden" name="match_id" value="<?= $match['matched_company_id'] ?>">
    <button type="submit" name="action" value="overwrite">Overwrite</button>

</form>
</td>
<td>
<span style="color: <?= ($match['matched_gst_number'] == $match['original_gst_number']) ? 'green' : 'red' ?>">
    <?= $match['matched_gst_number'] ?>
</span>
</td>
</tr>
<tr>
<td>sales_person</td>
<td><?= $match['original_sales_person'] ?></td>
<td>
<form method="post" action="<?= site_url('crossvalidation/action') ?>">
    <input type="hidden" name="type" value="sales_person">
    <input type="hidden" name="id" value="<?= $match['company_id'] ?>">
    <input type="hidden" name="match_id" value="<?= $match['matched_company_id'] ?>">
    <button type="submit" name="action" value="overwrite">Overwrite</button>

</form>
</td>
<td>
<span style="color: <?= ($match['matched_sales_person'] == $match['original_sales_person']) ? 'green' : 'red' ?>">
    <?= $match['matched_sales_person'] ?>
</span>
</td>
</tr>
<tr>
<td>active_inactive</td>
<td><?= $match['original_active_inactive'] ?></td>
<td>
<form method="post" action="<?= site_url('crossvalidation/action') ?>">
    <input type="hidden" name="type" value="active_inactive">
    <input type="hidden" name="id" value="<?= $match['company_id'] ?>">
    <input type="hidden" name="match_id" value="<?= $match['matched_company_id'] ?>">
    <button type="submit" name="action" value="overwrite">Overwrite</button>

</form>
</td>
<td>
<span style="color: <?= ($match['matched_active_inactive'] == $match['original_active_inactive']) ? 'green' : 'red' ?>">
    <?= $match['matched_active_inactive'] ?>
</span>
</td>
</tr>
<tr>
<td>created_at</td>
<td><?= $match['original_created_at'] ?></td>
<td>
<form method="post" action="<?= site_url('crossvalidation/action') ?>">
    <input type="hidden" name="type" value="created_at">
    <input type="hidden" name="id" value="<?= $match['company_id'] ?>">
    <input type="hidden" name="match_id" value="<?= $match['matched_company_id'] ?>">
    <button type="submit" name="action" value="overwrite">Overwrite</button>

</form>
</td>
<td>
<span style="color: <?= ($match['matched_created_at'] == $match['original_created_at']) ? 'green' : 'red' ?>">
    <?= $match['matched_created_at'] ?>
</span>
</td>
</tr>
<tr>
<td>updated_at</td>
<td><?= $match['original_updated_at'] ?></td>
<td>
<form method="post" action="<?= site_url('crossvalidation/action') ?>">
    <input type="hidden" name="type" value="updated_at">
    <input type="hidden" name="id" value="<?= $match['company_id'] ?>">
    <input type="hidden" name="match_id" value="<?= $match['matched_company_id'] ?>">
    <button type="submit" name="action" value="overwrite">Overwrite</button>

</form>
</td>
<td>
<span style="color: <?= ($match['matched_updated_at'] == $match['original_updated_at']) ? 'green' : 'red' ?>">
    <?= $match['matched_updated_at'] ?>
</span>
</td>
</tr>
<tr>
<td>last_confirmed_at</td>
<td><?= $match['original_last_confirmed_at'] ?></td>
<td>
<form method="post" action="<?= site_url('crossvalidation/action') ?>">
    <input type="hidden" name="type" value="last_confirmed_at">
    <input type="hidden" name="id" value="<?= $match['company_id'] ?>">
    <input type="hidden" name="match_id" value="<?= $match['matched_company_id'] ?>">
    <button type="submit" name="action" value="overwrite">Overwrite</button>

</form>
</td>
<td>
<span style="color: <?= ($match['matched_last_confirmed_at'] == $match['original_last_confirmed_at']) ? 'green' : 'red' ?>">
    <?= $match['matched_last_confirmed_at'] ?>
</span>
</td>
</tr>
<tr>
<td>session</td>
<td><?= $match['original_session'] ?></td>
<td>
<form method="post" action="<?= site_url('crossvalidation/action') ?>">
    <input type="hidden" name="type" value="session">
    <input type="hidden" name="id" value="<?= $match['company_id'] ?>">
    <input type="hidden" name="match_id" value="<?= $match['matched_company_id'] ?>">
    <button type="submit" name="action" value="overwrite">Overwrite</button>

</form>
</td>
<td>
<span style="color: <?= ($match['matched_session'] == $match['original_session']) ? 'green' : 'red' ?>">
    <?= $match['matched_session'] ?>
</span>
</td>
</tr><tr>
<td>Cross Validation</td>
<td><?= $match['orignal_cross_validation'] ?></td>
<td>

</td>
<td>
<span style="color: <?= ($match['matched_cross_validation'] == $match['matched_cross_validation']) ? 'green' : 'red' ?>">
    <?= $match['matched_cross_validation'] ?>
</span>
</td>
</tr>

<tr>
    <td>1 </td>
<td>
    2
</td>
<td>
    <form method="post" action="<?= site_url('crossvalidation/action') ?>">
    <input type="hidden" name="type" value="no_action">
    <input type="hidden" name="type" value="all">
    <input type="hidden" name="id" value="<?= $match['company_id'] ?>">
    <input type="hidden" name="match_id" value="<?= $match['matched_company_id'] ?>">
    <button type="submit" name="action" value="no_action">No Action
    <button type="submit" name="action" value="overwrite">Overwrite all</button>

</button>
</form>


</td>
<td>4


</td></tr>
<td><br></td>

        </tr>
    <?php endforeach; ?>
    </tbody>
</table>



















<h2>Contact Matches</h2>
<table>
    <thead>
        <tr>
            <th>Original ID</th>
            <th>Original Details</th>
            <th>Matched ID</th>
            <th>Matched Details</th>
            <th>Scores (Name / Designation / Email / Mobile)</th>
            <th>Match Type</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($contact_matches as $match): ?>
        <tr>
            <td><?= $match['contact_id'] ?></td>
            <td class="details">
                <div><strong>Name:</strong> <?= $match['original_name'] ?></div>
                <div><strong>Designation:</strong> <?= $match['original_designation'] ?></div>
                <div><strong>Email:</strong> <?= $match['original_email'] ?></div>
                <div><strong>Mobile:</strong> <?= $match['original_mobile'] ?></div>
            </td>
            <td><?= $match['matching_contact_id'] ?></td>
            <td class="details">
                <div><strong>Name:</strong> <?= $match['matched_name'] ?></div>
                <div><strong>Designation:</strong> <?= $match['matched_designation'] ?></div>
                <div><strong>Email:</strong> <?= $match['matched_email'] ?></div>
                <div><strong>Mobile:</strong> <?= $match['matched_mobile'] ?></div>
            </td>
            <td><?= $match['name'] ?> / <?= $match['designation'] ?> / <?= $match['email'] ?> / <?= $match['mobile'] ?></td>
            <td><?= $match['matching_type'] ?></td>
            <td class="actions">
                <form method="post" action="<?= site_url('crossvalidation/actioncontact') ?>">
                    <input type="hidden" name="type" value="contact">
                    <input type="hidden" name="id" value="<?= $match['contact_id'] ?>">
                    <input type="hidden" name="match_id" value="<?= $match['matching_contact_id'] ?>">
                    <button type="submit" name="action" value="overwrite">Overwrite</button>
                    <button type="submit" name="action" value="merge">Merge</button>
                    <button type="submit" name="action" value="skip">Skip</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>
