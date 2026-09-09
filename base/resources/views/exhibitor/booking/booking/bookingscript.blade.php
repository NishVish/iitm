<script>

    let rowIndex = {{ isset($stall) && is_iterable($stall) ? count($stall) : 1 }};

    function formatCurrency(amount) {

        return '₹' + Number(amount || 0).toLocaleString('en-IN', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });

    }

    function calculateRow(element) {

        const row = element.closest('.stall-row');

        if (!row) {
            return;
        }

        const eventSelect = row.querySelector('.event-select');
        const spaceInput = row.querySelector('.space-input');
        const priceInput = row.querySelector('.price-input');
        const priceHidden = row.querySelector('.price-hidden');
        const totalInput = row.querySelector('.total-input');

        if (!eventSelect || !spaceInput || !priceInput || !priceHidden || !totalInput) {
            return;
        }

        const selectedOption =
            eventSelect.options[eventSelect.selectedIndex];

        const price =
            parseFloat(selectedOption?.dataset.price || 0);

        const spaceValue =
            String(spaceInput.value || '').trim();

        const space =
            parseFloat(spaceValue);

        const validSpace =
            !isNaN(space) && space >= 0;

        const total =
            price * (validSpace ? space : 0);

        priceHidden.value = price;

        priceInput.value =
            price > 0
                ? formatCurrency(price)
                : '';

        totalInput.value =
            total > 0
                ? formatCurrency(total)
                : '';

        calculateGrandTotal();

    }

    function calculateGrandTotal() {

        let grandTotal = 0;

        document.querySelectorAll('.stall-row').forEach(function (row) {

            const eventSelect =
                row.querySelector('.event-select');

            const spaceInput =
                row.querySelector('.space-input');

            if (!eventSelect || !spaceInput) {
                return;
            }

            const selectedOption =
                eventSelect.options[eventSelect.selectedIndex];

            const price =
                parseFloat(selectedOption?.dataset.price || 0);

            const space =
                parseFloat(String(spaceInput.value || '').trim());

            if (!isNaN(price) && !isNaN(space)) {
                grandTotal += price * space;
            }

        });

        const grandTotalInput =
            document.getElementById('grandTotal');

        if (grandTotalInput) {
            grandTotalInput.value =
                formatCurrency(grandTotal);
        }

    }

    function addRow() {

        const tbody =
            document.getElementById('stallRows');

        const row =
            document.createElement('tr');

        row.classList.add('stall-row');

        /*
         * Get the main booking ID from the form.
         * This same booking ID is added to every newly created stall.
         */
        const bookingIdInput =
            document.querySelector('input[name="booking_id"]');

        const bookingId =
            bookingIdInput
                ? bookingIdInput.value
                : '';

        row.innerHTML = `

            <!-- Booking ID for this new stall -->
            <input
                type="hidden"
                name="stalls[${rowIndex}][booking_id]"
                value="${bookingId}">

            <td>
                <select
                    name="stalls[${rowIndex}][event_id]"
                    class="sb-select event-select"
                    onchange="calculateRow(this)"
                    required>

                    <option value="">Select Event</option>

                    @if(isset($eventsdata) && is_iterable($eventsdata))

                        @foreach($eventsdata as $event)

                            <option
                                value="{{ $event->event_id }}"
                                data-price="{{ $event->stall_price ?? 0 }}">

                                {{ $event->name ?? $event->event_name ?? ('Event #' . ($event->event_id ?? '')) }}

                            </option>

                        @endforeach

                    @endif

                </select>
            </td>

            <td>
                <input
                    type="text"
                    name="stalls[${rowIndex}][stall_size]"
                    class="sb-input space-input"
                    inputmode="decimal"
                    placeholder="Sq. Mtr"
                    oninput="calculateRow(this)"
                    required>
            </td>

         

            <td>
                <input
                    type="text"
                    class="sb-input price-input"
                    readonly>

                <input
                    type="hidden"
                    name="stalls[${rowIndex}][stall_price]"
                    class="price-hidden"
                    value="0">
            </td>

            <td>
                <input
                    type="text"
                    class="sb-input total-input sb-total-input"
                    readonly>
            </td>

            <td style="text-align: center;">
                <button
                    type="button"
                    class="sb-btn sb-btn-danger remove-row"
                    onclick="removeRow(this)">
                    Remove
                </button>
            </td>

        `;

        tbody.appendChild(row);

        rowIndex++;

        calculateGrandTotal();

    }

    function removeRow(button) {

        const rows =
            document.querySelectorAll('.stall-row');

        if (rows.length <= 1) {
            alert('At least one stall is required.');
            return;
        }

        const row =
            button.closest('.stall-row');

        if (row) {
            row.remove();
        }

        calculateGrandTotal();

    }

    document.addEventListener('DOMContentLoaded', function () {

        document.querySelectorAll('.stall-row').forEach(function (row) {

            const eventSelect =
                row.querySelector('.event-select');

            if (eventSelect) {
                calculateRow(eventSelect);
            }

        });

        calculateGrandTotal();

    });

</script>