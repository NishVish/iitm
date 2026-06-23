<!DOCTYPE html>
<html>

<head>
    <title>Mongo Companies</title>
</head>

<body>

    <h2>Add Company</h2>

    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    <form method="POST" action="{{ url('/mongo/store') }}">
        @csrf

        <input type="text" name="company_name" placeholder="Company Name" required>
        <br><br>

        <input type="text" name="address" placeholder="Address" required>
        <br><br>

        <input type="text" name="contact_name" placeholder="Contact Name" required>
        <br><br>

        <input type="text" name="designation" placeholder="Designation" required>
        <br><br>

        <input type="number" name="priority" placeholder="Priority (1 = decision maker)" required>
        <br><br>

        <input type="text" name="mobiles" placeholder="Mobiles (comma separated)" required>
        <br><br>

        <input type="text" name="emails" placeholder="Emails (comma separated)" required>
        <br><br>

        <button type="submit">Save</button>
    </form>

    <hr>

    <h2>Company List</h2>

    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>Company</th>
            <th>Address</th>
            <th>Contacts</th>
            <th>Created</th>
        </tr>

        @foreach($data as $company)
            <tr>
                <td>{{ $company['_id'] }}</td>
                <td>{{ $company['company_name'] }}</td>
                <td>{{ $company['address'] }}</td>
                <td>
                    @foreach($company['contacts'] as $c)
                        <div>
                            <b>{{ $c['name'] }}</b> ({{ $c['designation'] }})
                            <br>
                            Priority: {{ $c['priority'] }}
                            <br>
                            Decision Maker: {{ $c['is_decision_maker'] ? 'Yes' : 'No' }}
                            <br>
                            Mobiles: {{ implode(', ', $c['mobiles']) }}
                            <br>
                            Emails: {{ implode(', ', $c['emails']) }}
                            <hr>
                        </div>
                    @endforeach
                </td>
                <td>{{ $company['created_at'] }}</td>
            </tr>
        @endforeach
    </table>

</body>

</html>