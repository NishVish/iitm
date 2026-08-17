<div id="leadContainer" style="display: grid; gap: 15px;">
    <div>Loading...</div>
</div>

<iframe src="{{ url('/allleads') }}" frameborder="0" style="width: 100%; height: 500px;"></iframe>


<script>
    document.addEventListener("DOMContentLoaded", function () {

        const container = document.getElementById("leadContainer");

        fetch("{{ url('/allleads') }}")
            .then(res => res.json())
            .then(res => {

                if (!container) return;

                if (res.status !== 'success') {
                    container.innerHTML = "<div>Invalid response</div>";
                    return;
                }

                const list = Array.isArray(res.data) ? res.data : [];

                let html = "";

                list.forEach(item => {

                    const lead = item.lead ?? {};
                    const company = item.company ?? {};
                    const contact = item.contact ?? {};
                    const locations = Array.isArray(item.locations) ? item.locations : [];

                    const mobile = item.mobile ?? '';
                    const email = item.email ?? '';

                    html += `
        <div style="border:1px solid #ddd;padding:15px;border-radius:10px;background:#fff;margin-bottom:15px;">
            <h3>Lead #${lead.lead_id ?? '—'}</h3>

            <div><strong>Exhibitor:</strong> ${lead.exhibitor ?? '—'}</div>
            <div><strong>Year:</strong> ${lead.exhibition_year ?? '—'}</div>
            <div><strong>Sales Person:</strong> ${lead.sales_person ?? '—'}</div>
            <div><strong>Status:</strong> ${lead.status ?? '—'}</div>

            <hr>

            <div><strong>Company:</strong> ${company.company_name ?? '—'}</div>

            <hr>

            <div><strong>Contact:</strong> ${contact.name ?? '—'}</div>

            <hr>

            <div><strong>Mobile:</strong> ${mobile.mobile ?? '—'}</div>
            <div><strong>Email:</strong> ${email.email ?? '—'}</div>

            <hr>

            <strong>Locations (${locations.length}):</strong>
    `;

                    if (locations.length) {
                        locations.forEach(loc => {
                            html += `
                <div style="margin:8px 0;padding:8px;background:#f7f7f7;border-radius:5px;">
                    <div><strong>Location:</strong> ${loc.location ?? '—'}</div>
                    <div>Stall: ${loc.stall_location ?? '—'}</div>
                    <div>Size: ${loc.size ?? '—'}</div>
                </div>
            `;
                        });
                    } else {
                        html += `<div>No Locations</div>`;
                    }

                    html += `
                    <div style="display:flex;gap:5px;margin-top:10px;">

                        <button class="btn btn-primary"
                            onclick="openMailPopup('${email.email ?? ''}', '${company.company_name ?? ''}', '${lead.lead_id ?? ''}')">
                            ✉ Mail
                        </button>

                        <button class="btn btn-primary"
                            onclick="updateDetails('${lead.lead_id ?? ''}', '${mobile.mobile ?? ''}')">
                            ✎ Update
                        </button>

                    </div>

                </div>
                `;
                });

                container.innerHTML = html;
            })
            .catch(err => {
                console.error(err);
                container.innerHTML = "<div>Error loading data</div>";
            });

    });
</script>


<script>
    function updateDetails(id, mobile) {

        const url =
            "{{ url('leadsdetails') }}/" +
            encodeURIComponent(id) +
            "?mobile=" +
            encodeURIComponent(mobile || '');
        console.log(url);
        window.location.href = url;
    }
</script>