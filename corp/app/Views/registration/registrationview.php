<?= view('registration/side') ?>

<!DOCTYPE html>
<html>
<head>
    <title>Companies Overview</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }

        /* Button styles */
        .btn {
            padding: 8px 16px;
            margin-right: 5px;
            text-decoration: none;
            color: #fff;
            background-color: #007BFF;
            border-radius: 4px;
        }

        .btn.active {
            background-color: #0056b3;
            font-weight: bold;
        }

        .btn.inactive {
            background-color: #6c757d;
        }
    </style>
</head>
<body>

<h2>Companies Overview</h2>
<div>
    <?php
        // Get current page segment to determine active button
        $segment = service('uri')->getSegment(3); // "tradevisitor", "exhibitor", or "spot"
    ?>
    <a href="<?= base_url('registration/view/tradevisitor') ?>" class="btn <?= $segment === 'tradevisitor' ? 'active' : 'inactive' ?>">Visitors</a>
    <a href="<?= base_url('registration/view/exhibitor') ?>" class="btn <?= $segment === 'exhibitor' ? 'active' : 'inactive' ?>">Exhibitor</a>
    <a href="<?= base_url('registration/view/spot') ?>" class="btn <?= $segment === 'spot' ? 'active' : 'inactive' ?>">Spot</a>
</div>

<br>
<br>
<?php if(!empty($companies)): ?>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Company ID</th>
                <th>Name</th>
                <th>City</th>
                <th>Phone</th>
                <th>Leads Count</th>
                <th>Sources Count</th>
                <th>Primary Contact</th>
                <th>Contact Email</th>
                <th>Contact Mobile</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($companies as $index => $companyData): ?>
                <?php
                    $leadsCount = count($companyData['leads']);
                    $sourcesCount = count($companyData['sources']);
                    $primaryContact = $primaryEmail = $primaryMobile = '';
                    if(!empty($companyData['leads'])) {
                        foreach($companyData['leads'] as $lead) {
                            if(!empty($lead['contact'])) {
                                $primaryContact = $lead['contact']['name'] ?? '';
                                $primaryEmail = !empty($lead['contact']['emails']) ? $lead['contact']['emails'][0]['email'] : '';
                                $primaryMobile = !empty($lead['contact']['mobiles']) ? $lead['contact']['mobiles'][0]['mobile'] : '';
                                break;
                            }
                        }
                    }
                ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= esc($companyData['company']['company_id']) ?></td>
<td>
    <a href="<?= site_url('company/details/' . $companyData['company']['company_id']) ?>" >
        <?= esc($companyData['company']['company_name']) ?>
    </a>
</td>
                    <td><?= esc($companyData['company']['city']) ?></td>
                    <td><?= esc($companyData['company']['phone']) ?></td>
                    <td><?= $leadsCount ?></td>
                    <td><?= $sourcesCount ?></td>
                    <td><?= esc($primaryContact) ?></td>
                    <td><?= esc($primaryEmail) ?></td>
                    <td><?= esc($primaryMobile) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No companies found.</p>
<?php endif; ?>

</body>
</html>