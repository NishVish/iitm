<div class="container">
    <h2>All Leads</h2>

    <table border="1" cellpadding="10" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Lead ID</th>
                <th>Company ID</th>
                <th>Contact ID</th>
                <th>Sales Person</th>
                <th>Status</th>
                <th>Payment Status</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="leadsTable">
            <tr>
                <td colspan="7">Loading...</td>
            </tr>
        </tbody>
    </table>
</div>

<script>
    fetch('{{ url('allleads') }}')
        .then(response => response.json())
        .then(result => {
            let rows = '';

            if (result.data.length === 0) {
                rows = `<tr><td colspan="7">No leads found</td></tr>`;
            } else {
                result.data.forEach(lead => {
                    rows += `
<tr>
    <td>${lead.lead_id}</td>
    <td>${lead.company_id}</td>
    <td>${lead.contact_id}</td>
    <td>${lead.sales_person}</td>
    <td>${lead.status}</td>
    <td>${lead.payment_status}</td>
    <td>${lead.created_at}</td>
    <td>
        <button onclick='openMailPopup(${JSON.stringify(lead)})'>
            📧 Send Mail
        </button>
    </td>
</tr>
`;
                });
            }

            document.getElementById('leadsTable').innerHTML = rows;
        })
        .catch(error => {
            console.error(error);
            document.getElementById('leadsTable').innerHTML =
                `<tr><td colspan="7">Error loading data</td></tr>`;
        });
</script>