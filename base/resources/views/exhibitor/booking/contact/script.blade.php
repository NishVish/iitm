<script>
    function updateBillingContactValues() {
        const rows = document.querySelectorAll(
            '#contacts-table-body .contact-row'
        );

        rows.forEach(row => {
            const radio = row.querySelector('.billing-radio');
            const billingValue = row.querySelector('.billing-contact-value');

            if (radio && billingValue) {
                billingValue.value = radio.checked ? '1' : '0';
            }
        });
    }

    function bindBillingRadioEvents() {
        const radios = document.querySelectorAll(
            '#contacts-table-body .billing-radio'
        );

        radios.forEach(radio => {
            radio.removeEventListener('change', handleBillingRadioChange);
            radio.addEventListener('change', handleBillingRadioChange);
        });
    }

    function handleBillingRadioChange() {
        updateBillingContactValues();
    }

    function reindexContactRows() {
        const rows = document.querySelectorAll(
            '#contacts-table-body .contact-row'
        );

        rows.forEach((row, index) => {
            row.setAttribute('data-index', index);

            const rowNumber = row.querySelector('.row-number');

            if (rowNumber) {
                rowNumber.innerText = index + 1;
            }

            const radio = row.querySelector('.billing-radio');

            if (radio) {
                radio.value = index;
            }

            row.querySelectorAll('input').forEach(input => {
                const name = input.getAttribute('name');

                if (name) {
                    input.setAttribute(
                        'name',
                        name.replace(
                            /contacts\[\d+\]/,
                            `contacts[${index}]`
                        )
                    );
                }
            });

            const removeButton = row.querySelector('.ui-btn-danger');

            if (removeButton) {
                removeButton.style.display =
                    index === 0 ? 'none' : 'inline-flex';
            }
        });

        updateBillingContactValues();
    }

    function addContactRow() {
        const tbody = document.getElementById('contacts-table-body');

        const rows = tbody.querySelectorAll('.contact-row');

        const index = rows.length;

        const companyId = @json($company_id ?? '');

        const tr = document.createElement('tr');

        tr.className = 'contact-row';

        tr.setAttribute('data-index', index);

        tr.innerHTML = `
            <td class="row-number fw-bold text-secondary">
                ${index + 1}
            </td>

            <td class="billing-radio-cell">

                <input
                    type="hidden"
                    name="contacts[${index}][company_id]"
                    value="${companyId}"
                >

                <input
                    type="hidden"
                    name="contacts[${index}][billing_contact]"
                    value="0"
                    class="billing-contact-value"
                >

                <label class="ui-radio-label">
                    <input
                        type="radio"
                        name="billing_contact_index"
                        value="${index}"
                        class="billing-radio"
                    >
                </label>

            </td>

            <td>
                <input
                    type="text"
                    name="contacts[${index}][name]"
                    class="ui-input"
                    placeholder="Full Name"
                    required
                >
            </td>

            <td>
                <input
                    type="text"
                    name="contacts[${index}][designation]"
                    class="ui-input"
                    placeholder="Job Title"
                >
            </td>

            <td>
                <input
                    type="email"
                    name="contacts[${index}][email]"
                    class="ui-input"
                    placeholder="name@company.com"
                    required
                >
            </td>

            <td>
                <input
                    type="tel"
                    name="contacts[${index}][mobile]"
                    class="ui-input"
                    placeholder="+91 00000 00000"
                >
            </td>

            <td style="text-align: center;">
                <button
                    type="button"
                    class="ui-btn-danger"
                    onclick="removeContactRow(this)"
                >
                    Remove
                </button>
            </td>
        `;

        tbody.appendChild(tr);

        bindBillingRadioEvents();

        updateBillingContactValues();
    }

    function removeContactRow(btn) {
        const row = btn.closest('.contact-row');

        if (!row) {
            return;
        }

        const wasBillingContact =
            row.querySelector('.billing-radio')?.checked === true;

        row.remove();

        const rows = document.querySelectorAll(
            '#contacts-table-body .contact-row'
        );

        if (rows.length === 0) {
            return;
        }

        reindexContactRows();

        if (wasBillingContact) {
            const firstRadio = rows[0].querySelector('.billing-radio');

            if (firstRadio) {
                firstRadio.checked = true;
            }
        }

        updateBillingContactValues();

        bindBillingRadioEvents();
    }

    document.addEventListener('DOMContentLoaded', function () {

        const rows = document.querySelectorAll(
            '#contacts-table-body .contact-row'
        );

        /*
         * The existing billing_contact value from the database
         * determines which radio button is checked.
         *
         * billing_contact = 1 => checked
         * billing_contact = 0 => unchecked
         */

        let checkedRadio = document.querySelector(
            '#contacts-table-body .billing-radio:checked'
        );

        /*
         * If there is no billing contact in the database,
         * make the first contact the billing contact.
         */
        if (!checkedRadio && rows.length > 0) {

            const firstRadio = rows[0].querySelector('.billing-radio');

            if (firstRadio) {
                firstRadio.checked = true;
            }
        }

        bindBillingRadioEvents();

        updateBillingContactValues();

        /*
         * Before submitting:
         *
         * Selected contact => billing_contact = 1
         * All other contacts => billing_contact = 0
         */
        document.getElementById('contacts-form').addEventListener(
            'submit',
            function () {
                updateBillingContactValues();
            }
        );
    });
</script>