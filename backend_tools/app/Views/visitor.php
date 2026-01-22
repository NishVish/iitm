<!DOCTYPE html>
<html>
<head>
    <title>Visitor Details</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        table, th, td {
            border: 1px solid #333;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #eee;
        }
    </style>
</head>
<body>
    <h1>Visitor Details</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Person Key</th>
            <th>Name</th>
            <th>Designation</th>
            <th>Company Name</th>
            <th>Category</th>
            <th>Address</th>
            <th>City</th>
            <th>PIN</th>
            <th>State</th>
            <th>Mobile</th>
            <th>Email</th>
            <th>Created At</th>
        </tr>

        <?php foreach($visitors as $visitor): ?>
        <tr>
            <td><?= $visitor['id'] ?></td>
            <td><?= $visitor['person_key'] ?></td>
            <td><?= $visitor['name'] ?></td>
            <td><?= $visitor['designation'] ?></td>
            <td><?= $visitor['company_name'] ?></td>
            <td><?= $visitor['category'] ?></td>
            <td><?= $visitor['address'] ?></td>
            <td><?= $visitor['city'] ?></td>
            <td><?= $visitor['pin'] ?></td>
            <td><?= $visitor['state'] ?></td>
            <td><?= $visitor['mobile'] ?></td>
            <td><?= $visitor['email'] ?></td>
            <td><?= $visitor['created_at'] ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
