<nav class="navbar">
    <div class="navbar-container">
        <div class="navbar-left">
            <button class="navbar-toggle" id="sidebarToggle" aria-label="Toggle Sidebar">
                <span class="toggle-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </button>

            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <span class="brand-name-nav">Liga Perkasa</span>
                <span class="brand-tagline">| Dashboard</span>
            </a>
        </div>

        <div class="navbar-right">
            <div class="dropdown">
                <button class="user-dropdown" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    @php
                        $user = Auth::user();
                    @endphp
                    @if($user && $user->foto_profil && file_exists(public_path('uploads/profil/' . $user->foto_profil)))
                        <img src="{{ asset('uploads/profil/' . $user->foto_profil) }}" alt="{{ $user->name }}" class="user-avatar">
                    @else
                        <div class="user-avatar-initial" style="background: {{ $user->avatar_color ?? '#667eea' }};">
                            {{ $user->initials ?? strtoupper(substr($user->name, 0, 2)) }}
                        </div>
                    @endif
                    <span class="user-name">{{ Auth::user()->name ?? 'Admin' }}</span>
                    <i class="fas fa-chevron-down dropdown-arrow"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    <li>
                        <a class="dropdown-item" href="{{ route('profile.index') }}">
                            <i class="fas fa-user-circle"></i> Profile
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#">
                            <i class="fas fa-cog"></i> Settings
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>