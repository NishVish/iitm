<div id="mailPopup"
    style="display:none; position:fixed; top:10%; left:30%; width:500px; background:#fff; border:1px solid #ccc; padding:20px; z-index:999;">

    <h3>Mail Builder</h3>

    <p><strong>Lead ID:</strong> <span id="m_lead_id"></span></p>

    <input type="hidden" id="lead_id">
    <input type="hidden" id="company_id">
    <input type="hidden" id="contact_id">

    <!-- MAIL TYPE -->
    <label>Mail Type</label><br>
    <select id="mail_type">
        <option value="reminder">Reminder Mail</option>
        <option value="proposal">Proposal Mail</option>
        <option value="thankyou">Thank You Mail</option>
    </select>

    <br><br>

    <!-- SIZE -->
    <label><strong>Select Size</strong></label><br>

    <label><input type="checkbox" class="size-box" value="4"> 4 sqm</label><br>
    <label><input type="checkbox" class="size-box" value="6"> 6 sqm</label><br>
    <label><input type="checkbox" class="size-box" value="9"> 9 sqm</label><br>
    <label><input type="checkbox" class="size-box" value="12"> 12 sqm</label>

    <br><br>

    <p><strong>Total:</strong> ₹<span id="total_price">0</span></p>

    <hr>

    <!-- MESSAGE INPUT -->
    <textarea id="mail_message" rows="3" style="width:100%;" placeholder="Custom message..."></textarea>

    <br><br>

    <!-- PREVIEW -->
    <h4>📧 Email Preview</h4>
    <textarea id="mail_preview" rows="10" style="width:100%; background:#f9f9f9;"></textarea>

    <br>

    <button onclick="generateMail()">Generate Preview</button>
    <button onclick="copyMail()">Copy for Gmail</button>
    <button onclick="closeMailPopup()">Close</button>
</div>

<script>
    let pricePerSqm = 100;

    // OPEN POPUP
    function openMailPopup(lead) {
        document.getElementById('mailPopup').style.display = 'block';

        document.getElementById('m_lead_id').innerText = lead.lead_id;

        document.getElementById('lead_id').value = lead.lead_id;
        document.getElementById('company_id').value = lead.company_id;
        document.getElementById('contact_id').value = lead.contact_id;

        document.getElementById('mail_type').value = 'reminder';
        document.getElementById('mail_message').value = '';

        document.querySelectorAll('.size-box').forEach(cb => cb.checked = false);
        document.getElementById('total_price').innerText = 0;
        document.getElementById('mail_preview').value = '';
    }

    // CLOSE
    function closeMailPopup() {
        document.getElementById('mailPopup').style.display = 'none';
    }

    // TOTAL CALCULATION
    document.addEventListener('change', function (e) {
        if (e.target.classList.contains('size-box')) {
            calculateTotal();
        }
    });

    function calculateTotal() {
        let total = 0;

        document.querySelectorAll('.size-box:checked').forEach(cb => {
            total += parseInt(cb.value) * pricePerSqm;
        });

        document.getElementById('total_price').innerText = total;
    }

    // GENERATE EMAIL
    function generateMail() {
        let leadId = document.getElementById('lead_id').value;
        let type = document.getElementById('mail_type').value;
        let message = document.getElementById('mail_message').value;

        let sizes = [];
        document.querySelectorAll('.size-box:checked').forEach(cb => {
            sizes.push(cb.value + " sqm");
        });

        let total = document.getElementById('total_price').innerText;

        let preview =
            `Subject: ${type.toUpperCase()} - Lead ${leadId}

Hello,

This is regarding Lead ID: ${leadId}

Selected Sizes:
${sizes.join(', ') || 'None selected'}

Total Amount: ₹${total}

Message:
${message || '-'}

Regards,
Your Company`;

        document.getElementById('mail_preview').value = preview;
    }

    // COPY TO CLIPBOARD
    function copyMail() {
        let text = document.getElementById('mail_preview');
        text.select();
        document.execCommand('copy');
        alert("Copied to clipboard!");
    }
</script>