<?php
include 'header3.php';
?>
<style>


    .container {
        max-width: 500px;
        padding: 30px;
        background-color: #fff;
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        border-radius: 10px;
    }

    h2 {
        color: #4CAF50;
        margin-bottom: 20px;
        text-align: center;
    }



    form label {
        display: block;
        font-weight: 600;
    }

    form input {
        width: 100%;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ccc;
        box-sizing: border-box;
        font-size: 1rem;
    }

    form input[readonly] {
        background-color: #e9ecef;
    }

    .btn {
        display: inline-block;
        padding: 12px 25px;
        background-color: #4CAF50;
        color: white;
        font-size: 1rem;
        border: none;
        border-radius: 5px;
        text-decoration: none;
        cursor: pointer;
        transition: background 0.3s ease;
        text-align: center;
    }

    .btn:hover {
        background-color: #45a049;
    }

    .note {
        font-size: 0.9rem;
        color: #555;
        margin-bottom: 20px;
    }
</style>

<form method="post" action="<?= site_url('booking/stallinfo') ?>">
    <!-- Hidden fields -->
    <input type="hidden" name="lead_id" value="">
    <input type="hidden" id="user-ip" name="user_ip" value="<?= $_SERVER['REMOTE_ADDR'] ?>">

    <h4>

    <input type="text" placeholder="Company Name *" name="organisation" required>
                    <input type="text" placeholder="Website" name="website">

</h4>
    <table>
        <tr>
            <td colspan="3">
                <textarea placeholder="Address" name="address"></textarea>
            </td>
</tr><tr>
         <td><input type="text" placeholder="City" name="city">

            </td>        
            
         <td>
            
                <input type="text" placeholder="State *" name="state" required>

            </td>
            
        </tr>
        <tr><td>
                <input type="text" placeholder="Pincode *" name="pincode" required>
                         <td>
            
            <input type="text" placeholder="Country" name="country">

            </td>
            </td></tr>
    </table>

    <h4>Contact Details</h4>
    <select name="title" required>
        <option value="">Select Title</option>
        <option value="Mr.">Mr</option>
        <option value="Mrs.">Mrs</option>
        <option value="Ms.">Ms</option>
        <option value="Dr.">Dr</option>
    </select><br>
    <input type="text" placeholder="First Name *" name="firstname" required>
    <input type="text" placeholder="Last Name *" name="lastname" required>
                    <input type="text" placeholder="Your Designation *" name="designation" required>

    <br>
    <input type="email" placeholder="Your Email *" name="email" required>
    <input type="tel" pattern="\d{10}" placeholder="Your Phone *" name="phone" required>

    <h4>Interested In</h4>
    <div style="display:flex; flex-wrap: wrap; gap:10px;">
        <label><input type="checkbox" name="locations[]" value="Chennai"> CHENNAI</label>
        <label><input type="checkbox" name="locations[]" value="Bengaluru"> BENGALURU</label>
        <label><input type="checkbox" name="locations[]" value="Delhi"> DELHI</label>
        <label><input type="checkbox" name="locations[]" value="Mumbai"> MUMBAI</label>
        <label><input type="checkbox" name="locations[]" value="Pune"> PUNE</label>
        <br>
        <label><input type="checkbox" name="locations[]" value="Hyderabad"> HYDERABAD</label>
        <label><input type="checkbox" name="locations[]" value="Kochi"> KOCHI</label>
        <label><input type="checkbox" name="locations[]" value="Kolkata"> KOLKATA</label>
        <label><input type="checkbox" name="locations[]" value="Ahmedabad"> AHMEDABAD</label>
    </div>

    <textarea placeholder="Your Message" name="message"></textarea>
<br>
        <a href="<?= site_url('booking/exhibitor_booking/stallinfo') ?>" class="btn">Proceed to fill Stall Requirements</a>
</form>
