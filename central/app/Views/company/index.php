<?php include(APPPATH . 'Views/company/side.php'); ?>

<!-- Toggle Button -->
<button id="toggleBtn">Show/Hide Company Form</button>

<!-- Form Container -->
<div id="companyFormWrapper" class="form-container">
    <?= view('company/insert_company_form') ?>
</div>


<style>

/* ===============================
   FORM CONTAINER
=================================*/
.form-container {
    display: block;
    border: 2px solid #333;
    padding: 15px;
    margin-bottom: 20px;
    overflow: auto;
}


/* ===============================
   CONTENT WRAPPER
=================================*/
.content {
    max-width: 150vh;;
    margin: 0 auto;
    padding: 20px;
    box-sizing: border-box;
}

.content table {
    width: 100%;
    border-collapse: collapse;
}


/* ===============================
   PAGE HEADER
=================================*/
.page-header {
    background: #ffffff;
    padding: 20px;
    border-radius: 12px;
    margin: 20px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.08);
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.page-header h1 {
    margin: 0;
    font-size: 26px;
}


/* ===============================
   FILTER SECTION
=================================*/
.filter-section {
    width: 100%;
    background: #ffffff;
    padding: 15px;
    margin-top: 20px;
    border-radius: 12px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.08);
}

#states {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.state-link {
    padding: 6px 12px;
    border-radius: 20px;
    border: 1px solid #ccc;
    background: #f8f8f8;
    text-decoration: none;
    color: #333;
    font-size: 13px;
    transition: 0.3s;
}

.state-link:hover {
    background: #eaeaea;
}

.state-link.active {
    background: #a82324;
    color: #fff;
    border-color: #a82324;
}


/* ===============================
   COMPANY TABLE
=================================*/
.company-table {
    width: 100%;
    margin: 20px auto;
    border-collapse: collapse;
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 6px 20px rgba(0,0,0,0.08);
}

.company-table th {
    background: #a82324;
    color: white;
    padding: 12px;
    text-align: left;
    font-size: 14px;
}

.company-table td {
    padding: 10px 12px;
    border-bottom: 1px solid #eee;
    font-size: 13px;
}

.company-table tr:hover {
    background: #f9f9f9;
}

.company-table input[type="radio"] {
    transform: scale(1.2);
}


/* ===============================
   BUTTONS
=================================*/
#compareBtn {
    background: #6486a9;
    color: #fff;
    border: none;
    padding: 10px 18px;
    border-radius: 8px;
    cursor: pointer;
    margin: 15px 20px;
    font-weight: 600;
    transition: 0.3s;
}

#compareBtn:hover {
    background: #004999;
}


/* ===============================
   MODAL
=================================*/
#compareModal {
    border-radius: 12px;
    box-shadow: 0 15px 40px rgba(0,0,0,0.3);
}

#closeModal {
    background: #d7505e;
    color: white;
    border: none;
    padding: 5px 10px;
    border-radius: 6px;
    cursor: pointer;
}

</style>
<!-- 
<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>State</th>
            <th>TA</th>
            <th>Hotel</th>
            <th>Other</th>
        </tr>
    </thead>
    <tbody>
        <?php if(!empty($category_counts)): ?>
            <?php foreach($category_counts as $row): ?>
                <tr>

                


                    <td>

                    
                         <?php 
        // Replace & with '-and-' and spaces with '-'
        $cleanState = str_replace([' & ', ' '], ['-and-', '-'], $row['state']);
    ?>
                    
                    
                    
                    <a href="<?= base_url('company/bystate/' . $cleanState) ?>">
        <?= esc($row['state']) ?>
    </a>
    
    
                
                </td>
                    <td><?= (int)$row['TA_count'] ?></td>
                    <td><?= (int)$row['Hotel_count'] ?></td>
                    <td><?= (int)$row['Other_count'] ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4" style="text-align:center;">No data found</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>


<!-- company/index.php -->

<!-- <h3>Database & State Stats</h3>

<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>Database Name</th>
            <th>State</th>
            <th>Company Count</th>
        </tr>
    </thead>
    <tbody>
        <?php if(!empty($database_counts)): ?>
            <?php foreach($database_counts as $row): ?>
                <tr>
                    <td><?= esc($row['database_name']) ?></td>
                    <td><?= esc($row['state']) ?></td>
                    <td><?= esc($row['company_count']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="3">No data found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table> -->

<!-- <h1>Special Tag</h1> -->

<!-- Category Counts Table -->
<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>State</th>
            <th>TA</th>
            <th>Hotel</th>
            <th>Other</th>
        </tr>
    </thead>
    <tbody>
        <?php if(!empty($category_counts)): ?>
            <?php foreach($category_counts as $row): ?>
                <?php 
                    // Clean state for URL
                    $cleanState = str_replace([' & ', ' '], ['-and-', '-'], $row['state']);
                ?>
                <tr>
                    <td>
                        <a href="<?= base_url('company/byvar/state/' . $cleanState) ?>">
                            <?= esc($row['state']) ?>
                        </a>
                    </td>
                    <td>
                        <a href="<?= base_url('company/byvar/category/TA/state/' . $cleanState) ?>">
                            <?= (int)$row['TA_count'] ?>
                        </a>
                    </td>
                    <td>
                        <a href="<?= base_url('company/byvar/category/Hotel/state/' . $cleanState) ?>">
                            <?= (int)$row['Hotel_count'] ?>
                        </a>
                    </td>
                    <td>
                        <a href="<?= base_url('company/byvar/category/Other/state/' . $cleanState) ?>">
                            <?= (int)$row['Other_count'] ?>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4" style="text-align:center;">No data found</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<!-- Database & State Stats Table -->
<h3>Database & State Stats</h3>
<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>Database Name</th>
            <th>State</th>
            <th>Company Count</th>
        </tr>
    </thead>
    <tbody>
        <?php if(!empty($database_counts)): ?>
            <?php foreach($database_counts as $row): ?>
                <?php 
                    $cleanState = str_replace([' & ', ' '], ['-and-', '-'], $row['state']);
                    $cleanDB = str_replace([' '], ['-'], $row['database_name']);
                ?>
                <tr>
                    <td>
                        <a href="<?= base_url('company/byvar/database/' . $cleanDB) ?>">
                            <?= esc($row['database_name']) ?>
                        </a>
                    </td>
                    <td>
                        <a href="<?= base_url('company/byvar/state/' . $cleanState) ?>">
                            <?= esc($row['state']) ?>
                        </a>
                    </td>
                    <td>
                        <a href="<?= base_url('company/byvar/database/' . $cleanDB . '/state/' . $cleanState) ?>">
                            <?= esc($row['company_count']) ?>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="3">No data found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>