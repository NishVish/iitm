<?= view('header') ?>

<style>
body {
    font-family: 'Inter', sans-serif;
    background: #f9f9f9;
    color: #333;
}

.container {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
    margin-bottom: 30px;
}

.box {
    flex: 1;
    min-width: 280px;
    padding: 20px;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.05);
}

/* Company & Contacts */
h3 {
    margin-bottom: 10px;
    color: #444;
}

ul.contact-list {
    list-style: none;
    padding-left: 0;
    font-size: 0.9em;
}

ul.contact-list li {
    margin-bottom: 8px;
    padding: 6px 8px;
    border-left: 3px solid #4caf50;
    background: #f1fdf5;
    border-radius: 5px;
}

/* Leads */
.lead-container {
    display: flex;
    flex-wrap: wrap;
    gap: 16px;
}

.lead-card {
    flex: 1 1 220px;
    background: #fff;
    padding: 14px 18px;
    border-radius: 10px;
    border: 1px solid #eee;
    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    transition: transform 0.15s ease, box-shadow 0.15s ease;
}

.lead-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.lead-card div {
    margin-bottom: 4px;
    font-size: 0.9em;
}

hr {
    border: 0;
    border-top: 1px solid #ddd;
    margin: 20px 0;
}
</style>

<?php
$categoryMap = [
    'Travel Agent' => 'TA',
    'Hotel'        => 'H',
    'Restaurant'   => 'R',
    'Airline'      => 'A'
];

$category = esc($company['category']);
$label = $categoryMap[$category] ?? '';
?>

<!-- ================= COMPANY + CONTACTS ================= -->
<!-- ================= COMPANY + CONTACTS ================= -->
<div class="container" style="display:flex; gap:20px; flex-wrap:wrap;">

    <!-- Company Details -->
    <div class="box" style="flex:1; min-width:250px;">
        <h3><?= esc($company['company_id']) ?> | <?= esc($company['company_name']) ?> (<?= $label ?>) | <?= esc($company['city']) ?>, <?= esc($company['state']) ?></h3>
        <p style="margin:0.3em 0; font-size:0.95em;">
            
            <strong>Phone:</strong> <?= esc($company['phone']) ?> | 
            <strong>GST:</strong> <?= esc($company['gst_number']) ?>
        </p>
    </div>

    <!-- Contacts -->
    <div class="box" style="flex:1; min-width:250px;">
        <?php if (!empty($contacts)): ?>
            <ul class="contact-list">
                <?php foreach($contacts as $c): ?>
                    <li>
                        <strong><?= esc($c['name']) ?></strong> (<?= esc($c['designation']) ?>) | ID: <?= esc($c['contact_id']) ?>
                        Mobiles: <?= !empty($c['mobiles']) ? implode(', ', $c['mobiles']) : 'N/A' ?>
                        Emails: <?= !empty($c['emails']) ? implode(', ', $c['emails']) : 'N/A' ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No contacts found.</p>
        <?php endif; ?>
    </div>

</div>


<hr>

<!-- ================= LEADS ================= -->
<h3>Leads</h3>

<?php if (!empty($leads)): ?>
    <div class="lead-container">
        <?php foreach ($leads as $l): ?>
            <div class="lead-card">
                <div><strong>Lead ID:</strong> <?= esc($l['lead_id'] ?? '-') ?></div>
                <div><strong>Company ID:</strong> <?= esc($l['company_id'] ?? '-') ?></div>
                <div><strong>Exhibition Year:</strong> <?= esc($l['exhibition_year'] ?? '-') ?></div>
                <div><strong>Location:</strong> <?= esc($l['location'] ?? '-') ?></div>
                <div><strong>Size:</strong> <?= esc($l['size'] ?? '-') ?></div>
                <div><strong>Fascia:</strong> <?= esc($l['fascia'] ?? '-') ?></div>
                <div><strong>Stall:</strong> <?= esc($l['stall_location'] ?? '-') ?></div>
                <div><strong>Price:</strong> ₹<?= esc($l['price'] ?? '0') ?></div>
                <div><strong>Sales Person:</strong> <?= esc($l['sales_person'] ?? '-') ?></div>
                <div><strong>Exhibitor:</strong> <?= esc($l['exhibitor'] ?? '-') ?></div>
                <div><strong>Status:</strong> <?= esc($l['status'] ?? '-') ?></div>
                <div><strong>Payment:</strong> <?= esc($l['payment_status'] ?? '-') ?></div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p>No leads found.</p>

