@include('form.header')
<form action="{{ url('register') }}/mumbai/2000" method="post" class="register-form" id="registerForm">
    @csrf

    <style>
        .form-step-indicator {
            display: flex;
            align-items: center;
            justify-content: center;
            max-width: 800px;
            margin: 30px auto 40px;
            padding: 0 20px;
        }

        .form-step {
            display: flex;
            flex-direction: column;
            align-items: center;
            min-width: 110px;
            color: #94a3b8;
            transition: all 0.3s ease;
        }

        .form-step.active {
            color: #2563eb;
        }

        .form-step.completed {
            color: #16a34a;
        }

        .step-circle {
            width: 46px;
            height: 46px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            font-weight: 700;
            background: #f1f5f9;
            border: 2px solid #e2e8f0;
            margin-bottom: 8px;
            transition: all 0.3s ease;
        }

        .form-step.active .step-circle {
            color: #fff;
            background: #2563eb;
            border-color: #2563eb;
            box-shadow: 0 0 0 6px rgba(37, 99, 235, 0.12);
        }

        .form-step.completed .step-circle {
            color: #fff;
            background: #16a34a;
            border-color: #16a34a;
        }

        .step-title {
            font-size: 14px;
            font-weight: 600;
            text-align: center;
            white-space: nowrap;
        }

        .step-line {
            flex: 1;
            height: 2px;
            max-width: 160px;
            background: #e2e8f0;
            margin: 0 10px 30px;
            transition: background 0.3s ease;
        }

        .step-line.completed {
            background: #16a34a;
        }

        .form-page {
            display: none;
            max-width: 900px;
            margin: 0 auto 25px;
            padding: 30px;
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.06);
        }

        .form-page.active {
            display: block;
            animation: fadeIn 0.25s ease;
        }

        .form-navigation {
            max-width: 900px;
            margin: 0 auto 40px;
            padding: 0 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
        }

        .form-navigation button {
            min-width: 130px;
            padding: 12px 24px;
            border: 0;
            border-radius: 9px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-back {
            background: #f1f5f9;
            color: #334155;
        }

        .btn-back:hover {
            background: #e2e8f0;
        }

        .btn-next,
        .btnRegister {
            background: #2563eb;
            color: #fff;
        }

        .btn-next:hover,
        .btnRegister:hover {
            background: #1d4ed8;
        }

        .btnRegister {
            border: 0;
            border-radius: 9px;
            padding: 12px 28px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
        }

        .form-error {
            display: none;
            margin-top: 8px;
            padding: 10px 12px;
            color: #b91c1c;
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 8px;
            font-size: 13px;
        }

        .field-error {
            border-color: #dc2626 !important;
            box-shadow: 0 0 0 2px rgba(220, 38, 38, 0.08) !important;
        }

        .form-group {
            margin-bottom: 18px;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 600px) {
            .form-step-indicator {
                padding: 0 5px;
            }

            .form-step {
                min-width: 80px;
            }

            .step-title {
                font-size: 12px;
                white-space: normal;
            }

            .step-circle {
                width: 40px;
                height: 40px;
            }

            .step-line {
                margin-left: 4px;
                margin-right: 4px;
                margin-bottom: 30px;
            }

            .form-page {
                margin: 0 15px 20px;
                padding: 20px;
                border-radius: 12px;
            }

            .form-navigation {
                padding: 0 15px;
            }

            .form-navigation button {
                min-width: 110px;
            }
        }
    </style>

    <!-- STEP INDICATOR -->
    <div class="form-step-indicator">
        <div class="form-step active" data-step="1">
            <div class="step-circle">1</div>
            <div class="step-title">Person</div>
        </div>

        <div class="step-line" data-line="1"></div>

        <div class="form-step" data-step="2">
            <div class="step-circle">2</div>
            <div class="step-title">Company</div>
        </div>

        <div class="step-line" data-line="2"></div>

        <div class="form-step" data-step="3">
            <div class="step-circle">3</div>
            <div class="step-title">Background Check</div>
        </div>
    </div>

    <!-- PAGE 1 -->
    <div class="form-page active" data-page="1">
        @include('form.page1')
    </div>

    <!-- PAGE 2 -->
    <div class="form-page" data-page="2">
        @include('form.page2')
    </div>

    <!-- PAGE 3 -->
    <div class="form-page" data-page="3">
        @include('form.page3')
    </div>

    <!-- NAVIGATION -->
    <div class="form-navigation">
        <button type="button" class="btn-back" id="prevButton" style="display: none;">
            ← Back
        </button>

        <div></div>

        <button type="button" class="btn-next" id="nextButton">
            Next →
        </button>

        <button type="submit" class="btnRegister" id="submitButton" style="display: none;">
            Submit
        </button>
    </div>

    <div id="validationError" class="form-error" style="max-width: 900px; margin: -25px auto 30px;">
        Please complete all required fields before continuing.
    </div>

    <!-- intl-tel-input CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@25.3.1/build/css/intlTelInput.css">

    <!-- intl-tel-input JS -->
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@25.3.1/build/js/intlTelInput.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('registerForm');

            const steps = document.querySelectorAll('.form-step');
            const lines = document.querySelectorAll('.step-line');
            const pages = document.querySelectorAll('.form-page');

            const nextButton = document.getElementById('nextButton');
            const prevButton = document.getElementById('prevButton');
            const submitButton = document.getElementById('submitButton');
            const validationError = document.getElementById('validationError');

            let currentPage = 1;
            const totalPages = pages.length;

            /*
             * ---------------------------------------------------------
             * MOBILE PHONE
             * ---------------------------------------------------------
             */

            const countryHiddenInput = document.querySelector('#countryCode');
            const mobileInput = document.querySelector('#mobile');

            let mobileITI = null;

            if (mobileInput && window.intlTelInput) {
                mobileITI = window.intlTelInput(mobileInput, {
                    initialCountry: 'in',
                    nationalMode: true,
                    separateDialCode: true,
                    autoPlaceholder: 'aggressive',
                    strictMode: true,
                    loadUtils: () =>
                        import(
                            'https://cdn.jsdelivr.net/npm/intl-tel-input@25.3.1/build/js/utils.js'
                        )
                });

                function updateCountryCode() {
                    if (!countryHiddenInput || !mobileITI) {
                        return;
                    }

                    const countryData = mobileITI.getSelectedCountryData();

                    if (countryData && countryData.dialCode) {
                        countryHiddenInput.value = '+' + countryData.dialCode;
                    }
                }

                setTimeout(updateCountryCode, 300);

                mobileInput.addEventListener('countrychange', updateCountryCode);

                mobileInput.addEventListener('blur', function () {
                    if (!mobileInput.value.trim()) {
                        mobileInput.classList.remove('is-valid');
                        mobileInput.classList.remove('is-invalid');
                        return;
                    }

                    if (mobileITI.isValidNumber()) {
                        mobileInput.classList.remove('is-invalid');
                        mobileInput.classList.add('is-valid');
                    } else {
                        mobileInput.classList.remove('is-valid');
                        mobileInput.classList.add('is-invalid');
                    }
                });
            }

            /*
             * ---------------------------------------------------------
             * PAGE SWITCHING
             * ---------------------------------------------------------
             */

            function showPage(pageNumber) {
                currentPage = pageNumber;

                pages.forEach(function (page) {
                    page.classList.toggle(
                        'active',
                        Number(page.dataset.page) === pageNumber
                    );
                });

                steps.forEach(function (step) {
                    const stepNumber = Number(step.dataset.step);

                    step.classList.toggle(
                        'active',
                        stepNumber === pageNumber
                    );

                    step.classList.toggle(
                        'completed',
                        stepNumber < pageNumber
                    );
                });

                lines.forEach(function (line) {
                    const lineNumber = Number(line.dataset.line);

                    line.classList.toggle(
                        'completed',
                        lineNumber < pageNumber
                    );
                });

                prevButton.style.display =
                    pageNumber > 1 ? 'inline-block' : 'none';

                nextButton.style.display =
                    pageNumber < totalPages ? 'inline-block' : 'none';

                submitButton.style.display =
                    pageNumber === totalPages ? 'inline-block' : 'none';

                validationError.style.display = 'none';

                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }

            /*
             * ---------------------------------------------------------
             * VALIDATION
             * ---------------------------------------------------------
             *
             * Only fields on the current page are validated.
             * Hidden pages will NOT block the user from moving forward.
             */

            function validateCurrentPage() {
                const currentPageElement = document.querySelector(
                    '.form-page[data-page="' + currentPage + '"]'
                );

                if (!currentPageElement) {
                    return true;
                }

                let firstInvalidField = null;
                let isValid = true;

                validationError.style.display = 'none';

                /*
                 * Remove previous error styling.
                 */
                currentPageElement
                    .querySelectorAll('.field-error')
                    .forEach(function (field) {
                        field.classList.remove('field-error');
                    });

                /*
                 * Validate required inputs, selects and textareas.
                 */
                const fields = currentPageElement.querySelectorAll(
                    'input, select, textarea'
                );

                fields.forEach(function (field) {
                    if (
                        field.disabled ||
                        field.type === 'hidden' ||
                        field.offsetParent === null
                    ) {
                        return;
                    }

                    /*
                     * Radio buttons are handled separately below.
                     */
                    if (field.type === 'radio') {
                        return;
                    }

                    /*
                     * Checkbox validation.
                     */
                    if (field.type === 'checkbox') {
                        if (field.required && !field.checked) {
                            isValid = false;

                            if (!firstInvalidField) {
                                firstInvalidField = field;
                            }
                        }

                        return;
                    }

                    /*
                     * Required field validation.
                     */
                    if (
                        field.required &&
                        !field.value.trim()
                    ) {
                        isValid = false;

                        field.classList.add('field-error');

                        if (!firstInvalidField) {
                            firstInvalidField = field;
                        }

                        return;
                    }

                    /*
                     * Native validation for email, URL, etc.
                     */
                    if (
                        field.value.trim() &&
                        !field.checkValidity()
                    ) {
                        isValid = false;

                        field.classList.add('field-error');

                        if (!firstInvalidField) {
                            firstInvalidField = field;
                        }
                    }
                });

                /*
                 * Validate required radio groups.
                 */
                const radioNames = new Set();

                currentPageElement
                    .querySelectorAll(
                        'input[type="radio"][required]'
                    )
                    .forEach(function (radio) {
                        if (!radio.disabled) {
                            radioNames.add(radio.name);
                        }
                    });

                radioNames.forEach(function (name) {
                    const checked = currentPageElement.querySelector(
                        'input[type="radio"][name="' +
                        CSS.escape(name) +
                        '"]:checked'
                    );

                    if (!checked) {
                        isValid = false;

                        const firstRadio = currentPageElement.querySelector(
                            'input[type="radio"][name="' +
                            CSS.escape(name) +
                            '"]'
                        );

                        if (
                            firstRadio &&
                            !firstInvalidField
                        ) {
                            firstInvalidField = firstRadio;
                        }
                    }
                });

                /*
                 * Special mobile number validation.
                 */
                if (
                    mobileInput &&
                    mobileInput.required &&
                    mobileInput.closest('.form-page') === currentPageElement &&
                    mobileInput.offsetParent !== null
                ) {
                    if (!mobileInput.value.trim()) {
                        isValid = false;
                        mobileInput.classList.add('field-error');

                        if (!firstInvalidField) {
                            firstInvalidField = mobileInput;
                        }
                    } else if (
                        mobileITI &&
                        !mobileITI.isValidNumber()
                    ) {
                        isValid = false;
                        mobileInput.classList.add('field-error');

                        if (!firstInvalidField) {
                            firstInvalidField = mobileInput;
                        }
                    }
                }

                if (!isValid) {
                    validationError.style.display = 'block';

                    if (firstInvalidField) {
                        firstInvalidField.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });

                        setTimeout(function () {
                            try {
                                firstInvalidField.focus();
                            } catch (error) { }
                        }, 300);
                    }

                    return false;
                }

                return true;
            }

            /*
             * ---------------------------------------------------------
             * NEXT BUTTON
             * ---------------------------------------------------------
             */

            nextButton.addEventListener('click', function () {
                if (!validateCurrentPage()) {
                    return;
                }

                if (currentPage < totalPages) {
                    showPage(currentPage + 1);
                }
            });

            /*
             * ---------------------------------------------------------
             * BACK BUTTON
             * ---------------------------------------------------------
             */

            prevButton.addEventListener('click', function () {
                if (currentPage > 1) {
                    showPage(currentPage - 1);
                }
            });

            /*
             * ---------------------------------------------------------
             * FINAL SUBMIT
             * ---------------------------------------------------------
             *
             * Validate every page before submitting.
             */

            form.addEventListener('submit', function (event) {
                /*
                 * Validate the current page first.
                 */
                if (!validateCurrentPage()) {
                    event.preventDefault();
                    return;
                }

                /*
                 * Validate all pages before final submission.
                 */
                let allPagesValid = true;
                let firstInvalidPage = null;

                for (let pageNumber = 1; pageNumber <= totalPages; pageNumber++) {
                    currentPage = pageNumber;

                    if (!validateCurrentPage()) {
                        allPagesValid = false;
                        firstInvalidPage = pageNumber;
                        break;
                    }
                }

                if (!allPagesValid) {
                    event.preventDefault();

                    showPage(firstInvalidPage);
                    validateCurrentPage();

                    return;
                }

                /*
                 * Restore the final page state.
                 */
                showPage(totalPages);

                /*
                 * Convert the mobile number to full E.164 format.
                 */
                if (
                    mobileITI &&
                    mobileInput &&
                    mobileInput.value.trim()
                ) {
                    if (!mobileITI.isValidNumber()) {
                        event.preventDefault();

                        mobileInput.classList.add('field-error');
                        validationError.textContent =
                            'Please enter a valid mobile number.';
                        validationError.style.display = 'block';

                        mobileInput.focus();

                        return;
                    }

                    mobileInput.value = mobileITI.getNumber();

                    if (countryHiddenInput) {
                        const countryData =
                            mobileITI.getSelectedCountryData();

                        if (
                            countryData &&
                            countryData.dialCode
                        ) {
                            countryHiddenInput.value =
                                '+' + countryData.dialCode;
                        }
                    }
                }
            });

            /*
             * ---------------------------------------------------------
             * REMOVE ERROR WHEN USER FIXES FIELD
             * ---------------------------------------------------------
             */

            form.addEventListener('input', function (event) {
                const field = event.target;

                if (
                    field.matches(
                        'input, select, textarea'
                    )
                ) {
                    if (field.value.trim()) {
                        field.classList.remove('field-error');
                    }

                    validationError.style.display = 'none';
                }
            });

            form.addEventListener('change', function (event) {
                const field = event.target;

                if (
                    field.matches(
                        'input, select, textarea'
                    )
                ) {
                    field.classList.remove('field-error');

                    validationError.style.display = 'none';
                }
            });

            /*
             * ---------------------------------------------------------
             * INITIAL PAGE
             * ---------------------------------------------------------
             */

            showPage(1);
        });
    </script>
    <!-- </form><button type="button" id="fillDummyDetails" class="btn btn-primary">
    Fill Dummy Details
</button> -->

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            document.getElementById('fillDummyDetails').addEventListener('click', function () {

                document.querySelector('select[name="title"]').value = 'Mr.';

                document.querySelector('input[name="select2"]').value = 'Rahul';

                document.querySelector('input[name="lastname"]').value = 'Sharma';

                document.querySelector('input[name="designation"]').value = 'Travel Manager';

                document.querySelector('input[name="organisation"]').value = 'Global Travel Solutions';

                document.querySelector('input[name="email"]').value = 'rahul.sharma@example.com';

                document.querySelector('input[name="pincode"]').value = '560001';

            });

        });

    </script>