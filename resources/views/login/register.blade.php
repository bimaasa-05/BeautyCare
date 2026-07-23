<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar - BeautyCare</title>
    @include('partials.head-meta')

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

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
            max-width: 460px;
            background: var(--white);
            border-radius: var(--radius-lg);
            padding: 40px;
            box-shadow: var(--shadow-md);
            animation: fadeInUp 0.6s ease-out;
        }

        .login-card .lc-header {
            text-align: center;
            margin-bottom: 28px;
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
            margin-bottom: 18px;
        }

        .login-card .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .login-card .terms {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 24px;
        }

        .login-card .terms input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: var(--primary);
            cursor: pointer;
        }

        .login-card .terms label {
            font-size: 13px;
            color: var(--gray);
            cursor: pointer;
        }

        .login-card .terms a {
            color: var(--primary);
            font-weight: var(--fw-medium);
        }

        .login-card .btn {
            width: 100%;
            padding: 14px;
            font-size: 15px;
        }

        .login-card .login-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: var(--gray);
        }

        .login-card .login-link a {
            color: var(--primary);
            font-weight: var(--fw-medium);
        }

        .login-card .login-link a:hover {
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

        @media screen and (max-width: 768px) {
            .login-left {
                display: none;
            }

            .login-right {
                padding: 40px 20px;
            }

            .login-card {
                padding: 32px 20px;
            }

            .login-card .form-row {
                grid-template-columns: 1fr;
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
                    <svg width="40" height="40" viewBox="0 0 32 32" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <rect width="32" height="32" rx="8" fill="white" />
                        <path d="M16 8C14 8 10 10 10 16C10 22 14 24 16 24C18 24 22 22 22 16C22 10 18 8 16 8Z"
                            fill="#FF4F87" opacity="0.9" />
                    </svg>
                    <span>BeautyCare</span>
                </div>
                <h2>Mulai Perjalanan Anda</h2>
                <p>Daftar sekarang dan kelola bisnis kecantikan Anda dengan lebih profesional.</p>
            </div>
        </div>

        <div class="login-right">
            <div class="login-card">
                <div class="lc-header">
                    <h2>Buat Akun</h2>
                    <p>Isi data diri Anda untuk mendaftar</p>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul style="margin:0;padding-left:16px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="form-group">
                        <label class="form-label" for="name">Nama Lengkap</label>
                        <input type="text" id="name" name="name" class="form-input"
                            placeholder="Nama lengkap" value="{{ old('name') }}" required autofocus>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-input"
                            placeholder="email@example.com" value="{{ old('email') }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="no_hp">Nomor HP</label>
                        <input type="tel" id="no_hp" name="no_hp" class="form-input"
                            placeholder="+62 812 3456 7890" value="{{ old('no_hp') }}">
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="password">Password</label>
                            <input type="password" id="password" name="password" class="form-input"
                                placeholder="Masukan Password" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="form-input" placeholder="Ulangi password" required>
                        </div>
                    </div>

                    <div class="terms">
                        <input type="checkbox" id="terms" name="terms" required>
                        <label for="terms">Saya menyetujui <a href="#">Syarat & Ketentuan</a> dan <a
                                href="#">Kebijakan
                                Privasi</a></label>
                    </div>

                    <button type="submit" class="btn btn-primary">Daftar Sekarang</button>
                </form>

                <div class="login-link">
                    Sudah punya akun? <a href="{{ route('login') }}">Masuk</a>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/animation.js') }}"></script>
</body>

</html>
