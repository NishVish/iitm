<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Explorer | Antigravity Engine</title>
    <!-- Modern Typography -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Outfit:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
:root {
    --primary: var(--button-color);
    --primary-glow: rgba(0, 0, 0, 0.25);
    --accent: var(--nav-color);
    --bg-dark: var(--body-color);
    --card-bg: var(--body-color);
    --glass-border: rgba(255,255,255,0.08);
    --text-dim: rgba(255,255,255,0.6);
    --text-main: rgba(0, 0, 0, 0.6);
    --hover-row: rgba(255,255,255,0.05);
    --selection-col: rgba(255,255,255,0.08);
    --selection-row: rgba(255,255,255,0.15);
}

/* Base Styles & Scrollbar */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

::-webkit-scrollbar {
    width: 8px;
    height: 8px;
}
::-webkit-scrollbar-track {
    background: var(--nav-color);
}
::-webkit-scrollbar-thumb {
    background: var(--button-color);
    border-radius: 10px;
}
::-webkit-scrollbar-thumb:hover {
    background: rgba(148, 163, 184, 0.4);
}

body {
    background-color: var(--bg-dark);
    background-image: 
        radial-gradient(at 0% 0%, rgba(99, 102, 241, 0.12) 0, transparent 50%),
        radial-gradient(at 100% 100%, rgba(34, 211, 238, 0.1) 0, transparent 50%);
    color: var(--text-main);
    font-family: 'Inter', sans-serif;
}

.page-wrapper {
    max-width: 1600px;
    margin: 0 auto;
}

/* .header-section {
    margin-bottom: 2.5rem;
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
} */

/* Table Container with Glassmorphism */
.table-card {
    background: var(--card-bg);
    backdrop-filter: blur(20px);
    border: 1px solid var(--glass-border);
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    animation: fadeIn 0.6s ease-out;
}

.table-container {
    width: 100%;
    max-height: 70vh;
    min-height: 600px;
    overflow: auto;
    position: relative;
}

.custom-table {
    border-collapse: separate;
    border-spacing: 0;
    width: 100%;
    white-space: nowrap;
    font-size: 0.9rem;
}

/* Header Styling - Height Locked */
.custom-table thead th {
    background: var(--nav-color);
    backdrop-filter: blur(10px);
    position: sticky;
    top: 0;
    z-index: 10;
    color: var(--text-color);
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    padding: 0 1.25rem;
    height: 50px; /* Locked Height */
    vertical-align: middle;
    text-align: left;
    border-bottom: 1px solid var(--glass-border);
    transition: background 0.2s ease;
}

.custom-table thead th:hover {
    background: rgba(30, 41, 59, 1);
    color: #fff;
    cursor: pointer;
}

.custom-table td {
    vertical-align: middle;
    padding: 0 0.8rem;
    height: 50px;           /* Consistent Row Height */
    max-height: 50px;       /* ← ADD THIS - prevents expansion */
    line-height: 50px;
    white-space: nowrap;
    overflow: hidden;       /* Already have this - keeps it clipped */
    text-overflow: ellipsis;
    border-bottom: 1px solid var(--glass-border);
}

/* ← ADD THIS RULE */
.custom-table tbody tr {
    height: 50px;
    max-height: 50px;
    overflow: hidden;
}
.custom-table tbody tr:hover {
    background: var(--hover-row);
}

/* Selection States */
.selected-row {
    background: var(--selection-row) !important;
}

.selected-column th {
    background: var(--button-color) !important;
}

.selected-column {
    background: var(--nav-color) !important;
    color: var(--text-color) !important;

}

/* Interactive Elements - Internal Resets to maintain row height */
.custom-table td a {
    color: var(--text-color);
    text-decoration: none;
    font-weight: 500;
    display: inline-block;
    vertical-align: middle;
    line-height: normal; /* Prevents anchor from expanding 50px cell */
}

.custom-table td {
    color: var(--text-color);
}
.custom-table td a:hover {
    color: var(--primary);
}

.badge {
    display: inline-block;
    padding: 0.25rem 0.6rem;
    border-radius: 6px;
    color: var(--text-color);
    font-size: 0.8rem;
    font-weight: 600;
    border: 1px solid rgba(99, 102, 241, 0.3);
    line-height: 1;
    vertical-align: middle;
}

