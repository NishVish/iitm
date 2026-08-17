Entyer YOur Id


<form action="{{ url('auth/verify') }}" method="post">
    @csrf
    <input type="text" name="id" placeholder="Enter your id">
    <button type="submit">Verify</button>
</form>