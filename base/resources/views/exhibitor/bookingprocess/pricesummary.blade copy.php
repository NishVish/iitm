<div class="form-section">
    <div class="row">
        <div class="column" style="height: 240px;">

            <img src="side-image.png" style="width: 100%; height: 100%;" crossorigin="anonymous">
        </div>
        <div class="column">
            <div class="form-line"><label for="area">Area Required (m²):</label><input type="number" id="area"
                    name="area" required>
            </div>
            <div class="form-line"><label for="amount">Amount Rs:</label><input type="number" id="amount" name="amount"
                    required>
            </div>
            <div class="form-line">
                <label for="gst-amount">18% GST of the Amount:</label>
                <input type="number" id="gst-amount" name="gst-amount" readonly>
            </div>

            <div class="form-line">
                <label for="total">Total Amount with 18%:</label>
                <input type="number" id="total" name="total" readonly>
            </div>

            <div class="form-line"><label>A-Rs:</label><input type="number" id="a-rs" name="a-rs"> +
                <label>B-Rs:</label><input type="number" id="b-rs" name="b-rs">
            </div>
            <div class="form-line"><label><strong>Grand Total:</strong></label><input type="number" id="grand-total"
                    name="grand-total"></div>
        </div>
    </div>
</div>