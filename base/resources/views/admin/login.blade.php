<form action="{{ url('admin/verify') }}" method="post">
    @csrf
    <input type="text" name="id" placeholder="Enter your id">
    <button type="submit">Verify</button>
</form>