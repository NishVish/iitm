@include('registration.header')

<h2 style="text-align:center;">Exhibitor Registration Complete</h2>


@include('registration.delegatestable')

@php
    $shareLink = url('delegates/' . $data[0]->identifierkey);
@endphp

@include('registration.sharelink')
@php
    $lastsegment = basename($_SERVER['REQUEST_URI']);
    $secondlastSegment = basename(dirname($_SERVER['REQUEST_URI']));
    if (!$secondlastSegment) {
        $secondlastSegment = "spot";
        $lastsegment = "exhibitor";
    }


@endphp
@include('registration.formparameter')