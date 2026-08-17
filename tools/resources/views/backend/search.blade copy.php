<form action="{{ route('backend.search') }}" method="get">
    <input type="text" name="q" placeholder="Search by email, phone, or name">
    <button type="submit">Search</button>
</form>
auto


<input type="text" id="searchInput" placeholder="Search by email, phone, or name">
<button onclick="searchData()">Search</button>



<div id="contactResults"></div>
<div id="textResults"></div>
<div id="leadResults"></div>


<script>

    function searchData() {
        const query = document.getElementById('searchInput').value;

        if (!query) {
            alert('Enter something to search');
            return;
        }

        // CONTACT SEARCH
        fetch(`{{ url('backend/search') }}?q=${encodeURIComponent(query)}`)
            .then(res => res.json())
            .then(data => {

                let html = `
                <h2>Contact Results</h2>
            `;

                if (data.results?.length) {
                    data.results.forEach(item => {
                        html += `
                        <div style="border:1px solid #ccc; padding:10px; margin:10px;">
                            <h3>${item.name ?? ''}</h3>
                            <p>Email: ${item.email ?? ''}</p>
                            <p>Mobile: ${item.mobile ?? ''}</p>
                            <p>Company: ${item.company_name ?? ''}</p>
                            <button onclick="openLeadForm(${item.id})">Mark as Lead</button>
                        </div>
                    `;
                    });
                } else {
                    html += `<p>No contact results found</p>`;
                }

                document.getElementById('contactResults').innerHTML = html;

                // leads always render too
                let leadHtml = `<h2>Leads</h2>`;

                if (data.leads?.length) {
                    data.leads.forEach(lead => {
                        leadHtml += `
                        <div style="border:1px solid green; padding:10px; margin:10px;">
                            <p>Status: ${lead.status}</p>
                            <p>Location: ${lead.location}</p>
                            <p>Price: ${lead.grand_total}</p>
                        </div>
                    `;
                    });
                } else {
                    leadHtml += `<p>No leads found</p>`;
                }

                document.getElementById('leadResults').innerHTML = leadHtml;
            });

        // TEXT SEARCH
        fetch(`{{ url('backend/searchtext') }}?q=${encodeURIComponent(query)}`)
            .then(res => res.json())
            .then(data => {

                let html = `<h2>Text Search Results</h2>`;

                if (data.results?.length) {
                    data.results.forEach(item => {
                        html += `
                        <div style="border:1px solid #ccc; padding:10px; margin:10px;">
                            <h3>${item.name ?? ''}</h3>
                            <p>Email: ${item.email ?? ''}</p>
                            <p>Mobile: ${item.mobile ?? ''}</p>
                            <p>Company: ${item.company_name ?? ''}</p>
                            <button onclick="openLeadForm(${item.id})">Mark as Lead</button>
                        </div>
                    `;
                    });
                } else {
                    html += `<p>No text results found</p>`;
                }

                document.getElementById('textResults').innerHTML = html;
            });
    }
</script>
<div id="leadModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:#00000088;">
    <div style="background:#fff; padding:20px; width:300px; margin:10% auto; position:relative;">
        <h3>Create Lead</h3>

        <input type="hidden" id="leadUserId">

        <label>Status:</label><br>
        <input type="text" id="leadStatus"><br><br>

        <label>Location:</label><br>
        <input type="text" id="leadLocation"><br><br>

        <label>Price:</label><br>
        <input type="number" id="leadPrice"><br><br>

        <button onclick="submitLead()">Submit</button>
        <button onclick="closeLeadForm()">Cancel</button>
    </div>
</div>

<script>
    function openLeadForm(userId) {
        document.getElementById('leadUserId').value = userId;
        document.getElementById('leadModal').style.display = 'block';
    }

    function closeLeadForm() {
        document.getElementById('leadModal').style.display = 'none';
    }

    function submitLead() {
        const userId = document.getElementById('leadUserId').value;
        const status = document.getElementById('leadStatus').value;
        const location = document.getElementById('leadLocation').value;
        const price = document.getElementById('leadPrice').value;

        fetch(`{{ url('create-lead') }}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                user_id: userId,
                status: status,
                location: location,
                grand_total: price
            })
        })
            .then(res => res.json())
            .then(data => {
                alert('Lead created successfully');
                closeLeadForm();
                searchData(); // refresh results
            })
            .catch(err => {
                console.error(err);
                alert('Error creating lead');
            });
    }
</script>