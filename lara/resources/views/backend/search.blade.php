<h2>Sales Dashboard</h2>
@php
    // $company_id = $results[0]->company_id ?? null;

    $contactid = $results[0]->contact_id;
@endphp
<p>Query: {{ $query ?? '' }}</p>

@if(!empty($results) && count($results) > 0)

    @foreach($results as $row)

        <div style="border:1px solid #ddd; padding:15px; margin:10px 0; border-radius:6px;">

            <h3>{{ $row->name ?? 'N/A' }}</h3>

            <p><b>Phone:</b> {{ $row->phone ?? 'N/A' }}</p>
            <p><b>Email:</b> {{ $row->email ?? 'N/A' }}</p>

            <hr>

            <p><b>Company:</b> {{ $row->company_name ?? 'N/A' }}</p>
            <p><b>Category:</b> {{ $row->category ?? 'N/A' }} / {{ $row->subcategory ?? 'N/A' }}</p>

            <p><b>Address:</b> {{ $row->address ?? '' }}, {{ $row->city ?? '' }}, {{ $row->state ?? '' }}</p>

            <p><b>Website:</b> {{ $row->website ?? 'N/A' }}</p>
            <p><b>GST:</b> {{ $row->gst_number ?? 'N/A' }}</p>

            <p><b>Entry Type:</b> {{ $row->entry_type ?? 'N/A' }}</p>

            <hr>

            <button type="button" onclick="openLeadModal({{ $row->contact_id }})"
                style="padding:8px 14px; background:#28a745; color:white; border:none; cursor:pointer;">
                Mark as Lead
            </button>

        </div>

    @endforeach

@else
    <p>No results found</p>
@endif

<script>
    function openLeadModal(contactId) {
        document.getElementById('leadModal').style.display = 'block';
        document.getElementById('modal_contact_id').value = contactId;
    }

    function closeLeadModal() {
        document.getElementById('leadModal').style.display = 'none';
    }
</script>



@include('backend.leadsform')