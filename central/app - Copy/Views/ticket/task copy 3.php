<?= view('ticket/side') ?>

<?php
/**
 * Renders tasks and their children recursively with edit/add controls
 */
function renderTaskTree($tasks) {
    echo '<ul class="task-tree shadow-sm">';
    foreach ($tasks as $task) {
        $isDone = ($task['status'] !== 'open');
        $taskId = esc($task['id'] ?? rand(100, 999)); // Fallback ID for demo
        ?>
        <li class="task-node" data-id="<?= $taskId ?>">
            <div class="task-row <?= $isDone ? 'is-complete' : '' ?>">
                <div class="task-main">
                    <input type="checkbox" class="task-check" <?= $isDone ? 'checked' : '' ?> 
                           onchange="toggleTaskStatus(this)">
                    
                    <span class="task-title" contenteditable="true" 
                          onblur="saveTaskChange(<?= $taskId ?>, 'title', this.innerText)">
                        <?= esc($task['title']) ?>
                    </span>
                </div>

                <div class="task-actions">
                    <button onclick="addNewSubTask(<?= $taskId ?>)" class="btn-add" title="Add Sub-task">+</button>
                    <button onclick="deleteTask(<?= $taskId ?>)" class="btn-delete" title="Delete">×</button>
                </div>
            </div>

            <div class="sub-task-wrapper">
                <?php if (!empty($task['children'])) renderTaskTree($task['children']); ?>
            </div>
        </li>
        <?php
    }
    echo '</ul>';
}
?>

<div class="container project-dashboard">
    <header class="main-header">
        <h1><?= esc($pageTitle) ?></h1>
        <button class="btn-primary" onclick="alert('Create new top-level project logic here')">+ New Project</button>
    </header>

    <div class="projects-grid">
        <?php foreach ($tickets as $project): ?>
            <?php
                // Logic for progress bar
                $total = count($project['children'] ?? []);
                $done = array_reduce($project['children'] ?? [], function($c, $i) { 
                    return $c + ($i['status'] !== 'open' ? 1 : 0); 
                }, 0);
                $percent = $total > 0 ? round(($done / $total) * 100) : 0;
            ?>
            <div class="card project-card">
                <div class="card-header">
                    <h2 contenteditable="true"><?= esc($project['title']) ?></h2>
                    <span class="progress-badge"><?= $percent ?>%</span>
                </div>
                
                <p class="project-desc"><?= esc($project['description']) ?></p>

                <div class="progress-bar-container">
                    <div class="progress-fill" style="width: <?= $percent ?>%"></div>
                </div>

                <div class="task-section">
                    <?php if (!empty($project['children'])) renderTaskTree($project['children']); ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<style>
    :root {
        --primary: #6366f1;
        --bg: #f8fafc;
        --card: #ffffff;
        --border: #e2e8f0;
        --text: #334155;
        --success: #10b981;
    }

    body { background: var(--bg); color: var(--text); font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
    
    .project-card {
        background: var(--card);
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 30px;
        border: 1px solid var(--border);
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
    }

    .card-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; }
    
    /* Progress Bar */
    .progress-bar-container { background: #eee; height: 6px; border-radius: 10px; margin-bottom: 20px; overflow: hidden; }
    .progress-fill { background: var(--primary); height: 100%; transition: width 0.4s ease; }

    /* Task Tree Hierarchy */
    .task-tree { list-style: none; padding-left: 20px; border-left: 2px solid var(--border); margin: 10px 0; }
    .task-node { margin: 8px 0; position: relative; }
    
    .task-row { 
        display: flex; justify-content: space-between; align-items: center; 
        padding: 8px 12px; border: 1px solid var(--border); border-radius: 8px;
        background: white; transition: all 0.2s;
    }
    .task-row:hover { border-color: var(--primary); box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
    .task-row.is-complete .task-title { text-decoration: line-through; opacity: 0.6; }

    .task-main { display: flex; align-items: center; gap: 12px; flex-grow: 1; }
    .task-title { cursor: text; outline: none; padding: 2px 4px; display: block; width: 100%; }
    
    .task-actions { opacity: 0; transition: opacity 0.2s; }
    .task-node:hover > .task-row .task-actions { opacity: 1; }

    .btn-add, .btn-delete { border: none; background: #f1f5f9; cursor: pointer; border-radius: 4px; width: 24px; height: 24px; }
    .btn-add:hover { background: var(--primary); color: white; }
    .btn-delete:hover { background: #ef4444; color: white; }
</style>

<script>
    // Update Task Title or Status via Fake API
    function saveTaskChange(id, field, value) {
        console.log(`Saving Task ${id}: ${field} = ${value}`);
        // In reality, use fetch() here to talk to your Controller
    }

    // Toggle Checkbox
    function toggleTaskStatus(checkbox) {
        const row = checkbox.closest('.task-row');
        row.classList.toggle('is-complete', checkbox.checked);
        const taskId = checkbox.closest('.task-node').dataset.id;
        saveTaskChange(taskId, 'status', checkbox.checked ? 'done' : 'open');
    }

    // Add a New Sub-Task (Recursive UI Injection)
    function addNewSubTask(parentId) {
        const title = prompt("Enter sub-task name:");
        if (!title) return;

        const parentNode = document.querySelector(`[data-id="${parentId}"]`);
        const wrapper = parentNode.querySelector('.sub-task-wrapper');
        
        // Ensure there's a UL to hold sub-tasks
        let subList = wrapper.querySelector('.task-tree');
        if (!subList) {
            subList = document.createElement('ul');
            subList.className = 'task-tree shadow-sm';
            wrapper.appendChild(subList);
        }

        const newId = Date.now(); // Temporary unique ID
        const li = document.createElement('li');
        li.className = 'task-node';
        li.dataset.id = newId;
        li.innerHTML = `
            <div class="task-row">
                <div class="task-main">
                    <input type="checkbox" class="task-check" onchange="toggleTaskStatus(this)">
                    <span class="task-title" contenteditable="true" onblur="saveTaskChange(${newId}, 'title', this.innerText)">${title}</span>
                </div>
                <div class="task-actions">
                    <button onclick="addNewSubTask(${newId})" class="btn-add">+</button>
                    <button onclick="deleteTask(${newId})" class="btn-delete">×</button>
                </div>
            </div>
            <div class="sub-task-wrapper"></div>
        `;
        subList.appendChild(li);
    }

    function deleteTask(id) {
        if(confirm("Delete this task and all its sub-tasks?")) {
            document.querySelector(`[data-id="${id}"]`).remove();
        }
    }
</script>