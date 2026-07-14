<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Masuk - BeautyCare</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">

    <style>
        .login-page {
            min-height: 100vh;
            display: flex;
            font-family: 'Poppins', sans-serif;
        }

        .login-left {
            flex: 1;
            background: linear-gradient(135deg, #FF4F87 0%, #FF7BA6 50%, #FF4F87 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 60px 40px;
            position: relative;
            overflow: hidden;
        }

        .login-left::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -30%;
            width: 600px;
            height: 600px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
            pointer-events: none;
        }

        .login-left::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -20%;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            pointer-events: none;
        }

        .login-left-content {
            position: relative;
            z-index: 1;
            text-align: center;
            color: var(--white);
            max-width: 420px;
        }

        .login-left-content .logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-bottom: 32px;
        }

        .login-left-content .logo span {
            font-size: 28px;
            font-weight: var(--fw-bold);
        }

        .login-left-content h2 {
            font-size: 28px;
            font-weight: var(--fw-bold);
            margin-bottom: 16px;
        }

        .login-left-content p {
            font-size: 16px;
            opacity: 0.9;
            line-height: 1.7;
        }

        .login-left-content .illustration {
            margin-top: 40px;
        }

        .login-left-content .illustration svg {
            width: 200px;
            height: 200px;
            opacity: 0.6;
        }

        .login-right {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 60px 40px;
            background: var(--background);
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            background: var(--white);
            border-radius: var(--radius-lg);
            padding: 40px;
            box-shadow: var(--shadow-md);
            animation: fadeInUp 0.6s ease-out;
        }

        .login-card .lc-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .login-card .lc-header h2 {
            font-size: 24px;
            font-weight: var(--fw-bold);
            color: var(--dark);
            margin-bottom: 8px;
        }

        .login-card .lc-header p {
            font-size: 14px;
            color: var(--gray);
        }

        .login-card .form-group {
            margin-bottom: 20px;
        }

        .login-card .form-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .login-card .form-options label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            color: var(--gray);
            cursor: pointer;
        }

        .login-card .form-options input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: var(--primary);
            cursor: pointer;
        }

        .login-card .form-options a {
            font-size: 14px;
            color: var(--primary);
            font-weight: var(--fw-medium);
        }

        .login-card .form-options a:hover {
            text-decoration: underline;
        }

        .login-card .btn {
            width: 100%;
            padding: 14px;
            font-size: 15px;
        }

        .login-card .divider {
            margin: 24px 0;
        }

        .login-card .social-login {
            width: 100%;
            padding: 12px;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-size: 14px;
            font-weight: var(--fw-medium);
            color: var(--dark);
            background: var(--white);
            transition: var(--transition-base);
            cursor: pointer;
        }

        .login-card .social-login:hover {
            border-color: var(--primary);
            background: var(--hover);
        }

        .login-card .register-link {
            text-align: center;
            margin-top: 24px;
            font-size: 14px;
            color: var(--gray);
        }

        .login-card .register-link a {
            color: var(--primary);
            font-weight: var(--fw-medium);
        }

        .login-card .register-link a:hover {
            text-decoration: underline;
        }

        .login-card .alert {
            padding: 12px 16px;
            border-radius: var(--radius-md);
            font-size: 14px;
            margin-bottom: 20px;
        }

        .login-card .alert-danger {
            background: #FDE8E8;
            color: var(--danger);
            border: 1px solid #FECACA;
        }

        .login-card .alert-success {
            background: #E8F8EE;
            color: var(--success);
            border: 1px solid #BBF7D0;
        }

        @media screen and (max-width: 768px) {
            .login-left {
                display: none;
            }
            .login-right {
                padding: 40px 20px;
            }
            .login-card {
                padding: 32px 24px;
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <div class="login-page">
        <div class="login-left">
            <div class="login-left-content">
                <div class="logo">
                    <svg width="40" height="40" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="32" height="32" rx="8" fill="white"/>
                        <path d="M16 8C14 8 10 10 10 16C10 22 14 24 16 24C18 24 22 22 22 16C22 10 18 8 16 8Z" fill="#FF4F87" opacity="0.9"/>
                    </svg>
                    <span>BeautyCare</span>
                </div>
                <h2>Selamat Datang Kembali</h2>
                <p>Kelola bisnis kecantikan Anda dengan lebih mudah menggunakan BeautyCare. Masuk untuk melanjutkan.</p>
                <div class="illustration">
                    <svg width="200" height="200" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="100" cy="100" r="80" stroke="white" stroke-width="2" opacity="0.3"/>
                        <circle cx="100" cy="100" r="50" stroke="white" stroke-width="2" opacity="0.3"/>
                        <path d="M100 40V100L140 140" stroke="white" stroke-width="3" stroke-linecap="round" opacity="0.6"/>
                        <circle cx="100" cy="100" r="8" fill="white" opacity="0.8"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="login-right">
            <div class="login-card">
                <div class="lc-header">
                    <h2>Masuk</h2>
                    <p>Masukkan email dan password Anda</p>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                    </div>
                @endif

                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group">
                        <label class="form-label" for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-input" placeholder="email@example.com" value="{{ old('email') }}" required autofocus>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="password">Password</label>
                        <input type="password" id="password" name="password" class="form-input" placeholder="Masukkan password" required>
                    </div>

                    <div class="form-options">
                        <label>
                            <input type="checkbox" name="remember">
                            Ingat saya
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}">Lupa Password?</a>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary">Masuk</button>
                </form>

                <div class="divider">Atau</div>

                <button class="social-login">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 0 1-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z" fill="#4285F4"/>
                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                    </svg>
                    Masuk dengan Google
                </button>

                <div class="register-link">
                    Belum punya akun? <a href="{{ route('register') }}">Daftar Sekarang</a>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/animation.js') }}"></script>
</body>
</html>
