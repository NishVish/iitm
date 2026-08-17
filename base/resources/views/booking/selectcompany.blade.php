<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Company</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container py-4">

        <h4 class="mb-3">Select Company</h4>

        @if(empty($result) || count($result) === 0)

            <div class="alert alert-warning">
                No companies found.
            </div>

        @else

            <div class="list-group">

                @foreach($result as $company)

                    <div class="list-group-item list-group-item-action">

                        <div class="d-flex justify-content-between align-items-start">

                            <div class="me-3">

                                <h5 class="mb-1">
                                    {{ $company->company_name ?? '' }}
                                </h5>

                                <div class="text-muted small mb-2">
                                    Company ID: {{ $company->company_id ?? '' }}
                                </div>

                                @if(!empty($company->address))
                                    <div class="small">
                                        <strong>Address:</strong>
                                        {{ $company->address }}
                                    </div>
                                @endif

                                @if(!empty($company->city) || !empty($company->state))
                                    <div class="small">
                                        <strong>Location:</strong>
                                        {{ $company->city ?? '' }}
                                        @if(!empty($company->city) && !empty($company->state))
                                            ,
                                        @endif
                                        {{ $company->state ?? '' }}
                                        {{ $company->pincode ?? '' }}
                                    </div>
                                @endif

                                @if(!empty($company->contacts))

                                    <div class="mt-2">

                                        @foreach($company->contacts as $contact)

                                            <div class="small mb-1">

                                                <strong>{{ $contact->name ?? '' }}</strong>

                                                @if(!empty($contact->designation))
                                                    <span class="text-muted">
                                                        — {{ $contact->designation }}
                                                    </span>
                                                @endif

                                                @if(!empty($contact->mobiles))
                                                    <span class="ms-2">
                                                        📱
                                                        @foreach($contact->mobiles as $mobile)
                                                            {{ $mobile->mobile ?? '' }}
                                                        @endforeach
                                                    </span>
                                                @endif

                                                @if(!empty($contact->emails))
                                                    <span class="ms-2">
                                                        ✉️
                                                        @foreach($contact->emails as $email)
                                                            {{ $email->email ?? '' }}
                                                        @endforeach
                                                    </span>
                                                @endif

                                            </div>

                                        @endforeach

                                    </div>

                                @endif

                            </div>

                            <button type="button" class="btn btn-sm btn-primary select-company"
                                data-company-id="{{ $company->company_id }}" data-company-name="{{ $company->company_name }}">
                                Select
                            </button>

                        </div>

                    </div>

                @endforeach

            </div>

        @endif

    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        $(document).on('click', '.select-company', function () {

            const companyId = $(this).data('company-id');

            console.log('Selected Company ID:', companyId);

        });
    </script>

</body>

</html>