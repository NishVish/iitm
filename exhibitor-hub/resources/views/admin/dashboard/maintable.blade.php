<table id="bookingTable" border="1" cellpadding="10" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Stall No.</th>
            <th>Company Name</th>
            <th>Booking</th>
            <th>Payment</th>
            <th>Branding</th>
            <th>Delegates</th>
            <th>Fascia</th>
            <th>Certificate</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>

<script>
    fetch('{{ url('/api/event/list') }}')
        .then(response => response.json())
        .then(events => {

            let html = '';

            events.forEach(event => {

                const city = event.city || event.location;

                html += `
                <button class="event-btn" onclick="loadBookings('${city}')">
                    ${city}
                </button>
            `;
            });

            document.getElementById('eventButtons').innerHTML = html;
        });

    function loadBookings(city) {

        fetch(`{{ url('/api/bookingdata') }}/${encodeURIComponent(city)}`)
            .then(response => response.json())
            .then(data => {

                let rows = '';

                data.forEach(item => {

                    const bookingStatus = '✓ Completed';
                    const paymentStatus = '! Pending';
                    const brandingStatus = item.branding_id ? '✓ Completed' : '! Pending';
                    const delegateStatus = item.delegate_id ? '✓ Completed' : '! Pending';
                    const fasciaStatus = item.fascia_name ? '✓ Completed' : '! Pending';
                    const certificateStatus = item.certificate_name ? '✓ Completed' : '! Pending';

                    rows += `
                    <tr>
                        <td>${item.stall}</td>
                        <td>${item.company_name}</td>

                        <td class="${bookingStatus.startsWith('✓') ? 'completed' : 'pending'}">
                            ${bookingStatus}
                        </td>

                        <td class="${paymentStatus.startsWith('✓') ? 'completed' : 'pending'}">
                            ${paymentStatus}
                        </td>

                        <td class="${brandingStatus.startsWith('✓') ? 'completed' : 'pending'}">
                            ${brandingStatus}
                        </td>

                        <td class="${delegateStatus.startsWith('✓') ? 'completed' : 'pending'}">
                            ${delegateStatus}
                        </td>

                        <td class="${fasciaStatus.startsWith('✓') ? 'completed' : 'pending'}">
                            ${fasciaStatus}
                        </td>

                        <td class="${certificateStatus.startsWith('✓') ? 'completed' : 'pending'}">
                            ${certificateStatus}
                        </td>
                    </tr>
                `;
                });

                document.querySelector('#bookingTable tbody').innerHTML = rows;
            });
    }
</script>

<style>
    body {
        font-family: Arial, Helvetica, sans-serif;
    }

    #eventButtons {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }

    .event-btn {
        background: #0d6efd;
        color: #fff;
        border: none;
        padding: 10px 18px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
    }

    .event-btn:hover {
        background: #0b5ed7;
    }

    table {
        border-collapse: collapse;
    }

    th {
        background: #0d6efd;
        color: #fff;
        text-align: left;
    }

    td,
    th {
        border: 1px solid #ddd;
        padding: 10px;
    }

    .completed {
        color: #198754;
        font-weight: bold;
    }

    .pending {
        color: #fd7e14;
        font-weight: bold;
    }

    tr:nth-child(even) {
        background: #f8f9fa;
    }
</style>