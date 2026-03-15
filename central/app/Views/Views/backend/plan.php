<?= view('backend/sidemenu') ?>  <!-- loads app/Views/header.php -->

<h1>Company Management System</h1>

<h2>Authentication</h2>
<p>Only logged-in users can access the system. Users are redirected to <code>login.html</code> if not authenticated.</p>

<h2>System Pages Overview</h2>

<h3>1. Home Page (<code>home.html</code>)</h3>
<ul>
  <li>Header with Logo, User Info, and Logout</li>
  <li>Sidebar Navigation: Dashboard, Leads, Exhibitor</li>
  <li>Main Content: Welcome message + Summary Cards (Total Companies, Leads, Exhibitors)</li>
</ul>

<h3>2. Dashboard (<code>dashboard.html</code>)</h3>
<ul>
  <li>Company Search and Filter</li>
  <li>KPI Cards: Companies, Hotels, Travel Agents, Leads, Exhibitors</li>
  <li>Data Visualization: Charts for Companies, Leads, Exhibitors</li>
  <li>Company Details Panel</li>
</ul>

<h3>3. Location & Size Filter</h3>
<ul>
  <li>Dropdowns for Location → Size selection</li>
  <li>Display companies in a table: <strong>Location | Size | Cost</strong></li>
  <li>Support adding multiple locations dynamically</li>
</ul>

<h3>4. Company Listing (<code>companies.html</code>)</h3>
<ul>
  <li>Company table with pagination</li>
  <li>Columns: Name, Type, Country, State, City, Hotels, Travel Agents, Leads, Exhibitors, Status</li>
  <li>Actions: View, Edit, Delete</li>
</ul>

<h3>Common Components</h3>
<ul>
  <li>Header, Sidebar, Footer</li>
  <li>Authentication validation</li>
</ul>

<h3>Suggested File Structure</h3>
<ul>
  <li>login.html, home.html, dashboard.html, location-filter.html, companies.html</li>
  <li>Directories: <code>css/</code>, <code>js/</code>, <code>api/</code></li>
</ul>

<hr>

<h1>Plan 2: Company & Contact Management Workflow</h1>

<section>
<h2>Central Database Management</h2>
<ul>
  <li>Design normalized database: Companies, Contacts, Emails, Mobiles</li>
  <li>Insert bulk data from exhibitions, online sources, and visiting cards</li>
  <li>Deduplicate, clean, and cross-validate entries</li>
  <li>Link company, contact, and communication data</li>
  <li>Maintain audit trails and generate reports</li>
  <li>Monitor data quality and flag anomalies</li>
</ul>
</section>

<section>
<h2>Leads & Booking Management</h2>
<ul>
  <li>Lead creation and automated assignment to agents</li>
  <li>Track leads by year, location, and salesperson</li>
  <li>Maintain booking history and status updates</li>
  <li>Handle cancellations and rescheduling</li>
</ul>
</section>


Event Overview Management System

Purpose:
A centralized system to provide all team members with a clear, unified view of upcoming events, tasks, responsibilities, and vendor details to ensure smooth operations and eliminate communication gaps across departments.

Key Features / Overview:

High-Level Event Planning: Overview of all upcoming events (dates, venues, layouts).

Operational Tasks: Track key tasks required for each event.

Team Responsibilities: Assign who handles which operations (Operations, Sales, Accounts, IT, etc.).

Vendor Management: Centralized list of vendors and the services they provide.

Booking & Participation Tracking: Monitor exhibitor confirmations, allocations, and resources.

Cross-Department Visibility: Ensures every team member has the same information to reduce errors and overlaps.

Outcome / Benefits:

No miscommunication between teams.

Easy tracking of tasks and responsibilities.

Faster decision-making and issue resolution.

Standardized event preparation and execution.

Scalable for multiple events and future exhibitions.


<section>
<h2>Communication & Documentation</h2>
<ul>
  <li>Notify stakeholders with booking updates</li>
  <li>Generate automated confirmations, invoices, and receipts</li>
  <li>Ensure documentation is audit-ready</li>
  <li>Provide alerts for pending actions</li>
</ul>
</section>

<section class="future">
<h2>Advanced / Future Enhancements</h2>
<ul>
  <li>Machine Learning: Automatic duplicate detection</li>
  <li>Confidence Scoring: Auto-score records for validation</li>
  <li>Versioning: Track historical changes in records</li>
  <li>External Integrations: CRM, ERP, or other platforms</li>
</ul>
</section>

<hr>

<h1>Key Result Areas (KRA)</h1>

<section>
<details>
<summary>Exhibition Registration & Badge Management</summary>
<ul>
  <li>On-site registration setup and badge printing</li>
  <li>Real-time badge generation with troubleshooting</li>
</ul>
<div class="outcome">
<strong>Key Outcomes:</strong>
<ul>
  <li>Zero registration downtime</li>
  <li>Accurate badge issuance</li>
  <li>Enhanced exhibitor & volunteer experience</li>
</ul>
</div>
</details>

<details>
<summary>Database Management & Validation</summary>
<ul>
  <li>Maintain central database with cross-validation</li>
  <li>Clean and standardize data from multiple sources</li>
  <li>Correct bounced emails and incomplete records</li>
</ul>
<div class="outcome">
<strong>Key Outcomes:</strong>
<ul>
  <li>High accuracy, reduced duplication</li>
  <li>Reliable reporting base</li>
</ul>
</div>
</details>

<details>
<summary>Lead Management System</summary>
<ul>
  <li>Centralized system for leads tracking</li>
  <li>Lead allocation by year, location, salesperson</li>
  <li>Standardized booking workflow</li>
</ul>
<div class="outcome">
<strong>Key Outcomes:</strong>
<ul>
  <li>Transparent lead allocation</li>
  <li>No duplication or conflicts</li>
  <li>Improved conversion tracking</li>
</ul>
</div>
</details>

<details>
<summary>CodeIgniter 4 Development</summary>
<ul>
  <li>Internal system development with CI4</li>
  <li>Database integration, QR code generation, directory systems</li>
  <li>Maintain scalable internal web applications</li>
</ul>
<div class="outcome">
<strong>Key Outcomes:</strong>
<ul>
  <li>Automation of manual processes</li>
  <li>Improved operational efficiency</li>
</ul>
</div>
</details>

<details>
<summary>Operational & Technical Support</summary>
<ul>
  <li>Assist with event coordination, attendance, and presentations</li>
  <li>Enter visiting card data into systems</li>
</ul>
<div class="outcome">
<strong>Key Outcomes:</strong>
<ul>
  <li>Smooth event operations</li>
  <li>Accurate attendance and reporting</li>
</ul>
</div>
</details>
</section>

<hr>
