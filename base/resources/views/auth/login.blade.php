Entyer YOur Id



@php $lastsegmet = Request::segment(1);

@endphp

@if($lastsegmet == 'sales')
    <form action="{{ url('auth/verify') }}" method="post">
        @csrf
        <input type="text" name="id" placeholder="Enter your id">
        <button type="submit">Verify</button>
</form>@else

    @include('auth.exhibitorlogin')
@endif