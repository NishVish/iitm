<nav class="bottom-nav">
    <a href="<?= base_url('home') ?>" class="nav-item <?= ($segment ?? '') === 'home' ? 'active' : '' ?>">
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
    <a href="<?= base_url('profile') ?>" class="nav-item <?= ($segment ?? '') === 'profile' ? 'active' : '' ?>">
        <i class="material-icons-round">account_circle</i>
        <span>Profile</span>
    </a>
</nav>