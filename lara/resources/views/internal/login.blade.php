<form method="POST" action="{{ route('internal.login.submit') }}">
    @csrf

    <input type="password" name="pin" placeholder="Enter PIN" required>

    <button type="submit">Login</button>

    @if(session('error'))
        <p style="color:red;">{{ session('error') }}</p>
    @endif
</form>