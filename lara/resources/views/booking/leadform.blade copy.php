<!DOCTYPE html>
<html>

<head>
    <title>Lead Entry Form</title>
    <style>
        body {
            font-family: sans-serif;
            line-height: 1.5;
            padding: 20px;
            color: #333;
        }

        .location-block {
            border: 1px solid #ddd;
            padding: 20px;
            margin-bottom: 15px;
            background: #fff;
            border-radius: 4px;
        }

        label {
            display: inline-block;
            width: 150px;
            font-weight: bold;
            font-size: 0.9em;
        }

        input {
            padding: 5px;
            width: 250px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        .section-title {
            background: #f4f4f4;
            padding: 10px;
            border-left: 5px solid #333;
            margin-top: 30px;
        }

        button {
            cursor: pointer;
            border-radius: 4px;
            border: none;
        }

        .btn-add {
            background: #5c5c5c;
            color: white;
            padding: 8px 15px;
        }

        .btn-save {
            background: #28a745;
            color: white;
            padding: 12px 30px;
            font-size: 1em;
            font-weight: bold;
            margin-top: 20px;
        }

        .btn-remove {
            background: #dc3545;
            color: white;
            padding: 5px 10px;
            margin-top: 10px;
        }
    </style>
</head>

<body>

    <form method="POST" action="{{ url('lead/save') }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <h3 class="section-title">Lead Details</h3>

        <label>Company ID</label>
        <input type="text" name="company_id"><br><br>

        <label>Contact ID</label>
        <input type="text" name="contact_id"><br><br>

        <label>Exhibition Year</label>
        <input type="text" name="exhibition_year"><br><br>

        <label>Fascia</label>
        <input type="text" name="fascia"><br><br>

        <label>Sales Person</label>
        <input type="text" name="sales_person"><br><br>

        <label>Exhibitor</label>
        <input type="text" name="exhibitor"><br><br>

        <label>Booking Form</label>
        <input type="text" name="booking_form"><br><br>

        <label>Status</label>
        <input type="text" name="status"><br><br>

        <label>Payment Status</label>
        <input type="text" name="payment_status"><br><br>

        <h3 class="section-title">Lead Locations</h3>

        <div id="locations-container">
            <div class="location-block">
                <label>Location</label>
                <input type="text" name="locations[0][location]"><br><br>

                <label>Stall Location</label>
                <input type="text" name="locations[0][stall_location]"><br><br>

                <label>Size</label>
                <input type="text" name="locations[0][size]"><br><br>

                <label>Price</label>
                <input type="text" name="locations[0][price]"><br><br>

                <label>GST</label>
                <input type="text" name="locations[0][gst_amount]"><br><br>

                <label>Discount</label>
                <input type="text" name="locations[0][discount_amount]"><br><br>

                <label>Grand Total</label>
                <input type="text" name="locations[0][grand_total]"><br><br>
            </div>
        </div>

        <button type="button" class="btn-add" onclick="addLocation()">+ Add More Location</button>
        <br>
        <button type="submit" class="btn-save">Save Lead</button>
    </form>

    <script>
        let locationIndex = 1;

        // 1. ADD DYNAMIC ROW FUNCTION
        function addLocation() {
            const container = document.getElementById('locations-container');
            const div = document.createElement('div');
            div.className = 'location-block';
            div.innerHTML = `
            <label>Location</label>
            <input type="text" name="locations[${locationIndex}][location]"><br><br>
            <label>Stall Location</label>
            <input type="text" name="locations[${locationIndex}][stall_location]"><br><br>
            <label>Size</label>
            <input type="text" name="locations[${locationIndex}][size]"><br><br>
            <label>Price</label>
            <input type="text" name="locations[${locationIndex}][price]"><br><br>
            <label>GST</label>
            <input type="text" name="locations[${locationIndex}][gst_amount]"><br><br>
            <label>Discount</label>
            <input type="text" name="locations[${locationIndex}][discount_amount]"><br><br>
            <label>Grand Total</label>
            <input type="text" name="locations[${locationIndex}][grand_total]"><br><br>
            <button type="button" class="btn-remove" onclick="this.parentElement.remove()">Remove This Location</button>
        `;
            container.appendChild(div);
            locationIndex++;
        }

        // // 2. FILL DUMMY DATA FROM YOUR JSON
        // window.addEventListener('DOMContentLoaded', () => {
        //     const jsonData = {
        //         "name": { "contact_id": 299314, "company_id": "C5E0CE267", "name": "N" },
        //         "company": { "company_name": "Sphere Travelmedia & Exhibition", "country": "India", "active_inactive": "active" },
        //         "email": { "email": "marketing1@iitmindia.com" }
        //     };

        //     // Mapping Lead Details
        //     document.querySelector('[name="company_id"]').value = jsonData.company.company_id || jsonData.name.company_id;
        //     document.querySelector('[name="contact_id"]').value = jsonData.name.contact_id;
        //     document.querySelector('[name="exhibition_year"]').value = "2026";
        //     document.querySelector('[name="fascia"]').value = jsonData.company.company_name;
        //     document.querySelector('[name="sales_person"]').value = "Internal System";
        //     document.querySelector('[name="exhibitor"]').value = jsonData.name.name;
        //     document.querySelector('[name="booking_form"]').value = "AUTO-GEN-001";
        //     document.querySelector('[name="status"]').value = jsonData.company.active_inactive;
        //     document.querySelector('[name="payment_status"]').value = "Pending";

        //     // Pre-filling Location Row 0 with Dummy Data
        //     document.querySelector('[name="locations[0][location]"]').value = jsonData.company.country;
        //     document.querySelector('[name="locations[0][stall_location]"]').value = "Hall-1/A-05";
        //     document.querySelector('[name="locations[0][size]"]').value = "3x3";
        //     document.querySelector('[name="locations[0][price]"]').value = "12000.00";
        //     document.querySelector('[name="locations[0][gst_amount]"]').value = "2160.00";
        //     document.querySelector('[name="locations[0][discount_amount]"]').value = "0.00";
        //     document.querySelector('[name="locations[0][grand_total]"]').value = "14160.00";
        // });
    </script>

</body>

</html>