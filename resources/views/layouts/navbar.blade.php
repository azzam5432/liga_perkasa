<nav class="navbar">
    <div class="navbar-container">
        <!-- Tombol Toggle Sidebar -->
        <button class="navbar-toggle" id="sidebarToggle" aria-label="Toggle Sidebar">
            <span class="toggle-icon">
                <span></span>
                <span></span>
                <span></span>
            </span>
        </button>

        <a class="navbar-brand" href="{{ route('dashboard') }}">
            <span class="brand-name">Liga Perkasa</span>
            <span class="brand-tagline">| Dashboard</span>
        </a>
        <!-- Profil Pengguna -->
        <div class="navbar-right">
            <div class="dropdown">
                <button class="user-dropdown" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="user-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <span class="user-name d-none d-md-inline">
                        {{ Auth::user()->name ?? 'Admin' }}
                    </span>
                    <i class="fas fa-chevron-down dropdown-arrow d-none d-md-inline"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0" aria-labelledby="userDropdown">
                    <li>
                        <a class="dropdown-item" href="{{ route('profile.index') }}">
                            <i class="fas fa-user-circle me-2"></i> Profile
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#">
                            <i class="fas fa-cog me-2"></i> Settings
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>