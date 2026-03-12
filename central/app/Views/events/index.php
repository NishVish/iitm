<?= view('header') ?> 




    <div class="submenu">
        <a href="<?= base_url('events/fetch/iitm') ?>">Fetch IITM</a>
        <a href="<?= base_url('events/delete') ?>">Delete</a>
    </div>

</div>

    
<div class="content">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2 style="margin:0;">Events Management</h2>
        <a href="<?= site_url('events/create') ?>" class="btn-create-compact">
            <span class="plus-icon">+</span> Create New Event
        </a>
    </div>

    <!-- Editable Table -->
    <table class="events-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Event Name</th>
                <th>Year</th>
                <th>Venue</th>
                <th>Coordinator</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>B2B Logic</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($events as $event): ?>
            <tr data-id="<?= $event['event_id'] ?>">
                <td><?= $event['event_id'] ?></td>
                <td contenteditable="true" data-field="name"><?= esc($event['name']) ?></td>
                <td contenteditable="true" data-field="year"><?= esc($event['year']) ?></td>
                <td contenteditable="true" data-field="venue_details"><?= esc($event['venue_details']) ?></td>
                <td contenteditable="true" data-field="coordinator"><?= esc($event['coordinator']) ?></td>
                <td contenteditable="true" data-field="start_date"><?= esc($event['start_date']) ?></td>
                <td contenteditable="true" data-field="end_date"><?= esc($event['end_date']) ?></td>
                <td contenteditable="true" data-field="b2b_constrain"><?= esc($event['b2b_constrain']) ?></td>
                <td>
                    <a href="<?= site_url('events/edit/' . $event['event_id']) ?>" class="btn-edit">Edit</a>
                    <a href="<?= site_url('events/delete/' . $event['event_id']) ?>" onclick="return confirm('Are you sure?')" class="btn-delete">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <hr style="border:0; border-top:1px solid #eee; margin:40px 0;">

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
    /* Compact Button */
    .btn-create-compact {
        display: flex; align-items: center; justify-content: center; gap: 6px;
        padding: 8px 16px; background-color: var(--nav-color);
        color: var(--text-color); font-size: 0.9rem; font-weight: 500; border-radius: 4px;
        transition: opacity 0.2s;
    }
    .btn-create-compact:hover { opacity: 0.9; color: var(--text-color); }

    /* Editable Table */
    .events-table {
        width: 100%; border-collapse: collapse; margin-bottom: 30px;
        background: var(--body-color-dim); border-radius: 8px; overflow: hidden;
        box-shadow:0 2px 8px rgba(0,0,0,0.05);
    }
    .events-table th {
        background: var(--nav-color); color: var(--text-color); padding: 10px 12px; text-align: left;
    }
    .events-table td {
        padding: 8px 12px; border-bottom: 1px solid #eee;
    }
    .events-table tr:hover { background: #fff; transition: 0.2s; }

    /* Card Layout */
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
// Save edits on blur
document.querySelectorAll('.events-table td[contenteditable="true"]').forEach(cell => {
    cell.addEventListener('blur', function() {
        const tr = cell.closest('tr');
        const id = tr.dataset.id;
        const field = cell.dataset.field;
        const value = cell.textContent.trim();

        fetch("<?= base_url('events/update-cell') ?>", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `id=${id}&field=${field}&value=${encodeURIComponent(value)}`
        })
        .then(res => res.json())
        .then(res => {
            if(res.status !== 'success'){
                alert("Save failed for "+field);
            }
        })
        .catch(()=> alert("Server error"));
    });
});
</script>