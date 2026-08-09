<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tambah Bank - BeautyCare</title>
    @include('partials.head-meta')
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">

    <style>
        .sidebar-toggle { display: none; background: none; border: none; cursor: pointer; padding: 8px; }
        .sidebar-toggle svg { width: 24px; height: 24px; color: var(--dark); }
        .sidebar-overlay { display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.3); z-index: 90; }
        .sidebar-overlay.active { display: block; }
        @media (max-width: 768px) { .sidebar-toggle { display: flex; align-items: center; } }
    </style>
    <style>
        body { font-family: 'Poppins', sans-serif; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        .float-icon { position: absolute; pointer-events: none; opacity: 0.1; font-size: 80px; }
        .form-input-custom { border: 1.5px solid #ECECEC; border-radius: 12px; padding: 10px 14px; font-size: 13px; width: 100%; transition: all 0.3s ease; font-family: 'Poppins', sans-serif; }
        .form-input-custom:focus { border-color: #FF4F87; box-shadow: 0 0 0 3px rgba(255,79,135,0.12); outline: none; }
        .form-input-custom::placeholder { color: #aaa; }
        .form-input-custom[readonly] { background-color: #f9f9f9; cursor: not-allowed; }
        select.form-input-custom { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23666' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 14px center; padding-right: 40px; }
        .form-label { font-size: 12px; font-weight: 600; color: #555; margin-bottom: 6px; display: block; }

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
            pointer-events: none.
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
            flex-shrink: 0.
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

        .preview-logo { width: 80px; height: 80px; border-radius: 16px; object-fit: cover; border: 2px dashed #ECECEC; }
    </style>
</head>

<body>
    <div class="dashboard-layout">
        @include('layouts.sidebar')

        <main class="main-content">
            @include('layouts.header2')


            <div class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 space-y-4 sm:space-y-6">

            <div class="page-header-premium">
                <div class="ph-content">
                    <div class="ph-left">
                        <div class="ph-icon-wrap">
                            <span class="nav-icon">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M5 18H19M5 18C3.89543 18 3 17.1046 3 16V8C3 6.89543 3.89543 6 5 6H19C20.1046 6 21 6.89543 21 8V16C21 17.1046 20.1046 18 19 18M5 18L5 20M19 18L19 20" />
                                    <circle cx="7" cy="14" r="1.5" fill="currentColor" />
                                    <circle cx="17" cy="14" r="1.5" fill="currentColor" />
                                    <path d="M5 9H9V12H5V9Z" />
                                </svg>
                            </span>
                        </div>
                        <div class="ph-text">
                            <h3>Tambah Data Bank</h3>
                            <p>Tambah rekening bank untuk pembayaran transfer</p>
                        </div>
                    </div>
                </div>
            </div>

                @if (session('success'))
                <div class="mb-4 p-4 bg-emerald-50 border border-emerald-100 rounded-xl flex items-center gap-2 text-sm text-emerald-700">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check text-emerald-500"><circle cx="12" cy="12" r="10"></circle><path d="m9 12 2 2 4-4"></path></svg>
                    {{ session('success') }}
                </div>
                @endif

                @if ($errors->any())
                <div class="mb-4 p-4 bg-red-50 border border-red-100 rounded-xl flex items-center gap-2 text-sm text-red-700">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-x text-red-500"><circle cx="12" cy="12" r="10"></circle><path d="m15 9-6 6m0-6 6 6"></path></svg>
                    <div>
                        <p class="font-medium">Validasi gagal:</p>
                        <ul class="list-disc list-inside text-[11px] mt-1">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif

                <div class="bg-white rounded-2xl p-6 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] relative overflow-hidden">
                    <div class="float-icon" style="top:-15px;right:-10px;">🏦</div>

                    <div class="flex flex-wrap items-start sm:items-center justify-between gap-3 mb-6">
                        <div>
                            <h3 class="text-[16px] font-bold text-gray-800">
                                <i class="fa-solid fa-building-columns text-blue-500 mr-2"></i>Form Tambah Bank
                            </h3>
                            <p class="text-[12px] text-gray-400 mt-0.5">
                                <i class="fa-solid fa-circle-info text-pink-300 mr-1"></i>Isi data bank dengan lengkap
                            </p>
                        </div>
                        <a href="{{ route('admin.bank.index') }}"
                            class="flex items-center gap-2 border border-gray-200 text-gray-600 text-[12px] font-medium px-4 py-2 rounded-full hover:bg-gray-50 transition-colors">
                            <i class="fa-solid fa-arrow-left"></i> Kembali
                        </a>
                    </div>

                    <form action="{{ route('admin.bank.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- SECTION 1: Basic Info -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fa-solid fa-building-columns text-blue-400 mr-1"></i>Nama Bank <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="nama_bank"
                                    class="form-input-custom @error('nama_bank') border-red-400 @enderror"
                                    placeholder="Contoh: BCA, BRI, Mandiri" value="{{ old('nama_bank') }}">
                                @error('nama_bank')
                                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fa-solid fa-hashtag text-pink-400 mr-1"></i>Kode Bank (3 digit) <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="kode_bank" maxlength="3"
                                    class="form-input-custom @error('kode_bank') border-red-400 @enderror text-center"
                                    placeholder="Contoh: 014" value="{{ old('kode_bank') }}">
                                <p class="text-[11px] text-gray-400 mt-1">Kode standar Indonesia (BCA=014, BRI=002, dst). Wajib untuk tipe Transfer.</p>
                                @error('kode_bank')
                                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mt-5">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fa-solid fa-user-tie text-pink-400 mr-1"></i>Atas Nama <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="atas_nama"
                                    class="form-input-custom @error('atas_nama') border-red-400 @enderror"
                                    placeholder="Contoh: BeautyCare Official" value="{{ old('atas_nama', 'BeautyCare Official') }}">
                                @error('atas_nama')
                                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fa-solid fa-credit-card text-amber-400 mr-1"></i>Nomor Rekening
                                </label>
                                <input type="text" name="no_rekening"
                                    class="form-input-custom @error('no_rekening') border-red-400 @enderror"
                                    placeholder="Contoh: 1234567890" value="{{ old('no_rekening') }}">
                                @error('no_rekening')
                                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- SECTION 2: Tipe & Kontak -->
                        <div class="mt-6 pt-4 border-t border-gray-100">
                            <h4 class="text-[14px] font-bold text-gray-700 mb-4">
                                <i class="fa-solid fa-tag text-pink-500 mr-2"></i>Tipe Pembayaran & Kontak
                            </h4>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fa-solid fa-list text-pink-400 mr-1"></i>Tipe Bank <span class="text-red-500">*</span>
                                    </label>
                                    <select name="tipe" class="form-input-custom @error('tipe') border-red-400 @enderror">
                                        <option value="transfer" {{ old('tipe') == 'transfer' ? 'selected' : '' }}>Transfer (Virtual Account)</option>
                                        <option value="ewallet" {{ old('tipe') == 'ewallet' ? 'selected' : '' }}>E-Wallet</option>
                                        <option value="qris" {{ old('tipe') == 'qris' ? 'selected' : '' }}>QRIS</option>
                                    </select>
                                    @error('tipe')
                                        <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fa-solid fa-phone text-pink-400 mr-1"></i>Nomor Telepon
                                    </label>
                                    <input type="text" name="nomor_telepon"
                                        class="form-input-custom @error('nomor_telepon') border-red-400 @enderror"
                                        placeholder="+628xx-xxxx-xxxx" value="{{ old('nomor_telepon') }}">
                                    <p class="text-[11px] text-gray-400 mt-1">Wajib untuk tipe E-Wallet (format +62)</p>
                                    @error('nomor_telepon')
                                        <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="flex items-center gap-4 mt-4">
                                <div class="form-check">
                                    <input type="hidden" name="is_active" value="0">
                                    <input type="checkbox" name="is_active" id="is_active"
                                        class="w-4 h-4 text-pink-500 border-gray-300 rounded focus:ring-pink-500"
                                        {{ old('is_active', true) ? 'checked' : '' }} value="1">
                                    <label for="is_active" class="ml-2 text-sm font-medium text-gray-700">Aktifkan bank ini</label>
                                </div>
                            </div>
                        </div>

                        <!-- SECTION 3: Logo -->
                        <div class="mt-6 pt-4 border-t border-gray-100">
                            <h4 class="text-[14px] font-bold text-gray-700 mb-4">
                                <i class="fa-solid fa-image text-pink-500 mr-2"></i>Logo Bank
                            </h4>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fa-solid fa-upload text-pink-400 mr-1"></i>Upload Logo
                                    </label>
                                    <input type="file" name="logo" id="logo"
                                        class="form-input-custom @error('logo') border-red-400 @enderror"
                                        accept="image/jpeg,image/png,image/jpg,image/svg+xml">
                                    @error('logo')
                                        <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                    @enderror
                                    <p class="text-[11px] text-gray-400 mt-1">Format: JPG, PNG, SVG. Maks: 2MB</p>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Preview Logo</label>
                                    <div class="flex items-center gap-3">
                                        <img id="logoPreview" src="{{ asset('assets/img/bank-placeholder.svg') }}" alt="Preview Logo" class="preview-logo">
                                        <span class="text-sm text-gray-500">Logo akan ditampilkan di halaman pembayaran</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- SECTION 4: Submit -->
                        <div class="mt-6 pt-4 border-t border-gray-100 flex flex-wrap items-center justify-between gap-4">
                            <a href="{{ route('admin.bank.index') }}"
                                class="flex items-center gap-2 border border-gray-200 text-gray-600 text-[12px] font-medium px-5 py-2.5 rounded-full hover:bg-gray-50 transition-colors">
                                <i class="fa-solid fa-arrow-left"></i> Batal
                            </a>
                            <button type="submit"
                                class="flex items-center gap-2 bg-gradient-to-r from-[#EC4899] to-[#BE185D] text-white text-[13px] font-semibold px-6 py-2.5 rounded-full hover:shadow-md transition-all shadow-sm">
                                <i class="fa-regular fa-circle-check"></i> Simpan Data Bank
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Logo preview
        document.getElementById('logo').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('logoPreview').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>