<?= view('header') ?>

<div class="page-header">
    <div class="title-section">
        <h1>All Companies</h1>
    </div>

    <div class="action-section">
        <a href="<?= site_url('clear-matching') ?>" class="action-btn danger">Clear Matching</a>
        <a href="<?= site_url('clear-contacts') ?>" class="action-btn danger">Clear Contacts</a>
        <a href="<?= site_url('clear-companies') ?>" class="action-btn danger">Clear Companies</a>

        <a href="<?= site_url('crossvalidation/crossValidate') ?>" class="action-btn primary">
            Company Cross Validation
        </a>
    <a href="<?= site_url('company/dummy') ?>" class="action-btn primary">
insert Data        </a>

        <a href="<?= site_url('crossvalidation/crossValidateContact') ?>" class="action-btn primary">
            Contact Cross Validation
        </a>

        <a href="<?= site_url('crossvalidation/clear') ?>" class="action-btn warning">
            Clear Matches
        </a>

        <a href="<?= site_url('crossvalidation/clearcontact') ?>" class="action-btn warning">
            Clear Contact Matches
        </a>
    </div>
</div>
<style>
    /* Page Header */
.page-header {
    background: #ffffff;
    padding: 20px;
    border-radius: 12px;
    margin: 20px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.08);
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.page-header h1 {
    margin: 0;
    font-size: 26px;
}

/* Action Buttons */
.action-section {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.action-btn {
    padding: 8px 14px;
    border-radius: 8px;
    text-decoration: none;
    font-size: 13px;
    font-weight: 600;
    transition: all 0.3s ease;
    display: inline-block;
}

.action-btn.primary {
    background: #0066cc;
    color: #fff;
}

.action-btn.primary:hover {
    background: #004999;
}

.action-btn.danger {
    background: #c82333;
    color: #fff;
}

.action-btn.danger:hover {
    background: #a71d2a;
}

.action-btn.warning {
    background: #ff9800;
    color: #fff;
}

.action-btn.warning:hover {
    background: #e68900;
}

/* Filter Section */
.filter-section {
    background: #ffffff;
    padding: 20px;
    margin: 20px;
    border-radius: 12px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.08);
}

#states {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 10px;
}

.state-btn {
    padding: 6px 12px;
    border-radius: 20px;
    border: 1px solid #ccc;
    background: #f8f8f8;
    cursor: pointer;
    transition: 0.3s;
    font-size: 13px;
}

.state-btn:hover {
    background: #eaeaea;
}

.state-btn.active {
    background: #a82324;
    color: #fff;
    border-color: #a82324;
}
/* Company Table */
.company-table {
    width: 95%;
    margin: 20px auto;
    border-collapse: collapse;
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 6px 20px rgba(0,0,0,0.08);
}

.company-table th {
    background: #a82324;
    color: white;
    padding: 12px;
    text-align: left;
    font-size: 14px;
}

.company-table td {
    padding: 10px 12px;
    border-bottom: 1px solid #eee;
    font-size: 13px;
}

.company-table tr:hover {
    background: #f9f9f9;
    transition: 0.2s;
}

.company-table input[type="radio"] {
    transform: scale(1.2);
}

/* Compare Button */
#compareBtn {
    background: #0066cc;
    color: #fff;
    border: none;
    padding: 10px 18px;
    border-radius: 8px;
    cursor: pointer;
    margin: 15px 20px;
    font-weight: 600;
    transition: 0.3s;
}

#compareBtn:hover {
    background: #004999;
}

/* Modal */
#compareModal {
    border-radius: 12px;
    box-shadow: 0 15px 40px rgba(0,0,0,0.3);
    animation: fadeIn 0.3s ease;
}

#closeModal {
    background: #c82333;
    color: white;
    border: none;
    padding: 5px 10px;
    border-radius: 6px;
    cursor: pointer;
}

/* Selected buttons */
.state-btn.selected,
.city-btn.selected {
    background: #a82324 !important;
    color: #fff;
}


</style>

<div class="filter-section">
    <h3>Filter by State</h3>
    <div id="states">
        <button class="state-btn active" data-state="">All</button>
        <?php foreach($states as $s): ?>
            <button class="state-btn" data-state="<?= esc($s['state']) ?>">
                <?= esc($s['state']) ?>
            </button>
        <?php endforeach; ?>
    </div>
</div>



<h3>Filter by City</h3>
<div class="filter-section"
 id="cities">
    <button class="btn city-btn" data-city="">All</button>
</div>

<h3>Companies</h3>
<form id="compareForm">     <button type="button" id="compareBtn">Compare Selected</button>

<table id="company-table" class="company-table">
        <thead>
            <tr>
                <th>Main</th>
                <th>Compare</th>
                <th>Session</th>
                <th>Company Name</th>
                <th>Category</th>
                <th>City</th>
                <th>State</th>
                <th style="text-align:center"><span style="text-align:center"> Contact Detials</span></th>
                    
            </tr>
        </thead>
        <tbody>
            <?php foreach($companies as $c): ?>
