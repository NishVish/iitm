<?php

use Illuminate\Support\Facades\Route;

use Illuminate\Http\Request;

// if (session('type') == null) {
//     Route::get('/admin', function () {
//         return redirect('/admin/login');
//     });
// }

// if (!str_contains(request()->path(), 'api')) {
//     echo '
//     <div style="text-align: center; margin-bottom: 20px;">
//         <a href="' . url('/admin') . '" style="margin-right: 15px;">Admin Home</a>
//         <a href="' . url('/exhibitor/form') . '" style="margin-right: 15px;">Customer Form</a>
//         <a href="' . url('/exhibitor/dashboard') . '">Customer Dashboard</a>
//     </div>
//       <a href="' . url('/admin/logout') . '" style="
//                 background:#dc3545;
//                 color:white;
//                 text-decoration:none;
//                 padding:8px 15px;
//                 border-radius:5px;
//                 font-weight:bold;
//             ">
//                 Logout
//             </a>
//     ';
// }
// echo session('type');

use Illuminate\Support\Facades\DB;

Route::get('/backend', function () {

    $tables = DB::select('SHOW TABLES');

    echo '<div style="font-family: Arial, sans-serif; padding: 20px;">';

    foreach ($tables as $table) {

        $tableName = array_values((array) $table)[0];

        echo '<h2 style="margin-top:30px;">'
            . htmlspecialchars($tableName)
            . '</h2>';

        $columns = DB::select("DESCRIBE `$tableName`");

        echo '
        <table border="1"
               cellpadding="8"
               cellspacing="0"
               style="border-collapse:collapse; width:100%; margin-bottom:30px;">

            <thead style="background:#f2f2f2;">
                <tr>
                    <th>#</th>
                    <th>Column</th>
                    <th>Type</th>
                    <th>Null</th>
                    <th>Key</th>
                    <th>Default</th>
                    <th>Extra</th>
                </tr>
            </thead>

            <tbody>
        ';

        $i = 1;

        foreach ($columns as $column) {

            echo '<tr>';

            echo '<td>' . $i++ . '</td>';

            echo '<td>'
                . htmlspecialchars($column->Field)
                . '</td>';

            echo '<td>'
                . htmlspecialchars($column->Type)
                . '</td>';

            echo '<td>'
                . htmlspecialchars($column->Null)
                . '</td>';

            echo '<td>'
                . htmlspecialchars($column->Key)
                . '</td>';

            echo '<td>'
                . htmlspecialchars($column->Default ?? 'NULL')
                . '</td>';

            echo '<td>'
                . htmlspecialchars($column->Extra)
                . '</td>';

            echo '</tr>';
        }

        echo '
            </tbody>
        </table>
        ';
    }

    echo '</div>';
});

require __DIR__ . '/booking/booking.php';

require __DIR__ . '/authentication.php';
require __DIR__ . '/admin/admin.php';
require __DIR__ . '/dashboard/dashboard.php';
require __DIR__ . '/exhibitor/exhibitor.php';
require __DIR__ . '/company/company.php';
require __DIR__ . '/ai/ai.php';

require __DIR__ . '/sales/sales.php';

require __DIR__ . '/update/update.php';

require __DIR__ . '/getdata/getdata.php';

require __DIR__ . '/backend/backend.php';
require __DIR__ . '/razorpay.php';
Route::post('postcheck', function (Request $request) {

    dd($request->all());

})->name('postcheck');