<style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background: linear-gradient(135deg, #1e1e2f, #2b2b45);
        margin: 0;
        color: #333;
    }

    .container-box {
        max-width: 700px;
        margin: 30px auto;
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        padding-bottom: 90px;
    }

    /* Steps */
    .step {
        display: none;
        animation: fadeIn 0.3s ease-in-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Tabs */
    .step-tabs {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
        background: #f1f1f1;
        padding: 6px;
        border-radius: 50px;
    }

    .step-tabs button {
        flex: 1;
        border: none;
        background: transparent;
        padding: 10px;
        border-radius: 50px;
        cursor: pointer;
        font-weight: 500;
        transition: 0.3s;
    }

    .step-tabs button.active {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: #fff;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .step-tabs button:hover {
        background: rgba(0, 0, 0, 0.05);
    }

    /* Footer */
    .form-footer {
        position: sticky;
        bottom: 0;
        background: #fff;
        padding: 15px;
        border-top: 1px solid #eee;
        text-align: right;
    }

    .form-footer button {
        background: linear-gradient(135deg, #667eea, #764ba2);
        border: none;
        color: #fff;
        padding: 10px 22px;
        border-radius: 25px;
        font-size: 15px;
        cursor: pointer;
        transition: 0.3s;
    }

    .form-footer button:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
    }
</style>