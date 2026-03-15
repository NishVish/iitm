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

<h1>Company Management System</h1>

<h2>Authentication</h2>
<p>Only logged-in users can access the system. Redirect to login.html if not logged in.</p>

<h2>Page 1: Home Page (home.html)</h2>
<ul>
  <li>Header: Logo, user info, logout</li>
  <li>Sidebar / Navigation: Dashboard, Leads, Exhibitor</li>
  <li>Content: Welcome message and summary cards (Total Companies, Total Leads, Total Exhibitors)</li>
</ul>

<h2>Page 2: Dashboard (dashboard.html)</h2>
<ul>
  <li>Search companies</li>
  <li>KPI Cards: Total Companies, Hotels, Travel Agents, Total Leads, Total Exhibitors</li>
  <li>Charts: Companies, Leads, Exhibitors</li>
  <li>Company Details Panel</li>
</ul>

<h2>Page 3: Location Filter (location-filter.html)</h2>
<ul>
  <li>Country → State → City filters</li>
  <li>Results: Companies, Leads, Exhibitors, Hotels, Travel Agents</li>
</ul>

<h2>Page 4: Company View (companies.html)</h2>
<ul>
  <li>Company table with pagination</li>
  <li>Search and filters</li>
  <li>Columns: Name, Type, Country, State, City, Hotels, Travel Agents, Leads, Exhibitors, Status</li>
  <li>Actions: View, Edit, Delete</li>
</ul>

<h2>Common Components</h2>
<ul>
  <li>Header</li>
  <li>Sidebar</li>
  <li>Footer</li>
  <li>Authentication check</li>
</ul>

<h2>Suggested File Structure</h2>
<ul>
  <li>login.html</li>
  <li>home.html</li>
  <li>dashboard.html</li>
  <li>location-filter.html</li>
  <li>companies.html</li>
  <li>css/</li>
  <li>js/</li>
  <li>api/</li>
</ul>


Make the Drop down for location then another drop down for size 

then show in table format 
that location is this size is this will cost this much 

then add another location 

</body>
</html>

<h1>Plan 2</h1>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company & Contact Workflow</title>
    <style>

        h1, h2 {
            color: #2c3e50;
        }
        h1 {
            text-align: center;
            margin-bottom: 30px;
        }
        section {
            background: #fff;
            padding: 20px 30px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0px 2px 8px rgba(0,0,0,0.1);
        }
        ul {
            list-style: disc inside;
        }
        li {
            margin-bottom: 10px;
        }
        .future {
            background: #eaf4fc;
            border-left: 5px solid #3498db;
            padding-left: 15px;
        }
    </style>
