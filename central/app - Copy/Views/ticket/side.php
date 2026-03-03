<?= view('header') ?>  <!-- loads app/Views/header.php -->
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
$segment1 = service('uri')->getSegment(1);

if ($segment1 == 'ticket') : ?>
    <div class="submenu">
<a href="<?= base_url('ticket/type/task') ?>">Task</a>
<a href="<?= base_url('ticket/type/issue') ?>">Issue</a>
<a href="<?= base_url('ticket/type/update') ?>">Update</a>

        <!-- <a href="<?= base_url('tv') ?>">TV</a>
        <a href="<?= base_url('company') ?>">View Companies</a>
        <a href="<?= base_url('company/add') ?>">Add Company</a> -->
<div style="margin-bottom:15px;">
    <button type="button" onclick="createDummy('Task')">+ Dummy Task</button>
    <button type="button" onclick="createDummy('Issue')">+ Dummy Issue</button>
    <button type="button" onclick="createDummy('Update')">+ Dummy Update</button>
</div>
         

<div style="margin-bottom:15px;">
    <button type="button" onclick="setTheme('light')">Light</button>
    <button type="button" onclick="setTheme('dark')">Dark</button>
    <button type="button" onclick="setTheme('blue')">Blue</button>
</div>



<form method="post" action="<?= base_url('ticket/store') ?>" class="simple-form" id="form">
    <?= csrf_field() ?>

    <label class="full">Title *
        <input type="text" name="title" required>
    </label>

   <div class="form-group">
    <label>Parent Ticket (Type to search)</label>
    <input type="text" 
           list="ticket-list" 
           id="parent_search" 
           placeholder="Search ID or Title..." 
           autocomplete="off">

    <input type="hidden" name="parent_id" id="parent_id_hidden" value="0">

    <datalist id="ticket-list">
    <option data-id="0" data-level="0" value="None (Main Ticket)"></option>

    <?php if(isset($tickets) && is_array($tickets)): ?>
        <?php foreach($tickets as $t): ?>
            <option 
                data-id="<?= $t['id'] ?>" 
                data-level="<?= $t['task_level'] ?>" 
                value="#<?= $t['id'] ?> - <?= esc($t['title']) ?>">
            </option>
        <?php endforeach; ?>
    <?php endif; ?>
</datalist>
</div>
<label>Assign To User *
    <select name="user_id" required>
    <option value="<?= $userId ?>"><?= esc($userName) ?>(self)</option>
        <?php if(isset($users) && count($users) > 0): ?>
            <?php foreach($users as $u): ?>
                <option value="<?= $u['id'] ?>"><?= esc($u['name']) ?> (<?= esc($u['email']) ?>)</option>
            <?php endforeach; ?>
        <?php endif; ?>
    </select>
</label>

<label>Task Level
    <select name="task_level" id="task_level_select">
        <option value="0" selected>Head</option>
        <option value="1">Level 2</option>
        <option value="2">Level 3</option>
        <option value="3">Level 4</option>
        <option value="4">Level 5</option>
    </select>
</label>

    <label>Type
        <select name="ticket_type">
            <option value="Task">Task</option>
            <option value="Issue">Issue</option>
            <option value="Update">Update</option>
        </select>
    </label>

    <label>Department
        <input type="text" name="department">
    </label>

    <label>Priority
        <select name="priority">
            <option value="Low">Low</option>
            <option value="Medium" selected>Medium</option>
            <option value="High">High</option>
            <option value="Urgent">Urgent</option>
        </select>
    </label>

    <label>Status
        <select name="status">
            <option value="Open">Open</option>
            <option value="In Progress">In Progress</option>
            <option value="Resolved">Resolved</option>
        </select>
    </label>

    <label class="full">Description *
        <textarea name="description" rows="3" required></textarea>
    </label>

    <button type="submit" class="full">Create Ticket</button>
</form>

