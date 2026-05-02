<!DOCTYPE html>
<html>

<head>
    <title>Search</title>
    <style>
        body {
            font-family: Arial;
            padding: 20px;
        }

        input {
            padding: 8px;
            width: 300px;
        }

        button {
            padding: 8px 12px;
            cursor: pointer;
        }

        .section {
            margin-top: 30px;
        }

        .card {
            border: 1px solid #ddd;
            padding: 10px;
            margin-top: 10px;
            border-radius: 6px;
        }
    </style>
</head>

<body>
    <form action="{{ route('backend.search') }}" method="get">
        <input type="text" name="q" placeholder="Search by email, phone, or name">
        <button type="submit">Search</button>
    </form>
    auto




    <h2>Search Contacts & Leads</h2>

    <input type="text" id="searchInput" placeholder="Email, phone, name, company..." />
    <button onclick="searchAll()">Search</button>

    <div class="section">
        <h3>Main Results</h3>
        <div id="mainResults"></div>
    </div>

    <div class="section">
        <h3>Lead Results</h3>
        <div id="leadResults"></div>
    </div>

    <script>
        function renderResults(containerId, results) {
            let container = document.getElementById(containerId);
            container.innerHTML = '';

            if (!results.length) {
                container.innerHTML = '<p>No results found</p>';
                return;
            }

            results.forEach(item => {
                let card = `
        <div class="card">
            <strong>Name:</strong> ${item.name ?? 'N/A'} <br>
            <strong>Email:</strong> ${item.email ?? 'N/A'} <br>
            <strong>Mobile:</strong> ${item.mobile ?? 'N/A'} <br>
            <strong>Company Name:</strong> ${item.company_name ?? 'N/A'} <br>
            <strong>Company ID:</strong> ${item.company_id ?? 'N/A'} <br>
            <strong>Contact ID:</strong> ${item.contact_id ?? 'N/A'} <br>

            <button onclick='openLeadForm(${JSON.stringify(item)})'>
                ➕ Create Lead
            </button>
        </div>
        `;
                container.innerHTML += card;
            });
        }

        function searchAll() {
            let query = document.getElementById('searchInput').value;

            if (!query) {
                alert('Enter something');
                return;
            }

            // 🔎 MAIN SEARCH
            fetch(`{{ url('backend/search') }}?q=${encodeURIComponent(query)}`)
                .then(res => res.json())
                .then(data => {
                    renderResults('mainResults', data.results);

                })
                .catch(err => console.error(err));
            // console.log(data.results);

            // 🔎 LEADS SEARCH
            fetch(`{{ url('backend/searchleads') }}?q=${encodeURIComponent(query)}`)
                .then(res => res.json())
                .then(data => {
                    renderResults('leadResults', data.results);
                })
                .catch(err => console.error(err));
        }
        // console.log(data.results);


        // 🔥 optional: press Enter to search
        document.getElementById('searchInput').addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                searchAll();
            }
        });
    </script>

    <form method="POST" action="{{ url('backend/createlead') }}">
        @csrf

        <div id="leadFormContainer" style="display:none; margin-top:30px; border:1px solid #ccc; padding:15px;">
            <h3>Create / Edit Lead</h3>

            <input type="text" name="contact_id" id="contact_id">
            <input type="text" name="company_id" id="company_id">

            <label>Company</label><br>
            <input type="text" name="company_name" id="company_name"><br><br>

            <label>Name</label><br>
            <input type="text" name="name" id="name"><br><br>
            <label>exhibition_year</label><br>
            <input type="text" name="exhibition_year" id="exhibition_year"><br><br>

            <label>Email</label><br>
            <input type="email" name="email" id="email"><br><br>

            <label>Mobile</label><br>
            <input type="text" name="mobile" id="mobile"><br><br>

            <label>Exhibitor</label><br>
            <input type="text" name="exhibitor" id="exhibitor"><br><br>

            <label>Stall Locations</label><br>

            <div id="stallContainer">
                <div class="stallRow">
                    <input type="text" name="stall_location[]" placeholder="Stall Location">
                    <input type="text" name="size[]" placeholder="Size">
                    <input type="number" name="price[]" placeholder="Price">
                    <button type="button" onclick="removeRow(this)">❌</button>
                </div>
            </div>

            <button type="button" onclick="addRow()">➕ Add Stall</button>
            <br><br>

            <button type="submit">Save</button>
            <button type="button" onclick="closeForm()">Cancel</button>
        </div>
    </form>

    <script>
        function addRow() {
            let container = document.getElementById('stallContainer');

            let row = document.createElement('div');
            row.classList.add('stallRow');

            row.innerHTML = `
        <input type="text" name="stall_location[]" placeholder="Stall Location">
        <input type="text" name="size[]" placeholder="Size">
        <input type="number" name="price[]" placeholder="Price">
        <button type="button" onclick="removeRow(this)">❌</button>
    `;

            container.appendChild(row);
        }

        function removeRow(btn) {
            btn.parentElement.remove();
        }

        function openLeadForm(data = {}) {
            document.getElementById('leadFormContainer').style.display = 'block';

            // print everything directly (for debugging / dev)
            console.log("SELECTED DATA:", data);

            document.getElementById('contact_id').value = data.contact_id || '';
            document.getElementById('company_id').value = data.company_id || '';
            document.getElementById('company_name').value = data.company_name || '';
            document.getElementById('name').value = data.name || '';
            document.getElementById('email').value = data.email || '';
            document.getElementById('mobile').value = data.mobile || '';
            document.getElementById('exhibitor').value = data.exhibitor || '';
        }

        function closeForm() {
            document.getElementById('leadFormContainer').style.display = 'none';
        }
    </script>