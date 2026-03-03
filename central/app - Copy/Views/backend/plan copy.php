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



    Directory: C:\xampp\htdocs\iitm\central\app\Controllers


Mode                 LastWriteTime         Length Name
----                 -------------         ------ ----
-a----        13-02-2026     15:15            825 Authentication.php
-a----        23-01-2026     16:05           1257 Backend.php
-a----        12-12-2025     02:37           1352 BaseController.php
-a----        14-02-2026     15:47           9371 Booking.php
-a----        20-01-2026     15:56           4718 Company copy.php
-a----        16-02-2026     15:25          24622 Company.php
-a----        16-02-2026     15:15          35227 CrossValidation.php
-a----        13-02-2026     15:14           1556 Dashboard.php
-a----        02-02-2026     16:02           3403 DatabaseOperation.php
-a----        20-01-2026     12:36           3243 Events.php
-a----        13-02-2026     15:15            244 Home.php
-a----        20-01-2026     12:11           1232 LayoutInfo.php
-a----        14-02-2026     14:50           6541 Leads.php
-a----        16-01-2026     15:45           1164 Master.php
-a----        21-01-2026     13:58            322 Operations.php
-a----        20-01-2026     17:46           1255 Search.php


PS C:\xampp\htdocs\iitm\central\app\Controllers> c


    Directory: C:\xampp\htdocs\iitm\central\app\Models


Mode                 LastWriteTime         Length Name
----                 -------------         ------ ----
-a----        12-12-2025     02:37              0 .gitkeep
-a----        20-01-2026     15:51           3076 CompanyModel copy.php
-a----        04-02-2026     15:09           5747 CompanyModel.php
-a----        27-01-2026     18:14            270 ContactEmailModel.php
-a----        27-01-2026     18:13            274 ContactMobileModel.php
-a----        27-01-2026     18:29           1445 ContactModel.php
-a----        16-01-2026     11:48           1693 Dashboard_model.php
-a----        27-01-2026     10:39            505 DiscussionModel.php
-a----        20-01-2026     12:38           1457 EventModel.php
-a----        16-01-2026     18:38            306 ExhibitionModel.php
-a----        20-01-2026     12:11            810 LayoutInfoModel.php
-a----        14-02-2026     11:36            532 LeadLocationModel.php
-a----        14-02-2026     17:28           4327 LeadModel.php
-a----        16-01-2026     14:23           1164 MasterModel.php
-a----        03-02-2026     12:51            610 MatchingSessionModel.php
-a----        24-01-2026     15:34            304 SourceModel.php
-a----        03-02-2026     12:41            875 UpdationModel.php


PS C:\xampp\htdocs\iitm\central\app\Models>


    Directory: C:\xampp\htdocs\iitm\central\app\Views


Mode                 LastWriteTime         Length Name
----                 -------------         ------ ----
d-----        22-01-2026     17:39                backend
d-----        13-02-2026     18:42                booking
d-----        09-02-2026     11:50                company
d-----        06-02-2026     16:04                crossvalidation
d-----        22-01-2026     17:39                dashboard
d-----        22-01-2026     17:39                errors
d-----        22-01-2026     17:39                events
d-----        05-02-2026     14:22                home
d-----        22-01-2026     17:39                leads
d-----        22-01-2026     17:39                search
-a----        16-02-2026     12:59           9390 header.php
-a----        13-02-2026     15:53           3379 login.php

in html page what out plan is what are the pages what are the functino in the pages....

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Default route (landing page)
$routes->get('/', 'Home::index');
$routes->post('login', 'Authentication::login');

// Backend home / admin panel
$routes->get('backend', 'Backend::index');
$routes->get('plan', 'Backend::plan');
$routes->get('backend/sql', 'Backend::sql');
$routes->post('backend/sql/run', 'Backend::runSql');


// ===============================
// Dashboard routes
// ===============================

// Dashboard main page
$routes->get('dashboard', 'Dashboard::index');
$routes->post('dashboard/search', 'Dashboard::search');

// ===============================
// Company management routes
// ===============================

$routes->get('company', 'Company::index');               // Main page
$routes->post('company/getCities', 'Company::getCities');        // AJAX: get cities by state
$routes->post('company/filterCompanies', 'Company::filterCompanies');

$routes->get('company/details/(:any)', 'Company::details/$1');

$routes->post('master/filterCompanies', 'Master::filterCompanies');

$routes->get('company', 'Company::index');
$routes->post('company/compare_popup', 'Company::compare_popup');

// Add new company
// Show add company form
$routes->post('company/add_details', 'Company::add_details');
$routes->get('company/dummy', 'Company::dummyData');

$routes->get('company/add', 'Company::add'); // Show the form

// Preview form data (POST only)
$routes->post('company/add_check', 'Company::add_check'); 

$routes->post('company/store', 'Company::store');

