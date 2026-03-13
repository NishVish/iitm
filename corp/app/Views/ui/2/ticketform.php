

<div id="ticketModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3><span class="header-icon">+</span> Create New Ticket</h3>
            <span class="close-btn" onclick="closeModal()">&times;</span>
        </div>

        <form method="post" action="<?= base_url('ticket/store') ?>" class="ticket-form" id="form">
            <?= csrf_field() ?>

            <div class="form-row full">
                <label>Parent Ticket (Search ID or Title)</label>
                <input type="text" list="ticket-list" id="parent_search" placeholder="Search ID or Title..." value="<?=$currentSegment?>" autocomplete="off">
                <input type="hidden" name="parent_id" id="parent_id_hidden" value="0">
                <datalist id="ticket-list">
                    <option data-id="0" data-level="0" value="None (Main Ticket)"></option>
                    <?php if(isset($tickets) && is_array($tickets)): ?>
                        <?php foreach($tickets as $ticket): ?>
                            <option data-id="<?= $ticket['id'] ?>" data-level="<?= $ticket['task_level'] ?>" value="#<?= $ticket['id'] ?> - <?= esc($ticket['title']) ?>"></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </datalist>
            </div>

            <div class="form-grid">
                <div class="form-row">
                    <label>Assign To User *</label>
                    <select name="user_id" required>
                        <option value="<?= $user_id ?>" selected><?= esc($name) ?> (self)</option>
                        <?php if(isset($users)): foreach($users as $user): if($user['id'] != $user_id): ?>
                            <option value="<?= $user['id'] ?>"><?= esc($user['name']) ?></option>
                        <?php endif; endforeach; endif; ?>
                    </select>
                </div>

                <div class="form-row">
                    <label>Task Level</label>
                    <select name="task_level" id="task_level_select">
                        <option value="0" selected>Head</option>
                        <option value="1">Level 2</option>
                        <option value="2">Level 3</option>
                        <option value="3">Level 4</option>
                        <option value="4">Level 5</option>
                    </select>
                </div>

                <div class="form-row">
                    <label>Type</label>
                    <select name="ticket_type">
                        <option value="Task">Task</option>
                        <option value="Issue">Issue</option>
                        <option value="Update">Update</option>
                    </select>
                </div>

                <div class="form-row">
                    <label>Department</label>
                    <input type="text" name="department" placeholder="e.g. Sales">
                </div>

                <div class="form-row">
                    <label>Priority</label>
                    <select name="priority">
                        <option value="Low">Low</option>
                        <option value="Medium" selected>Medium</option>
                        <option value="High">High</option>
                        <option value="Urgent">Urgent</option>
                    </select>
                </div>

                <div class="form-row">
                    <label>Status</label>
                    <select name="status">
                        <option value="Open" selected>Open</option>
                        <option value="In Progress">In Progress</option>
                        <option value="Resolved">Resolved</option>
                    </select>
                </div>
            </div>

            <div class="form-row full">
                <label>Description *</label>
                <textarea name="description" rows="3" required placeholder="Details about this ticket..."></textarea>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal()">Cancel</button>
                <button type="submit" class="btn-submit">Create Ticket</button>
            </div>
        </form>
    </div>
</div>

<style>
/* Variables Integrated */
:root {
    --modal-primary: var(--nav-color, #007bff);
    --modal-bg: #ffffff;
    --modal-border: #e2e8f0;
}

/* Modal Overlay */
.modal {
    display: none;
    position: fixed;
    z-index: 9999;
    left: 0; top: 0;
    width: 100%; height: 100%;
    background-color: rgba(15, 23, 42, 0.6); /* Slightly darker slate overlay */
    backdrop-filter: blur(4px);
}

/* Modal Content Box */
.modal-content {
    background: var(--modal-bg);
    width: 650px;
    max-width: 95%;
    margin: 40px auto;
    border-radius: 12px;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    overflow: hidden;
    animation: slideIn 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}

/* Header Styling */
.modal-header {
    padding: 16px 24px;
    background: #f8fafc;
    border-bottom: 1px solid var(--modal-border);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-header h3 { margin: 0; font-size: 1.15rem; color: #1e293b; font-weight: 600; }
.header-icon { color: var(--modal-primary); margin-right: 8px; font-weight: bold; }

.close-btn { 
    font-size: 24px; color: #94a3b8; cursor: pointer; transition: 0.2s; 
}
.close-btn:hover { color: #1e293b; }

/* Form Elements */
.ticket-form { padding: 24px; }

.form-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 16px;
    margin-bottom: 16px;
}

.form-row { display: flex; flex-direction: column; margin-bottom: 16px; }
.form-row.full { grid-column: span 2; }

.form-row label {
    font-size: 0.85rem;
    font-weight: 600;
    color: #475569;
    margin-bottom: 6px;
}

.form-row input, .form-row select, .form-row textarea {
    padding: 10px 12px;
    border: 1px solid var(--modal-border);
    border-radius: 6px;
    font-size: 0.95rem;
    color: #1e293b;
    transition: all 0.2s;
}

.form-row input:focus, .form-row select:focus, .form-row textarea:focus {
    border-color: var(--modal-primary);
    box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
    outline: none;
}

/* Footer & Buttons */
.modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    margin-top: 10px;
}

.btn-submit {
    background: var(--modal-primary);
    color: #ffffff;
    border: none;
    padding: 12px 24px;
    border-radius: 6px;
    font-weight: 600;
    cursor: pointer;
    transition: filter 0.2s;
}

.btn-cancel {
    background: #f1f5f9;
    color: #475569;
    border: none;
    padding: 12px 24px;
    border-radius: 6px;
    font-weight: 600;
    cursor: pointer;
}

.btn-submit:hover { filter: brightness(90%); }
.btn-cancel:hover { background: #e2e8f0; }

/* Animations */
@keyframes slideIn {
    from { transform: translateY(-20px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}
</style>

<script>
function openModal() {
    document.getElementById("ticketModal").style.display = "block";
}

function closeModal() {
    document.getElementById("ticketModal").style.display = "none";
}

// Close when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById("ticketModal");
    if (event.target === modal) {
        modal.style.display = "none";
    }
}
</script>
