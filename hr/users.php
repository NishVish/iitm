<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Employee Directory | IITM</title>
    <style>
        :root {
            --iitm-red: #AA2D2C;
            --iitm-dark: #2c3e50;
            --bg: #f8f9fa;
            --white: #ffffff;
        }

        body {
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: var(--bg);
            margin: 0;
            padding: 40px 20px;
        }

        .dashboard-card {
            max-width: 1100px;
            margin: 0 auto;
            background: var(--white);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            border-top: 6px solid var(--iitm-red);
        }

        /* Header Area */
        .header-flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 25px 30px;
            background: #fff;
            border-bottom: 1px solid #eee;
        }

        .header-flex h2 {
            margin: 0;
            color: var(--iitm-dark);
            font-size: 1.6rem;
            letter-spacing: -0.5px;
        }

        /* Button Styling */
        .btn-add {
            background-color: var(--iitm-red);
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: bold;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(170, 45, 44, 0.2);
        }

        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(170, 45, 44, 0.3);
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
        }

        thead {
            background-color: #fcfcfc;
        }

        th {
            text-align: left;
            padding: 18px 30px;
            font-size: 0.85rem;
            text-transform: uppercase;
            color: #888;
            letter-spacing: 1px;
            border-bottom: 2px solid #eee;
        }

        td {
            padding: 15px 30px;
            border-bottom: 1px solid #f1f1f1;
            color: var(--iitm-dark);
            font-size: 0.95rem;
        }

        tr:hover {
            background-color: #f9f9f9;
        }

        /* Action Link Styling */
        .action-links a {
            text-decoration: none;
            font-weight: 600;
            font-size: 0.85rem;
            padding: 6px 12px;
            border-radius: 5px;
            margin-right: 5px;
            display: inline-block;
        }

        .view-link {
            color: #004a99;
            background: rgba(0, 74, 153, 0.05);
        }

        .view-link:hover {
            background: rgba(0, 74, 153, 0.1);
        }

        .delete-link {
            color: var(--iitm-red);
            background: rgba(170, 45, 44, 0.05);
        }

        .delete-link:hover {
            background: rgba(170, 45, 44, 0.1);
        }

        /* Status Badge Idea */
        .id-badge {
            background: #eee;
            padding: 4px 8px;
            border-radius: 4px;
            font-family: monospace;
            font-weight: bold;
            color: #555;
        }

        .empty-state {
            padding: 50px;
            text-align: center;
            color: #aaa;
        }
    </style>
</head>

<body>

    <div class="dashboard-card">
        <div class="header-flex">
            <h2>Employee Directory</h2>
            <a href="create.php" class="btn-add">+ Register New User</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Email Address</th>
                    <th>Phone</th>
                    <th style="text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $conn->query("SELECT id, name, email, phone FROM users ORDER BY id DESC");

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td><span class='id-badge'>#{$row['id']}</span></td>
                            <td><strong>" . htmlspecialchars($row['name']) . "</strong></td>
                            <td>" . htmlspecialchars($row['email']) . "</td>
                            <td>" . htmlspecialchars($row['phone']) . "</td>
                            <td class='action-links' style='text-align: center;'>
                                <a href='info.php?id={$row['id']}' class='view-link'>View Profile</a>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' class='empty-state'>No users found in the system.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <div style="text-align: center; margin-top: 20px; color: #bbb; font-size: 0.8rem;">
        IITM Management System Portal &bull; Internal Use Only
    </div>

</body>

</html>