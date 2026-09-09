<form action="{{ url('updateAllContacts') }}" method="POST" id="contacts-form">
    @csrf

    <div class="ui-table-container">
        <div class="ui-table-header">
            <h4 style="margin: 0; font-weight: 700; color: #111827;">
                Contact Persons
            </h4>

            <button type="button" class="ui-btn ui-btn-outline" onclick="addContactRow()">
                + Add Contact
            </button>
        </div>

        <div style="overflow-x: auto;">
            <table class="ui-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th style="width: 100px; text-align: center;">Delegate</th>
                        <th>Name *</th>
                        <th>Designation</th>
                        <th>Email *</th>
                        <th>Mobile</th>
                        <th style="width: 80px; text-align: center;">Action</th>
                    </tr>
                </thead>

                <tbody id="contacts-table-body">

                    @forelse($contact as $index => $contactData)

                        <tr class="contact-row" data-index="{{ $index }}">

                            @include('exhibitor.booking.basicdata')

                            <td class="row-number fw-bold text-secondary">
                                {{ $index + 1 }}
                            </td>

                            <td style="text-align: center; vertical-align: middle;">

                                <input type="hidden" name="stall_id" value="{{ $item->id }}">
                                <input type="hidden" name="contacts[{{ $index }}][contact_id]"
                                    value="{{ $contactData->contact_id ?? '' }}">

                                <input type="hidden" name="contacts[{{ $index }}][company_id]"
                                    value="{{ $contactData->company_id ?? ($company_id ?? '') }}">

                                <label style="
                                                    display: inline-flex;
                                                    align-items: center;
                                                    justify-content: center;
                                                    cursor: pointer;
                                                ">
                                    <input type="checkbox" name="contacts[{{ $index }}][delegate]" value="1" style="
                                                            width: 18px;
                                                            height: 18px;
                                                            cursor: pointer;
                                                            accent-color: #2563eb;
                                                        ">
                                </label>

                            </td>

                            <td>
                                <input type="text" name="contacts[{{ $index }}][name]" class="ui-input"
                                    placeholder="Full Name" value="{{ $contactData->name ?? '' }}" required>
                            </td>

                            <td>
                                <input type="text" name="contacts[{{ $index }}][designation]" class="ui-input"
                                    placeholder="Job Title" value="{{ $contactData->designation ?? '' }}">
                            </td>

                            <td>
                                <input type="email" name="contacts[{{ $index }}][email]" class="ui-input"
                                    placeholder="name@company.com" value="{{ $contactData->email ?? '' }}" required>
                            </td>

                            <td>
                                <input type="tel" name="contacts[{{ $index }}][mobile]" class="ui-input"
                                    placeholder="+91 00000 00000" value="{{ $contactData->mobile ?? '' }}">
                            </td>

                            <td style="text-align: center;">
                                @if($index > 0)
                                    <button type="button" class="ui-btn-danger" onclick="removeContactRow(this)">
                                        Remove
                                    </button>
                                @endif
                            </td>

                        </tr>

                    @empty

                        <tr class="contact-row" data-index="0">

                            <td class="row-number fw-bold text-secondary">
                                1
                            </td>

                            <td style="text-align: center; vertical-align: middle;">

                                <input type="hidden" name="contacts[0][company_id]" value="{{ $company_id ?? '' }}">

                                <label style="
                                                    display: inline-flex;
                                                    align-items: center;
                                                    justify-content: center;
                                                    cursor: pointer;
                                                ">
                                    <input type="checkbox" name="contacts[0][delegate]" value="1" style="
                                                            width: 18px;
                                                            height: 18px;
                                                            cursor: pointer;
                                                            accent-color: #2563eb;
                                                        ">
                                </label>

                            </td>

                            <td>
                                <input type="text" name="contacts[0][name]" class="ui-input" placeholder="Full Name"
                                    required>
                            </td>

                            <td>
                                <input type="text" name="contacts[0][designation]" class="ui-input" placeholder="Job Title">
                            </td>

                            <td>
                                <input type="email" name="contacts[0][email]" class="ui-input"
                                    placeholder="name@company.com" required>
                            </td>

                            <td>
                                <input type="tel" name="contacts[0][mobile]" class="ui-input" placeholder="+91 00000 00000">
                            </td>

                            <td style="text-align: center;"></td>

                        </tr>

                    @endforelse

                </tbody>
            </table>
        </div>

        <div style="text-align: right; margin-top: 12px;">
            <button type="submit" class="ui-btn" style="padding: 10px 28px; font-size: 0.95rem;">
                Save All Contacts
            </button>
        </div>
    </div>
</form>

@include('exhibitor.booking.delegate.script')
@include('exhibitor.booking.delegate.css')