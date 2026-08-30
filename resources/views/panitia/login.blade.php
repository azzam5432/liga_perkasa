<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <title>Login Admin</title>
    
    <style>
        html, body {
            height: 100%;
            overflow: hidden;
            margin: 0;
            padding: 0;
        }
        
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f0f2f5;
        }        

        .split-screen {
            display: flex;
            width: 100%;
            height: 100vh;
            overflow: hidden;
        }

        .left-panel {
            flex: 1;
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0.9) 100%),
            url('{{ asset("icon/login.jpg") }}');
            background-size: cover;
            background-position: center;
            background-blend-mode: overlay;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            position: relative;
        }
        
        .left-panel .illustration {
            max-width: 80%;
            text-align: center;
            color: white;
        }
        
        .left-panel .illustration h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 15px;
        }
        
        .left-panel .illustration p {
            font-size: 1.1rem;
            opacity: 0.9;
            line-height: 1.6;
        }
        
        .right-panel {
            flex: 1;
            padding-top: auto;
            display: flex;
            align-items: center;
            justify-content: center;
            background: white;
            padding: 40px;
        }
        
        .right-panel .login-wrapper {
            width: 100%;
            max-width: 420px;
        }
        
        .right-panel .login-wrapper .logo {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .right-panel .login-wrapper .logo h2 {
            font-weight: 700;
            color: #333;
        }
        
        .right-panel .login-wrapper .logo p {
            color: #777;
            margin-top: 5px;
        }
        
        .card-shadow {
            box-shadow: none;
            border: none;
        }
        
        .alert-custom {
            border-radius: 10px;
            border: none;
        }
        
        .btn-primary-custom {
            background: linear-gradient(135deg, #ff9900 0%, #ffa41b 100%);
            border: none;
            transition: all 0.3s;
        }
        
        .btn-primary-custom:hover {
            transform: scale(1.02);
            box-shadow: 0 5px 20px rgba(255, 153, 0, 0.4);
        }
        
        @media (max-width: 768px) {
            .split-screen {
                flex-direction: column;
                height: 100vh;
                overflow-y: auto;
            }
            
            .left-panel {
                padding: 30px 20px;
                min-height: 30vh;
            }
            
            .left-panel .illustration h1 {
                font-size: 1.8rem;
            }
            
            .left-panel .illustration p {
                font-size: 0.9rem;
            }
            
            .right-panel {
                padding: 30px 20px;
                min-height: 70vh;
            }
            
            .right-panel .login-wrapper {
                max-width: 100%;
            }
        }
        
        @media (max-width: 576px) {
            .left-panel .illustration h1 {
                font-size: 1.4rem;
            }
        }
    </style>
</head>
<body>
    <div class="split-screen">
        <div class="left-panel">
            <div class="illustration">
                
                <h1>Selamat Datang</h1>
                <p>Silakan login untuk mengakses dashboard admin dan kelola data dengan mudah</p>
            </div>
        </div>      
        <div class="right-panel">
            <div class="login-wrapper">
                <div class="logo">
                    <div class="bg-warning bg-gradient rounded-circle d-inline-flex p-3 mb-3" style="width: 70px; height: 70px;">
                        <i class="fas fa-user-lock text-white display-6 m-auto"></i>
                    </div>
                    <h2>Login Admin</h2>
                    <p>Masukkan Username dan Password Anda untuk melanjutkan</p>
                </div>
                @if ($errors->any())
                    <div class="alert alert-danger alert-custom d-flex align-items-center" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <div>
                            @foreach ($errors->all() as $error)
                                {{ $error }}
                            @endforeach
                        </div>
                    </div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success alert-custom d-flex align-items-center" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        <div>{{ session('success') }}</div>
                    </div>
                @endif
                @if (session('status'))
                    <div class="alert alert-info alert-custom d-flex align-items-center" role="alert">
                        <i class="fas fa-info-circle me-2"></i>
                        <div>{{ session('status') }}</div>
                    </div>
                @endif
                
                <form method="POST" action="{{ route('login') }}">
                    @csrf                    
                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">
                            <i class="fas fa-envelope me-1"></i> Alamat Email
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="fas fa-envelope text-muted"></i>
                            </span>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   placeholder="Masukkan email Anda" 
                                   required 
                                   autofocus>
                        </div>
                        @error('email')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold">
                            <i class="fas fa-key me-1"></i> Password
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="fas fa-lock text-muted"></i>
                            </span>
                            <input type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   id="password" 
                                   name="password" 
                                   placeholder="Masukkan password Anda" 
                                   required>
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Ingat saya</label>
                        </div>
                        <a href="#" class="text-decoration-none small">Lupa password?</a>
                    </div>
                    
                    <button type="submit" class="btn btn-primary-custom btn-lg w-100 text-white fw-semibold">
                        <i class="fas fa-sign-in-alt me-2"></i> Login
                    </button>
                </form>
                <div class="text-center mt-4">
                    <p class="text-muted small">
                        &copy; {{ date('Y') }} Politeknik Mitra Industri. All rights reserved.
                    </p>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>