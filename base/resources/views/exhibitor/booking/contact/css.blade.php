<style>
    .ui-table-container {
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        border: 1px solid #e5e7eb;
        padding: 24px;
        max-width: 1100px;
        margin: 0 auto 24px auto;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }

    .ui-table-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .ui-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        margin-bottom: 20px;
    }

    .ui-table th {
        background-color: #f9fafb;
        color: #374151;
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 12px 16px;
        border-bottom: 2px solid #e5e7eb;
        text-align: left;
    }

    .ui-table td {
        padding: 12px 16px;
        border-bottom: 1px solid #f3f4f6;
        vertical-align: middle;
    }

    .ui-table tr:last-child td {
        border-bottom: none;
    }

    .ui-input {
        width: 100%;
        padding: 8px 12px;
        border-radius: 6px;
        border: 1px solid #d1d5db;
        background-color: #ffffff;
        font-size: 0.875rem;
        color: #1f2937;
        transition: all 0.2s ease;
        outline: none;
        box-sizing: border-box;
    }

    .ui-input:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    }

    .ui-radio-label {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    .ui-radio-label input[type="radio"] {
        accent-color: #4f46e5;
        width: 18px;
        height: 18px;
        margin: 0;
        cursor: pointer;
    }

    .ui-btn {
        background-color: #4f46e5;
        color: #ffffff;
        font-weight: 600;
        padding: 8px 18px;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        font-size: 0.875rem;
        transition: background-color 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .ui-btn:hover {
        background-color: #4338ca;
    }

    .ui-btn-outline {
        background-color: transparent;
        color: #4f46e5;
        border: 1px solid #4f46e5;
    }

    .ui-btn-outline:hover {
        background-color: #e0e7ff;
    }

    .ui-btn-danger {
        background-color: #fee2e2;
        color: #dc2626;
        padding: 6px 10px;
        font-size: 0.8rem;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        font-weight: 600;
    }

    .ui-btn-danger:hover {
        background-color: #fca5a5;
        color: #991b1b;
    }

    .billing-radio-cell {
        text-align: center;
    }
</style>