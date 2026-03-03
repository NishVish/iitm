<?= view('header') ?> 

<?php $segment1 = service('uri')->getSegment(1); ?>

<?php if ($segment1 == 'events') : ?>
    <div class="submenu">
        <a href="<?= base_url('events/fetch/iitm') ?>">Fetch IITM</a>
        <a href="<?= base_url('events/delete') ?>">Delete</a>
    </div>
<?php endif; ?>
</div>

<div class="content">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2 style="margin:0;">Events Management</h2>
        <a href="<?= site_url('events/create') ?>" class="btn-create-compact" style="width: auto; text-decoration: none;">
            <span class="plus-icon">+</span> Create New Event
        </a>
    </div>

    <div id="Spreadsheet" style="margin-bottom: 30px;"></div>

    <hr style="border: 0; border-top: 1px solid #eee; margin: 40px 0;">

    <h3 style="margin-bottom:15px; color:#666;">Visual Cards View</h3>
    <div class="cards-container">
        <?php foreach ($events as $event): ?>
            <div class="event-card">
                <h3><?= esc($event['name']) ?> | <?= esc($event['year']) ?></h3>
                <p><strong>B2B:</strong> <?= esc($event['b2b_constrain']) ?></p>
                <p><strong>Venue:</strong> <?= esc($event['venue_details']) ?></p>
                <p><strong>Start:</strong> <?= esc($event['start_date']) ?></p>
                <div class="actions">
                    <a href="<?= site_url('events/edit/' . $event['event_id']) ?>" class="btn-edit">Edit</a>
                    <a href="<?= site_url('events/delete/' . $event['event_id']) ?>" onclick="return confirm('Are you sure?')" class="btn-delete">Delete</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<style>
    /* Compact Button Style from previous step */
    .btn-create-compact {
        display: flex; align-items: center; justify-content: center; gap: 6px;
        padding: 8px 16px; background-color: var(--nav-color, #007bff);
        color: #fff; font-size: 0.9rem; font-weight: 500; border-radius: 4px;
        transition: opacity 0.2s;
    }
    .btn-create-compact:hover { opacity: 0.9; color: #fff; }

    /* Card Layout Styles */
    .cards-container { display: flex; flex-wrap: wrap; gap: 15px; }
    .event-card {
        background: #fff; border: 1px solid #ddd; border-radius: 8px;
        padding: 15px; width: 300px; font-size: 13px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    .event-card h3 { margin: 0 0 10px 0; color: var(--nav-color); }
    .btn-edit { background: #ffc107; color: #000; padding: 4px 8px; border-radius: 4px; text-decoration:none; }
    .btn-delete { background: #dc3545; color: #fff; padding: 4px 8px; border-radius: 4px; text-decoration:none; }
</style>
<script>
const eventsData = <?= json_encode(array_map(function($e) {
    return [
        $e['event_id'],
        $e['name'],
        $e['year'],
        $e['venue_details'],
        $e['coordinator'],
        $e['start_date'],
        $e['end_date'],
        $e['b2b_constrain']
    ];
}, $events)); ?>;
const eventColumns = [
    { title: "ID", field: "event_id" },
    { title: "Event Name", field: "name" },
    { title: "Year", field: "year" },
    { title: "Venue", field: "venue_details" },
    { title: "Coordinator", field: "coordinator" },
    { title: "Start Date", field: "start_date" },
    { title: "End Date", field: "end_date" },
    { title: "B2B Logic", field: "b2b_constrain" }
];

const columnMap = [
    'event_id',
    'name',
    'year',
    'venue_details',
    'coordinator',
    'start_date',
    'end_date',
    'b2b_constrain'
];


const eventSheet = new Spreadsheet('Spreadsheet', {
    data: eventsData,
    columns: eventColumns,

    onCellEdit: function(data) {
        // 🔥 Debug log
        console.log("Cell Edited:", data);

        fetch("<?= base_url('events/update-cell') ?>", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            body: `id=${data.id}&field=${data.field}&value=${encodeURIComponent(data.value)}`
        })
        .then(res => res.json())
        .then(response => {
            if (response.status !== 'success') {
                alert("Save failed");
            } else {
                console.log("Saved successfully ✅");
            }
        })
        .catch(() => alert("Server error"));
    }
});
</script>