// Edit company
$routes->get('company/edit/(:segment)', 'Company::edit/$1');
$routes->post('company/update/(:segment)', 'Company::update/$1');

// Delete company (optional)
$routes->post('company/delete/(:segment)', 'Company::delete/$1');


// Optional: replace existing company if user chooses
$routes->post('company/replace/(:num)', 'Company::replace/$1');

// List page after adding
$routes->get('company/list', 'Company::list');    // Optional: show all companies

$routes->post('company/source_check', 'Company::source_check');

// $routes->post('update/(:segment)', 'Company::update/$1');


// Show the add contact form
$routes->get('contacts/add/(:any)', 'Contacts::add/$1'); 
// (:any) is for company_id

// Handle the form submission
$routes->post('contacts/savePerson', 'Company::savePerson');


// ===============================
// Leads / Booking routes
// ===============================
$routes->get('leads', 'Leads::index');
$routes->get('lead/details/(:any)', 'Leads::details/$1');
// $routes->get('leads/view/(:segment)', 'Leads::view/$1');
$routes->post('leads/create', 'Leads::createLead');
$routes->post('leads/store', 'Leads::store');
$routes->post('leads/clear', 'Leads::clearLeads');
$routes->get('leads/add-random', 'Leads::addRandomLead');

$routes->post('discussion/add', 'Leads::add');


// ===============================
// Event routes
// ===============================
$routes->get('events', 'Events::index');
$routes->get('events/create', 'Events::create');
$routes->post('events/store', 'Events::store');
$routes->get('events/edit/(:num)', 'Events::edit/$1');
$routes->post('events/update/(:num)', 'Events::update/$1');
$routes->get('events/delete/(:num)', 'Events::delete/$1');


$routes->group('layout-info', function ($routes) {
    $routes->get('/', 'LayoutInfo::index');          // list layouts
    $routes->get('create', 'LayoutInfo::create');    // show create form
    $routes->post('store', 'LayoutInfo::store');     // save layout
});
// Negotiation asking for 5000 Less if Booked for 3 Location

// ===============================
// Payments routes
// ===============================
$routes->group('booking', function($routes) {

    // Step 1
    // $routes->get('instructions', 'Exhibitor::instructions');
$routes->get('instructions/(:segment)', 'Booking::instructions/$1');

    // Step 2
    $routes->get('company/(:segment)', 'Booking::company/$1');

    // $routes->get('company/(:num)', 'Exhibitor::company/$1');

    // Step 3
    // $routes->get('exhibition/(:num)', 'Exhibitor::exhibition/$1');
    $routes->get('booking_details/(:segment)', 'Booking::booking_details/$1');

    // Payment
    $routes->post('savebookingdetails/(:segment)', 'Booking::savebookingdetails/$1');


    $routes->get('summary/(:num)', 'Booking::summary/$1');

    $routes->get('view', 'Booking::public_view');           // GET: show the form
    $routes->post('view', 'Booking::show_booking_details'); // POST: process the form
});



    // // ===============================
    // // Exhibitor Booking
    // // ===============================
    // $routes->get('exhibitor_booking', 'Booking::exhibitor_bookinginstructions');
    // $routes->get('exhibitor_booking/stallinfo', 'Booking::stallinfo');
    // $routes->get('exhibitor_booking/details', 'Booking::exhibitor_details');




login Home Backend Plan Companies Events Layout Add Companies Leads Crossvalidation Exhibitor Booking View Booking MyPhpAdmin
Search...
 Search
⚙️
Company Management System
Authentication
Only logged-in users can access the system. Redirect to login.html if not logged in.

