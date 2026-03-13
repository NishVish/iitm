<?= view('ticket/side') ?>

<?php
/**
 * Recursive function to render tasks side-by-side
 */
function renderHorizontalTasks($tasks, $parentId) {
    // This container ensures all tasks at this specific level are side-by-side
    echo '<div class="sibling-wrapper">';
    foreach ($tasks as $task) {
        $taskId = esc($task['id']);
        $isDone = ($task['status'] !== 'open');
        ?>

<div class="task-node" data-id="<?= $taskId ?>" data-parent="<?= $parentId ?>">

    <table class="task-table <?= $isDone ? 'is-complete' : '' ?>">
        <tr>
            <td>
                <input type="checkbox"
                       <?= $isDone ? 'checked' : '' ?>
                       onchange="toggleStatus(this)">
            </td>
            <td>
                <span contenteditable="true"
                      onblur="updateTask(<?= $taskId ?>, this.innerText)">
                    <?= esc($task['title']) ?>
                </span>
            </td>
            <td>
                <button onclick="addNewTask(<?= $taskId ?>)">+</button>
            </td>
        </tr>
    </table>

    <div class="child-container">
        <?php if (!empty($task['children'])) renderHorizontalTasks($task['children'], $taskId); ?>
    </div>

</div>
        <!-- <div class="task-node" data-id="<?= $taskId ?>" data-parent="<?= $parentId ?>">
            <div class="task-box <?= $isDone ? 'is-complete' : '' ?>">
                <div class="task-inner">
                    <input type="checkbox" <?= $isDone ? 'checked' : '' ?> onchange="toggleStatus(this)">
                    <span class="task-text" contenteditable="true" onblur="updateTask(<?= $taskId ?>, this.innerText)">
                        <?= esc($task['title']) ?>
                    </span>
                    <button class="add-sub-btn" onclick="addNewTask(<?= $taskId ?>)" title="Add Child">+</button>
                <br>
                <div class="child-container">
                <?php if (!empty($task['children'])) renderHorizontalTasks($task['children'], $taskId); ?>
            </div>
        
        </div>
            </div>

            
        </div> -->
        <?php
    }
    echo '</div>';
}
?>

<div class="board-container">
    <?php foreach ($tickets as $project): ?>
        <div class="project-section" data-id="<?= $project['id'] ?>">
            <div class="parent-card">
                <div class="parent-info">
                    <h2><?= esc($project['title']) ?> <small>#<?= $project['id'] ?></small></h2>
                    <button class="btn-main-add" onclick="addNewTask(<?= $project['id'] ?>)">Add Task</button>
                </div>
            </div>

            <div class="flow-area">
                <?php if (!empty($project['children'])) renderHorizontalTasks($project['children'], $project['id']); ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<style>
    :root { --primary: #6366f1; --border: #e2e8f0; --bg: #f8fafc; }
    body { background: var(--bg); font-family: 'Inter', sans-serif; color: #1e293b; }

    .project-section { margin-bottom: 50px; padding: 20px; background: white; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); }
    
    /* Level 0 Parent Header */
    .parent-card { margin-bottom: 20px; padding-bottom: 15px; border-bottom: 2px solid #f1f5f9; }
    .parent-info { display: flex; justify-content: space-between; align-items: center; }
    .btn-main-add { background: var(--primary); color: white; border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer; font-weight: 600; }

    /* Horizontal Flow Logic */
    .flow-area { overflow-x: auto; padding-top: 10px; }
    .sibling-wrapper { 
        display: flex; 
        flex-direction: row; /* THIS puts siblings next to each other */
        gap: 20px; 
        align-items: flex-start;
    }

    .task-node { display: flex; flex-direction: column; min-width: 240px; }
    
    /* Task Box Styling */
    .task-box { 
        background: #fff; border: 1px solid var(--border); border-radius: 8px; 
        padding: 12px; transition: all 0.2s; position: relative;
    }
    .task-box:hover { border-color: var(--primary); box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); }
    
    .task-inner { display: flex; align-items: center; gap: 10px; }
    .task-text { flex-grow: 1; outline: none; font-size: 14px; }
    
    .add-sub-btn { background: #f1f5f9; border: none; width: 24px; height: 24px; border-radius: 4px; cursor: pointer; display: flex; align-items: center; justify-content: center; }
    .add-sub-btn:hover { background: var(--primary); color: white; }

    /* Vertical line to show child relationship */
    .child-container { 
        margin-top: 20px; 
        padding-top: 10px; 
        border-top: 2px dashed #e2e8f0; 
        position: relative;
    }

    .is-complete .task-text { text-decoration: line-through; opacity: 0.5; }
</style>

<script>
    function toggleStatus(el) {
        el.closest('.task-node').classList.toggle('is-complete', el.checked);
    }

    function updateTask(id, text) {
        console.log("Saving Task:", id, "Text:", text);
    }

    function addNewTask(parentId) {
        const title = prompt("Task title:");
        if (!title) return;

        // 1. Find the correct container for siblings
        let container;
        const parentTaskNode = document.querySelector(`.task-node[data-id="${parentId}"]`);
        
        if (parentTaskNode) {
            // Adding a child to a Level 1+ task
            const childContainer = parentTaskNode.querySelector('.child-container');
            container = childContainer.querySelector('.sibling-wrapper');
            if (!container) {
                container = document.createElement('div');
                container.className = 'sibling-wrapper';
                childContainer.appendChild(container);
            }
        } else {
            // Adding Level 1 task to the Project
            const projectSection = document.querySelector(`.project-section[data-id="${parentId}"]`);
            const flowArea = projectSection.querySelector('.flow-area');
            container = flowArea.querySelector('.sibling-wrapper');
            if (!container) {
                container = document.createElement('div');
                container.className = 'sibling-wrapper';
                flowArea.appendChild(container);
            }
        }

        // 2. Inject the New Task
        const newId = Date.now();
        const taskHtml = `
            <div class="task-node" data-id="${newId}" data-parent="${parentId}">
                <div class="task-box">
                    <div class="task-inner">
                        <input type="checkbox" onchange="toggleStatus(this)">
                        <span class="task-text" contenteditable="true" onblur="updateTask(${newId}, this.innerText)">${title}</span>
                        <button class="add-sub-btn" onclick="addNewTask(${newId})">+</button>
                    </div>
                </div>
                <div class="child-container"></div>
            </div>
        `;
        
        container.insertAdjacentHTML('beforeend', taskHtml);
    }
</script>