<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pengaturan - BeautyCare</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">

    <style>
        .sidebar-toggle {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            padding: 8px;
        }

        .sidebar-toggle svg {
            width: 24px;
            height: 24px;
            color: var(--dark);
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.3);
            z-index: 90;
        }

        .sidebar-overlay.active {
            display: block;
        }

        @media (max-width: 768px) {
            .sidebar-toggle {
                display: flex;
                align-items: center;
            }
        }
    </style>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</head>

<body>
    <div class="dashboard-layout">
        @include('layouts.sidebar')

        <main class="main-content">
            @include('layouts.header2')

            <div class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
                <form id="formPengaturan" method="POST" action="{{ route('admin.pengaturan.update') }}">
                    @csrf
                    <div class="max-w-xl space-y-4">

                        <!-- Card: Notifikasi -->
                        <div class="bg-white rounded-2xl border border-pink-50 shadow-[0_2px_16px_rgba(236,72,153,0.07)] p-5">
                            <h3 class="font-bold text-gray-800 mb-4">Notifikasi</h3>
                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-semibold text-gray-700">Push Notification</p>
                                        <p class="text-xs text-gray-400">Notifikasi booking &amp; transaksi</p>
                                    </div>
                                    <input type="hidden" name="push_notification" value="{{ $pengaturan->push_notification ? '1' : '0' }}">
                                    <button type="button" class="toggle-btn w-11 h-6 rounded-full transition-all duration-300 relative {{ $pengaturan->push_notification ? 'bg-gradient-to-r from-[#EC4899] to-[#BE185D]' : 'bg-gray-200' }}" data-active="{{ $pengaturan->push_notification ? 'true' : 'false' }}">
                                        <div class="toggle-circle absolute top-1 w-4 h-4 bg-white rounded-full shadow transition-all duration-300 {{ $pengaturan->push_notification ? 'left-6' : 'left-1' }}"></div>
                                    </button>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-semibold text-gray-700">SMS Notifikasi</p>
                                        <p class="text-xs text-gray-400">Kirim SMS ke pelanggan otomatis</p>
                                    </div>
                                    <input type="hidden" name="sms_notifikasi" value="{{ $pengaturan->sms_notifikasi ? '1' : '0' }}">
                                    <button type="button" class="toggle-btn w-11 h-6 rounded-full transition-all duration-300 relative {{ $pengaturan->sms_notifikasi ? 'bg-gradient-to-r from-[#EC4899] to-[#BE185D]' : 'bg-gray-200' }}" data-active="{{ $pengaturan->sms_notifikasi ? 'true' : 'false' }}">
                                        <div class="toggle-circle absolute top-1 w-4 h-4 bg-white rounded-full shadow transition-all duration-300 {{ $pengaturan->sms_notifikasi ? 'left-6' : 'left-1' }}"></div>
                                    </button>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-semibold text-gray-700">Email Laporan</p>
                                        <p class="text-xs text-gray-400">Laporan harian via email</p>
                                    </div>
                                    <input type="hidden" name="email_laporan" value="{{ $pengaturan->email_laporan ? '1' : '0' }}">
                                    <button type="button" class="toggle-btn w-11 h-6 rounded-full transition-all duration-300 relative {{ $pengaturan->email_laporan ? 'bg-gradient-to-r from-[#EC4899] to-[#BE185D]' : 'bg-gray-200' }}" data-active="{{ $pengaturan->email_laporan ? 'true' : 'false' }}">
                                        <div class="toggle-circle absolute top-1 w-4 h-4 bg-white rounded-full shadow transition-all duration-300 {{ $pengaturan->email_laporan ? 'left-6' : 'left-1' }}"></div>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Card: Operasional -->
                        <div class="bg-white rounded-2xl border border-pink-50 shadow-[0_2px_16px_rgba(236,72,153,0.07)] p-5">
                            <h3 class="font-bold text-gray-800 mb-4">Operasional</h3>
                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-semibold text-gray-700">Konfirmasi Otomatis</p>
                                        <p class="text-xs text-gray-400">Booking auto-confirm jika tersedia</p>
                                    </div>
                                    <input type="hidden" name="konfirmasi_otomatis" value="{{ $pengaturan->konfirmasi_otomatis ? '1' : '0' }}">
                                    <button type="button" class="toggle-btn w-11 h-6 rounded-full transition-all duration-300 relative {{ $pengaturan->konfirmasi_otomatis ? 'bg-gradient-to-r from-[#EC4899] to-[#BE185D]' : 'bg-gray-200' }}" data-active="{{ $pengaturan->konfirmasi_otomatis ? 'true' : 'false' }}">
                                        <div class="toggle-circle absolute top-1 w-4 h-4 bg-white rounded-full shadow transition-all duration-300 {{ $pengaturan->konfirmasi_otomatis ? 'left-6' : 'left-1' }}"></div>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Card: Informasi Salon -->
                        <div class="bg-white rounded-2xl border border-pink-50 shadow-[0_2px_16px_rgba(236,72,153,0.07)] p-5">
                            <h3 class="font-bold text-gray-800 mb-4">Informasi Salon</h3>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="text-[10px] font-bold text-gray-400 mb-1.5 block uppercase">Nama Salon</label>
                                    <input type="text" name="nama_salon" value="{{ $pengaturan->nama_salon }}" class="w-full px-3 py-2.5 bg-[#FFF7FA] border border-pink-100 rounded-xl text-sm focus:outline-none focus:border-pink-400 text-gray-700 font-medium">
                                </div>
                                <div>
                                    <label class="text-[10px] font-bold text-gray-400 mb-1.5 block uppercase">Telepon</label>
                                    <input type="text" name="telepon" value="{{ $pengaturan->telepon }}" class="w-full px-3 py-2.5 bg-[#FFF7FA] border border-pink-100 rounded-xl text-sm focus:outline-none focus:border-pink-400 text-gray-700 font-medium">
                                </div>
                                <div>
                                    <label class="text-[10px] font-bold text-gray-400 mb-1.5 block uppercase">Jam Buka</label>
                                    <input type="time" name="jam_buka" value="{{ $pengaturan->jam_buka ? substr($pengaturan->jam_buka, 0, 5) : '08:00' }}" class="w-full px-3 py-2.5 bg-[#FFF7FA] border border-pink-100 rounded-xl text-sm focus:outline-none focus:border-pink-400 text-gray-700 font-medium">
                                </div>
                                <div>
                                    <label class="text-[10px] font-bold text-gray-400 mb-1.5 block uppercase">Jam Tutup</label>
                                    <input type="time" name="jam_tutup" value="{{ $pengaturan->jam_tutup ? substr($pengaturan->jam_tutup, 0, 5) : '20:00' }}" class="w-full px-3 py-2.5 bg-[#FFF7FA] border border-pink-100 rounded-xl text-sm focus:outline-none focus:border-pink-400 text-gray-700 font-medium">
                                </div>
                            </div>
                            <button type="submit" class="mt-4 px-5 py-2.5 bg-gradient-to-r from-[#EC4899] to-[#BE185D] text-white font-bold rounded-xl shadow-sm hover:opacity-95 transition-all text-sm">Simpan Pengaturan</button>
                        </div>

                    </div>
                </form>
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggleButtons = document.querySelectorAll('.toggle-btn');

            toggleButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    const isActive = this.getAttribute('data-active') === 'true';
                    const circle = this.querySelector('.toggle-circle');
                    const hiddenInput = this.parentElement.querySelector('input[type="hidden"]');

                    if (isActive) {
                        this.setAttribute('data-active', 'false');
                        this.classList.remove('bg-gradient-to-r', 'from-[#EC4899]', 'to-[#BE185D]');
                        this.classList.add('bg-gray-200');
                        circle.classList.remove('left-6');
                        circle.classList.add('left-1');
                        if (hiddenInput) hiddenInput.value = '0';
                    } else {
                        this.setAttribute('data-active', 'true');
                        this.classList.remove('bg-gray-200');
                        this.classList.add('bg-gradient-to-r', 'from-[#EC4899]', 'to-[#BE185D]');
                        circle.classList.remove('left-1');
                        circle.classList.add('left-6');
                        if (hiddenInput) hiddenInput.value = '1';
                    }
                });
            });

            // Toast notification from session
            const toastEl = document.getElementById('session-toast');
            if (toastEl) {
                showToast(toastEl.dataset.message, toastEl.dataset.type || 'success');
            }
            @if (session('success'))
                showToast('{{ session('success') }}', 'success');
            @endif
        });

        function showToast(message, type) {
            const bgColor = type === 'success' ? 'bg-green-500' :
                type === 'error' ? 'bg-red-500' :
                type === 'warning' ? 'bg-yellow-500' : 'bg-blue-500';

            const toast = document.createElement('div');
            toast.className = `fixed top-4 right-4 ${bgColor} text-white px-5 py-3 rounded-xl shadow-lg text-sm font-semibold z-[9999] transition-all duration-300 translate-x-0`;
            toast.textContent = message;
            document.body.appendChild(toast);

            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translateX(100%)';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        const now = new Date();
        const options = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        };
        const dateEl = document.getElementById('currentDate');
        if (dateEl) dateEl.textContent = now.toLocaleDateString('id-ID', options);
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>
