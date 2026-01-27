<?php include 'header.php'; ?>

<h2>Step 2: Confirm Company & Contact Details</h2>

<div class="container" style="display:flex; gap:20px; flex-wrap:wrap; margin-top:20px;">

    <!-- Company Card -->
    <div class="card" style="flex:1; min-width:300px; padding:20px; border:1px solid #ddd; border-radius:8px; background:#f9f9f9;">
        <h3><?= esc($company['company_name']) ?> (<?= esc($company['category']) ?>)</h3>
        <p><strong>City:</strong> <?= esc($company['city']) ?></p>
        <p><strong>State:</strong> <?= esc($company['state'] ?? '-') ?></p>
        <p><strong>Phone:</strong> <?= esc($company['phone'] ?? '-') ?></p>
        <p><strong>GST:</strong> <?= esc($company['gst_number'] ?? '-') ?></p>
    </div>

    <!-- Contacts Card -->
    <div class="card" style="flex:1; min-width:300px; padding:20px; border:1px solid #ddd; border-radius:8px; background:#f9f9f9;">
        <h4>Contact Persons</h4>
        <?php if (!empty($contacts)): ?>
            <ul style="padding-left:15px; margin-top:10px;">
                <?php foreach($contacts as $c): ?>
                    <li style="margin-bottom:10px;">
                        <strong><?= esc($c['name']) ?></strong> (<?= esc($c['designation']) ?>)<br>
                        <strong>Mobile:</strong> <?= esc($c['mobile'] ?? 'N/A') ?><br>
                        <strong>Email:</strong> <?= esc($c['email'] ?? 'N/A') ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No contacts found.</p>
        <?php endif; ?>
    </div>

</div>

<div style="margin-top:20px;">
    <a href="<?= site_url('exhibitor/exhibition/'.$company['company_id']) ?>" 
       style="padding:10px 20px; background:#4CAF50; color:white; border-radius:5px; text-decoration:none;">
       Proceed to Step 3
    </a>
</div>
