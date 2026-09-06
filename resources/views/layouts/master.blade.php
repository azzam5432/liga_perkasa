<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Liga Perkasa')</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
    
    <style>
        * {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #f0f2f5;
            overflow-x: hidden;
        }

        .app-container {
            display: flex;
            min-height: 100vh;
        }

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

        .sidebar::-webkit-scrollbar { width: 4px; }
        .sidebar::-webkit-scrollbar-thumb { background: #ff9900; border-radius: 10px; }

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

        .sidebar-menu {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .nav-item {
            list-style: none;
        }

        .nav-link {
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

        .nav-link:hover {
            background: rgba(255, 153, 0, 0.08);
            color: #ffffff;
        }

        .nav-link.active {
            background: #ff9900;
            color: #ffffff;
            box-shadow: 0 4px 15px rgba(255, 153, 0, 0.3);
        }

        .nav-link .fas {
            width: 22px;
            font-size: 16px;
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

        .logout-text {
            transition: all 0.3s ease;
        }

        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background: #f0f2f5;
            width: calc(100% - 260px);
        }

        .content-wrapper {
            flex: 1;
            padding: 24px;
        }

        .navbar {
            background: #ffffff;
            padding: 12px 24px;
            position: sticky;
            top: 0;
            z-index: 999;
            border-bottom: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
            width: 100%;
        }

        .navbar-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
        }

        .navbar-left {
            display: flex;
            align-items: center;
        }

        .navbar-toggle {
            background: transparent;
            border: none;
            padding: 6px;
            cursor: pointer;
            border-radius: 8px;
            transition: all 0.3s ease;
            margin-right: 16px;
        }

        .navbar-toggle:hover {
            background: #f1f3f5;
        }

        .toggle-icon {
            display: block;
            width: 26px;
            height: 18px;
            position: relative;
        }

        .toggle-icon span {
            position: absolute;
            left: 0;
            width: 100%;
            height: 2.5px;
            background: #1a2332;
            border-radius: 2px;
            transition: all 0.3s ease;
        }

        .toggle-icon span:nth-child(1) { top: 0; }
        .toggle-icon span:nth-child(2) { top: 50%; transform: translateY(-50%); }
        .toggle-icon span:nth-child(3) { bottom: 0; }

        .navbar-toggle.active .toggle-icon span:nth-child(1) {
            top: 50%;
            transform: translateY(-50%) rotate(45deg);
        }
        .navbar-toggle.active .toggle-icon span:nth-child(2) {
            opacity: 0;
            transform: translateX(-20px);
        }
        .navbar-toggle.active .toggle-icon span:nth-child(3) {
            bottom: 50%;
            transform: translateY(50%) rotate(-45deg);
        }

        .navbar-brand {
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .brand-name-nav {
            font-weight: 700;
            font-size: 18px;
            color: #1a2332;
        }

        .brand-tagline {
            font-weight: 300;
            font-size: 14px;
            color: #718096;
        }

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .user-profile-link {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            padding: 6px 12px;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .user-profile-link:hover {
            background: #f1f3f5;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
            flex-shrink: 0;
            border: 2px solid #e2e8f0;
        }

        .user-avatar-initial {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 14px;
            color: white;
            flex-shrink: 0;
            border: 2px solid #e2e8f0;
        }

        .user-name {
            font-weight: 500;
            font-size: 14px;
            color: #1a2332;
        }

        .app-footer {
            background: #ffffff;
            padding: 14px 24px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
            margin-top: auto;
            flex-shrink: 0;
        }

        .footer-text {
            font-size: 13px;
            color: #718096;
        }

        .footer-text strong {
            color: #1a2332;
        }

        /* ===== MOBILE SIDEBAR DRAWER ===== */
        @media (max-width: 991.98px) {
            .sidebar {
                position: fixed;
                top: 0;
                left: -260px;
                width: 260px;
                min-width: 260px;
                height: 100vh;
                z-index: 1050;
                transition: left 0.3s ease;
                box-shadow: none;
            }

            .sidebar.show {
                left: 0;
                box-shadow: 0 0 40px rgba(0,0,0,0.3);
            }

            .sidebar-backdrop {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0,0,0,0.5);
                z-index: 1049;
                opacity: 0;
                visibility: hidden;
                transition: all 0.3s ease;
            }

            .sidebar-backdrop.show {
                opacity: 1;
                visibility: visible;
            }

            .main-content {
                width: 100%;
            }

            .navbar-toggle {
                display: block;
            }
        }

        @media (min-width: 992px) {
            .navbar-toggle {
                display: none;
            }
        }

        @media (max-width: 576px) {
            .content-wrapper {
                padding: 16px;
            }
        }
    </style>

    @stack('styles')
</head>
<body>
    <div class="app-container">
        @include('layouts.sidebar')
        <div class="sidebar-backdrop" id="sidebarBackdrop"></div>
        <div class="main-content" id="mainContent">
            @include('layouts.navbar')
            <div class="content-wrapper">
                @yield('content')
            </div>
            @include('layouts.footer')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebarBackdrop');

            if (toggleBtn && sidebar && backdrop) {
                toggleBtn.addEventListener('click', function() {
                    if (window.innerWidth <= 991.98) {
                        sidebar.classList.toggle('show');
                        backdrop.classList.toggle('show');
                    }
                });

                backdrop.addEventListener('click', function() {
                    sidebar.classList.remove('show');
                    backdrop.classList.remove('show');
                });
            }
        });
    </script>
</body>
</html>