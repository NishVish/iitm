<?= view('ticket/side') ?>

<style>
    .issue-container { padding: 20px; max-width: 1400px; margin: 0 auto; font-family: 'Segoe UI', sans-serif; }
    .project-card { 
        background: #fff; border: 1px solid #e2e8f0; border-radius: 10px; 
        margin-bottom: 30px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); 
    }

    /* Card Header Styling */
    .card-header-main { 
        background: #1e293b; color: #fff; padding: 15px 20px; 
        display: flex; justify-content: space-between; align-items: center; 
    }
    .header-info h2 { margin: 0; font-size: 1.2rem; }
    .header-info span { font-size: 0.8rem; opacity: 0.7; }

    /* Table Styling */
    .child-table { width: 100%; border-collapse: collapse; }
    .child-table th { background: #f8fafc; padding: 12px 15px; text-align: left; font-size: 0.75rem; color: #64748b; border-bottom: 1px solid #e2e8f0; }
    .child-table td { padding: 12px 15px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }

    /* Inline Editing Styles */
    .display-mode { display: block; }
    .edit-mode { display: none; }
    
    input[type="text"].edit-input, select.edit-input, textarea.edit-input {
        width: 100%; padding: 5px; border: 1px solid #3b82f6; border-radius: 4px; font-size: 0.9rem;
    }

    /* Hierarchy Visuals */
    .lvl-indent { display: inline-block; color: #cbd5e1; margin-right: 10px; font-weight: bold; }
    
    /* Buttons */
    .btn-action { padding: 5px 10px; border-radius: 4px; border: none; cursor: pointer; font-size: 0.8rem; }
    .edit-btn { background: #3b82f6; color: white; }
    .save-btn { background: #10b981; color: white; }
    .cancel-btn { background: #64748b; color: white; margin-left: 5px; }

    .pri-Urgent { color: #ef4444; font-weight: bold; }
    .pri-High { color: #f59e0b; }
</style>

<div class="issue-container">
    <div class="header-section">
        <h2>Hierarchy & Task Management</h2>
        <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>
    </div>

    <?php 
    // Filter Roots (Parent ID 0)
    $roots = array_filter($ticket, fn($t) => (int)$t['parent_id'] === 0);
    foreach($roots as $root): 
        // Get subtasks for this specific root
        $subtasks = array_filter($ticket, fn($t) => (int)$t['parent_id'] === (int)$root['id']);
        usort($subtasks, fn($a, $b) => $a['task_level'] <=> $b['task_level']);
    ?>
    <div class="project-card" id="project-<?= $root['id'] ?>">
        <div class="card-header-main">
            <div class="header-info">
                <span>ROOT PROJECT #<?= $root['id'] ?></span>
                <h2><?= esc($root['title']) ?></h2>
            </div>
            <div class="header-actions">
                <span class="status-pill"><?= $root['status'] ?></span>
            </div>
        </div>

        <table class="child-table">
            <thead>
                <tr>
                    <th style="width: 40%;">Task / Subtask</th>
                    <th>Dept</th>
                    <th>Priority</th>
                    <th>Status</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php array_unshift($subtasks, $root); ?>
                
                <?php foreach($subtasks as $t): ?>
                <tr class="task-row" id="row-<?= $t['id'] ?>">
                    <form method="post" action="<?= base_url('ticket/update/'.$t['id']) ?>">
                        <?= csrf_field() ?>
                        
                        <td style="padding-left: <?= ($t['task_level'] * 30) + 15 ?>px;">
                            <?php if($t['task_level'] > 0): ?>
                                <span class="lvl-indent">↳</span>
                            <?php endif; ?>
                            
                            <span class="display-mode"><?= esc($t['title']) ?></span>
                            <input type="text" name="title" value="<?= esc($t['title']) ?>" class="edit-mode edit-input">
                        </td>

                        <td>
                            <span class="display-mode"><?= esc($t['department'] ?? '-') ?></span>
                            <input type="text" name="department" value="<?= esc($t['department']) ?>" class="edit-mode edit-input">
                        </td>

                        <td>
                            <span class="display-mode pri-<?= $t['priority'] ?>"><?= $t['priority'] ?></span>
                            <select name="priority" class="edit-mode edit-input">
                                <option value="Low" <?= $t['priority'] == 'Low' ? 'selected' : '' ?>>Low</option>
                                <option value="Medium" <?= $t['priority'] == 'Medium' ? 'selected' : '' ?>>Medium</option>
                                <option value="High" <?= $t['priority'] == 'High' ? 'selected' : '' ?>>High</option>
                                <option value="Urgent" <?= $t['priority'] == 'Urgent' ? 'selected' : '' ?>>Urgent</option>
                            </select>
                        </td>

                        <td>
                            <span class="display-mode"><?= $t['status'] ?></span>
                            <select name="status" class="edit-mode edit-input">
                                <option value="Open" <?= $t['status'] == 'Open' ? 'selected' : '' ?>>Open</option>
                                <option value="In Progress" <?= $t['status'] == 'In Progress' ? 'selected' : '' ?>>In Progress</option>
                                <option value="Resolved" <?= $t['status'] == 'Resolved' ? 'selected' : '' ?>>Resolved</option>
                            </select>
                        </td>

                        <td style="text-align:right;">
                            <button type="button" class="btn-action edit-btn display-mode">Edit</button>
                            <div class="edit-mode">
                                <button type="submit" class="btn-action save-btn">Save</button>
                                <button type="button" class="btn-action cancel-btn">X</button>
                            </div>
                        </td>
                    </form>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endforeach; ?>
</div>

<script>
document.querySelectorAll('.task-row').forEach(row => {
    const editBtn = row.querySelector('.edit-btn');
    const cancelBtn = row.querySelector('.cancel-btn');
    const displayElements = row.querySelectorAll('.display-mode');
    const editElements = row.querySelectorAll('.edit-mode');

    editBtn.addEventListener('click', () => {
        displayElements.forEach(el => el.style.display = 'none');
        editElements.forEach(el => el.style.display = 'inline-block');
    });

    cancelBtn.addEventListener('click', () => {
        displayElements.forEach(el => el.style.display = 'inline-block');
        editElements.forEach(el => el.style.display = 'none');
    });
});
</script>