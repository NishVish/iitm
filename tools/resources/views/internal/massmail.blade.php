<style>
    .mass-mail-module {
        --primary: #4f46e5;
        --primary-hover: #4338ca;
        --card-bg: #ffffff;
        --text-main: #0f172a;
        --text-muted: #64748b;
        --border: #e2e8f0;
        --danger: #ef4444;
        --danger-hover: #dc2626;

        font-family: system-ui, -apple-system, sans-serif;
        background: var(--card-bg);
        padding: 24px;
        border-radius: 12px;
        border: 1px solid var(--border);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        max-width: 1000px;
        margin: 20px auto;
        box-sizing: border-box;
    }

    .mass-mail-module * {
        box-sizing: border-box;
    }

    .mass-mail-module h2 {
        margin-top: 0;
        margin-bottom: 24px;
        font-size: 22px;
        font-weight: 700;
        color: var(--text-main);
        border-bottom: 2px solid var(--border);
        padding-bottom: 12px;
    }

    .mass-mail-module .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
        margin-bottom: 20px;
    }

    .mass-mail-module .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .mass-mail-module .form-group.full-width {
        grid-column: 1 / -1;
    }

    .mass-mail-module label {
        font-size: 13px;
        font-weight: 600;
        color: var(--text-muted);
    }

    .mass-mail-module select,
    .mass-mail-module textarea {
        padding: 10px 12px;
        border: 1px solid var(--border);
        border-radius: 6px;
        background-color: #fff;
        font-size: 14px;
        color: var(--text-main);
        outline: none;
        width: 100%;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .mass-mail-module select:focus,
    .mass-mail-module textarea:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15);
    }

    .mass-mail-module textarea {
        height: 100px;
        resize: vertical;
    }

    .mass-mail-module .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: var(--primary);
        color: white;
        border: none;
        padding: 10px 20px;
        font-size: 14px;
        font-weight: 600;
        border-radius: 6px;
        cursor: pointer;
        width: auto;
        transition: background 0.2s;
    }

    .mass-mail-module .btn:hover {
        background: var(--primary-hover);
    }

    .mass-mail-module .btn-secondary {
        background: transparent;
        border: 1px solid var(--border);
        color: var(--text-muted);
    }

    .mass-mail-module .btn-secondary:hover {
        background: #f1f5f9;
        color: var(--text-main);
    }

    .mass-mail-module .btn-danger {
        background: transparent;
        color: var(--danger);
        border: 1px solid #fee2e2;
        padding: 4px 10px;
        font-size: 12px;
        border-radius: 4px;
        cursor: pointer;
    }

    .mass-mail-module .btn-danger:hover {
        background: var(--danger);
        color: white;
    }

    .mass-mail-module .table-container {
        overflow-x: auto;
        margin-top: 20px;
        border: 1px solid var(--border);
        border-radius: 8px;
    }

    .mass-mail-module table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        font-size: 14px;
    }

    .mass-mail-module th,
    .mass-mail-module td {
        padding: 12px 14px;
        border-bottom: 1px solid var(--border);
    }

    .mass-mail-module th {
        background: #f8fafc;
        color: var(--text-muted);
        font-weight: 600;
        text-transform: uppercase;
        font-size: 12px;
        letter-spacing: 0.05em;
    }

    .mass-mail-module .email-tag {
        display: inline-block;
        background: #eef2ff;
        color: var(--primary);
        padding: 2px 6px;
        border-radius: 4px;
        font-size: 12px;
        margin: 2px;
        font-weight: 500;
    }

    .mass-mail-module .footer-actions {
        margin-top: 20px;
        display: flex;
        justify-content: flex-end;
    }
</style>

