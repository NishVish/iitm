<?= view('ticket/side') ?>

<style>
/* Container */
.issue-container {
    padding: 16px;
}

/* Header */
.header-section h2 {
    margin-bottom: 12px;
}

.alert.alert-success {
    padding: 8px 12px;
    background-color: #d4edda;
    color: #155724;
    border-radius: 4px;
    margin-bottom: 12px;
}

/* Cards container */
.cards-container {
    display: flex;
        flex-direction: column;

    flex-wrap: wrap;
    gap: 16px;
}

/* Issue card */
.issue-card {
    flex: 1 1 auto;
    border: 1px solid #ddd;
    border-radius: 6px;
    padding: 12px;
    background: #fff;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

/* Card header */
.card-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 8px;
}

.title-display,
.title-edit {
    width: 100%;
    font-weight: bold;
    font-size: 16px;
}

.title-edit {
    display: none;
    border: 1px solid #ccc;
    padding: 2px;
    border-radius: 4px;
}

.status-edit {
    font-size: 12px;
    color: #888;
}

/* Card body */
.card-body {
    color: #555;
    margin-bottom: 8px;
}

.desc-display,
.desc-edit {
    width: 100%;
}

.desc-display {
    white-space: pre-wrap;
}

.desc-edit {
    display: none;
    border: 1px solid #ccc;
    border-radius: 4px;
    padding: 4px;
    resize: vertical; /* allows vertical resizing */
    height: 120px; /* set a default height */
    min-height: auto; /* optional minimum */
    max-height: 300px; /* optional maximum */
    width: 100%; /* ensure it fills the card width */
    box-sizing: border-box; /* include padding in height */
}

/* Card meta */
.card-meta {
    display: flex;
    justify-content: space-between;
    font-size: 12px;
    color: #666;
    margin-bottom: 8px;
}

.card-meta input {
    border: none;
    background: none;
}

.card-meta input[name="dept"] {
    width: 80px;
}

.card-meta input[name="priority"] {
    width: 50px;
}

/* Card actions */
.card-actions button {
    padding: 6px 12px;
    border-radius: 4px;
    border: none;
    cursor: pointer;
}

.edit-btn {
    background: #2196F3;
    color: #fff;
}

.save-btn {
    background: #4CAF50;
    color: #fff;
    display: none;
}
</style>

<div class="issue-container">
    <div class="header-section">
        <h2>Issue Management</h2>
        <div class="issue-container">
    <div class="header-section">
        <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>
    </div>
        <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="cards-container">
        <?php foreach($issues as $issue): ?>
        <div class="issue-card">
            <form method="post" action="<?= base_url('issue/update/'.$issue['id']) ?>" class="issue-form">
                <?= csrf_field() ?>

                <div class="card-header">
                    <div class="title-display"><h2><?= esc($issue['title']) ?></h2></div>
                    <input type="text" name="title" value="<?= esc($issue['title']) ?>" class="title-edit">

                    <select name="status" class="status-edit" disabled>
                        <option value="Open" <?= $issue['status'] == 'Open' ? 'selected' : '' ?>>Open</option>
                        <option value="In Progress" <?= $issue['status'] == 'In Progress' ? 'selected' : '' ?>>In Progress</option>
                        <option value="Closed" <?= $issue['status'] == 'Closed' ? 'selected' : '' ?>>Closed</option>
                    </select>
                </div>

                <div class="card-body">
                    <div class="desc-display"><?= nl2br(esc($issue['description'])) ?></div>
                    <textarea name="description" class="desc-edit"><?= esc($issue['description']) ?></textarea>
                </div>

                <div class="card-meta">
                    <div><strong>Dept:</strong> <input type="text" name="dept" value="<?= esc($issue['dept'] ?? '-') ?>" readonly></div>
                    <div><strong>Priority:</strong> <input type="text" name="priority" value="<?= esc($issue['priority']) ?>" readonly></div>
                    <div><strong>Resolved:</strong> <?= $issue['resolved_at'] ?? '--:--' ?></div>
                </div>

                <div class="card-actions">
                    <button type="button" class="edit-btn">Edit</button>
                    <button type="submit" class="save-btn">Save</button>
                </div>
            </form>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
// Toggle edit mode
document.querySelectorAll('.issue-card').forEach(card => {
    const editBtn = card.querySelector('.edit-btn');
    const saveBtn = card.querySelector('.save-btn');

    const titleDisplay = card.querySelector('.title-display');
    const titleEdit = card.querySelector('.title-edit');

    const descDisplay = card.querySelector('.desc-display');
    const descEdit = card.querySelector('.desc-edit');

    const statusEdit = card.querySelector('.status-edit');

    editBtn.addEventListener('click', () => {
        titleDisplay.style.display = 'none';
        descDisplay.style.display = 'none';

        titleEdit.style.display = 'block';
        descEdit.style.display = 'block';
        statusEdit.removeAttribute('disabled');

        editBtn.style.display = 'none';
        saveBtn.style.display = 'inline-block';
    });
});
</script>