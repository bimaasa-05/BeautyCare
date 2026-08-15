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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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
            cursor: pointer;
        }

        .legal-modal {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 1000;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background: rgba(31, 41, 55, 0.6);
            backdrop-filter: blur(4px);
        }

        .legal-modal.active {
            display: flex;
        }

        .legal-modal .modal-card {
            width: 100%;
            max-width: 620px;
            max-height: 80vh;
            display: flex;
            flex-direction: column;
            background: var(--white);
            border-radius: 20px;
            box-shadow: 0 24px 64px rgba(0, 0, 0, 0.25);
            animation: modalIn 0.3s ease-out;
            overflow: hidden;
        }

        .legal-modal .modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 20px 24px;
            background: linear-gradient(135deg, #FF4F87 0%, #FF7BA6 100%);
            color: #fff;
            flex-shrink: 0;
        }

        .legal-modal .modal-header h3 {
            margin: 0;
            font-size: 18px;
            font-weight: var(--fw-bold);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .legal-modal .modal-close {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: #fff;
            width: 34px;
            height: 34px;
            border-radius: 50%;
            font-size: 18px;
            line-height: 1;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s;
            flex-shrink: 0;
        }

        .legal-modal .modal-close:hover {
            background: rgba(255, 255, 255, 0.35);
        }

        .legal-modal .modal-body {
            padding: 24px;
            overflow-y: auto;
            font-size: 13.5px;
            line-height: 1.8;
            color: #374151;
            white-space: pre-line;
        }

        .legal-modal .modal-footer {
            padding: 16px 24px;
            border-top: 1px solid #F3F4F6;
            display: flex;
            justify-content: flex-end;
            flex-shrink: 0;
        }

        .legal-modal .modal-footer .btn {
            padding: 10px 24px;
            font-size: 14px;
        }

        @keyframes modalIn {
            from {
                opacity: 0;
                transform: translateY(24px) scale(0.97);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
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

        .form-group .input-icon-wrap {
            position: relative;
        }

        .form-group .input-icon-wrap .toggle-pw {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #bbb;
            font-size: 15px;
            padding: 4px;
            transition: color 0.2s ease;
            line-height: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .form-group .input-icon-wrap .toggle-pw i {
            display: block;
        }

        .form-group .input-icon-wrap .toggle-pw:hover {
            color: var(--primary);
        }

        .form-group .input-icon-wrap input[type="password"],
        .form-group .input-icon-wrap input[type="text"] {
            padding-right: 44px;
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
                    <img src="{{ asset('assets/images/logo/logo.jpeg') }}" alt="BeautyCare Logo" width="100" height="100" style="border-radius: 23px;">
                    <span>BeautyCare</span>
                </div>
                <h2>Mulai Perjalanan Anda</h2>
                <p>Daftar untuk booking treatment, belanja produk, dapatkan promo menarik, dan nikmati benefit
                    membership BeautyCare.</p>
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
                            <div class="input-icon-wrap">
                                <input type="password" id="password" name="password" class="form-input"
                                    placeholder="Masukan Password" minlength="6" required>
                                <button type="button" class="toggle-pw" onclick="togglePassword(this)" tabindex="-1"><i class="fa-solid fa-eye"></i></button>
                            </div>
                            <div class="pw-meter" id="pwMeterRegister">
                                <div class="pw-bar"><span></span><span></span><span></span><span></span></div>
                                <div class="pw-info"><span class="pw-label"></span><span class="pw-hint"></span></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
                            <div class="input-icon-wrap">
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    class="form-input" placeholder="Ulangi password" minlength="6" required>
                                <button type="button" class="toggle-pw" onclick="togglePassword(this)" tabindex="-1"><i class="fa-solid fa-eye"></i></button>
                            </div>
                        </div>
                    </div>

                    <div class="terms">
                        <input type="checkbox" id="terms" name="terms" required>
                        <label for="terms">Saya menyetujui <a href="#" data-modal="modal-terms">Syarat & Ketentuan</a>
                            dan <a href="#" data-modal="modal-privacy">Kebijakan
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

    <div class="legal-modal" id="modal-terms">
        <div class="modal-card">
            <div class="modal-header">
                <h3>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                        <polyline points="14 2 14 8 20 8" />
                        <line x1="16" y1="13" x2="8" y2="13" />
                        <line x1="16" y1="17" x2="8" y2="17" />
                    </svg>
                    Syarat &amp; Ketentuan
                </h3>
                <button type="button" class="modal-close">&times;</button>
            </div>
            <div class="modal-body">
                @if ($pengaturan && $pengaturan->syarat_ketentuan)
                    {{ $pengaturan->syarat_ketentuan }}
                @else
                    <p>Konten Syarat &amp; Ketentuan belum tersedia.</p>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary modal-close">Tutup</button>
            </div>
        </div>
    </div>

    <div class="legal-modal" id="modal-privacy">
        <div class="modal-card">
            <div class="modal-header">
                <h3>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                        <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                    </svg>
                    Kebijakan Privasi
                </h3>
                <button type="button" class="modal-close">&times;</button>
            </div>
            <div class="modal-body">
                @if ($pengaturan && $pengaturan->kebijakan_privasi)
                    {{ $pengaturan->kebijakan_privasi }}
                @else
                    <p>Konten Kebijakan Privasi belum tersedia.</p>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary modal-close">Tutup</button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const openers = document.querySelectorAll('[data-modal]');
            const modals = document.querySelectorAll('.legal-modal');

            const openModal = (id) => {
                const modal = document.getElementById(id);
                if (modal) modal.classList.add('active');
                document.body.style.overflow = 'hidden';
            };

            const closeModals = () => {
                modals.forEach(m => m.classList.remove('active'));
                document.body.style.overflow = '';
            };

            openers.forEach(link => {
                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    openModal(link.dataset.modal);
                });
            });

            modals.forEach(modal => {
                modal.querySelectorAll('.modal-close').forEach(btn => {
                    btn.addEventListener('click', closeModals);
                });
                modal.addEventListener('click', (e) => {
                    if (e.target === modal) closeModals();
                });
            });

            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') closeModals();
            });
        });
    </script>

    @include('partials.password-strength')
    <script src="{{ asset('assets/js/animation.js') }}"></script>
    <script>
        function togglePassword(btn) {
            const input = btn.parentElement.querySelector('input');
            const icon = btn.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'fa-solid fa-eye-slash';
            } else {
                input.type = 'password';
                icon.className = 'fa-solid fa-eye';
            }
        }

        initPasswordStrength(document.getElementById('password'), 'pwMeterRegister');
    </script>
</body>

</html>
