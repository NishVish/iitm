<?php
// Sort data
arsort($stateCounts);
arsort($cityCounts);
arsort($sourceCounts);
arsort($categoryCounts);
arsort($commentCounts);

// Totals
$totalUniqueStates     = count($stateCounts);
$totalUniqueCities     = count($cityCounts);
$totalUniqueSources    = count($sourceCounts);
$totalUniqueCategories = count($categoryCounts);
$totalUniqueComments   = count($commentCounts);

$uri = service('uri');
$third = 'none';
?>

<style>
/* PAGE WRAPPER */

.master-wrapper{
font-family:'Inter',system-ui,-apple-system,sans-serif;
background:var(--body-color);
padding:20px;
border-radius:12px;
}

/* SUMMARY CARDS */

.summary-cards{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(160px,1fr));
gap:18px;
margin-bottom:25px;
}

.card{
background:var(--nav-color);
color:var(--text-color);
padding:20px;
border-radius:10px;
text-align:center;
box-shadow:0 4px 10px rgba(0,0,0,.08);
}

.card-title{
font-size:12px;
text-transform:uppercase;
letter-spacing:1px;
color:var(--text-color);
}

.card-value{
font-size:30px;
font-weight:800;
margin-top:6px;
}

/* GRID LAYOUT */

.dashboard-grid{
display:grid;
grid-template-columns:repeat(5,1fr);
gap:15px;
}

/* LIST PANEL */

.list-box{
background:var(--text-color);
border-radius:10px;
display:flex;
flex-direction:column;
overflow:hidden;
box-shadow:0 2px 8px rgba(0,0,0,.05);
}

/* PANEL HEADER */

.list-box h3{
background:var(--nav-color);
color:var(--text-color);
padding:12px;
margin:0;
font-size:14px;
letter-spacing:.5px;
}

/* SCROLL AREA */

.scroll{
max-height:700px;
overflow-y:auto;
overflow-x:hidden;
}

.scroll::-webkit-scrollbar{
width:6px;
}

.scroll::-webkit-scrollbar-thumb{
background:var(--button-color);
border-radius:10px;
}

/* LIST ITEMS */

.list-item{
display:flex;
justify-content:space-between;
align-items:center;
padding:10px 12px;
text-decoration:none;
color:var(--nav-color);
border-bottom:1px solid var(--body-color);
font-size:14px;
transition:background .2s ease;
}

.list-item:hover{
background:var(--body-color-dim);
}

/* COUNT BADGE */

.list-item span{
font-weight:700;
background:var(--button-color);
color:var(--text-color);
padding:2px 8px;
border-radius:6px;
font-size:12px;
}

/* COMMENT TEXT TRUNCATION */

.truncate{
max-width:160px;
overflow:hidden;
text-overflow:ellipsis;
white-space:nowrap;
}

/* RESPONSIVE */

@media(max-width:1200px){
.dashboard-grid{
grid-template-columns:repeat(3,1fr);
}
}

@media(max-width:800px){
.dashboard-grid{
grid-template-columns:repeat(2,1fr);
}
}

@media(max-width:500px){
.dashboard-grid{
grid-template-columns:1fr;
}
}

</style>
<div>
    Entry TYpe
</div>
<div class="master-wrapper">

<!-- SUMMARY -->
<div class="summary-cards">

<div class="card">
<div class="card-title">States</div>
<div class="card-value"><?= $totalUniqueStates ?></div>
</div>

<div class="card">
<div class="card-title">Cities</div>
<div class="card-value"><?= $totalUniqueCities ?></div>
</div>

<div class="card">
<div class="card-title">Sources</div>
<div class="card-value"><?= $totalUniqueSources ?></div>
</div>

<div class="card">
<div class="card-title">Categories</div>
<div class="card-value"><?= $totalUniqueCategories ?></div>
</div>

<div class="card">
<div class="card-title">Comments</div>
<div class="card-value"><?= $totalUniqueComments ?></div>
</div>

</div>


<!-- GRID -->

<div class="dashboard-grid">

<!-- STATES -->
<div class="list-box">
<!-- <h3>States</h3> -->
<div class="scroll">
<?php foreach ($stateCounts as $name => $count): ?>
<a class="list-item" href="<?= base_url().'company/'.$third.'/state/'.urlencode(str_replace(' ','-',$name)) ?>">
<?= htmlspecialchars($name) ?>
<span><?= $count ?></span>
</a>
<?php endforeach; ?>
</div>
</div>


