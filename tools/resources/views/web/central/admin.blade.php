<table border="1">
    <tr>
        <th>Company</th>
        <th>City</th>
        <th>Phone</th>
        <th>Email</th>
    </tr>

    @foreach($data as $row)
        <tr>
            <td>{{ $row['company'] }}</td>
            <td>{{ $row['city'] }}</td>
            <td>{{ $row['phone'] }}</td>
            <td>{{ $row['email'] }}</td>
        </tr>
    @endforeach
</table>