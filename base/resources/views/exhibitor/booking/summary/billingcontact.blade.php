<div style="
    max-width: 900px;
    margin: 30px auto;
    padding: 28px;
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.06);
    font-family: Arial, sans-serif;
">

    <div style="
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    ">
        <div>
            <h2 style="
                margin: 0;
                color: #111827;
                font-size: 22px;
            ">
                Billing Contact
            </h2>

            <p style="
                margin: 6px 0 0;
                color: #6b7280;
                font-size: 14px;
            ">
                Primary contact for billing and communication
            </p>
        </div>

        @if($billingcontact && (int) ($billingcontact->billing_contact ?? 0) === 1)
            <span style="
                    background: #dcfce7;
                    color: #166534;
                    padding: 6px 12px;
                    border-radius: 20px;
                    font-size: 13px;
                    font-weight: 600;
                ">
                Billing Contact
            </span>
        @endif
    </div>

    @if($billingcontact)

        <div style="
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 18px;
            ">

            <div style="
                    padding: 18px;
                    background: #f9fafb;
                    border-radius: 10px;
                    border: 1px solid #f3f4f6;
                ">
                <div style="
                        color: #6b7280;
                        font-size: 12px;
                        font-weight: 600;
                        text-transform: uppercase;
                        margin-bottom: 6px;
                    ">
                    Name
                </div>

                <div style="
                        color: #111827;
                        font-size: 16px;
                        font-weight: 600;
                    ">
                    {{ $billingcontact->name ?? '-' }}
                </div>
            </div>

            <div style="
                    padding: 18px;
                    background: #f9fafb;
                    border-radius: 10px;
                    border: 1px solid #f3f4f6;
                ">
                <div style="
                        color: #6b7280;
                        font-size: 12px;
                        font-weight: 600;
                        text-transform: uppercase;
                        margin-bottom: 6px;
                    ">
                    Designation
                </div>

                <div style="
                        color: #111827;
                        font-size: 16px;
                    ">
                    {{ $billingcontact->designation ?? '-' }}
                </div>
            </div>

            <div style="
                    padding: 18px;
                    background: #f9fafb;
                    border-radius: 10px;
                    border: 1px solid #f3f4f6;
                ">
                <div style="
                        color: #6b7280;
                        font-size: 12px;
                        font-weight: 600;
                        text-transform: uppercase;
                        margin-bottom: 6px;
                    ">
                    Email
                </div>

                @if(!empty($billingcontact->email))
                    <a href="mailto:{{ $billingcontact->email }}" style="
                                    color: #4f46e5;
                                    font-size: 15px;
                                    text-decoration: none;
                                    word-break: break-word;
                                ">
                        {{ $billingcontact->email }}
                    </a>
                @else
                    <div style="color: #9ca3af;">-</div>
                @endif
            </div>

            <div style="
                    padding: 18px;
                    background: #f9fafb;
                    border-radius: 10px;
                    border: 1px solid #f3f4f6;
                ">
                <div style="
                        color: #6b7280;
                        font-size: 12px;
                        font-weight: 600;
                        text-transform: uppercase;
                        margin-bottom: 6px;
                    ">
                    Mobile
                </div>

                @if(!empty($billingcontact->mobile))
                    <a href="tel:{{ $billingcontact->mobile }}" style="
                                    color: #4f46e5;
                                    font-size: 15px;
                                    text-decoration: none;
                                ">
                        {{ $billingcontact->mobile }}
                    </a>
                @else
                    <div style="color: #9ca3af;">-</div>
                @endif
            </div>

        </div>

        <div style="
                margin-top: 18px;
                padding: 14px 18px;
                background: #f5f3ff;
                border: 1px solid #ddd6fe;
                border-radius: 10px;
                display: flex;
                justify-content: space-between;
                gap: 15px;
                flex-wrap: wrap;
            ">
            <div>
                <span style="
                        color: #6b7280;
                        font-size: 12px;
                        display: block;
                        margin-bottom: 4px;
                    ">
                    Contact ID
                </span>

                <strong style="color: #3730a3;">
                    {{ $billingcontact->contact_id ?? '-' }}
                </strong>
            </div>

            <div>
                <span style="
                        color: #6b7280;
                        font-size: 12px;
                        display: block;
                        margin-bottom: 4px;
                    ">
                    Company ID
                </span>

                <strong style="color: #3730a3;">
                    {{ $billingcontact->company_id ?? '-' }}
                </strong>
            </div>
        </div>

    @else

        <div style="
                padding: 35px;
                text-align: center;
                background: #f9fafb;
                border: 1px dashed #d1d5db;
                border-radius: 10px;
            ">
            <div style="
                    font-size: 16px;
                    font-weight: 600;
                    color: #374151;
                ">
                No billing contact found
            </div>

            <div style="
                    margin-top: 6px;
                    color: #6b7280;
                    font-size: 14px;
                ">
                A billing contact has not been assigned to this booking.
            </div>
        </div>

    @endif

</div>