<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Editable Payslip with Auto Calculation</title>

  <style>
    /* Reset & base */
    body {
      margin: 5mm 15mm; /* A4 printable margins */
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      font-size: 12pt;
      color: #222;
      background: #fff;
      -webkit-print-color-adjust: exact;
      box-sizing: border-box;
      line-height: 1.4;
      max-width: 200mm; /* A4 width */
      min-height: 180mm; /* A4 height */
      margin-left: auto;
      margin-right: auto;
      text-align: center; /* center inline text */
    }

    .wrapper {
      max-width: 700px;
      margin: 0 auto;
      text-align: left; /* revert text alignment inside wrapper */
    }

    .header-container {
      display: flex;
      align-items: center;
      gap: 20px;
      border-bottom: 2px solid #2a7ae2;
      padding-bottom: 10px;
      margin-bottom: 10px;
    }

    .header-logo img {
      max-height: 60px;
      object-fit: contain;
    }

    .header-info {
      flex-grow: 1;
    }

    .company-name {
      font-size: 1.5rem;
      font-weight: 700;
      color: #fac612;
      margin: 0 0 4px 0;
    }

    .company-address {
      font-size: 1rem;
      color: #555;
      margin: 0 0 6px 0;
    }

    .payslip-month {
      font-style: italic;
      font-weight: 600;
      font-size: 1.1rem;
      color: #444;
    }

    table {
      border-collapse: collapse;
      width: 100%;
      font-family: Arial, sans-serif;
    }

    .info-table th,
    .info-table td,
    .earnings-table th,
    .earnings-table td,
    .net-pay-table td {
      padding: 5px 6px;
      border: 1px solid #ccc;
    }

    .info-table th {
      text-align: left;
      background-color: #ffffffff;
      font-weight: 600;
      width: 20%;
    }

    .info-table td {
      text-align: right;
      width: 30%;
    }

    .info-table tr:nth-child(even),
    .earnings-table tr:nth-child(even) {
      background-color: #ffffffff;
    }

    .earnings-table th {
      background-color: #f2f2f2;
      font-weight: 600;
      text-align: center;
    }

    .earnings-table td.label {
      text-align: left;
      font-weight: 600;
      width: 25%;
    }

    .earnings-table td.value input {
      width: 90%;
      border: none;
      text-align: right;
      font-weight: normal;
      font-size: 1rem;
      font-family: Arial, sans-serif;
      background: transparent;
    }

    .earnings-table td.value input:focus {
      outline: 1px solid #2a7ae2;
      background: #ffffffff;
    }

    .earnings-table td.total-label {
      text-align: left;
      font-weight: 700;
    }

    .earnings-table td.total-value {
      text-align: right;
      font-weight: 700;
    }

    .net-pay-row td {
      border: none;
      padding-top: 10px;
      font-weight: 700;
      font-size: 1.1rem;
    }

    .net-pay-row td input {
      width: 100%;
      border: none;
      background: transparent;
      text-align: right;
      font-weight: 700;
      font-size: 1.1rem;
      font-family: Arial, sans-serif;
    }

    .net-pay-row td input:focus {
      outline: 1px solid #2a7ae2;
      background: #ffffffff;
    }

    .amount-words {
      font-style: italic;
      padding-top: 5px;
      color: #555;
    }

    /* Leave balance */
    .leave-balance {
      margin-top: 30px;
      font-family: Arial, sans-serif;
      font-size: 1rem;
    }

    .leave-balance p {
      margin: 4px 0;
    }

    /* Signatures */
    .signatures {
      margin-top: 40px;
      display: flex;
      justify-content: space-between;
      font-family: Arial, sans-serif;
      font-size: 1rem;
      padding: 0 10px;
    }

    .signatures div {
      width: 40%;
      border-top: 1px solid #000;
      padding-top: 6px;
      text-align: center;
    }

    /* Company Info & footer */
    .company-info {
      margin-top: 30px;
      font-family: Arial, sans-serif;
      text-align: center;
      font-weight: 600;
      font-size: 1.1rem;
    }

    .payslip-month.footer {
      margin-top: 6px;
      font-family: Arial, sans-serif;
      text-align: center;
      font-style: italic;
      color: #555;
    }
  </style>
