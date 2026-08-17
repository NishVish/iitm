<style>
    :root {
        --primary-color: #AA2D2C;
        --dark-color: #1a1a1a;
        --grey-color: #6b7280;
        --light-bg: #f3f7fa;
    }

    * {
        box-sizing: border-box;
        font-family: 'Inter', -apple-system, sans-serif;
    }

    .stall-section {
        max-width: 1200px;
        margin: auto;
        padding: 70px 20px;
        background: #fff;
    }

    .stall-label {
        font-size: 11px;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: var(--primary-color);
        font-weight: 700;
        margin-bottom: 10px;
        display: block;
    }

    .stall-title {
        font-size: 36px;
        font-weight: 800;
        color: var(--dark-color);
        margin: 0 0 10px;
        line-height: 1.2;
    }

    .stall-title em {
        color: var(--primary-color);
        font-style: normal;
    }

    .stall-subtitle {
        font-size: 15px;
        color: var(--grey-color);
        max-width: 800px;
        line-height: 1.6;
        margin-bottom: 30px;
    }

    .options-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 18px;
        margin-bottom: 40px;
    }

    .option-card {
        background: var(--light-bg);
        padding: 24px;
        border-radius: 16px;
        border: 1px solid rgba(0, 0, 0, 0.04);
        transition: 0.3s ease;
    }

    .option-card:hover {
        transform: translateY(-5px);
        border-color: var(--primary-color);
        background: #fff;
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.06);
    }

    .option-title {
        font-size: 18px;
        font-weight: 800;
        color: var(--dark-color);
        margin-bottom: 10px;
    }

    .option-text {
        font-size: 14px;
        color: var(--grey-color);
        line-height: 1.5;
    }

    .table-wrapper {
        overflow-x: auto;
        margin-top: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        min-width: 800px;
    }

    th,
    td {
        text-align: left;
        padding: 14px 12px;
        border-bottom: 1px solid #eee;
        font-size: 14px;
    }

    th {
        background: var(--light-bg);
        font-weight: 700;
        color: var(--dark-color);
    }

    tr:hover td {
        background: rgba(170, 45, 44, 0.03);
    }

    .highlight-note {
        margin-top: 30px;
        padding: 18px;
        background: rgba(170, 45, 44, 0.05);
        border-left: 4px solid var(--primary-color);
        font-size: 14px;
        color: var(--dark-color);
    }

    @media (max-width: 900px) {
        .options-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<section class="stall-section">

    <span class="stall-label">Stall Booking</span>

    <h2 class="stall-title">Stall <em>Categories & Options</em></h2>

    <p class="stall-subtitle">
        Choose from flexible stall sizes and locations across major cities.
        All stalls can be customized as per 3m × 3m, 6m × 3m, 9m or larger requirements.
    </p>

    <!-- OPTIONS -->
    <div class="options-grid">

        <div class="option-card">
            <div class="option-title">Stall Sizes</div>
            <div class="option-text">
                Standard sizes include 3×3, 6×3, 9×3 and custom layouts based on your branding needs.
            </div>
        </div>

        <div class="option-card">
            <div class="option-title">Customization</div>
            <div class="option-text">
                Fully customizable stalls with branding space, layout design, and structural flexibility.
            </div>
        </div>

        <div class="option-card">
            <div class="option-title">Inclusions</div>
            <div class="option-text">
                Table, chairs, lighting, electricity, and basic stall infrastructure included.
            </div>
        </div>

    </div>

    <!-- TABLE -->
    <div class="table-wrapper">

        <table>
            <thead>
                <tr>
                    <th>Location</th>
                    <th>Year</th>
                    <th>Rate</th>
                    <th>Description</th>
                </tr>
            </thead>

            <tbody>
                @php
                    $locations = [
                        ['Chennai', '2026', '₹34,000/m²', 'Standard exhibition pricing'],
                        ['Bengaluru', '2026', '₹37,000/m²', 'Premium metro pricing'],
                        ['Delhi', '2026', '₹37,000/m²', 'High-demand corporate zone'],
                        ['Mumbai', '2026', '₹37,000/m²', 'Business capital pricing'],
                        ['Pune', '2026', '₹34,000/m²', 'Standard exhibition pricing'],
                        ['Hyderabad', '2026', '₹34,000/m²', 'Standard exhibition pricing'],
                        ['Kochi', '2027', '₹34,000/m²', 'Upcoming edition pricing'],
                        ['Kolkata', '2027', '₹34,000/m²', 'Upcoming edition pricing'],
                        ['Ahmedabad', '2027', '₹37,000/m²', 'Premium industrial hub']
                    ];
                @endphp

                @foreach($locations as $row)
                    <tr>
                        <td>{{ $row[0] }}</td>
                        <td>{{ $row[1] }}</td>
                        <td>{{ $row[2] }}</td>
                        <td>{{ $row[3] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

    <!-- NOTE -->
    <div class="highlight-note">
        <strong>Note:</strong> Stall sizes are flexible. You can book 3m × 3m, 6m × 3m, 9m or larger spaces.
        Custom stall designs are available based on branding requirements.
    </div>

</section>