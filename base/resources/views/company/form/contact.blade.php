@php
    $segments = request()->segments();
    $lastSegment = $segments[count($segments) - 1] ?? null;
    $secondLastSegment = $segments[count($segments) - 2] ?? null;

    $oldContacts = old('contacts');

    if ($oldContacts !== null) {
        $contactsToDisplay = collect($oldContacts);
    } else {
        $contactsToDisplay = $contacts ?? collect();
    }
@endphp


<style>
    .contacts-table-wrapper {
        width: 100%;
        overflow-x: auto;
        margin-top: 15px;
    }

    .contacts-table {
        width: 100%;
        border-collapse: collapse;
        background: #fff;
    }

    .contacts-table th,
    .contacts-table td {
        border: 1px solid #ddd;
        padding: 10px;
        vertical-align: middle;
        text-align: left;
    }

    .contacts-table th {
        background: #f5f5f5;
        font-weight: 600;
        white-space: nowrap;
    }

    .contacts-table td input[type="text"],
    .contacts-table td input[type="tel"],
    .contacts-table td input[type="email"] {
        width: 100%;
        box-sizing: border-box;
        padding: 8px 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .contacts-table .action-column {
        width: 60px;
        text-align: center;
    }

    .contacts-table .select-column {
        width: 130px;
        text-align: center;
    }

    .contacts-table .select-column label {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        cursor: pointer;
        white-space: nowrap;
    }

    .contacts-table .remove-btn {
        border: none;
        background: #dc3545;
        color: #fff;
        width: 32px;
        height: 32px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 18px;
        line-height: 1;
    }

    .contacts-table .remove-btn:hover {
        background: #bb2d3b;
    }

    .contacts-table .contact-number {
        text-align: center;
        font-weight: 600;
        width: 50px;
    }

    .contacts-table .billing-radio,
    .contacts-table .delegate-checkbox {
        width: 18px;
        height: 18px;
        cursor: pointer;
    }

    @media (max-width: 768px) {

        .contacts-table {
            min-width: 800px;
        }

    }
</style>


<!-- =====================================================
     CONTACTS
====================================================== -->

<div class="form-section">

    <div class="section-header">

        <h3>
            Contacts
        </h3>

        <button type="button" class="add-btn" id="addContactBtn">

            + Add Contact

        </button>

    </div>


    <div id="contactsContainer" class="contacts-table-wrapper">

        <table class="contacts-table">

            <thead>

                <tr>

                    <th>
                        #
                    </th>

                    <th>
                        Contact Name
                    </th>

                    <th>
                        Designation
                    </th>

                    <th>
                        Mobile
                    </th>

                    <th>
                        Email
                    </th>


                    {{-- =====================================================
                    BILLING COLUMN
                    ====================================================== --}}
                    @if($secondLastSegment === 'booking')
                        <th class="select-column">
                            Billing Contact
                        </th>

                    @endif


                    {{-- =====================================================
                    DELEGATE COLUMN
                    ====================================================== --}}
                    @if($secondLastSegment === 'bookinginfo')

                        <th class="select-column">
                            Delegate
                        </th>

                    @endif


                    <th class="action-column">
                        Action
                    </th>

                </tr>

            </thead>


            <tbody id="contactsTableBody">


                @if($contactsToDisplay->count() > 0)

                    @foreach($contactsToDisplay as $index => $item)

                                <tr class="contact-row">


                                    {{-- =====================================================
                                    CONTACT NUMBER
                                    ====================================================== --}}

                                    <td class="contact-number">

                                        {{ $index + 1 }}

                                    </td>


                                    {{-- =====================================================
                                    CONTACT ID
                                    ====================================================== --}}

                                    @if(data_get($item, 'contact_id'))

                                        <input type="hidden" name="contacts[{{ $index }}][contact_id]"
                                            value="{{ data_get($item, 'contact_id') }}">

                                    @endif


                                    {{-- =====================================================
                                    CONTACT NAME
                                    ====================================================== --}}

                                    <td>

                                        <input type="text" name="contacts[{{ $index }}][name]" placeholder="Contact name" value="{{ old(
                            "contacts.$index.name",
                            data_get($item, 'name', '')
                        ) }}">

                                    </td>


                                    {{-- =====================================================
                                    DESIGNATION
                                    ====================================================== --}}

                                    <td>

                                        <input type="text" name="contacts[{{ $index }}][designation]" placeholder="Designation" value="{{ old(
                            "contacts.$index.designation",
                            data_get($item, 'designation', '')
                        ) }}">

                                    </td>


                                    {{-- =====================================================
                                    MOBILE
                                    ====================================================== --}}

                                    <td>

                                        <input type="tel" name="contacts[{{ $index }}][mobile]" placeholder="Mobile number"
                                            maxlength="15" value="{{ old(
                            "contacts.$index.mobile",
                            data_get($item, 'mobile', '')
                        ) }}">

                                    </td>


                                    {{-- =====================================================
                                    EMAIL
                                    ====================================================== --}}

                                    <td>

                                        <input type="email" name="contacts[{{ $index }}][email]" placeholder="Email address" value="{{ old(
                            "contacts.$index.email",
                            data_get($item, 'email', '')
                        ) }}">

                                    </td>


                                    {{-- =====================================================
                                    BILLING CONTACT
                                    ====================================================== --}}

                                    @if($secondLastSegment === 'booking')

                                        <td class="select-column">

                                            <input type="hidden" name="contacts[{{ $index }}][billing_contact]" value="0"
                                                class="billing-contact-hidden">

                                            <label>

                                                <input type="radio" name="billing_contact" value="{{ $index }}" class="billing-radio"
                                                    data-index="{{ $index }}" {{ data_get($item, 'billing_contact') ? 'checked' : '' }}>

                                                Billing

                                            </label>

                                        </td>

                                    @endif


                                    {{-- =====================================================
                                    DELEGATE
                                    ====================================================== --}}

                                    @if($secondLastSegment === 'bookinginfo')

                                        <td class="select-column">

                                            <input type="hidden" name="contacts[{{ $index }}][delegate]" value="0">

                                            <label>

                                                <input type="checkbox" name="contacts[{{ $index }}][delegate]" value="1"
                                                    class="delegate-checkbox" {{ data_get($item, 'delegate') ? 'checked' : '' }}>

                                                Delegate

                                            </label>

                                        </td>

                                    @endif


                                    {{-- =====================================================
                                    REMOVE
                                    ====================================================== --}}

                                    <td class="action-column">

                                        <button type="button" class="remove-btn" aria-label="Remove contact">

                                            ×

                                        </button>

                                    </td>

                                </tr>

                    @endforeach


                @else


                    {{-- =====================================================
                    DEFAULT CONTACT
                    ====================================================== --}}

                    <tr class="contact-row">


                        <td class="contact-number">
                            1
                        </td>


                        {{-- CONTACT NAME --}}

                        <td>

                            <input type="text" name="contacts[0][name]" placeholder="Contact name">

                        </td>


                        {{-- DESIGNATION --}}

                        <td>

                            <input type="text" name="contacts[0][designation]" placeholder="Designation">

                        </td>


                        {{-- MOBILE --}}

                        <td>

                            <input type="tel" name="contacts[0][mobile]" placeholder="Mobile number" maxlength="15">

                        </td>


                        {{-- EMAIL --}}

                        <td>

                            <input type="email" name="contacts[0][email]" placeholder="Email address">

                        </td>


                        {{-- BILLING --}}

                        @if($secondLastSegment === 'booking')

                            <td class="select-column">

                                <input type="hidden" name="contacts[0][billing_contact]" value="0"
                                    class="billing-contact-hidden">

                                <label>

                                    <input type="radio" name="billing_contact" value="0" class="billing-radio" data-index="0">

                                    Billing

                                </label>

                            </td>

                        @endif


                        {{-- DELEGATE --}}

                        @if($secondLastSegment === 'bookinginfo')

                            <td class="select-column">

                                <input type="hidden" name="contacts[0][delegate]" value="0">

                                <label>

                                    <input type="checkbox" name="contacts[0][delegate]" value="1" class="delegate-checkbox">

                                    Delegate

                                </label>

                            </td>

                        @endif


                        {{-- REMOVE --}}

                        <td class="action-column">

                            <button type="button" class="remove-btn" aria-label="Remove contact">

                                ×

                            </button>

                        </td>

                    </tr>

                @endif

            </tbody>

        </table>

    </div>

