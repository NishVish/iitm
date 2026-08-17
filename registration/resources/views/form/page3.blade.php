<div class="question-card">
    @include('form.maincategory')
    @include('form.travelsub')
    @include('form.hospitalitysub')
    @include('form.relatedservices')



    <!-- =========================================================
     NOT RELATED
========================================================== -->

    <div id="not_related_question" class="conditional-question" data-category="Not related">

        <label class="sub-question-title">
            What is the nature of your business?
        </label>

        <span class="sub-question-description">
            Select the option that best describes your company's main business activity.
        </span>

        <div class="option-grid">

            <div class="option">
                <input type="checkbox" id="nature_retail" name="business_nature[]" value="Retail"
                    class="conditional-input">
                <label for="nature_retail">Retail</label>
            </div>

            <div class="option">
                <input type="checkbox" id="nature_wholesale" name="business_nature[]" value="Wholesale"
                    class="conditional-input">
                <label for="nature_wholesale">Wholesale</label>
            </div>

            <div class="option">
                <input type="checkbox" id="nature_manufacturing" name="business_nature[]" value="Manufacturing"
                    class="conditional-input">
                <label for="nature_manufacturing">Manufacturing</label>
            </div>

            <div class="option">
                <input type="checkbox" id="nature_services" name="business_nature[]" value="Professional Services"
                    class="conditional-input">
                <label for="nature_services">Professional Services</label>
            </div>

            <div class="option">
                <input type="checkbox" id="nature_technology" name="business_nature[]" value="Technology / IT"
                    class="conditional-input">
                <label for="nature_technology">Technology / IT</label>
            </div>

            <div class="option">
                <input type="checkbox" id="nature_finance" name="business_nature[]" value="Finance / Banking"
                    class="conditional-input">
                <label for="nature_finance">Finance / Banking</label>
            </div>

            <div class="option">
                <input type="checkbox" id="nature_healthcare" name="business_nature[]" value="Healthcare"
                    class="conditional-input">
                <label for="nature_healthcare">Healthcare</label>
            </div>

            <div class="option">
                <input type="checkbox" id="nature_education" name="business_nature[]" value="Education / Training"
                    class="conditional-input">
                <label for="nature_education">Education / Training</label>
            </div>

            <div class="option">
                <input type="checkbox" id="nature_construction" name="business_nature[]"
                    value="Construction / Real Estate" class="conditional-input">
                <label for="nature_construction">Construction / Real Estate</label>
            </div>

            <div class="option">
                <input type="checkbox" id="nature_transport" name="business_nature[]" value="Transport / Logistics"
                    class="conditional-input">
                <label for="nature_transport">Transport / Logistics</label>
            </div>

            <div class="option">
                <input type="checkbox" id="nature_agriculture" name="business_nature[]" value="Agriculture / Food"
                    class="conditional-input">
                <label for="nature_agriculture">Agriculture / Food</label>
            </div>

            <div class="option">
                <input type="checkbox" id="nature_media" name="business_nature[]" value="Media / Entertainment"
                    class="conditional-input">
                <label for="nature_media">Media / Entertainment</label>
            </div>

            <div class="option">
                <input type="checkbox" id="nature_consulting" name="business_nature[]" value="Consulting"
                    class="conditional-input">
                <label for="nature_consulting">Consulting</label>
            </div>

            <div class="option">
                <input type="checkbox" id="nature_other" name="business_nature[]" value="Other"
                    class="conditional-input">
                <label for="nature_other">Other</label>
            </div>
            <div class="option">
                <input type="checkbox" id="nature_individual" name="business_nature[]" value="Individual"
                    class="conditional-input">
                <label for="nature_individual">Individual</label>
            </div>
        </div>

        <div class="sub-question">

            <label class="sub-question-title">
                Please describe your main business activity.
            </label>

            <span class="sub-question-description">
                Briefly describe what your company does and the products or services it provides.
            </span>

            <textarea name="business_nature_description" class="form-control conditional-input" rows="4"
                placeholder="Example: We manufacture and distribute packaging materials for food and beverage companies."></textarea>

        </div>


    </div>

</div>


