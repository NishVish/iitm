<div id="leadModal"
    style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6); z-index: 1000;">
    <div
        style="background:#fff; width:600px; max-width:95%; margin:5vh auto; padding:20px; border-radius:8px; max-height:90vh; overflow-y:auto;">
        <h3>Mark as Lead</h3>

        <form method="POST" action="{{ route('backend.mark-lead') }}">
            @csrf
            <input type="hidden" name="contact_id" id="modal_contact_id">

            {{-- Main Lead Fields --}}
            <input type="hidden" name="contact_id" value="{{ $contactid }}" id="contactid">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                <div>
                    <label>Fascia</label>
                    <input type="text" name="fascia" style="width:100%;">
                </div>
                <div>
                    <label>Exhibition Year</label>
                    <input type="number" name="exhibition_year" style="width:100%;">
                </div>
            </div>

            <hr>

            <h4>Location Details</h4>
            <div id="location-container">
                <div class="location-row"
                    style="border: 1px solid #eee; padding: 10px; margin-bottom: 15px; position: relative;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                        <div>
                            <label>Location</label>
                            <input type="text" name="locations[0][name]" style="width:100%;">
                        </div>
                        <div>
                            <label>Stall Location</label>
                            <input type="text" name="locations[0][stall_location]" style="width:100%;">
                        </div>
                        <div>
                            <label>Size</label>
                            <input type="text" name="locations[0][size]" style="width:100%;">
                        </div>
                        <div>
                            <label>Price</label>
                            <input type="number" step="0.01" name="locations[0][price]" style="width:100%;">
                        </div>
                    </div>
                </div>
            </div>

            <button type="button" onclick="addLocation()"
                style="margin-bottom: 20px; background: #007bff; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer;">
                + Add Another Location
            </button>

            <div
                style="display:flex; justify-content:space-between; margin-top: 20px; border-top: 1px solid #ccc; padding-top: 15px;">
                <button type="submit"
                    style="background:green; color:white; padding:8px 16px; border:none; border-radius:4px;">Save
                    Lead</button>
                <button type="button" onclick="closeLeadModal()" style="padding:8px 16px;">Cancel</button>
            </div>
        </form>
    </div>
</div>
<script>
    let locationIndex = 1;

    function addLocation() {
        const container = document.getElementById('location-container');
        const newRow = document.createElement('div');
        newRow.className = 'location-row';
        newRow.style = "border: 1px solid #eee; padding: 10px; margin-bottom: 15px; position: relative; background: #fafafa;";

        newRow.innerHTML = `
        <button type="button" onclick="this.parentElement.remove()" style="position:absolute; right:5px; top:5px; color:red; border:none; background:none; cursor:pointer;">&times; Remove</button>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
            <div>
                <label>Location</label>
                <input type="text" name="locations[${locationIndex}][name]" style="width:100%;">
            </div>
            <div>
                <label>Stall Location</label>
                <input type="text" name="locations[${locationIndex}][stall_location]" style="width:100%;">
            </div>
            <div>
                <label>Size</label>
                <input type="text" name="locations[${locationIndex}][size]" style="width:100%;">
            </div>
            <div>
                <label>Price</label>
                <input type="number" step="0.01" name="locations[${locationIndex}][price]" style="width:100%;">
            </div>
        </div>
    `;

        container.appendChild(newRow);
        locationIndex++;
    }
</script>