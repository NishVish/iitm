@include('web.registration.formheader')



<form action="{{ route('registration.submit') }}" method="POST">
    @csrf
    <input type="hidden" name="event_id" value="{{ $eventinfo->event_id }}">
    @include('web.registration.personalfields')



    <div class="form-card" id="step3">
        @include('web.registration.companydetails')

        <div class="d-flex justify-content-end mt-5">
            <button type="button" class="btn-back" onclick="goToStep(2)">← Back</button>
            <button type="submit" class="btn-submit">Submit Registration ✓</button>
        </div>
    </div>

</form>
</div>

<script>
    function goToStep(num) {
        document.querySelectorAll('.form-card').forEach(c => c.classList.remove('active'));
        document.getElementById('step' + num).classList.add('active');

        if (num === 3) {
            document.getElementById('node2').classList.replace('active', 'completed');
            document.getElementById('node2').querySelector('.circle').innerText = '✓';
            document.getElementById('line2').classList.add('filled');
            document.getElementById('node3').classList.add('active');
        } else {
            document.getElementById('node2').classList.replace('completed', 'active');
            document.getElementById('node2').querySelector('.circle').innerText = '02';
            document.getElementById('line2').classList.remove('filled');
            document.getElementById('node3').classList.remove('active');
        }
        window.scrollTo(0, 0);
    }
</script>
</body>

</html>