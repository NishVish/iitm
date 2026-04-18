@extends('web.layouts.app') {{-- Update to your actual layout --}}

@section('content')
    <div class="section-2">
        <style>
            .preview-container {
                max-width: 1100px;
                margin: 0 auto;
                padding: 80px 20px;
                color: #ffffff;
            }

            .header-box {
                text-align: center;
                margin-bottom: 50px;
            }

            .header-box h2 {
                font-size: 2.5rem;
                font-weight: 800;
                letter-spacing: -1px;
                margin-bottom: 10px;
            }

            .header-box .badge {
                background: rgba(0, 245, 255, 0.1);
                color: var(--accent);
                padding: 5px 15px;
                border-radius: 50px;
                font-size: 0.8rem;
                font-weight: 700;
                border: 1px solid var(--accent);
            }

            /* Dashboard Grid */
            .dashboard-grid {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 20px;
            }

            .matte-card-mini {
                background: var(--card-dark);
                border: 1px solid var(--border-color);
                padding: 25px;
                border-radius: 12px;
                transition: border-color 0.3s ease;
            }

            .matte-card-mini:hover {
                border-color: var(--accent);
            }

            .matte-card-mini h3 {
                font-size: 0.75rem;
                text-transform: uppercase;
                letter-spacing: 2px;
                color: var(--text-muted);
                margin-bottom: 20px;
                border-bottom: 1px solid var(--border-color);
                padding-bottom: 10px;
            }

            /* Data Rows */
            .data-row {
                margin-bottom: 15px;
            }

            .data-label {
                display: block;
                font-size: 0.75rem;
                color: var(--text-muted);
                margin-bottom: 2px;
            }

            .data-value {
                display: block;
                font-size: 1rem;
                font-weight: 600;
                color: #fff;
            }

            .data-value.highlight {
                color: var(--accent);
            }

            /* Pill Tags for Arrays */
            .pill-container {
                display: flex;
                flex-wrap: wrap;
                gap: 8px;
                margin-top: 10px;
            }

            .pill {
                background: #1a1a1e;
                border: 1px solid var(--border-color);
                color: var(--accent);
                padding: 4px 10px;
                border-radius: 4px;
                font-size: 0.7rem;
                font-weight: 700;
                text-transform: uppercase;
            }

            .wide-card {
                grid-column: span 3;
            }

            @media (max-width: 992px) {
                .dashboard-grid {
                    grid-template-columns: 1fr 1fr;
                }

                .wide-card {
                    grid-column: span 2;
                }
            }

            @media (max-width: 600px) {
                .dashboard-grid {
                    grid-template-columns: 1fr;
                }

                .wide-card {
                    grid-column: span 1;
                }
            }
        </style>

        <div class="preview-container">
            <div class="header-box">
                <h2>Registration Complete</h2>
                <span class="badge">DATABASE SYNCHRONIZED</span>
            </div>

            <div class="dashboard-grid">

                {{-- Personal Section (Using DB Data) --}}
                <div class="matte-card-mini">
                    <h3>Representative</h3>
                    <div class="data-row">
                        <span class="data-label">Name</span>
                        <span class="data-value highlight">{{ $dbData->name }}</span>
                    </div>
                    <div class="data-row">
                        <span class="data-label">Designation</span>
                        <span class="data-value">{{ $dbData->designation }}</span>
                    </div>
                    <div class="data-row">
                        <span class="data-label">Contact</span>
                        <span class="data-value">{{ $dbData->mobile }}</span>
                        <span class="data-value">{{ $dbData->email }}</span>
                    </div>
                </div>

                {{-- Company Section (Using DB Data) --}}
                <div class="matte-card-mini">
                    <h3>Organization</h3>
                    <div class="data-row">
                        <span class="data-label">Company Name</span>
                        <span class="data-value highlight">{{ $dbData->company_name }}</span>
                    </div>
                    <div class="data-row">
                        <span class="data-label">Location</span>
                        <span class="data-value">{{ $dbData->city }}, {{ $dbData->state }}</span>
                        <span class="data-value">{{ $dbData->country }} - {{ $dbData->pincode }}</span>
                    </div>
                    <div class="data-row">
                        <span class="data-label">Website</span>
                        <span class="data-value" style="font-size: 0.8rem;">{{ $dbData->website }}</span>
                    </div>
                </div>

                {{-- Event Status --}}
                <div class="matte-card-mini">
                    <h3>Event Engagement</h3>
                    <div class="data-row">
                        <span class="data-label">Staff Count</span>
                        <span class="data-value">{{ $sentData['total_staff'] ?? 'N/A' }}</span>
                    </div>
                    <div class="data-row">
                        <span class="data-label">TTF Alumni</span>
                        <span class="data-value">{{ $sentData['attended_ttf_before'] ?? 'No' }}</span>
                    </div>
                    <div class="data-row">
                        <span class="data-label">Forum Interest</span>
                        <span class="data-value">{{ $sentData['interested_in_forum'] ?? 'No' }}</span>
                    </div>
                </div>

                {{-- Wide Section for Arrays (Travel & Preferences) --}}
                <div class="matte-card-mini wide-card">
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 40px;">

                        <div>
                            <h3>Travel Segments</h3>
                            <div class="pill-container">
                                @forelse($sentData['travel_segments'] ?? [] as $item)
                                    <span class="pill">{{ $item }}</span>
                                @empty
                                    <span class="data-label">None selected</span>
                                @endforelse
                            </div>
                        </div>

                        <div>
                            <h3>Meet Preferences</h3>
                            <div class="pill-container">
                                @forelse($sentData['meet_profiles'] ?? [] as $item)
                                    <span class="pill">{{ $item }}</span>
                                @empty
                                    <span class="data-label">None selected</span>
                                @endforelse
                            </div>
                        </div>

                        <div>
                            <h3>Interested States</h3>
                            <div class="pill-container">
                                @forelse($sentData['interested_states'] ?? [] as $item)
                                    <span class="pill">{{ $item }}</span>
                                @empty
                                    <span class="data-label">None selected</span>
                                @endforelse
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Business Details --}}
                <div class="matte-card-mini wide-card">
                    <h3>Business Narrative & Referral</h3>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px;">
                        <div class="data-row">
                            <span class="data-label">Attending Reason</span>
                            <p class="data-value" style="font-weight: 400; font-size: 0.9rem;">
                                {{ $sentData['attending_reason'] }}</p>
                        </div>
                        <div class="data-row">
                            <span class="data-label">Referral Source</span>
                            <span class="data-value">{{ $sentData['referral_details'] ?? 'Direct / Organic' }}</span>
                        </div>
                    </div>
                </div>

            </div>

            <div style="text-align: center; margin-top: 50px;">
                <a href="{{ url('/') }}" class="btn-return"
                    style="background: var(--accent); color: #000; padding: 15px 40px; border-radius: 8px; font-weight: 800; text-decoration: none;">DOWNLOAD
                    CONFIRMATION</a>
            </div>
        </div>
    </div>
@endsection