<?= view('ticket/side') ?>
<?php
$userModel = new \App\Models\UserModel();
$users = $userModel->getAllUsers();
$session = session();

// var_dump($session);
// exit;
$userId   = $session->get('user_id');   // returns user id
$userName = $session->get('name');      // returns user name

echo "Logged in user: $userName (ID: $userId)";
?>
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

    // Fill hidden form
    document.getElementById('hidden_title').value = title;
    document.getElementById('hidden_parent_id').value = parentId;

    // Optional: auto-calc level
    const parentNode = document.querySelector(`.task-node[data-id="${parentId}"]`);
    if (parentNode) {
        let parentLevel = parseInt(parentNode.dataset.level || 0);
        document.getElementById('hidden_task_level').value = parentLevel + 1;
    } else {
        document.getElementById('hidden_task_level').value = 0;
    }

    // Submit
    document.getElementById('form').submit();
}

// function addNewTask(parentId) {
//     const title = prompt("Enter task title:");
//     if (!title) return;

//     // Prepare data to send to server
//     const data = {
//         title: title,
//         parent_id: parentId,
//         task_level: 0,  // we will calculate below
//         user_id: <?= $userId ?>,
//         ticket_type: 'Task',
//         priority: 'Medium',
//         status: 'Open',
//         description: ''
//     };

//     // Calculate task level based on parent
//     const parentNode = document.querySelector(`.task-node[data-id="${parentId}"]`);
//     if (parentNode) {
//         const parentLevel = parseInt(parentNode.dataset.level || 0);
//         data.task_level = parentLevel + 1;
//     } else {
//         data.task_level = 0;
//     }

//         if (parentTaskNode) {
//             // Adding a child to a Level 1+ task
//             const childContainer = parentTaskNode.querySelector('.child-container');
//             container = childContainer.querySelector('.sibling-wrapper');
//             if (!container) {
//                 container = document.createElement('div');
//                 container.className = 'sibling-wrapper';
//                 childContainer.appendChild(container);
//             }
//         } else {
//             // Adding Level 1 task to the Project
//             const projectSection = document.querySelector(`.project-section[data-id="${parentId}"]`);
//             const flowArea = projectSection.querySelector('.flow-area');
//             container = flowArea.querySelector('.sibling-wrapper');
//             if (!container) {
//                 container = document.createElement('div');
//                 container.className = 'sibling-wrapper';
//                 flowArea.appendChild(container);
//             }
//         }

//         // 2. Inject the New Task
//         const newId = Date.now();
//         const taskHtml = `
//             <div class="task-node" data-id="${newId}" data-parent="${parentId}">
//                 <div class="task-box">
//                     <div class="task-inner">
//                         <input type="checkbox" onchange="toggleStatus(this)">
//                         <span class="task-text" contenteditable="true" onblur="updateTask(${newId}, this.innerText)">${title}</span>
//                         <button class="add-sub-btn" onclick="addNewTask(${newId})">+</button>
//                     </div>
//                 </div>
//                 <div class="child-container"></div>
//             </div>
//         `;
        
//         container.insertAdjacentHTML('beforeend', taskHtml);
//     // Send AJAX request to server
//     fetch("<?= base_url('ticket/store') ?>", {
//         method: "POST",
//         headers: {
//             "Content-Type": "application/json",
//             "X-Requested-With": "XMLHttpRequest",
//             "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
//         },
//         body: JSON.stringify(data)
//     })
//     .then(res => res.json())
//     .then(response => {
//         if(response.success) {
//             const newTaskId = response.id;

//             // Create HTML for new task
//             const taskHtml = `
//                 <div class="task-node" data-id="${newTaskId}" data-parent="${parentId}" data-level="${data.task_level}">
//                     <table class="task-table">
//                         <tr>
//                             <td><input type="checkbox" onchange="toggleStatus(this)"></td>
//                             <td><span contenteditable="true" onblur="updateTask(${newTaskId}, this.innerText)">${title}</span></td>
//                             <td><button onclick="addNewTask(${newTaskId})">+</button></td>
//                         </tr>
//                     </table>
//                     <div class="child-container"></div>
//                 </div>
//             `;

//             // Find or create sibling-wrapper container
//             let container;
//             if(parentNode) {
//                 const childContainer = parentNode.querySelector('.child-container');
//                 container = childContainer.querySelector('.sibling-wrapper');
//                 if(!container) {
//                     container = document.createElement('div');
//                     container.className = 'sibling-wrapper';
//                     childContainer.appendChild(container);
//                 }
//             } else {
//                 const projectSection = document.querySelector(`.project-section[data-id="${parentId}"]`);
//                 const flowArea = projectSection.querySelector('.flow-area');
//                 container = flowArea.querySelector('.sibling-wrapper');
//                 if(!container) {
//                     container = document.createElement('div');
//                     container.className = 'sibling-wrapper';
//                     flowArea.appendChild(container);
//                 }
//             }

//             // Insert the new task into the DOM
//             container.insertAdjacentHTML('beforeend', taskHtml);

//         } else {
//             alert("Error saving task.");
//         }
//     })
//     .catch(err => {
//         console.error(err);
//         alert("Failed to save task.");
//     });
// }