<!-- CITIES -->
<div class="list-box">
<!-- <h3>Cities</h3> -->
<div class="scroll">
<?php foreach ($cityCounts as $name => $count): ?>
<a class="list-item" href="<?= base_url().'company/'.$third.'/city/'.urlencode(str_replace(' ','-',$name)) ?>">
<?= htmlspecialchars($name) ?>
<span><?= $count ?></span>
</a>
<?php endforeach; ?>
</div>
</div>


<!-- SOURCES -->
<div class="list-box">
<!-- <h3>Sources</h3> -->
<div class="scroll">
<?php foreach ($sourceCounts as $name => $count): ?>
<a class="list-item" href="<?= base_url().'company/'.$third.'/source/'.urlencode(str_replace(' ','-',$name)) ?>">
<?= htmlspecialchars($name) ?>
<span><?= $count ?></span>
</a>
<?php endforeach; ?>
</div>
</div>


<!-- CATEGORIES -->
<div class="list-box">
<!-- <h3>Categories</h3> -->
<div class="scroll">
<?php foreach ($categoryCounts as $name => $count): ?>
<a class="list-item" href="<?= base_url().'company/'.$third.'/category/'.urlencode(str_replace(' ','-',$name)) ?>">
<?= htmlspecialchars($name) ?>
<span><?= $count ?></span>
</a>
<?php endforeach; ?>
</div>
</div>


<!-- COMMENTS -->
<div class="list-box">
<!-- <h3>Comments</h3> -->
<div class="scroll">
<?php foreach ($commentCounts as $name => $count): ?>
<a class="list-item" href="<?= base_url().'company/'.$third.'/last_comments/'.urlencode(str_replace(' ','-',$name)) ?>">
<div class="truncate" title="<?= htmlspecialchars($name) ?>">
<?= htmlspecialchars($name) ?>
</div>
<span><?= $count ?></span>
</a>
<?php endforeach; ?>
</div>
</div>

</div>

</div>


<?php

// limit to top 10 for charts
$stateTop = array_slice($stateCounts,0,10,true);
$cityTop = array_slice($cityCounts,0,10,true);
$sourceTop = array_slice($sourceCounts,0,10,true);
$categoryTop = array_slice($categoryCounts,0,10,true);

?>

<style>

.chart-grid{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(350px,1fr));
gap:20px;
margin-top:20px;
}

.chart-box{
background:var(--text-color);
border-radius:12px;
padding:20px;
box-shadow:0 2px 8px rgba(0,0,0,.06);
}

.chart-title{
font-size:14px;
font-weight:700;
margin-bottom:10px;
color:var(--nav-color);
}

canvas{
max-height:320px;
}

</style>

<div class="chart-grid">

<div class="chart-box">
<div class="chart-title">Top States</div>
<canvas id="stateChart"></canvas>
</div>

<div class="chart-box">
<div class="chart-title">Top Cities</div>
<canvas id="cityChart"></canvas>
</div>

<div class="chart-box">
<div class="chart-title">Sources</div>
<canvas id="sourceChart"></canvas>
</div>

<div class="chart-box">
<div class="chart-title">Categories</div>
<canvas id="categoryChart"></canvas>
</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

function createBarChart(id,labels,data){

new Chart(document.getElementById(id),{

type:'bar',

data:{
labels:labels,
datasets:[{
data:data,
backgroundColor:getComputedStyle(document.documentElement)
.getPropertyValue('--nav-color'),
borderRadius:6
}]
},

options:{
plugins:{
legend:{display:false}
},

scales:{
x:{
ticks:{color:'#555'}
},
y:{
beginAtZero:true,
ticks:{color:'#555'}
}
}
}

});

}

createBarChart(
'stateChart',
<?= json_encode(array_keys($stateTop)) ?>,
<?= json_encode(array_values($stateTop)) ?>
);

createBarChart(
'cityChart',
<?= json_encode(array_keys($cityTop)) ?>,
<?= json_encode(array_values($cityTop)) ?>
);

createBarChart(
'sourceChart',
<?= json_encode(array_keys($sourceTop)) ?>,
<?= json_encode(array_values($sourceTop)) ?>
);

createBarChart(
'categoryChart',
<?= json_encode(array_keys($categoryTop)) ?>,
<?= json_encode(array_values($categoryTop)) ?>
);

</script>

