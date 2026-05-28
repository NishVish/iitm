<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Paged.js Full Page Layout</title>

    <script src="https://unpkg.com/pagedjs/dist/paged.polyfill.js"></script>

    <style>
        @page {
            size: A4 landscape;
            margin: 0;
        }

        body {
            margin: 0;
            font-family: Arial;
            background: #eee;
        }

        .print-area {
            width: 100%;
        }

        /* FULL PAGE FIX */
        .page {
            width: 297mm;
            height: 210mm;
            box-sizing: border-box;
            background: white;
            overflow: hidden;

            /* important for perfect pagination */
            break-after: page;
            page-break-after: always;

            display: flex;
            flex-direction: column;
        }

        /* CONTENT SHOULD FILL FULL PAGE */
        .page-content {
            flex: 1;
            width: 100%;
            height: 100%;
            padding: 0;
            margin: 0;
        }

        .print-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            background: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            z-index: 999999;
        }

        @media print {
            .print-btn {
                display: none !important;
            }
        }
    </style>
</head>

<body>

    <style>
        .sponsor-class-1 {
            height: 100%;
            box-sizing: border-box;
            padding: 20mm;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background: linear-gradient(135deg, #1a1a1a 0%, #2c3e50 100%);
            color: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            border-left: 15px solid #d4af37;
            position: relative;
            overflow: hidden;
        }

        .sponsor-class-2 {
            position: absolute;
            right: -50px;
            top: -50px;
            width: 300px;
            height: 300px;
            background: rgba(212, 175, 55, 0.05);
            border-radius: 50%;
        }

        .sponsor-class-3 {
            width: 80px;
            height: 4px;
            background-color: #d4af37;
            margin-bottom: 25px;
        }

        .sponsor-class-4 {
            letter-spacing: 2px;
            text-transform: uppercase;
            z-index: 1;
        }

        .sponsor-class-5 {
            font-weight: 300;
            margin: 0;
            font-size: 22px;
            color: #d4af37;
            letter-spacing: 6px;
        }

        .sponsor-class-6 {
            font-size: 58px;
            line-height: 1;
            margin: 15px 0;
            font-weight: 800;
            letter-spacing: -1px;
        }

        .sponsor-class-7 {
            color: #fff;
        }

        .sponsor-class-8 {
            background: linear-gradient(90deg, #d4af37, transparent);
            height: 1px;
            width: 400px;
            margin: 30px 0;
        }

        .sponsor-class-9 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 40px;
            color: #ecf0f1;
            letter-spacing: 8px;
        }

        .sponsor-class-10 {
            margin-top: 20px;
        }

        .sponsor-class-11 {
            font-size: 16px;
            font-weight: 300;
            color: #bdc3c7;
            margin-bottom: 10px;
            letter-spacing: 1px;
        }

        .sponsor-class-12 {
            color: #d4af37;
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
            border-bottom: 1px solid #d4af37;
            padding-bottom: 3px;
            letter-spacing: 2px;
        }

        .sponsor-class-13 {
            position: absolute;
            bottom: 20px;
            right: 40px;
            font-size: 12px;
            color: rgba(255, 255, 255, 0.3);
            letter-spacing: 2px;
        }

        .sponsor-class-14 {
            height: 100%;
            box-sizing: border-box;
            padding: 15mm 20mm;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #ffffff;
            color: #333;
            position: relative;
            display: flex;
            flex-direction: column;
            border-top: 10px solid #1a1a1a;
        }

        .sponsor-class-15 {
            margin-bottom: 30px;
        }

        .sponsor-class-16 {
            font-size: 28px;
            font-weight: 800;
            color: #1a1a1a;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 0;
        }

        .sponsor-class-17 {
            color: #d4af37;
        }

        .sponsor-class-18 {
            width: 80px;
            height: 4px;
            background-color: #d4af37;
            margin-top: 12px;
        }

        .sponsor-class-19 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            flex-grow: 1;
        }

        .sponsor-class-20 {
            background: #f9f9f9;
            border: 1px solid #eee;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            border-radius: 4px;
            overflow: hidden;
        }

        .sponsor-class-21 {
            padding: 25px;
        }

        .sponsor-class-22 {
            font-size: 10px;
            color: #d4af37;
            font-weight: 800;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .sponsor-class-23 {
            font-size: 18px;
            color: #1a1a1a;
            margin: 0 0 15px 0;
            text-transform: uppercase;
        }

        .sponsor-class-24 {
            font-size: 13px;
            line-height: 1.6;
            color: #555;
            margin: 0;
        }

        .sponsor-class-25 {
            background: #1a1a1a;
            padding: 15px;
            color: #fff;
            text-align: center;
        }

        .sponsor-class-26 {
            font-size: 10px;
            letter-spacing: 1px;
            color: #d4af37;
            font-weight: bold;
            margin-bottom: 2px;
        }

        .sponsor-class-27 {
            font-size: 20px;
            font-weight: 300;
        }

        .sponsor-class-28 {
            font-size: 10px;
            color: #1a1a1a;
            font-weight: 800;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .sponsor-class-29 {
            background: #d4af37;
            padding: 15px;
            color: #fff;
            text-align: center;
        }

        .sponsor-class-30 {
            font-size: 10px;
            letter-spacing: 1px;
            color: #1a1a1a;
            font-weight: bold;
            margin-bottom: 2px;
        }

        .sponsor-class-31 {
            font-size: 20px;
            font-weight: 800;
        }

        .sponsor-class-32 {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid #eee;
            padding-top: 15px;
        }

        .sponsor-class-33 {
            font-size: 11px;
            color: #999;
            font-weight: bold;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .sponsor-class-34 {
            font-size: 14px;
            color: #d4af37;
            font-weight: 800;
        }

        .sponsor-class-35 {
            height: 100%;
            box-sizing: border-box;
            padding: 15mm 20mm;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #ffffff;
            color: #333;
            position: relative;
            display: flex;
            flex-direction: column;
            border-top: 10px solid #d4af37;
        }

        .sponsor-class-36 {
            font-size: 13px;
            color: #777;
            margin: 5px 0 0 0;
        }

        .sponsor-class-37 {
            flex-grow: 1;
        }

        .sponsor-class-38 {
            width: 100%;
            border-collapse: collapse;
            font-size: 15px;
        }

        .sponsor-class-39 {
            background-color: #1a1a1a;
            color: #fff;
            text-align: left;
        }

        .sponsor-class-40 {
            padding: 15px 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 12px;
        }

        .sponsor-class-41 {
            padding: 15px 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 12px;
            text-align: right;
        }

        .sponsor-class-42 {
            border-bottom: 1px solid #eee;
        }

        .sponsor-class-43 {
            padding: 20px;
            font-weight: 700;
            color: #1a1a1a;
        }

        .sponsor-class-44 {
            padding: 20px;
            color: #666;
            font-family: monospace;
        }

        .sponsor-class-45 {
            padding: 20px;
            text-align: right;
            font-weight: 800;
            color: #d4af37;
            font-size: 18px;
        }

        .sponsor-class-46 {
            border-bottom: 1px solid #eee;
            background-color: #fcfcfc;
        }

        .sponsor-class-47 {
            padding: 20px;
            text-align: right;
            font-weight: 800;
            color: #1a1a1a;
            font-size: 18px;
        }

        .sponsor-class-48 {
            border-bottom: 1px solid #1a1a1a;
        }

        .sponsor-class-49 {
            margin-top: 25px;
            display: flex;
            align-items: flex-start;
            gap: 15px;
        }

        .sponsor-class-50 {
            background: #fffcf5;
            border: 1px solid #d4af37;
            padding: 15px;
            flex-grow: 1;
        }

        .sponsor-class-51 {
            margin: 0;
            font-size: 13px;
            color: #555;
            line-height: 1.5;
        }

        .sponsor-class-52 {
            color: #1a1a1a;
        }

        .sponsor-class-53 {
            padding: 15px;
            font-size: 12px;
            color: #999;
            text-align: right;
        }

        .sponsor-class-54 {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid #eee;
            padding-top: 15px;
        }

        .sponsor-class-55 {
            height: 100%;
            box-sizing: border-box;
            padding: 0;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #1a1a1a;
            color: #ffffff;
            position: relative;
            display: flex;
            overflow: hidden;
        }

        .sponsor-class-56 {
            width: 45%;
            background-color: #d4af37;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 40px;
            position: relative;
        }

        .sponsor-class-57 {
            font-size: 60px;
            font-weight: 900;
            line-height: 0.9;
            text-transform: uppercase;
            letter-spacing: -2px;
            color: #1a1a1a;
        }

        .sponsor-class-58 {
            width: 60px;
            height: 10px;
            background: #1a1a1a;
            margin-top: 20px;
        }

        .sponsor-class-59 {
            position: absolute;
            bottom: -20px;
            left: -20px;
            font-size: 150px;
            font-weight: 900;
            color: rgba(0, 0, 0, 0.05);
            pointer-events: none;
        }

        .sponsor-class-60 {
            width: 55%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 60px;
            background: #1a1a1a;
        }

        .sponsor-class-61 {
            margin-bottom: 40px;
        }

        .sponsor-class-62 {
            font-size: 18px;
            color: #d4af37;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 10px;
        }

        .sponsor-class-63 {
            font-size: 22px;
            font-weight: 700;
            color: #fff;
        }

        .sponsor-class-64 {
            display: flex;
            flex-direction: column;
            gap: 25px;
        }

        .sponsor-class-65 {
            display: flex;
            gap: 15px;
        }

        .sponsor-class-66 {
            color: #d4af37;
            font-size: 20px;
            line-height: 1;
        }

        .sponsor-class-67 {
            font-size: 15px;
            color: #ccc;
            line-height: 1.5;
        }

        .sponsor-class-68 {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .sponsor-class-69 {
            font-size: 15px;
            color: #ccc;
        }

        .sponsor-class-70 {
            color: #fff;
            font-weight: bold;
        }

        .sponsor-class-71 {
            font-size: 15px;
        }

        .sponsor-class-72 {
            color: #fff;
            text-decoration: none;
            margin-right: 20px;
            border-bottom: 1px solid #d4af37;
        }

        .sponsor-class-73 {
            color: #fff;
            text-decoration: none;
            border-bottom: 1px solid #d4af37;
        }

        .sponsor-class-74 {
            position: absolute;
            bottom: 15mm;
            right: 15mm;
            color: #444;
            font-size: 14px;
            font-weight: 900;
        }

        .sponsor-class-75 {
            height: 100%;
            box-sizing: border-box;
            padding: 15mm 20mm;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #ffffff;
            color: #333;
            position: relative;
            border-top: 10px solid #1a1a1a;
            display: flex;
            flex-direction: column;
        }

        .sponsor-class-76 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            flex-grow: 1;
        }

        .sponsor-class-77 {
            padding: 20px;
            border-left: 4px solid #d4af37;
            background: #f9f9f9;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .sponsor-class-78 {
            display: block;
            font-size: 17px;
            color: #1a1a1a;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .sponsor-class-79 {
            margin: 0;
            font-size: 14px;
            line-height: 1.5;
            color: #555;
        }

        .sponsor-class-80 {
            padding: 20px;
            border-left: 4px solid #1a1a1a;
            background: #f9f9f9;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .sponsor-class-81 {
            padding: 15px;
            border: 1px dashed #d4af37;
            background: #fffcf5;
            margin-top: 25px;
            text-align: center;
        }

        .sponsor-class-82 {
            margin: 0;
            font-size: 15px;
            font-style: italic;
            color: #1a1a1a;
        }

        .sponsor-class-83 {
            height: 100%;
            box-sizing: border-box;
            padding: 15mm 15mm;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            position: relative;
            display: flex;
            flex-direction: column;
        }

        .sponsor-class-84 {
            text-align: center;
            margin-bottom: 25px;
        }

        .sponsor-class-85 {
            font-size: 24px;
            font-weight: 800;
            color: #1a1a1a;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin: 0;
        }

        .sponsor-class-86 {
            font-size: 14px;
            color: #666;
            margin: 5px 0 0 0;
        }

        .sponsor-class-87 {
            width: 60px;
            height: 3px;
            background-color: #d4af37;
            margin: 10px auto;
        }

        .sponsor-class-88 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            flex-grow: 1;
        }

        .sponsor-class-89 {
            background: #ffffff;
            border: 1px solid #ddd;
            display: flex;
            flex-direction: column;
            position: relative;
            border-top: 6px solid #1a1a1a;
        }

        .sponsor-class-90 {
            background: #1a1a1a;
            color: #d4af37;
            padding: 15px;
            text-align: center;
        }

        .sponsor-class-91 {
            font-size: 11px;
            letter-spacing: 2px;
            font-weight: bold;
            opacity: 0.8;
        }

        .sponsor-class-92 {
            font-size: 20px;
            font-weight: 900;
            margin: 5px 0;
        }

        .sponsor-class-93 {
            font-size: 18px;
            font-weight: 300;
        }

        .sponsor-class-94 {
            padding: 20px 25px;
            margin: 0;
            font-size: 11.5px;
            line-height: 1.6;
            color: #444;
            list-style-type: square;
        }

        .sponsor-class-95 {
            background: #ffffff;
            border: 1px solid #ddd;
            display: flex;
            flex-direction: column;
            border-top: 6px solid #d4af37;
        }

        .sponsor-class-96 {
            background: #d4af37;
            color: #fff;
            padding: 15px;
            text-align: center;
        }

        .sponsor-class-97 {
            font-size: 11px;
            letter-spacing: 2px;
            font-weight: bold;
            opacity: 0.9;
        }

        .sponsor-class-98 {
            background: #ffffff;
            border: 1px solid #ddd;
            display: flex;
            flex-direction: column;
            border-top: 6px solid #a0a0a0;
        }

        .sponsor-class-99 {
            background: #a0a0a0;
            color: #fff;
            padding: 15px;
            text-align: center;
        }

        .sponsor-class-100 {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid #ccc;
            padding-top: 10px;
        }

        .sponsor-class-101 {
            font-size: 10px;
            color: #888;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .sponsor-class-102 {
            font-size: 14px;
            color: #1a1a1a;
            font-weight: 800;
        }

        .sponsor-class-103 {
            height: 100%;
            box-sizing: border-box;
            padding: 15mm 15mm;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #ffffff;
            color: #333;
            position: relative;
            display: flex;
            flex-direction: column;
            border-right: 10px solid #d4af37;
        }

        .sponsor-class-104 {
            margin-bottom: 25px;
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }

        .sponsor-class-105 {
            font-size: 22px;
            font-weight: 800;
            color: #1a1a1a;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 0;
        }

        .sponsor-class-106 {
            text-align: right;
            font-size: 11px;
            color: #999;
            letter-spacing: 1px;
        }

        .sponsor-class-107 {
            background: #fdfdfd;
            border: 1px solid #e0e0e0;
            display: flex;
            flex-direction: column;
        }

        .sponsor-class-108 {
            background: #1a1a1a;
            color: #fff;
            padding: 15px;
            text-align: center;
        }

        .sponsor-class-109 {
            font-size: 16px;
            margin: 0;
            letter-spacing: 1px;
        }

        .sponsor-class-110 {
            color: #d4af37;
            font-size: 18px;
            font-weight: bold;
            margin-top: 5px;
        }

        .sponsor-class-111 {
            padding: 15px;
            font-size: 11.5px;
            line-height: 1.5;
            color: #444;
        }

        .sponsor-class-112 {
            margin-top: 0;
        }

        .sponsor-class-113 {
            padding-left: 15px;
            margin: 10px 0;
        }

        .sponsor-class-114 {
            color: #1a1a1a;
            font-size: 18px;
            font-weight: bold;
            margin-top: 5px;
        }

        .sponsor-class-115 {
            background: #f9f9f9;
            padding: 10px;
            border: 1px solid #eee;
            margin: 10px 0;
        }

        .sponsor-class-116 {
            color: #1a1a1a;
            font-size: 10px;
            text-transform: uppercase;
        }

        .sponsor-class-117 {
            padding-left: 15px;
            margin: 5px 0 0 0;
        }

        .sponsor-class-118 {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }

        .sponsor-class-119 {
            font-size: 10px;
            color: #bbb;
            font-weight: bold;
        }

        .sponsor-class-120 {
            height: 100%;
            box-sizing: border-box;
            padding: 15mm 20mm;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            position: relative;
            display: flex;
            flex-direction: column;
            border-top: 8px solid #d4af37;
        }

        .sponsor-class-121 {
            margin-bottom: 25px;
        }

        .sponsor-class-122 {
            font-size: 26px;
            font-weight: 800;
            color: #1a1a1a;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin: 0;
        }

        .sponsor-class-123 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            grid-template-rows: repeat(2, 1fr);
            gap: 15px;
            flex-grow: 1;
        }

        .sponsor-class-124 {
            background: #fff;
            border: 1px solid #eee;
            padding: 15px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            border-bottom: 3px solid #1a1a1a;
        }

        .sponsor-class-125 {
            margin: 0;
            font-size: 14px;
            color: #1a1a1a;
            text-transform: uppercase;
        }

        .sponsor-class-126 {
            width: 30px;
            height: 2px;
            background: #d4af37;
            margin: 10px 0;
        }

        .sponsor-class-127 {
            font-size: 18px;
            font-weight: 800;
            color: #d4af37;
        }

        .sponsor-class-128 {
            font-size: 11px;
            color: #999;
            font-weight: normal;
        }

        .sponsor-class-129 {
            background: #fff;
            border: 1px solid #eee;
            padding: 15px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            border-bottom: 3px solid #d4af37;
        }

        .sponsor-class-130 {
            width: 30px;
            height: 2px;
            background: #1a1a1a;
            margin: 10px 0;
        }

        .sponsor-class-131 {
            background: #1a1a1a;
            border: 1px solid #1a1a1a;
            padding: 15px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            color: #fff;
        }

        .sponsor-class-132 {
            margin: 0;
            font-size: 14px;
            color: #d4af37;
            text-transform: uppercase;
        }

        .sponsor-class-133 {
            font-size: 10px;
            color: #bbb;
            margin: 5px 0;
        }

        .sponsor-class-134 {
            font-size: 18px;
            font-weight: 800;
            color: #fff;
        }

        .sponsor-class-135 {
            font-size: 10px;
            color: #777;
            margin: 5px 0;
        }

        .sponsor-class-136 {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 10px;
        }

        .sponsor-class-137 {
            font-size: 10px;
            color: #999;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .sponsor-class-138 {
            display: flex;
            align-items: center;
        }

        .sponsor-class-139 {
            font-size: 11px;
            color: #999;
            margin-right: 15px;
        }

        .sponsor-class-140 {
            height: 100%;
            box-sizing: border-box;
            padding: 0;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #ffffff;
            color: #333;
            position: relative;
            display: flex;
            overflow: hidden;
        }

        .sponsor-class-141 {
            width: 50%;
            padding: 20mm 15mm;
            background: #1a1a1a;
            color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            border-right: 2px solid #d4af37;
        }

        .sponsor-class-142 {
            margin-bottom: 20px;
        }

        .sponsor-class-143 {
            font-size: 12px;
            letter-spacing: 3px;
            color: #d4af37;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .sponsor-class-144 {
            font-size: 32px;
            font-weight: 800;
            line-height: 1.1;
            margin: 0;
            text-transform: uppercase;
        }

        .sponsor-class-145 {
            font-size: 24px;
            font-weight: 300;
            color: #d4af37;
            margin-top: 15px;
        }

        .sponsor-class-146 {
            font-size: 11px;
            color: #888;
            margin-top: 5px;
        }

        .sponsor-class-147 {
            font-size: 13.5px;
            line-height: 1.6;
            color: #ccc;
        }

        .sponsor-class-148 {
            margin-bottom: 15px;
        }

        .sponsor-class-149 {
            padding-left: 20px;
            margin: 0;
        }

        .sponsor-class-150 {
            margin-bottom: 8px;
        }

        .sponsor-class-151 {
            width: 50%;
            padding: 20mm 15mm;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: #fff;
        }

        .sponsor-class-152 {
            font-size: 12px;
            letter-spacing: 3px;
            color: #1a1a1a;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .sponsor-class-153 {
            font-size: 32px;
            font-weight: 800;
            line-height: 1.1;
            margin: 0;
            text-transform: uppercase;
            color: #1a1a1a;
        }

        .sponsor-class-154 {
            font-size: 11px;
            color: #999;
            margin-top: 5px;
        }

        .sponsor-class-155 {
            font-size: 13.5px;
            line-height: 1.6;
            color: #555;
        }

        .sponsor-class-156 {
            padding-left: 20px;
            margin: 0;
            list-style-type: square;
        }

        .sponsor-class-157 {
            position: absolute;
            bottom: 15mm;
            right: 15mm;
            display: flex;
            align-items: center;
            border-top: 1px solid #eee;
            padding-top: 10px;
            width: calc(50% - 30mm);
        }

        .sponsor-class-158 {
            font-size: 10px;
            color: #999;
            font-weight: bold;
        }

        .sponsor-class-159 {
            font-size: 18px;
            color: #1a1a1a;
            font-weight: 900;
        }

        .sponsor-class-160 {
            height: 100%;
            box-sizing: border-box;
            padding: 0;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #1a1a1a;
            color: #ffffff;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .sponsor-class-161 {
            position: absolute;
            top: 0;
            right: 0;
            width: 40%;
            height: 100%;
            background: linear-gradient(to left, rgba(212, 175, 55, 0.1), transparent);
        }

        .sponsor-class-162 {
            position: absolute;
            bottom: -50px;
            left: -50px;
            width: 200px;
            height: 200px;
            border: 2px solid rgba(212, 175, 55, 0.2);
            border-radius: 50%;
        }

        .sponsor-class-163 {
            width: 80%;
            max-width: 800px;
            z-index: 1;
            text-align: center;
        }

        .sponsor-class-164 {
            display: inline-block;
            padding: 5px 20px;
            border: 1px solid #d4af37;
            color: #d4af37;
            font-size: 12px;
            letter-spacing: 4px;
            text-transform: uppercase;
            margin-bottom: 20px;
        }

        .sponsor-class-165 {
            font-size: 52px;
            font-weight: 800;
            line-height: 1;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: -1px;
        }

        .sponsor-class-166 {
            margin: 30px auto;
            width: 100px;
            height: 2px;
            background: #d4af37;
        }

        .sponsor-class-167 {
            font-size: 28px;
            font-weight: 300;
            margin-bottom: 40px;
            color: #fff;
        }

        .sponsor-class-168 {
            font-size: 14px;
            color: #888;
            vertical-align: middle;
            margin-left: 10px;
        }

        .sponsor-class-169 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            text-align: left;
            background: rgba(255, 255, 255, 0.05);
            padding: 30px;
            border-radius: 4px;
            backdrop-filter: blur(10px);
        }

        .sponsor-class-170 {
            color: #d4af37;
            font-size: 20px;
        }

        .sponsor-class-171 {
            font-size: 14px;
            line-height: 1.5;
            color: #ccc;
        }

        .sponsor-class-172 {
            color: #fff;
            display: block;
            margin-bottom: 5px;
        }

        .sponsor-class-173 {
            position: absolute;
            bottom: 15mm;
            left: 15mm;
            right: 15mm;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 15px;
        }

        .sponsor-class-174 {
            font-size: 10px;
            color: #666;
            font-weight: bold;
            letter-spacing: 2px;
        }

        .sponsor-class-175 {
            font-size: 18px;
            color: #d4af37;
            font-weight: 900;
        }

        .sponsor-class-176 {
            background: #f9f9f9;
            border: 1px solid #eee;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .sponsor-class-177 {
            padding: 20px;
        }

        .sponsor-class-178 {
            font-size: 16px;
            color: #1a1a1a;
            margin: 0 0 15px 0;
            border-bottom: 1px solid #d4af37;
            padding-bottom: 10px;
            text-transform: uppercase;
        }

        .sponsor-class-179 {
            font-size: 10px;
            letter-spacing: 1px;
            color: #d4af37;
            font-weight: bold;
        }

        .sponsor-class-180 {
            font-size: 10px;
            letter-spacing: 1px;
            color: #1a1a1a;
            font-weight: bold;
        }

        .sponsor-class-181 {
            font-size: 18px;
            font-weight: 800;
        }

        .sponsor-class-182 {
            margin-bottom: 30px;
            display: flex;
            align-items: baseline;
            justify-content: space-between;
        }

        .sponsor-class-183 {
            font-size: 12px;
            color: #999;
            letter-spacing: 2px;
        }

        .sponsor-class-184 {
            border: 1px solid #eee;
            display: flex;
            flex-direction: column;
            background: #fdfdfd;
        }

        .sponsor-class-185 {
            padding: 20px;
            flex-grow: 1;
        }

        .sponsor-class-186 {
            color: #d4af37;
            font-weight: bold;
            font-size: 10px;
            letter-spacing: 1px;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .sponsor-class-187 {
            font-size: 18px;
            color: #1a1a1a;
            margin: 0 0 15px 0;
            line-height: 1.2;
        }

        .sponsor-class-188 {
            font-size: 13px;
            line-height: 1.6;
            color: #666;
            margin: 0;
        }

        .sponsor-class-189 {
            background: #1a1a1a;
            padding: 15px;
            text-align: center;
        }

        .sponsor-class-190 {
            color: #fff;
            font-size: 16px;
            font-weight: 300;
        }

        .sponsor-class-191 {
            color: #d4af37;
            font-size: 9px;
            font-weight: bold;
            margin-top: 4px;
        }

        .sponsor-class-192 {
            background: #d4af37;
            padding: 15px;
            text-align: center;
        }

        .sponsor-class-193 {
            color: #1a1a1a;
            font-size: 16px;
            font-weight: 800;
        }

        .sponsor-class-194 {
            color: #fff;
            font-size: 9px;
            font-weight: bold;
            margin-top: 4px;
        }

        .sponsor-class-195 {
            font-size: 11px;
            color: #bbb;
            font-weight: bold;
            letter-spacing: 1px;
        }
    </style> <button class="print-btn" onclick="window.print()">Download PDF</button>

    <div class="print-area">

        <div class="page">
            <div class="page-content">
                <div class="sponsor-class-1">

                    <!-- Decorative background element for a "fancy" touch -->
                    <div class="sponsor-class-2">
                    </div>

                    <!-- Decorative Accent -->
                    <div class="sponsor-class-3"></div>

                    <div class="sponsor-class-4">
                        <h2 class="sponsor-class-5">
                            Sponsorship
                        </h2>

                        <h1 class="sponsor-class-6">
                            ADVERTISING<br>
                            <span class="sponsor-class-7">BRANDING &</span><br>
                            MARKETING
                        </h1>

                        <div class="sponsor-class-8">
                        </div>

                        <p class="sponsor-class-9">
                            OPPORTUNITIES
                        </p>

                        <div class="sponsor-class-10">
                            <p class="sponsor-class-11">
                                INDIA’S PREMIER TRAVEL & TOURISM EXHIBITION
                            </p>

                            <a href="https://www.iitmindia.com" class="sponsor-class-12">
                                WWW.IITMINDIA.COM
                            </a>
                        </div>
                    </div>

                    <!-- Bottom Page Indicator for style -->
                    <div class="sponsor-class-13">
                        OFFICIAL PROSPECTUS 2026
                    </div>
                </div>
            </div>
        </div>

        <div class="page">
            <div class="page-content">
                <div class="sponsor-class-75">

                    <!-- Header Section -->
                    <div class="sponsor-class-15">
                        <h2 class="sponsor-class-16">
                            Sponsorship <span class="sponsor-class-17">Opportunities</span>
                        </h2>
                        <div class="sponsor-class-18"></div>
                    </div>

                    <!-- Content Grid: 2 Columns for Landscape -->
                    <div class="sponsor-class-76">

                        <div class="sponsor-class-77">
                            <strong class="sponsor-class-78">
                                Targeted Impact
                            </strong>
                            <p class="sponsor-class-79">
                                Reach a highly specific audience with cost-effective strategies designed for maximum
                                resonance and
                                engagement.
                            </p>
                        </div>

                        <div class="sponsor-class-80">
                            <strong class="sponsor-class-78">
                                Multi-Channel Branding
                            </strong>
                            <p class="sponsor-class-79">
                                Excellent branding opportunities that extend far beyond the booth, reaching quality
                                audiences across
                                various media vehicles.
                            </p>
                        </div>

                        <div class="sponsor-class-77">
                            <strong class="sponsor-class-78">
                                Industry Leadership
                            </strong>
                            <p class="sponsor-class-79">
                                Increase your visibility and solidify your position as an industry leader to your core
                                target
                                demographic.
                            </p>
                        </div>

                        <div class="sponsor-class-80">
                            <strong class="sponsor-class-78">
                                Innovation & Promotion
                            </strong>
                            <p class="sponsor-class-79">
                                Access a diverse range of innovative promotional opportunities tailored to modern
                                marketing needs.
                            </p>
                        </div>

                    </div>

                    <!-- Tailor-made callout spans full width at the bottom -->
                    <div class="sponsor-class-81">
                        <p class="sponsor-class-82">
                            "We tailor-make solutions based on your specific needs and budget constraints."
                        </p>
                    </div>

                    <!-- Footer -->
                    <div class="sponsor-class-32">
                        <span class="sponsor-class-33">www.iitmindia.com</span>
                        <span class="sponsor-class-34">02</span>
                    </div>

                </div>
            </div>
        </div>

        <div class="page">
            <div class="page-content">
                <div class="sponsor-class-83">

                    <!-- Header Section -->
                    <div class="sponsor-class-84">
                        <h2 class="sponsor-class-85">
                            IITM <span class="sponsor-class-17">Sponsorship Options</span>
                        </h2>
                        <p class="sponsor-class-86">
                            Partner with one of the largest Travel & Tourism Exhibitions in India
                        </p>
                        <div class="sponsor-class-87"></div>
                    </div>

                    <!-- Pricing Tiers Grid -->
                    <div class="sponsor-class-88">

                        <!-- PLATINUM PARTNER -->
                        <div class="sponsor-class-89">
                            <div class="sponsor-class-90">
                                <div class="sponsor-class-91">1 SLOT PER CITY
                                </div>
                                <div class="sponsor-class-92">PLATINUM</div>
                                <div class="sponsor-class-93">Rs 25,00,000/-</div>
                            </div>
                            <ul class="sponsor-class-94">
                                <li><strong>Premium Branding:</strong> All marketing collateral (EDMs, Social, Print,
                                    Outdoor, Venue)
                                </li>
                                <li><strong>Press Recognition:</strong> Featured at the official event Press Release
                                </li>
                                <li><strong>Exhibition Space:</strong> 54 Sq Mtrs (6x9 Mtrs) Stall</li>
                                <li><strong>Directory:</strong> 4-Page Advertisement in Event Directory</li>
                                <li><strong>VIP Access:</strong> 12 Networking Lunch & Dinner Passes</li>
                                <li><strong>Exclusive:</strong> Premium slots for MC Announcements</li>
                                <li>Special Acknowledgment at <strong>IITM Awards Night</strong></li>
                            </ul>
                        </div>

                        <!-- GOLD PARTNER -->
                        <div class="sponsor-class-95">
                            <div class="sponsor-class-96">
                                <div class="sponsor-class-97">3 SLOTS PER CITY
                                </div>
                                <div class="sponsor-class-92">GOLD</div>
                                <div class="sponsor-class-93">Rs 15,00,000/-</div>
                            </div>
                            <ul class="sponsor-class-94">
                                <li><strong>Branding Space:</strong> All marketing collateral & Venue Branding</li>
                                <li><strong>Press Recognition:</strong> Recognized at event Press Release</li>
                                <li><strong>Exhibition Space:</strong> 27 Sq Mtrs (3x9 Mtrs) Stall</li>
                                <li><strong>Directory:</strong> 1-Page Advertisement in Event Directory</li>
                                <li><strong>VIP Access:</strong> 8 Networking Lunch & Dinner Passes</li>
                                <li>MC Announcements during the event</li>
                                <li>Special Acknowledgment at <strong>IITM Awards Night</strong></li>
                            </ul>
                        </div>

                        <!-- SILVER PARTNER -->
                        <div class="sponsor-class-98">
                            <div class="sponsor-class-99">
                                <div class="sponsor-class-97">5 SLOTS PER CITY
                                </div>
                                <div class="sponsor-class-92">SILVER</div>
                                <div class="sponsor-class-93">Rs 8,00,000/-</div>
                            </div>
                            <ul class="sponsor-class-94">
                                <li><strong>Branding Space:</strong> Marketing collateral & Venue Branding</li>
                                <li><strong>Exhibition Space:</strong> 12 Sq Mtrs (3x4 Mtrs) Stall</li>
                                <li><strong>Directory:</strong> Quarter-Page Advt (Circulated to 2000+ keys)</li>
                                <li><strong>VIP Access:</strong> 5 Networking Lunch & Dinner Passes</li>
                                <li>MC Announcements during the event</li>
                                <li>Special Acknowledgment at <strong>IITM Awards Night</strong></li>
                            </ul>
                        </div>

                    </div>

                    <!-- Footer -->
                    <div class="sponsor-class-100">
                        <span class="sponsor-class-101">IITM SPONSORSHIP
                            PROSPECTUS</span>
                        <span class="sponsor-class-102">03</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="page">
            <div class="page-content">
                <div class="sponsor-class-103">

                    <!-- Header Section -->
                    <div class="sponsor-class-104">
                        <div>
                            <h2 class="sponsor-class-105">
                                Event <span class="sponsor-class-17">Sponsorships</span>
                            </h2>
                            <p class="sponsor-class-36">Exclusive branding at high-traffic touchpoints
                                and elite gatherings.</p>
                        </div>
                        <div class="sponsor-class-106">IITM 2026 PROSPECTUS</div>
                    </div>

                    <!-- Options Grid -->
                    <div class="sponsor-class-19">

                        <!-- AWARDS FUNCTION -->
                        <div class="sponsor-class-107">
                            <div class="sponsor-class-108">
                                <h3 class="sponsor-class-109">AWARDS FUNCTION</h3>
                                <div class="sponsor-class-110">Rs 15,00,000/-</div>
                            </div>
                            <div class="sponsor-class-111">
                                <p class="sponsor-class-112"><strong>The Opportunity:</strong> Host the biggest
                                    gathering of inbound &
                                    outbound faculty to felicitate key achievers, followed by a cocktail dinner.</p>
                                <ul class="sponsor-class-113">
                                    <li><strong>10-Min Presentation</strong> in front of 250–300 industry leaders</li>
                                    <li><strong>18 Sq Mtrs (3x6)</strong> Exhibition Stall</li>
                                    <li><strong>Ample Branding</strong> on the Event Night</li>
                                    <li>Full marketing collateral branding (EDMs, Social, Print)</li>
                                </ul>
                            </div>
                        </div>

                        <!-- REGISTRATION DESK -->
                        <div class="sponsor-class-107">
                            <div class="sponsor-class-96">
                                <h3 class="sponsor-class-109">REGISTRATION DESK</h3>
                                <div class="sponsor-class-114">Rs 4,00,000/-</div>
                            </div>
                            <div class="sponsor-class-111">
                                <p class="sponsor-class-112"><strong>First Impression:</strong> Position your brand at
                                    the primary point of
                                    contact for every single visitor, exhibitor, and delegate.</p>
                                <ul class="sponsor-class-113">
                                    <li><strong>360° Branding</strong> in the main registration area</li>
                                    <li><strong>9 Sq Mtrs (3x3)</strong> Exhibition Stall</li>
                                    <li>Continuous brand visibility during peak entry hours</li>
                                    <li>Logo inclusion in all Pre & Post Event digital marketing</li>
                                </ul>
                            </div>
                        </div>

                        <!-- NETWORKING DINNER -->
                        <div class="sponsor-class-107">
                            <div class="sponsor-class-108">
                                <h3 class="sponsor-class-109">NETWORKING DINNER</h3>
                                <div class="sponsor-class-110">Rs 15,00,000/-</div>
                            </div>
                            <div class="sponsor-class-111">
                                <p class="sponsor-class-112"><strong>The Network:</strong> Host 250–300 leading tour
                                    operators, hoteliers,
                                    and media in an exclusive networking environment.</p>
                                <div class="sponsor-class-115">
                                    <strong class="sponsor-class-116">Partner
                                        Benefits:</strong>
                                    <ul class="sponsor-class-117">
                                        <li><strong>18 Sq Mtrs</strong> Booth at single location</li>
                                        <li>Branding in all marketing collaterals</li>
                                        <li>High brand recall with Foreign Tour Operators</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Footer -->
                    <div class="sponsor-class-118">
                        <span class="sponsor-class-119">WWW.IITMINDIA.COM</span>
                        <span class="sponsor-class-34">04</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="page">
            <div class="page-content">
                <div class="sponsor-class-120">

                    <!-- Page Header -->
                    <div class="sponsor-class-121">
                        <h2 class="sponsor-class-122">
                            On-Site <span class="sponsor-class-17">Sponsorship</span>
                        </h2>
                        <p class="sponsor-class-36">Maximize your footprint with high-visibility
                            tactical branding across the venue.</p>
                    </div>

                    <!-- On-Site Options Grid -->
                    <div class="sponsor-class-123">

                        <!-- Drop Downs / Hanging Banners -->
                        <div class="sponsor-class-124">
                            <div>
                                <h4 class="sponsor-class-125">Drop Downs
                                    /<br>Hanging Banners</h4>
                                <div class="sponsor-class-126"></div>
                            </div>
                            <div class="sponsor-class-127">Rs 50,000/- <span class="sponsor-class-128">for 3</span>
                            </div>
                        </div>

                        <!-- Temporary Walk-Way Display -->
                        <div class="sponsor-class-129">
                            <div>
                                <h4 class="sponsor-class-125">Temporary
                                    Walk-Way<br>Display Board</h4>
                                <div class="sponsor-class-130"></div>
                            </div>
                            <div class="sponsor-class-127">Rs 50,000/- <span class="sponsor-class-128">for 3</span>
                            </div>
                        </div>

                        <!-- Bill Boards -->
                        <div class="sponsor-class-124">
                            <div>
                                <h4 class="sponsor-class-125">Prominent<br>Bill
                                    Boards</h4>
                                <div class="sponsor-class-126"></div>
                            </div>
                            <div class="sponsor-class-127">Rs 50,000/- <span class="sponsor-class-128">for 3</span>
                            </div>
                        </div>

                        <!-- LED Display -->
                        <div class="sponsor-class-131">
                            <div>
                                <h4 class="sponsor-class-132">LED
                                    Display<br>Branding</h4>
                                <p class="sponsor-class-133">3 Days x 20 spots of 30 sec each</p>
                            </div>
                            <div class="sponsor-class-134">Rs 1,00,000/-</div>
                        </div>

                        <!-- Selfie Counter -->
                        <div class="sponsor-class-129">
                            <div>
                                <h4 class="sponsor-class-125">Selfie
                                    Counter<br>Branding</h4>
                                <div class="sponsor-class-130"></div>
                            </div>
                            <div class="sponsor-class-127">Rs 60,000/- <span class="sponsor-class-128">for 1</span>
                            </div>
                        </div>

                        <!-- B2C Gift -->
                        <div class="sponsor-class-124">
                            <div>
                                <h4 class="sponsor-class-125">B2C Gift<br>Branding
                                </h4>
                                <p class="sponsor-class-135">Large scale reach (25,000 pcs)</p>
                            </div>
                            <div class="sponsor-class-127">Rs 1,50,000/-</div>
                        </div>

                    </div>

                    <!-- Footer -->
                    <div class="sponsor-class-136">
                        <span class="sponsor-class-137">IITM ON-SITE
                            OPPORTUNITIES</span>
                        <div class="sponsor-class-138">
                            <span class="sponsor-class-139">www.iitmindia.com</span>
                            <span class="sponsor-class-102">05</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="page">
            <div class="page-content">
                <div class="sponsor-class-140">

                    <!-- Left Section: Networking Dinner Branding -->
                    <div class="sponsor-class-141">
                        <div class="sponsor-class-142">
                            <div class="sponsor-class-143">
                                Exclusive Event</div>
                            <h2 class="sponsor-class-144">
                                Networking Dinner<br>Branding</h2>
                            <div class="sponsor-class-145">Rs 3,00,000/-</div>
                            <div class="sponsor-class-146">(1 Slot per City)</div>
                        </div>

                        <div class="sponsor-class-147">
                            <p class="sponsor-class-148">Host a "By Invitation Only" function designed to connect you
                                with the upper
                                echelon of the travel trade.</p>
                            <ul class="sponsor-class-149">
                                <li class="sponsor-class-150"><strong class="sponsor-class-7">10-Minute
                                        Presentation:</strong> Introduce
                                    new products directly to industry leaders before dinner.</li>
                                <li class="sponsor-class-150"><strong class="sponsor-class-7">Stage Backdrop:</strong>
                                    Dominant branding
                                    presence throughout the evening.</li>
                                <li class="sponsor-class-150"><strong class="sponsor-class-7">Banner Displays:</strong>
                                    Strategic
                                    placement within the dinner venue for maximum recall.</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Right Section: Help Desk Branding -->
                    <div class="sponsor-class-151">
                        <div class="sponsor-class-142">
                            <div class="sponsor-class-152">
                                Tactical Visibility</div>
                            <h2 class="sponsor-class-153">
                                Help Desk<br>Branding</h2>
                            <div class="sponsor-class-145">Rs 1,00,000/-</div>
                            <div class="sponsor-class-154">(1 Slot per City)</div>
                        </div>

                        <div class="sponsor-class-155">
                            <p class="sponsor-class-148">Capitalize on the highest-traffic service point for every
                                exhibitor,
                                delegate, and VIP guest.</p>
                            <ul class="sponsor-class-156">
                                <li class="sponsor-class-150"><strong class="sponsor-class-52">First Point of
                                        Contact:</strong> Gain
                                    immediate exposure as guests enter the registration zone.</li>
                                <li class="sponsor-class-150"><strong class="sponsor-class-52">Repeat Exposure:</strong>
                                    The Help Desk
                                    is the most revisited location throughout the event days.</li>
                                <li class="sponsor-class-150"><strong class="sponsor-class-52">Prime Location:</strong>
                                    Logo placement
                                    on all help desk signage and scoreboards.</li>
                            </ul>
                        </div>

                        <!-- Pagination & URL -->
                        <div class="sponsor-class-157">
                            <span class="sponsor-class-158">WWW.IITMINDIA.COM</span>
                            <span class="sponsor-class-37"></span>
                            <span class="sponsor-class-159">06</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="page">
            <div class="page-content">
                <div class="sponsor-class-160">

                    <!-- Decorative background texture/accent -->
                    <div class="sponsor-class-161">
                    </div>
                    <div class="sponsor-class-162">
                    </div>

                    <!-- Main Content Container -->
                    <div class="sponsor-class-163">

                        <div class="sponsor-class-164">
                            Elite Networking
                        </div>

                        <h1 class="sponsor-class-165">
                            Interactive <span class="sponsor-class-17">VIP & Media</span> Lounge
                        </h1>

                        <div class="sponsor-class-166"></div>

                        <div class="sponsor-class-167">
                            Rs 3,00,000/- <span class="sponsor-class-168">(1 Slot
                                per City • 3 Days)</span>
                        </div>

                        <!-- Benefits Grid -->
                        <div class="sponsor-class-169">

                            <div class="sponsor-class-65">
                                <div class="sponsor-class-170">✦</div>
                                <div class="sponsor-class-171">
                                    <strong class="sponsor-class-172">Media Dominance</strong>
                                    Pre and post-event coverage from both Local and National Media outlets.
                                </div>
                            </div>

                            <div class="sponsor-class-65">
                                <div class="sponsor-class-170">✦</div>
                                <div class="sponsor-class-171">
                                    <strong class="sponsor-class-172">Executive Presence</strong>
                                    Exclusive 10-minute dedicated interaction session with the media fraternity.
                                </div>
                            </div>

                            <div class="sponsor-class-65">
                                <div class="sponsor-class-170">✦</div>
                                <div class="sponsor-class-171">
                                    <strong class="sponsor-class-172">Brand Immersion</strong>
                                    Immense visibility with company branding throughout the prime lounge area.
                                </div>
                            </div>

                            <div class="sponsor-class-65">
                                <div class="sponsor-class-170">✦</div>
                                <div class="sponsor-class-171">
                                    <strong class="sponsor-class-172">Targeted Access</strong>
                                    By-invitation-only networking designed to add significant brand value.
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="sponsor-class-173">
                        <span class="sponsor-class-174">WWW.IITMINDIA.COM</span>
                        <span class="sponsor-class-175">07</span>
                    </div>

                </div>
            </div>
        </div>

        <div class="page">
            <div class="page-content">
                <div class="sponsor-class-14">

                    <!-- Header -->
                    <div class="sponsor-class-15">
                        <h2 class="sponsor-class-16">
                            Other <span class="sponsor-class-17">Sponsorships</span>
                        </h2>
                        <div class="sponsor-class-18"></div>
                    </div>

                    <!-- Product Grid -->
                    <div class="sponsor-class-19">

                        <!-- Buyers & Sellers Kit Bags -->
                        <div class="sponsor-class-176">
                            <div class="sponsor-class-177">
                                <h3 class="sponsor-class-178">
                                    Buyers & Sellers<br>Kit Bags
                                </h3>
                                <p class="sponsor-class-24">
                                    Your logo will appear on the welcome bags containing essential show information.
                                    Distributed
                                    exclusively to <strong>Sellers, Press, and Buyers</strong>.
                                </p>
                            </div>
                            <div class="sponsor-class-25">
                                <div class="sponsor-class-179">4 SLOTS AVAILABLE
                                </div>
                                <div class="sponsor-class-93">Rs. 1,00,000/-</div>
                            </div>
                        </div>

                        <!-- Lanyard Sponsorship -->
                        <div class="sponsor-class-176">
                            <div class="sponsor-class-177">
                                <h3 class="sponsor-class-178">
                                    Official<br>Lanyards
                                </h3>
                                <p class="sponsor-class-24">
                                    High-visibility branding on the lanyards worn by <strong>all exhibitors, trade
                                        visitors, press,
                                        delegates, and VIPs</strong> for the duration of the event.
                                </p>
                            </div>
                            <div class="sponsor-class-29">
                                <div class="sponsor-class-180">4 SLOTS AVAILABLE
                                </div>
                                <div class="sponsor-class-181">Rs. 75,000/-</div>
                            </div>
                        </div>

                        <!-- Exhibitors Kit -->
                        <div class="sponsor-class-176">
                            <div class="sponsor-class-177">
                                <h3 class="sponsor-class-178">
                                    Exhibitors<br>Kit Bags
                                </h3>
                                <p class="sponsor-class-24">
                                    Show carry bags distributed from the registration area and help desks. Features your
                                    <strong>logo
                                        and message</strong> on every bag.
                                </p>
                            </div>
                            <div class="sponsor-class-25">
                                <div class="sponsor-class-179">4 SLOTS AVAILABLE
                                </div>
                                <div class="sponsor-class-93">Rs. 2,00,000/-</div>
                            </div>
                        </div>

                    </div>

                    <!-- Footer -->
                    <div class="sponsor-class-32">
                        <span class="sponsor-class-33">www.iitmindia.com</span>
                        <span class="sponsor-class-34">08</span>
                    </div>

                </div>
            </div>
        </div>

        <div class="page">
            <div class="page-content">
                <div class="sponsor-class-35">

                    <!-- Header Section -->
                    <div class="sponsor-class-182">
                        <h2 class="sponsor-class-16">
                            Utility <span class="sponsor-class-17">Sponsorships</span>
                        </h2>
                        <span class="sponsor-class-183">BRAND VISIBILITY & UTILITY</span>
                    </div>

                    <!-- Grid Content -->
                    <div class="sponsor-class-19">

                        <!-- Drinking Water -->
                        <div class="sponsor-class-184">
                            <div class="sponsor-class-185">
                                <div class="sponsor-class-186">
                                    Engagement</div>
                                <h3 class="sponsor-class-187">Drinking
                                    Water<br>Bottles</h3>
                                <p class="sponsor-class-188">
                                    A cost-effective means to generate immense goodwill. <strong>5,000 bottles</strong>
                                    distributed to
                                    all exhibitors and featured in the exclusive Buyers' Lounges.
                                </p>
                            </div>
                            <div class="sponsor-class-189">
                                <div class="sponsor-class-190">Rs. 1,00,000/-</div>
                                <div class="sponsor-class-191">ONLY 1 SLOT AVAILABLE
                                </div>
                            </div>
                        </div>

                        <!-- Badges -->
                        <div class="sponsor-class-184">
                            <div class="sponsor-class-185">
                                <div class="sponsor-class-186">
                                    Visibility</div>
                                <h3 class="sponsor-class-187">Official
                                    Event<br>Badges</h3>
                                <p class="sponsor-class-188">
                                    One of the most visible elements. Your logo appears in the <strong>main
                                        section</strong> of badges
                                    worn by all participants, press, delegates, and VIPs.
                                </p>
                            </div>
                            <div class="sponsor-class-192">
                                <div class="sponsor-class-193">Rs. 75,000/-</div>
                                <div class="sponsor-class-194">4 SLOTS AVAILABLE</div>
                            </div>
                        </div>

                        <!-- Exhibitors Directory -->
                        <div class="sponsor-class-184">
                            <div class="sponsor-class-185">
                                <div class="sponsor-class-186">
                                    Legacy</div>
                                <h3 class="sponsor-class-187">
                                    Exhibitors<br>Directory</h3>
                                <p class="sponsor-class-188">
                                    Enormous shelf life as a <strong>Reference Source</strong> for the industry.
                                    Includes a full-page
                                    advertisement for long-lasting post-event visibility.
                                </p>
                            </div>
                            <div class="sponsor-class-189">
                                <div class="sponsor-class-190">Rs. 25,000/-</div>
                                <div class="sponsor-class-191">LOGO ONLY BRANDING
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Footer -->
                    <div class="sponsor-class-32">
                        <span class="sponsor-class-195">IITM SPONSORSHIP PROSPECTUS
                            2026</span>
                        <span class="sponsor-class-34">09</span>
                    </div>

                </div>
            </div>
        </div>

        <div class="page">
            <div class="page-content">
                <div class="sponsor-class-14">

                    <!-- Header Section -->
                    <div class="sponsor-class-15">
                        <h2 class="sponsor-class-16">
                            Tangible <span class="sponsor-class-17">Branding</span>
                        </h2>
                        <div class="sponsor-class-18"></div>
                    </div>

                    <!-- Content Grid -->
                    <div class="sponsor-class-19">

                        <!-- Souvenirs -->
                        <div class="sponsor-class-20">
                            <div class="sponsor-class-21">
                                <div class="sponsor-class-22">
                                    Gift Engagement</div>
                                <h3 class="sponsor-class-23">
                                    Custom<br>Souvenirs</h3>
                                <p class="sponsor-class-24">
                                    Reach trade invitees by gifting a memorable souvenir of your choice. A lasting
                                    physical reminder of
                                    your brand logo and hospitality.
                                </p>
                            </div>
                            <div class="sponsor-class-25">
                                <div class="sponsor-class-26">
                                    4 SLOTS AVAILABLE</div>
                                <div class="sponsor-class-27">Rs. 1,00,000/-</div>
                            </div>
                        </div>

                        <!-- T-Shirts -->
                        <div class="sponsor-class-20">
                            <div class="sponsor-class-21">
                                <div class="sponsor-class-28">
                                    Lifestyle Branding</div>
                                <h3 class="sponsor-class-23">
                                    Official<br>T-Shirts</h3>
                                <p class="sponsor-class-24">
                                    Get your brand featured on 250 custom-made T-Shirts. These high-utility items
                                    provide walking
                                    advertisement throughout the venue and beyond.
                                </p>
                            </div>
                            <div class="sponsor-class-29">
                                <div class="sponsor-class-30">
                                    2 SLOTS AVAILABLE</div>
                                <div class="sponsor-class-31">Rs. 50,000/-</div>
                            </div>
                        </div>

                        <!-- Print Material -->
                        <div class="sponsor-class-20">
                            <div class="sponsor-class-21">
                                <div class="sponsor-class-22">
                                    Direct Outreach</div>
                                <h3 class="sponsor-class-23">Brochure
                                    &<br>Print Insert</h3>
                                <p class="sponsor-class-24">
                                    Ensure your collateral reaches every tour operator and agent. We include your print
                                    materials
                                    directly into the official event kit bags.
                                </p>
                            </div>
                            <div class="sponsor-class-25">
                                <div class="sponsor-class-26">
                                    2 SLOTS AVAILABLE</div>
                                <div class="sponsor-class-27">Rs. 1,00,000/-</div>
                            </div>
                        </div>

                    </div>

                    <!-- Footer -->
                    <div class="sponsor-class-32">
                        <span class="sponsor-class-33">www.iitmindia.com</span>
                        <span class="sponsor-class-34">10</span>
                    </div>

                </div>
            </div>
        </div>

        <div class="page">
            <div class="page-content">
                <div class="sponsor-class-35">

                    <!-- Header Section -->
                    <div class="sponsor-class-15">
                        <h2 class="sponsor-class-16">
                            Directory <span class="sponsor-class-17">Advertising</span>
                        </h2>
                        <p class="sponsor-class-36">Official Exhibition Directory: The definitive
                            industry reference guide.</p>
                    </div>

                    <!-- Rate Card Table -->
                    <div class="sponsor-class-37">
                        <table class="sponsor-class-38">
                            <thead>
                                <tr class="sponsor-class-39">
                                    <th class="sponsor-class-40">
                                        Position / Size</th>
                                    <th class="sponsor-class-40">
                                        Dimensions (WxH)</th>
                                    <th class="sponsor-class-41">
                                        Rate (INR)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="sponsor-class-42">
                                    <td class="sponsor-class-43">Double Spread</td>
                                    <td class="sponsor-class-44">420mm x 297mm</td>
                                    <td class="sponsor-class-45">
                                        2,50,000/-</td>
                                </tr>
                                <tr class="sponsor-class-46">
                                    <td class="sponsor-class-43">Back Cover</td>
                                    <td class="sponsor-class-44">210mm x 297mm</td>
                                    <td class="sponsor-class-47">
                                        1,50,000/-</td>
                                </tr>
                                <tr class="sponsor-class-42">
                                    <td class="sponsor-class-43">Inner Cover (Front/Back)</td>
                                    <td class="sponsor-class-44">210mm x 297mm</td>
                                    <td class="sponsor-class-47">
                                        75,000/-</td>
                                </tr>
                                <tr class="sponsor-class-48">
                                    <td class="sponsor-class-43">Full Page</td>
                                    <td class="sponsor-class-44">210mm x 297mm</td>
                                    <td class="sponsor-class-47">
                                        20,000/-</td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- Technical Note -->
                        <div class="sponsor-class-49">
                            <div class="sponsor-class-50">
                                <p class="sponsor-class-51">
                                    <strong class="sponsor-class-52">Technical Requirement:</strong> All advertisement
                                    artwork must be
                                    provided by the sponsor in high-resolution (300 DPI) print-ready format
                                    (PDF/TIFF/CDR).
                                </p>
                            </div>
                            <div class="sponsor-class-53">
                                *Government Taxes Applicable extra
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="sponsor-class-54">
                        <span class="sponsor-class-33">www.iitmindia.com</span>
                        <span class="sponsor-class-34">11</span>
                    </div>

                </div>
            </div>
        </div>

        <div class="page">
            <div class="page-content">
                <div class="sponsor-class-55">

                    <!-- Left Branding Section -->
                    <div class="sponsor-class-56">
                        <div class="sponsor-class-57">
                            THANK<br>YOU
                        </div>
                        <div class="sponsor-class-58"></div>

                        <!-- Subtle background watermark -->
                        <div class="sponsor-class-59">
                            IITM
                        </div>
                    </div>

                    <!-- Right Contact Section -->
                    <div class="sponsor-class-60">

                        <div class="sponsor-class-61">
                            <h3 class="sponsor-class-62">
                                Organized By</h3>
                            <div class="sponsor-class-63">Sphere Travelmedia & Exhibitions Pvt. Ltd.
                            </div>
                        </div>

                        <div class="sponsor-class-64">
                            <!-- Address -->
                            <div class="sponsor-class-65">
                                <div class="sponsor-class-66">📍</div>
                                <div class="sponsor-class-67">
                                    #245 Amar Jyothi Layout, Bangalore - 560071,<br>
                                    Karnataka, India.
                                </div>
                            </div>

                            <!-- Phone -->
                            <div class="sponsor-class-68">
                                <div class="sponsor-class-66">📞</div>
                                <div class="sponsor-class-69">
                                    Office Tel: <span class="sponsor-class-70">+91 80 40834100</span>
                                </div>
                            </div>

                            <!-- Websites -->
                            <div class="sponsor-class-68">
                                <div class="sponsor-class-66">🌐</div>
                                <div class="sponsor-class-71">
                                    <a href="https://www.spheretravelmedia.com"
                                        class="sponsor-class-72">spheretravelmedia.com</a>
                                    <a href="https://www.iitmindia.com" class="sponsor-class-73">iitmindia.com</a>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Footer Page Numbering -->
                    <div class="sponsor-class-74">
                        12
                    </div>

                </div>
            </div>
        </div>

    </div>

</body>

</html>