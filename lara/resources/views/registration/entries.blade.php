<div style="padding:20px; background:#f8fafc; min-height:100vh; color:#111827;">

    <h2 style="color:#111827; margin-bottom:15px;">📋 Exhibitor Entries</h2>

    {{-- FILTER BUTTONS --}}
    <div style="margin-bottom:15px; display:flex; flex-wrap:wrap; gap:8px;">

        <a href="{{ url()->current() }}"
            style="padding:8px 12px; background:#111827; color:#fff; border-radius:6px; text-decoration:none;">
            All
        </a>

        @foreach($states as $state)
            <a href="{{ urlencode($state->state) }}"
                style="padding:8px 12px; background:#e5e7eb; color:#111827; border-radius:6px; text-decoration:none;">
                {{ $state->state }}
            </a>
        @endforeach

        @foreach($cities as $city)
            <a href="{{ urlencode($city->city) }}"
                style="padding:8px 12px; background:#dbeafe; color:#111827; border-radius:6px; text-decoration:none;">
                {{ $city->city }}
            </a>
        @endforeach

    </div>

    <div style="overflow-x:auto;">
        <table
            style="width:100%; border-collapse:collapse; background:#ffffff; border-radius:10px; overflow:hidden; box-shadow:0 2px 10px rgba(0,0,0,0.06);">

            <thead>
                <tr style="background:#e5e7eb; text-align:left; color:#111827;">
                    <th style="padding:12px;">ID</th>
                    <th style="padding:12px;">Key</th>
                    <th style="padding:12px;">Name</th>
                    <th style="padding:12px;">Company</th>
                    <th style="padding:12px;">Stall</th>
                    <th style="padding:12px;">Exhibiting In</th>
                    <th style="padding:12px;">State</th>
                    <th style="padding:12px;">Mobile</th>
                    <th style="padding:12px;">Created</th>
                </tr>
            </thead>

            <tbody>
                @foreach($data as $d)
                    <tr style="border-bottom:1px solid #e5e7eb;">
                        <td style="padding:10px;">{{ $d->id }}</td>
                        <td style="padding:10px; color:#7c3aed;">{{ $d->person_key }}</td>
                        <td style="padding:10px; color:#2563eb; font-weight:600;">{{ $d->name }}</td>
                        <td style="padding:10px;">{{ $d->company_name }}</td>
                        <td style="padding:10px;">{{ $d->address }}</td>
                        <td style="padding:10px;">{{ $d->city }}</td>
                        <td style="padding:10px;">{{ $d->state }}</td>
                        <td style="padding:10px;">{{ $d->mobile }}</td>
                        <td style="padding:10px; font-size:12px; color:#6b7280;">{{ $d->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>

        </table>
    </div>

</div>