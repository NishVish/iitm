<div class="others">Loading...</div>

<script>
    const url = "{{ url('otherregistration') }}";

    fetch(url)
        .then(response => response.json())
        .then(data => {

            let html = `
        <table border="1" cellpadding="8" cellspacing="0" width="100%">
            <tr>
                <th>ID</th>
                <th>Company</th>
                <th>City</th>
                <th>State</th>
                <th>Entry Type</th>
                <th>Action</th>
            </tr>
        `;

            data.forEach(item => {
                html += `
                <tr>
                    <td>${item.id}</td>
                    <td>${item.company_name}</td>
                    <td>${item.city}</td>
                    <td>${item.state}</td>
                    <td>${item.entry_type}</td>
                    <td>
    <!-- CATEGORY SELECT -->
    <select id="category-${item.id}">
        <option value="">Select</option>
        <option value="ta">TA</option>
        <option value="hotel">HOTEL</option>
        <option value="mis">MIS</option>
        <option value="none">NONE</option>
    </select>

    <!-- SUBMIT USING HREF -->
    <button onclick="submitCategory('${item.company_id}', '${item.contact_id}', '${item.email}', ${item.id})">
        Submit
    </button>

    <br><br>

    <!-- DIRECT REJECT LINK -->
    <a href="{{ url('reject-company') }}/${item.company_id}/${item.contact_id}/${item.email}"
       onclick="return confirm('Reject this company?')">
        <button style="background:red; color:white;">Reject ❌</button>
    </a>
</td>
                </tr>
            `;
            });

            html += `</table>`;

            document.querySelector('.others').innerHTML = html;
        })
        .catch(error => {
            document.querySelector('.others').innerHTML = "Error loading data";
        });

    // function sendMail(companyId, contactId, email) {

    //     fetch("{{ url('sendmailtoother') }}/" + companyId + "/" + contactId + "/" + email)
    //         .then(res => res.text())
    //         .then(res => {
    //             alert("Mail Sent for " + companyId);
    //         })
    //         .catch(err => {
    //             alert("Failed to send mail");
    //         });
    // }
</script><!-- TOP BUTTONS -->
<br>
<script>
    function submitCategory(companyId, contactId, email, id) {

        let category = document.getElementById('category-' + id).value;

        if (!category) {
            alert("Please select category");
            return;
        }

        // redirect using URL (no fetch)
        let url = "{{ url('approved-category') }}/"
            + companyId + "/"
            + contactId + "/"
            + email + "/"
            + category;

        window.location.href = url;
    }
</script>