<div class="events-section">
    <style>
        .events-section {
            width: 100%;
            color: #aa2324;
            /* Center the table within the div */
            display: flex;
            justify-content: center;
        }

        .events-section table {
            /* Adjust width to control how "spread out" the location and year are */
            width: 60%;
            border-collapse: collapse;
            color: #aa2324;
            font-family: "Playfair Display", "Georgia", serif;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.15em;
        }

        .events-section td {
            vertical-align: middle;
            padding: 8px 0;
            /* This ensures the content itself is treated as the center of the page */
            text-align: center;
        }

        .location-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            font-size: 15px;
        }
    </style>

    <table>
        <tr>
            <td>
                <!-- @php
                    $event = str_replace('iitm-', '', strtolower($data['eventname']));
                    $parts = explode('-', $event);
                    $year = end($parts);
                    array_pop($parts);
                    $location = ucfirst(implode(' ', $parts));
                @endphp -->

                @php
                    $raw = strtolower(trim($data['eventname'] ?? ''));

                    // normalize separators (spaces → hyphens)
                    $raw = preg_replace('/\s+/', '-', $raw);

                    // remove prefix safely
                    $raw = preg_replace('/^iitm-?/', '', $raw);

                    $parts = array_values(array_filter(explode('-', $raw)));

                    $year = '';
                    $locationParts = $parts;

                    // detect year safely
                    if (!empty($parts) && is_numeric(end($parts))) {
                        $year = array_pop($locationParts);
                    }

                    $location = !empty($locationParts)
                        ? ucwords(str_replace('-', ' ', implode(' ', $locationParts)))
                        : 'Unknown';
                @endphp

                <div class="location-container">
                    <span>{{ $location }}</span>
                    <span
                        style="flex-grow: 1; border-bottom: 1px solid rgba(170, 35, 36, 0.2); margin: 0 20px; height: 1px;"></span>
                    <span>{{ $year }}</span>
                </div>
            </td>
        </tr>
    </table>
</div>