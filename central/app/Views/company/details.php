<?= view('company/side') ?>

<style>
    /* ===== Page Layout ===== */


    h2,
    h3 {
        color: #2c3e50;
        margin-top: 20px;
        margin-bottom: 10px;
    }

    /* ===== Flex Container for Company & Contacts ===== */
    .container {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
        /* for smaller screens */
    }

    .box {
        flex: 1 1 45%;
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
    }

    /* ===== Form Inputs ===== */
    input[type="text"],
    input[type="number"],
    input[type="date"],
    input[type="datetime-local"],
    select {
        width: auto;
        padding: 6px 8px;
        margin: 2px 4px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 13px;
        box-sizing: border-box;
    }

    /* Inputs in H2 inline fields */
    h2 input {
        width: auto;
        min-width: 80px;
    }

    /* ===== Buttons ===== */
    button {
        padding: 6px 12px;
        border: none;
        border-radius: 4px;
        font-size: 13px;
        cursor: pointer;
        transition: 0.2s;
    }

    button:hover {
        opacity: 0.9;
    }

    .btn-primary {
        background-color: #28a745;
        color: #fff;
    }

    #openLeadFormBtn {
        background-color: #007bff;
        color: #fff;
        margin-bottom: 10px;
    }

    /* ===== Lists ===== */
    ul {
        padding-left: 20px;
        margin-bottom: 10px;
    }

    /* ===== Lead Cards ===== */
    /* ===== Lead Cards ===== */
    .lead-container {
        display: flex;
        flex-direction: column;
        /* Stack cards vertically */
        gap: 16px;
        /* Space between cards */
    }

    .lead-card {
        width: 100%;
        /* Make card full width of container */
        padding: 16px;
        border: 1px solid #ccc;
        border-radius: 8px;
        background: #f9f9f9;
        box-sizing: border-box;
    }

    /* ===== Modal ===== */
    #leadModal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: none;
        /* hidden by default */
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    .modal-content {
        background: #fff;
        padding: 20px 25px;
        border-radius: 8px;
        width: 400px;
        max-width: 90%;
        position: relative;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    }

    .close-btn {
        position: absolute;
        top: 10px;
        right: 15px;
        font-size: 20px;
        font-weight: bold;
        cursor: pointer;
    }

    /* ===== Updation History ===== */
    #updates div {
        background: #f7f7f7;
        padding: 10px;
        border-radius: 4px;
        margin-bottom: 8px;
    }

    #updates hr {
        margin: 8px 0;
    }

    /* ===== Responsive ===== */
    @media (max-width: 900px) {
        .container {
            flex-direction: column;
        }

        .box {
            width: 100%;
        }
    }


    .company-header {
        background: #fff;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        display: flex;
        flex-direction: column;
        gap: 15px;
        font-family: Arial, sans-serif;
    }

    /* Top row: ID + Label */
    .company-top {
        display: flex;
        align-items: center;
        font-size: 14px;
    }

    /* Company Name big */
    .company-name input.inline-edit {
        font-size: 20px;
        font-weight: 600;
        width: 100%;
        border: none;
        border-bottom: 2px solid #ccc;
        background: transparent;
        padding: 2px 4px;
    }

    .company-name input.inline-edit:focus {
        border-color: #a82324;
        outline: none;
    }

    /* Address / Location row */
    .company-location {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .company-location input.inline-edit {
        border: none;
        border-bottom: 2px solid #ccc;
        background: transparent;
        padding: 2px 6px;
        transition: border-color 0.2s;
    }

    .company-location input.inline-edit:focus {
        border-color: #a82324;
        outline: none;
    }

    /* Contact / GST */
    .company-contact {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 15px;
        font-size: 14px;
    }

    .company-contact input.inline-edit {
        border: none;
        border-bottom: 2px solid #ccc;
        background: transparent;
        padding: 2px 6px;
        transition: border-color 0.2s;
    }

    .company-contact input.inline-edit:focus {
        border-color: #a82324;
        outline: none;
    }
</style>

<?php
$categoryMap = [
    'Travel Agent' => 'TA',
    'Hotel' => 'H',
    'Restaurant' => 'R',
    'Airline' => 'A'
];

$category = esc($company['category']);
$label = $categoryMap[$category] ?? '';
?>
<div class="search-container">
    <style>
        :root {
            --accent-color: #4f46e5;
            /* Modern Indigo */
            --input-bg: #ffffff;
            --text-main: #1e293b;
            --shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .search-container {
            width: 100%;
            max-width: 700px;
            margin: 10px auto;
            padding: 0 15px;
        }

        .modern-search-form {
            display: flex;
            align-items: center;
            background: var(--input-bg);
            padding: 8px;
            border-radius: 50px;
            /* Pill shape */
            box-shadow: var(--shadow);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            border: 1px solid #e2e8f0;
        }

        /* Subtle lift when typing */
        .modern-search-form:focus-within {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            border-color: var(--accent-color);
        }

        .search-icon {
            padding-left: 15px;
            color: #94a3b8;
            display: flex;
            align-items: center;
        }

        .modern-search-form input[type="text"] {
            flex: 1;
            padding: 12px 15px;
            font-size: 16px;
            border: none;
            background: transparent;
            outline: none;
            color: var(--text-main);
            width: 100%;
        }

        .modern-search-form input::placeholder {
            color: #94a3b8;
        }

        .modern-search-form button {
            padding: 12px 28px;
            font-size: 15px;
            font-weight: 600;
            background-color: var(--accent-color);
            color: white;
            border: none;
            border-radius: 40px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.3);
        }

        .modern-search-form button:hover {
            background-color: #4338ca;
            box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.4);
            transform: scale(1.02);
        }

        .modern-search-form button:active {
            transform: scale(0.98);
        }

        /* Responsive tweak */
        @media (max-width: 480px) {
            .modern-search-form button {
                padding: 10px 15px;
                font-size: 14px;
            }
        }
    </style>

    <form action="<?= base_url('search') ?>" method="get" class="modern-search-form">
        <div class="search-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
        </div>

        <input type="text" name="q" value="<?= esc($search ?? '') ?>" placeholder="Search company, contact, mobile..."
            required>

        <button type="submit">Search</button>
    </form>

