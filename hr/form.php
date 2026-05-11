<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Employee | IITM Management</title>
    <style>
        :root {
            --iitm-red: #AA2D2C;
            --bg: #f4f7f6;
            --white: #ffffff;
            --border: #dcdcdc;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--bg);
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: var(--white);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border-top: 5px solid var(--iitm-red);
        }

        h2 {
            color: var(--iitm-red);
            margin-top: 0;
            border-bottom: 1px solid var(--border);
            padding-bottom: 10px;
            text-transform: uppercase;
            font-size: 1.5rem;
        }

        .section-title {
            background: #f9f9f9;
            padding: 10px;
            margin: 20px 0 15px 0;
            font-weight: bold;
            color: #555;
            border-left: 4px solid var(--iitm-red);
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        label {
            font-size: 0.9rem;
            margin-bottom: 5px;
            color: #333;
            font-weight: 600;
        }

        input[type="text"],
        input[type="email"],
        input[type="number"],
        input[type="password"],
        input[type="date"],
        select,
        textarea {
            padding: 10px;
            border: 1px solid var(--border);
            border-radius: 6px;
            font-size: 0.95rem;
            outline: none;
            transition: border-color 0.3s;
        }

        input:focus {
            border-color: var(--iitm-red);
        }

        textarea {
            height: 80px;
            resize: vertical;
        }

        .file-input {
            background: #fcfcfc;
            padding: 5px;
        }

        .btn-submit {
            background-color: var(--iitm-red);
            color: white;
            padding: 15px 40px;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            margin-top: 30px;
            width: 100%;
            transition: opacity 0.3s;
        }

        .btn-submit:hover {
            opacity: 0.9;
        }

        @media (max-width: 600px) {
            .grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Employee Registration Form</h2>

        <form action="store.php" method="POST" enctype="multipart/form-data">

            <div class="section-title">Basic Information</div>
            <div class="grid">
                <div class="form-group">
                    <label>Full Name *</label>
                    <input type="text" name="name" required placeholder="John Doe">
                </div>
                <div class="form-group">
                    <label>Employee ID</label>
                    <input type="number" name="employee_id" placeholder="IITM-001">
                </div>
                <div class="form-group">
                    <label>Email Address *</label>
                    <input type="email" name="email" required placeholder="email@example.com">
                </div>
                <div class="form-group">
                    <label>Password *</label>
                    <input type="password" name="password" required>
                </div>
                <div class="form-group">
                    <label>User Type</label>
                    <select name="user_type">
                        <option value="employee">Employee</option>
                        <option value="admin">Admin</option>
                        <option value="manager">Manager</option>
                    </select>
                </div>
            </div>

            <div class="section-title">Employment Details</div>
            <div class="grid">
                <div class="form-group">
                    <label>Designation</label>
                    <input type="text" name="designation">
                </div>
                <div class="form-group">
                    <label>Department</label>
                    <input type="text" name="department">
                </div>
                <div class="form-group">
                    <label>Category</label>
                    <input type="text" name="category" placeholder="e.g. Permanent, Contract">
                </div>
                <div class="form-group">
                    <label>Date of Joining</label>
                    <input type="date" name="doj">
                </div>
            </div>

            <div class="section-title">Personal & Statutory Details</div>
            <div class="grid">
                <div class="form-group">
                    <label>Father's Name</label>
                    <input type="text" name="fathers_name">
                </div>
                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="text" name="phone">
                </div>
                <div class="form-group">
                    <label>Aadhaar Number</label>
                    <input type="text" name="aadhaar_card">
                </div>
                <div class="form-group">
                    <label>PAN Card Number</label>
                    <input type="text" name="pan_card">
                </div>
                <div class="form-group">
                    <label>UAN Number</label>
                    <input type="text" name="uan_no">
                </div>
                <div class="form-group">
                    <label>Bank Account Number</label>
                    <input type="text" name="bank_account_number">
                </div>
                <div class="form-group">
                    <label>IFSC Code</label>
                    <input type="text" name="ifsc_code">
                </div>
                <div class="form-group" style="grid-column: span 1;">
                    <label>Address</label>
                    <textarea name="address"></textarea>
                </div>
            </div>

            <div class="section-title">Document Uploads (Files)</div>
            <div class="grid">
                <div class="form-group">
                    <label>Resume</label>
                    <input type="file" name="resume_file" class="file-input">
                </div>
                <div class="form-group">
                    <label>Offer Letter</label>
                    <input type="file" name="offerletter_file" class="file-input">
                </div>
                <div class="form-group">
                    <label>Aadhaar Front</label>
                    <input type="file" name="aadhaar_front" class="file-input">
                </div>
                <div class="form-group">
                    <label>Aadhaar Back</label>
                    <input type="file" name="aadhaar_back" class="file-input">
                </div>
                <div class="form-group">
                    <label>PAN Card Copy</label>
                    <input type="file" name="pan_card_file" class="file-input">
                </div>
            </div>

            <div class="section-title">Additional Documents</div>
            <div class="grid">
                <?php for ($i = 1; $i <= 4; $i++): ?>
                    <div class="form-group">
                        <label>Document
                            <?php echo $i; ?> Name
                        </label>
                        <input type="text" name="document_<?php echo $i; ?>_name" placeholder="e.g. Degree Certificate">
                        <label style="margin-top:5px">File</label>
                        <input type="file" name="document_<?php echo $i; ?>_file" class="file-input">
                    </div>
                <?php endfor; ?>
            </div>

            <div class="section-title">Remarks / Journal</div>
            <div class="form-group">
                <textarea name="journal" placeholder="Internal notes..."></textarea>
            </div>

            <button type="submit" class="btn-submit">SAVE EMPLOYEE DATA</button>

        </form>
    </div>

</body>

</html>