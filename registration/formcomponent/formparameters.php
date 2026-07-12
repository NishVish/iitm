<form action="register.php" method="post" class="register-form">






    <div class="form-group">
        <select class="form-control" name="title" required>
            <option value="Mr.">Mr</option>
            <option value="Mrs.">Mrs</option>
            <option value="Ms.">Ms</option>
            <option value="Dr.">Dr</option>
        </select>
    </div>
    <!--<div class="form-group">
                        <input type="text" class="form-control" placeholder="First Name *" name="select2" required>
                    </div>-->

    <div class="form-group">
        <input type="text" class="form-control" placeholder="First Name *" name="select2" value="" required />
    </div>
    <div class="form-group">
        <input type="text" class="form-control" placeholder="Last Name" name="lastname">
    </div>
    <div class="form-group">
        <input type="text" class="form-control" placeholder="Designation *" name="designation" required>
    </div>
    <div class="form-group">
        <input type="text" class="form-control" placeholder="Company Name *" name="organisation" required>
    </div>
    <div class="form-group">
        <input type="email" class="form-control" placeholder="Your Email *" name="email" required>
    </div>


    <?php
    include('number.php');

    include('category.php');
    include('address.php');


    ?>





    <!-- 
<div class="form-group">
    <textarea class="form-control" placeholder="Address" name="address"></textarea>
</div>
<div class="form-group">
    <input type="text" class="form-control" placeholder="City" name="city">
</div>
<div class="form-group">
    <input type="text" class="form-control" placeholder="State" name="state">
</div>
<div class="form-group">
    <input type="text" class="form-control" placeholder="Pincode" name="pincode">
</div>
<div class="form-group">
    <input type="text" class="form-control" placeholder="Country" name="country">
</div> -->
    <div class="form-group">
        <input type="text" class="form-control" placeholder="Phone *" name="phone" minlength="10" maxlength="10">
    </div>

    <div class="form-group">
        <input type="text" class="form-control" placeholder="Website" name="website">
    </div>
    <div class="form-group">
        <textarea class="form-control" placeholder="Your Message" name="Message"></textarea>
    </div>
    <div class="form-group">
        <input type="hidden" class="form-control" placeholder="city_name *" value="<?php echo $cityname; ?>"
            name="city_name" minlength="10" maxlength="10">
    </div>


    <button type="submit" class="btnRegister">Submit</button>
</form>