</head>
<body>

    <h1>Company & Contact Management Workflow</h1>

    <!-- Central Database Section -->
    <section>
        <h2>Central Database</h2>
        <ul>
            <li><strong>Design database schema:</strong> Define tables for companies, contacts, emails, and mobiles.</li>
            <li><strong>Insert large volumes of data:</strong> Efficient data migration from multiple sources.</li>
            <li><strong>Deduplicate, clean, and cross-validate:</strong> Detect duplicates, handle missing and messy data.</li>
            <li><strong>Normalize and link data:</strong> Connect company, contact, email, and mobile information.</li>
            <li><strong>Maintain audit trails:</strong> Track all changes, merges, and validations.</li>
            <li><strong>Generate reports:</strong> Basic and advanced reporting on counts, duplicates, and validation status.</li>
            <li><strong>Monitor data quality:</strong> Track metrics and flag anomalies for review.</li>
        </ul>
    </section>

    <!-- Leads & Booking Section -->
    <section>
        <h2>Leads & Booking</h2>
        <ul>
            <li><strong>Create leads:</strong> Automatically or manually using validated central database records.</li>
            <li><strong>Assign leads:</strong> Allocate leads to agents or teams with priority and tracking.</li>
            <li><strong>Manage bookings and payments:</strong> Secure, multi-step process for bookings and payments.</li>
            <li><strong>Track booking history:</strong> Maintain full record of each lead’s booking status.</li>
            <li><strong>Handle cancellations/modifications:</strong> Support rescheduling or updates to bookings.</li>
        </ul>
    </section>

    <!-- Communication & Documentation Section -->
    <section>
        <h2>Communication & Documentation</h2>
        <ul>
            <li><strong>Share booking details:</strong> Notify customers, teams, and stakeholders.</li>
            <li><strong>Generate confirmations, invoices, receipts:</strong> Automated documentation for bookings.</li>
            <li><strong>Maintain documentation:</strong> Ensure compliance and audit-readiness.</li>
            <li><strong>Provide notifications:</strong> Alerts and reminders for pending actions or follow-ups.</li>
        </ul>
    </section>

    <!-- Optional Advanced / Future Steps Section -->
    <section class="future">
        <h2>Optional Advanced / Future Steps</h2>
        <ul>
            <li><strong>Machine learning:</strong> Suggest merges and detect duplicates automatically.</li>
            <li><strong>Auto-score records:</strong> Confidence scoring for matches or inconsistencies.</li>
            <li><strong>Implement versioning:</strong> Track historical changes in company or contact data.</li>
            <li><strong>Integrate with external systems:</strong> CRM, ERP, or other lead management platforms.</li>
        </ul>
    </section>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Junior Data Analyst / Tech - KRA & Projects</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f6f8;
            color: #333;
        }
        header {
            background-color: #0073e6;
            color: white;
            padding: 20px;
            text-align: center;
        }
        header h1 {
            margin: 0;
            font-size: 1.8em;
        }
        main {
            padding: 20px;
            max-width: 1200px;
            margin: auto;
        }
        h2, h3 {
            color: #0073e6;
        }
        section {
            background: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        ul, ol {
            padding-left: 20px;
        }
        .outcome {
            background-color: #e6f2ff;
            padding: 10px;
            border-left: 4px solid #0073e6;
            margin: 10px 0;
            border-radius: 4px;
        }
        .project-status {
            font-weight: bold;
            color: #0073e6;
        }
        details {
            margin: 10px 0;
        }
        summary {
            cursor: pointer;
            font-weight: bold;
            font-size: 1.1em;
            color: #005bb5;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #0073e6;
            color: white;
        }
        .note {
            font-style: italic;
            color: #555;
        }
        button.toggle-btn {
            background-color: #0073e6;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 15px;
        }
        button.toggle-btn:hover {
            background-color: #005bb5;
        }
    </style>
</head>
<body>
    <header>
        <h1>Junior Data Analyst / Tech - KRA & Projects</h1>
    </header>
    <main>

        <button class="toggle-btn" id="toggleDetails">Show/Hide All Details</button>

        <section>
            <h2>Key Result Areas (KRA)</h2>

            <details>
                <summary>1. Exhibition Registration & Badge Management System</summary>
                <ul>
                    <li>Travel to exhibition venues for on-site registration setup and support.</li>
                    <li>Manage badge printing operations for exhibitors and volunteers.</li>
                    <li>Develop and maintain the Badge Printing System.</li>
                    <li>Ensure smooth real-time registration and badge generation.</li>
                    <li>Troubleshoot technical issues during events.</li>
                </ul>
                <div class="outcome">
                    <strong>Key Outcomes:</strong>
                    <ul>
                        <li>Zero registration downtime during events.</li>
                        <li>Accurate and timely badge printing.</li>
                        <li>Improved exhibitor and volunteer experience.</li>
                    </ul>
                </div>
            </details>

            <details>
                <summary>2. Database Management & Data Validation</summary>
                <ul>
                    <li>Maintain and update central database.</li>
                    <li>Perform cross-validation and insertion of new data from multiple sources: Roadshow events, Exhibition events, Visiting cards, Online registrations, Other offline sources.</li>
                    <li>Clean and standardize raw data.</li>
                    <li>Catch bounced emails and correct records.</li>
                </ul>
                <div class="outcome">
                    <strong>Key Outcomes:</strong>
                    <ul>
                        <li>High data accuracy and reduced duplication.</li>
                        <li>Clean, validated, and structured database.</li>
                        <li>Reliable reporting base for management.</li>
                    </ul>
                </div>
            </details>

            <details>
                <summary>3. Database System Development & Migration</summary>
                <ul>
                    <li>Maintain existing Excel-based database system.</li>
                    <li>Plan and execute migration to SQL database.</li>
                    <li>Design structured database architecture with cross-validation, duplication handling, and centralization.</li>
                </ul>
                <div class="outcome">
                    <strong>Key Outcomes:</strong>
                    <ul>
                        <li>Secure and scalable SQL-based database.</li>
                        <li>Centralized data access.</li>
                        <li>Reduced manual dependency.</li>
                        <li>Improved system efficiency and reporting speed.</li>
                    </ul>
                </div>
            </details>

            <details>
                <summary>4. Lead Management System Development</summary>
                <ul>
                    <li>Build and manage centralized Lead Handling System.</li>
                    <li>Track leads by Year, Location, Salesperson.</li>
                    <li>Maintain lead history and status updates.</li>
                    <li>Standardize booking and sales process to prevent conflicts.</li>
                </ul>
                <div class="outcome">
                    <strong>Key Outcomes:</strong>
                    <ul>
                        <li>Transparent lead allocation system.</li>
                        <li>No duplication or sales conflicts.</li>
                        <li>Standardized and documented booking workflow.</li>
                        <li>Improved conversion tracking.</li>
                    </ul>
                </div>
            </details>

            <details>
                <summary>5. Application Development (CodeIgniter 4)</summary>
                <ul>
                    <li>Develop internal systems using CodeIgniter 4.</li>
                    <li>Integrate central database with web applications.</li>
                    <li>Implement QR code generation and directory systems.</li>
                    <li>Maintain and enhance internal web platforms.</li>
                </ul>
                <div class="outcome">
                    <strong>Key Outcomes:</strong>
                    <ul>
                        <li>Functional and scalable internal systems.</li>
                        <li>Automation of manual processes.</li>
                        <li>Improved operational efficiency.</li>
                    </ul>
                </div>
            </details>

            <details>
                <summary>6. Operational & Technical Support</summary>
                <ul>
                    <li>Assist with calls and email coordination for IITM / OTR events.</li>
                    <li>Mark attendees and manage participation data.</li>
                    <li>Enter visiting card data into the system.</li>
                    <li>Prepare presentations and update websites.</li>
                </ul>
                <div class="outcome">
                    <strong>Key Outcomes:</strong>
                    <ul>
                        <li>Smooth event operations.</li>
                        <li>Accurate attendance tracking.</li>
                        <li>Timely website and marketing updates.</li>
                        <li>Organized and reliable event data records.</li>
                    </ul>
                </div>
            </details>

            <section>
                <h3>Overall Objective</h3>
                <ul>
                    <li>Design, maintain, and improve centralized data systems.</li>
migrate data
cross validation and dupclication handling
                    <li>Ensure accurate data management and reporting.</li>
                    <li>Standardize sales and booking processes.</li>
                    <li>Support exhibitions and roadshow operations.</li>
                    <li>Reduce manual errors and duplication.</li>
                </ul>
            </section>
        </section>

        <section>
            <h2>My Tech Projects</h2>

            <details>
                <summary>QR Registration and Badge Printing</summary>
                <ul>
                    <li>QR code: <span class="project-status">Working</span></li>
                    <li>Form: <span class="project-status">Working</span></li>
                    <li>Searching and Printing Entry: <span class="project-status">Working</span></li>
                    <li>Documentation: Provided via links.</li>
                </ul>
            </details>

            <details>
                establising central database
                desiging database and tables 
                migarting data to sql 
                designind lead system 
                processcing payment 
                
                <summary>Leads (Depends on Central Database)</summary>
                <ul>
                    <li>Marking as Leads: <span class="project-status">Done</span></li>
                    <li>Company Details: <span class="project-status">Done</span></li>
                    <li>Booking Details: <span class="project-status">Done</span></li>
                    <li>Summary: <span class="project-status">Done</span></li>
                    <li>Payment Integration: <span class="project-status">Pending</span></li>
                    <li>Leads can handle multiple locations.</li>
                </ul>
                <details>
                    <summary>Communication</summary>
                    <ul>
                        <li>Show all Leads: <span class="project-status">Done</span></li>
                        <li>Take requirements of the exhibitor: <span class="project-status">Pending</span></li>
                    </ul>
                </details>
            </details>

            <details>
                <summary>Backup & Central Database Operations</summary>
                <ul>
                    <li>Search Company</li>
                    <li>Add New Contact / Company / Source</li>
                    <li>Edit Entries</li>
                    <li>Large Data Insertion (Migration): <span class="project-status">Working</span></li>
                    <li>Cross Validation: <span class="project-status">Working</span></li>
                    <li>Invalid Entries / Missing Data Handling: <span class="project-status">Working</span></li>
                    <li>Exporting data & Security Parameters</li>
                </ul>

                <details>
                    <summary>Cross Validation Cases</summary>
                    <table>
                        <tr>
                            <th>Case #</th>
                            <th>Company Match</th>
                            <th>Contact Match</th>
                            <th>Meaning / Interpretation</th>
                        </tr>
                        <tr><td>1</td><td>Exact</td><td>Exact</td><td>Same company and same contact → definite duplicate</td></tr>
                        <tr><td>2</td><td>Exact</td><td>No</td><td>Same company but contact does not match → new contact under existing company</td></tr>
                        <tr><td>3</td><td>Exact</td><td>Partial</td><td>Same company, contact looks similar → possible duplicate contact</td></tr>
                        <tr><td>4</td><td>No</td><td>Exact</td><td>Different company but same contact → contact linked to wrong company or shared person</td></tr>
                        <tr><td>5</td><td>No</td><td>No</td><td>Completely different company and contact → new record</td></tr>
                        <tr><td>6</td><td>No</td><td>Partial</td><td>Different company, contact partially matches → possible cross-company duplicate contact</td></tr>
                        <tr><td>7</td><td>Partial</td><td>Exact</td><td>Company looks similar, same contact → possible duplicate company</td></tr>
                        <tr><td>8</td><td>Partial</td><td>No</td><td>Company looks similar, contact is new → possible duplicate company with new contact</td></tr>
                        <tr><td>9</td><td>Partial</td><td>Partial</td><td>Both company and contact look similar → high-risk duplicate, needs review</td></tr>
                    </table>
                </details>
            </details>

            <p class="note">Once the central database is established, insights and statistics can be generated such as company count by categories, active participants by event, and location-wise company distribution.</p>
        </section>

    </main>

    <script>
        const toggleBtn = document.getElementById('toggleDetails');
        let detailsVisible = false;

        toggleBtn.addEventListener('click', () => {
            const allDetails = document.querySelectorAll('details');
            allDetails.forEach(d => d.open = !detailsVisible);
            detailsVisible = !detailsVisible;
            toggleBtn.textContent = detailsVisible ? "Hide All Details" : "Show All Details";
        });
    </script>
</body>
</html>

