@include('registration.header')
<h2>Exhibitor Registration</h2>


@php
    $lastsegment = basename($_SERVER['REQUEST_URI']);
    $secondlastSegment = basename(dirname($_SERVER['REQUEST_URI']));
    if (!$secondlastSegment) {
        $secondlastSegment = "spot";
        $lastsegment = "exhibitor";
    }


@endphp
@include('registration.formparameter')
</div>


</body>

</html>