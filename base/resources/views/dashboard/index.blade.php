<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Exhibitor</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f5f6fa;
        }

        .form-card {
            max-width: 900px;
            margin: 40px auto;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, .08);
        }

        .form-title {
            font-weight: 600;
            margin-bottom: 25px;
        }

        .required {
            color: red;
        }

        .form-label {
            font-weight: 500;
        }
    </style>
</head>

<body>



    <div class="container">

        <a href="{{ url('add_booking') }}">


            Add Booking
        </a>

        <div class="form-card">

            <h3 class="form-title">Add Booking</h3>

            <form action="save_stall_booking.php" method="POST">

                <div class="row g-3">

                    <!-- Event -->
                    <div class="col-md-6">
                        <label class="form-label">
                            Event <span class="required">*</span>
                        </label>

                        <select name="event_id" class="form-select" required>
                            <option value="">Select Event</option>
                            <option value="101">Food Expo 2026</option>
                            <option value="102">Tech Expo 2026</option>
                            <option value="103">Build Expo 2026</option>
                            <option value="104">Business Expo 2026</option>
                        </select>
                    </div>

                    <!-- Company -->
                    <div class="col-md-6">
                        <label class="form-label">
                            Company <span class="required">*</span>
                        </label>

                        <select name="company_id" class="form-select" required>
                            <option value="">Select Company</option>
                            <option value="1001">ABC Technologies</option>
                            <option value="1002">Global Foods Pvt Ltd</option>
                            <option value="1003">TechNova Solutions</option>
                            <option value="1004">GreenLeaf Industries</option>
                            <option value="1005">BuildPro India</option>
                        </select>
                    </div>

                    <!-- Sales Person -->
                    <div class="col-md-6">
                        <label class="form-label">
                            Sales Person
                        </label>

                        <select name="sales_id" class="form-select">
                            <option value="">Select Sales Person</option>
                            <option value="501">John Smith</option>
                            <option value="502">Sarah Johnson</option>
                            <option value="503">David Wilson</option>
                            <option value="504">Anita Rao</option>
                            <option value="505">Rahul Sharma</option>
                        </select>
                    </div>

                    <!-- Stall Size -->
                    <div class="col-md-6">
                        <label class="form-label">
                            Stall Size
                        </label>

                        <select name="stall_size" class="form-select">
                            <option value="">Select Stall Size</option>
                            <option value="3x3">3 x 3</option>
                            <option value="6x3">6 x 3</option>
                            <option value="6x6">6 x 6</option>
                            <option value="9x3">9 x 3</option>
                            <option value="9x6">9 x 6</option>
                        </select>
                    </div>

                    <!-- Stall Location -->
                    <div class="col-md-6">
                        <label class="form-label">
                            Stall Location
                        </label>

                        <input type="text" name="stall_location" class="form-control" placeholder="e.g. Hall A - A12">
                    </div>

                    <!-- Stall Type -->
                    <div class="col-md-6">
                        <label class="form-label">
                            Stall Type
                        </label>

                        <select name="stall_type" class="form-select">
                            <option value="">Select Stall Type</option>
                            <option value="Standard">Standard</option>
                            <option value="Premium">Premium</option>
                            <option value="Island">Island</option>
                            <option value="Outdoor">Outdoor</option>
                        </select>
                    </div>

                    <!-- Fascia -->
                    <div class="col-md-6">
                        <label class="form-label">
                            Fascia
                        </label>

                        <input type="text" name="fascia" class="form-control" placeholder="Enter fascia name">
                    </div>

                    <!-- Branding Requirement -->
                    <div class="col-md-6">

                        <label class="form-label d-block">
                            Branding Requirement
                        </label>

                        <div class="form-check form-switch mt-2">

                            <input class="form-check-input" type="checkbox" name="has_branding_requirement"
                                id="branding" value="1">

                            <label class="form-check-label" for="branding">
                                Branding Required
                            </label>

                        </div>

                    </div>

                    <!-- Note -->
                    <div class="col-md-12">
                        <label class="form-label">
                            Note
                        </label>

                        <textarea name="note" class="form-control" rows="4"
                            placeholder="Enter any additional notes..."></textarea>
                    </div>

                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-end gap-2">

                    <a href="stall_booking.php" class="btn btn-light border">
                        Cancel
                    </a>

                    <button type="reset" class="btn btn-outline-secondary">
                        Reset
                    </button>

                    <button type="submit" class="btn btn-primary px-4">
                        Save Exhibitor
                    </button>

                </div>

            </form>

        </div>

    </div>

</body>

</html>