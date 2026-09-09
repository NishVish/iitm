<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Exhibitor Dashboard — {{ $company->company_name }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Archivo:wght@600;800&family=Inter:wght@400;500;600&family=IBM+Plex+Mono:wght@400;500&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --paper: #EFEFE8;
            --panel: #FFFFFF;
            --ink: #14171D;
            --line: #DBDACF;
            --line-strong: #C7C6B9;
            --muted: #75786F;
            --green: #1F6F52;
            --green-bg: #E3F0E9;
            --red: #B23A2C;
            --red-bg: #F8E8E4;
            --navy: #243349;
            --navy-bg: #E7EAEF;
            --radius: 10px;
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            padding: 0;
        }

        body {
            background: var(--paper);
            color: var(--ink);
            font-family: 'Inter', sans-serif;
            -webkit-font-smoothing: antialiased;
            padding: 48px 24px 96px;
        }

        .page {
            max-width: 1040px;
            margin: 0 auto;
        }

        .eyebrow {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 11px;
            letter-spacing: .14em;
            text-transform: uppercase;
            color: var(--muted);
            margin: 0 0 10px;
        }

        .masthead {
            padding-bottom: 28px;
            border-bottom: 1px solid var(--line-strong);
            margin-bottom: 28px;
        }

        .masthead-row {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        h1 {
            font-family: 'Archivo', sans-serif;
            font-weight: 800;
            font-size: clamp(28px, 4vw, 40px);
            letter-spacing: -.01em;
            line-height: 1.05;
            margin: 0;
        }

        .booking-chip {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 13px;
            background: var(--ink);
            color: var(--paper);
            padding: 8px 14px;
            border-radius: 6px;
            white-space: nowrap;
        }

        .meta-line {
            margin-top: 10px;
            font-size: 14px;
            color: var(--muted);
        }

        .meta-line span:not(:last-child)::after {
            content: "·";
            margin: 0 8px;
            color: var(--line-strong);
        }

        .summary-grid {
            display: grid;
            grid-template-columns: 1.1fr 1fr 1fr;
            gap: 16px;
            margin-bottom: 44px;
        }

        .panel {
            background: var(--panel);
            border: 1px solid var(--line);
            border-radius: var(--radius);
            padding: 20px 22px;
        }

        .panel-label {
            display: block;
            font-family: 'IBM Plex Mono', monospace;
            font-size: 10.5px;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 14px;
        }

        .kv {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            font-size: 13.5px;
            padding: 7px 0;
            border-top: 1px solid var(--line);
        }

        .kv:first-of-type {
            border-top: none;
            padding-top: 0;
        }

        .kv dt {
            color: var(--muted);
            font-weight: 400;
        }

        .kv dd {
            margin: 0;
            text-align: right;
            font-weight: 500;
        }

        .kv dd.muted-val {
            color: var(--muted);
            font-weight: 400;
            font-style: italic;
        }

        dl {
            margin: 0;
        }

        .stat-row {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            padding: 9px 0;
            border-top: 1px solid var(--line);
        }

        .stat-row:first-of-type {
            border-top: none;
            padding-top: 0;
        }

        .stat-row .stat-label {
            font-size: 13.5px;
            color: var(--muted);
        }

        .stat-row .stat-value {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 16px;
            font-weight: 500;
        }

        .stat-value.due {
            color: var(--red);
        }

        .stat-value.ok {
            color: var(--green);
        }

        .section-head {
            display: flex;
            align-items: baseline;
            justify-content: space-between;
            margin-bottom: 18px;
        }

        .section-head h2 {
            font-family: 'Archivo', sans-serif;
            font-weight: 800;
            font-size: 20px;
            margin: 0;
        }

        .section-head .count {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 12.5px;
            color: var(--muted);
        }

        .empty-state {
            background: var(--panel);
            border: 1px dashed var(--line-strong);
            border-radius: var(--radius);
            padding: 40px 24px;
            text-align: center;
            color: var(--muted);
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="page">

        <header class="masthead">
            <p class="eyebrow">Exhibitor portal</p>
            <div class="masthead-row">
                <h1>{{ $company->company_name }}</h1>
                <div class="booking-chip">{{ $booking->booking_id }}</div>
            </div>
            <p class="meta-line">
                @if($company->category)<span>{{ $company->category }}</span>@endif
                @if($company->city || $company->state)<span>{{ trim(($company->city ?? '') . ', ' . ($company->state ?? ''), ', ') }}</span>@endif
                @if($updatedAt)<span>Updated {{ $updatedAt }}</span>@endif
            </p>
        </header>