</head>
<body>
  <!-- Place this above the table -->
<div>
  <label>Gross Salary:</label> <input type="number" id="gross-salary" />
  
</div>

  <div class="wrapper">
    <div class="header-container">
      <div class="header-logo">
        <img 
          src="https://spheretravelmedia.com/wp-content/uploads/2025/03/cropped-cropped-38x38inch-Sphere-Logo-Copy-min_prev_ui-300x100.png" 
          alt="Sphere Travelmedia Logo"
        />
      </div>
      <div class="header-info">
        <h1 contenteditable="true" class="company-name">Sphere Travelmedia & Exhibitions Pvt Ltd</h1>
        <p contenteditable="true" class="company-address"># 245, Amar Jyothi Layout, Domlur, Bangalore - 560071</p>
        <p contenteditable="true" class="payslip-month">Payslip for the month of July 2025</p>
      </div>
    </div>

    <table class="info-table">
  <tr>
    <th>Employee ID</th>
    <td contenteditable="true"></td>
    <th>Name</th>
    <td contenteditable="true"></td>
  </tr>
  <tr>
    <th>Department</th>
    <td contenteditable="true"></td>
    <th>Designation</th>
    <td contenteditable="true"></td>
  </tr>
  <tr>
    <th>Date of Joining (DOJ)</th>
    <td contenteditable="true"></td>
    <th>UAN No</th>
    <td contenteditable="true"></td>
  </tr>
  <tr>
   <label>Days Worked:</label> <input type="number" id="days-worked" />
    <th>Father's Name</th>
    <td contenteditable="true"></td>
  </tr>
  <tr>
    <th>CL & SL</th>
    <td contenteditable="true"></td>
      <label>Total Days:</label> <input type="number" id="total-days" />
  </tr>
  <tr>
    <th>EL</th>
    <td contenteditable="true"></td>
    <th>Late Coming</th>
    <td contenteditable="true"></td>
  </tr>
  <tr>
    <th>LOP</th>
    <td contenteditable="true" colspan="3" style="text-align: right;"></td>
  </tr>
