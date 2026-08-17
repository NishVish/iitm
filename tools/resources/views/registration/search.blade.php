<!DOCTYPE html>
<html>

<head>
    <title>Exhibitor Search</title>
</head>

<body>

    <h2>Exhibitor Search</h2>

    <input type="text" id="search" placeholder="Search here..." />

    <br><br>

    <table border="1" width="100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Company</th>
                <th>City</th>
                <th>Mobile</th>
                <th>Email</th>
            </tr>
        </thead>

        <tbody id="results">
        </tbody>
    </table>

    <script>
        const search = document.getElementById('search');
        const results = document.getElementById('results');

        fetchData('');

        search.addEventListener('keyup', function () {
            fetchData(this.value);
        });

        function fetchData(keyword) {
            fetch("{{ url('/exhibitor/search') }}/" + encodeURIComponent(keyword))
                .then(response => response.json())
                .then(data => {
                    let rows = '';

                    if (data.length > 0) {
                        data.forEach(item => {
                            rows += `
                                <tr>
                                    <td>${item.id}</td>
                                    <td>${item.name ?? ''}</td>
                                    <td>${item.company_name ?? ''}</td>
                                    <td>${item.city ?? ''}</td>
                                    <td>${item.mobile ?? ''}</td>
                                    <td>${item.email ?? ''}</td>
                                </tr>
                            `;
                        });
                    } else {
                        rows = `<tr><td colspan="6">No data found</td></tr>`;
                    }

                    results.innerHTML = rows;
                })
                .catch(error => {
                    console.error(error);
                });
        }
    </script>

</body>

</html>