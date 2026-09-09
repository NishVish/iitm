<?php

namespace App\Http\Controllers\Database;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Laravel\Prompts\Elements\NumberedList;

class DatabaseController extends Controller
{

    public function index()
    {
        // Get tables from both databases
        $mysqlTables = DB::connection('mysql')
            ->select('SHOW TABLES');

        $liveTables = DB::connection('live')
            ->select('SHOW TABLES');

        // Convert results into simple table-name arrays
        $mysqlTableNames = collect($mysqlTables)
            ->map(fn($table) => array_values((array) $table)[0])
            ->values()
            ->toArray();

        $liveTableNames = collect($liveTables)
            ->map(fn($table) => array_values((array) $table)[0])
            ->values()
            ->toArray();

        // All unique table names
        $allTables = collect([
            ...$mysqlTableNames,
            ...$liveTableNames,
        ])->unique()->sort()->values();

        echo '<!DOCTYPE html>';
        echo '<html>';
        echo '<head>';
        echo '<meta charset="UTF-8">';
        echo '<title>Database Table Comparison</title>';

        echo '<style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            padding: 20px;
        }

        h1 {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 12px;
            vertical-align: top;
            text-align: left;
        }

        th {
            background: #222;
            color: #fff;
        }

        .database-header {
            background: #0066cc;
            color: white;
            text-align: center;
            font-size: 18px;
        }

        .live-header {
            background: #198754;
        }

        .table-name {
            font-weight: bold;
            background: #f0f0f0;
            width: 15%;
        }

        .exists {
            color: green;
            font-weight: bold;
        }

        .missing {
            color: red;
            font-weight: bold;
        }

        pre {
            white-space: pre-wrap;
            word-break: break-word;
            background: #f8f8f8;
            padding: 10px;
            border-radius: 4px;
            font-size: 12px;
            max-height: 400px;
            overflow: auto;
        }
    </style>';

        echo '</head>';
        echo '<body>';

        echo '<h1>Database Table Comparison</h1>';

        echo '<table>';

        echo '<tr>';
        echo '<th class="table-name">Table</th>';
        echo '<th class="database-header">MYSQL</th>';
        echo '<th class="database-header live-header">LIVE</th>';
        echo '</tr>';

        foreach ($allTables as $tableName) {

            $mysqlExists = in_array($tableName, $mysqlTableNames);
            $liveExists = in_array($tableName, $liveTableNames);

            echo '<tr>';

            // Table name
            echo '<td class="table-name">';
            echo htmlspecialchars($tableName);
            echo '</td>';

            /*
            |--------------------------------------------------------------------------
            | MYSQL
            |--------------------------------------------------------------------------
            */

            echo '<td>';

            if ($mysqlExists) {

                echo '<div class="exists">✓ EXISTS</div>';

                try {

                    $result = DB::connection('mysql')
                        ->select("SHOW CREATE TABLE `{$tableName}`");

                    if (!empty($result)) {

                        $createSql = array_values((array) $result[0]);

                        // SHOW CREATE TABLE returns:
                        // [0] => table name
                        // [1] => CREATE TABLE SQL

                        $createSql = $createSql[1] ?? '';

                        echo '<pre>';
                        echo htmlspecialchars($createSql);
                        echo '</pre>';
                    }

                } catch (\Throwable $e) {

                    echo '<div class="missing">';
                    echo 'Error: ' . htmlspecialchars($e->getMessage());
                    echo '</div>';
                }

            } else {

                echo '<div class="missing">✗ NOT EXISTS</div>';
            }

            echo '</td>';

            /*
            |--------------------------------------------------------------------------
            | LIVE
            |--------------------------------------------------------------------------
            */

            echo '<td>';

            if ($liveExists) {

                echo '<div class="exists">✓ EXISTS</div>';

                try {

                    $result = DB::connection('live')
                        ->select("SHOW CREATE TABLE `{$tableName}`");

                    if (!empty($result)) {

                        $createSql = array_values((array) $result[0]);

                        $createSql = $createSql[1] ?? '';

                        echo '<pre>';
                        echo htmlspecialchars($createSql);
                        echo '</pre>';
                    }

                } catch (\Throwable $e) {

                    echo '<div class="missing">';
                    echo 'Error: ' . htmlspecialchars($e->getMessage());
                    echo '</div>';
                }

            } else {

                echo '<div class="missing">✗ NOT EXISTS</div>';
            }

            echo '</td>';

            echo '</tr>';
        }

        echo '</table>';

        echo '</body>';
        echo '</html>';

        exit;
    }

    //    public function index()
    // {

    //     step 1 is normalization 

    //     normalize the mobile NumberedList 

    //     if the number containt "/"
    //     and the matching contact id also contains "/" 
    //     make new contact and new mobile same with 


    //     // Get all database tables
    //     $tables = DB::table('contact_mobile')->get();

    //     // // Debug and display the tables
    //     // do these things 

    //     // insert the log number 
    //     dd($tables);
    // }
}
