
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

