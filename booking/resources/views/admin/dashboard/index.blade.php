@include('admin.dashboard/eventlist')
@include('admin.dashboard/maintable')


<!-- <table class="table table-bordered">
    <thead>
        <tr>
            <th>City Name</th>
            <th>Total Bookings</th>
            <th>Pending</th>
            <th>Completed</th>
        </tr>
    </thead>
    <tbody>
        @foreach($cities as $city)
            <tr>
                <td>{{ $city->city }}</td>
                <td>{{ $city->total_bookings }}</td>
                <td>{{ $city->pending }}</td>
                <td>{{ $city->completed }}</td>
            </tr>
        @endforeach
    </tbody>
</table> -->