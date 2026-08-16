<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Verifikasi Email - BeautyCare</title>
    @include('partials.head-meta')

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
            max-width: 440px;
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

        .login-card .lc-header .otp-icon {
            width: 72px;
            height: 72px;
            margin: 0 auto 16px;
            border-radius: 50%;
            background: linear-gradient(135deg, #FFE4EC 0%, #FFD1DF 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            color: var(--primary);
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
            line-height: 1.7;
        }

        .login-card .lc-header p strong {
            color: var(--dark);
            word-break: break-all;
        }

        .otp-input-wrap {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 24px;
        }

        .otp-input-wrap input {
            width: 52px;
            height: 56px;
            text-align: center;
            font-size: 24px;
            font-weight: var(--fw-bold);
            color: var(--dark);
            border: 2px solid var(--border);
            border-radius: var(--radius-md);
            background: var(--white);
            transition: var(--transition-base);
            outline: none;
            caret-color: var(--primary);
        }

        .otp-input-wrap input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(255, 79, 135, 0.15);
        }

        .otp-input-wrap input:disabled {
            background: #f5f5f5;
            cursor: not-allowed;
        }

        .login-card .btn {
            width: 100%;
            padding: 14px;
            font-size: 15px;
        }

        .login-card .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .resend-section {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: var(--gray);
        }

        .resend-section .timer {
            font-weight: var(--fw-semibold);
            color: var(--primary);
        }

        .resend-section button {
            background: none;
            border: none;
            color: var(--primary);
            font-weight: var(--fw-semibold);
            font-size: 14px;
            cursor: pointer;
            padding: 0;
        }

        .resend-section button:disabled {
            color: #bbb;
            cursor: not-allowed;
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

        .login-card .alert-info {
            background: #FFF7E6;
            color: #92400E;
            border: 1px solid #FCD34D;
            font-size: 13px;
            line-height: 1.6;
        }

        .login-card .back-link {
            display: block;
            text-align: center;
            margin-top: 24px;
            font-size: 14px;
            color: var(--gray);
        }

        .login-card .back-link a {
            color: var(--primary);
            font-weight: var(--fw-medium);
        }

        .login-card .back-link a:hover {
            text-decoration: underline;
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
            .otp-input-wrap input {
                width: 44px;
                height: 50px;
                font-size: 20px;
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
                <h2>Verifikasi Email Anda</h2>
                <p>Masukkan kode verifikasi yang kami kirim ke email Anda untuk mengaktifkan akun BeautyCare.</p>
            </div>
        </div>

        <div class="login-right">
            <div class="login-card">
                <div class="lc-header">
                    <div class="otp-icon">
                        <i class="fa-solid fa-envelope-open-text"></i>
                    </div>
                    <h2>Kode Verifikasi</h2>
                    <p>Kode 6 digit telah dikirim ke<br><strong>{{ $email }}</strong></p>
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

                <div class="alert alert-info">
                    <i class="fa-solid fa-circle-info"></i> Tidak menerima kode? Periksa folder Spam/Promosi di email Anda, lalu klik "Kirim Ulang Kode".
                </div>

                <form method="POST" action="{{ route('verification.otp.verify') }}" id="otpForm">
                    @csrf
                    <input type="hidden" name="email" value="{{ $email }}">

                    <div class="otp-input-wrap">
                        <input type="text" inputmode="numeric" maxlength="1" autocomplete="one-time-code" class="otp-digit" required autofocus>
                        <input type="text" inputmode="numeric" maxlength="1" autocomplete="one-time-code" class="otp-digit" required>
                        <input type="text" inputmode="numeric" maxlength="1" autocomplete="one-time-code" class="otp-digit" required>
                        <input type="text" inputmode="numeric" maxlength="1" autocomplete="one-time-code" class="otp-digit" required>
                        <input type="text" inputmode="numeric" maxlength="1" autocomplete="one-time-code" class="otp-digit" required>
                        <input type="text" inputmode="numeric" maxlength="1" autocomplete="one-time-code" class="otp-digit" required>
                    </div>

                    <button type="submit" class="btn btn-primary" id="btnVerify" disabled>Verifikasi</button>
                </form>

                <div class="resend-section">
                    Belum menerima kode?
                    <form method="POST" action="{{ route('verification.otp.resend') }}" style="display: inline;">
                        @csrf
                        <input type="hidden" name="email" value="{{ $email }}">
                        <button type="submit" id="btnResend" disabled>Kirim Ulang Kode</button>
                    </form>
                    <div class="timer" id="timerText"></div>
                </div>

                <div class="back-link">
                    <a href="{{ route('login') }}"><i class="fa-solid fa-arrow-left"></i> Kembali ke halaman masuk</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        const digits = document.querySelectorAll('.otp-digit');
        const btnVerify = document.getElementById('btnVerify');
        const btnResend = document.getElementById('btnResend');
        const timerText = document.getElementById('timerText');
        let resendCooldown = 60;

        digits.forEach((input, index) => {
            input.addEventListener('input', function () {
                this.value = this.value.replace(/\D/g, '').slice(0, 1);
                if (this.value && index < digits.length - 1) {
                    digits[index + 1].focus();
                }
                updateVerifyState();
            });

            input.addEventListener('keydown', function (e) {
                if (e.key === 'Backspace' && !this.value && index > 0) {
                    digits[index - 1].focus();
                }
            });

            input.addEventListener('paste', function (e) {
                e.preventDefault();
                const paste = (e.clipboardData || window.clipboardData).getData('text').replace(/\D/g, '').slice(0, 6);
                for (let i = 0; i < paste.length && index + i < digits.length; i++) {
                    digits[index + i].value = paste[i];
                }
                if (index + paste.length < digits.length) {
                    digits[index + paste.length].focus();
                }
                updateVerifyState();
            });
        });

        function updateVerifyState() {
            let filled = 0;
            digits.forEach(d => { if (d.value) filled++; });
            btnVerify.disabled = filled < 6;
        }

        document.getElementById('otpForm').addEventListener('submit', function () {
            let code = '';
            digits.forEach(d => { code += d.value; });
            const hidden = document.createElement('input');
            hidden.type = 'hidden';
            hidden.name = 'code';
            hidden.value = code;
            this.appendChild(hidden);
        });

        function startTimer() {
            resendCooldown = 60;
            btnResend.disabled = true;
            const interval = setInterval(() => {
                resendCooldown--;
                timerText.textContent = 'Kirim ulang dalam ' + resendCooldown + ' detik';
                if (resendCooldown <= 0) {
                    clearInterval(interval);
                    btnResend.disabled = false;
                    timerText.textContent = '';
                }
            }, 1000);
        }

        startTimer();
    </script>
    <script src="{{ asset('assets/js/animation.js') }}"></script>
</body>
</html>