</table>
<table class="earnings-table">
  <thead>
    <tr>
      <th>Earnings</th>
      <th>Full Value</th>
      <th>Actual Value</th>
      <th>Deductions</th>
      <th>Full Value</th>
      <th>Actual Value</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td class="label">Basic Pay</td>
      <td class="value"><input type="number" id="basic-full" readonly /></td>
      <td class="value"><input type="number" id="basic-actual" /></td>
      <td class="label">EPF</td>
      <td class="value"><input type="number" id="epf-full" readonly /></td>
      <td class="value"><input type="number" id="epf-actual" /></td>
    </tr>
    <tr>
      <td class="label">HRA</td>
      <td class="value"><input type="number" id="hra-full" readonly /></td>
      <td class="value"><input type="number" id="hra-actual" /></td>
      <td class="label">PT</td>
      <td class="value"><input type="number" id="pt-full" readonly /></td>
      <td class="value"><input type="number" id="pt-actual" /></td>
    </tr>
    <tr>
      <td class="label">Spl Allowance</td>
      <td class="value"><input type="number" id="spl-full" readonly /></td>
      <td class="value"><input type="number" id="spl-actual" /></td>
      <td class="label">ESIC</td>
      <td class="value"><input type="number" id="esic-full" readonly /></td>
      <td class="value"><input type="number" id="esic-actual" /></td>
    </tr>
    <tr>
      <td class="label">Gratuity</td>
      <td class="value"><input type="number" id="gratuity-full" readonly /></td>
      <td class="value"><input type="number" id="gratuity-actual" /></td>
      <td class="label">TDS</td>
      <td class="value"><input type="number" id="tds-full" readonly /></td>
      <td class="value"><input type="number" id="tds-actual" /></td>
    </tr>
    <tr>
      <td class="label">Reimbursement</td>
      <td class="value"><input type="number" id="reimburse-full" readonly /></td>
      <td class="value"><input type="number" id="reimburse-actual" /></td>
      <td class="label">PF Admin Charges</td>
      <td class="value"><input type="number" id="pfadmin-full" readonly /></td>
      <td class="value"><input type="number" id="pfadmin-actual" /></td>
    </tr>
    <tr>
      <td class="label">Bonus / Others</td>
      <td class="value"><input type="number" id="bonus-full" readonly /></td>
      <td class="value"><input type="number" id="bonus-actual" /></td>
      <td class="label">Insurance</td>
      <td class="value"><input type="number" id="insurance-full" readonly /></td>
      <td class="value"><input type="number" id="insurance-actual" /></td>
    </tr>
    <tr>
      <td class="label">--</td>
      <td class="value"></td>
      <td class="value"></td>
      <td class="label">Employer ESIC</td>
      <td class="value"><input type="number" id="empesic-full" readonly /></td>
      <td class="value"><input type="number" id="empesic-actual" /></td>
    </tr>
    <tr>
      <td class="label">--</td>
      <td class="value"></td>
      <td class="value"></td>
      <td class="label">LWF</td>
      <td class="value"><input type="number" id="lwf-full" readonly /></td>
      <td class="value"><input type="number" id="lwf-actual" /></td>
    </tr>
    <tr>
      <td class="label">--</td>
      <td class="value"></td>
      <td class="value"></td>
      <td class="label">Advance / Loan</td>
      <td class="value"><input type="number" id="advance-full" readonly /></td>
      <td class="value"><input type="number" id="advance-actual" /></td>
    </tr>
    <tr>
      <td class="total-label">Total Earnings</td>
      <td class="total-value" id="total-earnings-full"></td>
      <td class="total-value" id="total-earnings-actual"></td>
      <td class="total-label">Total Deductions</td>
      <td class="total-value" id="total-deductions-full"></td>
      <td class="total-value" id="total-deductions-actual"></td>
    </tr>
  </tbody>
</table>


<table style="width: 100%; margin-top: 15px; font-family: Arial, sans-serif;" class="net-pay-table">
  <tr class="net-pay-row">
    <td style="text-align: left;">Previous Balance</td>
    <td style="text-align: right;">
      <input type="number" id="previous-balance" value="" min="0" />
    </td>
  </tr>
  <tr class="net-pay-row">
    <td style="text-align: left;">Net Pay:</td>
    <td style="text-align: right;">
      <input type="number" id="net-pay" value="" readonly />
    </td>
  </tr>
  <tr>
    <td colspan="2" class="amount-words" style="text-align: center;" id="amount-in-words">
    </td>
  </tr>
</table>

<div class="leave-balance" contenteditable="true">
  <p><strong>CL & SL Balance:</strong> </p>
  <p><strong>EL Balance:</strong> </p>
