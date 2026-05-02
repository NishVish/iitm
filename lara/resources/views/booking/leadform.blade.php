<style>
    .location-block {
        border: 1px solid #ccc;
        padding: 12px;
        margin-bottom: 12px;
        background: #fff;
        overflow: visible;
    }

    .location-block label {
        display: block;
        margin-top: 10px;
        font-weight: 600;
    }

    .location-block input,
    .location-block select {
        width: 100%;
        padding: 6px;
        margin-top: 4px;
        box-sizing: border-box;
        display: block;
    }
</style>

<form method="POST" action="{{ url('lead/save') }}">
    @csrf

    <h3>Lead Details</h3>

    <label>Company ID</label>
    <input type="text" name="company_id" value="{{ $lead->company_id ?? '' }}">

    <label>Lead ID</label>
    <input type="text" name="lead_id" value="{{ $lead->lead_id ?? '' }}">

    <label>Contact ID</label>
    <input type="text" name="contact_id" value="{{ $lead->contact_id ?? '' }}">

    <label>Exhibition Year</label>
    <input type="text" name="exhibition_year" value="{{ $lead->exhibition_year ?? '' }}">

    <label>Fascia</label>
    <input type="text" name="fascia" value="{{ $lead->fascia ?? '' }}">

    <label>Sales Person</label>
    <input type="text" name="sales_person" value="{{ $lead->sales_person ?? '' }}">

    <label>Exhibitor</label>
    <input type="text" name="exhibitor" value="{{ $lead->exhibitor ?? '' }}">

    <label>Status</label>
    <input type="text" name="status" value="{{ $lead->status ?? '' }}">

    <label>Payment Status</label>
    <input type="text" name="payment_status" value="{{ $lead->payment_status ?? '' }}">

    <hr>

    <h3>Lead Locations</h3>

    <div id="locations">

        @if(isset($leadloaction) && count($leadloaction) > 0)

            @foreach($leadloaction as $index => $loc)

                <div class="location-block">

                    <label>Location</label>
                    <input type="text" name="locations[{{ $index }}][location]" value="{{ $loc->location ?? '' }}">

                    <label>Stall Location</label>
                    <input type="text" name="locations[{{ $index }}][stall_location]" value="{{ $loc->stall_location ?? '' }}">

                    <label>Size</label>
                    <select name="locations[{{ $index }}][size]">
                        <option value="">Select</option>
                        <option value="3" {{ ($loc->size ?? '') == 3 ? 'selected' : '' }}>3</option>
                        <option value="6" {{ ($loc->size ?? '') == 6 ? 'selected' : '' }}>6</option>
                        <option value="9" {{ ($loc->size ?? '') == 9 ? 'selected' : '' }}>9</option>
                        <option value="12" {{ ($loc->size ?? '') == 12 ? 'selected' : '' }}>12</option>
                    </select>

                    <label>Amount</label>
                    <input type="text" name="locations[{{ $index }}][amount]" value="{{ $loc->amount ?? '' }}">

                    <label>GST</label>
                    <input type="text" name="locations[{{ $index }}][gst_amount]" value="{{ $loc->gst_amount ?? '' }}">

                    <label>Discount</label>
                    <input type="text" name="locations[{{ $index }}][discount_amount]"
                        value="{{ $loc->discount_amount ?? '' }}">

                    <label>Grand Total</label>
                    <input type="text" name="locations[{{ $index }}][grand_total]" value="{{ $loc->grand_total ?? '' }}">

                    @if($index > 0)
                        <button type="button" onclick="this.parentElement.remove()">Remove</button>
                    @endif

                </div>

            @endforeach

        @else

            <div class="location-block">

                <label>Location</label>
                <input type="text" name="locations[0][location]">

                <label>Stall Location</label>
                <input type="text" name="locations[0][stall_location]">

                <label>Size</label>
                <select name="locations[0][size]">
                    <option value="">Select</option>
                    <option value="3">3</option>
                    <option value="6">6</option>
                    <option value="9">9</option>
                    <option value="12">12</option>
                </select>

                <label>Amount</label>
                <input type="text" name="locations[0][amount]">

                <label>GST</label>
                <input type="text" name="locations[0][gst_amount]">

                <label>Discount</label>
                <input type="text" name="locations[0][discount_amount]">

                <label>Grand Total</label>
                <input type="text" name="locations[0][grand_total]">

            </div>

        @endif

    </div>

    <button type="button" onclick="addLocation()">+ Add More Location</button>

    <br><br>

    <button type="submit">Save Lead</button>
</form>

<script>
    let locationIndex = {{ isset($leadloaction) ? count($leadloaction) : 1 }};

    function addLocation() {

        const container = document.getElementById("locations");

        const html = `
        <div class="location-block">

            <label>Location</label>
            <input type="text" name="locations[${locationIndex}][location]">

            <label>Stall Location</label>
            <input type="text" name="locations[${locationIndex}][stall_location]">

            <label>Size</label>
            <select name="locations[${locationIndex}][size]">
                <option value="">Select</option>
                <option value="3">3</option>
                <option value="6">6</option>
                <option value="9">9</option>
                <option value="12">12</option>
            </select>

            <label>Amount</label>
            <input type="text" name="locations[${locationIndex}][amount]">

            <label>GST</label>
            <input type="text" name="locations[${locationIndex}][gst_amount]">

            <label>Discount</label>
            <input type="text" name="locations[${locationIndex}][discount_amount]">

            <label>Grand Total</label>
            <input type="text" name="locations[${locationIndex}][grand_total]">

            <button type="button" onclick="this.parentElement.remove()">Remove</button>

        </div>
    `;

        container.insertAdjacentHTML("beforeend", html);
        locationIndex++;
    }
</script>