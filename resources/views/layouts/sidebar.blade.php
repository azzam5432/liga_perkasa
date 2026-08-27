<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="brand-wrapper">
            <img src="{{ asset('icon/trophy.svg') }}" alt="Logo" class="brand-icon">
            <span class="brand-text"><span>Liga</span> Perkasa</span>
        </div>
    </div>

    <div class="sidebar-menu">
        @auth
            @if(Auth::user()->isPanitia())
                <a href="{{ route('dashboard') }}" class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <div class="menu-link">
                        <img src="{{ asset('icon/dashboard.svg') }}" alt="" class="menu-icon">
                        <span class="menu-text">Dashboard</span>
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

                <a href="{{ route('juri.penilaian') }}" class="menu-item {{ request()->routeIs('juri.penilaian') ? 'active' : '' }}">
                    <div class="menu-link">
                        <img src="{{ asset('icon/penilaian.svg') }}" alt="" class="menu-icon">
                        <span class="menu-text">Penilaian Juri</span>
                    </div>
                </a>
            @endif

            @if(Auth::user()->isSuperAdmin())
                <a href="{{ route('admin.dashboard') }}" class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <div class="menu-link">
                        <img src="{{ asset('icon/dashboard.svg') }}" alt="" class="menu-icon">
                        <span class="menu-text">Dashboard Admin</span>
                    </div>
                </a>

                <a href="{{ route('admin.index') }}" class="menu-item {{ request()->routeIs('admin.*') && !request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <div class="menu-link">
                        <img src="{{ asset('icon/team.svg') }}" alt="" class="menu-icon">
                        <span class="menu-text">Data Panitia</span>
                    </div>
                </a>

                <div class="menu-item has-submenu">
                    <div class="menu-link" onclick="toggleSubmenu(this)">
                        <img src="{{ asset('icon/penilaian.svg') }}" alt="" class="menu-icon">
                        <span class="menu-text">Penilaian</span>
                        <span class="menu-arrow">▼</span>
                    </div>
                    <div class="submenu {{ request()->routeIs('kriteria.*') || request()->routeIs('juri.*') || request()->routeIs('penilaian.*') || request()->routeIs('juri_lomba.*') ? 'show' : '' }}">
                        <a href="{{ route('kriteria.index') }}" class="submenu-item {{ request()->routeIs('kriteria.*') ? 'active' : '' }}">
                            <div class="submenu-link">
                                <span class="submenu-icon">•</span>
                                <span class="submenu-text">Kriteria</span>
                            </div>
                        </a>

                        <a href="{{ route('juri.index') }}" class="submenu-item {{ request()->routeIs('juri.*') ? 'active' : '' }}">
                            <div class="submenu-link">
                                <span class="submenu-icon">•</span>
                                <span class="submenu-text">Data Juri</span>
                            </div>
                        </a>

                        <a href="{{ route('juri_lomba.index') }}" class="submenu-item {{ request()->routeIs('juri_lomba.*') ? 'active' : '' }}">
                            <div class="submenu-link">
                                <span class="submenu-icon">•</span>
                                <span class="submenu-text">Penugasan Juri</span>
                            </div>
                        </a>

                        <a href="{{ route('penilaian.index') }}" class="submenu-item {{ request()->routeIs('penilaian.index') ? 'active' : '' }}">
                            <div class="submenu-link">
                                <span class="submenu-icon">•</span>
                                <span class="submenu-text">Data Penilaian</span>
                            </div>
                        </a>

                        <a href="{{ route('penilaian.rekap') }}" class="submenu-item {{ request()->routeIs('penilaian.rekap') ? 'active' : '' }}">
                            <div class="submenu-link">
                                <span class="submenu-icon">•</span>
                                <span class="submenu-text">Rekap Penilaian</span>
                            </div>
                        </a>
                    </div>
                </div>
            @endif
        @endauth
    </div>

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

<script>
function toggleSubmenu(element) {
    var parent = element.closest('.menu-item');
    var submenu = parent.querySelector('.submenu');
    
    document.querySelectorAll('.submenu').forEach(function(item) {
        if (item !== submenu) {
            item.classList.remove('show');
            var arrow = item.closest('.menu-item').querySelector('.menu-arrow');
            if (arrow) arrow.textContent = '▼';
        }
    });
    
    submenu.classList.toggle('show');
    var arrow = element.querySelector('.menu-arrow');
    if (arrow) {
        arrow.textContent = submenu.classList.contains('show') ? '▲' : '▼';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.submenu').forEach(function(submenu) {
        if (submenu.querySelector('.active')) {
            submenu.classList.add('show');
            var parent = submenu.closest('.menu-item');
            var arrow = parent.querySelector('.menu-arrow');
            if (arrow) arrow.textContent = '▲';
        }
    });
});
</script>