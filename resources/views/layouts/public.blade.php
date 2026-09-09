<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Liga Perkasa')</title>
    
    <!-- Bootstrap & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
    
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        body {
            background: linear-gradient(rgba(10, 20, 40, 0.85), rgba(10, 20, 40, 0.95)), url('/icon/liga.png');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            margin: 0;
            display: flex;
            flex-direction: column;
        }
        
        /* ===== TOP NAVBAR UTAMA ===== */
        .public-navbar {
            background: rgba(26, 54, 93, 0.95);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
            padding: 10px 0;
        }
        
        /* Memberikan posisi relative ke container agar posisi absolute dropdown mengacu pada container ini */
        .public-navbar .container {
            position: relative;
        }

        /* Brand / Logo */
        .public-navbar .brand {
            font-weight: 800;
            font-size: 20px;
            color: white;
            text-decoration: none;
            white-space: nowrap;
        }
        
        .public-navbar .brand span {
            color: #ff9900;
        }

        /* Nav Item Links */
        .nav-link-custom {
            color: rgba(255, 255, 255, 0.85);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            padding: 8px 16px;
            border-radius: 6px;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
        }
        
        .nav-link-custom:hover {
            color: #ff9900;
            background: rgba(255, 255, 255, 0.05);
        }

        /* Tombol Login */
        .btn-login {
            background: #ff9900;
            color: white !important;
            padding: 8px 20px;
            border-radius: 6px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        
        .btn-login:hover {
            background: #e68a00;
            transform: translateY(-1px);
        }

        /* Tampilan Toggler / Hamburger Button */
        .navbar-toggler-custom {
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            background: transparent;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 18px;
            transition: all 0.2s;
        }

        .navbar-toggler-custom:focus {
            box-shadow: 0 0 0 0.25rem rgba(255, 153, 0, 0.25);
            outline: none;
            border-color: #ff9900;
        }

        /* ===== PERUBAHAN UTAMA UNTUK MENIMPA KONTEN (OVERLAY MOBILE) ===== */
        @media (max-width: 991.98px) {
            .navbar-collapse {
                position: absolute; /* Membuat menu melayang */
                top: 100%; /* Posisinya pas di bawah header */
                left: 0;
                right: 0;
                background: rgba(18, 38, 68, 0.98);
                backdrop-filter: blur(15px); /* Efek blur konten di belakangnya */
                border-radius: 12px;
                padding: 15px;
                margin-top: 10px;
                border: 1px solid rgba(255, 255, 255, 0.15);
                box-shadow: 0 15px 30px rgba(0,0,0,0.5); /* Bayangan tegas agar terpisah dari konten */
                z-index: 1050; /* Memastikan di atas konten utama */
            }

            .nav-link-custom {
                padding: 12px 14px;
                font-size: 15px;
            }

            .btn-login {
                width: 100%;
                margin-top: 10px;
                padding: 10px;
            }
        }

        /* Layout Content & Footer */
        .public-content {
            padding: 24px 0;
            flex: 1;
        }
        
        .public-footer {
            text-align: center;
            padding: 20px;
            color: rgba(255, 255, 255, 0.7);
            font-size: 13px;
            background: rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(5px);
            margin-top: auto;
        }
    </style>
</head>
<body>

    <!-- TOP NAVIGATION BAR -->
    <nav class="navbar navbar-expand-lg public-navbar">
        <div class="container">
            <!-- Brand Logo -->
            <a href="{{ route('ranking') }}" class="brand">
                <i class="fas fa-trophy me-2"></i> Liga <span>Perkasa</span>
            </a>

            <!-- Toggle Button -->
            <button class="navbar-toggler navbar-toggler-custom" type="button" data-bs-toggle="collapse" data-bs-target="#topNavbar" aria-controls="topNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>

            <!-- Top Nav Links Dropdown (Melayang di atas Konten) -->
            <div class="collapse navbar-collapse" id="topNavbar">
                <div class="navbar-nav ms-auto align-items-lg-center gap-2 mt-2 mt-lg-0">
                    <a href="{{ route('ranking') }}" class="nav-link-custom">
                        <i class="fas fa-chart-line me-2"></i> Ranking
                    </a>
                    <a href="{{ route('lomba.publik') }}" class="nav-link-custom">
                        <i class="fas fa-trophy me-2"></i> Daftar Lomba
                    </a>
                    <a href="{{ route('login') }}" class="btn-login ms-lg-2">
                        <i class="fas fa-sign-in-alt me-2"></i> Login
                    </a>
                </div>
            </div>
        </div>
    </nav>
    
    <!-- Main Content -->
    <div class="public-content">
        <div class="container">
            @yield('content')
        </div>
    </div>
    
    <!-- Footer -->
    <footer class="public-footer">
        <i class="fas fa-copyright me-1"></i>
        {{ date('Y') }} <strong>Liga Perkasa</strong>. All Rights Reserved.
    </footer>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script sederhana ubah icon toggle -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const topNavbar = document.getElementById('topNavbar');
            const togglerBtn = document.querySelector('.navbar-toggler-custom');
            const icon = togglerBtn.querySelector('i');

            topNavbar.addEventListener('show.bs.collapse', function () {
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-times');
            });

            topNavbar.addEventListener('hide.bs.collapse', function () {
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            });
        });
    </script>
</body>
</html>