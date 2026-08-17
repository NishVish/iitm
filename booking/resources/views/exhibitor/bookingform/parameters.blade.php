<div class="form-box">

    <form action="{{ route('exhibitor.store') }}" method="POST">

        @csrf


        <div class="form-group">



        </div>


        <div class="form-group">
            <label>Company Name</label>

            <input type="text" name="company_name" placeholder="Enter Company Name" required>
        </div>





        <div class="form-group">
            <label>Company Address</label>

            <textarea name="address" placeholder="Enter Company Address"></textarea>
        </div>


        <div class="form-group">
            <label>PIN</label>

            <input type="text" name="pin" placeholder="Enter PIN">
        </div>


        <div class="form-group">
            <label>State</label>

            <input type="text" name="state" placeholder="Enter State">
        </div>


        <div class="form-group">
            <label>Contact Person</label>

            <input type="text" name="name" placeholder="Enter Contact Person Name">
        </div>


        <div class="form-group">
            <label>Designation</label>

            <input type="text" name="designation" placeholder="Enter Designation">
        </div>


        <div class="form-group">
            <label>Mobile</label>

            <input type="text" name="mobile" placeholder="Enter Mobile Number">
        </div>


        <div class="form-group">
            <label>Email</label>

            <input type="email" name="email" placeholder="Enter Email">
        </div>


        Booking Details

        <div class="form-group">
            <label>Stall Number</label>

            <input type="text" name="stall_number" placeholder="" readonly>
        </div>


        <div class="form-group">
            <label>Size </label>

            <input type="text" name="stall" placeholder="Example: 12 Sq.M">
        </div>


        <div class="form-group">
            <label>Fascia Name</label>

            <input type="text" name="fascia_name" placeholder="Enter Fascia Name">
        </div>


        <div class="form-group">
            <label>Certificate Name</label>

            <input type="text" name="certificate_name" placeholder="Enter Certificate Name">
        </div>


        <button type="submit">
            Save Details
        </button>


    </form>

</div>


<style>
    .form-box {
        width: 400px;
        background: white;
        padding: 25px;
        margin: 30px auto;
        border-radius: 10px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, .1);
    }


    .form-group {
        margin-bottom: 15px;
    }


    .form-group label {
        display: block;
        margin-bottom: 6px;
        font-weight: bold;
        color: #333;
    }


    .form-group input,
    .form-group textarea,
    .form-group select {

        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
        font-size: 14px;

    }


    .form-group textarea {
        height: 80px;
        resize: none;
    }


    button {

        width: 100%;
        padding: 12px;
        background: #0066cc;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;

    }


    button:hover {
        background: #004c99;
    }
</style>