</div>
<div class="container">

    <!-- ================= COMPANY DETAILS ================= -->

    <div class="box left">

        <div class="navigation-wrapper" style="display: flex; align-items: center; gap: 15px;">
            <?php if ($prev_id): ?>
                <a href="<?= base_url("company/details/$type/$prev_id") ?>" class="nav-btn">← Previous</a>
            <?php else: ?>
                <button class="nav-btn" disabled>At Start</button>
            <?php endif; ?>

            <div style="font-weight: 600; color: var(--text-main); font-size: 0.9rem;">
                <?= esc($company['company_name']) ?>
            </div>

            <?php if ($next_id): ?>
                <a href="<?= base_url("company/details/$type/$next_id") ?>" class="nav-btn">Next →</a>
            <?php else: ?>
                <button class="nav-btn" disabled>At End</button>
            <?php endif; ?>
        </div>
        <div class="company-card">

            <div class="company-header">
                <div class="company-top">
                    <h1> <?= esc($company['company_id']) ?> |
                        <h1> <?= esc($company['entry_type']) ?> |

                            <?= esc($company['category'] ?? 'No Category') ?> |
                            <strong><?= esc($company['company_name']) ?></strong> |
                            <?= esc($company['city']) ?>
                        </h1>
                </div>


                <div class="company-contact">
                    <p>
                        Phone: <?= esc($company['phone']) ?> |
                        GST: <?= esc($company['gst_number']) ?> |
                        Database: <?= esc($company['database_name']) ?> |
                        Outbound: <?= $company['outbound'] ? 'Yes' : 'No' ?> |
                        Cross Validation: <?= $company['cross_validation'] ? 'Yes' : 'No' ?>
                    </p>
                </div>

                <div class="company-updates">
                    <p>
                        Last Comments: <?= esc($company['last_comments']) ?> |
                        Updated By: <?= esc($company['updated_by']) ?> |
                        Updated At: <?= esc($company['updated_at']) ?>
                    </p>
                </div>
            </div>
            <hr>

            <h3>Sources</h3>
            <table style="width:100%; text-align:left; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th>Source ID</th>
                        <th>Event Date</th>
                        <th>Source Name</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($sources as $source): ?>
                        <tr>
                            <td><?= esc($source['source_id']) ?></td>
                            <td><?= esc($source['event_date']) ?></td>
                            <td><?= esc($source['notes']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <!-- Button to open comparison window -->
            <button type="button" onclick="openComparison()">Compare Changes</button>

            <!-- Hidden Comparison Overlay -->
            <div id="comparisonOverlay" style="
    display:none;
    position:fixed;
    top:0; left:0;
    width:100%; height:100%;
    background:rgba(0,0,0,0.7);
    z-index:9999;
    overflow:auto;
    padding:50px 20px;
">
                <div style="
        background:#fff; 
        max-width:1000px; 
        margin:0 auto; 
        padding:20px; 
        border-radius:10px;
        display:flex;
        gap:20px;
    ">
                    <!-- Original Values -->
                    <div style="flex:1; border-right:1px solid #ccc; padding-right:20px;">
                        <h3>Original</h3>
                        <p><strong>Category:</strong> <?= esc($label ?? '-') ?></p>
                        <p><strong>Company:</strong> <?= esc($company['company_name']) ?></p>
                        <p><strong>City:</strong> <?= esc($company['city']) ?></p>
                        <p><strong>Address:</strong> <?= esc($company['address']) ?></p>
                        <p><strong>Pincode:</strong> <?= esc($company['pincode']) ?></p>
                        <p><strong>State:</strong> <?= esc($company['state']) ?></p>
                        <p><strong>Phone:</strong> <?= esc($company['phone']) ?></p>
                        <p><strong>GST:</strong> <?= esc($company['gst_number']) ?></p>

                        <h4>Sources</h4>
                        <ul>
                            <?php foreach ($sources as $source): ?>
                                <li>
                                    <strong>ID:</strong> <?= esc($source['source_id']) ?> |
                                    <strong>Date:</strong> <?= esc($source['event_date']) ?> |
                                    <strong>Notes:</strong> <?= esc($source['notes']) ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <!-- Editable Inputs -->
                    <div style="flex:1; padding-left:20px;">
                        <h3>Editable</h3>
                        <div class="company-header-hidden">
                            <input type="text" name="label" value="<?= esc($label ?? '') ?>" placeholder="Category"><br>
                            <input type="text" name="company_name" value="<?= esc($company['company_name']) ?>"
                                placeholder="Company Name"><br>
                            <input type="text" name="city" value="<?= esc($company['city']) ?>" placeholder="City"><br>

                            <input type="text" name="address" value="<?= esc($company['address']) ?>"
                                placeholder="Address"><br>
                            <input type="text" name="pincode" value="<?= esc($company['pincode']) ?>"
                                placeholder="Pincode"><br>
                            <input type="text" name="state" value="<?= esc($company['state']) ?>"
                                placeholder="State"><br>
                            <input type="text" name="phone" value="<?= esc($company['phone']) ?>"
                                placeholder="Phone"><br>
                            <input type="text" name="gst_number" value="<?= esc($company['gst_number']) ?>"
                                placeholder="GST Number"><br>
                        </div>

                        <h4>Sources</h4>
                        <ul class="sources-list" style="list-style:none; padding:0;">
                            <?php foreach ($sources as $i => $source): ?>
                                <li style="margin-bottom:10px;">
                                    <input type="hidden" name="sources[<?= $i ?>][id]" value="<?= $source['id'] ?>">
                                    <input type="number" name="sources[<?= $i ?>][source_id]"
                                        value="<?= esc($source['source_id']) ?>" placeholder="Source ID">
                                    <input type="date" name="sources[<?= $i ?>][event_date]"
                                        value="<?= esc($source['event_date']) ?>">
                                    <input type="text" name="sources[<?= $i ?>][notes]" value="<?= esc($source['notes']) ?>"
                                        placeholder="Notes">
                                </li>
                            <?php endforeach; ?>
                        </ul>

                        <div class="save-section">
                            <button type="submit">Save Changes</button>
                            <button type="button" onclick="closeComparison()">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                function openComparison() {
                    document.getElementById('comparisonOverlay').style.display = 'block';
                }

                function closeComparison() {
                    document.getElementById('comparisonOverlay').style.display = 'none';
                }
            </script>

        </div>

    </div>

    <div class="box right">
        <!-- ================= CONTACT DETAILS ================= -->
        <h3></h3>
        <br><br>


        <?php if (!empty($contacts)): ?>
            <table border="1" cellpadding="8" cellspacing="0"
                style="border-collapse: collapse; width:100%; font-size:14px;">
                <thead style="background:#f5f5f5;">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Designation</th>
                        <th>Mobile(s)</th>
                        <th>Email(s)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($contacts as $contact): ?>
                        <tr>
                            <td><?= esc($contact['contact_id']) ?></td>
                            <td><?= esc($contact['name']) ?></td>
                            <td><?= esc($contact['designation']) ?></td>
                            <td>
                                <?= !empty($contact['mobiles']) ? esc(implode(', ', $contact['mobiles'])) : 'N/A' ?>
                            </td>
                            <td>
                                <?= !empty($contact['emails']) ? esc(implode(', ', $contact['emails'])) : 'N/A' ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No contacts found.</p>
        <?php endif; ?>



        <!-- Button to open contact comparison -->
        <button type="button" onclick="openContactComparison()">Compare Contacts</button>

        <!-- Hidden Contact Comparison Overlay -->
        <div id="contactOverlay" style="
    display:none;
    position:fixed;
    top:0; left:0;
    width:100%; height:100%;
    background:rgba(0,0,0,0.7);
    z-index:9999;
    overflow:auto;
    padding:50px 20px;
">
            <div style="
        background:#fff; 
        max-width:900px; 
        margin:0 auto; 
        padding:20px; 
        border-radius:10px;
        display:flex;
        gap:20px;
    ">
                <!-- Original Contacts -->
                <div style="flex:1; border-right:1px solid #ccc; padding-right:20px;">
                    <h3>Original Contacts</h3>
                    <?php if (!empty($contacts)): ?>
                        <?php foreach ($contacts as $contact): ?>
                            <p>
                                <strong>ID:</strong> <?= $contact['contact_id'] ?><br>
                                <strong>Name:</strong> <?= $contact['name'] ?><br>
                                <strong>Designation:</strong> <?= $contact['designation'] ?><br>
                                <strong>Mobiles:</strong>
                                <?= !empty($contact['mobiles']) ? implode(', ', $contact['mobiles']) : 'N/A' ?><br>
                                <strong>Emails:</strong>
                                <?= !empty($contact['emails']) ? implode(', ', $contact['emails']) : 'N/A' ?>
                            </p>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No contacts found.</p>
                    <?php endif; ?>
                </div>

                <!-- Editable Contacts -->
                <div style="flex:1; padding-left:20px;">
                    <h3>Editable Contacts</h3>
                    <?php if (!empty($contacts)): ?>
                        <?php foreach ($contacts as $i => $contact): ?>
                            <div style="margin-bottom:15px; border-bottom:1px solid #ddd; padding-bottom:10px;">
                                <input type="hidden" name="contacts[<?= $i ?>][contact_id]"
                                    value="<?= $contact['contact_id'] ?>">

                                <label>Name:</label>
                                <input type="text" name="contacts[<?= $i ?>][name]" value="<?= $contact['name'] ?>"
                                    placeholder="Name">

                                <label>Designation:</label>
                                <input type="text" name="contacts[<?= $i ?>][designation]"
                                    value="<?= $contact['designation'] ?>" placeholder="Designation">

                                <label>Mobiles:</label>
                                <input type="text" name="contacts[<?= $i ?>][mobile]"
                                    value="<?= !empty($contact['mobiles']) ? implode(', ', $contact['mobiles']) : '' ?>"
                                    placeholder="Mobiles">

                                <label>Emails:</label>
                                <input type="text" name="contacts[<?= $i ?>][email]"
                                    value="<?= !empty($contact['emails']) ? implode(', ', $contact['emails']) : '' ?>"
                                    placeholder="Emails">
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No contacts to edit.</p>
                    <?php endif; ?>

                    <div class="save-section" style="margin-top:10px;">
                        <button type="submit">Save Changes</button>
                        <button type="button" onclick="closeContactComparison()">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function openContactComparison() {
                document.getElementById('contactOverlay').style.display = 'block';
            }

            function closeContactComparison() {
                document.getElementById('contactOverlay').style.display = 'none';
            }
        </script>






    </div>
</div>




<!-- ================= UPDATION DETAILS ================= -->
<h3>Updation History</h3>

<?php if (!empty($updates)): ?>
    <?php foreach ($updates as $u): ?>
        <div>
            <strong><?= esc($u['updated_by']) ?></strong><br>
            <?= esc($u['comment']) ?><br>
            <small><?= esc($u['created_at']) ?></small>
        </div>
        <hr>
    <?php endforeach; ?>
<?php else: ?>
    <p>No updates available.</p>
<?php endif; ?>

<hr>

<!-- ================= LEAD DETAILS ================= -->
<!-- ================= LEAD DETAILS ================= -->
<h3>Leads</h3>
<button id="openLeadFormBtn">Add Lead</button>

<a href="<?= base_url('lead/createQuick/' . $company['company_id']) ?>">
    Add Quick Lead
</a>

<style>
    .lead-card {
        border: 1px solid #ddd;
        padding: 15px;
        margin: 10px 0;
        border-radius: 6px;
        background: #f9f9f9;
    }

    /* Flex container for the two sections */
    .lead-row {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
        /* stack on smaller screens */
    }

    /* Each section takes ~50% width */
    .location-section {
        flex: 1;
        min-width: 50xpx;
    }

    .lead-section {
        flex: 1;
        max-width: 20%;
    }

    .location-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    .location-table th,
    .location-table td {
        border: 1px solid #ccc;
        padding: 8px 12px;
        text-align: left;
    }

    .location-table th {
        background-color: #f0f0f0;
    }

    .location-table tr:nth-child(even) {
        background-color: #fafafa;
    }

    .location-section h4 {
        margin-bottom: 10px;
    }

    /* Horizontal rows inside location card */
    .location-row,
    .price-row,
    .timestamp-row {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
    }

    .timestamp-row {
        justify-content: space-between;
        font-size: 0.85em;
        color: #555;
    }
</style>

<?php if (!empty($leads)): ?>
    <div class="lead-container">
        <?php foreach ($leads as $l): ?>
            <div class="lead-card">

                <div class="lead-row">

                    <!-- Section 1: Lead Details -->
                    <div class="lead-section">
                        <div><strong>Lead ID:</strong> <?= esc($l['lead_id'] ?? '') ?></div>
                        <div><strong>Company ID:</strong> <?= esc($l['company_id'] ?? '') ?></div>
                        <div><strong>Status:</strong> <?= esc($l['status'] ?? '') ?></div>
                        <div><strong>Payment Status:</strong> <?= esc($l['payment_status'] ?? '') ?></div>
                        <div><strong>Source:</strong> <?= esc($l['source'] ?? '') ?></div>
                        <div><strong>Budget:</strong> <?= esc($l['budget'] ?? '') ?></div>
                        <div><strong>Requirement:</strong> <?= esc($l['requirement'] ?? '') ?></div>

                        <a href="<?= site_url('booking/company/' . $l['lead_id']) ?>" class="btn-next">Proceed to Step 2 </a>

                    </div>

                    <!-- Section 2: Location Details -->
                    <div class="location-section">
                        <?php if (!empty($l['locations'])): ?>
                            <strong>Contact Name:</strong> <?= esc($l['contact_name'] ?? '') ?>, <strong>Designation:</strong>
                            <?= esc($l['designation'] ?? '') ?>, <strong>Email:</strong> <?= esc($l['primary_email'] ?? '') ?>,
                            <strong>Mobile:</strong> <?= esc($l['primary_mobile'] ?? '') ?>

                            <table class="location-table">
                                <thead>
                                    <tr>
                                        <th>Location</th>
                                        <th>Stall</th>
                                        <th>Size</th>
                                        <th>Price (₹)</th>
                                        <th>GST (₹)</th>
                                        <th>Discount (₹)</th>
                                        <th>Grand Total (₹)</th>
                                        <th>Created At</th>
                                        <th>Updated At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($l['locations'] as $loc): ?>
                                        <tr>
                                            <td><?= esc($loc['location']) ?></td>
                                            <td><?= esc($loc['stall_location']) ?></td>
                                            <td><?= esc($loc['size']) ?></td>
                                            <td><?= esc($loc['amount'] ?? 0) ?></td>
                                            <td><?= esc($loc['gst'] ?? 0) ?></td>
                                            <td><?= esc($loc['discount_amount'] ?? 0) ?></td>
                                            <td><?= esc($loc['grand_total'] ?? 0) ?></td>
                                            <td><?= esc($loc['created_at']) ?></td>
                                            <td><?= esc($loc['updated_at']) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <p>No locations added for this lead.</p>
                        <?php endif; ?>
                    </div>

                </div> <!-- lead-row -->

            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>


<!-- ================= ADD LEAD MODAL ================= -->

<!-- Modal Overlay -->
<div id="leadModal" class="modal-overlay">
    <div class="modal-content">
        <span id="closeLeadFormBtn" class="close-btn">&times;</span>
        <h3>Add New Lead</h3>

        <form action="<?= site_url('leads/create') ?>" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="company_id" value="<?= esc($company['company_id']) ?>">

            <div class="form-group">
                <label for="exhibition_year">Exhibition Year</label>
                <input type="number" name="exhibition_year" id="exhibition_year" required>
            </div>

            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" name="location" id="location" maxlength="100" required>
            </div>

            <div class="form-group">
                <label for="size">Size</label>
                <input type="text" name="size" id="size" maxlength="50">
            </div>

            <div class="form-group">
                <label for="fascia">Fascia</label>
                <input type="text" name="fascia" id="fascia" maxlength="100">
            </div>

            <div class="form-group">
                <label for="stall_location">Stall Location</label>
                <input type="text" name="stall_location" id="stall_location" maxlength="100">
            </div>

            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" step="0.01" name="price" id="price">
            </div>

            <div class="form-group">
                <label for="sales_person">Sales Person</label>
                <input type="text" name="sales_person" id="sales_person" maxlength="100">
            </div>

            <div class="form-group">
                <label for="exhibitor">Exhibitor</label>
                <input type="text" name="exhibitor" id="exhibitor" maxlength="255">
            </div>

            <div class="form-group">
                <label for="booking_form">Booking Form</label>
                <input type="text" name="booking_form" id="booking_form" maxlength="255">
            </div>


            <label>Select Contact</label>
            <select id="contact_select" class="form-control">
                <option value="">-- Select Contact --</option>
                <?php foreach ($contacts as $contact): ?>
                    <option value="<?= esc($contact['contact_id']) ?>" data-name="<?= esc($contact['name']) ?>">
                        <?= esc($contact['name']) ?> (<?= esc($contact['designation']) ?>)
                    </option>
                <?php endforeach; ?>
            </select>

            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" id="status">
                    <option value="draft" selected>Draft</option>
                    <option value="confirmed">Confirmed</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>

            <div class="form-group">
                <label for="payment_status">Payment Status</label>
                <select name="payment_status" id="payment_status">
                    <option value="pending" selected>Pending</option>
                    <option value="paid">Paid</option>
                    <option value="refunded">Refunded</option>
                </select>
            </div>

            <div style="margin-top:15px; text-align:right;">
                <button type="submit" class="btn-submit">Create Lead</button>
            </div>
        </form>
    </div>
</div>
<script>
    // Open modal
    document.getElementById('openLeadFormBtn').addEventListener('click', function () {
        document.getElementById('leadModal').style.display = 'flex';
    });

    // Close modal
    document.getElementById('closeLeadFormBtn').addEventListener('click', function () {
        document.getElementById('leadModal').style.display = 'none';
    });

    // Close modal if clicked outside content
    window.addEventListener('click', function (e) {
        const modal = document.getElementById('leadModal');
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    });
</script>


<div class="box" style="flex: 1 1 100%; margin-top: 20px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
        <h3>Company Master Database</h3>
        <button type="button" class="btn-primary" onclick="crmSheet.copyAll()">📋 Copy Master Row for Excel</button>
    </div>
    <div id="crmSpreadsheet"></div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // 1. Columns precisely mapped to your requested headers
        const columns = [
            { title: 'database_name' }, { title: 'category' }, { title: 'source' },
            { title: 'updated_by' }, { title: 'updated_at' }, { title: 'outbound' },
            { title: 'company_name' }, { title: 'address_1' }, { title: 'address_2' },
            { title: 'city' }, { title: 'pincode' }, { title: 'state' },
            { title: 'phone' }, { title: 'fax' },
            // Contact 1
            { title: 'contact_name' }, { title: 'designation' },
            { title: 'mobile_1' }, { title: 'mobile_2' }, { title: 'mobile_3' },
            { title: 'email_1' }, { title: 'email_2' }, { title: 'email_3' },
            // Contact 2
            { title: 'contact_name_2' }, { title: 'designation_2' },
            { title: 'email_4' }, { title: 'email_5' },
            { title: 'mobile_4' }, { title: 'mobile_5' },
            // Contact 3
            { title: 'contact_name_3' }, { title: 'designation_3' },
            { title: 'email_6' }, { title: 'email_7' },
            { title: 'mobile_6' }, { title: 'mobile_7' }
        ];

        // 2. Data Logic to distribute contacts into slots
        const data = [
            <?php
            // Extract history/source metadata
            $lastUpd = !empty($updates) ? $updates[0] : [];
            $srcNote = !empty($sources) ? end($sources)['notes'] : '';

            // Map Contacts to fixed slots to maintain column alignment
            $c1 = $contacts[0] ?? null;
            $c2 = $contacts[1] ?? null;
            $c3 = $contacts[2] ?? null;

            // Helper to get specific index from contact arrays
            $getArr = function ($arr, $idx) {
                return esc($arr[$idx] ?? '');
            };
            ?>
            [
            '<?= esc($database_name ?? 'Main DB') ?>',
            '<?= esc($company['category'] ?? '') ?>',
            '<?= esc($srcNote) ?>',
            '<?= esc($lastUpd['updated_by'] ?? '') ?>',
            '<?= esc($lastUpd['created_at'] ?? '') ?>',
            '<?= esc($outbound_status ?? 'Pending') ?>',
            '<?= esc($company['company_name']) ?>',
            '<?= esc($company['address']) ?>', // split if you have address_2
            '', // address_2
            '<?= esc($company['city']) ?>',
            '<?= esc($company['pincode']) ?>',
            '<?= esc($company['state']) ?>',
            '<?= esc($company['phone']) ?>',
            '<?= esc($company['fax'] ?? '') ?>',

            // Contact 1 Slot
            '<?= esc($c1['name'] ?? '') ?>',
            '<?= esc($c1['designation'] ?? '') ?>',
            '<?= $getArr($c1['mobiles'] ?? [], 0) ?>',
            '<?= $getArr($c1['mobiles'] ?? [], 1) ?>',
            '<?= $getArr($c1['mobiles'] ?? [], 2) ?>',
            '<?= $getArr($c1['emails'] ?? [], 0) ?>',
            '<?= $getArr($c1['emails'] ?? [], 1) ?>',
            '<?= $getArr($c1['emails'] ?? [], 2) ?>',

            // Contact 2 Slot
            '<?= esc($c2['name'] ?? '') ?>',
            '<?= esc($c2['designation'] ?? '') ?>',
            '<?= $getArr($c2['emails'] ?? [], 0) ?>',
            '<?= $getArr($c2['emails'] ?? [], 1) ?>',
            '<?= $getArr($c2['mobiles'] ?? [], 0) ?>',
            '<?= $getArr($c2['mobiles'] ?? [], 1) ?>',

            // Contact 3 Slot
            '<?= esc($c3['name'] ?? '') ?>',
            '<?= esc($c3['designation'] ?? '') ?>',
            '<?= $getArr($c3['emails'] ?? [], 0) ?>',
            '<?= $getArr($c3['emails'] ?? [], 1) ?>',
            '<?= $getArr($c3['mobiles'] ?? [], 0) ?>',
            '<?= $getArr($c3['mobiles'] ?? [], 1) ?>'
            ]
        ];

        3. Initialize Spreadsheet
        window.crmSheet = new Spreadsheet('crmSpreadsheet', {
            data: data,
            columns: columns
        });
    });
</script>