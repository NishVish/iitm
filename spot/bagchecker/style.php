<style>
    html,
    body {
        height: 100%;
        margin: 0;
    }

    body {
        background: #eef2f7;
        display: flex;
        justify-content: center;
        align-items: center;
        font-family: "Segoe UI", sans-serif;
        padding: 20px;
        box-sizing: border-box;
    }

    .phone {
        width: 100%;
        max-width: 430px;
        background: #fff;
        border-radius: 28px;
        overflow: hidden;
        box-shadow: 0 20px 50px rgba(0, 0, 0, .18);
    }

    .header {
        background: linear-gradient(135deg, #2563eb, #4f46e5);
        color: #fff;
        text-align: center;
        padding: 18px;
        font-size: 22px;
        font-weight: 600;
    }

    .container {
        padding: 18px;
    }

    .card {
        background: #fff;
        border-radius: 16px;
        padding: 16px;
        margin-bottom: 18px;
        border: 1px solid #edf0f5;
        box-shadow: 0 5px 18px rgba(0, 0, 0, .05);
    }

    .label {
        font-size: 13px;
        color: #666;
        font-weight: 700;
        margin-bottom: 12px;
    }

    .status {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #16a34a;
        font-weight: 600;
    }

    .dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #16a34a;
    }

    input[type=text] {
        width: 100%;
        padding: 13px;
        border: 1px solid #d9dce3;
        border-radius: 10px;
        font-size: 15px;
        box-sizing: border-box;
    }

    .scan-btn {
        width: 100%;
        margin-top: 15px;
        border: none;
        border-radius: 10px;
        padding: 13px;
        background: #2563eb;
        color: #fff;
        font-size: 16px;
        cursor: pointer;
        transition: .25s;
    }

    .scan-btn:hover {
        background: #1d4ed8;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        padding: 12px 0;
        border-bottom: 1px solid #efefef;
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-row span {
        color: #777;
        font-size: 14px;
        min-width: 80px;
    }

    .info-row strong {
        flex: 1;
        text-align: right;
        outline: none;
        word-break: break-word;
    }

    .camera {
        position: relative;
        height: 320px;
        background: #000;
        border-radius: 15px;
        overflow: hidden;
    }

    #reader {
        width: 100%;
        height: 100%;
    }

    #reader video {
        width: 100% !important;
        height: 100% !important;
        object-fit: cover !important;
    }

    #reader__dashboard {
        display: none;
    }

    .scan-box {
        position: absolute;
        width: 220px;
        height: 220px;
        border: 3px solid #00e5ff;
        border-radius: 12px;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        pointer-events: none;
    }

    .scan-line {
        position: absolute;
        width: 220px;
        height: 3px;
        background: #00e5ff;
        left: 50%;
        animation: scan 2s linear infinite;
    }

    @keyframes scan {
        0% {
            top: calc(50% - 110px);
            transform: translateX(-50%);
        }

        50% {
            top: calc(50% + 110px);
            transform: translateX(-50%);
        }

        100% {
            top: calc(50% - 110px);
            transform: translateX(-50%);
        }
    }

    @media print {

        body * {
            visibility: hidden;
        }

        #printSection,
        #printSection * {
            visibility: visible;
        }

        * {
            border: none !important;
            outline: none !important;
            box-shadow: none !important;
        }

        #printSection {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            text-align: center;
        }

        .image-container img {
            opacity: 0 !important;
        }

        .image-container.opacity-enabled img {
            opacity: 1 !important;
        }

        .overlay-text {
            color: blue !important;
        }

        .image-container.opacity-enabled .overlay-text {
            color: blue !important;
        }
    }

    .image-container {
        position: relative;
        display: inline-block;
        width: 9.2cm;
        height: 13.67cm;
    }

    .image-container img {
        width: 100%;
        height: 100%;
    }

    .overlay-text {
        position: absolute;
        width: calc(100% - 40px);
        text-align: center;
        line-height: 1.6;
    }

    #temp {
        position: absolute;
        margin-top: 300px;
        margin-left: 15px;
        line-height: 1.3;
        color: blue;
    }
</style>