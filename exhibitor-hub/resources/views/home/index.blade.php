<div class="portal-box">

    <h1>Exhibitor Portal</h1>

    <form action="{{ url('exhibitor/verify')}}" method="POST">

        @csrf

        <div class="form-group">
            <label>Booking ID</label>

            <input type="text" name="booking_id" placeholder="Enter your booking ID" required>
        </div>


        <div class="form-group">
            <label>OTP</label>

            <input type="text" name="otp" placeholder="Enter OTP sent to your mobile/email" required>
        </div>


        <button type="submit">
            Access Exhibitor Portal
        </button>

    </form>


    <div class="links">

        <a href="{{ url('exhibitor') }}">
            Customer Portal
        </a>


        <a href="{{ url('admin') }}">
            Admin Portal
        </a>

    </div>

</div>



<style>
    .portal-box {

        width: 400px;
        background: #fff;
        padding: 30px;
        margin: 50px auto;
        border-radius: 10px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, .15);

    }


    .portal-box h1 {

        text-align: center;
        margin-bottom: 25px;
        color: #333;

    }


    .form-group {

        margin-bottom: 20px;

    }


    .form-group label {

        display: block;
        margin-bottom: 7px;
        font-weight: bold;

    }


    .form-group input {

        width: 100%;
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;

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



    .links {

        display: flex;
        justify-content: space-between;
        margin-top: 25px;

    }


    .links a {

        text-decoration: none;
        color: #0066cc;
        font-weight: bold;

    }


    .links a:hover {

        text-decoration: underline;

    }
</style>