</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {

        const container = document.getElementById('contactsTableBody');
        const addButton = document.getElementById('addContactBtn');

        if (!container || !addButton) {
            return;
        }

        const secondLastSegment = @json($secondLastSegment);

        let contactIndex = container.querySelectorAll('.contact-row').length;


        /*
        |--------------------------------------------------------------------------
        | ADD CONTACT
        |--------------------------------------------------------------------------
        */

        addButton.addEventListener('click', function () {

            const index = contactIndex;

            const row = document.createElement('tr');

            row.className = 'contact-row';


            let billingColumn = '';
            let delegateColumn = '';


            /*
            |--------------------------------------------------------------------------
            | BILLING
            |--------------------------------------------------------------------------
            */

            if (secondLastSegment === 'booking') {

                billingColumn = `
                <td class="select-column">

                    <input
                        type="hidden"
                        name="contacts[${index}][billing_contact]"
                        value="0"
                        class="billing-contact-hidden"
                    >

                    <label>

                        <input
                            type="radio"
                            name="billing_contact"
                            value="${index}"
                            class="billing-radio"
                            data-index="${index}"
                        >

                        Billing

                    </label>

                </td>
            `;
            }


            /*
            |--------------------------------------------------------------------------
            | DELEGATE
            |--------------------------------------------------------------------------
            */

            if (secondLastSegment === 'bookinginfo') {

                delegateColumn = `
                <td class="select-column">

                    <input
                        type="hidden"
                        name="contacts[${index}][delegate]"
                        value="0"
                    >

                    <label>

                        <input
                            type="checkbox"
                            name="contacts[${index}][delegate]"
                            value="1"
                            class="delegate-checkbox"
                        >

                        Delegate

                    </label>

                </td>
            `;
            }


            /*
            |--------------------------------------------------------------------------
            | ROW
            |--------------------------------------------------------------------------
            */

            row.innerHTML = `

            <td class="contact-number">
                ${index + 1}
            </td>

            <td>
                <input
                    type="text"
                    name="contacts[${index}][name]"
                    placeholder="Contact name"
                >
            </td>

            <td>
                <input
                    type="text"
                    name="contacts[${index}][designation]"
                    placeholder="Designation"
                >
            </td>

            <td>
                <input
                    type="tel"
                    name="contacts[${index}][mobile]"
                    placeholder="Mobile number"
                    maxlength="15"
                >
            </td>

            <td>
                <input
                    type="email"
                    name="contacts[${index}][email]"
                    placeholder="Email address"
                >
            </td>

            ${billingColumn}

            ${delegateColumn}

            <td class="action-column">

                <button
                    type="button"
                    class="remove-btn"
                    aria-label="Remove contact"
                >
                    ×
                </button>

            </td>
        `;


            container.appendChild(row);

            contactIndex++;

            updateContactNumbers();
        });


        /*
        |--------------------------------------------------------------------------
        | REMOVE CONTACT
        |--------------------------------------------------------------------------
        */

        container.addEventListener('click', function (event) {

            const button = event.target.closest('.remove-btn');

            if (!button) {
                return;
            }

            const rows = container.querySelectorAll('.contact-row');

            if (rows.length <= 1) {

                alert('At least one contact is required.');

                return;
            }

            const row = button.closest('.contact-row');

            if (row) {
                row.remove();
            }

            updateContactNumbers();

        });


        /*
        |--------------------------------------------------------------------------
        | BILLING CONTACT
        |--------------------------------------------------------------------------
        */

        container.addEventListener('change', function (event) {

            if (!event.target.classList.contains('billing-radio')) {
                return;
            }

            /*
            | Reset every contact
            */

            container
                .querySelectorAll('.billing-contact-hidden')
                .forEach(function (input) {

                    input.value = '0';

                });


            /*
            | Get selected row
            */

            const row =
                event.target.closest('.contact-row');


            if (!row) {
                return;
            }


            /*
            | Set selected contact = billing
            */

            const hiddenInput =
                row.querySelector('.billing-contact-hidden');


            if (hiddenInput) {

                hiddenInput.value = '1';

            }

        });


        /*
        |--------------------------------------------------------------------------
        | UPDATE CONTACT NUMBERS
        |--------------------------------------------------------------------------
        */

        function updateContactNumbers() {

            container
                .querySelectorAll('.contact-row')
                .forEach(function (row, index) {

                    const number =
                        row.querySelector('.contact-number');

                    if (number) {
                        number.textContent = index + 1;
                    }

                });

        }


        /*
        |--------------------------------------------------------------------------
        | INITIAL BILLING VALUE
        |--------------------------------------------------------------------------
        |
        | Important when editing an existing booking.
        |
        */

        function initializeBillingContact() {

            if (secondLastSegment !== 'booking') {
                return;
            }

            const selectedRadio =
                container.querySelector('.billing-radio:checked');


            /*
            | First reset all contacts
            */

            container
                .querySelectorAll('.billing-contact-hidden')
                .forEach(function (input) {

                    input.value = '0';

                });


            /*
            | Set existing billing contact
            */

            if (selectedRadio) {

                const row =
                    selectedRadio.closest('.contact-row');


                if (row) {

                    const hiddenInput =
                        row.querySelector('.billing-contact-hidden');


                    if (hiddenInput) {

                        hiddenInput.value = '1';

                    }

                }

            }

        }


        /*
        |--------------------------------------------------------------------------
        | INITIALIZE
        |--------------------------------------------------------------------------
        */

        updateContactNumbers();

        initializeBillingContact();

    });
</script>