<?php endif; ?>


<!-- ================= DISCUSSIONS ================= -->
<h3 style="display:flex; justify-content:space-between; align-items:center;">
    Discussions
    <button id="addDiscussionBtn" style="
        padding:6px 12px;
        background:#4CAF50;
        color:#fff;
        border:none;
        border-radius:4px;
        cursor:pointer;
        font-size:0.9em;
    ">
        + Add Discussion
    </button>
</h3>

<?php if (!empty($discussions)): ?>
    <div class="discussion-container" style="display:flex; flex-wrap:wrap; gap:16px; margin-top:10px;">
        <?php foreach ($discussions as $d): ?>
            <div class="discussion-card" style="
                border:1px solid #ddd;
                border-radius:8px;
                padding:12px 16px;
                background:#f9f9f9;
                box-shadow:0 2px 6px rgba(0,0,0,0.08);
                min-width:250px;
                flex:1;
            ">
                <div style="font-size:0.9em; color:#555; margin-bottom:6px;">
                    <strong>Action:</strong> <?= esc($d['action']) ?><br>
                    <strong>Lead ID:</strong> <?= esc($d['lead_id']) ?>
                </div>
                <div style="margin-bottom:8px; font-size:0.95em;">
                    <?= nl2br(esc($d['message'])) ?>
                </div>
                <div style="font-size:0.8em; color:#888;">
                    <?= date('d M Y, H:i', strtotime($d['discussion_date'])) ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p style="margin-top:10px;">No discussions found.</p>
<?php endif; ?>
<!-- ================= ADD DISCUSSION MODAL ================= -->
<div id="discussionModal" style="
    display:none;
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.5);
    justify-content:center;
    align-items:center;
    z-index:9999;
">
    <div style="
        background:#fff;
        padding:20px 25px;
        border-radius:8px;
        width:400px;
        max-width:90%;
        position:relative;
        box-shadow:0 5px 15px rgba(0,0,0,0.3);
    ">
        <span id="closeModal" style="
            position:absolute;
            top:10px;
            right:15px;
            font-size:20px;
            font-weight:bold;
            cursor:pointer;
        ">&times;</span>

        <h3 style="margin-top:0;">Add Discussion</h3>

        <form method="post" action="<?= site_url('discussion/add') ?>">
            <input type="hidden" name="lead_id" value="<?= esc($lead['lead_id'] ?? $leads[0]['lead_id']) ?>">

            <label for="action">Action</label><br>
            <input type="text" name="action" id="action" required style="width:100%; padding:6px; margin-bottom:10px;"><br>

            <label for="message">Message</label><br>
            <textarea name="message" id="message" rows="5" required style="width:100%; padding:6px; margin-bottom:10px;"></textarea><br>

            <button type="submit" style="
                padding:8px 16px;
                background:#4CAF50;
                color:#fff;
                border:none;
                border-radius:4px;
                cursor:pointer;
            ">Submit</button>
        </form>
    </div>
</div>

<!-- ================= JS TO OPEN/CLOSE MODAL ================= -->
<script>
    const modal = document.getElementById('discussionModal');
    const openBtn = document.getElementById('addDiscussionBtn');
    const closeBtn = document.getElementById('closeModal');

    openBtn.addEventListener('click', () => {
        modal.style.display = 'flex';
    });

    closeBtn.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    window.addEventListener('click', (e) => {
        if(e.target === modal){
            modal.style.display = 'none';
        }
    });
</script>

