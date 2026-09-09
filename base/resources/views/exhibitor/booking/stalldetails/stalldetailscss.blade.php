<style>
    :root {
        --primary: #4f46e5;
        --primary-hover: #4338ca;
        --primary-light: #eef2ff;
        --text-main: #0f172a;
        --text-muted: #64748b;
        --border-color: #e2e8f0;
        --card-bg: #ffffff;
        --page-bg: #f8fafc;
    }

    .stall-page {
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
        padding: 32px 24px 50px;
        box-sizing: border-box;
    }

    .stall-card {
        width: 100%;
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05);
        transition: all 0.25s ease;
        position: relative;
        overflow: hidden;
        margin-left: auto;
        margin-right: auto;
    }

    .stall-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: var(--primary);
        opacity: 0;
        transition: opacity 0.2s ease;
    }

    .stall-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 30px -10px rgba(79, 70, 229, 0.12);
        border-color: #cbd5e1;
    }

    .stall-card:hover::before {
        opacity: 1;
    }

    .card-badge-header {
        width: 100%;
        background: #f8fafc;
        border-bottom: 1px solid var(--border-color);
        padding: 18px 24px;
        box-sizing: border-box;
    }

    .card-badge-header .event-title {
        min-width: 0;
        flex: 1;
    }

    .card-badge-header h5 {
        margin: 0;
        font-size: 1.05rem;
        line-height: 1.4;
        word-break: break-word;
    }

    .badge-soft {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        background-color: var(--primary-light);
        color: var(--primary);
        font-weight: 700;
        font-size: 0.72rem;
        letter-spacing: 0.05em;
        padding: 7px 12px;
        border-radius: 20px;
    }

    .event-id-badge {
        flex-shrink: 0;
        white-space: nowrap;
    }

    .stall-body {
        width: 100%;
        padding: 28px;
        box-sizing: border-box;
    }

    .event-info-panel {
        width: 100%;
        background: #f8fafc;
        border: 1px solid #f1f5f9;
        border-radius: 12px;
        padding: 20px;
        box-sizing: border-box;
    }

    .event-info-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 20px;
        width: 100%;
    }

    .info-item {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 0;
        width: 100%;
    }

    .info-icon {
        width: 40px;
        height: 40px;
        min-width: 40px;
        border-radius: 9px;
        background: #ffffff;
        border: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary);
    }

    .info-content {
        min-width: 0;
        flex: 1;
    }

    .info-label {
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: var(--text-muted);
        font-weight: 700;
        margin-bottom: 4px;
    }

    .info-value {
        font-size: 0.9rem;
        color: var(--text-main);
        font-weight: 600;
        line-height: 1.35;
        word-break: break-word;
    }

    .info-value-small {
        display: block;
        margin-top: 3px;
        font-size: 0.75rem;
        color: var(--text-muted);
        font-weight: 400;
        line-height: 1.4;
    }

    .form-section {
        width: 100%;
        margin-top: 26px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 20px;
        width: 100%;
    }

    .form-field {
        min-width: 0;
        width: 100%;
    }

    .form-field.full-width {
        grid-column: 1 / -1;
    }

    .field-label {
        font-size: 0.8rem;
        font-weight: 600;
        color: #475569;
        margin-bottom: 7px;
        display: block;
    }

    .form-control-modern {
        width: 100%;
        min-height: 46px;
        box-sizing: border-box;
        border: 1px solid var(--border-color);
        border-radius: 10px;
        padding: 11px 14px;
        font-size: 0.9rem;
        color: var(--text-main);
        font-weight: 500;
        transition: all 0.2s ease;
        background-color: #ffffff;
    }

    .form-control-modern:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
        outline: none;
    }

    .allocated-area {
        width: 100%;
        min-height: 46px;
        box-sizing: border-box;
        border: 1px solid var(--border-color);
        border-radius: 10px;
        padding: 11px 14px;
        background: #f8fafc;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        color: var(--text-muted);
        font-size: 0.85rem;
    }

    .allocated-area strong {
        color: var(--text-main);
        font-size: 0.9rem;
        text-align: right;
        word-break: break-word;
    }

    .segmented-control {
        display: flex;
        width: 100%;
        max-width: 320px;
        background: #f1f5f9;
        padding: 4px;
        border-radius: 10px;
        box-sizing: border-box;
    }

    .segmented-control input[type="radio"] {
        display: none;
    }

    .segmented-control label {
        flex: 1;
        text-align: center;
        padding: 9px 16px;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--text-muted);
        cursor: pointer;
        transition: all 0.2s ease;
        margin: 0;
    }

    .segmented-control input[type="radio"]:checked+label {
        background: #ffffff;
        color: var(--primary);
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
    }

    .save-section {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        width: 100%;
        margin-top: 28px;
    }

    .btn-gradient {
        background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%);
        border: none;
        color: #ffffff;
        padding: 12px 28px;
        font-weight: 600;
        border-radius: 10px;
        box-shadow: 0 4px 14px rgba(79, 70, 229, 0.3);
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        cursor: pointer;
    }

    .btn-gradient:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(79, 70, 229, 0.4);
        color: #ffffff;
    }

    @media (max-width: 991px) {
        .stall-page {
            max-width: 100%;
            padding: 24px 18px 40px;
        }

        .event-info-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .stall-body {
            padding: 22px;
        }
    }

    @media (max-width: 767px) {
        .stall-page {
            padding: 18px 12px 35px;
        }

        .card-badge-header {
            padding: 16px;
        }

        .card-badge-header {
            flex-wrap: wrap;
            gap: 12px;
        }

        .card-badge-header .event-title {
            width: 100%;
            flex-basis: 100%;
        }

        .event-id-badge {
            margin-left: auto;
        }

        .stall-body {
            padding: 18px;
        }

        .event-info-panel {
            padding: 16px;
        }

        .event-info-grid {
            grid-template-columns: 1fr;
            gap: 16px;
        }

        .form-grid {
            grid-template-columns: 1fr;
            gap: 16px;
        }

        .form-field.full-width {
            grid-column: auto;
        }

        .save-section {
            justify-content: stretch;
        }

        .btn-gradient {
            width: 100%;
        }
    }

    @media (max-width: 480px) {
        .card-badge-header {
            padding: 14px;
        }

        .stall-body {
            padding: 14px;
        }

        .event-info-panel {
            padding: 13px;
        }

        .info-icon {
            width: 36px;
            height: 36px;
            min-width: 36px;
        }

        .allocated-area {
            align-items: flex-start;
            flex-direction: column;
            gap: 4px;
        }

        .allocated-area strong {
            text-align: left;
        }

        .event-id-badge {
            margin-left: 0;
        }
    }
</style>