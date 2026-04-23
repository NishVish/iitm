<div class="enquiry-section">

    <style>
        /* IITM BRANDED ENQUIRY SECTION */
        .enquiry-section {
            padding: 80px 5%;
            background: #f4f4f4 url('https://www.transparenttextures.com/patterns/world-map.png');
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .form-container {
            width: 100%;
            max-width: 900px;
            background: #ffffff;
            border-top: 6px solid #aa2324;
            /* IITM Crimson Red */
            border-radius: 12px;
            padding: 50px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        /* HEADER */
        .form-header {
            text-align: center;
            margin-bottom: 35px;
        }

        .form-header h2 {
            font-family: Georgia, serif;
            font-size: 2.4rem;
            font-weight: normal;
            color: #111;
            margin-bottom: 10px;
        }

        .form-header p {
            color: #666;
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* CALLBACK BOX (IITM Theme) */
        .callback-box {
            margin-bottom: 35px;
            padding: 25px;
            border-radius: 8px;
            background: #fff5f5;
            border: 1px solid #f8d7da;
            border-left: 5px solid #aa2324;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .callback-box h3 {
            color: #aa2324;
            font-size: 1.2rem;
            font-weight: 700;
            margin: 0;
        }

        .callback-box p {
            color: #555;
            font-size: 0.9rem;
            margin: 5px 0 0;
        }

        .callback-btn {
            padding: 12px 24px;
            background: #aa2324;
            color: #fff;
            border-radius: 4px;
            font-weight: 700;
            text-decoration: none;
            text-transform: uppercase;
            font-size: 0.85rem;
            transition: 0.3s;
            white-space: nowrap;
            box-shadow: 0 4px 10px rgba(170, 35, 36, 0.2);
        }

        .callback-btn:hover {
            background: #8e1d1e;
            transform: translateY(-2px);
        }

        /* FORM GRID LAYOUT */
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
            font-size: 0.8rem;
            color: #333;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            background: #fdfdfd;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 15px;
            color: #333;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: #aa2324;
            background: #fff;
            outline: none;
            box-shadow: 0 0 0 3px rgba(170, 35, 36, 0.05);
        }

        /* CITY SELECTION (Checkboxes) */
        .city-selection {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            padding: 20px;
            background: #f9f9f9;
            border: 1px solid #eee;
            border-radius: 8px;
        }

        .city-option {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.9rem;
            color: #444;
            cursor: pointer;
        }

        .city-option input {
            accent-color: #aa2324;
            width: 18px;
            height: 18px;
        }

        /* DROP-DOWN STYLING */
        .form-group select {
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23aa2324' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 15px center;
            background-size: 15px;
        }

        .form-group select option {
            background: #fff;
            color: #333;
        }

        /* SUBMIT BUTTON (IITM Formal) */
        .submit-btn {
            margin-top: 40px;
            width: 100%;
            padding: 20px;
            background: #111;
            /* Dark contrast */
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 1.1rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            cursor: pointer;
            transition: 0.4s;
        }

        .submit-btn:hover {
            background: #aa2324;
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(170, 35, 36, 0.2);
        }

        /* RESPONSIVE DESIGN */
        @media (max-width: 768px) {
            .enquiry-section {
                padding: 40px 15px;
            }

            .form-container {
                padding: 30px 20px;
            }

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

            .callback-btn {
                width: 100%;
                text-align: center;
            }
        }
    </style>

    @include('web.participant.form.enquiryformfields')