<div class="mass-mail-module">
    <h2>Mass Mail Sender</h2>

    <form method="POST" action="{{ url('/mass-mail') }}" id="mailForm">
        @csrf

        <div class="form-grid">
            <div class="form-group">
                <label>Template</label>
                <select name="template_id" required>
                    <option value="welcome">Welcome</option>
                    <option value="promo" selected>Promo</option>
                    <option value="reminder">Reminder</option>
                </select>
            </div>

            <div class="form-group">
                <label>Choose State / City</label>
                <select name="location" required>
                    <option value="">Select Location</option>
                    <option value="Karnataka - Bangalore">Karnataka - Bangalore</option>
                    <option value="Tamil Nadu - Chennai">Tamil Nadu - Chennai</option>
                    <option value="Maharashtra - Mumbai">Maharashtra - Mumbai</option>
                    <option value="Delhi - New Delhi">Delhi - New Delhi</option>
                </select>
            </div>

            <div class="form-group">
                <label>Promotion Name</label>
                <select name="promotion_name" required>
                    <option value="">Select Promotion</option>
                    <option value="Summer Offer">Summer Offer</option>
                    <option value="Festival Sale">Festival Sale</option>
                    <option value="Year End Discount">Year End Discount</option>
                    <option value="Referral Bonus">Referral Bonus</option>
                </select>
            </div>

            <div class="form-group">
                <label>User Name</label>
                <select name="user_name" required>
                    <option value="">Select User</option>
                    <option value="Admin">Admin</option>
                    <option value="Marketing Team">Marketing Team</option>
                    <option value="Sales Team">Sales Team</option>
                    <option value="Support Team">Support Team</option>
                </select>
            </div>

            <div class="form-group full-width">
                <label>Paste Data (Name + Email)</label>
                <textarea id="pasteBox" placeholder="John Doe	john@example.com"></textarea>
            </div>
        </div>

        <button type="button" class="btn btn-secondary" onclick="generateTable()">
            Generate Table
        </button>

        <input type="hidden" name="mail_data" id="mail_data">

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Emails</th>
                        <th style="width: 80px; text-align: center;">Action</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <tr>
                        <td colspan="3" style="text-align: center; color: var(--text-muted); font-style: italic;">
                            No data generated yet.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="footer-actions">
            <button type="submit" class="btn">
                Send Mass Mail
            </button>
        </div>
    </form>
</div>

<script>
    let mailData = [];

    function generateTable() {
        const input = document.getElementById("pasteBox").value.trim();
        const tbody = document.getElementById("tableBody");

        if (!input) {
            tbody.innerHTML = `<tr><td colspan="3" style="text-align: center; color: var(--text-muted); font-style: italic;">No data generated yet.</td></tr>`;
            document.getElementById("mail_data").value = JSON.stringify([]);
            return;
        }

        const lines = input.split("\n");
        tbody.innerHTML = "";
        mailData = [];

        lines.forEach((line) => {
            if (!line.trim()) return;

            const cols = line.split("\t");
            const name = (cols[0] || "").trim();
            let emails = [];

            for (let i = 1; i < cols.length; i++) {
                if (!cols[i]) continue;
                cols[i].split(",").forEach(e => {
                    const email = e.trim();
                    if (email.includes("@")) {
                        emails.push(email);
                    }
                });
            }

            emails = [...new Set(emails)];

            if (name) {
                mailData.push({
                    name: name,
                    emails: emails
                });

                const emailTags = emails.map(email => `<span class="email-tag">${email}</span>`).join("");
                const row = document.createElement('tr');
                row.dataset.index = mailData.length - 1;
                row.innerHTML = `
                    <td style="font-weight: 500;">${name}</td>
                    <td>${emailTags || '<span style="color:var(--danger)">No valid emails</span>'}</td>
                    <td style="text-align: center;">
                        <button type="button" class="btn-danger" onclick="removeRow(this)">
                            Delete
                        </button>
                    </td>
                `;
                tbody.appendChild(row);
            }
        });

        document.getElementById("mail_data").value = JSON.stringify(mailData);
    }

    function removeRow(button) {
        const row = button.closest('tr');
        const index = parseInt(row.dataset.index);

        mailData.splice(index, 1);
        row.remove();

        const remainingRows = document.querySelectorAll('.mass-mail-module #tableBody tr');
        if (remainingRows.length === 0) {
            document.getElementById("tableBody").innerHTML = `<tr><td colspan="3" style="text-align: center; color: var(--text-muted); font-style: italic;">No data generated yet.</td></tr>`;
        } else {
            remainingRows.forEach((r, i) => r.dataset.index = i);
        }

        document.getElementById("mail_data").value = JSON.stringify(mailData);
    }

    document.getElementById("mailForm").addEventListener("submit", function () {
        document.getElementById("mail_data").value = JSON.stringify(mailData);
    });
</script>