<!-- BUTTONS -->
<button type="button" onclick="openLeadForm()">➕ Create Lead</button>
<button type="button" onclick="openLeadForm(dummyData)">🧪 Load Dummy Data</button>

<form method="POST" action="{{ url('backend/save-lead') }}">
    @csrf

    <div id="leadFormContainer" style="display:none; margin-top:30px; border:1px solid #ccc; padding:15px;">
        <h3>Create / Edit Lead</h3>

        <input type="hidden" name="contact_id" id="contact_id">

        <label>Company</label><br>
        <input type="text" name="company_name" id="company_name"><br><br>

        <label>Name</label><br>
        <input type="text" name="name" id="name"><br><br>

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
    const dummyData = {
        contact_id: 101,
        company_name: "Tech Expo Pvt Ltd",
        name: "John Doe",
        email: "john@example.com",
        mobile: "9876543210",
        exhibitor: "Yes",
        stalls: [
            { stall_location: "Hall A1", size: "10x10", price: 5000 },
            { stall_location: "Hall B2", size: "20x20", price: 12000 }
        ]
    };

    function openLeadForm(data = null) {
        document.getElementById('leadFormContainer').style.display = 'block';

        // reset form first
        document.getElementById('contact_id').value = '';
        document.getElementById('company_name').value = '';
        document.getElementById('name').value = '';
        document.getElementById('email').value = '';
        document.getElementById('mobile').value = '';
        document.getElementById('exhibitor').value = '';

        // reset stalls
        document.getElementById('stallContainer').innerHTML = `
        <div class="stallRow">
            <input type="text" name="stall_location[]" placeholder="Stall Location">
            <input type="text" name="size[]" placeholder="Size">
            <input type="number" name="price[]" placeholder="Price">
            <button type="button" onclick="removeRow(this)">❌</button>
        </div>
    `;

        // if dummy data provided → fill it
        if (data) {
            document.getElementById('contact_id').value = data.contact_id || '';
            document.getElementById('company_name').value = data.company_name || '';
            document.getElementById('name').value = data.name || '';
            document.getElementById('email').value = data.email || '';
            document.getElementById('mobile').value = data.mobile || '';
            document.getElementById('exhibitor').value = data.exhibitor || '';

            let container = document.getElementById('stallContainer');
            container.innerHTML = '';

            data.stalls.forEach(s => {
                let row = document.createElement('div');
                row.classList.add('stallRow');

                row.innerHTML = `
                <input type="text" name="stall_location[]" value="${s.stall_location}" placeholder="Stall Location">
                <input type="text" name="size[]" value="${s.size}" placeholder="Size">
                <input type="number" name="price[]" value="${s.price}" placeholder="Price">
                <button type="button" onclick="removeRow(this)">❌</button>
            `;

                container.appendChild(row);
            });
        }
    }

    function closeForm() {
        document.getElementById('leadFormContainer').style.display = 'none';
    }

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
</script>