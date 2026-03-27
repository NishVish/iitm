<?php
$conn = new mysqli("localhost", "root", "", "tempdatabase");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = $_POST['name'] ?? '';
$companyname = $_POST['companyname'] ?? '';
$mobilenumber = $_POST['mobilenumber'] ?? '';
$emailid = $_POST['emailid'] ?? '';
$city = $_POST['city'] ?? '';

// Insert into DB
$stmt = $conn->prepare("INSERT INTO registrations (name, companyname, mobilenumber, emailid, city) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $name, $companyname, $mobilenumber, $emailid, $city);

$is_success = false;
if ($stmt->execute()) {
    $is_success = true;
} 

$stmt->close();
$conn->close();

$mobile = htmlspecialchars($mobilenumber);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Successful</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-color: #f3f4f6;
            --card-bg: #ffffff;
            --text-main: #111827;
            --text-muted: #6b7280;
            --primary-accent: #8b5cf6; /* Modern Purple */
            --success-green: #10b981;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 1.5rem;
            text-align: center;
        }

        .card {
            background: var(--card-bg);
            border-radius: 28px;
            padding: 3rem 2rem;
            width: 100%;
            max-width: 480px;
            /* Multi-layered shadow for a "premium" lifted look */
            box-shadow: 
                0 10px 15px -3px rgba(0, 0, 0, 0.05),
                0 4px 6px -2px rgba(0, 0, 0, 0.03),
                0 20px 25px -5px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(0, 0, 0, 0.05);
            animation: fadeIn 0.6s ease-out;
        }

        .icon-badge {
            width: 72px;
            height: 72px;
            margin: 0 auto 1.5rem;
            background: #ecfdf5; /* Very light green */
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .icon-badge svg {
            width: 36px;
            height: 36px;
            color: var(--success-green);
        }

        h1 {
            font-size: 1.85rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: var(--text-main);
        }

        p {
            color: var(--text-muted);
            font-size: 1.05rem;
            margin-bottom: 2rem;
        }

        .info-container {
            background: #f9fafb;
            border: 1.5px dashed #e5e7eb;
            border-radius: 20px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .info-label {
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
            color: var(--text-muted);
            margin-bottom: 0.75rem;
        }
        
        .mobile-display {
            color: var(--primary-accent); 
            font-size: 2rem;
            font-weight: 700;
            display: block;
        }

        .btn-secondary {
            display: inline-block;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 500;
            padding: 12px 24px;
            border-radius: 12px;
            transition: all 0.2s;
            border: 1px solid #e5e7eb;
        }

        .btn-secondary:hover, .btn-secondary:active {
            background: #f9fafb;
            color: var(--text-main);
            border-color: #d1d5db;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 480px) {
            .card { padding: 2.5rem 1.25rem; }
            h1 { font-size: 1.6rem; }
            .mobile-display { font-size: 1.75rem; }
        }
    </style>
</head>
<body>

   <div class="card">
        <div class="icon-badge">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>
        </div>
        
        <h1>All set!</h1>
        <p>Registration confirmed for:</p>
        
        <h2 style="font-size: 1.5rem; color: var(--text-main); margin-bottom: 0.25rem;">
            <?php echo htmlspecialchars($name); ?>
        </h2>
        <div style="color: var(--primary-accent); font-weight: 600; margin-bottom: 2rem; text-transform: uppercase; font-size: 0.9rem; letter-spacing: 0.5px;">
            <?php echo htmlspecialchars($companyname); ?>
        </div>
        
        <div class="info-container">
            <span class="info-label">Check-in Number</span>
            <span class="mobile-display"><?php echo $mobile; ?></span>
        </div>
        
        <a href="form.php" class="btn-secondary">
            Register Another
        </a>
    </div>
</body>
</html>