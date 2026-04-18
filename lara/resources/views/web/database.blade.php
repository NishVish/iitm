<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Search Company Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">
        <h3>Search Company Data</h3>

        <div class="row mb-3">
            <div class="col-md-6">
                <input type="text" id="mobile" class="form-control" placeholder="Enter Mobile Number"
                    value="7909075195">
            </div>
            <div class="col-md-3">
                <button class="btn btn-primary" onclick="searchData()">Search</button>
            </div>
        </div>

        <hr>

        <h4>Latest Record</h4>
        <div id="latestData" class="card p-3 mb-4"></div>

        <h4>All Matching Records</h4>
        <div id="allData"></div>
    </div>

    <script>
        function searchData() {
            let mobile = document.getElementById('mobile').value;

            if (!mobile) {
                alert('Enter mobile number');
                return;
            }

            document.getElementById('latestData').innerHTML = "Loading...";
            document.getElementById('allData').innerHTML = "Loading...";
            fetch(`{{ url('/api/getLatestCompanyData/${mobile}') }}`)
                .then(res => res.json())
                .then(res => {
                    let box = document.getElementById('latestData');

                    if (res.status && res.data) {
                        let html = '';

                        Object.keys(res.data).forEach(key => {
                            html += `<p><b>${key}:</b> ${res.data[key] ?? ''}</p>`;
                        });

                        box.innerHTML = html;
                    } else {
                        box.innerHTML = `<p>No data found</p>`;
                    }
                })
                .catch(() => {
                    document.getElementById('latestData').innerHTML = `<p>Error loading data</p>`;
                });

            fetch(`{{ url('/api/getAllCompanyData/${mobile}') }}`)
                .then(res => res.json())
                .then(res => {
                    let container = document.getElementById('allData');
                    container.innerHTML = '';

                    if (res.status && res.data.length > 0) {

                        res.data.forEach(item => {
                            let html = '';

                            Object.keys(item).forEach(key => {
                                html += `<p><b>${key}:</b> ${item[key] ?? ''}</p>`;
                            });

                            container.innerHTML += `
                    <div class="card p-3 mb-2">
                        ${html}
                    </div>
                `;
                        });

                    } else {
                        container.innerHTML = `<p>No records found</p>`;
                    }
                })
                .catch(() => {
                    document.getElementById('allData').innerHTML = `<p>Error loading data</p>`;
                });
        }
    </script>

</body>

</html>