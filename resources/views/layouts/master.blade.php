<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Liga Perkasa')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500;700&display=swap" rel="stylesheet" />
    
    <!-- CSS -->
    <style>

        * {
            font-family: 'Ubuntu', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            background: #f0f2f5;
        }

        /* container */
        .app-container {
            display: flex;
            min-height: 100vh;
            padding: 0 !important;
            margin: 0 !important;
            max-width: 100% !important;
            width: 100% !important;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            padding: 0 !important;
            margin: 0 !important;
            width: calc(100% - 260px) !important;
            max-width: calc(100% - 260px) !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow-x: hidden;
            background: #f0f2f5;
        }

        .sidebar.hide ~ .main-content,
        .sidebar.hide + .main-content {
            width: 100% !important;
            max-width: 100% !important;
            margin-left: 0 !important;
        }

        .main-content .content-wrapper {
            flex: 1;
            padding: 24px;
            width: 100% !important;
            max-width: 100% !important;
        }

        @media (max-width: 768px) {
            .main-content {
                width: calc(100% - 80px) !important;
                max-width: calc(100% - 80px) !important;
            }
            .main-content .content-wrapper {
                padding: 16px;
            }
        }

        @media (max-width: 576px) {
            .main-content {
                width: calc(100% - 70px) !important;
                max-width: calc(100% - 70px) !important;
            }
            .main-content .content-wrapper {
                padding: 12px;
            }
        }

        /* Sidebar */
        .sidebar {
            background: linear-gradient(180deg, #111827 0%, #1a2332 100%);
            width: 260px;
            min-width: 260px;
            padding: 24px 20px;
            display: flex;
            flex-direction: column;
            position: sticky;
            top: 0;
            left: 0;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            flex-shrink: 0;
            border-right: 1px solid rgba(255, 255, 255, 0.05);
        }

        .sidebar::-webkit-scrollbar {
            width: 4px;
        }
        .sidebar::-webkit-scrollbar-track {
            background: transparent;
        }
        .sidebar::-webkit-scrollbar-thumb {
            background: #ff9900;
            border-radius: 10px;
        }

        /* Sidebar Hide */
        .sidebar.hide {
            width: 54px;
            min-width: 0px;
            padding: 2px;
            overflow: hidden;
            border: none;
        }

        .sidebar.hide .brand-text,
        .sidebar.hide .brand-ilustration,
        .sidebar.hide .menu-text,
        .sidebar.hide .logout-text {
            display: none !important;
        }

        .sidebar.hide .brand-wrapper {
            justify-content: center;
            padding: 1rem;
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
            padding: 12px;
        }
        .sidebar.hide .logout-icon {
            margin-right: 0;
        }

        /* Sidebar Header */
        .sidebar-header {
            margin-bottom: 30px;
        }

        .brand-wrapper {
            display: flex;
            align-items: center;
            padding: 8px 10px;
            margin-bottom: 16px;
            transition: all 0.3s ease;
        }

        .brand-icon {
            width: 36px;
            height: 36px;
            margin-right: 12px;
            transition: all 0.3s ease;
            filter: brightness(0) invert(1);
        }

        .brand-text {
            font-weight: 700;
            font-size: 20px;
            color: #ffffff;
            letter-spacing: 0.5px;
            white-space: nowrap;
            transition: all 0.3s ease;
        }

        .brand-text span {
            color: #ff9900;
        }

        .brand-ilustration {
            display: flex;
            justify-content: center;
            padding: 10px;
            margin-top: 8px;
            transition: all 0.3s ease;
        }
        .brand-ilustration img {
            max-width: 100%;
            height: auto;
        }

        /* Sidebar Menu */
        .sidebar-menu {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .menu-item {
            text-decoration: none;
            display: block;
            border-radius: 10px;
            transition: all 0.2s ease;
        }

        .menu-item:hover {
            background: rgba(255, 153, 0, 0.1);
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
            transition: all 0.3s ease;
        }

        .menu-icon {
            width: 24px;
            height: 24px;
            margin-right: 14px;
            flex-shrink: 0;
            transition: all 0.3s ease;
            opacity: 0.7;
        }

        .menu-item:hover .menu-icon {
            opacity: 1;
        }

        .menu-text {
            font-weight: 400;
            font-size: 16px;
            color: rgba(255, 255, 255, 0.8);
            white-space: nowrap;
            transition: all 0.3s ease;
        }

        .menu-item:hover .menu-text {
            color: #ffffff;
        }
        .menu-item.active .menu-text {
            color: #ffffff;
            font-weight: 500;
        }

        .menu-item.has-submenu {
            cursor: pointer;
        }

        .menu-item.has-submenu .menu-link {
            display: flex;
            align-items: center;
            padding: 12px 16px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .menu-item.has-submenu .menu-link:hover {
            background: rgba(102, 126, 234, 0.1);
        }

        .menu-arrow {
            margin-left: auto;
            font-size: 12px;
            transition: transform 0.3s ease;
        }

        .submenu {
            display: none;
            padding-left: 20px;
            margin-left: 10px;
            border-left: 2px solid rgba(102, 126, 234, 0.2);
        }

        .submenu.show {
            display: block;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .submenu-item {
            display: block;
            padding: 8px 12px;
            border-radius: 6px;
            color: #4a5568;
            text-decoration: none;
            transition: all 0.2s ease;
            font-size: 14px;
        }

        .submenu-item:hover {
            background: rgba(102, 126, 234, 0.08);
            color: #667eea;
        }

        .submenu-item.active {
            background: rgba(102, 126, 234, 0.12);
            color: #667eea;
            font-weight: 600;
        }

        .submenu-link {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .submenu-icon {
            font-size: 18px;
            color: #a0aec0;
        }

        .submenu-item.active .submenu-icon {
            color: #667eea;
        }

        /* Logout Button */
        .sidebar-footer {
            padding: 16px;
            border-top: 1px solid #e2e8f0;
            margin-top: auto;
        }

        .logout-btn {
            display: flex;
            align-items: center;
            gap: 12px;
            width: 100%;
            padding: 12px 16px;
            border: none;
            border-radius: 8px;
            background: #fee2e2;
            color: #dc2626;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 14px;
            font-weight: 500;
        }

        .logout-btn:hover {
            background: #fecaca;
            transform: translateY(-2px);
        }

        .logout-icon {
            width: 20px;
            height: 20px;
        }

        /* Sidebar Footer */
        .sidebar-footer {
            margin-top: auto;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }

        .logout-btn {
            width: 100%;
            padding: 12px 14px;
            border: none;
            border-radius: 10px;
            background: rgba(220, 53, 69, 0.15);
            color: #ef4444;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
            gap: 12px;
        }

        .logout-btn:hover {
            background: #dc3545;
            color: #ffffff;
            transform: scale(1.02);
            box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
        }

        .logout-btn:hover .logout-icon {
            filter: brightness(0) invert(1);
        }

        .logout-icon {
            width: 24px;
            height: 24px;
            flex-shrink: 0;
            transition: all 0.3s ease;
            margin-right: 2px;
        }

        .logout-text {
            transition: all 0.3s ease;
        }

        /* Navbar */
        .navbar {
            background: linear-gradient(135deg, #1a2332 0%, #2d3748 100%);
            padding: 0.75rem 1.5rem;
            position: sticky;
            top: 0;
            z-index: 999;
            border-bottom: 2px solid #ff9900;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            max-width: 100%;
        }

        /* Toggle Button */
        .navbar-toggle {
            background: transparent;
            border: none;
            padding: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            border-radius: 8px;
            margin-right: 16px;
        }

        .navbar-toggle:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: scale(1.05);
        }

        .toggle-icon {
            position: relative;
            display: block;
            width: 28px;
            height: 20px;
        }

        .toggle-icon span {
            position: absolute;
            left: 0;
            width: 100%;
            height: 3px;
            background-color: #ffffff;
            border-radius: 2px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .toggle-icon span:nth-child(1) { top: 0; }
        .toggle-icon span:nth-child(2) {
            top: 50%;
            transform: translateY(-50%);
        }
        .toggle-icon span:nth-child(3) { bottom: 0; }

        .navbar-toggle.active .toggle-icon span:nth-child(1) {
            top: 50%;
            transform: translateY(-50%) rotate(45deg);
            background-color: #ff9900;
        }

        .navbar-toggle.active .toggle-icon span:nth-child(2) {
            opacity: 0;
            transform: translateX(-20px);
        }

        .navbar-toggle.active .toggle-icon span:nth-child(3) {
            bottom: 50%;
            transform: translateY(50%) rotate(-45deg);
            background-color: #ff9900;
        }

        /* Brand */
        .navbar-brand {
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 6px;
            flex: 1;
        }

        .brand-name {
            font-weight: 700;
            font-size: 1.1rem;
            color: #ffffff;
            letter-spacing: 0.5px;
        }

        .brand-tagline {
            font-weight: 300;
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.6);
        }

        /* Right Section */
        .navbar-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        /* User Dropdown */
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
            color: #ffffff;
        }

        .user-dropdown:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #4e73df, #224abe);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 16px;
            transition: all 0.3s ease;
            flex-shrink: 0;
        }

        .user-dropdown:hover .user-avatar {
            transform: scale(1.05);
            box-shadow: 0 0 20px rgba(78, 115, 223, 0.4);
        }

        .user-name {
            font-weight: 500;
            font-size: 0.95rem;
            color: #ffffff;
        }

        .dropdown-arrow {
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.5);
            transition: all 0.3s ease;
        }

        .user-dropdown:hover .dropdown-arrow {
            color: #ffffff;
        }

        /* Footer */
        .app-footer {
            background: linear-gradient(135deg, #1a2332 0%, #2d3748 100%);
            color: rgba(255, 255, 255, 0.8);
            padding: 16px 0;
            text-align: center;
            width: 100% !important;
            box-sizing: border-box !important;
            margin-top: auto;
            border-top: 2px solid #ff9900;
            margin-left: 0 !important;
            margin-right: 0 !important;
            flex-shrink: 0;
        }

        .footer-content {
            padding: 0 20px;
            max-width: 100%;
        }

        .footer-text {
            font-size: 0.85rem;
            letter-spacing: 0.3px;
        }

        .footer-text strong {
            color: #ff9900;
            font-weight: 700;
        }
        .footer-text i {
            color: #ff9900;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 80px;
                min-width: 80px;
                padding: 20px 10px;
            }

            .sidebar .brand-text,
            .sidebar .brand-ilustration,
            .sidebar .menu-text,
            .sidebar .logout-text {
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
                padding: 12px;
            }
            .sidebar .logout-icon {
                margin-right: 0;
            }

            /* Navbar */
            .navbar {
                padding: 0.6rem 1rem;
            }
            .brand-tagline {
                display: none;
            }
            .brand-name {
                font-size: 0.95rem;
            }
            .user-name {
                display: none;
            }
            .navbar-toggle {
                padding: 6px;
            }
            .toggle-icon {
                width: 24px;
                height: 18px;
            }
            .toggle-icon span {
                height: 2.5px;
            }
            .user-avatar {
                width: 32px;
                height: 32px;
                font-size: 14px;
            }
        }

        @media (max-width: 576px) {
            .sidebar {
                width: 70px;
                min-width: 70px;
                padding: 16px 8px;
            }

            .sidebar .brand-icon {
                width: 30px;
                height: 30px;
            }
            .sidebar .menu-link {
                padding: 10px 6px;
            }
            .sidebar .menu-icon {
                width: 20px;
                height: 20px;
            }
            .sidebar .logout-btn {
                padding: 10px 6px;
                font-size: 14px;
            }
            .sidebar .logout-icon {
                width: 20px;
                height: 20px;
            }

            /* Navbar */
            .navbar {
                padding: 0.5rem 0.75rem;
            }
            .brand-name {
                font-size: 0.85rem;
            }
            .toggle-icon {
                width: 20px;
                height: 16px;
            }
            .toggle-icon span {
                height: 2px;
            }
            .user-avatar {
                width: 28px;
                height: 28px;
                font-size: 12px;
            }

            /* Footer */
            .app-footer {
                padding: 12px 0;
            }
            .footer-text {
                font-size: 0.75rem;
            }
        }

        /* Dropdown Menu */
        .dropdown-menu {
            border: none;
            border-radius: 12px;
            padding: 0.5rem;
            min-width: 200px;
            background: #ffffff;
            box-shadow: 0 0.5rem 2rem rgba(0, 0, 0, 0.15);
            margin-top: 8px;
        }

        .dropdown-item {
            border-radius: 8px;
            padding: 0.6rem 0.8rem;
            font-size: 0.9rem;
            color: #1a2332;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .dropdown-item:hover {
            background: #f8f9fa;
            transform: translateX(4px);
        }

        .dropdown-item i {
            width: 20px;
            text-align: center;
            color: #6c757d;
        }

        .dropdown-item.text-danger {
            color: #dc3545 !important;
        }

        .dropdown-item.text-danger:hover {
            background: #fce4e4;
            color: #c82333 !important;
        }

        .dropdown-item.text-danger i {
            color: #dc3545;
        }

        .dropdown-divider {
            margin: 0.3rem 0;
            border-color: rgba(0, 0, 0, 0.05);
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
            const mainContent = document.getElementById('mainContent');

            if (toggleBtn && sidebar) 
              {
                toggleBtn.addEventListener('click', function() {
                sidebar.classList.toggle('hide');
                this.classList.toggle('active');
                
                if (mainContent) 
                  {
                    const isHidden = sidebar.classList.contains('hide');
                    if (isHidden) {
                        mainContent.style.width = '100%';
                        mainContent.style.maxWidth = '100%';
                    } else {
                        mainContent.style.width = 'calc(100% - 260px)';
                        mainContent.style.maxWidth = 'calc(100% - 260px)';
                    }
                  }
                });
              }

            function handleResize() {
                if (!sidebar || !mainContent) return;
                
                const windowWidth = window.innerWidth;
                const isHidden = sidebar.classList.contains('hide');
                
                // lebar sidebar berdasarkan status
                let sidebarWidth;
                if (windowWidth <= 576) {
                    sidebarWidth = 70; // untuk mobile
                } else if (windowWidth <= 768) {
                    sidebarWidth = 80; // untuk tablet
                } else {
                    sidebarWidth = isHidden ? 80 : 260; // 80 saat hide, 260 saat show di desktop
                }
                
                // Set lebar main content
                mainContent.style.width = `calc(100% - ${sidebarWidth}px)`;
                mainContent.style.maxWidth = `calc(100% - ${sidebarWidth}px)`;
                mainContent.style.marginLeft = '0';
            }

            handleResize();
            window.addEventListener('resize', handleResize);
        });
    </script>
</body>
</html>