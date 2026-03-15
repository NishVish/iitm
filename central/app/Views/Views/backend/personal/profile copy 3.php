<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Progress Report - Junior Data Analyst / Technical Lead</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #2c3e50;
            --secondary: #1abc9c;
            --accent: #3498db;
            --bg: #f4f7f6;
            --text: #333;
            --white: #ffffff;
            --danger: #e74c3c;
            --success: #27ae60;
            --gray: #95a5a6;
        }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            background-color: var(--bg);
            color: var(--text);
            display: flex;
        }

        /* Sidebar */
        nav {
            width: 300px;
            background: var(--primary);
            color: var(--white);
            height: 100vh;
            position: fixed;
            padding: 30px 20px;
            box-sizing: border-box;
            box-shadow: 4px 0 10px rgba(0,0,0,0.1);
        }

        nav h2 {
            font-size: 1.1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        nav a {
            color: #bdc3c7;
            text-decoration: none;
            display: block;
            padding: 12px 10px;
            border-radius: 5px;
            transition: 0.3s;
            font-size: 0.9rem;
            margin-bottom: 5px;
        }

        nav a:hover {
            background: rgba(255,255,255,0.05);
            color: var(--secondary);
        }

        /* Main Content */
        main {
            margin-left: 300px;
            padding: 40px;
            width: calc(100% - 300px);
            max-width: 1200px;
        }

        header {
            background: var(--white);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            margin-bottom: 30px;
            border-top: 5px solid var(--accent);
        }

        header h1 { margin: 0; color: var(--primary); font-size: 2.2rem; }
        header h2 { font-size: 1.1rem; color: var(--gray); margin-top: 10px; font-weight: normal; }
        header a { color: var(--accent); text-decoration: none; word-break: break-all; }

        section {
            background: var(--white);
            padding: 35px;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }

        h2 { color: var(--primary); font-size: 1.5rem; margin-top: 0; border-left: 6px solid var(--secondary); padding-left: 15px; }
        h3 { color: var(--accent); font-size: 1.2rem; margin-top: 25px; border-bottom: 1px solid #eee; padding-bottom: 10px; }

        .impact {
            background-color: #f8f9fa;
            border-left: 4px solid var(--secondary);
            padding: 20px;
            margin: 20px 0;
            border-radius: 0 10px 10px 0;
            font-style: italic;
        }

        /* Tables */
        .table-container { overflow-x: auto; margin: 20px 0; }
        table {
            width: 100%;
            border-collapse: collapse;
            background: var(--white);
            border-radius: 8px;
            overflow: hidden;
        }

        th { background: #f1f4f6; color: var(--primary); text-align: left; padding: 15px; font-weight: 600; border: 1px solid #dee2e6; }
        td { padding: 15px; border: 1px solid #dee2e6; font-size: 0.95rem; vertical-align: top; }
        
        tr:nth-child(even) { background-color: #fcfcfc; }

        strong { color: var(--primary); }

        /* Technical Grid */
        .tech-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }

        .tech-item {
            background: #fff;
            border: 1px solid #e1e8ed;
            padding: 12px 18px;
            border-radius: 8px;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            transition: 0.3s;
        }

        .tech-item:hover { border-color: var(--secondary); transform: translateY(-2px); }
        .tech-item i { margin-right: 12px; color: var(--secondary); font-size: 1.1rem; }

        .performance-badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 4px;
            font-weight: bold;
            font-size: 0.85rem;
        }
        .bad { color: var(--danger); }
        .good { color: var(--success); }

        @media (max-width: 1024px) {
            nav { width: 220px; }
            main { margin-left: 220px; width: calc(100% - 220px); }
        }
    </style>
</head>
<body>

    <nav>
        <h2><i class="fa-solid fa-microchip"></i><span style="color:white;">Section </span></h2>
        <a href="#overview"><i class="fa-solid fa-eye"></i> Overview</a>
        <a href="#sec1"><i class="fa-solid fa-qrcode"></i> 1. Registration System</a>
        <a href="#sec2"><i class="fa-solid fa-database"></i> 2. Digital Transformation</a>
        <a href="#sec3"><i class="fa-solid fa-server"></i> 3. SQL & Data Integrity</a>
        <a href="#sec4"><i class="fa-solid fa-users-gear"></i> 4. Custom CRM</a>
        <a href="#sec5"><i class="fa-solid fa-tools"></i> 5. Technical Support</a>
        <a href="#vision"><i class="fa-solid fa-rocket"></i> Strategic Vision</a>
    </nav>

    <main>
        <header id="overview">
            <h1>Junior Data Analyst / Technical Lead</h1>
            <h2>Project Progress Tracking — <a href="https://iitmindia.com/ci/central/project_summary">https://iitmindia.com/ci/central/project_summary</a></h2>
        </header>
  <section>
            <h2>Project Overview</h2>
            <p>Leading the digital transformation of <strong>Travel & Tourism Exhibition</strong> operations by transitioning from fragmented Excel workflows to a robust, centralized <strong>CodeIgniter 4 & SQL</strong> infrastructure.</p>
<div class="tech-grid" style="display: flex; flex-wrap: nowrap; white-space: nowrap;">
    <div class="tech-item" style="width: 25%; text-align: center;">
        <i class="fa-solid fa-database"></i> SQL Architecture
    </div>
    <div class="tech-item" style="width: 25%; text-align: center;">
        <i class="fa-solid fa-code"></i> Backend Dev
    </div>
    <div class="tech-item" style="width: 25%; text-align: center;">
        <i class="fa-solid fa-magnifying-glass-chart"></i> Business Intelligence
    </div>
    <div class="tech-item" style="width: 25%; text-align: center;">
        <i class="fa-solid fa-qrcode"></i> QR Operations
    </div>
</div>

        </section>


        <section id="sec1">
            <h2>1: Registration & Badge Printing System</h2>
            <p><strong>Objective:</strong> Automate the registration and badge printing process to reduce manual errors, ensure consistent data formatting, and improve operational efficiency during exhibitions.</p>
            <p><strong>Background:</strong> Previously, the registration and badge printing process relied on Word documents and manual guesswork, causing frequent human errors, misaligned entries, and unnecessary printing paper wastage.</p>
            
            <h3>Key Responsibilities:</h3>
            <ul>
                <li>Design and develop a QR-based Registration & Badge Printing System.</li>
                <li>Implement live badge printing workflow for Trade Visitors and Exhibitors.</li>
                <li>Coordinate and structure volunteer operations at registration desks.</li>
                <li>Integrate QR-based attendee marking and directory management.</li>
            </ul>
            
            <h3>Expected Outcomes / Impact:</h3>
            <ul>
                <li>Significant reduction in on-site registration time.</li>
                <li>Consistent, error-free data capture.</li>
                <li>Improved visitor experience during live events.</li>
                <li><strong>3 Step Registration:</strong> (Scan QR for Form, Fill Form Details, Show QR or Mention Mobile No. at Desk to Print the Badge)</li>
                <li><strong>3 Step Badge Printing:</strong> (Collecting Business Card, Searching the Entry, Print)</li>
            </ul>
            
            <h3>Performance Metrics Comparison:</h3>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Metric</th>
                            <th>Old Manual System</th>
                            <th>New QR-based System</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Processing Time</strong></td>
                            <td class="bad">2-3 minutes (Word-based entry, guesswork, human errors, paper wastage)</td>
                            <td class="good">&lt; 2 minutes <strong>(Pre-registration: 15 seconds)</strong></td>
                        </tr>
                        <tr>
                            <td><strong>Data Accuracy</strong></td>
                            <td class="bad">75–80% (manual entry errors)</td>
                            <td class="good">99%+</td>
                        </tr>
                        <tr>
                            <td><strong>Data Storage</strong></td>
                            <td>None</td>
                            <td>SQL Table</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <section id="sec2">
            <h2>2. System Development & Digital Transformation</h2>
            <ul>
                <li>Designing a centralized SQL database architecture.</li>
                <li>Migrating legacy Excel data into a structured relational system.</li>
                <li>Developing backend systems using <strong>CodeIgniter 4</strong> and <strong>SQL</strong>.</li>
                <li>Building automated validation logic and duplication handling mechanisms.</li>
                <li>Implementing audit tracking and structured lifecycle data management.</li>
            </ul>
            <div class="impact">
                <strong>Expected Outcome:</strong> Improved data accuracy, reduced manual dependency, elimination of duplication, and creation of a scalable digital foundation for future events.
            </div>
        </section>

        <section id="sec3">
            <h2>2: Centralized Database & Data Integrity Management</h2>
            <p><strong>Objective:</strong> Create a centralized database to ensure data accuracy, eliminate duplication, enable collaboration, and provide a single source of truth for all company, exhibitor, and visitor information.</p>
            <p><strong>Background:</strong> Previously, data management involved multiple Excel files per state, leading to duplication and missing data, with no scope for collaboration. Migrated data to Google Sheets and developed a centralized custom system.</p>
            
            <h3>Responsibilities:</h3>
            <ul>
                <li>Consolidate data from roadshows, exhibitions, online registrations, and third-party sources into a central repository.</li>
                <li>Develop cross-validation logic to ensure data consistency and accuracy across sources.</li>
                <li>Implement structured data cleaning and standardization processes to maintain high-quality data.</li>
                <li>Facilitate collaboration by creating a single source of truth accessible to relevant stakeholders.</li>
            </ul>
            
            <div class="impact">
                <strong>Outcome:</strong> Creation of a reliable, centralized database for company, exhibitor, and visitor data. 
                <ul>
                    <li>Ensures comprehensive coverage in marketing campaigns.</li>
                    <li>Eliminates data loss from unmerged or misplaced Excel files.</li>
                    <li>Provides audit traceability and high reliability for business analytics operations.</li>
                </ul>
            </div>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Metric</th>
                            <th>Old Multiple Excel Files</th>
                            <th>Centralized Database System</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Consolidation Time</strong></td>
                            <td class="bad">Hours per state (manual copy-paste, duplication issues)</td>
                            <td class="good">Minutes (automated aggregation from all sources)</td>
                        </tr>
                        <tr>
                            <td><strong>Data Accuracy</strong></td>
                            <td class="bad">70–80% (manual errors, missing entries)</td>
                            <td class="good">99%+ (cross-validation & standardization)</td>
                        </tr>
                        <tr>
                            <td><strong>Retrieval & Reporting</strong></td>
                            <td>Manual lookup in multiple files, prone to errors</td>
                            <td class="good">Instant SQL-based queries, centralized dashboard</td>
                        </tr>
                        <tr>
                            <td><strong>Collaboration</strong></td>
                            <td>None (files isolated per state)</td>
                            <td class="good">Full collaboration: shared access with audit trail</td>
                        </tr>
                        <tr>
                            <td><strong>Integrity & Audit</strong></td>
                            <td>Low (duplicate/missing files, no version control)</td>
                            <td class="good">High (single source of truth, version-controlled)</td>
                        </tr>
                        <tr>
                            <td><strong>Data Insights</strong></td>
                            <td>Basic numbers only (manual counting, by file)</td>
                            <td class="good">Advanced insights: count by category, region, state, city; dynamic filtering</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <section id="sec4">
            <h2>4: Lead Handling (Custom CRM Development)</h2>
            <p><strong>Background:</strong> Previously, lead and booking management was offline, maintained via paper booking forms and exhibitor ledgers. This led to delays, missing forms, incomplete details, and lack of visibility.</p>

            <h3>Responsibilities:</h3>
            <ul>
                <li>Digitize the traditional booking process into an integrated online system.</li>
                <li>Design lifecycle tracking from lead generation to confirmed exhibitor.</li>
                <li>Structure booking logic to reduce sales overlaps and missing data.</li>
                <li>Develop year-wise, salesperson-wise, and location-wise tracking mechanisms.</li>
            </ul>

            <h3>Planned Business Intelligence:</h3>
            <div class="tech-grid">
                <div class="tech-item"><i class="fa-solid fa-chart-pie"></i> Exhibitor Retention Analysis</div>
                <div class="tech-item"><i class="fa-solid fa-chart-line"></i> Market Growth (“New Gains”)</div>
                <div class="tech-item"><i class="fa-solid fa-filter"></i> Lead Conversion Funnel Tracking</div>
                <div class="tech-item"><i class="fa-solid fa-gauge-high"></i> Real-time Management Dashboards</div>
            </div>

            <div class="impact">
                <strong>Expected Outcome:</strong> Improved sales transparency, reduced booking conflicts, and data-driven strategic decision-making.
            </div>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Metric</th>
                            <th>Old Offline Booking System</th>
                            <th>Custom CRM System</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Tracking & Visibility</strong></td>
                            <td class="bad">Manual, offline, prone to missing forms</td>
                            <td class="good">Digitized lifecycle tracking from lead to exhibitor</td>
                        </tr>
                        <tr>
                            <td><strong>Sales Conflicts</strong></td>
                            <td class="bad">High (manual allocation, duplicates)</td>
                            <td class="good">Structured logic reduces overlaps</td>
                        </tr>
                        <tr>
                            <td><strong>Retrieval & Reporting</strong></td>
                            <td>Time-consuming, manual compilation</td>
                            <td class="good">Automated dashboards (Year/Staff/Loc)</td>
                        </tr>
                        <tr>
                            <td><strong>Retention Insights</strong></td>
                            <td>Limited analysis, manual calculation</td>
                            <td class="good">Retention analysis & Growth tracking</td>
                        </tr>
                        <tr>
                            <td><strong>Decision Making</strong></td>
                            <td class="bad">Reactive, error-prone, delayed</td>
                            <td class="good">Real-time dashboards, data-driven strategy</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <section id="sec5">
            <h2>5. Technical & Operational Support</h2>
            <div class="tech-grid">
                <div class="tech-item"><i class="fa-solid fa-phone-volume"></i> IITM/OTR Call & Email Support</div>
                <div class="tech-item"><i class="fa-solid fa-broom"></i> Data Cleaning & Reporting</div>
                <div class="tech-item"><i class="fa-solid fa-user-check"></i> Attendee Attendance Marking</div>
                <div class="tech-item"><i class="fa-solid fa-keyboard"></i> Typing & Maintaining Card Data</div>
                <div class="tech-item"><i class="fa-solid fa-envelope-circle-check"></i> Email Bounce Handling</div>
                <div class="tech-item"><i class="fa-solid fa-file-powerpoint"></i> PPT Preparation</div>
                <div class="tech-item"><i class="fa-solid fa-globe"></i> Website Updates & Maintenance</div>
                <div class="tech-item"><i class="fa-solid fa-link"></i> QR Directory Linking</div>
                <div class="tech-item"><i class="fa-solid fa-file-export"></i> Data Extraction</div>
                <div class="tech-item"><i class="fa-solid fa-envelope-open-text"></i> Mail Merge</div>
            </div>
        </section>

        <section id="vision">
            <h2>Core Vision & Strategic Contribution</h2>
            <ul style="list-style-type: '🚀 '; padding-left: 20px;">
                <li>Replace manual Excel workflows with scalable digital systems.</li>
                <li>Improve operational speed during exhibitions.</li>
                <li>Increase data accuracy and accountability.</li>
                <li>Deliver actionable insights on retention, growth, and revenue.</li>
                <li>Build sustainable digital infrastructure for long-term expansion.</li>
            </ul>
        </section>
    </main>

</body>
</html>