</div>

    <div class="signatures" contenteditable="true">
      <div>Employee Signature</div>
      <div>Employer Signature</div>
    </div>

    <div class="company-info" contenteditable="true">
      Sphere Travelmedia & Exhibitions Pvt Ltd<br />
      # 245, Amar Jyothi Layout, Domlur, Bangalore - 560071
    </div>

    <div class="payslip-month footer" contenteditable="true">
      Payslip for the month of July 2025
    </div>
  </div>

  <script>
  function numberToWords(num) {
    if (num === 0) return 'Zero only';
    if (num < 0) return 'Minus ' + numberToWords(Math.abs(num));
    const a = ['', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 'Ten',
      'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'];
    const b = ['', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'];

    function inWords(num) {
      if (num === 0) return '';
      if (num < 20) return a[num] + ' ';
      if (num < 100) return b[Math.floor(num / 10)] + ' ' + a[num % 10] + ' ';
      if (num < 1000) return a[Math.floor(num / 100)] + ' Hundred ' + inWords(num % 100);
      return '';
    }

    let str = '';
    let crore = Math.floor(num / 10000000);
    num %= 10000000;
    let lakh = Math.floor(num / 100000);
    num %= 100000;
    let thousand = Math.floor(num / 1000);
    num %= 1000;
    let hundred = num;

    if (crore > 0) str += inWords(crore) + 'Crore ';
    if (lakh > 0) str += inWords(lakh) + 'Lakh ';
    if (thousand > 0) str += inWords(thousand) + 'Thousand ';
    if (hundred > 0) str += inWords(hundred);

    return str.trim() + ' only';
  }

  function autoCalculateSalaries() {
    const grossInput = document.getElementById("gross-salary");
    const daysWorkedInput = document.getElementById("days-worked");
    const totalDaysInput = document.getElementById("total-days");

    const gross = parseFloat(grossInput?.value) || 0;
    const daysWorked = parseFloat(daysWorkedInput?.value) || 0;
    const totalDays = parseFloat(totalDaysInput?.value) || 0;

    const actualGross = totalDays > 0 ? Math.round((daysWorked / totalDays) * gross) : gross;

    // === Full Values ===
    const basicFull = gross * 0.40;
    const hraFull = basicFull * 0.40;
    const splFull = gross - basicFull - hraFull;

    const epfFull = basicFull * 0.12;
    const pfAdminFull = basicFull * 0.0116;
    const gratuityFull = basicFull * 0.0481;

    // === Actual Values ===
    const actualFactor = totalDays > 0 ? daysWorked / totalDays : 1;

    const basicActual = basicFull * actualFactor;
    const hraActual = hraFull * actualFactor;
    const splActual = splFull * actualFactor;
    const epfActual = epfFull * actualFactor;
    const pfAdminActual = pfAdminFull * actualFactor;
    const gratuityActual = gratuityFull * actualFactor;

    // Fill inputs (must have matching IDs in HTML)
    document.getElementById("basic-full").value = basicFull.toFixed(2);
    document.getElementById("basic-actual").value = basicActual.toFixed(2);

    document.getElementById("hra-full").value = hraFull.toFixed(2);
    document.getElementById("hra-actual").value = hraActual.toFixed(2);

    document.getElementById("spl-full").value = splFull.toFixed(2);
    document.getElementById("spl-actual").value = splActual.toFixed(2);

    document.getElementById("epf-full").value = epfFull.toFixed(2);
    document.getElementById("epf-actual").value = epfActual.toFixed(2);

    document.getElementById("pfadmin-full").value = pfAdminFull.toFixed(2);
    document.getElementById("pfadmin-actual").value = pfAdminActual.toFixed(2);

    document.getElementById("gratuity-full").value = gratuityFull.toFixed(2);
    document.getElementById("gratuity-actual").value = gratuityActual.toFixed(2);

    calculateNet();
  }

  function calculateNet() {
    // Sum actual earnings & deductions
    const earningsIds = ["basic-actual", "hra-actual", "spl-actual", "gratuity-actual"];
    const deductionIds = ["epf-actual", "pfadmin-actual"];

    let totalEarnings = 0;
    let totalDeductions = 0;

    earningsIds.forEach(id => {
      totalEarnings += parseFloat(document.getElementById(id)?.value) || 0;
    });

    deductionIds.forEach(id => {
      totalDeductions += parseFloat(document.getElementById(id)?.value) || 0;
    });

    document.getElementById('total-earnings').textContent = totalEarnings.toFixed(2);
    document.getElementById('total-deductions').textContent = totalDeductions.toFixed(2);

    const previousBalance = parseFloat(document.getElementById("previous-balance")?.value) || 0;
    const netPay = totalEarnings - totalDeductions + previousBalance;

    document.getElementById("net-pay").value = netPay.toFixed(2);
    document.getElementById("amount-in-words").textContent = "Amount in words: " + numberToWords(Math.round(netPay));
  }

  function attachAllListeners() {
    const inputs = document.querySelectorAll('#gross-salary, #days-worked, #total-days, #previous-balance');
    inputs.forEach(input => input.addEventListener('input', autoCalculateSalaries));
  }

  window.addEventListener('DOMContentLoaded', () => {
    attachAllListeners();
    autoCalculateSalaries();
  });
</script>

</body>
</html>
