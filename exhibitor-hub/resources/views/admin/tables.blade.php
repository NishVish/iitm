<div class="container mt-4">
    <h2 class="mb-4">Database Schema</h2>

    @php
        $groupedSchema = collect($schema)->groupBy('TABLE_NAME');
    @endphp

    @foreach($groupedSchema as $tableName => $columns)
        <div class="card mb-4">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">{{ $tableName }}</h5>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Column</th>
                                <th>Type</th>
                                <th>Data Type</th>
                                <th>Length</th>
                                <th>Nullable</th>
                                <th>Default</th>
                                <th>Key</th>
                                <th>Extra</th>
                                <th>Comment</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($columns as $column)
                                <tr>
                                    <td>{{ $column->ORDINAL_POSITION }}</td>
                                    <td><strong>{{ $column->COLUMN_NAME }}</strong></td>
                                    <td>{{ $column->COLUMN_TYPE }}</td>
                                    <td>{{ $column->DATA_TYPE }}</td>
                                    <td>{{ $column->CHARACTER_MAXIMUM_LENGTH ?? '-' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $column->IS_NULLABLE == 'YES' ? 'success' : 'danger' }}">
                                            {{ $column->IS_NULLABLE }}
                                        </span>
                                    </td>
                                    <td>{{ $column->COLUMN_DEFAULT ?? '-' }}</td>
                                    <td>{{ $column->COLUMN_KEY ?: '-' }}</td>
                                    <td>{{ $column->EXTRA ?: '-' }}</td>
                                    <td>{{ $column->COLUMN_COMMENT ?: '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endforeach
</div>
<h2>All Bookings</h2>


@if(session('success'))
    <p style="color:green;">
        {{ session('success') }}
    </p>
@endif


</table>
<div class="card mt-4">
    <div class="card-header">
        <h5 class="mb-0">Database Tables</h5>
    </div>
    <div class="card-body">
        @if(!empty($tables) && count($tables))
            <div class="row">
                @foreach($tables as $table)
                    <div class="col-md-4 mb-2">
                        <div class="border rounded p-2 bg-light">
                            {{ $table }}
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-muted mb-0">No tables found.</p>
        @endif
    </div>
</div>