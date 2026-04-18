<div class="enquiry-section">

    <style>
        .enquiry-section {
            padding: 80px 5%;
            background: #050505;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .form-container {
            width: 100%;
            max-width: 900px;
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 30px;
            padding: 50px;
            box-shadow: 0 40px 100px rgba(0, 0, 0, 0.5);
        }

        /* HEADER */
        .form-header {
            text-align: center;
            margin-bottom: 25px;
        }

        .form-header h2 {
            font-size: 2.5rem;
            font-weight: 800;
            background: linear-gradient(90deg, #fff, #00f5ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 10px;
        }

        .form-header p {
            color: #888;
        }

        /* CALLBACK BOX */
        .callback-box {
            margin-bottom: 35px;
            padding: 20px;
            border-radius: 15px;
            background: rgba(0, 245, 255, 0.08);
            border: 1px solid rgba(0, 245, 255, 0.2);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }

        .callback-box h3 {
            color: #fff;
            font-size: 1.2rem;
            margin: 0;
        }

        .callback-box p {
            color: #aaa;
            font-size: 0.85rem;
            margin: 5px 0 0;
        }

        .callback-btn {
            padding: 10px 18px;
            background: #00f5ff;
            color: #000;
            border-radius: 30px;
            font-weight: 700;
            text-decoration: none;
            transition: 0.3s;
            white-space: nowrap;
        }

        .callback-btn:hover {
            transform: scale(1.05);
            background: #fff;
        }

        /* FORM */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 25px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .form-group.full-width {
            grid-column: span 2;
        }

        .form-group label {
            font-size: 0.85rem;
            color: #aaa;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 15px;
            color: #fff;
        }

        /* CITY CHECKBOX */
        .city-selection {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            padding: 20px;
            background: rgba(0, 0, 0, 0.2);
            border-radius: 15px;
        }

        .city-option {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.9rem;
            cursor: pointer;
        }

        .city-option input {
            accent-color: #00f5ff;
        }

        /* BUTTON */
        .submit-btn {
            margin-top: 40px;
            width: 100%;
            padding: 20px;
            background: #fff;
            color: #000;
            border: none;
            border-radius: 15px;
            font-size: 1.1rem;
            font-weight: 800;
            text-transform: uppercase;
            cursor: pointer;
            transition: 0.4s;
        }

        .submit-btn:hover {
            background: #00f5ff;
            transform: translateY(-3px);
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-group.full-width {
                grid-column: span 1;
            }

            .city-selection {
                grid-template-columns: repeat(2, 1fr);
            }

            .callback-box {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>

    <div class="form-container">

        <!-- HEADER -->
        <div class="form-header">
            <h2>Exhibitor Enquiry</h2>
            <p>Partner with India's leading Travel Media platform</p>
        </div>

        <!-- CALLBACK SECTION -->
        <div class="callback-box">
            <div>
                <h3>Need Help?</h3>
                <p>Request a callback from our exhibition team</p>
            </div>

            <a href="tel:+919999999999" class="callback-btn">
                Request Callback
            </a>
        </div>

        <!-- FORM -->
        <form action="" method="POST">
            @csrf

            <div class="form-grid">

                <div class="form-group full-width">
                    <label>Company Name</label>
                    <input type="text" name="company_name" required>
                </div>

                <div class="form-group">
                    <label>Contact Person</label>
                    <input type="text" name="contact_name" required>
                </div>
                <div class="form-group">
                    <label>Designation</label>
                    <input type="text" name="designation" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" required>
                </div>

                <div class="form-group">
                    <label>City</label>
                    <input type="text" name="city" required>
                </div>

                <div class="form-group">
                    <label>Phone</label>
                    <input type="tel" name="phone" required>
                </div>

                <div class="form-group">
                    <label>Category</label>
                    <select name="category">
                        <option>Tourism Board</option>
                        <option>Hotels & Resorts</option>
                        <option>Airlines</option>
                        <option>Travel Agency</option>
                        <option>Media / Tech</option>
                    </select>
                </div>

                <div class="form-group full-width">
                    <label>Cities of Interest</label>

                    <div class="city-selection">
                        @php
                            $cities = ['Mumbai', 'Delhi', 'Bangalore', 'Hyderabad', 'Chennai', 'Kolkata', 'Ahmedabad', 'Pune', 'Jaipur'];
                        @endphp

                        @foreach($cities as $city)
                            <label class="city-option">
                                <input type="checkbox" name="cities[]" value="{{ $city }}">
                                {{ $city }}
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="form-group full-width">
                    <label>Requirements</label>
                    <textarea name="message" rows="4"></textarea>
                </div>

            </div>

            <button type="submit" class="submit-btn">
                Request Prospectus & Pricing
            </button>

        </form>

    </div>
</div>