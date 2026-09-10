<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="brand-wrapper">
            <img src="{{ asset('icon/trophy.svg') }}" alt="Logo" class="brand-icon">
            <span class="brand-text"><span>Liga</span> Perkasa</span>
        </div>
    </div>

    <ul class="sidebar-menu">
        @auth
            @if(Auth::user()->isSuperAdmin())
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
                       href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-chart-pie me-2"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.*') && !request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
                       href="{{ route('admin.index') }}">
                        <i class="fas fa-users-cog me-2"></i>
                        <span>Data Panitia</span>
                    </a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('juri_lomba.*') ? 'active' : '' }}" 
                        href="{{ route('juri_lomba.index') }}">
                        <i class="fas fa-user-tag me-2"></i> Penugasan Juri
                    </a>
                </li> -->
            @elseif(Auth::user()->isPanitia())
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" 
                       href="{{ route('dashboard') }}">
                        <i class="fas fa-chart-pie me-2"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('panitia.*') ? 'active' : '' }}" 
                       href="{{ route('panitia.index') }}">
                        <i class="fas fa-users me-2"></i>
                        <span>Data Tim</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('lomba.index') ? 'active' : '' }}" 
                        href="{{ route('lomba.index') }}">
                        <i class="fas fa-trophy me-2"></i> Daftar Lomba
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('nilai.index') ? 'active' : '' }}" 
                        href="{{ route('nilai.index') }}">
                        <i class="fas fa-clipboard-list me-2"></i> Penilaian Lomba
                    </a>
                </li>
            @endif

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('dashboard.ranking') ? 'active' : '' }}" 
                href="{{ route('dashboard.ranking') }}">
                    <i class="fas fa-chart-line me-2"></i>
                    <span>Ranking</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}" 
                   href="{{ route('profile.index') }}">
                    <i class="fas fa-user-circle me-2"></i>
                    <span>Profile</span>
                </a>
            </li>
        @endauth
    </ul>

    <div class="sidebar-footer">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">
                <img src="{{ asset('icon/logout.svg') }}" alt="" class="logout-icon">
                <span class="logout-text">Logout</span>
            </button>
        </form>
    </div>
</div>