Page 1: Home Page (home.html)
Header: Logo, user info, logout
Sidebar / Navigation: Dashboard, Leads, Exhibitor
Content: Welcome message and summary cards (Total Companies, Total Leads, Total Exhibitors)
Page 2: Dashboard (dashboard.html)
Search companies
KPI Cards: Total Companies, Hotels, Travel Agents, Total Leads, Total Exhibitors
Charts: Companies, Leads, Exhibitors
Company Details Panel
Page 3: Location Filter (location-filter.html)
Country → State → City filters
Results: Companies, Leads, Exhibitors, Hotels, Travel Agents
Page 4: Company View (companies.html)
Company table with pagination
Search and filters
Columns: Name, Type, Country, State, City, Hotels, Travel Agents, Leads, Exhibitors, Status
Actions: View, Edit, Delete
Common Components
Header
Sidebar
Footer
Authentication check
Suggested File Structure
login.html
home.html
dashboard.html
location-filter.html
companies.html
css/
js/
api/
Make the Drop down for location then another drop down for size then show in table format that location is this size is this will cost this much then add another location
Plan 2
Company & Contact Management Workflow
Central Database
Design database schema: Define tables for companies, contacts, emails, and mobiles.
Insert large volumes of data: Efficient data migration from multiple sources.
Deduplicate, clean, and cross-validate: Detect duplicates, handle missing and messy data.
Normalize and link data: Connect company, contact, email, and mobile information.
Maintain audit trails: Track all changes, merges, and validations.
Generate reports: Basic and advanced reporting on counts, duplicates, and validation status.
Monitor data quality: Track metrics and flag anomalies for review.
Leads & Booking
Create leads: Automatically or manually using validated central database records.
Assign leads: Allocate leads to agents or teams with priority and tracking.
Manage bookings and payments: Secure, multi-step process for bookings and payments.
Track booking history: Maintain full record of each lead’s booking status.
Handle cancellations/modifications: Support rescheduling or updates to bookings.
Communication & Documentation
Share booking details: Notify customers, teams, and stakeholders.
Generate confirmations, invoices, receipts: Automated documentation for bookings.
Maintain documentation: Ensure compliance and audit-readiness.
Provide notifications: Alerts and reminders for pending actions or follow-ups.
Optional Advanced / Future Steps
Machine learning: Suggest merges and detect duplicates automatically.
Auto-score records: Confidence scoring for matches or inconsistencies.
Implement versioning: Track historical changes in company or contact data.
Integrate with external systems: CRM, ERP, or other lead management platforms.
combine them 

<!-- I Think I Need to Make an Operation Page Also
 Branding is True then it will be show to opeation teams
 all the requirement and rates will be shown at final invoice and quotes will be genearte and sent to both parties of the conclusion
 -->


 <!-- A Backend Page to Store Layout -->

 <!-- Show Layout To Exhibitor ask them choose it show them the amount
  they will send request  -->

  <!-- A Page to Have All The Details About the Exhibition
   all Exhibitor
   all Fasica Name
   Venue B2B 
   all Template and Emails
  last Updated Layout Previous Layout 
  
  
  Event ID
  Days
  B2B Constrain
  Year
  Name
  Venue Details
  Venue Booking Details
  Coordinator

Maketing Templates
Event ID
Platform
Image or images
Email Formats
date