.view-link {
    display: inline-flex;
    align-items: center;
    padding: 0.4rem 0.8rem;
    border-radius: 8px;
    font-size: 0.8rem;
    background: var(--button-color);
    color: #fff !important;
    line-height: 1;
    vertical-align: middle;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.view-link:hover {
    transform: translateY(-1px);
    box-shadow: 0 10px 15px -3px var(--primary-glow);
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
    </style>
</head>
<body>

    <div class="page-wrapper">
        <header class="header-section">
            <div class="title-group">
            </div>
            <div class="stats-mini">
                <!-- Decorative element -->
            </div>
        </header>

        <div class="table-card">
            <div class="table-container">
            <table class="custom-table" id="dataTable">
                <thead>
                    <tr>
                        <th>Action</th>
                        <th>Database</th>
                        <th>Category</th>
                        <th>Source</th>
                        <th>Updated By</th>
                        <th>Updated At</th>
                        <th>Comments</th>
                        <th>Outbound</th>
                        <th>Company Name</th>
                        <th>Address</th>
                        <th>City</th>
                        <th>Pincode</th>
                        <th>State</th>
                        <th>Phone</th>
                        <th>Fax</th>

                        <?php for ($i = 1; $i <= ($maxContacts ?? 1); $i++): 
                            $suffix = $i === 1 ? '' : "_$i";
                        ?>
                            <th>Contact Name<?= $suffix ?></th>
                            <th>Designation<?= $suffix ?></th>
                            <th>Mobile <?= $i*2-1 ?></th>
                            <th>Mobile <?= $i*2 ?></th>
                            <th>Email <?= $i*2-1 ?></th>
                            <th>Email <?= $i*2 ?></th>
                        <?php endfor; ?>
                    </tr>
                </thead>

                <tbody>
                <?php if(isset($companies) && !empty($companies)): ?>
                    <?php foreach ($companies as $comp):
                        $d = $comp['details'];
                        $cList = array_values($comp['contacts']);

                        $rawSources = explode(', ', $d['source_notes'] ?? '');
                        $linkedSources = [];

                        foreach ($rawSources as $source) {
                            if (!empty(trim($source))) {
                                $slug = urlencode(str_replace([' & ', ' '], ['-and-', '-'], trim($source)));
                                $url = base_url("company/byvar/source/$slug");
                                $linkedSources[] = '<a href="'.$url.'">'.esc($source).'</a>';
                            }
                        }

                        $sourceHtml = implode(', ', $linkedSources);
                    ?>
                        <tr>
                            <td>
                                <a href="<?= base_url('company/details/' . esc($d['company_id'])) ?>" class="view-link">
                                    View Details
                                </a>
                            </td>

                            <td><span class="badge"><?= esc($d['database_name'] ?? 'N/A') ?></span></td>
                            <td><?= esc($d['category'] ?? '') ?></td>
                            <td><?= $sourceHtml ?></td>
                            <td><?= esc($d['updated_by'] ?? '') ?></td>
                            <td><?= esc($d['updated_at'] ?? '') ?></td>
                            <td title="<?= esc($d['last_comments'] ?? '') ?>">
                                <?= strlen($d['last_comments'] ?? '') > 30 ? substr(esc($d['last_comments']), 0, 30).'...' : esc($d['last_comments'] ?? '') ?>
                            </td>
                            <td><?= esc($d['outbound'] ?? '') ?></td>

                            <td>
                                <a href="<?= base_url("company/details/" . ($filters['entry_type'] ?? 'general') . "/" . $d['company_id']) ?>">
                                    <?= esc($d['company_name'] ?? 'Untitled Corp') ?>
                                </a>
                            </td>

                            <td><?= esc($d['address'] ?? '') ?></td>
                            <td><?= esc($d['city'] ?? '') ?></td>
                            <td><?= esc($d['pincode'] ?? '') ?></td>
                            <td><?= esc($d['state'] ?? '') ?></td>
                            <td><?= esc($d['phone'] ?? '') ?></td>
                            <td><?= esc($d['fax'] ?? '') ?></td>

                            <?php for ($i=0; $i < ($maxContacts ?? 1); $i++):
                                $c = $cList[$i] ?? [];
                            ?>
                                <td><?= esc($c['name'] ?? '-') ?></td>
                                <td><?= esc($c['designation'] ?? '-') ?></td>
                                <td><?= esc($c['mobiles'][0] ?? '-') ?></td>
                                <td><?= esc($c['mobiles'][1] ?? '-') ?></td>
                                <td><?= esc($c['emails'][0] ?? '-') ?></td>
                                <td><?= esc($c['emails'][1] ?? '-') ?></td>
                            <?php endfor; ?>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- Placeholder Row for demo if no data is passed -->
                    <tr>
                        <td colspan="15" style="text-align:center; padding: 4rem; color: var(--text-dim);">
                            Waiting for data connection... 
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const table = document.getElementById("dataTable");
        
        // --- ROW SELECTION ---
        table.querySelector("tbody").addEventListener("click", function(e) {
            const row = e.target.closest("tr");
            if (!row || e.target.tagName.toLowerCase() === "a") return;

            table.querySelectorAll(".selected-row").forEach(r => r.classList.remove("selected-row"));
            row.classList.add("selected-row");
        });

        // --- COLUMN SELECTION ---
        table.querySelectorAll("thead th").forEach((header, index) => {
            header.addEventListener("click", function () {
                // remove previous highlight
                table.querySelectorAll(".selected-column").forEach(cell => cell.classList.remove("selected-column"));

                // highlight cells in this column
                table.querySelectorAll("tr").forEach(row => {
                    const cell = row.children[index];
                    if (cell) cell.classList.add("selected-column");
                });
            });
        });

        // --- SMOOTH SCROLL SHADOWS ---
        const container = document.querySelector('.table-container');
        container.addEventListener('scroll', () => {
            const scrolled = container.scrollLeft > 0;
            // Optionally add a shadow to the first column if it's fixed
        });
    });
    </script>

</body>
</html>
