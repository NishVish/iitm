<?= view('ticket/side') ?>

<?php
/**
 * 1. LOGIC 
 * We group everything by the root parent and sort by level.
 */

// 1. Get all Root tickets (Parent ID 0)
$rootTickets = array_filter($tickets ?? [], fn($t) => (int)$t['parent_id'] === 0);

// 2. Helper to get all sub-items for a root
if (!function_exists('getSubtasksForRoot')) {
    function getSubtasksForRoot($allTickets, $rootId) {
        $subtasks = array_filter($allTickets, fn($t) => (int)$t['parent_id'] === (int)$rootId);
        // Sort by level so they appear in a logical top-down order
        usort($subtasks, fn($a, $b) => $a['task_level'] <=> $b['task_level']);
        return $subtasks;
    }
}
?>

<div class="dashboard-wrapper">
    <h2 class="page-title"><?= esc($pageTitle ?? 'Task Management') ?></h2>

    <?php if (!empty($rootTickets)): ?>
        <?php foreach ($rootTickets as $root): 
            $subtasks = getSubtasksForRoot($tickets, $root['id']);
        ?>
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
                    <table class="child-table">
                        <thead>
                            <tr>
                                <th>Hierarchy (Level)</th>
                                <th>Department</th>
                                <th>Priority</th>
                                <th>Status</th>
                                <th style="text-align:right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($subtasks)): ?>
                                <?php foreach ($subtasks as $row): ?>
                                    <tr>
                                        <td class="task-cell" style="padding-left: <?= ($row['task_level'] * 30) ?>px;">
                                            <span class="tree-line">↳</span>
                                            <span class="task-text">
                                                <?= esc($row['title']) ?>
                                                <small class="lvl-tag">LVL <?= $row['task_level'] ?></small>
                                            </span>
                                            <span class="row-id">#<?= $row['id'] ?></span>
                                        </td>
                                        <td><?= esc($row['department']) ?></td>
                                        <td>
                                            <span class="pri-label pri-<?= strtolower($row['priority']) ?>">
                                                <?= $row['priority'] ?>
                                            </span>
                                        </td>
                                        <td><span class="status-text"><?= $row['status'] ?></span></td>
                                        <td style="text-align:right">
                                            <a href="<?= base_url('ticket/view/'.$row['id']) ?>" class="btn-view">View</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="empty-state">No sub-levels found for this root task.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="empty-dashboard">
            <p>No main tickets available to display.</p>
        </div>
    <?php endif; ?>
</div>

<style>
/* Reset & Base */
.dashboard-wrapper, .dashboard-wrapper * { box-sizing: border-box; font-family: 'Segoe UI', system-ui, sans-serif; }
.dashboard-wrapper { padding: 20px; max-width: 1400px; margin: 0 auto; }
.page-title { color: #1e293b; margin-bottom: 25px; font-weight: 300; font-size: 1.8rem; }

/* The Card Container */
.project-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    margin-bottom: 40px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
}

/* Header Styling */
.project-header {
    background: #1e293b; /* Darker professional header */
    color: #f8fafc;
    padding: 18px 25px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.header-main { display: flex; align-items: center; gap: 12px; }
.root-id { color: #94a3b8; font-weight: bold; font-family: monospace; }
.root-title { font-size: 1.15rem; font-weight: 600; }
.type-badge { font-size: 0.7rem; background: rgba(255,255,255,0.1); padding: 2px 8px; border-radius: 4px; border: 1px solid rgba(255,255,255,0.2); text-transform: uppercase; }
.status-pill { font-size: 0.8rem; background: #10b981; padding: 3px 12px; border-radius: 20px; font-weight: 600; }

/* Table Styling */
.child-table { width: 100%; border-collapse: collapse; }
.child-table th { 
    background: #f8fafc; 
    padding: 12px 20px; 
    text-align: left; 
    font-size: 0.7rem; 
    text-transform: uppercase; 
    letter-spacing: 1px; 
    color: #64748b;
    border-bottom: 2px solid #f1f5f9;
}
.child-table td { padding: 14px 20px; border-bottom: 1px solid #f1f5f9; font-size: 0.95rem; color: #334155; }

/* Hierarchy Visuals */
.task-cell { display: flex; align-items: center; }
.tree-line { color: #cbd5e1; margin-right: 12px; font-weight: bold; font-size: 1.2rem; }
.lvl-tag { font-size: 0.65rem; color: #94a3b8; border: 1px solid #e2e8f0; padding: 1px 4px; border-radius: 3px; margin-left: 8px; font-weight: bold; vertical-align: middle; }
.row-id { color: #cbd5e1; font-size: 0.75rem; margin-left: auto; font-weight: normal; font-family: monospace; }

/* Priority Colors */
.pri-label { font-size: 0.75rem; font-weight: 700; text-transform: uppercase; }
.pri-urgent { color: #e11d48; }
.pri-high { color: #f59e0b; }
.pri-medium { color: #0ea5e9; }
.pri-low { color: #94a3b8; }

.status-text { font-size: 0.85rem; color: #64748b; }

.btn-view { text-decoration: none; color: #475569; border: 1px solid #e2e8f0; padding: 5px 12px; border-radius: 6px; font-size: 0.8rem; transition: all 0.2s; background: #fff; }
.btn-view:hover { background: #f8fafc; border-color: #cbd5e1; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
.empty-state { text-align: center; color: #94a3b8; padding: 40px !important; font-style: italic; }
</style>