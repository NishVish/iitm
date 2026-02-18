<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Project Progress Dashboard</title>
<style>
    body {
        margin: 0;
        font-family: 'Segoe UI', sans-serif;
        background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
        color: #fff;
    }

    .container {
        width: 90%;
        max-width: 1100px;
        margin: 40px auto;
    }

    h1 {
        text-align: center;
        margin-bottom: 40px;
        letter-spacing: 2px;
    }

    .card {
        background: rgba(255, 255, 255, 0.08);
        border-radius: 15px;
        padding: 20px 25px;
        margin-bottom: 25px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.3);
        backdrop-filter: blur(10px);
        transition: transform 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .project-title {
        font-size: 20px;
        margin-bottom: 15px;
        font-weight: bold;
    }

    .progress-bar {
        background: rgba(255,255,255,0.2);
        border-radius: 20px;
        overflow: hidden;
        height: 18px;
        margin-bottom: 15px;
    }

    .progress {
        height: 100%;
        border-radius: 20px;
        text-align: right;
        padding-right: 8px;
        font-size: 12px;
        font-weight: bold;
        line-height: 18px;
    }

    .complete { background: linear-gradient(90deg, #00c853, #64dd17); }
    .mid { background: linear-gradient(90deg, #ffb300, #ff6f00); }
    .low { background: linear-gradient(90deg, #ff5252, #d50000); }

    ul {
        list-style: none;
        padding-left: 0;
    }

    li {
        margin: 6px 0;
        font-size: 14px;
    }

    li.done { color: #00e676; font-weight: bold; }
    li.pending { color: #ffab00; font-weight: bold; }

    /* Subtasks */
    li ul {
        margin-top: 4px;
        margin-left: 20px;
        border-left: 2px dashed rgba(255,255,255,0.3);
        padding-left: 12px;
    }

    li ul li {
        font-size: 13px;
        font-weight: normal;
        margin: 3px 0;
    }

    li ul li.done { color: #00e676; font-weight: normal; }
    li ul li.pending { color: #ffab00; font-weight: normal; }

    .footer {
        text-align: center;
        margin-top: 40px;
        font-size: 14px;
        opacity: 0.8;
    }

    /* Optional: Hover effect for subtasks */
    li ul li:hover {
        text-decoration: underline;
    }
</style>
</head>
<body>

<div class="container">
    <h1>🚀 Project Implementation Dashboard</h1>

    <!-- QR Badge Printing System -->
    <div class="card">
        <div class="project-title">QR Badge Printing System</div>
        <div class="progress-bar">
            <div class="progress complete" style="width:100%;">100%</div>
        </div>
        <ul>
            <li class="done">✔ QR Code Generation</li>
            <li class="done">✔ Registration Form</li>
            <li class="done">✔ Search Interface</li>
            <li class="done">✔ Badge Printing Interface</li>
        </ul>
    </div>

    <!-- Central Database System -->
    <div class="card">
        <div class="project-title">Central Database System</div>
        <div class="progress-bar">
            <div class="progress mid" style="width:70%;">70%</div>
        </div>
        <ul>
<li class="done">Database Designing – Core Tables Overview
    <ul>
        <li>company_data – stores main company details, GST, address, city, state, sales person, and status</li>
        <li>company_data_backup – backup of all company records</li>
        <li>company_full_data – enriched company data including contacts, history, and source tracking</li>
        <li>contact – primary contact details for companies</li>
        <li>contact_email / contact_mobile – multiple emails and mobile numbers per contact</li>
        <li>events – event metadata, venue details, coordinators, and booking info</li>
        <li>leads – exhibitor booking details, payment, and status tracking</li>
        <li>lead_locations – stall details, pricing, discounts, and grand total</li>
        <li>payments – records of payments, modes, and status</li>
        <li>invoices – invoice generation with amounts and PDF storage</li>
        <li>marketing_templates – email and platform-based templates</li>
        <li>sources – tracking lead sources and types</li>
        <li>users – system user roles and status</li>
        <li>updation – logs of updates to company data</li>
    </ul>
</li>
            <li class="done">Data Migration
                <ul>
                    <li class="done">Formatting all Excel files to new standards</li>
                    <li class="done">Writing methods to insert mass data into new SQL tables</li>
                    <li class="done">Basic data cleaning and standardization</li>
                    <li class="pending">Cross-validation logic implementation</li>
                </ul>
            </li>
            <li class="pending">Cross-Validation Cases
                <ul>
                    <li class="pending">Case 1: Exact Company & Exact Contact → Definite duplicate</li>
                    <li class="pending">Case 2: Exact Company & No Contact Match → New contact under existing company</li>
                    <li class="pending">Case 3: Exact Company & Partial Contact → Possible duplicate contact</li>
                    <li class="pending">Case 4: No Company & Exact Contact → Contact linked to wrong company</li>
                    <li class="pending">Case 5: No Company & No Contact → New record</li>
                    <li class="pending">Case 6: No Company & Partial Contact → Possible cross-company duplicate</li>
                    <li class="pending">Case 7: Partial Company & Exact Contact → Possible duplicate company</li>
                    <li class="pending">Case 8: Partial Company & No Contact → Possible duplicate company with new contact</li>
                    <li class="pending">Case 9: Partial Company & Partial Contact → High-risk duplicate, needs review</li>
                </ul>
            </li>
            <li class="done">Search & Lead Marking</li>
            <li class="done">State/City Filtering</li>
            <li class="pending">Mass Mailing and WhatsApp Integration</li>
        </ul>
    </div>

    <!-- Lead Handling -->
    <div class="card">
        <div class="project-title">Lead Handling (Custom CRM)</div>
        <div class="progress-bar">
            <div class="progress mid" style="width:50%;">50%</div>
        </div>
        <ul>
            <li class="done">Marking as Lead</li>
            <li class="done">Saving Company & Person Details</li>
            <li class="done">Stall & Amount Management</li>
            <li class="pending">Payment Integration</li>
            <li class="pending">Invoice & Email Automation</li>
            <li class="pending">Inter-Team Workflow</li>
        </ul>
    </div>

    <!-- Sphere Internal Communication -->
    <div class="card">
        <div class="project-title">Sphere Internal Communication</div>
        <div class="progress-bar">
            <div class="progress low" style="width:30%;">30%</div>
        </div>
        <ul>
            <li class="done">Basic Structure Implemented</li>
            <li class="pending">Advanced Workflow Integration</li>
        </ul>
    </div>

    <!-- Event Overview & Management -->
    <div class="card">
        <div class="project-title">Event Overview & Management System</div>
        <div class="progress-bar">
            <div class="progress low" style="width:0%;">0%</div>
        </div>
        <ul>
            <li class="pending">List all events with dates, venues, and layouts</li>
            <li class="pending">Outline operational tasks and responsibilities</li>
            <li class="pending">Assign teams handling each task</li>
            <li class="pending">Track vendor details and services</li>
            <li class="pending">Monitor bookings, exhibitor participation, and resources</li>
        </ul>
    </div>

    <!-- Analytics & Insights -->
    <div class="card">
        <div class="project-title">Analytics & Insights</div>
        <div class="progress-bar">
            <div class="progress low" style="width:0%;">0%</div>
        </div>
        <ul>
            <li class="pending">Exhibitor Retention Analysis (Regular Participants)</li>
            <li class="pending">New Gains / Market Expansion Tracking</li>
            <li class="pending">Lead Conversion Funnel Analysis</li>
            <li class="pending">Revenue Per Event Dashboard</li>
            <li class="pending">Sales Performance Analytics</li>
            <li class="pending">Real-time Management Reporting Dashboard</li>
        </ul>
    </div>

    <div class="footer">
        Junior Data Analyst / Technical Lead • System Migration • Automation • CRM Development
    </div>
</div>

</body>
</html>
