<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Enterprise Project Progress Dashboard</title>
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
        margin-bottom: 5px;
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
    .project-description {
        font-size: 14px;
        margin-bottom: 12px;
        opacity: 0.85;
        line-height: 1.5;
    }
    .complete { background: linear-gradient(90deg, #00c853, #64dd17); }
    .mid { background: linear-gradient(90deg, #ffb300, #ff6f00); }
    .low { background: linear-gradient(90deg, #ff5252, #d50000); }
    ul { list-style: none; padding-left: 0; }
    li { margin: 6px 0; font-size: 14px; }
    li.done { color: #00e676; font-weight: bold; }
    li.pending { color: #ffab00; font-weight: bold; }
    li ul { margin-top: 4px; margin-left: 20px; border-left: 2px dashed rgba(255,255,255,0.3); padding-left: 12px; }
    li ul li { font-size: 13px; font-weight: normal; margin: 3px 0; }
    li ul li.done { color: #00e676; font-weight: normal; }
    li ul li.pending { color: #ffab00; font-weight: normal; }
    .footer { text-align: center; margin-top: 40px; font-size: 14px; opacity: 0.8; }
    li ul li:hover { text-decoration: underline; }

 /* Status classes */
    .ok {color:#64dd17;}
    .remains {color:yellow;}
    .working {color:white;}
    


</style>
</head>
<body>

<div class="container">
    <h1>Project Overview Dashboard</h1>

    <!-- QR Badge Management System -->
    <div class="card">
        <div class="project-title">QR Badge Printing System V.1 </div>
        
        <div class="progress-bar">
            <div class="progress complete" style="width:100%;">100%</div>
        </div>
                <div class="project-description">
            A robust solution for attendee registration and on-site badge printing. Supports pre-registrations, dynamic searches, and instant badge issuance for large-scale corporate events.
        </div>
         <table>
            <tr>
                <th class="ok">Start date -> </th> 
                <th class="ok">Planning -> </th> 
                <th class="ok">Development -> </th> 
                <th class="ok">Testing -> </th> 
                <th class="ok">Deployment -> </th> 
                <th class="ok">Tested and Works on Exhibition</th> 
            </tr>
            <tr>
                <td>June</td>
                <td></td>
                <td></td>
                <td></td>
                <td>July</td>
                <td>✅</td>
            </tr>
        </table>



        <ul>
            <li class="done">QR Code Generation Module</li>
            <li class="done">Digital Registration Forms</li>
            <li class="done">Adjustable Text Position </li>
            <li class="done">Search & Filtering Badge Printing Interface</li>
        </ul>
        <div class="stage-info">
    This project was completed within 20-25 days(June to July.) and has been successfully implemented in Chennai, Bangalore, Pune, Hyderabad, and Kochi.
</div>

     <div class="updatehistory">
<table style="text-align:center; border:1px dotted grey; border-collapse: collapse; width:100%;">
                            <tr>
                                <th>Version</th>
                                <th>V.1</th>
                        <th>V.2</th>

                        </tr>
                        <tr>
                            <th>Features</th>
                            <td>Basic</td>
                        <td>Adjustable Font Size
                            <br>
                            An Output Page to see the data
                        </td>
                        </tr>
                        <tr>
                            <th>status</th>
                            <td>   Deployed and Active</td>
                            <td>Pending</td>

                        </tr>

                </table>
        </div>


    </div>

    <!-- Enterprise Central Database -->
    <div class="card">
        <div class="project-title">Central Database</div>
        <div class="progress-bar">
            <div class="progress mid" style="width:75%;">75%</div>
        </div>
        <div class="project-description">
            Centralized repository for company, contact, and lead data with audit logs, historical tracking, and integration with CRM and ERP systems.
        </div>
        
   


<table>
  <tr>
                <th class="ok">Start date -> </th> 
                <th class="ok">Planning -> </th> 
                <th class="working">Development -> </th> 
                <th class="working">Testing -> </th> 
                <th class="remains">Deployment -> </th> 
                <th class="remains">Tested and Works For All Required Operations</th> 
            </tr>
  <tr>
    <td class="ok">January 15</td>
    <td class="ok">1 weeks</td>
    <td class="working">4 weeks (in progress)</td>
    <td class="working">4 weeks (in progress)</td>
    <td class="remains">5-10 March Expected</td>
    <td class="remains">⭕Pending</td>
  </tr>
</table>











        <ul>
            <li class="done">Database Architecture & Core Schema
                <ul>
                    <li>Master Company Records & Metadata</li>
                    <li>Backup & Recovery Tables</li>
                    <li>Enriched Company Profiles with Historical Data</li>
                    <li>Contact Management (Email & Mobile)</li>
                    <li>Event & Booking Metadata</li>
                    <li>Leads & Exhibitor Allocation</li>
                    <li>Financial Records: Payments & Invoices</li>
                    <li>Marketing Templates & Source Tracking</li>
                    <li>User Access & Activity Logs</li>
                </ul>
            </li>
            <li class="done">Data Migration & Standardization
                <ul>
                    <li>Excel / Legacy System Data Transformation</li>
                    <li>Insert Bulk Data</li>
                    <li class="pending">Automactcally Import Online Registration</li>
                    <li class="pending">Data Cleansing & Normalization</li>
                    <li class="pending">Cross-System Validation Logic (In Progress)</li>
                </ul>
            </li>
            <li class="pending">Duplicate & Data Integrity Management
                <ul>
                    <li>Exact & Partial Company/Contact Matching</li>
                    <li>Conflict Resolution for Cross-System Records</li>
                    <li>High-Risk Data Review Procedures</li>
                </ul>
            </li>
            <li class="done">Searching Entries(Company,Contact(name,mobile,eamil),Source)</li>
            <li class="done">Geolocation Filtering (State/City)</li>
            <li class="pending">Enterprise Email & Messaging Integration</li>
        </ul>


        
<div class="stage-info">
    This project was completed within 20-25 days(June to July.) and has been successfully implemented in Chennai, Bangalore, Pune, Hyderabad, and Kochi from 
</div>

    </div>

    <!-- Professional Lead Management -->
    <div class="card">
        <div class="project-title">Lead Management Integration</div>
        <div class="progress-bar">
            <div class="progress mid" style="width:60%;">60%</div>
        </div>
        <div class="project-description">
            End-to-end CRM module for lead tracking, company management, sales pipeline, and inter-team workflow automation.
        </div>




<table>
  <tr>
                <th class="ok">Start date -> </th> 
                <th class="ok">Planning -> </th> 
                <th class="working">Development -> </th> 
                <th class="working">Testing -> </th> 
                <th class="remains">Deployment -> </th> 
                <th class="remains">Tested and Works For All Required Operations</th> 
            </tr>
  <tr>
    <td class="ok">January 15</td>
    <td class="ok">1 weeks</td>
    <td class="working">4 weeks (in progress)</td>
    <td class="working">4 weeks (in progress)</td>
    <td class="remains">2 weeks</td>
    <td class="remains">⭕Pending</td>
  </tr>
</table>
<div class="stage-info">
</div>




        <ul>
            <li class="done">Lead Capture & Qualification</li>
            <li class="done">Company & Contact Management</li>
            <li class="done">Stall Allocation & Pricing Module</li>
            <li class="pending">Payment Gateway Integration</li>
            <li class="pending">Invoice Generation & Communication Automation</li>
            <li class="pending">Collaborative Team Workflow</li>
        </ul>
    </div>


    
<!-- Professional Lead Management -->
<div class="card">
    <div class="project-title">Mass Marketing and Management Integration</div>
    <div class="progress-bar">
        <div class="progress mid" style="width:60%;">60%</div>
    </div>
    <div class="project-description">
        End-to-end CRM module for lead tracking, company management, sales pipeline, and inter-team workflow automation.
    </div>

    <table>
      <tr>
        <th class="remains">Start date -> </th> 
        <th class="remains">Planning -> </th> 
        <th class="remains">Development -> </th> 
        <th class="remains">Testing -> </th> 
        <th class="remains">Deployment -> </th> 
        <th class="remains">Tested and Works For All Required Operations</th> 
      </tr>
      <tr>
        <td class="remains"></td>
        <td class="remains"></td>
        <td class="remains"></td>
        <td class="remains"></td>
        <td class="remains"></td>
        <td class="remains"></td>
        
      </tr>
    </table>
    <div class="stage-info">
    </div>

    <ul>
        <li class="pending">Mail Merge for Bulk Emails</li>
        <li class="pending">WhatsApp Marketing Integration</li>
    </ul>
</div>





    <!-- Corporate Internal Communication -->
    <div class="card">
        <div class="project-title">Internal Collaboration & Communication</div>
        <div class="progress-bar">
            <div class="progress low" style="width:40%;">40%</div>
        </div>
        <div class="project-description">
            Implementation of an internal communication platform to streamline team workflows, task assignments, and operational coordination.
        </div>



         <table>
            <tr>
                <th class="ok">Project Start date -> </th> 
                <th class="ok">Planning -> </th> 
                <th class="ok">Development -> </th> 
                <th class="ok">Testing -> </th> 
                <th class="ok">Deployment -> </th> 
                <th class="ok">Tested and Works on Exhibition</th> 
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                                <td></td>

            </tr>
        </table>
<div class="stage-info">
</div>





        <ul>
    <!-- Pages / Sections -->
    <li class="done">Home / Dashboard</li>
    <li class="done">Employee Book</li>
    <li class="done">Resource & Data Center</li>
    <li class="pending">Dashboard Metrics</li>
    <li class="pending">Event Overview</li>
    <li class="pending">Tools</li>
    <li class="pending">HR Department</li>
    <li class="pending">Creative / Design</li>

    <!-- Features -->
    <li class="done">User Authentication (Login / Logout)</li>
    <li class="pending">Event Management (Upcoming, Completed, Registration)</li>
    <li class="done">Announcements / Communication Board</li>
    <li class="pending">Department-Specific Updates</li>
    <li class="pending">Location & Venue Information</li>
    <li class="pending">Event Status Tracking (Completed / Registration / TBA)</li>
    <li class="pending">Admin Contact / Support</li>

    <!-- Interactive / Communication Features -->
    <li class="pending">Event Registration</li>
    <li class="pending">Employee Acknowledgment / Comment on Announcements</li>
    <li class="pending">Search / Filter Employees, Events, Announcements</li>
    <li class="pending">User Profile Management (Edit Profile)</li>
    <li class="pending">Notifications for Upcoming Events / Announcements</li>
    <li class="pending">RSVP Tracking for Events</li>
    <li class="pending">Downloadable Event Resources / Materials</li>
    <li class="pending">Internal Chat / Discussion Boards</li>
    <li class="pending">Analytics / Engagement Dashboard for HR or Management</li>
</ul>

    </div>

    <!-- Event Operations & Management -->
    <div class="card">
        <div class="project-title">Event Operations Management System</div>
        <div class="progress-bar">
            <div class="progress low" style="width:20%;">20%</div>
        </div>
        <div class="project-description">
            Comprehensive platform to track events, allocate resources, manage vendors, and monitor exhibitor participation for large-scale corporate events.
        </div>


         <table>
            <tr>
                <th class="remains">Project Start date -> </th> 
                <th class="remains">Planning -> </th> 
                <th class="remains">Development -> </th> 
                <th class="remains">Testing -> </th> 
                <th class="remains">Deployment -> </th> 
                <th class="remains">Tested and Works on Exhibition</th> 
            </tr>
            <tr>
                <!-- <td>June</td>
                <td>2 weeks</td>
                <td>5 weeks</td>
                <td>3 weeks</td>
                <td>2 weeks</td>
                <td>2 weeks</td> -->
            </tr>
        </table>
<div class="stage-info">
    <!-- This project was completed within 20-25 days(June to July.) and has been successfully implemented in Chennai, Bangalore, Pune, Hyderabad, and Kochi from  -->
</div>






        <ul>
            <li class="pending">Event Scheduling & Venue Layouts</li>
            <li class="pending">Operational Task Assignment & Accountability</li>
            <li class="pending">Vendor Management & Contract Tracking</li>
            <li class="pending">Resource Allocation & Monitoring</li>
            <li class="pending">Exhibitor Participation Tracking</li>
        </ul>
    </div>

    <!-- Enterprise Analytics & Insights -->
    <div class="card">
        <div class="project-title">Business Analytics & Reporting (Depends On Central Database)</div>
        <div class="progress-bar">
            <div class="progress low" style="width:15%;">15%</div>
        </div>
        <div class="project-description">
            Real-time analytics and reporting platform to provide insights on lead conversion, revenue metrics, exhibitor retention, and sales performance across events.
        </div>



         <table>
            <tr>
                <th class="remains">Project Start date -> </th> 
                <th class="remains">Planning -> </th> 
                <th class="remains">Development -> </th> 
                <th class="remains">Testing -> </th> 
                <th class="remains">Deployment -> </th> 
                <th class="remains">Tested and Works on Exhibition</th> 
            </tr>
            <tr>
                <!-- <td>June</td>
                <td>2 weeks</td>
                <td>5 weeks</td>
                <td>3 weeks</td>
                <td>2 weeks</td>
                <td>2 weeks</td> -->
            </tr>
        </table>
<div class="stage-info">
    <!-- This project was completed within 20-25 days(June to July.) and has been successfully implemented in Chennai, Bangalore, Pune, Hyderabad, and Kochi from  -->
</div>





        <ul>
            <li class="pending">Exhibitor Retention & Engagement Analysis</li>
            <li class="pending">Market Expansion & Growth Metrics</li>
            <li class="pending">Lead Conversion Funnel Dashboard</li>
            <li class="pending">Revenue per Event Tracking</li>
            <li class="pending">Sales Performance KPIs</li>
            <li class="pending">Executive Management Reporting</li>
        </ul>
    </div>

    <div class="footer">
        Enterprise Solutions • CRM Development • Data Migration • Automation • Analytics & Reporting
    </div>
</div>
<script>
function calculateProgress() {
    document.querySelectorAll(".card").forEach(card => {
        const allTasks = card.querySelectorAll(":scope > ul > li");
        const doneTasks = card.querySelectorAll(":scope > ul > li.done");
        const total = allTasks.length;
        const completed = doneTasks.length;
        let percent = total === 0 ? 0 : Math.round((completed / total) * 100);
        const progressBar = card.querySelector(".progress");
        progressBar.style.width = percent + "%";
        progressBar.textContent = percent + "%";
        progressBar.classList.remove("complete", "mid", "low");
        if (percent >= 80) progressBar.classList.add("complete");
        else if (percent >= 40) progressBar.classList.add("mid");
        else progressBar.classList.add("low");
    });
}
document.addEventListener("DOMContentLoaded", calculateProgress);
</script>

</body>
</html>
