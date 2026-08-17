<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\BookingDetail;
use App\Models\EventDetail;
use App\Models\CompanyDetail;
use App\Models\DelegateAttending;
use Illuminate\Support\Facades\DB;



class Dashboard extends Controller
{
    public function index()
    {
        if (session('usertype') !== 'admin') {
            return redirect(url('/'));
        }

        // Get all tables
        $tables = DB::select('SHOW TABLES');

        // Get leads
        $leads = DB::table('company_data')
            ->where('entry_type', 'lead')
            ->get();

        $bookings = DB::table('stall_booking')->get();

        echo $bookings;

        // if ($leads->isNotEmpty()) {

        //     $headers = array_keys((array) $leads->first());

        //     echo '<table border="1" cellpadding="8" cellspacing="0">';

        //     // Header
        //     echo '<thead><tr>';

        //     foreach ($headers as $header) {
        //         echo '<th>' . htmlspecialchars(
        //             ucwords(str_replace('_', ' ', $header))
        //         ) . '</th>';
        //     }

        //     echo '</tr></thead>';

        //     // Values
        //     echo '<tbody>';

        //     foreach ($leads as $lead) {

        //         echo '<tr>';

        //         $row = (array) $lead;

        //         foreach ($headers as $header) {

        //             $value = $row[$header] ?? '';

        //             // Handle JSON / arrays
        //             if (is_array($value) || is_object($value)) {
        //                 $value = json_encode($value);
        //             }

        //             echo '<td>' . htmlspecialchars((string) $value) . '</td>';
        //         }

        //         echo '</tr>';
        //     }

        //     echo '</tbody>';

        //     echo '</table>';

        // } else {

        //     echo '<p>No records found.</p>';
        // }
        return view('dashboard.index', compact('leads', 'tables'));
    }
}
