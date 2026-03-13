<?= view('ticket/side') ?>

<?php
// Get root tasks
$rootTickets = array_filter($tickets ?? [], fn($t) => (int)$t['parent_id'] === 0);

// Helper: get subtasks for a parent
function getSubtasksByLevel($allTickets, $parentId) {
    $subtasks = array_filter($allTickets, fn($t) => (int)$t['parent_id'] === (int)$parentId);
    $levels = [];
    foreach ($subtasks as $task) {
        $levels[$task['task_level']][] = $task;
    }
    ksort($levels); // sort by level ascending
    return $levels;
}
?>

<div class="dashboard-wrapper">
    <h2 class="page-title"><?= esc($pageTitle ?? 'Projects Overview') ?></h2>

    <?php if (!empty($rootTickets)): ?>
        <?php foreach ($rootTickets as $root): ?>
            <div class="project-card">
                <div class="project-header">
                    <div class="header-main">
                        <span class="root-id">#<?= $root['id'] ?></span>
                        <span class="root-title"><?= esc($root['title']) ?></span>
                    </div>
                    <div class="header-meta">
                        <span class="type-badge"><?= $root['ticket_type'] ?></span>
                        <span class="status-pill"><?= $root['status'] ?></span>
                    </div>
                </div>

                <div class="table-responsive">
                    <?php
                        $levels = getSubtasksByLevel($tickets, $root['id']);
                        if (!empty($levels)):
                    ?>
                    <table class="child-table">
                        <thead>
                            <tr>
                                <th>Level</th>
                                <th>Tasks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($levels as $lvl => $tasks): ?>
                                <tr>
                                    <td>Level <?= $lvl ?></td>
                                    <td>
                                        <?php foreach ($tasks as $task): ?>
                                            <div class="task-box">
                                                <span class="task-title"><?= esc($task['title']) ?></span>
                                                <span class="task-meta">(Dept: <?= esc($task['department']) ?> | Priority: <?= $task['priority'] ?> | Status: <?= $task['status'] ?>)</span>
                                                <a href="<?= base_url('ticket/view/'.$task['id']) ?>" class="btn-view">View</a>
                                            </div>
                                        <?php endforeach; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php else: ?>
                        <p class="empty-state">No tasks found for this project.</p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="empty-dashboard">
            <p>No main projects available to display.</p>
        </div>
    <?php endif; ?>
</div>

<style>
.dashboard-wrapper { padding: 20px; max-width: 1200px; margin: 0 auto; font-family: 'Segoe UI', sans-serif; }
.page-title { color: #1e293b; margin-bottom: 25px; font-weight: 500; font-size: 1.8rem; }

/* Project Card */
.project-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 10px; width: 100%; margin-bottom: 20px; padding: 15px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }

/* Header */
.project-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; }
.header-main { display: flex; flex-direction: column; }
.root-id { color: #94a3b8; font-weight: bold; font-family: monospace; }
.root-title { font-weight: 600; font-size: 1.1rem; margin-top: 2px; }
.type-badge { font-size: 0.65rem; background: #f1f5f9; padding: 2px 6px; border-radius: 4px; text-transform: uppercase; margin-right: 5px; }
.status-pill { font-size: 0.7rem; background: #10b981; color: #fff; padding: 2px 8px; border-radius: 12px; font-weight: 600; }

/* Table */
.table-responsive { overflow-x: auto; }
.child-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
.child-table th, .child-table td { border: 1px solid #e2e8f0; padding: 10px; font-size: 0.9rem; text-align: left; }
.child-table th { background: #f1f5f9; text-transform: uppercase; font-size: 0.75rem; }

/* Task Box inside cell */
.task-box { margin-bottom: 6px; padding: 5px; border: 1px solid #e2e8f0; border-radius: 6px; background: #f8fafc; display: flex; flex-wrap: wrap; align-items: center; gap: 8px; }
.task-title { font-weight: 600; }
.task-meta { font-size: 0.75rem; color: #64748b; }
.btn-view { font-size: 0.7rem; padding: 3px 8px; background: #3b82f6; color: #fff; border-radius: 4px; text-decoration: none; }
.btn-view:hover { background: #2563eb; }

/* Empty states */
.empty-state, .empty-dashboard { text-align: center; color: #94a3b8; padding: 20px; font-style: italic; }
</style>