@php
    // Get the current segment from the URL
    $segment = request()->segment(2); 
@endphp

<nav class="bottom-nav">
    <a href="{{ url('home') }}" 
       class="nav-item {{ in_array($segment, ['home', 'calendar', 'layout']) ? 'active' : '' }}">
        <i class="material-icons-round">dashboard</i>
        <span>Home</span>
    </a>

    <a href="#" class="nav-item">
        <i class="material-icons-round">explore</i>
        <span>Cities</span>
    </a>

    <a href="#" class="nav-item">
        <i class="material-icons-round">forum</i>
        <span>Chat</span>
    </a>

    <a href="{{ url('profile') }}" 
       class="nav-item {{ ($segment ?? '') === 'profile' ? 'active' : '' }}">
        <i class="material-icons-round">account_circle</i>
        <span>Profile</span>
    </a>
</nav>