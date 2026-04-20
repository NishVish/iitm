<h2>Mail Test</h2>

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

<form method="POST" action="{{ url('/mail-test/send') }}">
    @csrf

    <input type="email" name="email" placeholder="Enter email" required><br><br>

    <textarea name="body" placeholder="<h1>Hello</h1>" rows="10" cols="50" required></textarea><br><br>

    <button type="submit">Send</button>
</form>