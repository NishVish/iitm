@include('backend.header')

@php
    $lastsegment = request()->segment(1);
@endphp

<h1>{{ $lastsegment }}</h1>
<!-- <iframe src="{{ url('otherregistration') }}" frameborder="0"></iframe> -->
@include('backend.data.otherregistration')
<button onclick="loadData('exhibitor')">Main</button>
<button onclick="loadData('visitor')">Leads</button>
<button onclick="loadData('online_registration')">Online Registration</button>

<hr>

<!-- OUTPUT AREA -->
<div id="output">
    Loading...
</div>

<script>
    function loadData(type) {
        document.getElementById('output').innerHTML = "Loading...";

        fetch("{{ url('getcompanybyentrytype') }}/" + type)
            .then(response => response.text())
            .then(data => {
                document.getElementById('output').innerHTML = data;
            })
            .catch(error => {
                document.getElementById('output').innerHTML = "Error loading data";
            });
    }

    // default load
    loadData('exhibitor');
</script>