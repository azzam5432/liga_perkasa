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
                {{-- SUPER ADMIN MENU --}}
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
                
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('juri.*') ? 'active' : '' }}" 
                        href="{{ route('juri.index') }}">
                        <i class="fas fa-user-tie me-2"></i> Data Juri
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('juri_lomba.*') ? 'active' : '' }}" 
                        href="{{ route('juri_lomba.index') }}">
                        <i class="fas fa-user-tag me-2"></i> Penugasan Juri
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('finalis.*') ? 'active' : '' }}" 
                    href="{{ route('finalis.index', 1) }}">
                        <i class="fas fa-trophy me-2"></i>
                        <span>Finalis</span>
                    </a>
                </li>

            @elseif(Auth::user()->isPanitia())
                {{-- PANITIA MENU --}}
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

                {{-- MANAJEMEN LOMBA --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('lomba.index') ? 'active' : '' }}" 
                        href="{{ route('lomba.index') }}">
                        <i class="fas fa-trophy me-2"></i> Daftar Lomba
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('nilai.index') ? 'active' : '' }}" 
                        href="{{ route('nilai.index') }}">
                        <i class="fas fa-clipboard-list me-2"></i> penilaian lomba
                    </a>
                </li>
            @endif
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('ranking') ? 'active' : '' }}" 
                   href="{{ route('ranking') }}">
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

<style>
    .sidebar {
        width: 260px;
        min-width: 260px;
        background: #111827;
        padding: 20px 16px;
        display: flex;
        flex-direction: column;
        height: 100vh;
        position: sticky;
        top: 0;
        overflow-y: auto;
        z-index: 1000;
        transition: all 0.3s ease;
        border-right: 1px solid rgba(255,255,255,0.05);
        flex-shrink: 0;
    }

    .sidebar .sidebar-menu {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 2px;
        padding: 0;
        margin: 0;
        list-style: none;
    }

    .sidebar .nav-item {
        list-style: none;
    }

    .sidebar .nav-link {
        display: flex;
        align-items: center;
        padding: 12px 14px;
        border-radius: 10px;
        color: rgba(255,255,255,0.8);
        text-decoration: none;
        transition: all 0.3s ease;
        cursor: pointer;
        font-weight: 500;
        font-size: 15px;
        gap: 14px;
    }

    .sidebar .nav-link:hover {
        background: rgba(255, 153, 0, 0.08);
        color: #ffffff;
    }

    .sidebar .nav-link.active {
        background: #ff9900;
        color: #ffffff;
        box-shadow: 0 4px 15px rgba(255, 153, 0, 0.3);
    }

    .sidebar .nav-link .fas {
        width: 22px;
        font-size: 16px;
    }

    .sidebar .nav-link .ms-auto {
        margin-left: auto;
        font-size: 12px;
        transition: all 0.3s ease;
    }

    .sidebar .nav-link[aria-expanded="true"] .ms-auto {
        transform: rotate(180deg);
    }

    .sidebar .collapse .nav {
        padding-left: 12px;
        border-left: 2px solid rgba(255, 153, 0, 0.2);
        margin-left: 8px;
    }

    .sidebar .collapse .nav-link {
        padding: 8px 12px;
        font-size: 14px;
        color: rgba(255,255,255,0.6);
    }

    .sidebar .collapse .nav-link:hover {
        color: #ffffff;
        background: rgba(255, 153, 0, 0.08);
    }

    .sidebar .collapse .nav-link.active {
        color: #ff9900;
        background: rgba(255, 153, 0, 0.12);
    }

    .sidebar .collapse .nav-link .fas {
        width: 16px;
        font-size: 6px;
    }

    .sidebar-footer {
        margin-top: auto;
        padding-top: 16px;
        border-top: 1px solid rgba(255,255,255,0.08);
    }

    .logout-btn {
        width: 100%;
        padding: 12px 14px;
        border: none;
        border-radius: 10px;
        background: rgba(220, 53, 69, 0.15);
        color: #ef4444;
        font-size: 15px;
        font-weight: 500;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 14px;
        transition: all 0.3s ease;
    }

    .logout-btn:hover {
        background: #dc3545;
        color: #ffffff;
        box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
    }

    .logout-icon {
        width: 22px;
        height: 22px;
        flex-shrink: 0;
        filter: brightness(0) invert(1);
        opacity: 0.7;
        transition: all 0.3s ease;
    }

    .logout-btn:hover .logout-icon {
        opacity: 1;
        filter: brightness(0) invert(1);
    }

    .brand-wrapper {
        display: flex;
        align-items: center;
        padding: 8px 0;
        margin-bottom: 20px;
    }

    .brand-icon {
        width: 36px;
        height: 36px;
        margin-right: 12px;
        filter: brightness(0) invert(1);
        flex-shrink: 0;
    }

    .brand-text {
        font-weight: 800;
        font-size: 20px;
        color: #ffffff;
        letter-spacing: 0.5px;
        white-space: nowrap;
    }

    .brand-text span {
        color: #ff9900;
    }

    @media (max-width: 992px) {
        .sidebar {
            width: 70px;
            min-width: 70px;
            padding: 16px 10px;
        }
        .sidebar .brand-text {
            display: none;
        }
        .sidebar .nav-link span:not(.fas) {
            display: none;
        }
        .sidebar .nav-link .ms-auto {
            display: none;
        }
        .sidebar .collapse {
            display: none !important;
        }
        .sidebar .logout-text {
            display: none;
        }
        .sidebar .logout-btn {
            justify-content: center;
            padding: 12px 8px;
        }
        .sidebar .logout-icon {
            margin-right: 0;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.sidebar .nav-link[data-bs-toggle="collapse"]').forEach(function(link) {
        link.addEventListener('click', function(e) {
            var target = document.querySelector(this.getAttribute('href'));
            if (target) {
                document.querySelectorAll('.sidebar .collapse.show').forEach(function(item) {
                    if (item !== target) {
                        item.classList.remove('show');
                        var btn = document.querySelector('[href="#' + item.id + '"]');
                        if (btn) btn.setAttribute('aria-expanded', 'false');
                    }
                });
            }
        });
    });
});
</script>