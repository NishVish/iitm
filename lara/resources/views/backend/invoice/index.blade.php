<!DOCTYPE html>
<html>

<head>
    <title>Invoice - {{ $invoice_number }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            color: #2d3436;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }

        .container {
            width: 850px;
            margin: 30px auto;
            background: #fff;
            padding: 40px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
            border-top: 8px solid #a4221e;
            /* IITM Red */
        }

        .header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
        }

        .brand-logo {
            color: #a4221e;
            font-weight: 900;
            font-size: 32px;
            letter-spacing: -1px;
        }

        .brand-logo span {
            color: #003366;
            /* IITM Blue */
        }

        .invoice-title {
            text-align: right;
        }

        .invoice-title h2 {
            margin: 0;
            color: #a4221e;
            font-size: 36px;
            text-transform: uppercase;
        }

        .meta-table {
            width: 100%;
            margin-bottom: 30px;
        }

        .meta-table td {
            width: 50%;
            vertical-align: top;
        }

        .label {
            color: #636e72;
            text-transform: uppercase;
            font-size: 11px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .bill-to-box {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 4px;
            border-left: 4px solid #003366;
        }

        table.items {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table.items th {
            background-color: #003366;
            color: white;
            text-align: left;
            padding: 12px 15px;
            text-transform: uppercase;
            font-size: 12px;
        }

        table.items td {
            padding: 15px;
            border-bottom: 1px solid #dfe6e9;
        }

        .right {
            text-align: right;
        }

        .total-section {
            margin-top: 30px;
            float: right;
            width: 300px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
        }

        .grand-total {
            background: #a4221e;
            color: white;
            padding: 15px;
            font-weight: bold;
            font-size: 18px;
            margin-top: 10px;
            border-radius: 4px;
        }

        .footer {
            margin-top: 100px;
            border-top: 1px solid #dfe6e9;
            padding-top: 20px;
            font-size: 11px;
            color: #b2bec3;
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="header">
            <div class="brand-logo">IITM<span>INDIA</span></div>
            <div class="invoice-title">
                <h2>INVOICE</h2>
                <div class="label" style="margin-top:10px;">Reference Number</div>
                <strong>{{ $invoice_number }}</strong>
            </div>
        </div>

        <table class="meta-table">
            <tr>
                <td>
                    <div class="bill-to-box">
                        <div class="label">Bill To:</div>
                        <strong>{{ $customer['name'] }}</strong><br>
                        {{ $customer['address'] }}<br>
                        {{ $customer['city'] }}, {{ $customer['state'] }} - {{ $customer['zip'] }}
                    </div>
                </td>
                <td class="right">
                    <div class="label">Invoice Date</div>
                    <div>{{ $invoice_date }}</div>
                    <div class="label" style="margin-top:15px;">Due Date</div>
                    <div>{{ $due_date }}</div>
                </td>
            </tr>
        </table>

        <table class="items">
            <thead>
                <tr>
                    <th>Service / Item Description</th>
                    <th class="right">Qty</th>
                    <th class="right">Rate</th>
                    <th class="right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                    <tr>
                        <td>
                            <strong>{{ $item['name'] }}</strong><br>
                            <small style="color:#636e72">{{ $item['description'] }}</small>
                        </td>
                        <td class="right">{{ $item['quantity'] }}</td>
                        <td class="right">{{ number_format($item['price'], 2) }}</td>
                        <td class="right"><strong>{{ number_format($item['total'], 2) }}</strong></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total-section">
            <div class="total-row">
                <span>Subtotal:</span>
                <span>{{ number_format($subtotal, 2) }}</span>
            </div>
            <div class="total-row">
                <span>Tax (GST):</span>
                <span>{{ number_format($tax, 2) }}</span>
            </div>
            <div class="grand-total">
                <span>TOTAL DUE:</span>
                <span style="float:right;">₹ {{ number_format($total, 2) }}</span>
            </div>
        </div>

        <div style="clear:both;"></div>

        <div class="footer">
            <strong>IITM India - India's Largest Travel Exhibition & Trade Show</strong><br>
            Sphere Travelmedia & Exhibitions Pvt. Ltd. | www.iitmindia.com
        </div>
    </div>

</body>

</html>