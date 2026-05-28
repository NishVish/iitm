@include('internal.header')

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

@include('internal.mail')
@include('internal.massmail')