<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BackendController extends Controller
{
    public function backend()
    {
        $database = DB::getDatabaseName();

        // Get all tables
        $tables = DB::select(
            "SELECT TABLE_NAME
             FROM information_schema.TABLES
             WHERE TABLE_SCHEMA = ?
             AND TABLE_TYPE = 'BASE TABLE'
             ORDER BY TABLE_NAME",
            [$database]
        );

        $result = [];

        foreach ($tables as $table) {

            $tableName = $table->TABLE_NAME;

            // Get table columns / structure
            $columns = DB::select(
                "SELECT
                    ORDINAL_POSITION,
                    COLUMN_NAME,
                    COLUMN_TYPE,
                    DATA_TYPE,
                    COLLATION_NAME,
                    IS_NULLABLE,
                    COLUMN_DEFAULT,
                    COLUMN_COMMENT,
                    EXTRA,
                    COLUMN_KEY,
                    CHARACTER_SET_NAME
                 FROM information_schema.COLUMNS
                 WHERE TABLE_SCHEMA = ?
                 AND TABLE_NAME = ?
                 ORDER BY ORDINAL_POSITION",
                [$database, $tableName]
            );

            $result[] = [
                'table' => $tableName,
                'columns' => $columns,
            ];
        }

        return view('backend.index', compact('result', 'database'));
    }


    public function backendcreate()
    {
        // Get table names only
        $tables = DB::select('SHOW TABLES');

        $result = [];

        foreach ($tables as $table) {

            $tableName = array_values((array) $table)[0];

            // Get complete CREATE TABLE schema
            $schema = DB::select("SHOW CREATE TABLE `{$tableName}`");

            $result[] = [
                'table' => $tableName,
                'schema' => $schema[0]->{'Create Table'},
            ];
        }

        return view('backend.index', compact('result'));
    }

    public function runquery(Request $request)
    {
        $request->validate([
            'query' => ['required', 'string'],
        ]);

        try {
            $query = trim($request->input('query'));

            $result = DB::select($query);

            return response()->json([
                'success' => true,
                'data' => $result,
            ]);

        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}