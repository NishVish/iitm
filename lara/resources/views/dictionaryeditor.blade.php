<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dictionary Editor</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --bg-light: #f4f7f6;
            --border-color: #dee2e6;
        }

        body {
            background-color: var(--bg-light);
            padding-top: 30px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .editor-card {
            background: white;
            border-radius: 0 0 8px 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            padding: 20px;
        }

        .filter-shell {
            background: #fff;
            padding: 20px;
            border-radius: 8px 8px 0 0;
            border: 1px solid var(--border-color);
            border-bottom: none;
        }

        .category-pill {
            transition: all 0.2s;
            margin-bottom: 5px;
        }

        .table-container {
            max-height: 60vh;
            overflow-y: auto;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .table thead th {
            position: sticky;
            top: 0;
            z-index: 10;
            background-color: #212529;
            color: white;
            border: none;
        }

        .table input {
            width: 100%;
            border: 1px solid transparent;
            background: transparent;
            padding: 6px;
            outline: none;
        }

        .table input:focus {
            background: #e9ecef;
            border-radius: 4px;
        }

        .actions-cell {
            width: 40px;
            text-align: center;
        }

        .btn-delete {
            color: #dc3545;
            cursor: pointer;
            font-size: 1.2rem;
            line-height: 1;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-11">

                <h3 class="fw-bold mb-4">Dictionary Manager</h3>

                <div class="filter-shell">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-uppercase fw-bold small text-secondary">Quick Filter by Category:</span>
                        <small class="text-muted">Rows visible: <span id="rowCount"
                                class="fw-bold text-primary">0</span></small>
                    </div>
                    <div id="categoryButtonGroup" class="d-flex flex-wrap gap-2">
                        <button type="button" class="btn btn-sm btn-dark category-pill"
                            onclick="filterByCategory('all')">Show All</button>
                    </div>
                </div>

                <div class="editor-card">
                    <form method="POST" action="{{ route('dictionary.update') }}">
                        @csrf

                        <div class="table-container">
                            <table class="table table-hover align-middle m-0">
                                <thead>
                                    <tr>
                                        <th>Keyword</th>
                                        <th>Category</th>
                                        <th class="actions-cell"></th>
                                    </tr>
                                </thead>
                                <tbody id="tableBody">
                                    @foreach($dictionary as $row)
                                        <tr class="data-row">
                                            <td>
                                                <input type="text" name="keyword[]" value="{{ $row['keyword'] ?? '' }}"
                                                    class="kw-input">
                                            </td>
                                            <td>
                                                <input type="text" name="category[]" value="{{ $row['category'] ?? '' }}"
                                                    class="cat-input" onchange="refreshCategoryButtons()">
                                            </td>
                                            <td class="actions-cell">
                                                <span class="btn-delete" onclick="removeRow(this)">&times;</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-outline-primary px-4" onclick="addRow()">+ Add New
                                Row</button>
                            <button type="submit" class="btn btn-success px-5 fw-bold">Save All Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const tableBody = document.getElementById('tableBody');
        const buttonGroup = document.getElementById('categoryButtonGroup');

        // 1. Function to find unique categories and build buttons
        function refreshCategoryButtons() {
            const rows = tableBody.getElementsByClassName('data-row');
            const categories = new Set();

            Array.from(rows).forEach(row => {
                const val = row.querySelector('.cat-input').value.trim();
                if (val) categories.add(val);
            });

            // Clear old buttons (except "Show All")
            const showAllBtn = buttonGroup.firstElementChild;
            buttonGroup.innerHTML = '';
            buttonGroup.appendChild(showAllBtn);

            // Create a button for each unique category
            categories.forEach(cat => {
                const btn = document.createElement('button');
                btn.type = "button";
                btn.className = "btn btn-sm btn-outline-secondary category-pill";
                btn.innerText = cat;
                btn.onclick = () => filterByCategory(cat);
                buttonGroup.appendChild(btn);
            });

            updateCount();
        }

        // 2. Function to filter rows
        function filterByCategory(category) {
            const rows = tableBody.getElementsByClassName('data-row');

            Array.from(rows).forEach(row => {
                const rowCat = row.querySelector('.cat-input').value.trim();
                if (category === 'all' || rowCat === category) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });

            // UI Feedback: Highlight active button
            Array.from(buttonGroup.children).forEach(btn => {
                btn.classList.replace('btn-secondary', 'btn-outline-secondary');
                if (btn.innerText === category || (category === 'all' && btn.innerText === 'Show All')) {
                    btn.classList.replace('btn-outline-secondary', 'btn-secondary');
                }
            });

            updateCount();
        }

        function addRow() {
            const row = document.createElement('tr');
            row.className = 'data-row';
            row.innerHTML = `
                <td><input type="text" name="keyword[]" class="kw-input" placeholder="Keyword..."></td>
                <td><input type="text" name="category[]" class="cat-input" placeholder="Category..." onchange="refreshCategoryButtons()"></td>
                <td class="actions-cell"><span class="btn-delete" onclick="removeRow(this)">&times;</span></td>
            `;
            tableBody.appendChild(row);
            refreshCategoryButtons();
        }

        function removeRow(btn) {
            btn.closest('tr').remove();
            refreshCategoryButtons();
        }

        function updateCount() {
            const visibleRows = Array.from(tableBody.getElementsByClassName('data-row'))
                .filter(r => r.style.display !== "none").length;
            document.getElementById('rowCount').innerText = visibleRows;
        }

        // Initialize on load
        window.onload = refreshCategoryButtons;
    </script>
</body>

</html>