<tr onclick="window.location='<?= site_url('company/details/'.$c['company_id']) ?>'" 
    style="cursor:pointer;">                    <td><input type="radio" name="main_id" value="<?= esc($c['company_id']) ?>"></td>
                    <td><input type="radio" name="compare_id" value="<?= esc($c['company_id']) ?>"></td>
                    <td><?= esc($c['session']) ?></td>
                    <td>
    <?= esc($c['company_name']) ?>

<style>
    .plain-link {
        color: inherit;       /* Keep the text color same as surrounding text */
        text-decoration: none; /* Remove underline */
        cursor: pointer;       /* Optional: keeps pointer cursor on hover */
    }
    .plain-link:hover {
        color: inherit;       /* Prevent color change on hover */
        text-decoration: none; /* Prevent underline on hover */
    }
</style>

                    </td>
                    <td><?= esc($c['category']) ?></td>
                    <td><?= esc($c['city']) ?></td>
                    <td><?= esc($c['state']) ?></td>
<td style="text-align:center; vertical-align:middle; 
           display:flex; justify-content:center; 
           align-items:center; flex-direction:column;">
<?php if (!empty($c['contacts'])): ?>

    <?php 
        $rows = explode("\n", trim($c['contacts']));
    ?>

<table class="table table-sm table-bordered text-center"
       style="font-size:13px; table-layout:fixed; width:100%;">
        <thead style="background:#f5f5f5;">
           
        </thead>
        <tbody>

        <?php foreach ($rows as $row): ?>
            <?php
                if (trim($row) === '') continue;

                // Break using "|"
                $parts = array_map('trim', explode('|', $row));

                // Extract Name + Designation
                preg_match('/^(.*?)\s*\((.*?)\)$/', $parts[0] ?? '', $matches);
                $name = $matches[1] ?? $parts[0];
                $designation = $matches[2] ?? '';

                // Extract Mobiles
                $mobiles = '';
                if (isset($parts[1])) {
                    $mobiles = str_replace('Mobiles:', '', $parts[1]);
                }

                // Extract Emails
                $emails = '';
                if (isset($parts[2])) {
                    $emails = str_replace('Emails:', '', $parts[2]);
                }
            ?>

            <tr>
    <td style="width:25%; word-wrap:break-word;"><?= esc(trim($name)) ?></td>
    <td style="width:25%; word-wrap:break-word;"><?= esc(trim($designation)) ?></td>
    <td style="width:25%; word-wrap:break-word;"><?= esc(trim($mobiles)) ?></td>
    <td style="width:25%; word-wrap:break-word;"><?= esc(trim($emails)) ?></td>
</tr>


        <?php endforeach; ?>

        </tbody>
    </table>

<?php else: ?>
    No contacts
<?php endif; ?>
</td>




                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <button type="button" id="compareBtn">Compare Selected</button>
</form>



<div id="modalBackdrop" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,.5); z-index:9998;"></div>

<div id="compareModal" style="display:none; position:fixed; top:50%; left:50%;
transform:translate(-50%,-50%); background:#fff; padding:20px; z-index:9999; max-width:90%; max-height:80%; overflow:auto;">
    <button id="closeModal" style="float:right;">X</button>
    <div id="compareContent"></div>
</div>

<button type="button" id="compareBtn">Compare Selected</button>


<script>
document.addEventListener('DOMContentLoaded', function () {

    document.getElementById('compareBtn').addEventListener('click', function () {

        const mainId = document.querySelector('input[name="main_id"]:checked');
        const compareId = document.querySelector('input[name="compare_id"]:checked');

        if (!mainId || !compareId) {
            alert('Please select both a Main and a Compare company.');
            return;
        }

        document.getElementById('compareContent').innerHTML = 'Loading...';

fetch('<?= site_url('company/compare_popup') ?>', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
        main_id: mainId.value,
        compare_id: compareId.value
    })
})
.then(res => res.text())
.then(html => {
    document.getElementById('compareContent').innerHTML = html;
});


        document.getElementById('compareModal').style.display = 'block';
        document.getElementById('modalBackdrop').style.display = 'block';
    });

    document.getElementById('closeModal').addEventListener('click', function () {
        document.getElementById('compareModal').style.display = 'none';
        document.getElementById('modalBackdrop').style.display = 'none';
    });

});
</script>


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
                <td><input type="radio" name="main_id" value="${c.company_id}"></td>
                <td><input type="radio" name="compare_id" value="${c.company_id}"></td>
                <td>${c.session ?? ''}</td>
                <td>
                    <a href="<?= site_url('company/details') ?>/${c.company_id}" target="_blank">
                        ${c.company_name}
                    </a>
                </td>
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