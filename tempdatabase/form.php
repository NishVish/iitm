<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Contact Information</title>

<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600&display=swap" rel="stylesheet">

<style>
/* 1. Global Reset for consistent sizing */
* {
    box-sizing: border-box;
}

body {
    font-family: 'Outfit', sans-serif;
    background: #f9fafb;
    margin: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    padding: 20px; /* Prevents container touching screen edges */
}

/* Container */
.form-container {
    background: #ffffff;
    padding: 2rem;
    border-radius: 14px;
    width: 100%;
    max-width: 420px;
    border: 1px solid #e5e7eb;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

/* Header */
.form-header {
    text-align: center;
    margin-bottom: 1.8rem;
}

.logo {
    width: 110px;
    height: auto;
    margin-bottom: 10px;
}

.form-header h2 {
    margin: 0;
    color: #111827;
    font-size: 1.5rem;
}

.form-header p {
    color: #6b7280;
    font-size: 14px;
    margin-top: 5px;
}

/* Inputs */
.input-group {
    margin-bottom: 1rem;
}

input {
    width: 100%;
    padding: 14px; /* Slightly larger for easier tapping */
    border-radius: 8px;
    border: 1px solid #d1d5db;
    background: #ffffff;
    font-size: 16px; /* 16px prevents iOS auto-zoom on focus */
    transition: border-color 0.2s;
    -webkit-appearance: none; /* Removes iOS default styling */
}

input:focus {
    outline: none;
    border-color: #8b5cf6;
    box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
}

/* Button */
button {
    width: 100%;
    padding: 14px;
    border: none;
    border-radius: 8px;
    background: #8b5cf6;
    color: white;
    font-weight: 600;
    font-size: 16px;
    cursor: pointer;
    transition: background 0.2s;
    -webkit-tap-highlight-color: transparent;
}

button:active {
    background: #7c3aed;
    transform: scale(0.98); /* Feedback for touch */
}

/* Mobile Specific Adjustments */
@media (max-width: 480px) {
    .form-container {
        padding: 1.5rem;
        border: none; /* Cleaner look on small screens */
        box-shadow: none;
        background: transparent;
    }
    
    body {
        background: #ffffff; /* Match container for seamless feel */
        align-items: flex-start; /* Better for long forms on short screens */
        padding-top: 40px;
    }
}
</style>
</head>

<body>

<div class="form-container">
    <header class="form-header">
        <img src="logo.png" alt="Logo" class="logo">
        <h2>Let's Connect</h2>
        <p>Enter your details below</p>
    </header>

    <form method="POST" action="thankx.php">
        <div class="input-group">
            <input type="text" name="name" placeholder="Full Name" required autocomplete="name">
        </div>

        <div class="input-group">
            <input type="text" name="companyname" placeholder="Company Name" required>
        </div>

        <div class="input-group">
            <input type="tel" name="mobilenumber" placeholder="Mobile Number" required autocomplete="tel">
        </div>

        <div class="input-group">
            <input type="email" name="emailid" placeholder="Email Address" required autocomplete="email">
        </div>

        <div class="input-group">
            <input type="text" name="city" placeholder="City" required>
        </div>

        <button type="submit">Submit Details</button>
    </form>
</div>

</body>
</html>