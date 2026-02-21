<?= view('header') ?>  <!-- loads app/Views/header.php -->
<?php
$segment1 = service('uri')->getSegment(1);

if ($segment1 == 'issue') : ?>
    <div class="submenu">
        <a href="<?= base_url('plan') ?>">Plan</a>
        <!-- <a href="<?= base_url('games') ?>">Play Games</a> -->
        <!-- <a href="<?= base_url('tv') ?>">TV</a> -->
        <a href="<?= base_url('company') ?>">View Companies</a>
        <a href="<?= base_url('company/add') ?>">Add Company</a>

            <!-- New Ticket Form -->
    <form method="post" action="<?= base_url('issue/store') ?>" class="new-issue-form">
    <?= csrf_field() ?>
    
    <input type="text" name="title" placeholder="Enter issue title" value="<?= esc(old('title')) ?>" required>
    
    <textarea name="description" placeholder="Enter issue description" rows="6" required><?= esc(old('description')) ?></textarea>
    
    <input type="text" name="dept" placeholder="Enter department" value="<?= esc(old('dept')) ?>">
    
    <select name="priority">
        <option value="" disabled <?= old('priority') ? '' : 'selected' ?>>Select priority</option>
        <option value="Low" <?= old('priority') == 'Low' ? 'selected' : '' ?>>Low</option>
        <option value="Medium" <?= old('priority') == 'Medium' ? 'selected' : '' ?>>Medium</option>
        <option value="High" <?= old('priority') == 'High' ? 'selected' : '' ?>>High</option>
    </select>
    
    <button type="submit">Submit Ticket</button>
</form>

<style>


.new-issue-form {
    display: flex;
    flex-direction: column;
    gap: 6px;
    width: 100%;
    height: 100%;
    padding: 5px;
    box-sizing: border-box;
    background-color: var(--body-color); 
}

.new-issue-form input,
.new-issue-form textarea,
.new-issue-form select,
.new-issue-form button {
    width: 100%;
    padding: 12px;
    font-size: 16px;
    border-radius: 6px;
    border: 1px solid #ccc;
    box-sizing: border-box;
}

.new-issue-form textarea {
    resize: vertical;
    min-height: 120px;
}

.new-issue-form button {
    background-color: #4CAF50;
    color: white;
    border: none;
    cursor: pointer;
    font-weight: bold;
}

.new-issue-form button:hover {
    background-color: #45a049;
}
</style>
    </div>
<?php endif; ?>

</div>

<div class="content">