Layout Info
Event ID
pdf or image
data






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detailed Project Overview | IITM Central System</title>
    <style>
        :root {
            --primary: #2c3e50;
            --secondary: #3498db;
            --success: #27ae60;
            --warning: #f39c12;
            --danger: #e74c3c;
            --light: #ecf0f1;
        }
        body { font-family: 'Segoe UI', sans-serif; line-height: 1.6; color: #333; margin: 0; background: #f4f7f9; }
        .container { max-width: 1100px; margin: 30px auto; background: white; padding: 40px; border-radius: 12px; box-shadow: 0 5px 25px rgba(0,0,0,0.1); }
        header { border-bottom: 4px solid var(--primary); margin-bottom: 30px; padding-bottom: 10px; }
        h1 { color: var(--primary); margin: 0; }
        h2 { color: var(--secondary); border-left: 5px solid var(--secondary); padding-left: 15px; margin-top: 40px; }
        h3 { color: var(--primary); background: var(--light); padding: 10px; border-radius: 5px; }
        
        .workflow-box { display: flex; justify-content: space-between; gap: 20px; margin: 20px 0; }
        .step { flex: 1; background: #fff; border: 1px solid #ddd; padding: 15px; border-radius: 8px; text-align: center; }
        
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { border: 1px solid #dfe6e9; padding: 12px; text-align: left; }
        th { background: var(--primary); color: white; }
        tr:nth-child(even) { background: #f9f9f9; }
        
        .code-block { background: #2d3436; color: #fab1a0; padding: 15px; border-radius: 6px; font-family: monospace; overflow-x: auto; }
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 0.85em; font-weight: bold; }
        .badge-logic { background: #ffeaa7; color: #d35400; }
        
        .op-section { border: 2px dashed var(--warning); padding: 20px; border-radius: 10px; margin-top: 20px; }
    </style>
</head>
<body>

<div class="container">
    <header>
        <h1>Company & Exhibition Management System</h1>
        <p><strong>Version:</strong> 2.0 | <strong>Framework:</strong> CodeIgniter 4 | <strong>Status:</strong> Operational & Scalable</p>
    </header>

    <section>
        <h2>1. System Architecture & Routing</h2>
        <p>The system follows a strict MVC pattern to separate data integrity from user interaction. Below is the technical file mapping for core functions:</p>
        
        <table>
            <thead>
                <tr>
                    <th>Module</th>
                    <th>Controller</th>
                    <th>Model</th>
                    <th>Key Functionality</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>Auth</strong></td>
                    <td>Authentication.php</td>
                    <td>-</td>
                    <td>Session-based login/redirect security.</td>
                </tr>
                <tr>
                    <td><strong>Data Quality</strong></td>
                    <td>CrossValidation.php</td>
                    <td>MatchingSessionModel</td>
                    <td>Deduplication (Company/Contact/Mobile).</td>
                </tr>
                <tr>
                    <td><strong>Booking</strong></td>
                    <td>Booking.php</td>
                    <td>LeadLocationModel</td>
                    <td>Multi-step stall booking wizard.</td>
                </tr>
                <tr>
                    <td><strong>Ops</strong></td>
                    <td>LayoutInfo.php</td>
                    <td>LayoutInfoModel</td>
                    <td>Floor plans, PDF assets, and Venue details.</td>
                </tr>
            </tbody>
        </table>
    </section>

    <section>
        <h2>2. Dynamic Calculator & Discount Logic</h2>
        <p>This module handles real-time cost calculation for exhibitors based on their physical footprint across various events.</p>
        
        <h3>The "Stall & Size" Logic</h3>
        <ul>
            <li><strong>Step 1:</strong> Select Location via Dropdown (fetches rates from <code>LeadLocationModel</code>).</li>
            <li><strong>Step 2:</strong> Select Size via Dropdown (Standard: 9sqm, 12sqm, 18sqm, etc.).</li>
            <li><strong>Step 3:</strong> <code>Booking::savebookingdetails</code> calculates: 
                <span class="code-block">Total = (Location_Rate * Size_Multiplier)</span>
            </li>
        </ul>

        <div class="op-section">
            <span class="badge badge-logic">CRITICAL LOGIC: Multi-Location Discount</span>
            <p>If the user adds <strong>3 or more locations</strong> to their cart, the system triggers a <strong>Negotiation Rule</strong>: 
            A flat reduction of <strong>5,000</strong> is applied to the final invoice total.</p>
        </div>
    </section>

    <section>
        <h2>3. Operations Team Workflow</h2>
        <p>When the <strong>Branding</strong> flag is active, the system opens the Operations portal. This ensures that the conclusion of a sale transitions smoothly into event execution.</p>
        
        <div class="workflow-box">
            <div class="step">
                <strong>Fascia Name</strong><br>
                <small>Exhibitor input for stall header printing.</small>
            </div>
            <div class="step">
                <strong>Layout Choice</strong><br>
                <small>PDF/Image selection mapped to Event ID.</small>
            </div>
            <div class="step">
                <strong>Quotes & Invoices</strong><br>
                <small>Auto-generated PDF sent to both parties.</small>
            </div>
        </div>

        <h3>Event Metadata Storage</h3>
        <p>The <code>Events</code> and <code>LayoutInfo</code> modules store the "Physical Reality" of the exhibition:</p>
        <ul>
            <li><strong>Venue Details:</strong> Booking dates, Coordinator contacts, and B2B Constraints.</li>
            <li><strong>Marketing Assets:</strong> Image templates and specific Email formats for the Event ID.</li>
            <li><strong>Layout History:</strong> Tracks <em>"Previous Layout"</em> vs <em>"Last Updated"</em> to prevent version conflicts.</li>
        </ul>
    </section>

    <section>
        <h2>4. Database Lifecycle</h2>
        <p>How a record moves through the system:</p>
        <ol>
            <li><strong>Import:</strong> Raw data enters via <code>Backend::index</code>.</li>
            <li><strong>Cleanse:</strong> <code>CrossValidation</code> flags duplicates.</li>
            <li><strong>Lead Generation:</strong> <code>Leads::createLead</code> converts validated data into active prospects.</li>
            <li><strong>Booking:</strong> Exhibitor uses the Public View to select stalls and see the dynamic amount.</li>
            <li><strong>Execution:</strong> Operations uses <code>LayoutInfo</code> to finalize the floor plan and fascia.</li>
        </ol>
        
        
    </section>

    <section style="background: #fff5f5; padding: 20px; border-radius: 10px; border: 1px solid #feb2b2;">
        <h2 style="color: var(--danger); border-color: var(--danger);">5. Maintenance & Database Controls</h2>
        <p>Specific routes in <code>DatabaseOperation.php</code> allow for mass management:</p>
        <ul>
            <li><code>db/clear-matching</code>: Flushes deduplication tables (Safe).</li>
            <li><code>db/clear-non-financial</code>: Removes leads/companies but keeps payment records (Medium Risk).</li>
            <li><code>db/wipe-all</code>: Complete system reset (Extreme Risk).</li>
        </ul>
    </section>

    <footer style="text-align: center; margin-top: 50px; color: #95a5a6; font-size: 0.9em;">
        <hr>
        <p>IITM Company Management System Overview &copy; 2026</p>
    </footer>
</div>

</body>
</html>


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
    </style>
</head>
<body>
    <header>
        <h1>Junior Data Analyst / Tech - KRA & Projects</h1>
    </header>
    <main>

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
</body>
</html>
