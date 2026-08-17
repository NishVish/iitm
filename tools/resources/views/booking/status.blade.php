<form method="POST" action="{{ url('lead/save') }}">
    @csrf

    <div class="ticket-wrapper">
        <div class="boarding-pass">
            
            <div class="stub">
                <div class="top">
                    <span class="label">LEAD ID</span>
                    <div class="value">#{{ $lead->lead_id ?? 'NEW' }}</div>
                </div>
                <div class="barcode-area">
                    <div class="barcode"></div>
                    <span class="serial">SN-{{ rand(1000, 9999) }}</span>
                </div>
                <div class="status-badge">{{ $lead->status ?? 'PENDING' }}</div>
            </div>

            <div class="main-body">
                <div class="header">
                    <div class="brand">LEAD ENTRY MANIFEST</div>
                    <div class="meta">
                        <input type="text" name="exhibition_year" value="{{ $lead->exhibition_year ?? '2024' }}" placeholder="Year">
                        <input type="text" name="sales_person" value="{{ $lead->sales_person ?? '' }}" placeholder="Sales Rep">
                    </div>
                </div>

                <div class="content-grid">
                    <div class="col">
                        <h6>COMPANY</h6>
                        <input type="text" name="company_name" value="{{ $lead->company_name }}" placeholder="Company Name" class="bold">
                        <input type="text" name="gst_number" value="{{ $lead->gst_number }}" placeholder="GST Number">
                        <input type="text" name="website" value="{{ $lead->website }}" placeholder="Website">
                        <textarea name="address" placeholder="Address">{{ $lead->address }}</textarea>
                    </div>

                    <div class="col">
                        <h6>CONTACT</h6>
                        <input type="text" name="contact_name" value="{{ $lead->contact_name }}" placeholder="Contact Name" class="bold">
                        <input type="text" name="designation" value="{{ $lead->designation }}" placeholder="Designation">
                        
                        <div class="multi-row">
                            <input type="email" name="emails[]" value="{{ $emails[0]->email ?? '' }}" placeholder="Email">
                            <input type="text" name="mobiles[]" value="{{ $mobiles[0]->mobile ?? '' }}" placeholder="Mobile">
                        </div>
                    </div>

                    <div class="col locations">
                        <h6>LOCATIONS</h6>
                        <div id="loc-list">
                            @foreach($leadloaction ?? [] as $index => $loc)
                            <div class="loc-item">
                                <span>{{ $loc->location }}</span>
                                <span>{{ $loc->size }}m²</span>
                                <span class="price">${{ $loc->grand_total }}</span>
                            </div>
                            @endforeach
                        </div>
                        <button type="button" class="btn-mini" onclick="addLocation()">+ Add</button>
                    </div>
                </div>

                <div class="footer">
                    <span class="note">Valid lead for {{ $lead->exhibitor ?? 'Exhibitor Name' }}</span>
                    <button type="submit" class="save-btn">SAVE TICKET</button>
                </div>
            </div>

        </div>
    </div>
</form>

<style>
    .ticket-wrapper {
        padding: 20px;
        background: #f0f2f5;
        display: flex;
        justify-content: center;
        font-family: 'Courier New', Courier, monospace;
    }

    .boarding-pass {
        display: flex;
        width: 100%;
        max-width: 950px;
        background: #fff;
        border: 2px solid #333;
        border-radius: 8px;
        overflow: hidden;
        position: relative;
        box-shadow: 5px 5px 0px #333;
    }

    /* Stub (Left Side) */
    .stub {
        width: 160px;
        background: #333;
        color: #fff;
        padding: 15px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        border-right: 2px dashed #fff;
    }

    .stub .label { font-size: 10px; color: #aaa; }
    .stub .value { font-size: 18px; font-weight: bold; }
    
    .barcode-area { text-align: center; }
    .barcode { 
        height: 40px; 
        background: linear-gradient(90deg, #fff 2px, transparent 2px, #fff 4px, transparent 7px, #fff 10px); 
        background-size: 15px 100%;
    }
    .serial { font-size: 9px; }

    .status-badge {
        background: #fff;
        color: #333;
        font-size: 10px;
        font-weight: bold;
        text-align: center;
        padding: 4px;
        transform: rotate(-3deg);
    }

    /* Main Body */
    .main-body { flex: 1; padding: 15px; display: flex; flex-direction: column; }

    .header {
        display: flex;
        justify-content: space-between;
        border-bottom: 1px solid #333;
        padding-bottom: 5px;
        margin-bottom: 10px;
    }
    .brand { font-weight: 900; font-size: 14px; }
    .meta input { 
        width: 80px; 
        border: none; 
        border-bottom: 1px solid #ccc; 
        font-size: 11px; 
        text-align: right;
    }

    .content-grid { display: flex; gap: 20px; }
    .col { flex: 1; display: flex; flex-direction: column; gap: 5px; }
    .col h6 { margin: 0 0 5px 0; font-size: 10px; color: #888; text-decoration: underline; }

    input, textarea {
        border: 1px solid transparent;
        background: #f9f9f9;
        padding: 4px;
        font-size: 12px;
        font-family: inherit;
    }
    input:focus, textarea:focus { background: #fff; border-color: #333; outline: none; }
    .bold { font-weight: bold; background: transparent; font-size: 14px; }
    
    textarea { height: 40px; resize: none; }

    .multi-row { display: flex; gap: 5px; }
    .multi-row input { width: 50%; }

    /* Locations Section */
    .loc-list { max-height: 80px; overflow-y: auto; }
    .loc-item { 
        display: flex; 
        justify-content: space-between; 
        font-size: 10px; 
        border-bottom: 1px dotted #ccc;
        padding: 2px 0;
    }
    .price { font-weight: bold; }
    .btn-mini { background: #eee; border: 1px solid #ccc; font-size: 9px; cursor: pointer; margin-top: 5px; }

    /* Footer */
    .footer {
        margin-top: auto;
        padding-top: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top: 1px solid #eee;
    }
    .note { font-size: 9px; font-style: italic; color: #666; }
    .save-btn {
        background: #333;
        color: #fff;
        border: none;
        padding: 8px 20px;
        font-size: 12px;
        font-weight: bold;
        cursor: pointer;
    }
    .save-btn:hover { background: #000; }

    /* Perforation circles */
    .boarding-pass::before, .boarding-pass::after {
        content: "";
        position: absolute;
        left: 152px;
        width: 16px;
        height: 16px;
        background: #f0f2f5;
        border-radius: 50%;
        border: 2px solid #333;
        z-index: 5;
    }
    .boarding-pass::before { top: -10px; }
    .boarding-pass::after { bottom: -10px; }
</style>