function addNewTask(parentId) {
    const title = prompt("Enter task title:");
    if (!title) return;

    // 1. Find the Parent Element to calculate levels and find containers
    // We check for .task-node (if adding a subtask) or .project-section (if adding level 1)
    const parentNode = document.querySelector(`.task-node[data-id="${parentId}"]`);
    const projectSection = document.querySelector(`.project-section[data-id="${parentId}"]`);
    
    let taskLevel = 0;
    if (parentNode) {
        const parentLevel = parseInt(parentNode.dataset.level || 0);
        taskLevel = parentLevel + 1;
    }

    // 2. Prepare data for the server
    const data = {
        title: title,
        parent_id: parentId,
        task_level: taskLevel,
        user_id: <?= $userId ?>,
        ticket_type: 'Task',
        priority: 'Medium',
        status: 'Open',
        description: ''
    };

    // 3. Send AJAX request
    fetch("<?= base_url('ticket/storeajax') ?>", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-Requested-With": "XMLHttpRequest",
            "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
        },
        body: JSON.stringify(data)
    })
    .then(res => res.json())
    .then(response => {
        if (response.success) {
            const newTaskId = response.id;
            let container;

            // 4. Identify the correct container for the new sibling
            if (parentNode) {
                // We are adding a sub-task (Child of a Task)
                const childArea = parentNode.querySelector('.child-container');
                container = childArea.querySelector('.sibling-wrapper');
                
                if (!container) {
                    container = document.createElement('div');
                    container.className = 'sibling-wrapper';
                    childArea.appendChild(container);
                }
            } else if (projectSection) {
                // We are adding a Level 1 task (Child of a Project)
                const flowArea = projectSection.querySelector('.flow-area');
                container = flowArea.querySelector('.sibling-wrapper');
                
                if (!container) {
                    container = document.createElement('div');
                    container.className = 'sibling-wrapper';
                    flowArea.appendChild(container);
                }
            }

            // 5. Create the Table-based HTML for the new task
            const taskHtml = `
                <div class="task-node" data-id="${newTaskId}" data-parent="${parentId}" data-level="${taskLevel}">
                    <table class="task-table-box">
                        <tr>
                            <td class="td-check"><input type="checkbox" onchange="toggleStatus(this)"></td>
                            <td class="td-title">
                                <span class="task-text" contenteditable="true" onblur="updateTask(${newTaskId}, this.innerText)">${title}</span>
                            </td>
                            <td class="td-add">
                                <button class="btn-sub-add" onclick="addNewTask(${newTaskId})">+</button>
                            </td>
                        </tr>
                    </table>
                    <div class="child-container"></div>
                </div>
            `;

            if (container) {
                container.insertAdjacentHTML('beforeend', taskHtml);
            } else {
                console.error("Could not find a valid container to inject the task.");
                // Fallback: if it's the very first task, you might want to reload or 
                // handle the creation of the initial flow-area here.
            }

        } else {
            alert("Error saving task: " + (response.message || "Unknown error"));
        }
    })
    .catch(err => {
        console.error("AJAX Error:", err);
        alert("Failed to save task. Please check your connection.");
    });
}
document.getElementById('parent_search').addEventListener('input', function(e) {
    const list = document.getElementById('ticket-list');
    const hiddenInput = document.getElementById('parent_id_hidden');
    const levelSelect = document.getElementById('task_level_select');
    const inputValue = e.target.value;

    const option = Array.from(list.options).find(opt => opt.value === inputValue);

    if (option) {
        const newParentId = option.getAttribute('data-id');
        const parentLevel = parseInt(option.getAttribute('data-level') || 0);
        
        hiddenInput.value = newParentId;
        
        // Auto-set level to parent level + 1
        if (newParentId != "0") {
            levelSelect.value = parentLevel + 1;
        } else {
            levelSelect.value = 0;
        }
    }
});
    // function addNewTask(parentId) {
    //     const title = prompt("Task title:");
    //     if (!title) return;

    //     // 1. Find the correct container for siblings
    //     let container;
    //     const parentTaskNode = document.querySelector(`.task-node[data-id="${parentId}"]`);
        
    //     if (parentTaskNode) {
    //         // Adding a child to a Level 1+ task
    //         const childContainer = parentTaskNode.querySelector('.child-container');
    //         container = childContainer.querySelector('.sibling-wrapper');
    //         if (!container) {
    //             container = document.createElement('div');
    //             container.className = 'sibling-wrapper';
    //             childContainer.appendChild(container);
    //         }
    //     } else {
    //         // Adding Level 1 task to the Project
    //         const projectSection = document.querySelector(`.project-section[data-id="${parentId}"]`);
    //         const flowArea = projectSection.querySelector('.flow-area');
    //         container = flowArea.querySelector('.sibling-wrapper');
    //         if (!container) {
    //             container = document.createElement('div');
    //             container.className = 'sibling-wrapper';
    //             flowArea.appendChild(container);
    //         }
    //     }

    //     // 2. Inject the New Task
    //     const newId = Date.now();
    //     const taskHtml = `
    //         <div class="task-node" data-id="${newId}" data-parent="${parentId}">
    //             <div class="task-box">
    //                 <div class="task-inner">
    //                     <input type="checkbox" onchange="toggleStatus(this)">
    //                     <span class="task-text" contenteditable="true" onblur="updateTask(${newId}, this.innerText)">${title}</span>
    //                     <button class="add-sub-btn" onclick="addNewTask(${newId})">+</button>
    //                 </div>
    //             </div>
    //             <div class="child-container"></div>
    //         </div>
    //     `;
        
    //     container.insertAdjacentHTML('beforeend', taskHtml);
    // }
</script>