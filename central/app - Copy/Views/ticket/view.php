<?= view('ticket/side', get_defined_vars()) ?>

<?php
function buildTree($tickets, $parentId = 0) {
    $branch = [];

    foreach ($tickets as $ticket) {
        if ((int)$ticket['parent_id'] === (int)$parentId) {
            $children = buildTree($tickets, $ticket['id']);
            if ($children) {
                $ticket['children'] = $children;
            }
            $branch[] = $ticket;
        }
    }

    return $branch;
}

$tree = buildTree($tickets, $ticket['id']);

function renderTree($tree)
{
    if (!$tree) return;

    echo '<div class="level-row">';

    foreach ($tree as $node) {
        ?>
        <div class="task-card">
            <div class="task-title">
                #<?= $node['id'] ?> <?= esc($node['title']) ?>
            </div>

            <div class="task-meta">
                <?= esc($node['status']) ?> | <?= esc($node['priority']) ?>
            </div>

            <div class="task-actions">
                <a href="<?= base_url('ticket/view/'.$node['id']) ?>">Open</a>
            </div>

            <?php
            if (isset($node['children'])) {
                renderTree($node['children']);
            }
            ?>
        </div>
        <?php
    }

    echo '</div>';
}
?>

<div class="dashboard-container">

    <!-- MAIN PROJECT -->
    <div class="main-card">
        <h2><?= esc($ticket['title']) ?></h2>
        <p><?= esc($ticket['description']) ?></p>

        <div class="meta">
            Status: <?= esc($ticket['status']) ?> |
            Priority: <?= esc($ticket['priority']) ?>
        </div>
    </div>

    <!-- SUBTASK TREE -->
    <?php renderTree($tree); ?>

</div>

<style>
.dashboard-container {
    max-width: 1200px;
    margin: 30px auto;
    font-family: Arial, sans-serif;
}

.main-card {
    background: #ffffff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    margin-bottom: 40px;
}

.meta {
    margin-top: 10px;
    font-size: 14px;
    color: #666;
}

/* LEVEL ROW (siblings horizontal) */
.level-row {
    display: flex;
    gap: 20px;
    margin-left: 40px;
    margin-top: 20px;
    flex-wrap: wrap;
}

/* TASK CARD */
.task-card {
    background: #f8fafc;
    border-left: 4px solid #3b82f6;
    padding: 15px;
    border-radius: 8px;
    min-width: 250px;
    max-width: 300px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.task-title {
    font-weight: bold;
    margin-bottom: 6px;
}

.task-meta {
    font-size: 13px;
    color: #555;
    margin-bottom: 10px;
}

.task-actions a {
    font-size: 12px;
    text-decoration: none;
    color: #2563eb;
}
</style>