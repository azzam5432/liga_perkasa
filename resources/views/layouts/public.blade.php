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
        }
        
        body {
            /* BACKGROUND GAMBAR MENYELURUH */
            background: linear-gradient(rgba(10, 20, 40, 0.85), rgba(10, 20, 40, 0.95)), url('/icon/liga.png');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            margin: 0;
        }
        
        .public-navbar {
            background: rgba(26, 54, 93, 0.9); /* Semi transparan */
            padding: 14px 24px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(5px);
        }
        
        .public-navbar .brand {
            font-weight: 800;
            font-size: 20px;
            color: white;
            text-decoration: none;
        }
        
        .public-navbar .brand span {
            color: #ff9900;
        }
        
        .public-navbar .btn-login {
            background: #ff9900;
            color: white;
            padding: 6px 16px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.2s ease;
        }
        
        .public-navbar .btn-login:hover {
            background: #e68a00;
        }
        
        .public-content {
            padding: 24px;
        }
        
        .public-footer {
            text-align: center;
            padding: 20px;
            color: rgba(255, 255, 255, 0.7);
            font-size: 13px;
            background: rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(5px);
        }
    </style>
</head>
<body>
    <nav class="public-navbar">
        <div class="container d-flex justify-content-between align-items-center">
            <a href="{{ route('ranking') }}" class="brand">
                <i class="fas fa-trophy me-2"></i> Liga <span>Perkasa</span>
            </a>
            <a href="{{ route('login') }}" class="btn-login">
                <i class="fas fa-sign-in-alt me-1"></i> Login
            </a>
        </div>
    </nav>
    
    <div class="public-content">
        <div class="container">
            @yield('content')
        </div>
    </div>
    
    <footer class="public-footer">
        <i class="fas fa-copyright me-1"></i>
        {{ date('Y') }} <strong>Liga Perkasa</strong>. All Rights Reserved.
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>