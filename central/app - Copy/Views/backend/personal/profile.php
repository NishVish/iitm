<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Progress Report - Junior Data Analyst / Technical Lead</title>

<style>
body {
    font-family: Arial, sans-serif;
    margin: 0;
    background-color: #f4f4f4;
    color: #333;
}

main {
    max-width: 1000px;
    margin: auto;
    padding: 20px;
}

header, section {
    background: #fff;
    padding: 20px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
}

h1, h2, h3 {
    margin-top: 0;
}

h2 {
    border-bottom: 2px solid #1abc9c;
    padding-bottom: 5px;
}

h3 {
    margin-top: 20px;
}

a {
    color: #3498db;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}

/* Tables */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

th, td {
    border: 1px solid #ccc;
    padding: 8px;
    text-align: left;
    vertical-align: top;
}

th {
    background: #eee;
}

.bad { color: red; }
.good { color: green; }

/* Impact box */
.impact {
    background: #f9f9f9;
    border-left: 4px solid #1abc9c;
    padding: 10px;
    margin-top: 15px;
}
</style>
</head>

<body>

<main>

<header>
    <h1>Junior Data Analyst / Technical Lead</h1>
    <h3>
        Project Progress Tracking — 
        <a href="https://iitmindia.com/ci/central/project_summary">
            https://iitmindia.com/ci/central/project_summary
        </a>
    </h3>
</header>

<section>
<h2>Profile Overview</h2>
<p>
Leading the digital transformation of <strong>Travel & Tourism Exhibition</strong> operations by transitioning from fragmented Excel workflows to a robust, centralized <strong>CodeIgniter 4 & SQL</strong> infrastructure.
</p>

<ul>
<li>SQL Architecture</li>
<li>Backend Development</li>
<li>Business Intelligence</li>
<li>QR Operations</li>
</ul>
</section>

<section>
<h2>1. Registration & Badge Printing System</h2>

<p><strong>Objective:</strong> Automate the registration and badge printing process to reduce manual errors, ensure consistent data formatting, and improve operational efficiency during exhibitions.</p>

<p><strong>Background:</strong> Previously, the registration and badge printing process relied on Word documents and manual guesswork, causing frequent human errors, misaligned entries, and unnecessary printing paper wastage.</p>

<h3>Key Responsibilities</h3>
<ul>
<li>Design and develop a QR-based Registration & Badge Printing System.</li>
<li>Implement live badge printing workflow for Trade Visitors and Exhibitors At the Venue.</li>
<li>Coordinate and Guiding volunteer operations at registration desks.</li>
</ul>

<h3>Expected Outcomes / Impact</h3>
<ul>
<li>Significant reduction in on-site registration time.</li>
<li>Consistent, error-free data capture.</li>
<li>Improved visitor experience during live events.</li>
<li><strong>3 Step Registration:</strong> Scan QR → Fill Form → Show QR/Mobile to Print</li>
<li><strong>3 Step Badge Printing:</strong> Collect Card → Search Entry → Print</li>
</ul>

<h3>Performance Metrics Comparison</h3>
<table>
<tr>
<th>Metric</th>
<th>Old Manual System</th>
<th>New QR-based System</th>
</tr>
<tr>
<td>Processing Time</td>
<td class="bad">2–3 minutes (Word entry, human errors, paper wastage)</td>
<td class="good">&lt; 2 minutes (Pre-registration: 15 seconds)</td>
</tr>
<tr>
<td>Data Accuracy</td>
<td class="bad">75–80%</td>
<td class="good">99%+</td>
</tr>
<tr>
<td>Data Storage</td>
<td>None</td>
<td>SQL Table</td>
</tr>
</table>
</section>

<section>
<h2>2. System Development & Digital Transformation</h2>

<ul>
<li>Designing a centralized SQL database architecture.</li>
<li>Migrating legacy Excel data into a structured relational system.</li>
<li>Developing backend systems using CodeIgniter 4 and SQL.</li>
<li>Building automated validation logic and duplication handling.</li>
<li>Implementing audit tracking and structured lifecycle management.</li>
</ul>

<div class="impact">
<strong>Expected Outcome:</strong> Improved data accuracy, reduced manual dependency, elimination of duplication, and scalable digital foundation.
</div>
</section>

<section>
<h2>3. Centralized Database & Data Integrity Management</h2>

<p><strong>Objective:</strong> Create a centralized database ensuring data accuracy, eliminating duplication, enabling collaboration, and providing a single source of truth.</p>

<p><strong>Background:</strong> Previously managed via multiple Excel files per state causing duplication and missing data.</p>

<h3>Responsibilities</h3>
<ul>
<li>Consolidate data from roadshows, exhibitions, online registrations, and third-party sources.</li>
<li>Develop cross-validation logic for data consistency.</li>
<li>Implement structured data cleaning and standardization.</li>
<li>Create collaborative shared access for stakeholders.</li>
</ul>

<div class="impact">
<strong>Outcome:</strong> Reliable centralized database ensuring marketing coverage, no data loss, audit traceability, and reliable analytics.
</div>

<h3>Performance Comparison</h3>
<table>
<tr>
<th>Metric</th>
<th>Old Excel System</th>
<th>Centralized Database</th>
</tr>
<tr>
<td>Consolidation Time</td>
<td class="bad">Hours per state</td>
<td class="good">Minutes (automated)</td>
</tr>
<tr>
<td>Data Accuracy</td>
<td class="bad">70–80%</td>
<td class="good">99%+</td>
</tr>
<tr>
<td>Retrieval & Reporting</td>
<td>Manual lookup</td>
<td class="good">Instant SQL queries</td>
</tr>
<tr>
<td>Collaboration</td>
<td>None</td>
<td class="good">Shared access with audit trail</td>
</tr>
<tr>
<td>Integrity & Audit</td>
<td>Low</td>
<td class="good">High (single source of truth)</td>
</tr>
<tr>
<td>Data Insights</td>
<td>Basic numbers</td>
<td class="good">Advanced category & region insights</td>
</tr>
</table>
</section>

<section>
<h2>4. Lead Handling (Custom CRM Development)</h2>

<p><strong>Background:</strong> Previously offline via paper booking forms causing delays and missing details.</p>

<h3>Responsibilities</h3>
<ul>
<li>Digitize booking process into integrated system.</li>
<li>Design lifecycle tracking from lead to confirmed exhibitor.</li>
<li>Structure booking logic reducing overlaps.</li>
<li>Develop year-wise, salesperson-wise, location-wise tracking.</li>
</ul>

<h3>Planned Business Intelligence</h3>
<ul>
<li>Exhibitor Retention Analysis</li>
<li>Market Growth Tracking</li>
<li>Lead Conversion Funnel</li>
<li>Real-time Dashboards</li>
</ul>

<div class="impact">
<strong>Expected Outcome:</strong> Improved sales transparency, reduced conflicts, and data-driven decisions.
</div>

<h3>Performance Comparison</h3>
<table>
<tr>
<th>Metric</th>
<th>Old Offline</th>
<th>Custom CRM</th>
</tr>
<tr>
<td>Tracking</td>
<td class="bad">Manual & Missing</td>
<td class="good">Full Lifecycle Tracking</td>
</tr>
<tr>
<td>Sales Conflicts</td>
<td class="bad">High</td>
<td class="good">Reduced via structured logic</td>
</tr>
<tr>
<td>Reporting</td>
<td>Manual compilation</td>
<td class="good">Automated dashboards</td>
</tr>
<tr>
<td>Retention Insights</td>
<td>Limited</td>
<td class="good">Retention & Growth analytics</td>
</tr>
<tr>
<td>Decision Making</td>
<td class="bad">Reactive</td>
<td class="good">Real-time strategy</td>
</tr>
</table>
</section>

<section>
<h2>5. Technical & Operational Support</h2>
<ul>
<li>IITM/OTR Call & Email Support</li>
<li>Data Cleaning & Reporting</li>
<li>Attendance Marking</li>
<li>Typing & Card Data Maintenance</li>
<li>Email Bounce Handling</li>
<li>PPT Preparation</li>
<li>Website Updates & Maintenance</li>
<li>QR Directory Linking</li>
<li>Data Extraction</li>
<li>Mail Merge</li>
</ul>
</section>

<section>
<h2>Core Vision & Strategic Contribution</h2>
<ul>
<li>Replace manual Excel workflows with scalable systems.</li>
<li>Improve operational speed during exhibitions.</li>
<li>Increase data accuracy and accountability.</li>
<li>Deliver actionable retention & revenue insights.</li>
<li>Build sustainable digital infrastructure.</li>
</ul>
</section>

</main>

</body>
</html>
