{{-- resources/views/leads/allleads.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Leads</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: sans-serif;
            background: #f5f5f5;
            color: #222;
        }

        .page-wrapper {
            padding: 2rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        h2 {
            font-size: 20px;
            font-weight: 500;
            margin-bottom: 1.5rem;
        }

        .table-wrapper {
            width: 100%;
            overflow-x: auto;
            background: #fff;
            border-radius: 10px;
            border: 0.5px solid #ddd;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
            table-layout: fixed;
        }

        thead tr {
            background: #f9f9f9;
            border-bottom: 0.5px solid #ddd;
        }

        th {
            padding: 12px 14px;
            text-align: left;
            font-weight: 500;
            color: #555;
            white-space: nowrap;
        }

        td {
            padding: 12px 14px;
            border-bottom: 0.5px solid #f0f0f0;
            vertical-align: middle;
            color: #333;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        tbody tr:hover {
            background: #fafafa;
        }

        .badge {
            display: inline-block;
            font-size: 11px;
            font-weight: 500;
            padding: 3px 9px;
            border-radius: 20px;
        }

        .badge-draft {
            background: #eee;
            color: #666;
        }

        .badge-confirmed {
            background: #eaf3de;
            color: #3b6d11;
        }

        .badge-cancelled {
            background: #fcebeb;
            color: #a32d2d;
        }

        .badge-pending {
            background: #faeeda;
            color: #854f0b;
        }

        .badge-paid {
            background: #eaf3de;
            color: #3b6d11;
        }

        .badge-failed {
            background: #fcebeb;
            color: #a32d2d;
        }

        .badge-na {
            background: #f1efe8;
            color: #5f5e5a;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 12px;
            padding: 5px 11px;
            border-radius: 6px;
            border: 0.5px solid #ccc;
            background: #fff;
            cursor: pointer;
            color: #333;
            transition: background 0.15s;
        }

        .btn:hover {
            background: #f2f2f2;
        }

        .btn-mail {
            color: #185fa5;
            border-color: #b5d4f4;
        }

        .btn-mail:hover {
            background: #e6f1fb;
        }

        .btn-edit {
            color: #3b6d11;
            border-color: #c0dd97;
        }

        .btn-edit:hover {
            background: #eaf3de;
        }

        .action-cell {
            display: flex;
            gap: 6px;
        }

        .empty-row td {
            text-align: center;
            padding: 2.5rem;
            color: #999;
        }

        /* ── Modal Overlay ── */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.35);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal-overlay.open {
            display: flex;
        }

        .modal {
            background: #fff;
            border-radius: 12px;
            padding: 1.75rem;
            width: 100%;
            max-width: 440px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
        }

        .modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.25rem;
        }

        .modal-header h3 {
            font-size: 16px;
            font-weight: 500;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
            color: #888;
            line-height: 1;
        }

        .modal-close:hover {
            color: #333;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            font-size: 12px;
            color: #666;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 100%;
            padding: 8px 12px;
            border: 0.5px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
            color: #222;
            outline: none;
        }

        .form-group input:focus {
            border-color: #378add;
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 8px;
            margin-top: 1.25rem;
        }

        .btn-cancel {
            padding: 7px 16px;
            border-radius: 6px;
            border: 0.5px solid #ccc;
            background: #fff;
            cursor: pointer;
            font-size: 13px;
            color: #555;
        }

        .btn-send {
            padding: 7px 16px;
            border-radius: 6px;
            border: none;
            background: #185fa5;
            color: #fff;
            cursor: pointer;
            font-size: 13px;
            font-weight: 500;
        }

        .btn-send:hover {
            background: #0c447c;
        }

        .btn-send:disabled {
            background: #aaa;
            cursor: not-allowed;
        }

        .col-id {
            width: 70px;
        }

        .col-company {
            width: 130px;
        }

        .col-exhibitor {
            width: 140px;
        }

        .col-contact {
            width: 130px;
        }

        .col-year {
            width: 70px;
        }

        .col-sp {
            width: 110px;
        }

        .col-status {
            width: 100px;
        }

        .col-payment {
            width: 100px;
        }

        .col-date {
            width: 130px;
        }

        .col-action {
            width: 190px;
        }
    </style>
</head>

<body>

    <div class="page-wrapper">
        <h2>All Leads</h2>

        <div class="table-wrapper"></div>