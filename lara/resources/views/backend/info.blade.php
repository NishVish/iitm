<h2>System Administration Dashboard</h2>
@php
    $user = session('user')[0] ?? null;

    $name = $user->name ?? null;
    $mobile = $user->phone ?? null;
    $email = $user->email ?? null;
@endphp
<div class="box">
    @if(!session()->has('user'))
        <span class="session-badge badge-error">Status: ❌ No Active Session</span>
        <p>Please authenticate to access administrator tools.</p>
    @else
        <span class="session-badge badge-success">Status: ✅ Operator Authenticated</span>
        <p><strong>Current Operator:</strong> {{ session('user') }}</p>
    @endif
    @php
        $salesPerson = session('user.name');

    @endphp
</div>

<div class="box">
    <h3>Operator Session Trace</h3>
    @php $sessionData = session()->all(); @endphp
    <pre>{{ print_r($sessionData, true) }}</pre>
</div>