<!-- =========================================================
     RELATED SERVICES
========================================================== -->

<div id="related_question" class="conditional-question" data-category="Related services">

    <label class="sub-question-title">
        What type of business does the company operate?
    </label>

    <span class="sub-question-description">
        Select the company's primary business type or service area.
    </span>

    <select name="business_type" class="form-control conditional-input">

        <option value="">Select a business type</option>

        <option value="Marketing & Sales">Marketing & Sales</option>
        <option value="Finance & Accounting">Finance & Accounting</option>
        <option value="Human Resources">Human Resources (HR)</option>
        <option value="Operations">Operations</option>
        <option value="Production / Manufacturing">Production / Manufacturing</option>
        <option value="Research & Development">Research & Development (R&D)</option>
        <option value="Procurement & Purchasing">Procurement & Purchasing</option>
        <option value="Supply Chain & Logistics">Supply Chain & Logistics</option>
        <option value="Customer Service">Customer Service</option>
        <option value="Information Technology">Information Technology (IT)</option>
        <option value="Legal & Compliance">Legal & Compliance</option>
        <option value="Strategy & Management">Strategy & Management</option>
        <option value="Other">Other</option>

    </select>


    <!-- Business Services -->
    <div class="sub-question">

        <label class="sub-question-title">
            What products or services does the company provide?
        </label>

        <span class="sub-question-description">
            Select all services that apply.
        </span>

        <div class="option-grid">

            <div class="option">
                <input type="checkbox" id="related_catering" name="business_services[]" value="Catering"
                    class="conditional-input">
                <label for="related_catering">
                    Catering
                </label>
            </div>

            <div class="option">
                <input type="checkbox" id="related_manpower" name="business_services[]" value="Manpower / Staffing"
                    class="conditional-input">
                <label for="related_manpower">
                    Manpower / Staffing
                </label>
            </div>

            <div class="option">
                <input type="checkbox" id="related_furniture" name="business_services[]" value="Furniture"
                    class="conditional-input">
                <label for="related_furniture">
                    Furniture
                </label>
            </div>

            <div class="option">
                <input type="checkbox" id="related_machinery" name="business_services[]" value="Machinery / Equipment"
                    class="conditional-input">
                <label for="related_machinery">
                    Machinery / Equipment
                </label>
            </div>

            <div class="option">
                <input type="checkbox" id="related_consulting" name="business_services[]" value="Consulting"
                    class="conditional-input">
                <label for="related_consulting">
                    Consulting
                </label>
            </div>

            <div class="option">
                <input type="checkbox" id="related_software" name="business_services[]" value="Software / Technology"
                    class="conditional-input">
                <label for="related_software">
                    Software / Technology
                </label>
            </div>

            <div class="option">
                <input type="checkbox" id="related_real_estate" name="business_services[]" value="Real Estate"
                    class="conditional-input">
                <label for="related_real_estate">
                    Real Estate
                </label>
            </div>

            <div class="option">
                <input type="checkbox" id="related_finance" name="business_services[]"
                    value="Finance / Financial Services" class="conditional-input">
                <label for="related_finance">
                    Finance / Financial Services
                </label>
            </div>

            <div class="option">
                <input type="checkbox" id="related_transportation" name="business_services[]" value="Transportation"
                    class="conditional-input">
                <label for="related_transportation">
                    Transportation
                </label>
            </div>

            <div class="option">
                <input type="checkbox" id="related_logistics" name="business_services[]" value="Logistics"
                    class="conditional-input">
                <label for="related_logistics">
                    Logistics
                </label>
            </div>

            <div class="option">
                <input type="checkbox" id="related_other_service" name="business_services[]" value="Other"
                    class="conditional-input">
                <label for="related_other_service">
                    Other
                </label>
            </div>

        </div>

    </div>


    <!-- Business Description -->
    <div class="sub-question">

        <label class="sub-question-title" for="business_description">
            Describe the product or service your company provides.
        </label>

        <span class="sub-question-description">
            Briefly describe the service and the type of travel or hospitality
            businesses that typically use it.
        </span>

        <textarea id="business_description" name="business_description" class="form-control conditional-input" rows="4"
            placeholder="Example: We provide accounting, staffing and software services to hotels, resorts and travel agencies."></textarea>

    </div>


    <!-- Current Business -->
    <div class="sub-question">

        <label class="sub-question-title">
            Do you currently provide this service to travel or hospitality businesses?
        </label>

        <div class="option-grid">

            <div class="option">
                <input type="radio" id="related_current_yes" name="related_current_business" value="Yes"
                    class="conditional-input">
                <label for="related_current_yes">
                    Yes
                </label>
            </div>

            <div class="option">
                <input type="radio" id="related_current_no" name="related_current_business" value="No"
                    class="conditional-input">
                <label for="related_current_no">
                    No
                </label>
            </div>

        </div>

    </div>

</div>