<style>
    .sb-wrapper {
        max-width: 1100px;
        margin: 20px auto;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }

    .sb-card {
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        border: 1px solid #f0f0f0;
        padding: 24px;
    }

    .sb-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 16px;
        border-bottom: 1px solid #f3f4f6;
    }

    .sb-card-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #111827;
        margin: 0;
    }

    .sb-table-responsive {
        width: 100%;
        overflow-x: auto;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
    }

    .sb-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        background-color: #ffffff;
    }

    .sb-table th {
        background-color: #f9fafb;
        color: #374151;
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 12px 16px;
        border-bottom: 1px solid #e5e7eb;
    }

    .sb-table td {
        padding: 12px 16px;
        border-bottom: 1px solid #f3f4f6;
        vertical-align: middle;
    }

    .sb-table tbody tr:hover {
        background-color: #f8fafc;
    }

    .sb-input,
    .sb-select {
        width: 100%;
        padding: 8px 12px;
        border-radius: 6px;
        border: 1px solid #d1d5db;
        background-color: #f9fafb;
        font-size: 0.875rem;
        color: #1f2937;
        transition: all 0.2s ease;
        outline: none;
        box-sizing: border-box;
    }

    .sb-input:focus,
    .sb-select:focus {
        background-color: #ffffff;
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    }

    .sb-input[readonly] {
        background-color: #f3f4f6;
        color: #6b7280;
        font-weight: 600;
        cursor: not-allowed;
    }

    .sb-total-input {
        background-color: #e0e7ff !important;
        color: #3730a3 !important;
        font-weight: 700 !important;
    }

    .sb-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 8px 16px;
        font-size: 0.875rem;
        font-weight: 600;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .sb-btn-primary {
        background-color: #ffffff;
        color: #4f46e5;
        border: 1px solid #4f46e5;
    }

    .sb-btn-primary:hover {
        background-color: #e0e7ff;
    }

    .sb-btn-success {
        background-color: #4f46e5;
        color: #ffffff;
        padding: 10px 24px;
    }

    .sb-btn-success:hover {
        background-color: #4338ca;
    }

    .sb-btn-danger {
        background-color: #fee2e2;
        color: #dc2626;
        padding: 6px 12px;
        font-size: 0.775rem;
    }

    .sb-btn-danger:hover {
        background-color: #fca5a5;
    }

    .sb-footer-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 20px;
    }
</style>