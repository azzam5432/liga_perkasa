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
            background: #f0f2f5;
            min-height: 100vh;
        }
        
        .public-navbar {
            background: #1a365d;
            padding: 14px 24px;
            color: white;
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
        
        .public-content {
            padding: 24px;
        }
        
        .public-footer {
            text-align: center;
            padding: 20px;
            color: #718096;
            font-size: 13px;
        }
    </style>
</head>
<body>
    <nav class="public-navbar">
        <div class="container">
            <a href="{{ route('ranking') }}" class="brand">
                <i class="fas fa-trophy me-2"></i> Liga <span>Perkasa</span>
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