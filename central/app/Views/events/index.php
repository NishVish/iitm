<?= view('header') ?> 
<style>
body {
    font-family: Arial, sans-serif;

}

/* Header already in header.php */

h2 {
    margin-bottom: 10px;
}

/* Button style */
.btn-create {
    display: inline-block;
    margin-bottom: 15px;
    padding: 6px 12px;
    background: #007bff;
    color: #fff;
    text-decoration: none;
    border-radius: 4px;
    font-size: 14px;
}

/* Container for all event cards */
.cards-container {
    display: flex;
    flex-wrap: wrap;       /* wrap to next row if space is full */
    gap: 15px;             /* spacing between cards */
}

/* Individual event card */
.event-card {
    background: #f9f9f9;
    border: 1px solid #ddd;
    border-radius: 6px;
    padding: 10px;
    width: 280px;          /* adjust for 4-5 cards per row */
    box-sizing: border-box;
    font-size: 13px;
    line-height: 1.3;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

/* Event card headings */
.event-card h3 {
    margin: 0 0 6px 0;
    font-size: 16px;
}

/* Card paragraphs */
.event-card p {
    margin: 2px 0;
}

/* Action buttons */
.event-card .actions {
    margin-top: 8px;
}

.event-card .actions a {
    margin-right: 6px;
    padding: 3px 6px;
    font-size: 12px;
    text-decoration: none;
    border-radius: 4px;
}

.btn-edit {
    background: #ffc107;
    color: #000;
}

.btn-delete {
    background: #dc3545;
    color: #fff;
}
</style>

<h2>Events List</h2>
<a href="<?= site_url('events/create') ?>" class="btn-create">Create New Event</a>

<div class="cards-container">
    <?php foreach ($events as $event): ?>
        <div class="event-card">
            <h3><?= esc($event['name']) ?> | <?= esc($event['year']) ?></h3>
            <p><strong>B2B:</strong> <?= esc($event['b2b_constrain']) ?></p>
            <p><strong>Venue:</strong> <?= esc($event['venue_details']) ?></p>
            <p><strong>Booking:</strong> <?= esc($event['venue_booking_details']) ?></p>
            <p><strong>Coordinator:</strong> <?= esc($event['coordinator']) ?></p>
            <p><strong>Start:</strong> <?= esc($event['start_date']) ?></p>
            <p><strong>End:</strong> <?= esc($event['end_date']) ?></p>
            <p><strong>Created:</strong> <?= esc($event['created_at']) ?></p>
            <p><strong>Updated:</strong> <?= esc($event['updated_at'] ?? '-') ?></p>
            <p><strong>Layout:</strong> <?= esc($event['layout_date'] ?? 'No layout') ?></p>
            <p>
                <strong>File:</strong>
                <?php if (!empty($event['layout_id'])): ?>
                    <a href="<?= site_url('layouts/download/' . $event['layout_id']) ?>">Download</a>
                <?php else: ?>
                    — 
                <?php endif; ?>
            </p>
            <div class="actions">
                <a href="<?= site_url('events/edit/' . $event['event_id']) ?>" class="btn-edit">Edit</a>
                <a href="<?= site_url('events/delete/' . $event['event_id']) ?>" onclick="return confirm('Are you sure?')" class="btn-delete">Delete</a>
            </div>
        </div>
    <?php endforeach; ?>
</div>
