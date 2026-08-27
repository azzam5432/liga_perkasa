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

        .sidebar.hide {
            width: 70px;
            min-width: 70px;
            padding: 20px 10px;
        }

        .sidebar.hide .brand-text,
        .sidebar.hide .brand-ilustration,
        .sidebar.hide .menu-text,
        .sidebar.hide .logout-text,
        .sidebar.hide .menu-arrow,
        .sidebar.hide .submenu {
            display: none !important;
        }

        .sidebar.hide .brand-wrapper {
            justify-content: center;
            padding: 0;
        }
        .sidebar.hide .brand-icon {
            margin-right: 0;
        }
        .sidebar.hide .menu-link {
            justify-content: center;
            padding: 12px 8px;
        }
        .sidebar.hide .menu-icon {
            margin-right: 0;
        }
        .sidebar.hide .logout-btn {
            justify-content: center;
            padding: 12px 8px;
        }
        .sidebar.hide .logout-icon {
            margin-right: 0;
        }

        .brand-wrapper {
            display: flex;
            align-items: center;
            padding: 8px 0;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }

        .brand-icon {
            width: 36px;
            height: 36px;
            margin-right: 12px;
            transition: all 0.3s ease;
            filter: brightness(0) invert(1);
            flex-shrink: 0;
        }

        .brand-text {
            font-weight: 800;
            font-size: 20px;
            color: #ffffff;
            letter-spacing: 0.5px;
            white-space: nowrap;
            transition: all 0.3s ease;
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

        .menu-item {
            text-decoration: none;
            display: block;
            border-radius: 10px;
            transition: all 0.2s ease;
        }

        .menu-item:hover {
            background: rgba(255, 153, 0, 0.08);
        }

        .menu-item.active {
            background: #ff9900;
            box-shadow: 0 4px 15px rgba(255, 153, 0, 0.3);
        }

        .menu-item.active .menu-text {
            color: #ffffff;
        }
        .menu-item.active .menu-icon {
            filter: brightness(0) invert(1);
        }

        .menu-link {
            display: flex;
            align-items: center;
            padding: 12px 14px;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            gap: 14px;
        }

        .menu-icon {
            width: 22px;
            height: 22px;
            flex-shrink: 0;
            opacity: 0.7;
            transition: all 0.3s ease;
            filter: brightness(0) invert(1);
        }

        .menu-item:hover .menu-icon {
            opacity: 1;
        }
        .menu-item.active .menu-icon {
            opacity: 1;
        }

        .menu-text {
            font-weight: 500;
            font-size: 15px;
            color: rgba(255,255,255,0.8);
            white-space: nowrap;
            transition: all 0.3s ease;
            flex: 1;
        }

        .menu-item:hover .menu-text {
            color: #ffffff;
        }
        .menu-item.active .menu-text {
            color: #ffffff;
        }

        .menu-arrow {
            font-size: 11px;
            color: rgba(255,255,255,0.4);
            transition: all 0.3s ease;
        }

        .menu-item.active .menu-arrow {
            color: rgba(255,255,255,0.8);
        }

        .submenu {
            display: none;
            padding: 4px 0 8px 16px;
            margin-left: 8px;
            border-left: 2px solid rgba(255, 153, 0, 0.2);
        }

        .submenu.show {
            display: block;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .submenu-item {
            display: block;
            padding: 8px 12px;
            border-radius: 6px;
            color: rgba(255,255,255,0.6);
            text-decoration: none;
            transition: all 0.2s ease;
            font-size: 14px;
        }

        .submenu-item:hover {
            background: rgba(255, 153, 0, 0.08);
            color: #ffffff;
        }

        .submenu-item.active {
            background: rgba(255, 153, 0, 0.12);
            color: #ff9900;
            font-weight: 600;
        }

        .submenu-link {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .submenu-icon {
            font-size: 6px;
            color: rgba(255,255,255,0.3);
        }

        .submenu-item.active .submenu-icon {
            color: #ff9900;
        }

        .submenu-text {
            font-weight: 400;
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

        .logout-btn:hover .logout-icon {
            filter: brightness(0) invert(1);
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
        }

        .logout-text {
            transition: all 0.3s ease;
        }

        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            transition: all 0.3s ease;
            background: #f0f2f5;
            width: calc(100% - 260px);
        }

        .sidebar.hide ~ .main-content {
            width: calc(100% - 70px);
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

        .user-dropdown {
            background: transparent;
            border: none;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 6px 12px;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .user-dropdown:hover {
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

        .dropdown-arrow {
            font-size: 12px;
            color: #718096;
            transition: all 0.3s ease;
        }

        .dropdown-menu {
            border: none;
            border-radius: 12px;
            padding: 8px;
            min-width: 200px;
            background: #ffffff;
            box-shadow: 0 10px 40px rgba(0,0,0,0.12);
            margin-top: 8px;
        }

        .dropdown-item {
            border-radius: 8px;
            padding: 8px 14px;
            font-size: 14px;
            color: #1a2332;
            transition: all 0.2s ease;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .dropdown-item:hover {
            background: #f1f3f5;
        }

        .dropdown-item i {
            width: 18px;
            color: #718096;
        }

        .dropdown-item.text-danger {
            color: #dc3545 !important;
        }
        .dropdown-item.text-danger:hover {
            background: #fce4e4;
        }
        .dropdown-item.text-danger i {
            color: #dc3545;
        }

        .dropdown-divider {
            margin: 4px 0;
            border-color: #e2e8f0;
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

        @media (max-width: 992px) {
            .sidebar {
                width: 70px;
                min-width: 70px;
                padding: 16px 10px;
                overflow: hidden !important;
            }
            .sidebar:hover {
                overflow-y: auto !important;
            }
            .sidebar .brand-text,
            .sidebar .brand-ilustration,
            .sidebar .menu-text,
            .sidebar .logout-text,
            .sidebar .menu-arrow,
            .sidebar .submenu {
                display: none !important;
            }
            .sidebar .brand-wrapper {
                justify-content: center;
                padding: 0;
            }
            .sidebar .brand-icon {
                margin-right: 0;
            }
            .sidebar .menu-link {
                justify-content: center;
                padding: 12px 8px;
            }
            .sidebar .menu-icon {
                margin-right: 0;
            }
            .sidebar .logout-btn {
                justify-content: center;
                padding: 12px 8px;
            }
            .sidebar .logout-icon {
                margin-right: 0;
            }

            .main-content {
                width: calc(100% - 70px);
            }
            .sidebar.hide ~ .main-content {
                width: 100%;
            }

            .brand-tagline {
                display: none;
            }
            .brand-name-nav {
                font-size: 16px;
            }
            .user-name {
                display: none;
            }
            .dropdown-arrow {
                display: none;
            }
        }

        @media (max-width: 576px) {
            .sidebar {
                width: 60px;
                min-width: 60px;
                padding: 12px 6px;
                overflow: hidden !important;
            }
            .sidebar:hover {
                overflow-y: auto !important;
            }
            .sidebar .brand-icon {
                width: 28px;
                height: 28px;
            }
            .sidebar .menu-link {
                padding: 10px 6px;
            }
            .sidebar .menu-icon {
                width: 18px;
                height: 18px;
            }
            .sidebar .logout-btn {
                padding: 10px 6px;
                font-size: 13px;
            }
            .sidebar .logout-icon {
                width: 18px;
                height: 18px;
            }

            .main-content {
                width: calc(100% - 60px);
            }
            .sidebar.hide ~ .main-content {
                width: 100%;
            }

            .navbar {
                padding: 10px 16px;
            }
            .brand-name-nav {
                font-size: 14px;
            }
            .toggle-icon {
                width: 20px;
                height: 14px;
            }
            .toggle-icon span {
                height: 2px;
            }
            .user-avatar,
            .user-avatar-initial {
                width: 30px;
                height: 30px;
                font-size: 12px;
            }
            .content-wrapper {
                padding: 16px;
            }
            .app-footer {
                padding: 10px 16px;
            }
            .footer-text {
                font-size: 11px;
            }
        }
    </style>

    @stack('styles')
</head>
<body>
    <div class="app-container">
        @include('layouts.sidebar')
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

            if (toggleBtn && sidebar) {
                toggleBtn.addEventListener('click', function() {
                    sidebar.classList.toggle('hide');
                    this.classList.toggle('active');
                });
            }

            function handleResize() {
                if (window.innerWidth <= 992) {
                    if (!sidebar.classList.contains('hide')) {
                        sidebar.classList.add('hide');
                        if (toggleBtn) toggleBtn.classList.add('active');
                    }
                }
            }

            handleResize();
            window.addEventListener('resize', handleResize);
        });
    </script>
</body>
</html>