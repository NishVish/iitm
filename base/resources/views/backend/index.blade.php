<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Database Structure</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: #f1f3f6;
            color: #212529;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 14px;
        }

        /*
        |--------------------------------------------------------------------------
        | Main wrapper
        |--------------------------------------------------------------------------
        */
        .page {
            width: 95%;
            max-width: 1600px;
            margin: 30px auto;
        }

        /*
        |--------------------------------------------------------------------------
        | Top bar
        |--------------------------------------------------------------------------
        */
        .topbar {
            background: #343a40;
            color: white;
            padding: 18px 25px;
            border-radius: 6px 6px 0 0;
        }

        .topbar h1 {
            margin: 0;
            font-size: 20px;
            font-weight: 500;
        }

        .database {
            color: #adb5bd;
            font-size: 13px;
            margin-top: 5px;
        }

        /*
        |--------------------------------------------------------------------------
        | Content
        |--------------------------------------------------------------------------
        */
        .container {
            width: 100%;
            padding: 25px;
            background: #f1f3f6;
        }

        /*
        |--------------------------------------------------------------------------
        | Table wrapper
        |--------------------------------------------------------------------------
        */
        .table-wrapper {
            background: white;
            margin-bottom: 35px;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, .05);
            overflow: hidden;
        }

        .table-title {
            padding: 15px 18px;
            background: #e9ecef;
            border-bottom: 1px solid #ced4da;
            font-size: 17px;
            font-weight: bold;
        }

        .table-title span {
            color: #6c757d;
            font-weight: normal;
        }

        /*
        |--------------------------------------------------------------------------
        | Structure table
        |--------------------------------------------------------------------------
        */
        .table-scroll {
            width: 100%;
            overflow-x: auto;
        }

        .structure-table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
        }

        .structure-table th {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            padding: 10px 8px;
            text-align: left;
            white-space: nowrap;
            font-weight: 600;
        }

        .structure-table td {
            border: 1px solid #dee2e6;
            padding: 9px 8px;
            vertical-align: middle;
        }

        .structure-table tbody tr:hover {
            background: #f8f9fa;
        }

        /*
        |--------------------------------------------------------------------------
        | Columns
        |--------------------------------------------------------------------------
        */
        .number {
            width: 45px;
            text-align: center;
            color: #6c757d;
        }

        .name {
            font-weight: 600;
            color: #212529;
            white-space: nowrap;
        }

        .type {
            color: #0056b3;
            font-family: monospace;
            white-space: nowrap;
        }

        .collation {
            color: #6c757d;
            white-space: nowrap;
        }

        .null {
            text-align: center;
        }

        .null-no {
            color: #dc3545;
            font-weight: bold;
        }

        .null-yes {
            color: #198754;
        }

        .default {
            font-family: monospace;
            white-space: nowrap;
        }

        .comment {
            color: #6c757d;
        }

        .extra {
            font-family: monospace;
            color: #6f42c1;
            white-space: nowrap;
        }

        /*
        |--------------------------------------------------------------------------
        | Primary / Index
        |--------------------------------------------------------------------------
        */
        .primary {
            color: #dc3545;
            font-weight: bold;
        }

        .index {
            color: #fd7e14;
            font-weight: bold;
        }

        .primary small,
        .index small {
            font-size: 10px;
            margin-left: 4px;
            font-weight: normal;
        }

        /*
        |--------------------------------------------------------------------------
        | Empty
        |--------------------------------------------------------------------------
        */
        .empty {
            padding: 30px;
            background: white;
            text-align: center;
            color: #6c757d;
            border: 1px solid #dee2e6;
            border-radius: 5px;
        }

        /*
        |--------------------------------------------------------------------------
        | Responsive
        |--------------------------------------------------------------------------
        */
        @media (max-width: 900px) {

            .page {
                width: 100%;
                margin: 0;
            }

            .topbar {
                border-radius: 0;
            }

            .container {
                padding: 10px;
            }

            .structure-table {
                min-width: 1100px;
            }
        }
    </style>
</head>

<body>

    <div class="page">

        {{-- Header --}}
        <div class="topbar">

            <h1>Database Structure</h1>

            <div class="database">
                Database: <strong>{{ $database }}</strong>
            </div>

        </div>


        {{-- Tables --}}
        <div class="container">

            @forelse ($result as $table)

                <div class="table-wrapper">

                    <div class="table-title">
                        Table:
                        <strong>{{ $table['table'] }}</strong>

                        <span>
                            — Table structure
                        </span>
                    </div>


                    <div class="table-scroll">

                        <table class="structure-table">

                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Collation</th>
                                    <th>Attributes</th>
                                    <th>Null</th>
                                    <th>Default</th>
                                    <th>Comments</th>
                                    <th>Extra</th>
                                </tr>
                            </thead>


                            <tbody>

                                @foreach ($table['columns'] as $column)

                                    <tr>

                                        {{-- # --}}
                                        <td class="number">
                                            {{ $column->ORDINAL_POSITION }}
                                        </td>


                                        {{-- Name --}}
                                        <td class="name">

                                            @if ($column->COLUMN_KEY === 'PRI')

                                                <span class="primary">
                                                    {{ $column->COLUMN_NAME }}
                                                    <small>Primary</small>
                                                </span>

                                            @elseif ($column->COLUMN_KEY === 'MUL')

                                                <span class="index">
                                                    {{ $column->COLUMN_NAME }}
                                                    <small>Index</small>
                                                </span>

                                            @elseif ($column->COLUMN_KEY === 'UNI')

                                                <span class="index">
                                                    {{ $column->COLUMN_NAME }}
                                                    <small>Unique</small>
                                                </span>

                                            @else

                                                {{ $column->COLUMN_NAME }}

                                            @endif

                                        </td>


                                        {{-- Type --}}
                                        <td class="type">
                                            {{ $column->COLUMN_TYPE }}
                                        </td>


                                        {{-- Collation --}}
                                        <td class="collation">

                                            @if ($column->COLLATION_NAME)
                                                {{ $column->COLLATION_NAME }}
                                            @else
                                                —
                                            @endif

                                        </td>


                                        {{-- Attributes --}}
                                        <td>
                                            —
                                        </td>


                                        {{-- Null --}}
                                        <td class="null">

                                            @if ($column->IS_NULLABLE === 'YES')

                                                <span class="null-yes">
                                                    Yes
                                                </span>

                                            @else

                                                <span class="null-no">
                                                    No
                                                </span>

                                            @endif

                                        </td>


                                        {{-- Default --}}
                                        <td class="default">

                                            @if (is_null($column->COLUMN_DEFAULT))

                                                <span style="color:#6c757d">
                                                    None
                                                </span>

                                            @else

                                                {{ $column->COLUMN_DEFAULT }}

                                            @endif

                                        </td>


                                        {{-- Comments --}}
                                        <td class="comment">

                                            @if ($column->COLUMN_COMMENT)
                                                {{ $column->COLUMN_COMMENT }}
                                            @else
                                                —
                                            @endif

                                        </td>


                                        {{-- Extra --}}
                                        <td class="extra">

                                            @if ($column->EXTRA)
                                                {{ $column->EXTRA }}
                                            @else
                                                —
                                            @endif

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>

            @empty

                <div class="empty">
                    No tables found in this database.
                </div>

            @endforelse

        </div>

    </div>

</body>

</html>