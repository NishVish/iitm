<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Mass Mail Table</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
        }

        h2 {
            margin-bottom: 20px;
        }

        select,
        button,
        textarea {
            padding: 10px;
            margin-top: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 10px;
        }

        th {
            background: #f4f4f4;
        }

        textarea {
            width: 100%;
            height: 120px;
        }

        .btn {
            background: #2d6cdf;
            color: white;
            border: none;
            cursor: pointer;
        }

        .btn:hover {
            background: #1b4fb3;
        }
    </style>
</head>

<body>

    <h2>Mass Mail Sender</h2>

    <form method="GET" action="{{ url('/mass-mail') }}">
        @csrf

        <!-- TEMPLATE -->
        <label>Template</label>
        <select name="template_id" value="Helo" required>
            <option value="welcome">Welcome</option>
            <option value="promo" selected>Promo</option>
            <option value="reminder">Reminder</option>
        </select>

        <!-- PASTE AREA -->
        <label>Paste Data (Name + Email)</label>
        <textarea id="pasteBox" placeholder="Name    email@example.com"></textarea>

        <button type="button" class="btn" onclick="generateTable()">Generate Table</button>

        <!-- TABLE -->
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Emails</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="tableBody"></tbody>
        </table>

        <br>
        <button type="submit" class="btn">Send Mass Mail</button>

    </form>

    <script>
        function generateTable() {
            const input = document.getElementById("pasteBox").value.trim();
            const lines = input.split("\n");

            const tbody = document.getElementById("tableBody");
            tbody.innerHTML = "";

            lines.forEach((line, index) => {
                if (!line.trim()) return;

                const parts = line.split(/\t+|\s{2,}/);
                const name = parts[0] ? parts[0].trim() : "";
                const email = parts[1] ? parts[1].trim() : "";

                const row = `
      <tr>
        <td>
          <input type="text" name="name[]" value="${name}">
        </td>
        <td>
          <input type="text" name="emails[]" value="${email}">
        </td>
        <td>
          <button type="button" onclick="this.closest('tr').remove()">Delete</button>
        </td>
      </tr>
    `;

                tbody.insertAdjacentHTML("beforeend", row);
            });
        }
    </script>

</body>

</html>