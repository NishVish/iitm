<form id="exhibitorForm">
    @csrf

    <div class="mb-3">
        <h3 style="text-align: center; font-weight:bold;">{{ $data->first()->company_name ?? '' }}</h3>
    </div>
    <form id="exhibitorForm">
        @csrf

        @forelse($data as $i => $exhibitor)

            <!-- STACK CARD -->
            <div class="card mb-3 shadow-sm">
                <h3>{{ "Conatact:-" . $i + 1 }}</h3>

                <div class="card-body">

                    <!-- KEEP ALL HIDDEN ESSENTIAL FIELDS -->
                    <input type="hidden" name="persons[{{ $i }}][person_key]" value="{{ $exhibitor->person_key }}">
                    <input type="hidden" name="persons[{{ $i }}][identifierkey]" value="{{ $exhibitor->identifierkey }}">
                    <input type="hidden" name="persons[{{ $i }}][city]" value="{{ $exhibitor->city }}">
                    <input type="hidden" name="persons[{{ $i }}][state]" value="{{ $exhibitor->state }}">
                    <input type="hidden" name="persons[{{ $i }}][bag_collected]" value="{{ $exhibitor->bag_collected }}">
                    <input type="hidden" name="persons[{{ $i }}][company_name]" value="{{ $exhibitor->company_name }}">

                    <div class="mb-2">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" name="persons[{{ $i }}][name]"
                            value="{{ $exhibitor->name }}">
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Designation</label>
                        <input type="text" class="form-control" name="persons[{{ $i }}][designation]"
                            value="{{ $exhibitor->designation }}">
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Mobile</label>
                        <input type="text" class="form-control" name="persons[{{ $i }}][mobile]"
                            value="{{ $exhibitor->mobile }}">
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="persons[{{ $i }}][email]"
                            value="{{ $exhibitor->email }}">
                    </div>

                </div>
            </div>

        @empty
            <div class="alert alert-warning text-center">
                No records found.
            </div>
        @endforelse

        @if($data->count())
            <div class="text-end">
                <button type="submit" class="btn-save">
                    Save Changes
                </button>
                <style>
                    .btn-save {
                        background: linear-gradient(135deg, #4f8cff, #1e60ff);
                        color: #fff;
                        border: none;
                        padding: 10px 22px;
                        font-size: 15px;
                        font-weight: 600;
                        border-radius: 999px;
                        cursor: pointer;
                        display: inline-flex;
                        align-items: center;
                        gap: 8px;
                        box-shadow: 0 6px 14px rgba(30, 96, 255, 0.25);
                        transition: all 0.25s ease;
                    }

                    .btn-save:hover {
                        transform: translateY(-2px);
                        box-shadow: 0 8px 18px rgba(30, 96, 255, 0.35);
                    }

                    .btn-save:active {
                        transform: scale(0.97);
                    }

                    .btn-save::before {
                        content: "💾";
                        font-size: 14px;
                    }
                </style>
            </div>
        @endif
    </form>

    <style>
        @media (max-width: 768px) {
            .card {
                border-radius: 12px;
            }

            .form-label {
                font-weight: 600;
                font-size: 13px;
            }

            .form-control {
                font-size: 14px;
            }
        }
    </style>

</form>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $('#exhibitorForm').on('submit', function (e) {
        e.preventDefault();

        $.ajax({
            url: "{{ url('delegatesupdate') }}",
            type: "POST",
            data: $(this).serialize(),

            success: function (res) {
                console.log("SUCCESS RESPONSE:", res);
                alert('Updated successfully');
            },

            error: function (xhr, status, error) {

                console.log("STATUS:", status);
                console.log("ERROR:", error);
                console.log("RESPONSE TEXT:", xhr.responseText);
                console.log("HTTP STATUS:", xhr.status);

                alert('Update failed (check console)');
            }
        });
    });
</script>