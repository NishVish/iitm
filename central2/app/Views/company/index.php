<!-- <!DOCTYPE html>
<html>
<head>
    <title>All Companies</title>
    <style>
        table {border-collapse: collapse; width: 90%;}
        th, td {border: 1px solid #ccc; padding: 5px;}
        .btn {padding: 5px 10px; margin: 2px; cursor: pointer; background: #f0f0f0; border: 1px solid #999;}
        .btn.selected {background: #007bff; color: #fff;}
    </style>
</head>
<body> -->
<?= view('header') ?>  <!-- loads app/Views/header.php -->

<h1>All Companies</h1>

<h3>Filter by State</h3>
<div id="states">
    <button class="btn state-btn" data-state="">All</button>
    <?php foreach($states as $s): ?>
        <button class="btn state-btn" data-state="<?= esc($s['state']) ?>">
            <?= esc($s['state']) ?>
        </button>
    <?php endforeach; ?>
</div>


<h3>Filter by City</h3>
<div id="cities">
    <button class="btn city-btn" data-city="">All</button>
</div>

<h3>Companies</h3>
<table id="company-table" border="1" cellpadding="5">
    <thead>
        <tr>
            <th>Company Name</th>
            <th>Category</th>
            <th>City</th>
            <th>State</th>
            <th>Contacts</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($companies as $c): ?>
            <tr>
                <td>
                    <a href="<?= site_url('company/details/'.$c['company_id']) ?>">
                        <?= esc($c['company_name']) ?>
                    </a>
                </td>
                <td><?= esc($c['category']) ?></td>
                <td><?= esc($c['city']) ?></td>
                <td><?= esc($c['state']) ?></td>
                <td style="white-space: pre-line;">
                    <?= esc($c['contacts'] ?? 'No contacts') ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>



<script>
let selectedState = '';
let selectedCity = '';

// State buttons
document.querySelectorAll('.state-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        selectedState = this.dataset.state;
        selectedCity = '';

        document.querySelectorAll('.state-btn').forEach(b => b.classList.remove('selected'));
        this.classList.add('selected');

        if(selectedState){
            fetchCities(selectedState);
        } else {
            document.getElementById('cities').innerHTML = `<button class="btn city-btn" data-city="">All</button>`;
        }

        fetchCompanies(selectedState, selectedCity);
    });
});

function fetchCities(state){
    fetch('<?= site_url("company/getCities") ?>', {
        method:'POST',
        headers:{'Content-Type':'application/x-www-form-urlencoded'},
        body:'state='+encodeURIComponent(state)
    })
    .then(res=>res.json())
    .then(data=>{
        let html = `<button class="btn city-btn" data-city="">All</button>`; 
        data.forEach(c=>{
            let cityName = c.city?.trim() ?? '';
            html += `<button class="btn city-btn" data-city="${cityName}">${cityName}</button>`;
        });
        document.getElementById('cities').innerHTML = html;

        document.querySelectorAll('.city-btn').forEach(btn=>{
            btn.addEventListener('click', function(){
                selectedCity = this.dataset.city;
                document.querySelectorAll('.city-btn').forEach(b=>b.classList.remove('selected'));
                this.classList.add('selected');
                fetchCompanies(selectedState, selectedCity);
            });
        });
    });
}

function fetchCompanies(state, city) {
    fetch('<?= site_url("company/filterCompanies") ?>', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'state=' + encodeURIComponent(state) + '&city=' + encodeURIComponent(city)
    })
    .then(res => res.json())
    .then(data => {
        let html = '';
        data.forEach(c => {
            html += `<tr>
                <td><a href="<?= site_url('company/details') ?>/${c.company_id}" target="_blank">${c.company_name}</a></td>
                <td>${c.category ?? ''}</td>
                <td>${c.city ?? ''}</td>
                <td>${c.state ?? ''}</td>
                <td style="white-space: pre-line;">${c.contacts ?? 'No contacts'}</td>
            </tr>`;
        });
        document.querySelector('#company-table tbody').innerHTML = html;
    })
    .catch(err => console.error('Failed to fetch companies:', err));
}






</script>
</body>
</html>
