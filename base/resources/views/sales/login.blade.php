@php 
    $lastsegment = Request::segment(1);
@endphp

@if($lastsegment == 'sales')
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sales Login | IITM</title>

        <!-- Bootstrap 5 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

        <!-- Custom Theme Styling -->
        <style>
            :root {
                --brand-color: rgb(165, 30, 37);
                --brand-color-hover: rgb(135, 20, 26);
            }

            .bg-brand {
                background-color: var(--brand-color) !important;
            }

            .text-brand {
                color: var(--brand-color) !important;
            }

            .btn-brand {
                background-color: var(--brand-color);
                border-color: var(--brand-color);
                color: #ffffff;
                transition: all 0.2s ease-in-out;
            }

            .btn-brand:hover,
            .btn-brand:focus,
            .btn-brand:active {
                background-color: var(--brand-color-hover) !important;
                border-color: var(--brand-color-hover) !important;
                color: #ffffff !important;
                box-shadow: 0 4px 12px rgba(165, 30, 37, 0.25) !important;
            }

            .form-control:focus {
                border-color: var(--brand-color) !important;
                box-shadow: 0 0 0 0.25rem rgba(165, 30, 37, 0.15) !important;
            }

            .input-group-text-custom {
                background-color: #ffffff;
                border-color: #dee2e6;
                color: var(--brand-color);
            }
        </style>
    </head>

    <body class="bg-light">

        <div class="d-flex align-items-center justify-content-center min-vh-100 px-3 py-5">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden" style="max-width: 420px; width: 100%;">

                {{-- Top Theme Accent Bar --}}
                <div class="bg-brand py-1.5"></div>

                <div class="card-body p-4 p-md-5 text-center">

                    {{-- Logo Header --}}
                    <div class="mb-4">
                        <img src="https://iitmindia.com/wp-content/uploads/elementor/thumbs/IITM-new-logo-2026-scaled-rreo6ngtix52iulqek96x9dehvo5df6r0r4ufg74n4.png"
                            alt="IITM Logo" class="img-fluid mb-3" style="max-height: 75px; object-fit: contain;">

                        <h5 class="fw-bold text-dark mb-1">Sales Verification</h5>
                        <p class="text-muted small mb-0">Enter your official Sales ID to access the panel</p>
                    </div>

                    {{-- Sales Verification Form --}}
                    <form action="{{ url('login_sales') }}" method="POST">
                        @csrf

                        <div class="mb-4 text-start">
                            <label for="sales_id" class="form-label text-muted small fw-semibold">Sales ID</label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-custom border-end-0 ps-3">
                                    <i class="fas fa-id-badge"></i>
                                </span>
                                <input type="text" id="sales_id" name="id" class="form-control border-start-0 ps-2 py-2.5"
                                    placeholder="Enter your Sales ID" required autofocus>
                            </div>
                        </div>

                        <button type="submit"
                            class="btn btn-brand w-100 py-2.5 fw-semibold rounded-3 shadow-sm d-flex align-items-center justify-content-center gap-2">
                            <span>Verify & Continue</span>
                            <i class="fas fa-arrow-right small"></i>
                        </button>
                    </form>

                </div>

                {{-- Footer Branding --}}
                <div class="card-footer bg-white border-0 py-3 text-center border-top border-light">
                    <span class="text-muted small">IITM India &copy; {{ date('Y') }}</span>
                </div>

            </div>
        </div>

    </body>

    </html>
@else
    @include('auth.exhibitorlogin')
@endif