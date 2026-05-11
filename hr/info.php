<?php
include("connection.php");

$id = $_GET['id'] ?? 0;
$id = (int) $id;

$user = $conn->query("SELECT * FROM users WHERE id=$id")->fetch_assoc();

if (!$user) {
    die("<div style='padding:50px; text-align:center; font-family:sans-serif;'>
            <h2 style='color:#AA2D2C;'>User Not Found</h2>
            <a href='index.php'>Go Back</a>
         </div>");
}

function renderFilePreview($file, $label)
{
    if (!$file)
        return "<p style='font-size:0.8rem; color:#888;'>No file currently uploaded</p>";
    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));

    // Just a small thumbnail for the edit view
    if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
        return "<div class='doc-preview'><img src='$file' style='height:60px; width:auto; display:block; margin-bottom:5px;'></div>";
    }
    return "<p style='font-size:0.8rem; color: #AA2D2C;'>Existing File: " . basename($file) . "</p>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Profile | <?= htmlspecialchars($user['name']) ?></title>
    <style>
        :root {
            --iitm-red: #AA2D2C;
            --bg: #f4f7f6;
            --white: #ffffff;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: var(--bg);
            margin: 0;
            padding: 20px;
            color: #333;
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
            background: var(--white);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
        }

        .profile-header {
            background: var(--iitm-red);
            color: white;
            padding: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .content-padding {
            padding: 30px;
        }

        .section-title {
            color: var(--iitm-red);
            border-bottom: 2px solid #eee;
            padding-bottom: 8px;
            margin: 30px 0 15px;
            font-size: 1.1rem;
            text-transform: uppercase;
            font-weight: bold;
        }

        /* Form Styling */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .info-item {
            padding: 10px 0;
        }

        .info-label {
            font-size: 0.8rem;
            color: #888;
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        input[type="number"],
        input[type="date"],
        select,
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            font-family: inherit;
        }

        textarea {
            height: 80px;
        }

        .doc-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
            gap: 20px;
        }

        .doc-card {
            border: 1px solid #eee;
            border-radius: 8px;
            padding: 15px;
            background: #fafafa;
        }

        .btn-save {
            background: #28a745;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 4px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
        }

        .btn-save:hover {
            background: #218838;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="profile-header">
            <div>
                <h2>Edit User: <?= htmlspecialchars($user['name']) ?></h2>
                <span>System Update Mode | ID: <?= $user['id'] ?></span>
            </div>
            <a href="index.php" style="color:white; text-decoration:none; font-weight:bold;">← Cancel &
                Exit</a>
        </div>

        <form action="edit.php?id=<?= $id ?>" method="POST" enctype="multipart/form-data">

            <div class="content-padding">

                <div class="section-title">Core Identity</div>
                <div class="info-grid">
                    <div class="info-item">
                        <label class="info-label">Full Name</label>
                        <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>
                    </div>
                    <div class="info-item">
                        <label class="info-label">Employee ID</label>
                        <input type="number" name="employee_id" value="<?= htmlspecialchars($user['employee_id']) ?>">
                    </div>
                    <div class="info-item">
                        <label class="info-label">User Type / Role</label>
                        <select name="user_type">
                            <option value="user" <?= $user['user_type'] == 'user' ? 'selected' : '' ?>>User</option>
                            <option value="admin" <?= $user['user_type'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                        </select>
                    </div>
                    <div class="info-item">
                        <label class="info-label">New Password (Leave blank to keep current)</label>
                        <input type="text" name="password" placeholder="********">
                    </div>
                </div>

                <div class="section-title">Personal & Contact Details</div>
                <div class="info-grid">
                    <div class="info-item">
                        <label class="info-label">Email Address</label>
                        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                    </div>
                    <div class="info-item">
                        <label class="info-label">Phone Number</label>
                        <input type="text" name="phone" value="<?= htmlspecialchars($user['phone']) ?>">
                    </div>
                    <div class="info-item">
                        <label class="info-label">Father's Name</label>
                        <input type="text" name="fathers_name" value="<?= htmlspecialchars($user['fathers_name']) ?>">
                    </div>
                    <div class="info-item">
                        <label class="info-label">Residential Address</label>
                        <textarea name="address"><?= htmlspecialchars($user['address']) ?></textarea>
                    </div>
                </div>

                <div class="section-title">Employment & Statutory</div>
                <div class="info-grid">
                    <div class="info-item"><label class="info-label">Designation</label><input type="text"
                            name="designation" value="<?= htmlspecialchars($user['designation']) ?>"></div>
                    <div class="info-item"><label class="info-label">Department</label><input type="text"
                            name="department" value="<?= htmlspecialchars($user['department']) ?>"></div>
                    <div class="info-item"><label class="info-label">Category</label><input type="text" name="category"
                            value="<?= htmlspecialchars($user['category']) ?>"></div>
                    <div class="info-item"><label class="info-label">Date of Joining</label><input type="date"
                            name="doj" value="<?= $user['doj'] ?>"></div>
                    <div class="info-item"><label class="info-label">Aadhaar Card Number</label><input type="text"
                            name="aadhaar_card" value="[Aadhaar Redacted]"></div>
                    <div class="info-item"><label class="info-label">PAN Card Number</label><input type="text"
                            name="pan_card" value="<?= htmlspecialchars($user['pan_card']) ?>"></div>
                    <div class="info-item"><label class="info-label">UAN Number</label><input type="text" name="uan_no"
                            value="<?= htmlspecialchars($user['uan_no']) ?>"></div>
                    <div class="info-item"><label class="info-label">Bank Account Number</label><input type="text"
                            name="bank_account_number" value="<?= htmlspecialchars($user['bank_account_number']) ?>">
                    </div>
                    <div class="info-item"><label class="info-label">IFSC Code</label><input type="text"
                            name="ifsc_code" value="<?= htmlspecialchars($user['ifsc_code']) ?>"></div>
                </div>

                <style>
                    /* Styling for the showcase/edit hybrid */
                    .doc-grid {
                        display: grid;
                        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
                        gap: 20px;
                        margin-bottom: 30px;
                    }

                    .doc-card {
                        background: #fff;
                        border: 1px solid #e0e0e0;
                        border-radius: 12px;
                        padding: 15px;
                        display: flex;
                        flex-direction: column;
                        transition: box-shadow 0.3s;
                    }

                    .doc-card:hover {
                        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
                    }

                    .info-label {
                        font-weight: bold;
                        color: #555;
                        font-size: 0.85rem;
                        margin-bottom: 10px;
                        display: block;
                        text-transform: uppercase;
                    }

                    /* The Showcase Window */
                    .showcase-box {
                        background: #fdfdfd;
                        border: 1px dashed #ccc;
                        border-radius: 8px;
                        margin-bottom: 15px;
                        padding: 10px;
                        min-height: 150px;
                        display: flex;
                        flex-direction: column;
                        align-items: center;
                        justify-content: center;
                        overflow: hidden;
                    }

                    .showcase-box img {
                        max-width: 100%;
                        max-height: 130px;
                        border-radius: 4px;
                        object-fit: contain;
                    }

                    .showcase-box iframe {
                        width: 100%;
                        height: 130px;
                        border: none;
                    }

                    /* The Edit Input */
                    .file-upload-wrapper {
                        background: #f1f1f1;
                        padding: 8px;
                        border-radius: 6px;
                        font-size: 0.8rem;
                    }

                    .file-upload-wrapper input[type="file"] {
                        width: 100%;
                    }

                    .btn-save {
                        background-color: #AA2D2C;
                        color: white;
                        padding: 16px 60px;
                        border: none;
                        border-radius: 50px;
                        font-size: 1rem;
                        font-weight: bold;
                        cursor: pointer;
                        transition: 0.3s;
                        box-shadow: 0 4px 10px rgba(170, 45, 44, 0.3);
                    }

                    .btn-save:hover {
                        background-color: #8a2423;
                        transform: translateY(-2px);
                    }
                </style>

                <div class="section-title">Primary Documents (View & Update)</div>
                <div class="doc-grid">
                    <?php
                    $files = [
                        "resume_file" => "Resume / CV",
                        "offerletter_file" => "Offer Letter",
                        "aadhaar_front" => "Aadhaar Front",
                        "aadhaar_back" => "Aadhaar Back",
                        "pan_card_file" => "PAN Card"
                    ];

                    foreach ($files as $name => $label): ?>
                        <div class="doc-card">
                            <label class="info-label">
                                <?= $label ?>
                            </label>

                            <div class="showcase-box">
                                <?php if (!empty($user[$name])): ?>
                                    <?= renderFile($user[$name]) ?> <a href="<?= $user[$name] ?>" target="_blank"
                                        style="font-size: 0.7rem; color: #AA2D2C; margin-top: 5px; text-decoration: none;">View
                                        Full Size</a>
                                <?php else: ?>
                                    <span style="color: #bbb; font-style: italic; font-size: 0.8rem;">No file currenty on
                                        record</span>
                                <?php endif; ?>
                            </div>

                            <div class="file-upload-wrapper">
                                <input type="file" name="<?= $name ?>">
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="section-title">Other Attachments</div>
                <div class="doc-grid">
                    <?php for ($i = 1; $i <= 4; $i++): ?>
                        <div class="doc-card">
                            <label class="info-label">Extra Document
                                <?= $i ?>
                            </label>

                            <input type="text" name="document_<?= $i ?>_name"
                                value="<?= htmlspecialchars($user["document_{$i}_name"]) ?>"
                                placeholder="Enter document name..."
                                style="margin-bottom: 10px; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">

                            <div class="showcase-box">
                                <?php if (!empty($user["document_{$i}_file"])): ?>
                                    <?= renderFile($user["document_{$i}_file"]) ?>
                                <?php else: ?>
                                    <span style="color: #bbb; font-size: 0.8rem;">Empty Slot</span>
                                <?php endif; ?>
                            </div>

                            <div class="file-upload-wrapper">
                                <input type="file" name="document_<?= $i ?>_file">
                            </div>
                        </div>
                    <?php endfor; ?>
                </div>
                <?php
                function renderFile($filePath)
                {
                    if (empty($filePath))
                        return '';

                    // Get the file extension
                    $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

                    // Define supported image types
                    $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

                    if (in_array($extension, $imageExtensions)) {
                        // Return an image preview
                        return '<img src="' . htmlspecialchars($filePath) . '" style="max-width: 100%; max-height: 100px; display: block; border-radius: 4px; margin-bottom: 5px;" alt="File Preview">';
                    } elseif ($extension === 'pdf') {
                        // Return a PDF icon or text
                        return '<div style="font-size: 2rem; color: #AA2D2C;"><i class="fa fa-file-pdf"></i> PDF</div>';
                    } else {
                        // Return a generic file icon or name
                        return '<div style="font-size: 0.8rem; color: #666;">View Document</div>';
                    }
                }
                ?>
                <div class="section-title">Internal Journal / Notes</div>
                <textarea name="journal"
                    style="width:100%; height:120px; border:1px solid #ddd; border-left: 5px solid #ffc107; padding:15px; border-radius: 8px; box-sizing:border-box; font-family: inherit;"><?= htmlspecialchars($user['journal']) ?></textarea>

                <div style="margin: 50px 0; text-align: center;">
                    <button type="submit" class="btn-save">💾 SAVE ALL CHANGES</button>
                </div>


            </div>
        </form>
    </div>

</body>

</html>