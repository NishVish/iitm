<form id="companySearchForm" method="POST" action="{{ route('search') }}">
    @csrf

    <input type="text" name="keyword" id="keyword">
    <button type="submit">Search</button>
</form>