<script>
// Logic to handle searching and level calculation
document.getElementById('parent_search').addEventListener('input', function(e) {
    const input = e.target;
    const list = document.getElementById('ticket-list');
    const hiddenId = document.getElementById('parent_id_hidden');
    const hiddenLvl = document.getElementById('task_level_hidden');
    const options = list.options;
    
    let found = false;
    for (let i = 0; i < options.length; i++) {
        if (options[i].value === input.value) {
            const parentId = options[i].getAttribute('data-id');
            const parentLvl = parseInt(options[i].getAttribute('data-level'));
            
            hiddenId.value = parentId;
            // If parent is 0, level is 0. If child, level is parent_level + 1
            hiddenLvl.value = (parentId == "0") ? 0 : (parentLvl + 1);
            found = true;
            break;
        }
    }
    
    if (!found) {
        hiddenId.value = "0";
        hiddenLvl.value = "0";
    }
});
function createDummy(type) {
    const form = document.getElementById('form');
    if (!form) return;

    const titles = {
        Task: ["Server Maintenance", "Backup Configuration", "Deploy New Feature"],
        Issue: ["Login Failure", "Payment Gateway Error", "API Timeout"],
        Update: ["System Patch Applied", "Policy Updated", "Security Upgrade"]
    };

    const random = (arr) => arr[Math.floor(Math.random() * arr.length)];

    try {
        form.querySelector('[name="title"]').value = random(titles[type]) + " #" + Math.floor(Math.random() * 100);
        form.querySelector('[name="ticket_type"]').value = type;
        form.querySelector('[name="department"]').value = random(["IT", "HR", "Admin", "Support"]);
        form.querySelector('[name="description"]').value = type + " auto-generated at " + new Date().toLocaleString();
        form.querySelector('[name="priority"]').value = random(["Low", "Medium", "High", "Urgent"]);
        form.querySelector('[name="status"]').value = random(["Open", "In Progress"]);

        // Dummy always resets to Root
        document.getElementById('parent_id_hidden').value = 0;
        document.getElementById('task_level_hidden').value = 0;

        // NEW: assign a random user
        if (users.length > 0) {
            const randomUser = random(users);
            form.querySelector('[name="user_id"]').value = randomUser.id;
        }

        form.submit();
    } catch (e) {
        console.error("Error filling dummy data:", e);
    }
}
</script>

<style>

.sidebar {
    position: sticky;
    top: 50px;
    width: 220px;
    height: calc(100vh - 60px);
    background-color: var(--nav-color);
    color: #fff;
    padding: 20px;
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
    flex-shrink: 0;
    
    /* Keep it scrollable internally */
    overflow-y: auto; 
    
    /* Hide scrollbar for Chrome, Safari and Opera */
    -ms-overflow-style: none;  /* IE and Edge */
    scrollbar-width: none;     /* Firefox */
}

/* Hide scrollbar for Chrome, Safari and Opera */
.sidebar::-webkit-scrollbar {
    display: none;
}
    /* Apply to EVERYTHING in the form to prevent padding overflow */
.simple-form, 
.simple-form * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
    width: ;
}

.simple-form {
    padding: 20px;
    background: #fff;
    font-family: sans-serif;
}

/* Vertical stacking for all groups */
.form-group {
    margin-bottom: 15px;
    display: block;
}

.simple-form label {
    display: block;
    margin-bottom: 5px;
    font-size: 14px;
    font-weight: 600;
    color: #333;
}

/* 100% width with internal padding */
.simple-form input, 
.simple-form select, 
.simple-form textarea {
    width: 100%;
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
    display: block;
}

.simple-form textarea {
    height: 100px;
}

/* Button stretches to full width as well */
.simple-form button {
    width: 100%;
    padding: 15px;
    background: #2563eb;
    color: white;
    border: none;
    border-radius: 4px;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    margin-top: 10px;
}

.simple-form button:hover {
    background: #1d4ed8;
}
</style>


<script>
function setTheme(theme) {

    const body = document.body;
    const cards = document.querySelectorAll('.issue-card');
    const textElements = document.querySelectorAll('.issue-card h2, .card-body, .card-meta');

    if (theme === 'light') {

        body.style.backgroundColor = "#f4f6f9";
        body.style.color = "#000";

        cards.forEach(card => {
            card.style.backgroundColor = "#ffffff";
            card.style.borderColor = "#ddd";
        });

    } else if (theme === 'dark') {

        body.style.backgroundColor = "#121212";
        body.style.color = "#ffffff";

        cards.forEach(card => {
            card.style.backgroundColor = "#1e1e1e";
            card.style.borderColor = "#333";
        });

    } else if (theme === 'blue') {

        body.style.backgroundColor = "#e3f2fd";
        body.style.color = "#0d47a1";

        cards.forEach(card => {
            card.style.backgroundColor = "#bbdefb";
            card.style.borderColor = "#90caf9";
        });

    }
}
</script>
    </div>
<?php endif; ?>

</div>

<div class="content">