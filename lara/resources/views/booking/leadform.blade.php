<form method="POST" action="{{ url('lead/save') }}">
    @csrf

    <h3>Lead Details</h3>


    <label>Company ID</label>
    <input type="text" name="company_id" value="{{ $lead->company_id ?? '' }}"><br><br>
    <label>Lead_id ID</label>
    <input type="text" name="lead_id" value="{{ $lead->lead_id ?? '' }}"><br><br>

    <label>Contact ID</label>
    <input type="text" name="contact_id" value="{{ $lead->contact_id ?? '' }}"><br><br>

    <label>Exhibition Year</label>
    <input type="text" name="exhibition_year" value="{{ $lead->exhibition_year ?? '' }}"><br><br>

    <label>Fascia</label>
    <input type="text" name="fascia" value="{{ $lead->fascia ?? '' }}"><br><br>

    <label>Sales Person</label>
    <input type="text" name="sales_person" value="{{ $lead->sales_person ?? '' }}"><br><br>

    <label>Exhibitor</label>
    <input type="text" name="exhibitor" value="{{ $lead->exhibitor ?? '' }}"><br><br>

    <label>Booking Form</label>
    <input type="text" name="booking_form" value="{{ $lead->booking_form ?? '' }}"><br><br>

    <label>Status</label>
    <input type="text" name="status" value="{{ $lead->status ?? '' }}"><br><br>

    <label>Payment Status</label>
    <input type="text" name="payment_status" value="{{ $lead->payment_status ?? '' }}"><br><br>

    <hr>

    <h3>Lead Locations</h3>

    <div id="locations">
        @if(isset($leadloaction) && count($leadloaction) > 0)
            @foreach($leadloaction as $index => $loc)
                <div class="location-block" style="border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;">
                    <label>Location</label>
                    <input type="text" name="locations[{{ $index }}][location]" value="{{ $loc->location ?? '' }}"><br><br>

                    <label>Stall Location</label>
                    <input type="text" name="locations[{{ $index }}][stall_location]"
                        value="{{ $loc->stall_location ?? '' }}"><br><br>

                    <label>Size</label>
                    <input type="text" name="locations[{{ $index }}][size]" value="{{ $loc->size ?? '' }}"><br><br>

                    <label>Price</label>
                    <input type="text" name="locations[{{ $index }}][price]" value="{{ $loc->price ?? '' }}"><br><br>

                    <label>GST</label>
                    <input type="text" name="locations[{{ $index }}][gst_amount]" value="{{ $loc->gst_amount ?? '' }}"><br><br>

                    <label>Discount</label>
                    <input type="text" name="locations[{{ $index }}][discount_amount]"
                        value="{{ $loc->discount_amount ?? '' }}"><br><br>

                    <label>Grand Total</label>
                    <input type="text" name="locations[{{ $index }}][grand_total]"
                        value="{{ $loc->grand_total ?? '' }}"><br><br>

                    @if($index > 0)
                        <button type="button" onclick="this.parentElement.remove()">Remove</button>
                    @endif
                </div>
            @endforeach
        @else
            <div class="location-block">
                <label>Location</label>
                <input type="text" name="locations[0][location]"><br><br>
            </div>
        @endif
    </div>

    <button type="button" onclick="addLocation()">+ Add More Location</button>
    <br><br>
    <button type="submit">Update/Save Lead</button>

</form>

<script>
    // Keep track of the index based on existing rows
    let locationIndex = {{ isset($leadloaction) ? count($leadloaction) : 1 }};

    function addLocation() {
        const container = document.getElementById('locations');
        const html = `
            <div class="location-block" style="border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;">
                <hr>
                <label>Location</label>
                <input type="text" name="locations[${locationIndex}][location]"><br><br>
                <label>Stall Location</label>
                <input type="text" name="locations[${locationIndex}][stall_location]"><br><br>
                <label>Size</label>
                <input type="text" name="locations[${locationIndex}][size]"><br><br>
                <label>Price</label>
                <input type="text" name="locations[${locationIndex}][price]"><br><br>
                <label>GST</label>
                <input type="text" name="locations[${locationIndex}][gst_amount]"><br><br>
                <label>Discount</label>
                <input type="text" name="locations[${locationIndex}][discount_amount]"><br><br>
                <label>Grand Total</label>
                <input type="text" name="locations[${locationIndex}][grand_total]"><br><br>
                <button type="button" onclick="this.parentElement.remove()">Remove</button>
            </div>`;
        container.insertAdjacentHTML('beforeend', html);
        locationIndex++;
    }
</script>