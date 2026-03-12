<?= view('search/side') ?>

<!DOCTYPE html>
<html>
<head>
    <title>Company Search</title>

    <style>

        

        .result-card {
            background: #fff;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 6px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.08);
        }

        .form-row {
            display: flex;
            margin-bottom: 8px;
        }

        .form-label {
            width: 150px;
            font-weight: bold;
        }

        .form-value {
            flex: 1;
        }

        .contacts {
            white-space: pre-line;
            background: #f8f9fa;
            padding: 8px;
            border-radius: 4px;
        }

        .no-result {
            color: red;
            font-weight: bold;
        }

    </style>
</head>
<body>

    <style>
        :root {
            --accent-color: #4f46e5; /* Modern Indigo */
            --input-bg: #ffffff;
            --text-main: #1e293b;
            --shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

.search-container {
    width: 100%;
    max-width: 700px;
    margin: 10px auto;
    padding: 0 15px;
    display: block; /* show the container */
}

.search-container form {
    display: flex;
    width: 100%;
}

.search-container input[type="text"] {
    flex: 1;
    padding: 10px 15px;
    font-size: 16px;
    border: 1px solid rgba(255, 255, 255, 0.5); /* semi-transparent border */
    background-color: transparent; /* fully transparent */
    color: white; /* text color */
    border-radius: 4px 0 0 4px;
    outline: none;
}

.search-container button {
    padding: 10px 20px;
    font-size: 16px;
    border: 1px solid rgba(255, 255, 255, 0.5);
    border-left: none;
    background-color: rgba(255, 255, 255, 0.2); /* semi-transparent button */
    color: white;
    border-radius: 0 4px 4px 0;
    cursor: pointer;
    transition: background-color 0.3s;
}

.search-container button:hover {
    background-color: rgba(255, 255, 255, 0.4);
}
        .modern-search-form {
            display: flex;
            align-items: center;
            background: var(--input-bg);
            padding: 8px;
            border-radius: 50px; /* Pill shape */
            box-shadow: var(--shadow);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            border: 1px solid #e2e8f0;
        }

        /* Subtle lift when typing */
        .modern-search-form:focus-within {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            border-color: var(--accent-color);
        }

        .search-icon {
            padding-left: 15px;
            color: #94a3b8;
            display: flex;
            align-items: center;
        }

        .modern-search-form input[type="text"] {
            flex: 1;
            padding: 12px 15px;
            font-size: 16px;
            border: none;
            background: transparent;
            outline: none;
            color: var(--text-main);
            width: 100%;
        }

        .modern-search-form input::placeholder {
            color: #94a3b8;
        }

        .modern-search-form button {
            padding: 12px 28px;
            font-size: 15px;
            font-weight: 600;
            background-color: var(--accent-color);
            color: white;
            border: none;
            border-radius: 40px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.3);
        }

        .modern-search-form button:hover {
            background-color: #4338ca;
            box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.4);
            transform: scale(1.02);
        }

        .modern-search-form button:active {
            transform: scale(0.98);
        }

        /* Responsive tweak */
        @media (max-width: 480px) {
            .modern-search-form button {
                padding: 10px 15px;
                font-size: 14px;
            }
        }
    </style>

    <form action="<?= base_url('search') ?>" method="get" class="modern-search-form">
        <div class="search-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
        </div>

        <input 
            type="text" 
            name="q"
            value="<?= esc($search ?? '') ?>"
            placeholder="Search company, contact, mobile..." 
            required
        >
        
        <button type="submit">Search</button>
    </form>
<?php if (!empty($results)) : ?>

    <p><strong><?= count($results) ?></strong> result(s) found for 
        "<strong><?= esc($search) ?></strong>"
    </p>

    <?php foreach ($results as $row) : ?>
<form method="post" action="#">
    <div>

    <div class="result-card" style="display: flex; gap: 20px; width: 100%;">

        <!-- Company Info Section - 30% -->
        <div class="company-section" style="flex-basis: 30%; flex-grow: 0;">

            <div class="form-row">
                <div class="form-label">Company ID:</div>
                <div class="form-value"><?= esc($row->company_id) ?></div>
            </div>

            <div class="form-row">
                <div class="form-label">Company Name:</div>
                <div class="form-value"><?= esc($row->company_name) ?></div>
            </div>

            <div class="form-row">
                <div class="form-label">Category:</div>
                <div class="form-value"><?= esc($row->category ?? 'N/A') ?></div>
            </div>

            <div class="form-row">
                <div class="form-label">Location:</div>
                <div class="form-value">
                    <?= esc($row->city ?? 'N/A') ?>, <?= esc($row->state ?? 'N/A') ?>
                </div>
            
            </div>
            <a  
    type="button" 
    class="open-details-btn" 
    href="<?= base_url('company/details/') . esc($row->company_id) ?>">
    View
    </a>
        </div>

        <!-- Contacts Section - 70% -->
        <div class="contacts-section" style="flex-basis: 70%; flex-grow: 0;">

            <div class="form-row">
        <?php if (!empty($row->contacts)) : ?>
            <?php
                // Split each contact line
                $contacts = explode("\n", $row->contacts);
            ?>
            <table border="1" cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Designation</th>
                        <th>Mobile</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($contacts as $contact) : ?>
                        <?php
                            // Parse "Name (Designation) - Mobile / Email"
                            preg_match('/^(.*?) \((.*?)\) - (.*?) \/ (.*)$/', $contact, $matches);
                            $name = $matches[1] ?? 'N/A';
                            $designation = $matches[2] ?? 'N/A';
                            $mobile = $matches[3] ?? 'N/A';
                            $email = $matches[4] ?? 'N/A';
                        ?>
                        <tr>
                            <td><?= esc($name) ?></td>
                            <td><?= esc($designation) ?></td>
                            <td><?= esc($mobile) ?></td>
                            <td><?= esc($email) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <div>No contacts available</div>
        <?php endif; ?>
    </div>
        </div>

    </div>

    
</div>


</form>


    <?php endforeach; ?>

<?php else : ?>

    <?php if (!empty($search)) : ?>
        <p class="no-result">
            No results found for "<?= esc($search) ?>"
        </p>
    <?php endif; ?>

<?php endif; ?>

</body>
</html>