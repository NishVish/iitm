<style>
    /* Scope resets and typography */
    .dashboard-container * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
    }

    .dashboard-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 24px;
        background-color: #f8fafc;
        min-height: 100vh;
        color: #334155;
    }

    /* Top Action Bar */
    .top-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .breadcrumbs {
        font-size: 13px;
        color: #64748b;
    }

    .breadcrumbs .separator {
        color: #cbd5e1;
        margin: 0 4px;
    }

    .breadcrumbs .active {
        color: #0f172a;
        font-weight: 600;
    }

    .btn-dashboard {
        display: inline-block;
        background-color: #0f172a;
        color: #ffffff;
        padding: 8px 16px;
        border-radius: 6px;
        text-decoration: none;
        font-size: 12px;
        font-weight: 600;
        transition: background-color 0.2s ease;
    }

    .btn-dashboard:hover {
        background-color: #1e293b;
    }

    /* Cards Base Structure */
    .card {
        background-color: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    /* Header Status Card */
    .header-card {
        padding: 20px 24px;
        margin-bottom: 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-left: 5px solid #4f46e5;
    }

    .booking-ref-tag {
        display: inline-block;
        font-size: 11px;
        font-weight: 700;
        color: #4f46e5;
        background-color: #eef2ff;
        padding: 3px 8px;
        border-radius: 4px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .booking-id-text {
        font-size: 20px;
        font-weight: 700;
        color: #0f172a;
        font-family: monospace;
        margin-left: 8px;
    }

    .header-subtitle {
        font-size: 13px;
        color: #64748b;
        margin-top: 4px;
    }

    .badge {
        font-size: 11px;
        font-weight: 600;
        padding: 4px 12px;
        border-radius: 20px;
    }

    .badge-editable {
        background-color: #ecfdf5;
        color: #047857;
        border: 1px solid #a7f3d0;
    }

    .badge-readonly {
        background-color: #f1f5f9;
        color: #475569;
        border: 1px solid #cbd5e1;
    }

    /* Grid Layout */
    .grid-layout {
        display: grid;
        grid-template-columns: 1fr;
        gap: 24px;
    }

    @media (min-width: 992px) {
        .grid-layout {
            grid-template-columns: 320px 1fr;
        }
    }

    .left-column {
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    /* Company Profile Card */
    .company-card {
        overflow: hidden;
    }

    .company-card-header {
        background: linear-gradient(135deg, #0f172a, #1e293b);
        color: #ffffff;
        padding: 16px 20px;
    }

    .company-card-header h3 {
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #94a3b8;
    }

    .company-name {
        font-size: 16px;
        font-weight: 700;
        margin-top: 4px;
    }

    .company-card-body {
        padding: 20px;
        font-size: 12px;
    }

    .info-group {
        padding-top: 12px;
        border-top: 1px solid #f1f5f9;
    }

    .info-group:first-child {
        padding-top: 0;
        border-top: none;
    }

    .label {
        display: block;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #94a3b8;
        margin-bottom: 4px;
    }

    .value-box {
        display: inline-block;
        font-weight: 600;
        color: #334155;
        background-color: #f1f5f9;
        padding: 4px 8px;
        border-radius: 4px;
    }

    .mono-box {
        display: inline-block;
        font-family: monospace;
        color: #1e293b;
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        padding: 2px 6px;
        border-radius: 4px;
    }

    .address-text {
        color: #475569;
        line-height: 1.5;
    }

    /* Contact Card */
    .contact-card {
        padding: 20px;
    }

    .contact-card h2 {
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #94a3b8;
        margin-bottom: 16px;
    }

    .contact-wrapper {
        display: flex;
        gap: 12px;
    }

    .avatar {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        background-color: #eef2ff;
        color: #4f46e5;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 16px;
        flex-shrink: 0;
    }

    .contact-details {
        font-size: 12px;
        flex-grow: 1;
    }

    .contact-name {
        font-size: 14px;
        font-weight: 700;
        color: #0f172a;
    }

    .contact-title {
        color: #64748b;
        margin-bottom: 12px;
    }

    .contact-link {
        color: #4f46e5;
        text-decoration: none;
        font-weight: 500;
    }

    .contact-link:hover {
        text-decoration: underline;
    }
</style>

<div class="dashboard-container">

    <!-- Top Navigation / Action Bar -->
    <div class="top-bar">
        <div class="breadcrumbs">
            <span>Dashboard</span>
            <span class="separator">/</span>
            <span>Bookings</span>
            <span class="separator">/</span>
            <span class="active">{{ $final_bookingdetails->booking->booking_id }}</span>
        </div>

        <a href="{{ url('exhibitor/closebooking/' . $final_bookingdetails->booking->booking_id) }}"
            class="btn-dashboard">
            Move to Dashboard
        </a>
    </div>



    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Exhibitor Dashboard</title>

        <style>
            * {
                box-sizing: border-box;
                margin: 0;
                padding: 0;
            }

            body {
                font-family: Arial, Helvetica, sans-serif;
                background: #f5f7fb;
                color: #1f2937;
                line-height: 1.5;
            }

            .dashboard {
                max-width: 1400px;
                margin: 0 auto;
                padding: 30px;
            }

            /* Header */
            .dashboard-header {
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
                gap: 20px;
                margin-bottom: 25px;
            }

            .dashboard-header h1 {
                font-size: 28px;
                color: #111827;
                margin-bottom: 5px;
            }

            .dashboard-header p {
                color: #6b7280;
                font-size: 14px;
            }

            .header-actions {
                display: flex;
                gap: 10px;
            }

            .btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                padding: 10px 16px;
                border-radius: 8px;
                border: 1px solid #d1d5db;
                background: #fff;
                color: #374151;
                text-decoration: none;
                font-size: 14px;
                font-weight: 600;
                cursor: pointer;
            }

            .btn-primary {
                background: #2563eb;
                color: #fff;
                border-color: #2563eb;
            }

            .btn-danger {
                background: #fff;
                color: #dc2626;
                border-color: #fecaca;
            }

            /* Booking status */
            .booking-bar {
                background: #fff;
                border: 1px solid #e5e7eb;
                border-radius: 12px;
                padding: 18px 20px;
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 20px;
                gap: 20px;
            }

            .booking-info {
                display: flex;
                gap: 35px;
                flex-wrap: wrap;
            }

            .booking-item small {
                display: block;
                color: #6b7280;
                font-size: 12px;
                margin-bottom: 3px;
            }

            .booking-item strong {
                font-size: 15px;
                color: #111827;
            }

            .status {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                padding: 6px 11px;
                border-radius: 20px;
                font-size: 12px;
                font-weight: 700;
            }

            .status-success {
                background: #dcfce7;
                color: #166534;
            }

            .status-warning {
                background: #fef3c7;
                color: #92400e;
            }

            .status-danger {
                background: #fee2e2;
                color: #991b1b;
            }

            .status-info {
                background: #dbeafe;
                color: #1d4ed8;
            }

            /* Stats */
            .stats-grid {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 18px;
                margin-bottom: 20px;
            }

            .stat-card {
                background: #fff;
                border: 1px solid #e5e7eb;
                border-radius: 12px;
                padding: 20px;
            }

            .stat-card .icon {
                width: 42px;
                height: 42px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 10px;
                background: #eff6ff;
                color: #2563eb;
                margin-bottom: 14px;
                font-size: 18px;
            }

            .stat-card small {
                display: block;
                color: #6b7280;
                font-size: 13px;
                margin-bottom: 5px;
            }

            .stat-card strong {
                display: block;
                font-size: 25px;
                color: #111827;
            }

            /* Action Required */
            .action-card {
                background: #fff;
                border: 1px solid #fecaca;
                border-left: 5px solid #dc2626;
                border-radius: 12px;
                padding: 20px;
                display: flex;
                justify-content: space-between;
                align-items: center;
                gap: 20px;
                margin-bottom: 25px;
            }

            .action-card h3 {
                font-size: 16px;
                color: #991b1b;
                margin-bottom: 5px;
            }

            .action-card p {
                font-size: 14px;
                color: #6b7280;
            }

            /* Grid */
            .content-grid {
                display: grid;
                grid-template-columns: 2fr 1fr;
                gap: 20px;
                margin-bottom: 20px;
            }

            .card {
                background: #fff;
                border: 1px solid #e5e7eb;
                border-radius: 12px;
                overflow: hidden;
            }

            .card-header {
                padding: 18px 20px;
                border-bottom: 1px solid #e5e7eb;
                display: flex;
                justify-content: space-between;
                align-items: center;
                gap: 15px;
            }

            .card-header h2 {
                font-size: 17px;
                color: #111827;
            }

            .card-header a {
                color: #2563eb;
                font-size: 13px;
                text-decoration: none;
                font-weight: 600;
            }

            .card-body {
                padding: 20px;
            }

            /* Events */
            .event-card {
                border: 1px solid #e5e7eb;
                border-radius: 10px;
                padding: 18px;
                margin-bottom: 14px;
            }

            .event-card:last-child {
                margin-bottom: 0;
            }

            .event-top {
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
                gap: 15px;
            }

            .event-name {
                font-size: 16px;
                font-weight: 700;
                color: #111827;
                margin-bottom: 5px;
            }

            .event-location,
            .event-date {
                font-size: 13px;
                color: #6b7280;
                margin-bottom: 3px;
            }

            .event-stall {
                margin-top: 15px;
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 10px;
                padding-top: 15px;
                border-top: 1px solid #f0f0f0;
            }

            .stall-info small {
                display: block;
                color: #9ca3af;
                font-size: 11px;
                margin-bottom: 3px;
            }

            .stall-info strong {
                font-size: 13px;
                color: #374151;
            }

            .event-footer {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-top: 15px;
                padding-top: 15px;
                border-top: 1px solid #f0f0f0;
            }

            .event-price {
                font-size: 18px;
                font-weight: 700;
                color: #111827;
            }

            /* Payment */
            .payment-total {
                text-align: center;
                padding: 10px 0 20px;
            }

            .payment-total small {
                display: block;
                color: #6b7280;
                margin-bottom: 5px;
            }

            .payment-total strong {
                font-size: 30px;
                color: #111827;
            }

            .progress {
                height: 9px;
                background: #e5e7eb;
                border-radius: 20px;
                overflow: hidden;
                margin: 10px 0 20px;
            }

            .progress-bar {
                height: 100%;
                width: 63%;
                background: #16a34a;
                border-radius: 20px;
            }

            .payment-row {
                display: flex;
                justify-content: space-between;
                padding: 11px 0;
                border-bottom: 1px solid #f3f4f6;
                font-size: 14px;
            }

            .payment-row:last-child {
                border-bottom: 0;
            }

            .payment-row span:first-child {
                color: #6b7280;
            }

            .payment-row strong {
                color: #111827;
            }

            /* Deadlines */
            .deadline {
                display: flex;
                justify-content: space-between;
                align-items: center;
                gap: 15px;
                padding: 14px 0;
                border-bottom: 1px solid #f3f4f6;
            }

            .deadline:last-child {
                border-bottom: 0;
            }

            .deadline-date {
                font-size: 13px;
                font-weight: 700;
                color: #111827;
            }

            .deadline-title {
                font-size: 13px;
                color: #6b7280;
            }

            .deadline-days {
                font-size: 12px;
                font-weight: 700;
                white-space: nowrap;
            }

            .deadline-danger {
                color: #dc2626;
            }

            .deadline-warning {
                color: #d97706;
            }

            .deadline-success {
                color: #16a34a;
            }

            /* Company */
            .company-profile {
                display: flex;
                gap: 15px;
                align-items: flex-start;
            }

            .company-logo {
                width: 52px;
                height: 52px;
                border-radius: 10px;
                background: #eff6ff;
                display: flex;
                align-items: center;
                justify-content: center;
                color: #2563eb;
                font-size: 20px;
                font-weight: 700;
            }

            .company-profile h3 {
                font-size: 16px;
                margin-bottom: 4px;
            }

            .company-profile p {
                font-size: 13px;
                color: #6b7280;
                margin-bottom: 3px;
            }

            /* Contact */
            .contact-box {
                padding: 5px 0;
            }

            .contact-name {
                font-size: 16px;
                font-weight: 700;
                color: #111827;
            }

            .contact-role {
                color: #6b7280;
                font-size: 13px;
                margin-bottom: 12px;
            }

            .contact-detail {
                font-size: 13px;
                margin-bottom: 6px;
                color: #374151;
            }

            /* Documents */
            .document-row {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 13px 0;
                border-bottom: 1px solid #f3f4f6;
            }

            .document-row:last-child {
                border-bottom: 0;
            }

            .document-name {
                font-size: 13px;
                color: #374151;
            }

            .document-action {
                font-size: 12px;
                color: #2563eb;
                font-weight: 600;
                text-decoration: none;
            }

            /* Support */
            .support-grid {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 15px;
            }

            .support-item {
                border: 1px solid #e5e7eb;
                border-radius: 10px;
                padding: 18px;
            }

            .support-item h3 {
                font-size: 14px;
                margin-bottom: 6px;
            }

            .support-item p {
                color: #6b7280;
                font-size: 12px;
                margin-bottom: 12px;
            }

            .support-item a {
                font-size: 12px;
                color: #2563eb;
                font-weight: 700;
                text-decoration: none;
            }

            /* Responsive */
            @media (max-width: 1000px) {
                .stats-grid {
                    grid-template-columns: repeat(2, 1fr);
                }

                .content-grid {
                    grid-template-columns: 1fr;
                }
            }

            @media (max-width: 700px) {
                .dashboard {
                    padding: 15px;
                }

                .dashboard-header,
                .booking-bar,
                .action-card {
                    flex-direction: column;
                    align-items: stretch;
                }

                .stats-grid {
                    grid-template-columns: 1fr 1fr;
                }

                .event-stall {
                    grid-template-columns: 1fr 1fr;
                }

                .support-grid {
                    grid-template-columns: 1fr;
                }

                .header-actions {
                    width: 100%;
                }

                .header-actions .btn {
                    flex: 1;
                }
            }

            @media (max-width: 450px) {
                .stats-grid {
                    grid-template-columns: 1fr;
                }

                .event-stall {
                    grid-template-columns: 1fr;
                }
            }
        </style>
    </head>

    <body>

        <div class="dashboard">

            <!-- Header -->
            <div class="dashboard-header">
                <div>
                    <h1>Exhibitor Dashboard</h1>
                    <p>Welcome back, Growing Sphere Pvt. Ltd.</p>
                </div>

                <div class="header-actions">
                    <a href="#" class="btn">Help & Support</a>
                    <a href="#" class="btn btn-danger">Logout</a>
                </div>
            </div>

            <!-- Booking Bar -->
            <div class="booking-bar">
                <div class="booking-info">

                    <div class="booking-item">
                        <small>Booking ID</small>
                        <strong>BKEFLHFVVLVQ</strong>
                    </div>

                    <div class="booking-item">
                        <small>Booking Status</small>
                        <span class="status status-success">● Confirmed</span>
                    </div>

                    <div class="booking-item">
                        <small>Payment Status</small>
                        <span class="status status-warning">● Partially Paid</span>
                    </div>

                </div>

                <a href="#" class="btn btn-primary">Open Booking</a>
            </div>

            <!-- Statistics -->
            <div class="stats-grid">

                <div class="stat-card">
                    <div class="icon">📅</div>
                    <small>Upcoming Events</small>
                    <strong>2</strong>
                </div>

                <div class="stat-card">
                    <div class="icon">▣</div>
                    <small>Total Stalls</small>
                    <strong>2</strong>
                </div>

                <div class="stat-card">
                    <div class="icon">₹</div>
                    <small>Total Amount</small>
                    <strong>₹71,000</strong>
                </div>

                <div class="stat-card">
                    <div class="icon">!</div>
                    <small>Balance Due</small>
                    <strong>₹26,000</strong>
                </div>

            </div>

            <!-- Action Required -->
            <div class="action-card">

                <div>
                    <h3>🔴 Action Required</h3>
                    <p>
                        A payment of ₹26,000 is still pending.
                        Please complete the payment before the deadline.
                    </p>
                </div>

                <a href="#" class="btn btn-primary">Make Payment</a>

            </div>

            <!-- Main Content -->
            <div class="content-grid">

                <!-- Upcoming Events -->
                <div class="card">

                    <div class="card-header">
                        <h2>Upcoming Events</h2>
                        <a href="#">View All</a>
                    </div>

                    <div class="card-body">

                        <!-- Event 1 -->
                        <div class="event-card">

                            <div class="event-top">

                                <div>
                                    <div class="event-name">
                                        IITM Bengaluru 2026
                                    </div>

                                    <div class="event-date">
                                        📅 15 Sep 2026 - 17 Sep 2026
                                    </div>

                                    <div class="event-location">
                                        📍 Gate No-2, Tripura Vasini, Palace Ground,
                                        Bengaluru
                                    </div>
                                </div>

                                <span class="status status-success">
                                    Confirmed
                                </span>

                            </div>

                            <div class="event-stall">

                                <div class="stall-info">
                                    <small>Stall</small>
                                    <strong>5345</strong>
                                </div>

                                <div class="stall-info">
                                    <small>Size</small>
                                    <strong>4 sq. ft.</strong>
                                </div>

                                <div class="stall-info">
                                    <small>Type</small>
                                    <strong>Shell Scheme</strong>
                                </div>

                                <div class="stall-info">
                                    <small>Payment</small>
                                    <strong style="color:#16a34a;">Paid</strong>
                                </div>

                            </div>

                            <div class="event-footer">

                                <div class="event-price">
                                    ₹37,000
                                </div>

                                <a href="#" class="btn">
                                    View Stall
                                </a>

                            </div>

                        </div>

                        <!-- Event 2 -->
                        <div class="event-card">

                            <div class="event-top">

                                <div>
                                    <div class="event-name">
                                        IITM Kochi 2026
                                    </div>

                                    <div class="event-date">
                                        📅 09 Jan 2027 - 10 Jan 2027
                                    </div>

                                    <div class="event-location">
                                        📍 Rajiv Gandhi Indoor Stadium,
                                        Kochi
                                    </div>
                                </div>

                                <span class="status status-warning">
                                    Payment Pending
                                </span>

                            </div>

                            <div class="event-stall">

                                <div class="stall-info">
                                    <small>Stall</small>
                                    <strong>asdf</strong>
                                </div>

                                <div class="stall-info">
                                    <small>Size</small>
                                    <strong>4 sq. ft.</strong>
                                </div>

                                <div class="stall-info">
                                    <small>Type</small>
                                    <strong>Shell Scheme</strong>
                                </div>

                                <div class="stall-info">
                                    <small>Payment</small>
                                    <strong style="color:#d97706;">Pending</strong>
                                </div>

                            </div>

                            <div class="event-footer">

                                <div class="event-price">
                                    ₹34,000
                                </div>

                                <a href="#" class="btn btn-primary">
                                    Complete Payment
                                </a>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- Payment Summary -->
                <div class="card">

                    <div class="card-header">
                        <h2>Payment Summary</h2>
                        <a href="#">History</a>
                    </div>

                    <div class="card-body">

                        <div class="payment-total">
                            <small>Total Payable</small>
                            <strong>₹71,000</strong>
                        </div>

                        <div class="progress">
                            <div class="progress-bar"></div>
                        </div>

                        <div class="payment-row">
                            <span>Amount Paid</span>
                            <strong style="color:#16a34a;">₹35,000</strong>
                        </div>

                        <div class="payment-row">
                            <span>Pending Approval</span>
                            <strong style="color:#d97706;">₹10,000</strong>
                        </div>

                        <div class="payment-row">
                            <span>Balance Due</span>
                            <strong style="color:#dc2626;">₹26,000</strong>
                        </div>

                        <br>

                        <a href="#" class="btn btn-primary" style="width:100%;">
                            Make Payment
                        </a>

                    </div>

                </div>

            </div>

            <!-- Deadlines + Company -->
            <div class="content-grid">

                <!-- Deadlines -->
                <div class="card">

                    <div class="card-header">
                        <h2>Important Deadlines</h2>
                    </div>

                    <div class="card-body">

                        <div class="deadline">

                            <div>
                                <div class="deadline-date">
                                    30 Aug 2026
                                </div>

                                <div class="deadline-title">
                                    Update Booking Details
                                </div>
                            </div>

                            <div class="deadline-days deadline-danger">
                                8 days left
                            </div>

                        </div>

                        <div class="deadline">

                            <div>
                                <div class="deadline-date">
                                    05 Sep 2026
                                </div>

                                <div class="deadline-title">
                                    Final Payment
                                </div>
                            </div>

                            <div class="deadline-days deadline-warning">
                                14 days left
                            </div>

                        </div>

                        <div class="deadline">

                            <div>
                                <div class="deadline-date">
                                    10 Sep 2026
                                </div>

                                <div class="deadline-title">
                                    Stall Modification
                                </div>
                            </div>

                            <div class="deadline-days deadline-success">
                                19 days left
                            </div>

                        </div>

                        <div class="deadline">

                            <div>
                                <div class="deadline-date">
                                    15 Sep 2026
                                </div>

                                <div class="deadline-title">
                                    IITM Bengaluru Begins
                                </div>
                            </div>

                            <div class="deadline-days">
                                Event
                            </div>

                        </div>

                    </div>

                </div>

                <!-- Company Profile -->
                <div class="card">

                    <div class="card-header">
                        <h2>Company Profile</h2>
                        <a href="#">View</a>
                    </div>

                    <div class="card-body">

                        <div class="company-profile">

                            <div class="company-logo">
                                GS
                            </div>

                            <div>
                                <h3>Growing Sphere Pvt. Ltd.</h3>

                                <p>Category: General</p>

                                <p>
                                    GST: yououoisudfoiasudpf
                                </p>

                                <p>
                                    Mumbai, Maharashtra
                                </p>

                                <br>

                                <span class="status status-success">
                                    ● Profile Complete
                                </span>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <!-- Contact + Documents -->
            <div class="content-grid">

                <!-- Contact -->
                <div class="card">

                    <div class="card-header">
                        <h2>Primary Contact</h2>
                        <a href="#">Manage</a>
                    </div>

                    <div class="card-body">

                        <div class="contact-box">

                            <div class="contact-name">
                                Mr. Deepak Kanabar
                            </div>

                            <div class="contact-role">
                                Director
                            </div>

                            <div class="contact-detail">
                                ✉ dk@thegrowingsphere.com
                            </div>

                            <div class="contact-detail">
                                ☎ 91-7506212213
                            </div>

                            <br>

                            <span class="status status-info">
                                2 Stall Delegates
                            </span>

                        </div>

                    </div>

                </div>

                <!-- Documents -->
                <div class="card">

                    <div class="card-header">
                        <h2>Documents</h2>
                        <a href="#">View All</a>
                    </div>

                    <div class="card-body">

                        <div class="document-row">
                            <span class="document-name">
                                Booking Confirmation
                            </span>
                            <a href="#" class="document-action">
                                Download
                            </a>
                        </div>

                        <div class="document-row">
                            <span class="document-name">
                                Payment Receipt
                            </span>
                            <a href="#" class="document-action">
                                Download
                            </a>
                        </div>

                        <div class="document-row">
                            <span class="document-name">
                                Tax Invoice
                            </span>
                            <span class="status status-warning">
                                Pending
                            </span>
                        </div>

                        <div class="document-row">
                            <span class="document-name">
                                Stall Allocation
                            </span>
                            <a href="#" class="document-action">
                                Download
                            </a>
                        </div>

                    </div>

                </div>

            </div>

            <!-- Support -->
            <div class="card">

                <div class="card-header">
                    <h2>Need Help?</h2>
                </div>

                <div class="card-body">

                    <div class="support-grid">

                        <div class="support-item">
                            <h3>Request Changes</h3>

                            <p>
                                Need to modify your company,
                                contact or stall information?
                            </p>

                            <a href="#">
                                Request Changes →
                            </a>
                        </div>

                        <div class="support-item">
                            <h3>Email Confirmation</h3>

                            <p>
                                Didn't receive your booking
                                confirmation email?
                            </p>

                            <a href="#">
                                Send Confirmation →
                            </a>
                        </div>

                        <div class="support-item">
                            <h3>Raise a Ticket</h3>

                            <p>
                                Have a question or need assistance
                                with your booking?
                            </p>

                            <a href="#">
                                Contact Support →
                            </a>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </body>

    </html>


    <!-- Header Card -->
    <div class="card header-card">
        <div>
            <div>
                <span class="booking-ref-tag">Booking Reference</span>
                <span class="booking-id-text">{{ $final_bookingdetails->booking->booking_id }}</span>
            </div>
            <p class="header-subtitle">Review your event booking details and stall allocations.</p>
        </div>

        <div>
            @if($final_bookingdetails->booking->allow_edit)
            <span class="badge badge-editable">Editable Mode</span>
            @else
            <span class="badge badge-readonly">Read-Only</span>
            @endif
        </div>
    </div>

    <!-- Main Grid -->
    <div class="">

        <!-- Left Column: Company & Billing Contact -->

        <!-- Company Card -->
        <div class="card company-card">
            <div class="company-card-header">
                <h3>Company Profile</h3>
                <div class="company-name">{{ $final_bookingdetails->company->company_name }}</div>
            </div>

            <div class="company-card-body">
                <div class="info-group">
                    <span class="label">Category</span>
                    <span class="value-box">{{ $final_bookingdetails->company->category ?? 'N/A' }}</span>
                </div>

                <div class="info-group">
                    <span class="label">GST Number</span>
                    <span class="mono-box">{{ $final_bookingdetails->company->gst_number }}</span>
                </div>

                <div class="info-group">
                    <span class="label">Registered Address</span>
                    <p class="address-text">
                        {{ $final_bookingdetails->company->address }}<br>
                        <strong>{{ $final_bookingdetails->company->city }}, {{ $final_bookingdetails->company->state }}
                            - {{ $final_bookingdetails->company->pincode }}</strong>
                    </p>
                </div>
            </div>
        </div>

        <!-- Billing Contact Card -->
        <div class="card contact-card">
            <h2>Billing Contact</h2>

            <div class="contact-wrapper">
                <div class="avatar">
                    {{ strtoupper(substr($final_bookingdetails->billingcontact->name, 0, 1)) }}
                </div>

                <div class="contact-details">
                    <div class="contact-name">{{ $final_bookingdetails->billingcontact->name }}</div>
                    <div class="contact-title">{{ $final_bookingdetails->billingcontact->designation }}</div>

                    <div class="info-group">
                        <span class="label">Email</span>
                        <a href="mailto:{{ $final_bookingdetails->billingcontact->email }}" class="contact-link">
                            {{ $final_bookingdetails->billingcontact->email }}
                        </a>
                    </div>

                    <div class="info-group">
                        <span class="label">Mobile</span>
                        <span class="mono-box">{{ $final_bookingdetails->billingcontact->mobile }}</span>
                    </div>
                </div>
            </div>
        </div>


        <!-- Right Column: Included Subview -->
        @include('exhibitor.booking.summary.stalldetails')

    </div>
</div>