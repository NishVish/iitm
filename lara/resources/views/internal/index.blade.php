@include('internal.header')

@php
    $lastSegment = request()->segment(count(request()->segments()));
    $secondlastSegment = request()->segment(count(request()->segments()) - 1);
@endphp
@if($lastSegment === 'knowledge')


    Hello

@elseif($lastSegment === 'mail')
    <div class="row">
        {{-- Main Selection Buttons --}}
        <div class="col-md-12 mb-3">
            <button type="button" class="btn btn-primary" id="btnIndividual">
                Individual Mail
            </button>

            <button type="button" class="btn btn-success" id="btnMass">
                Mass Mail
            </button>
        </div>
    </div>

    {{-- ================= INDIVIDUAL MAIL SECTION ================= --}}
    @include('internal.mail')

    @include('internal.massmail')


@elseif($lastSegment === 'home')

    <div class="page-wrapper">

        <h1>Internal Dashboard</h1>

        <p>Welcome, {{ session('internal_name') }}</p>

    </div>

    <style>
        .page-wrapper {
            max-width: 600px;
            margin: 40px auto;
            font-family: Arial, sans-serif;
        }

        h1 {
            color: #aa2324;
            border-bottom: 2px solid #aa2324;
            padding-bottom: 10px;
        }
    </style>

@endif