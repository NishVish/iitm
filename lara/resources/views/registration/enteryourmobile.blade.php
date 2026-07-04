@include('registration.header')
<h2 style="text-align:center;">Exhibitor Registration</h2>

<div class="mb-3">
    <label for="key" class="form-label">Enter Mobile / Key</label>

    <input type="text" id="key" class="form-control" placeholder="Enter mobile number or key">
</div>

<button type="button" class="btn btn-primary" onclick="goSearch()">
    Search
</button>

<script>
    function goSearch() {
        let value = document.getElementById('key').value.trim();

        if (!value) return;

        let url = "{{ url('delegatesInfobymobile') }}/" + encodeURIComponent(value);

        window.location.href = url;
    }
</script>