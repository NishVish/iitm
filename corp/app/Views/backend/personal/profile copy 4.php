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
            --card-shadow: 0 10px 30px rgba(0,0,0,0.08);
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
            z-index: 100;
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
            box-shadow: var(--card-shadow);
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
            box-shadow: var(--card-shadow);
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

        /* Transformation Bar */
        .trans-bar {
            display: flex;
            align-items: center;
            background: linear-gradient(135deg, var(--primary), #34495e);
            padding: 25px;
            border-radius: 12px;
            color: white;
            margin: 25px 0;
            justify-content: space-around;
            text-align: center;
        }

        /* Grid Layouts */
        .tech-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }

        .tech-item {
            background: #fff;
            border: 1px solid #e1e8ed;
            padding: 15px;
            border-radius: 10px;
            font-size: 0.9rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transition: 0.3s;
            text-align: center;
        }

        .tech-item:hover { border-color: var(--secondary); transform: translateY(-3px); box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
        .tech-item i { margin-bottom: 10px; color: var(--secondary); font-size: 1.5rem; }

        .performance-badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 4px;
            font-weight: bold;
            font-size: 0.85rem;
        }
        .bad { color: var(--danger); font-weight: bold;}
        .good { color: var(--success); font-weight: bold;}

        @media (max-width: 1024px) {
            nav { width: 220px; }
            main { margin-left: 220px; width: calc(100% - 220px); }
        }
    </style>
</head>
<body>

    <nav>
        <h2><i class="fa-solid fa-microchip"></i> Operations Hub</h2>
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
            
            <div class="tech-grid">
                <div class="tech-item"><i class="fa-solid fa-database"></i> <strong>SQL Architecture</strong></div>
                <div class="tech-item"><i class="fa-solid fa-code"></i> <strong>Backend Dev</strong></div>
                <div class="tech-item"><i class="fa-solid fa-magnifying-glass-chart"></i> <strong>Business Intelligence</strong></div>
                <div class="tech-item"><i class="fa-solid fa-qrcode"></i> <strong>QR Operations</strong></div>
            </div>
        </section>

        <section id="sec1">
            <h2>1: Registration & Badge Printing System</h2>
            <p><strong>Objective:</strong> Automate the registration process to ensure data consistency and operational efficiency during exhibitions.</p>
            
            <div class="trans-bar">
                <div style="flex: 1;">
                    <small style="text-transform: uppercase; opacity: 0.7;">Before</small>
                    <div style="font-size: 1.1rem; color: #ff7675;">Manual Word Docs</div>
                </div>
                <div style="font-size: 1.5rem; opacity: 0.5;">➔</div>
                <div style="flex: 1;">
                    <small style="text-transform: uppercase; opacity: 0.7;">After</small>
                    <div style="font-size: 1.1rem; color: var(--secondary);">QR-Based SQL System</div>
                </div>
            </div>

            <h3>Key Responsibilities:</h3>
            <div class="tech-grid">
                <div class="tech-item" style="flex-direction: row; justify-content: start;"><i class="fa-solid fa-check-circle" style="margin-bottom:0; margin-right:10px;"></i>QR System Design</div>
                <div class="tech-item" style="flex-direction: row; justify-content: start;"><i class="fa-solid fa-check-circle" style="margin-bottom:0; margin-right:10px;"></i>Live Workflow Ops</div>
                <div class="tech-item" style="flex-direction: row; justify-content: start;"><i class="fa-solid fa-check-circle" style="margin-bottom:0; margin-right:10px;"></i>Volunteer Coordination</div>
                <div class="tech-item" style="flex-direction: row; justify-content: start;"><i class="fa-solid fa-check-circle" style="margin-bottom:0; margin-right:10px;"></i>Attendee Tracking</div>
            </div>

            <h3>Performance Metrics:</h3>
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
                            <td class="bad">2-3 minutes</td>
                            <td class="good">&lt; 2 minutes (Pre-reg: 15s)</td>
                        </tr>
                        <tr>
                            <td><strong>Data Accuracy</strong></td>
                            <td class="bad">75–80% errors</td>
                            <td class="good">99%+ Accuracy</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <section id="sec2">
            <h2>2. System Development & Transformation</h2>
            <div class="impact">
                Migrating legacy Excel data into a structured relational system using <strong>CodeIgniter 4</strong> and <strong>SQL</strong> to build a scalable digital foundation.
            </div>
            <ul>
                <li>Centralized SQL database architecture design.</li>
                <li>Automated validation logic and duplication handling.</li>
                <li>Audit tracking and lifecycle data management.</li>
            </ul>
        </section>

        <section id="sec3">
            <h2>3: SQL & Data Integrity Management</h2>
            <p><strong>Objective:</strong> Create a "Single Source of Truth" to eliminate duplication and enable cross-team collaboration.</p>
            
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Comparison</th>
                            <th>Excel Legacy</th>
                            <th>Centralized SQL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Consolidation</strong></td>
                            <td class="bad">Hours per state</td>
                            <td class="good">Instant Aggregation</td>
                        </tr>
                        <tr>
                            <td><strong>Collaboration</strong></td>
                            <td class="bad">Isolated Files</td>
                            <td class="good">Shared Access / Audit Trail</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <section id="sec4">
            <h2>4: Custom CRM Development</h2>
            <p>Digitizing the traditional paper-based booking process into an integrated online system for better lifecycle tracking.</p>

            <div class="tech-grid">
                <div class="tech-item"><i class="fa-solid fa-chart-pie"></i>Retention Analysis</div>
                <div class="tech-item"><i class="fa-solid fa-chart-line"></i>Market Growth</div>
                <div class="tech-item"><i class="fa-solid fa-filter"></i>Lead Funnels</div>
                <div class="tech-item"><i class="fa-solid fa-gauge-high"></i>Real-time Dashboards</div>
            </div>
        </section>

        <section id="sec5">
            <h2>5. Technical & Operational Support</h2>
            <div class="tech-grid">
                <div class="tech-item"><i class="fa-solid fa-phone-volume"></i>Call Support</div>
                <div class="tech-item"><i class="fa-solid fa-broom"></i>Data Cleaning</div>
                <div class="tech-item"><i class="fa-solid fa-user-check"></i>Attendance</div>
                <div class="tech-item"><i class="fa-solid fa-globe"></i>Web Updates</div>
                <div class="tech-item"><i class="fa-solid fa-envelope-circle-check"></i>Mail Ops</div>
                <div class="tech-item"><i class="fa-solid fa-file-export"></i>Extraction</div>
            </div>
        </section>

        <section id="vision" style="background: var(--primary); color: white;">
            <h2 style="color: var(--secondary); border-left-color: var(--secondary);">Strategic Vision</h2>
            <ul style="list-style-type: '🚀 '; padding-left: 20px;">
                <li>Replace manual Excel workflows with scalable SQL systems.</li>
                <li>Improve operational speed during live exhibitions.</li>
                <li>Deliver actionable insights on retention and revenue growth.</li>
                <li>Build a sustainable digital infrastructure for future expansion.</li>
            </ul>
        </section>
    </main>
</body>
</html>