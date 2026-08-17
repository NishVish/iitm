<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Stall Management Dashboard</title>

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
            padding: 30px;
        }

        .container {
            max-width: 1600px;
            margin: auto;
        }

        .header {
            margin-bottom: 25px;
        }

        .header h1 {
            font-size: 28px;
            color: #111827;
        }

        .header p {
            margin-top: 6px;
            color: #6b7280;
            font-size: 14px;
        }

        .summary {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            margin-bottom: 25px;
        }

        .summary-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 20px;
        }

        .summary-card .label {
            color: #6b7280;
            font-size: 13px;
            margin-bottom: 8px;
        }

        .summary-card .value {
            font-size: 24px;
            font-weight: 700;
            color: #111827;
        }

        .green .value {
            color: #059669;
        }

        .red .value {
            color: #dc2626;
        }

        .orange .value {
            color: #d97706;
        }

        .dashboard {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
        }

        .section-header {
            padding: 20px 22px;
            border-bottom: 1px solid #e5e7eb;
            background: #fafafa;
        }

        .section-header h2 {
            font-size: 18px;
            color: #111827;
        }

        .section-header p {
            margin-top: 5px;
            font-size: 13px;
            color: #6b7280;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 1550px;
        }

        th {
            background: #f9fafb;
            color: #6b7280;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            text-align: left;
            padding: 14px 15px;
            border-bottom: 1px solid #e5e7eb;
            white-space: nowrap;
        }

        td {
            padding: 16px 15px;
            border-bottom: 1px solid #eef0f3;
            font-size: 13px;
            color: #374151;
            white-space: nowrap;
        }

        tbody tr:hover {
            background: #fafcff;
        }

        .company {
            font-weight: 600;
            color: #111827;
        }

        .stall {
            color: #2563eb;
            font-weight: 700;
        }

        .category {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 6px;
            background: #eff6ff;
            color: #2563eb;
            font-size: 11px;
            font-weight: 600;
        }

        .amount-paid {
            color: #059669;
            font-weight: 600;
        }

        .amount-due {
            color: #dc2626;
            font-weight: 600;
        }

        .status {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 5px 9px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .status-completed {
            background: #dcfce7;
            color: #15803d;
        }

        .status-pending {
            background: #fef3c7;
            color: #b45309;
        }

        .status-not-started {
            background: #f3f4f6;
            color: #6b7280;
        }

        .status-partial {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .status-required {
            background: #fee2e2;
            color: #b91c1c;
        }

        .control-panel {
            padding: 22px;
        }

        .control-grid {
            display: grid;
            grid-template-columns: 1.5fr 1fr 1fr auto;
            gap: 15px;
            align-items: end;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 7px;
        }

        .form-group label {
            font-size: 12px;
            font-weight: 600;
            color: #4b5563;
        }

        select,
        input {
            width: 100%;
            height: 42px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 0 12px;
            background: #fff;
            color: #111827;
            outline: none;
            font-size: 14px;
        }

        select:focus,
        input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .send-btn {
            height: 42px;
            border: none;
            border-radius: 8px;
            padding: 0 20px;
            background: #2563eb;
            color: #fff;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            white-space: nowrap;
        }

        .send-btn:hover {
            background: #1d4ed8;
        }

        .notification {
            position: fixed;
            right: 25px;
            bottom: 25px;
            background: #111827;
            color: #fff;
            padding: 14px 18px;
            border-radius: 9px;
            font-size: 14px;
            opacity: 0;
            transform: translateY(15px);
            pointer-events: none;
            transition: 0.3s ease;
            max-width: 400px;
        }

        .notification.show {
            opacity: 1;
            transform: translateY(0);
        }

        @media (max-width: 900px) {
            body {
                padding: 15px;
            }

            .summary {
                grid-template-columns: 1fr 1fr;
            }

            .control-grid {
                grid-template-columns: 1fr;
            }

            .send-btn {
                width: 100%;
            }
        }

        @media (max-width: 550px) {
            .summary {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <div class="container">

        <div class="header">
            <h1>Stall Management</h1>
            <p>Company registration, branding, facilities and payment status</p>
        </div>

        <!-- SUMMARY -->
        <div class="summary">

            <div class="summary-card">
                <div class="label">Total Companies</div>
                <div class="value" id="totalCompanies">0</div>
            </div>

            <div class="summary-card green">
                <div class="label">Total Amount Paid</div>
                <div class="value" id="totalPaid">₹0</div>
            </div>

            <div class="summary-card red">
                <div class="label">Total Amount Due</div>
                <div class="value" id="totalDue">₹0</div>
            </div>

            <div class="summary-card orange">
                <div class="label">Pending Items</div>
                <div class="value" id="pendingItems">0</div>
            </div>

        </div>

        <div class="dashboard">

            <!-- SECTION 1 -->
            <div class="section-header">
                <h2>Section 1 — Company & Stall Details</h2>
                <p>Track stall details, payment and all required event services.</p>
            </div>

            <div class="table-wrapper">

                <table>
                    <thead>
                        <tr>
                            <th>Company Name</th>
                            <th>Stall No.</th>
                            <th>Category</th>
                            <th>Area</th>
                            <th>Amount Paid</th>
                            <th>Amount Due</th>
                            <th>Facia</th>
                            <th>Delegate Names</th>
                            <th>Branding</th>
                            <th>Furniture</th>
                            <th>Electricity</th>
                            <th>Internet</th>
                            <th>Documents</th>
                            <th>Payment Status</th>
                        </tr>
                    </thead>

                    <tbody id="companyTable"></tbody>
                </table>

            </div>

            <!-- SECTION 2 -->
            <div class="section-header">
                <h2>Section 2 — Control Panel</h2>
                <p>Select a company and manage payment collection.</p>
            </div>

            <div class="control-panel">

                <div class="control-grid">

                    <div class="form-group">
                        <label for="companySelect">Company</label>

                        <select id="companySelect">
                            <option value="">Select Company</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="paymentAmount">Payment Amount</label>

                        <input type="number" id="paymentAmount" placeholder="Enter amount" />
                    </div>

                    <div class="form-group">
                        <label for="paymentMethod">Payment Method</label>

                        <select id="paymentMethod">
                            <option value="UPI">UPI</option>
                            <option value="Bank Transfer">Bank Transfer</option>
                            <option value="Card">Card</option>
                        </select>
                    </div>

                    <button class="send-btn" onclick="sendPaymentLink()">
                        Send Link for Payment
                    </button>

                </div>

            </div>

        </div>

    </div>

    <div class="notification" id="notification"></div>

    <script>

        const companies = [

            {
                companyName: "TechNova Solutions",
                stallNo: "A-101",
                category: "Technology",
                area: "120 sq.ft",
                amountPaid: 25000,
                amountDue: 15000,

                facia: "Completed",
                delegateNames: "Completed",
                branding: "Pending",
                furniture: "Completed",
                electricity: "Completed",
                internet: "Pending",
                documents: "Completed"
            },

            {
                companyName: "GreenLeaf Organics",
                stallNo: "B-205",
                category: "Food & Organic",
                area: "100 sq.ft",
                amountPaid: 30000,
                amountDue: 10000,

                facia: "Completed",
                delegateNames: "Completed",
                branding: "Completed",
                furniture: "Pending",
                electricity: "Completed",
                internet: "Not Started",
                documents: "Completed"
            },

            {
                companyName: "UrbanCraft Furniture",
                stallNo: "C-310",
                category: "Furniture",
                area: "180 sq.ft",
                amountPaid: 40000,
                amountDue: 20000,

                facia: "Pending",
                delegateNames: "Completed",
                branding: "Pending",
                furniture: "Completed",
                electricity: "Pending",
                internet: "Pending",
                documents: "Completed"
            },

            {
                companyName: "SmartHome India",
                stallNo: "D-115",
                category: "Home & Living",
                area: "150 sq.ft",
                amountPaid: 35000,
                amountDue: 5000,

                facia: "Completed",
                delegateNames: "Completed",
                branding: "Completed",
                furniture: "Completed",
                electricity: "Completed",
                internet: "Completed",
                documents: "Completed"
            },

            {
                companyName: "StyleHub Fashion",
                stallNo: "E-220",
                category: "Fashion",
                area: "90 sq.ft",
                amountPaid: 20000,
                amountDue: 25000,

                facia: "Pending",
                delegateNames: "Pending",
                branding: "Not Started",
                furniture: "Pending",
                electricity: "Completed",
                internet: "Not Started",
                documents: "Pending"
            },

            {
                companyName: "FreshBite Foods",
                stallNo: "F-125",
                category: "Food & Beverage",
                area: "110 sq.ft",
                amountPaid: 28000,
                amountDue: 12000,

                facia: "Completed",
                delegateNames: "Pending",
                branding: "Completed",
                furniture: "Completed",
                electricity: "Completed",
                internet: "Pending",
                documents: "Completed"
            }

        ];

        function formatCurrency(amount) {

            return new Intl.NumberFormat("en-IN", {
                style: "currency",
                currency: "INR",
                maximumFractionDigits: 0
            }).format(amount);

        }

        function getStatusClass(status) {

            const normalized = status.toLowerCase();

            if (normalized === "completed") {
                return "status-completed";
            }

            if (normalized === "pending") {
                return "status-pending";
            }

            if (normalized === "not started") {
                return "status-not-started";
            }

            if (normalized === "partial") {
                return "status-partial";
            }

            return "status-required";

        }

        function statusBadge(status) {

            return `
        <span class="status ${getStatusClass(status)}">
          ${status}
        </span>
      `;

        }

        function renderTable() {

            const table = document.getElementById("companyTable");

            table.innerHTML = companies.map(company => {

                return `
          <tr>

            <td>
              <div class="company">
                ${company.companyName}
              </div>
            </td>

            <td>
              <span class="stall">
                ${company.stallNo}
              </span>
            </td>

            <td>
              <span class="category">
                ${company.category}
              </span>
            </td>

            <td>
              ${company.area}
            </td>

            <td>
              <span class="amount-paid">
                ${formatCurrency(company.amountPaid)}
              </span>
            </td>

            <td>
              <span class="amount-due">
                ${formatCurrency(company.amountDue)}
              </span>
            </td>

            <td>
              ${statusBadge(company.facia)}
            </td>

            <td>
              ${statusBadge(company.delegateNames)}
            </td>

            <td>
              ${statusBadge(company.branding)}
            </td>

            <td>
              ${statusBadge(company.furniture)}
            </td>

            <td>
              ${statusBadge(company.electricity)}
            </td>

            <td>
              ${statusBadge(company.internet)}
            </td>

            <td>
              ${statusBadge(company.documents)}
            </td>

            <td>
              ${company.amountDue === 0
                        ? statusBadge("Completed")
                        : company.amountPaid > 0
                            ? statusBadge("Partial")
                            : statusBadge("Pending")
                    }
            </td>

          </tr>
        `;

            }).join("");

        }

        function renderCompanySelect() {

            const select = document.getElementById("companySelect");

            companies.forEach((company, index) => {

                const option = document.createElement("option");

                option.value = index;

                option.textContent =
                    `${company.companyName} — ${company.stallNo}`;

                select.appendChild(option);

            });

        }

        function renderSummary() {

            const totalPaid = companies.reduce(
                (total, company) =>
                    total + company.amountPaid,
                0
            );

            const totalDue = companies.reduce(
                (total, company) =>
                    total + company.amountDue,
                0
            );

            let pending = 0;

            companies.forEach(company => {

                const statuses = [
                    company.facia,
                    company.delegateNames,
                    company.branding,
                    company.furniture,
                    company.electricity,
                    company.internet,
                    company.documents
                ];

                statuses.forEach(status => {

                    if (
                        status === "Pending" ||
                        status === "Not Started"
                    ) {
                        pending++;
                    }

                });

            });

            document.getElementById("totalCompanies").textContent =
                companies.length;

            document.getElementById("totalPaid").textContent =
                formatCurrency(totalPaid);

            document.getElementById("totalDue").textContent =
                formatCurrency(totalDue);

            document.getElementById("pendingItems").textContent =
                pending;

        }

        document
            .getElementById("companySelect")
            .addEventListener("change", function () {

                const selectedIndex = this.value;

                const amountInput =
                    document.getElementById("paymentAmount");

                if (selectedIndex === "") {

                    amountInput.value = "";

                    return;

                }

                const company = companies[selectedIndex];

                amountInput.value = company.amountDue;

            });

        function sendPaymentLink() {

            const companyIndex =
                document.getElementById("companySelect").value;

            const amount =
                document.getElementById("paymentAmount").value;

            const method =
                document.getElementById("paymentMethod").value;

            if (companyIndex === "") {

                showNotification(
                    "Please select a company."
                );

                return;

            }

            if (!amount || Number(amount) <= 0) {

                showNotification(
                    "Please enter a valid payment amount."
                );

                return;

            }

            const company = companies[companyIndex];

            const paymentLink =
                "https://example.com/pay/" +
                company.stallNo
                    .toLowerCase()
                    .replace("-", "");

            console.log({
                company: company.companyName,
                stallNo: company.stallNo,
                amount: Number(amount),
                paymentMethod: method,
                paymentLink: paymentLink
            });

            showNotification(
                `Payment link generated for ${company.companyName} — ${formatCurrency(Number(amount))}`
            );

        }

        function showNotification(message) {

            const notification =
                document.getElementById("notification");

            notification.textContent = message;

            notification.classList.add("show");

            setTimeout(() => {

                notification.classList.remove("show");

            }, 3000);

        }

        renderTable();
        renderCompanySelect();
        renderSummary();

    </script>

</body>

</html>