<style>
    .sub-question {
        margin-top: 24px;
        padding-top: 20px;
        border-top: 1px solid #f1f5f9;
    }


    .conditional-question {
        display: none;
        margin-top: 24px;
        padding-top: 24px;
        border-top: 1px solid #e5e7eb;
    }


    .conditional-question.active {
        display: block;
        animation: conditionalFadeIn 0.25s ease;
    }


    .nested-conditional-question {
        display: none;
        margin-top: 20px;
        padding: 18px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
    }


    .nested-conditional-question.active {
        display: block;
        animation: conditionalFadeIn 0.2s ease;
    }


    .sub-question-title {
        display: block;
        font-size: 15px;
        font-weight: 600;
        color: #111827;
        margin-bottom: 7px;
    }


    .sub-question-description {
        display: block;
        font-size: 13px;
        line-height: 1.5;
        color: #6b7280;
        margin-bottom: 13px;
    }


    .conditional-question select,
    .conditional-question input[type="text"],
    .conditional-question input[type="number"],
    .conditional-question textarea {
        width: 100%;
        box-sizing: border-box;
    }


    @keyframes conditionalFadeIn {
        from {
            opacity: 0;
            transform: translateY(6px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>


<script>
    document.addEventListener('DOMContentLoaded', function () {

        const categoryInputs = document.querySelectorAll(
            'input[name="company_category"]'
        );


        const conditionalQuestions = document.querySelectorAll(
            '.conditional-question'
        );


        const businessServiceRadios = document.querySelectorAll(
            'input[name="not_related_business"]'
        );


        const businessServiceDetails = document.getElementById(
            'not_related_business_details'
        );


        const businessServiceDescription =
            document.getElementById(
                'not_related_business_description'
            );


        /*
         * ---------------------------------------------------------
         * MAIN CATEGORY
         * ---------------------------------------------------------
         */

        function updateCategoryQuestions() {

            const selectedCategory = document.querySelector(
                'input[name="company_category"]:checked'
            );


            const selectedValue = selectedCategory
                ? selectedCategory.value
                : null;


            conditionalQuestions.forEach(function (question) {

                const shouldShow =
                    question.dataset.category === selectedValue;


                question.classList.toggle(
                    'active',
                    shouldShow
                );


                /*
                 * Disable inputs inside hidden sections.
                 *
                 * This is important because hidden conditional
                 * questions should not be validated or submitted.
                 */

                question
                    .querySelectorAll(
                        'input, select, textarea'
                    )
                    .forEach(function (field) {

                        field.disabled = !shouldShow;

                    });

            });


            /*
             * If user changes away from Not Related,
             * hide the nested question.
             */

            if (selectedValue !== 'Not related') {

                businessServiceDetails.classList.remove(
                    'active'
                );

                if (businessServiceDescription) {
                    businessServiceDescription.disabled = true;
                    businessServiceDescription.value = '';
                }

            }

        }


        /*
         * ---------------------------------------------------------
         * NOT RELATED -> BUSINESS SERVICE
         * ---------------------------------------------------------
         */

        function updateBusinessServiceQuestion() {

            const selected = document.querySelector(
                'input[name="not_related_business"]:checked'
            );


            if (
                selected &&
                selected.value === 'Yes'
            ) {

                businessServiceDetails.classList.add(
                    'active'
                );

                if (businessServiceDescription) {
                    businessServiceDescription.disabled = false;
                }

            } else {

                businessServiceDetails.classList.remove(
                    'active'
                );

                if (businessServiceDescription) {
                    businessServiceDescription.disabled = true;
                    businessServiceDescription.value = '';
                }

            }

        }


        /*
         * Main category change.
         */

        categoryInputs.forEach(function (input) {

            input.addEventListener(
                'change',
                updateCategoryQuestions
            );

        });


        /*
         * Not-related business question change.
         */

        businessServiceRadios.forEach(function (radio) {

            radio.addEventListener(
                'change',
                updateBusinessServiceQuestion
            );

        });


        /*
         * Initial state.
         */

        updateCategoryQuestions();
        updateBusinessServiceQuestion();

    });
</script>