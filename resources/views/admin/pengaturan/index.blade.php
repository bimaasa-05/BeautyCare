<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pengaturan - BeautyCare</title>
    @include('partials.head-meta')
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

        .page-header-premium {
            background: linear-gradient(135deg, #FFF5F8 0%, #FFE5EF 50%, #FFD6E6 100%);
            border-radius: 20px;
            padding: 28px 32px;
            margin-bottom: 24px;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255, 79, 135, 0.08);
        }

        .page-header-premium::before {
            content: '';
            position: absolute;
            top: -60px;
            right: -60px;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255, 79, 135, 0.12) 0%, transparent 70%);
            pointer-events: none;
        }

        .page-header-premium::after {
            content: '';
            position: absolute;
            bottom: -40px;
            left: 30%;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255, 79, 135, 0.08) 0%, transparent 70%);
            pointer-events: none;
        }

        .page-header-premium .ph-content {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .page-header-premium .ph-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .page-header-premium .ph-icon-wrap {
            width: 52px;
            height: 52px;
            border-radius: 16px;
            background: linear-gradient(135deg, var(--primary), #FF7BA6);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 22px;
            box-shadow: 0 6px 20px rgba(255, 79, 135, 0.3);
            flex-shrink: 0;
        }

        .page-header-premium .ph-text h3 {
            font-size: 20px;
            font-weight: 700;
            color: var(--dark);
            margin: 0;
        }

        .page-header-premium .ph-text p {
            font-size: 13px;
            color: var(--gray);
            margin: 2px 0 0;
        }

    </style>
</head>

<body>
    <div class="dashboard-layout">
        @include('layouts.sidebar')

        <main class="main-content">
            @include('layouts.header2')


            <div class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">

            <div class="page-header-premium">
                <div class="ph-content">
                    <div class="ph-left">
                        <div class="ph-icon-wrap">
                            <span class="nav-icon">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="3"></circle>
                                    <path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"></path>
                                </svg>
                            </span>
                        </div>
                        <div class="ph-text">
                            <h3>Pengaturan</h3>
                            <p>Konfigurasi pengaturan aplikasi BeautyCare sesuai kebutuhan.</p>
                        </div>
                    </div>
                </div>
            </div>
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

                        <!-- Card: Syarat & Ketentuan -->
                        <div class="bg-white rounded-2xl border border-pink-50 shadow-[0_2px_16px_rgba(236,72,153,0.07)] p-5">
                            <h3 class="font-bold text-gray-800 mb-4">Syarat &amp; Ketentuan</h3>
                            <p class="text-xs text-gray-400 mb-3">Konten ini ditampilkan di halaman publik Syarat &amp; Ketentuan.</p>
                            <textarea name="syarat_ketentuan" rows="10"
                                class="w-full px-3 py-2.5 bg-[#FFF7FA] border border-pink-100 rounded-xl text-sm focus:outline-none focus:border-pink-400 text-gray-700 font-medium leading-relaxed"
                                placeholder="Tulis syarat & ketentuan di sini...">{{ $pengaturan->syarat_ketentuan }}</textarea>
                        </div>

                        <!-- Card: Kebijakan Privasi -->
                        <div class="bg-white rounded-2xl border border-pink-50 shadow-[0_2px_16px_rgba(236,72,153,0.07)] p-5">
                            <h3 class="font-bold text-gray-800 mb-4">Kebijakan Privasi</h3>
                            <p class="text-xs text-gray-400 mb-3">Konten ini ditampilkan di halaman publik Kebijakan Privasi.</p>
                            <textarea name="kebijakan_privasi" rows="10"
                                class="w-full px-3 py-2.5 bg-[#FFF7FA] border border-pink-100 rounded-xl text-sm focus:outline-none focus:border-pink-400 text-gray-700 font-medium leading-relaxed"
                                placeholder="Tulis kebijakan privasi di sini...">{{ $pengaturan->kebijakan_privasi }}</textarea>
                        </div>

                        <!-- Card: Kategori Pusat Bantuan -->
                        <div class="bg-white rounded-2xl border border-pink-50 shadow-[0_2px_16px_rgba(236,72,153,0.07)] p-5">
                            <h3 class="font-bold text-gray-800 mb-1">Kategori Pusat Bantuan</h3>
                            <p class="text-xs text-gray-400 mb-4">Kelola kategori untuk mengelompokkan pertanyaan di halaman Pusat Bantuan.</p>
                            <div id="kategori-rows" class="space-y-2"></div>
                            <button type="button" id="btn-tambah-kategori"
                                style="margin-top:12px;padding:8px 16px;background:#FFF0F5;border:1px solid #F9A8C9;color:#DB2777;font-weight:700;border-radius:12px;font-size:12px;cursor:pointer;transition:background 0.2s;"
                                onmouseover="this.style.background='#FFE3EC'" onmouseout="this.style.background='#FFF0F5'">+ Tambah Kategori</button>
                            <input type="hidden" name="pusat_bantuan_kategori" id="pusat_bantuan_kategori" value="">
                        </div>

                        <!-- Card: FAQ Pusat Bantuan -->
                        <div class="bg-white rounded-2xl border border-pink-50 shadow-[0_2px_16px_rgba(236,72,153,0.07)] p-5">
                            <h3 class="font-bold text-gray-800 mb-1">FAQ Pusat Bantuan</h3>
                            <p class="text-xs text-gray-400 mb-4">Kelola pertanyaan &amp; jawaban yang tampil di halaman Pusat Bantuan.</p>
                            <div id="faq-rows"></div>
                            <button type="button" id="btn-tambah-faq"
                                style="margin-top:12px;padding:8px 16px;background:#FFF0F5;border:1px solid #F9A8C9;color:#DB2777;font-weight:700;border-radius:12px;font-size:12px;cursor:pointer;transition:background 0.2s;"
                                onmouseover="this.style.background='#FFE3EC'" onmouseout="this.style.background='#FFF0F5'">+ Tambah FAQ</button>
                            <input type="hidden" name="pusat_bantuan_faq" id="pusat_bantuan_faq" value="">
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
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const kategoriState = @json(json_decode($pengaturan->pusat_bantuan_kategori ?? '[]', true) ?: []);
            const faqState = @json(json_decode($pengaturan->pusat_bantuan_faq ?? '[]', true) ?: []);

            const kategoriRows = document.getElementById('kategori-rows');
            const faqRows = document.getElementById('faq-rows');

            const inputCls =
                'w-full px-3 py-2.5 bg-[#FFF7FA] border border-pink-100 rounded-xl text-sm focus:outline-none focus:border-pink-400 text-gray-700 font-medium';
            const labelCls = 'text-[10px] font-bold text-gray-400 mb-1 block uppercase';

            const kategoriNames = () =>
                Array.from(kategoriRows.querySelectorAll('.kategori-input')).map(i => i.value.trim()).filter(Boolean);

            const esc = (s) => String(s || '').replace(/[&<>"']/g, (c) => ({
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#39;'
            }[c]));

            const buildFaqSelect = (selected) => {
                const names = kategoriNames();
                let opts = '<option value="" disabled>-- Pilih kategori --</option>';
                names.forEach(n => {
                    opts += `<option value="${esc(n)}" ${selected === n ? 'selected' : ''}>${esc(n)}</option>`;
                });
                return opts;
            };

            const renderKategori = () => {
                kategoriRows.innerHTML = '';
                kategoriState.forEach((k, i) => {
                    const row = document.createElement('div');
                    row.className = 'flex items-center gap-2';
                    row.innerHTML = `
                        <input type="text" class="kategori-input flex-1 ${inputCls}" placeholder="Nama kategori" value="${esc(k.nama)}">
                        <button type="button" class="remove-kategori px-3 py-2.5 rounded-xl bg-red-50 text-red-500 text-xs font-bold hover:bg-red-100 transition-all" title="Hapus">Hapus</button>
                    `;
                    row.querySelector('.remove-kategori').addEventListener('click', () => {
                        kategoriState.splice(i, 1);
                        renderKategori();
                        renderFaq();
                    });
                    kategoriRows.appendChild(row);
                });
            };

            const renderFaq = () => {
                faqRows.innerHTML = '';
                faqState.forEach((f, i) => {
                    const row = document.createElement('div');
                    row.className = 'faq-row border border-pink-100 rounded-xl p-3 mb-3 bg-[#FFFCFD]';
                    row.innerHTML = `
                        <div class="grid grid-cols-1 sm:grid-cols-[1fr_auto] gap-2 mb-2">
                            <div>
                                <label class="${labelCls}">Kategori</label>
                                <select class="faq-kategori w-full px-3 py-2.5 bg-white border border-pink-100 rounded-xl text-sm focus:outline-none focus:border-pink-400 text-gray-700 font-medium">
                                    ${buildFaqSelect(f.kategori || '')}
                                </select>
                            </div>
                            <div class="flex items-end">
                                <button type="button" class="remove-faq px-3 py-2.5 rounded-xl bg-red-50 text-red-500 text-xs font-bold hover:bg-red-100 transition-all" title="Hapus">Hapus</button>
                            </div>
                        </div>
                        <div class="mb-2">
                            <label class="${labelCls}">Pertanyaan</label>
                            <input type="text" class="faq-pertanyaan ${inputCls}" placeholder="Tulis pertanyaan..." value="${esc(f.pertanyaan)}">
                        </div>
                        <div>
                            <label class="${labelCls}">Jawaban</label>
                            <textarea rows="3" class="faq-jawaban w-full px-3 py-2.5 bg-[#FFF7FA] border border-pink-100 rounded-xl text-sm focus:outline-none focus:border-pink-400 text-gray-700 font-medium leading-relaxed" placeholder="Tulis jawaban...">${esc(f.jawaban)}</textarea>
                        </div>
                    `;
                    row.querySelector('.remove-faq').addEventListener('click', () => {
                        faqState.splice(i, 1);
                        renderFaq();
                    });
                    row.querySelector('.faq-kategori').addEventListener('change', (e) => {
                        f.kategori = e.target.value;
                    });
                    row.querySelector('.faq-pertanyaan').addEventListener('input', (e) => {
                        f.pertanyaan = e.target.value;
                    });
                    row.querySelector('.faq-jawaban').addEventListener('input', (e) => {
                        f.jawaban = e.target.value;
                    });
                    faqRows.appendChild(row);
                });
            };

            kategoriRows.addEventListener('input', (e) => {
                if (e.target.classList.contains('kategori-input')) {
                    const idx = Array.from(kategoriRows.children).indexOf(e.target.closest('.flex'));
                    kategoriState[idx].nama = e.target.value;
                }
            });

            document.getElementById('btn-tambah-kategori').addEventListener('click', () => {
                kategoriState.push({ nama: '' });
                renderKategori();
                renderFaq();
            });

            document.getElementById('btn-tambah-faq').addEventListener('click', () => {
                faqState.push({ kategori: '', pertanyaan: '', jawaban: '' });
                renderFaq();
            });

            document.getElementById('formPengaturan').addEventListener('submit', () => {
                const kategori = [];
                kategoriRows.querySelectorAll('.kategori-input').forEach(i => {
                    if (i.value.trim()) kategori.push({ nama: i.value.trim() });
                });
                const faq = [];
                faqRows.querySelectorAll('.faq-row').forEach(r => {
                    const faqKategori = r.querySelector('.faq-kategori').value;
                    const pertanyaan = r.querySelector('.faq-pertanyaan').value.trim();
                    const jawaban = r.querySelector('.faq-jawaban').value.trim();
                    if (faqKategori && pertanyaan && jawaban) {
                        faq.push({ kategori: faqKategori, pertanyaan, jawaban });
                    }
                });
                document.getElementById('pusat_bantuan_kategori').value = JSON.stringify(kategori);
                document.getElementById('pusat_bantuan_faq').value = JSON.stringify(faq);
            });

            renderKategori();
            renderFaq();
        });
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>
