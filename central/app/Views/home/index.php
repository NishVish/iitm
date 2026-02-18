<?= view('header') ?>  <!-- loads app/Views/header.php -->
<?php
$segment1 = service('uri')->getSegment(1);

if ($segment1 == 'backend') : ?>
    <div class="submenu">
        <a href="<?= base_url('plan') ?>">Plan</a>
        <a href="<?= base_url('games') ?>">Play Games</a>
        <a href="<?= base_url('tv') ?>">TV</a>
        <a href="<?= base_url('company') ?>">View Companies</a>
        <a href="<?= base_url('company/add') ?>">Add Company</a>
    </div>
<?php endif; ?>

</div>

<div class="content">

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f8f4f4; /* light background for contrast */
        color: #333;
    }

    h1, h2 {
        color: #a82324; /* deep red headings */
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 40px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        border-radius: 8px;
        overflow: hidden;
    }

    th, td {
        border: 1px solid #a82324;
        padding: 12px 15px;
        text-align: left;
    }

    th {
        background-color: #a82324;
        color: #fff;
        font-weight: bold;
    }

    tr:nth-child(even) {
        background-color: #fddede; /* lighter red for contrast */
    }

    tr:nth-child(odd) {
        background-color: #fff0f0; /* subtle off-white for readability */
    }

    tr:hover {
        background-color: #f8c0c2; /* hover highlight in palette */
        transition: background-color 0.3s ease;
    }

    code {
        background-color: #fddede; /* lighter shade of red */
        color: #a82324; /* deep red text */
        padding: 4px 8px;
        border-radius: 4px;
        display: block;
        white-space: pre-wrap;
        margin: 5px 0;
    }
</style>

</head>
<body>
    <h1>Company Database Analytics Overview</h1>

    <!-- 1. Company Analytics -->
    <h2>1. Company Analytics</h2>
    <table>
        <tr>
            <th>Metric</th>
            <th>Description</th>
            <th>Example SQL</th>
        </tr>
        <tr>
            <td>Active vs Inactive Companies</td>
            <td>Count of companies based on their `active_inactive` status</td>
            <td><code>
SELECT active_inactive, COUNT(*) AS total_companies
FROM company_data
GROUP BY active_inactive;
            </code></td>
        </tr>
        <tr>
            <td>Company Distribution by Country</td>
            <td>Number of active companies in each country</td>
            <td><code>
SELECT country, COUNT(*) AS total_companies
FROM company_data
WHERE active_inactive = 'active'
GROUP BY country;
            </code></td>
        </tr>
        <tr>
            <td>Companies by Category</td>
            <td>Distribution of companies across categories</td>
            <td><code>
SELECT category, COUNT(*) AS total_companies
FROM company_data
GROUP BY category;
            </code></td>
        </tr>
    </table>

    <!-- 2. Contact Analytics -->
    <h2>2. Contact Analytics</h2>
    <table>
        <tr>
            <th>Metric</th>
            <th>Description</th>
            <th>Example SQL</th>
        </tr>
        <tr>
            <td>Total Contacts per Company</td>
            <td>Number of contacts linked to each company</td>
            <td><code>
SELECT company_id, COUNT(*) AS total_contacts
FROM contact
GROUP BY company_id;
            </code></td>
        </tr>
        <tr>
            <td>Contacts with Email</td>
            <td>Number of contacts having primary emails</td>
            <td><code>
SELECT c.company_id, COUNT(e.email_id) AS contacts_with_email
FROM contact c
JOIN contact_email e ON c.contact_id = e.contact_id
WHERE e.is_primary = 1
GROUP BY c.company_id;
            </code></td>
        </tr>
    </table>

    <!-- 3. Leads & Sales Analytics -->
    <h2>3. Leads & Sales Analytics</h2>
    <table>
        <tr>
            <th>Metric</th>
            <th>Description</th>
            <th>Example SQL</th>
        </tr>
        <tr>
            <td>Lead Status Distribution</td>
            <td>Count of leads by their `status`</td>
            <td><code>
SELECT status, COUNT(*) AS total_leads
FROM leads
GROUP BY status;
            </code></td>
        </tr>
        <tr>
            <td>Revenue per Salesperson</td>
            <td>Sum of lead prices grouped by salesperson</td>
            <td><code>
SELECT sales_person, SUM(price) AS total_leads_value
FROM leads
GROUP BY sales_person;
            </code></td>
        </tr>
    </table>

    <!-- 4. Event & Marketing Analytics -->
    <h2>4. Event & Marketing Analytics</h2>
    <table>
        <tr>
            <th>Metric</th>
            <th>Description</th>
            <th>Example SQL</th>
        </tr>
        <tr>
            <td>Companies Participated Per Year</td>
            <td>Count of distinct companies attending events by year</td>
            <td><code>
SELECT exhibition_year, COUNT(DISTINCT company_id) AS companies_participated
FROM leads
GROUP BY exhibition_year;
            </code></td>
        </tr>
        <tr>
            <td>Marketing Templates by Platform</td>
            <td>Number of templates created for each marketing platform</td>
            <td><code>
SELECT platform, COUNT(*) AS templates_count
FROM marketing_templates
GROUP BY platform;
            </code></td>
        </tr>
    </table>

    <!-- 5. Payment & Invoice Analytics -->
    <h2>5. Payment & Invoice Analytics</h2>
    <table>
        <tr>
            <th>Metric</th>
            <th>Description</th>
            <th>Example SQL</th>
        </tr>
        <tr>
            <td>Total Revenue per Company</td>
            <td>Sum of all paid amounts grouped by company</td>
            <td><code>
SELECT company_id, SUM(amount) AS total_paid
FROM payments
WHERE payment_status = 'paid'
GROUP BY company_id;
            </code></td>
        </tr>
        <tr>
            <td>Pending Payments</td>
            <td>List of payments still pending</td>
            <td><code>
SELECT * 
FROM payments
WHERE payment_status = 'pending';
            </code></td>
        </tr>
    </table>

    <!-- 6. Cross-Validation Analytics -->
    <h2>6. Cross-Validation Analytics</h2>
    <table>
        <tr>
            <th>Metric</th>
            <th>Description</th>
            <th>Example SQL</th>
        </tr>
        <tr>
            <td>Cross-Validated Companies</td>
            <td>Percentage of companies marked for cross-validation</td>
            <td><code>
SELECT 
    SUM(cross_validation) / COUNT(*) * 100 AS cross_validation_percent
FROM company_data;
            </code></td>
        </tr>
    </table>

</body>
</html>
