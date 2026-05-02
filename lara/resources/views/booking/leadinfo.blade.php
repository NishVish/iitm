<style>
    .form-grid {
        display: grid;
        grid-template-columns: 200px 1fr;
        gap: 8px 15px;
        align-items: center;
        margin-bottom: 15px;
    }

    .block {
        border: 1px solid #ddd;
        padding: 15px;
        margin-bottom: 15px;
        border-radius: 8px;
        background: #fff;
    }

    .block input {
        width: 100%;
        padding: 6px;
    }
</style>

<h3>Lead Details</h3>

<div class="form-grid">
    <label>Lead ID</label>
    <input type="text" name="lead_id" value="{{ $lead->lead_id ?? '' }}">

    <label>Company ID</label>
    <input type="text" name="company_id" value="{{ $lead->company_id ?? '' }}">

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
</div>

<hr>

<h3>Lead Locations</h3>

<div id="locations">

    @if(isset($locations) && count($locations) > 0)

        @foreach($locations as $i => $loc)

            <div class="block">

                <div class="form-grid">

                    <label>Location</label>
                    <select name="locations[{{ $i }}][location] ?? ">
                        <option value="">Select</option>
                        <option value="MUMBAI" {{ ($loc->location ?? '') == 'MUMBAI' ? 'selected' : '' }}>MUMBAI</option>
                        <option value="DELHI" {{ ($loc->location ?? '') == 'DELHI' ? 'selected' : '' }}>DELHI</option>
                        <option value="BANGALORE" {{ ($loc->location ?? '') == 'BANGALORE' ? 'selected' : '' }}>BANGALORE</option>
                        <option value="HYDERABAD" {{ ($loc->location ?? '') == 'HYDERABAD' ? 'selected' : '' }}>HYDERABAD</option>
                        <option value="CHENNAI" {{ ($loc->location ?? '') == 'CHENNAI' ? 'selected' : '' }}>CHENNAI</option>
                        <option value="KOLKATA" {{ ($loc->location ?? '') == 'KOLKATA' ? 'selected' : '' }}>KOLKATA</option>
                        <option value="PUNE" {{ ($loc->location ?? '') == 'PUNE' ? 'selected' : '' }}>PUNE</option>
                        <option value="AHMEDABAD" {{ ($loc->location ?? '') == 'AHMEDABAD' ? 'selected' : '' }}>AHMEDABAD</option>
                        <option value="KOCHI" {{ ($loc->location ?? '') == 'KOCHI' ? 'selected' : '' }}>KOCHI</option>
                    </select>
                    <label>Stall Location</label>
                    <input type="text" name="locations[{{ $i }}][stall_location]" value="{{ $loc->stall_location ?? '' }}">

                    <label>Size</label>
                    <select name="locations[{{ $i }}][size]">
                        <option value="">Select</option>
                        <option value="3" {{ ($loc->size ?? '') == '3' ? 'selected' : '' }}>3</option>
                        <option value="6" {{ ($loc->size ?? '') == '6' ? 'selected' : '' }}>6</option>
                        <option value="9" {{ ($loc->size ?? '') == '9' ? 'selected' : '' }}>9</option>
                        <option value="12" {{ ($loc->size ?? '') == '12' ? 'selected' : '' }}>12</option>
                    </select>
                    <label>Amount</label>
                    <input type="number" step="0.01" name="locations[{{ $i }}][amount]" value="{{ $loc->amount ?? 0 }}">

                    <label>GST</label>
                    <input type="number" step="0.01" name="locations[{{ $i }}][gst]" value="{{ $loc->gst ?? 0 }}">

                </div>

                <button type="button" onclick="this.closest('.block').remove()">Remove</button>

            </div>

        @endforeach

    @else

        <div class="block">

            <div class="form-grid">

                <label>Location</label>
                <select name="locations[0][location]">
                    <option value="">Select</option>
                    <option value="MUMBAI" {{ ($loc->location ?? '') == 'MUMBAI' ? 'selected' : '' }}>MUMBAI</option>
                    <option value="DELHI" {{ ($loc->location ?? '') == 'DELHI' ? 'selected' : '' }}>DELHI</option>
                    <option value="BANGALORE" {{ ($loc->location ?? '') == 'BANGALORE' ? 'selected' : '' }}>BANGALORE</option>
                    <option value="HYDERABAD" {{ ($loc->location ?? '') == 'HYDERABAD' ? 'selected' : '' }}>HYDERABAD</option>
                    <option value="CHENNAI" {{ ($loc->location ?? '') == 'CHENNAI' ? 'selected' : '' }}>CHENNAI</option>
                    <option value="KOLKATA" {{ ($loc->location ?? '') == 'KOLKATA' ? 'selected' : '' }}>KOLKATA</option>
                    <option value="PUNE" {{ ($loc->location ?? '') == 'PUNE' ? 'selected' : '' }}>PUNE</option>
                    <option value="AHMEDABAD" {{ ($loc->location ?? '') == 'AHMEDABAD' ? 'selected' : '' }}>AHMEDABAD</option>
                    <option value="KOCHI" {{ ($loc->location ?? '') == 'KOCHI' ? 'selected' : '' }}>KOCHI</option>
                </select>
                <label>Stall Location</label>
                <input type="text" name="locations[0][stall_location]">

                <label>Size</label>
                <select name="locations[0][size]">
                    <option value="">Select</option>
                    <option value="3" {{ ($loc->size ?? '') == '3' ? 'selected' : '' }}>3</option>
                    <option value="6" {{ ($loc->size ?? '') == '6' ? 'selected' : '' }}>6</option>
                    <option value="9" {{ ($loc->size ?? '') == '9' ? 'selected' : '' }}>9</option>
                    <option value="12" {{ ($loc->size ?? '') == '12' ? 'selected' : '' }}>12</option>
                </select>
                <label>Amount</label>
                <input type="number" step="0.01" name="locations[0][amount]" value="0">

                <label>GST</label>
                <input type="number" step="0.01" name="locations[0][gst]" value="0">

            </div>

        </div>

    @endif

</div>

<button type="button" onclick="addLocation()">+ Add Location</button>

<script>
    let locationIndex = 0;

    function addLocation() {
        const c = document.getElementById("locations");

        const i = locationIndex++;

        c.insertAdjacentHTML("beforeend", `
        <div class="block">

            <div class="form-grid">

                <label>Location</label>
                <select name="locations[${i}][location]">
                    <option value="">Select</option>
                    <option value="MUMBAI">MUMBAI</option>
                    <option value="DELHI">DELHI</option>
                    <option value="BANGALORE">BANGALORE</option>
                    <option value="HYDERABAD">HYDERABAD</option>
                    <option value="CHENNAI">CHENNAI</option>
                    <option value="KOLKATA">KOLKATA</option>
                    <option value="PUNE">PUNE</option>
                    <option value="AHMEDABAD">AHMEDABAD</option>
                    <option value="KOCHI">KOCHI</option>
                </select>

                <label>Stall Location</label>
                <input type="text" name="locations[${i}][stall_location]">

                <label>Size</label>
                <select name="locations[${i}][size]">
                    <option value="">Select</option>
                    <option value="3">3</option>
                    <option value="6">6</option>
                    <option value="9">9</option>
                    <option value="12">12</option>
                </select>

                <label>Amount</label>
                <input type="number" step="0.01" name="locations[${i}][amount]" value="0">

                <label>GST</label>
                <input type="number" step="0.01" name="locations[${i}][gst]" value="0">

            </div>

            <button type="button" onclick="this.closest('.block').remove()">Remove</button>

        </div>
    `);
    }
</script>