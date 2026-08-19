<div class="sidebar" id="sidebar">
    <!-- Header Sidebar -->
    <div class="sidebar-header">
        <div class="brand-wrapper">
            <img src="{{ asset('icon/youtube.svg') }}" alt="Logo" class="brand-icon">
            <span class="brand-text"><span>Liga</span> Perkasa</span>
        </div>
        <div class="brand-ilustration">
            <img src="{{ asset('icon/ilustrator.png') }}" alt="Ilustration">
        </div>
    </div>

    <!-- Menu Sidebar -->
    <div class="sidebar-menu">
        @auth
            @if(Auth::user()->isPanitia())
                <a href="{{ route('dashboard') }}" class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <div class="menu-link">
                        <img src="{{ asset('icon/dashboard.svg') }}" alt="" class="menu-icon">
                        <span class="menu-text">Dashboard</span>
                    </div>
                </a>
                <a href="#" class="menu-item">
                    <div class="menu-link">
                        <img src="{{ asset('icon/analytic.svg') }}" alt="" class="menu-icon">
                        <span class="menu-text">Analytic</span>
                    </div>
                </a>

                <a href="#" class="menu-item">
                    <div class="menu-link">
                        <img src="{{ asset('icon/category.svg') }}" alt="" class="menu-icon">
                        <span class="menu-text">Category</span>
                    </div>
                </a>

                <a href="{{ route('panitia.index') }}" class="menu-item {{ request()->routeIs('panitia.*') ? 'active' : '' }}">
                    <div class="menu-link">
                        <img src="{{ asset('icon/team.svg') }}" alt="" class="menu-icon">
                        <span class="menu-text">Peserta Lomba</span>
                    </div>
                </a>

                <a href="{{ route('lomba.index') }}" class="menu-item {{ request()->routeIs('lomba.*') ? 'active' : '' }}">
                    <div class="menu-link">
                        <img src="{{ asset('icon/event.svg') }}" alt="" class="menu-icon">
                        <span class="menu-text">Daftar Lomba</span>
                    </div>
                </a>

                <a href="#" class="menu-item">
                    <div class="menu-link">
                        <img src="{{ asset('icon/explore.svg') }}" alt="" class="menu-icon">
                        <span class="menu-text">Explore</span>
                    </div>
                </a>

            @endif
        @endauth
        
        @auth
            @if(Auth::user()->isSuperAdmin())
                <a class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                    <div class="menu-link">
                        <img src="{{ asset('icon/dashboard.svg') }}" alt="" class="menu-icon">
                        <span class="menu-text">Dashboard Admin</span>
                    </div>
                </a>
                <a class="menu-item {{ request()->routeIs('admin.index') ? 'active' : '' }}" href="{{ route('admin.index') }}">
                    <div class="menu-link">
                        <img src="{{ asset('icon/dashboard.svg') }}" alt="" class="menu-icon">
                        <span class="menu-text">Data Panitia</span>
                    </div>
                </a>
            @endif
        @endauth
        
        
    </div>

    <!-- Logout -->
    <!-- <div class="sidebar-footer">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">
                <img src="{{ asset('icon/logout.svg') }}" alt="" class="logout-icon">
                <span class="logout-text">Logout</span>
            </button>
        </form>
    </div> -->
</div>