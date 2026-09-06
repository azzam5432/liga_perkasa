<nav class="navbar">
    <div class="navbar-container">
        <div class="navbar-left">
            <button class="navbar-toggle d-lg-none" id="sidebarToggle" aria-label="Toggle Sidebar">
                <span class="toggle-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </button>

            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <span class="brand-name-nav">Liga Perkasa</span>
                <span class="brand-tagline d-none d-md-inline">| Dashboard</span>
            </a>
        </div>

        <div class="navbar-right">
            <a href="{{ route('profile.index') }}" class="user-profile-link">
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
                <span class="user-name d-none d-lg-inline">{{ Auth::user()->name ?? 'Admin' }}</span>
            </a>
        </div>
    </div>
</nav>