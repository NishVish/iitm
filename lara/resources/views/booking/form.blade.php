<form method="POST" action="{{url('/finalize-lead')}}">
    @csrf

    <style>
        body {
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background: #f4f7f9;
            margin: 0;
            color: #2d3436;
        }

        .container-box {
            max-width: 800px;
            margin: 20px auto;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid #ddd;
        }

        /* IITM Branding Header within Form */
        .iitm-accent-bar {
            height: 5px;
            background: linear-gradient(90deg, #ed1c24 0%, #ed1c24 50%, #0054a6 50%, #0054a6 100%);
        }

        /* Step Navigation - Ticket Stub Style */
        .step-tabs {
            display: flex;
            background: #f8f9fa;
            border-bottom: 1px solid #eee;
            padding: 0;
        }

        .step-tabs button {
            flex: 1;
            border: none;
            background: transparent;
            padding: 15px;
            cursor: pointer;
            font-weight: bold;
            font-size: 13px;
            color: #666;
            transition: all 0.3s;
            border-right: 1px dashed #ddd;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .step-tabs button:last-child {
            border-right: none;
        }

        .step-tabs button.active {
            background: #fff;
            color: #0054a6;
            /* IITM Blue */
            box-shadow: inset 0 -3px 0 #0054a6;
        }

        .step-tabs button .step-num {
            display: block;
            font-size: 10px;
            color: #ed1c24;
            /* IITM Red */
        }

        /* Content Area */
        .step-content {
            padding: 30px;
            min-height: 300px;
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(10px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .step h3 {
            margin-top: 0;
            color: #0054a6;
            font-size: 18px;
            border-left: 4px solid #ed1c24;
            padding-left: 10px;
            margin-bottom: 20px;
        }

        /* Footer */
        .form-footer {
            background: #f8f9fa;
            padding: 15px 30px;
            border-top: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .form-footer button {
            background: #0054a6;
            border: none;
            color: #fff;
            padding: 12px 28px;
            border-radius: 4px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.2s;
            text-transform: uppercase;
        }

        .form-footer button:hover {
            background: #003d7a;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-prev {
            background: transparent !important;
            color: #666 !important;
            border: 1px solid #ccc !important;
        }
    </style>

    <div class="container-box">
        <div class="iitm-accent-bar"></div>

        {{-- STEP NAVIGATION --}}
        <div class="step-tabs">
            <button type="button" onclick="showStep(1)" id="tab-1">
                <span class="step-num">STEP 01</span> PERSONAL
            </button>
            <button type="button" onclick="showStep(2)" id="tab-2">
                <span class="step-num">STEP 02</span> COMPANY
            </button>
            <button type="button" onclick="showStep(3)" id="tab-3">
                <span class="step-num">STEP 03</span> LEAD
            </button>
        </div>

        <div class="step-content">
            <div id="step-1" class="step">
                @include('booking.personalinfo')
            </div>

            <div id="step-2" class="step">
                @include('booking.companyinfo')
            </div>

            <div id="step-3" class="step">
                @include('booking.leadinfo')
            </div>
        </div>

        <div class="form-footer">
            <button type="button" class="btn-prev" onclick="prevStep()" id="prevBtn">← Back</button>
            <button type="submit" id="nextBtn">Next Step →</button>
        </div>
    </div>
</form>

<script>
    let currentStep = 1;
    const totalSteps = 3;

    function showStep(step) {
        if (step < 1 || step > totalSteps) return;
        currentStep = step;

        // Toggle Steps
        document.querySelectorAll('.step').forEach(el => el.style.display = 'none');
        document.getElementById('step-' + step).style.display = 'block';

        // Toggle Tabs
        document.querySelectorAll('.step-tabs button').forEach(btn => btn.classList.remove('active'));
        document.getElementById('tab-' + step).classList.add('active');

        // Update Footer Buttons
        document.getElementById('prevBtn').style.visibility = (step === 1) ? 'hidden' : 'visible';
        document.getElementById('nextBtn').innerText = (step === totalSteps) ? 'Finalize Registration' : 'Next Step →';

        if (step === totalSteps) {
            document.getElementById('nextBtn').style.background = '#ed1c24'; // Red for final action
        } else {
            document.getElementById('nextBtn').style.background = '#0054a6';
        }
    }

    function prevStep() {
        showStep(currentStep - 1);
    }

    // Initialize
    showStep(1);
</script>