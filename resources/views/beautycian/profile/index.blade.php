<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Profile - BeautyCare</title>
    @include('partials.head-meta')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/beautycian.css') }}">
    <style>
        .profile-grid { display: grid; grid-template-columns: 340px 1fr; gap: 24px; }
        .profile-card { background: var(--white); border-radius: 20px; box-shadow: 0 2px 12px -4px rgba(0,0,0,0.06); overflow: hidden; }
        .profile-card .pc-header { padding: 20px 24px; border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: 12px; }
        .profile-card .pc-header .pc-icon { width: 36px; height: 36px; border-radius: 10px; background: var(--hover); color: var(--primary); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .profile-card .pc-header .pc-title { font-size: 16px; font-weight: 700; color: var(--dark); }
        .profile-card .pc-body { padding: 24px; }
        .avatar-section { text-align: center; }
        .avatar-section .avatar-wrap {
            position: relative; width: 140px; height: 140px; margin: 0 auto 16px;
            border-radius: 50%; overflow: hidden;
            box-shadow: 0 4px 20px rgba(255, 79, 135, 0.2);
            border: 4px solid var(--white); outline: 2px solid var(--hover);
        }
        .avatar-section .avatar-wrap img { width: 100%; height: 100%; object-fit: cover; }
        .avatar-section .avatar-overlay {
            position: absolute; inset: 0;
            background: rgba(0,0,0,0.45); display: flex; align-items: center; justify-content: center;
            opacity: 0; transition: opacity 0.3s ease; cursor: pointer; border-radius: 50%;
        }
        .avatar-section .avatar-wrap:hover .avatar-overlay { opacity: 1; }
        .avatar-section .avatar-overlay svg { color: #fff; }
        .avatar-section .avatar-name { font-size: 18px; font-weight: 700; color: var(--dark); margin-bottom: 2px; }
        .avatar-section .avatar-role { font-size: 12px; color: var(--gray); font-weight: 500; }
        .avatar-section .avatar-role .badge-role { display: inline-block; padding: 3px 14px; border-radius: 100px; background: var(--hover); color: var(--primary); font-size: 11px; font-weight: 600; }
        #fotoInput { display: none; }
        .form-group { margin-bottom: 20px; }
        .form-group:last-child { margin-bottom: 0; }
        .form-group label { display: block; font-size: 12px; font-weight: 600; color: var(--gray); margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.3px; }
        .form-group .form-control { width: 100%; padding: 11px 16px; border-radius: 12px; border: 1.5px solid var(--border); background: #FAFAFA; font-size: 13px; font-family: 'Poppins', sans-serif; color: var(--dark); transition: all 0.2s ease; outline: none; box-sizing: border-box; }
        .form-group .form-control:focus { border-color: var(--primary); background: #fff; box-shadow: 0 0 0 3px rgba(255, 79, 135, 0.1); }
        .form-group .form-control:disabled { background: #f5f5f5; color: #999; cursor: not-allowed; }
        .form-group .input-icon-wrap { position: relative; }
        .form-group .input-icon-wrap .input-icon { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #bbb; }
        .form-group .input-icon-wrap .form-control { padding-left: 40px; }
        .btn-primary-full { width: 100%; padding: 12px 24px; border-radius: 12px; border: none; background: linear-gradient(135deg, var(--primary), #FF7BA6); color: #fff; font-size: 13px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; font-family: 'Poppins', sans-serif; box-shadow: 0 4px 16px rgba(255, 79, 135, 0.25); display: inline-flex; align-items: center; justify-content: center; gap: 8px; }
        .btn-primary-full:hover { transform: translateY(-2px); box-shadow: 0 6px 24px rgba(255, 79, 135, 0.35); }
        .info-row { display: flex; align-items: center; padding: 14px 0; border-bottom: 1px solid #F5F5F5; }
        .info-row:last-child { border-bottom: none; }
        .info-row .ir-icon { width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-right: 14px; }
        .info-row .ir-icon.email { background: #DBEAFE; color: #2563EB; }
        .info-row .ir-icon.phone { background: #D1FAE5; color: #059669; }
        .info-row .ir-icon.calendar { background: #FEF3C7; color: #D97706; }
        .info-row .ir-content { flex: 1; }
        .info-row .ir-content .ir-label { font-size: 11px; color: var(--gray); font-weight: 500; text-transform: uppercase; letter-spacing: 0.3px; }
        .info-row .ir-content .ir-value { font-size: 14px; font-weight: 600; color: var(--dark); margin-top: 1px; }
        @media (max-width: 900px) { .profile-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <div class="dashboard-layout">
        @include('layouts.sidebar-beautycian')
        <main class="main-content">
            @include('layouts.header2')
            <div class="dashboard-content">
                <div class="page-header-premium">
                    <div class="ph-content">
                        <div class="ph-left">
                            <div class="ph-icon-wrap">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            </div>
                            <div class="ph-text"><h3>Profile Saya</h3><p>Kelola data diri dan pengaturan akun Anda</p></div>
                        </div>
                    </div>
                </div>

                @if(session('success'))
                <div class="alert-premium success">
                    <div class="alert-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    </div>
                    {{ session('success') }}
                </div>
                @endif
                @if($errors->any())
                <div class="alert-premium" style="background:linear-gradient(135deg,#FEF2F2,#FEE2E2);border:1px solid #FECACA;color:#991B1B;">
                    <div class="alert-icon" style="background:#FECACA;color:#DC2626;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    </div>
                    <ul style="margin:0;padding-left:16px;">@foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul>
                </div>
                @endif

                <div class="profile-grid">
                    <div>
                        <div class="profile-card">
                            <div class="pc-header">
                                <div class="pc-icon">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                </div>
                                <div class="pc-title">Foto Profil</div>
                            </div>
                            <div class="pc-body">
                                <div class="avatar-section">
                                    <form id="fotoForm" action="{{ route('beautycian.profile.update-foto') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="avatar-wrap" onclick="document.getElementById('fotoInput').click()">
                                            <img src="{{ auth()->user()->foto ? asset('storage/' . auth()->user()->foto) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->nama).'&background=FF4F87&color=fff&size=140' }}" alt="Foto Profil" id="profilePreview">
                                            <div class="avatar-overlay">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                                            </div>
                                        </div>
                                        <input type="file" id="fotoInput" name="foto" accept="image/jpeg,image/png,image/jpg" onchange="previewAndSubmit(this)">
                                    </form>
                                    <div class="avatar-name">{{ auth()->user()->nama }}</div>
                                    <div class="avatar-role"><span class="badge-role">{{ ucfirst(auth()->user()->role) }}</span></div>
                                </div>
                            </div>
                        </div>
                        <div class="profile-card" style="margin-top:24px;">
                            <div class="pc-header">
                                <div class="pc-icon">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                                </div>
                                <div class="pc-title">Info Akun</div>
                            </div>
                            <div class="pc-body" style="padding:8px 24px;">
                                <div class="info-row">
                                    <div class="ir-icon email">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                                    </div>
                                    <div class="ir-content"><div class="ir-label">Email</div><div class="ir-value">{{ auth()->user()->email }}</div></div>
                                </div>
                                <div class="info-row">
                                    <div class="ir-icon phone">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                    </div>
                                    <div class="ir-content"><div class="ir-label">No. Handphone</div><div class="ir-value">{{ auth()->user()->no_hp ?? '-' }}</div></div>
                                </div>
                                <div class="info-row">
                                    <div class="ir-icon calendar">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                    </div>
                                    <div class="ir-content"><div class="ir-label">Bergabung</div><div class="ir-value">{{ auth()->user()->created_at ? \Carbon\Carbon::parse(auth()->user()->created_at)->isoFormat('D MMMM YYYY') : '-' }}</div></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="profile-card">
                            <div class="pc-header">
                                <div class="pc-icon">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                </div>
                                <div class="pc-title">Edit Profil</div>
                            </div>
                            <div class="pc-body">
                                <form action="{{ route('beautycian.profile.update') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label>Nama Lengkap</label>
                                        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', auth()->user()->nama) }}">
                                        @error('nama') <span style="font-size:11px;color:#DC2626;margin-top:4px;display:block;">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <div class="input-icon-wrap">
                                            <svg class="input-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', auth()->user()->email) }}">
                                        </div>
                                        @error('email') <span style="font-size:11px;color:#DC2626;margin-top:4px;display:block;">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>No. Handphone</label>
                                        <div class="input-icon-wrap">
                                            <svg class="input-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                            <input type="text" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror" value="{{ old('no_hp', auth()->user()->no_hp) }}">
                                        </div>
                                        @error('no_hp') <span style="font-size:11px;color:#DC2626;margin-top:4px;display:block;">{{ $message }}</span> @enderror
                                    </div>
                                    <button type="submit" class="btn-primary-full">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                                        Simpan Perubahan
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="profile-card" style="margin-top:24px;">
                            <div class="pc-header">
                                <div class="pc-icon">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                                </div>
                                <div class="pc-title">Ganti Password</div>
                            </div>
                            <div class="pc-body">
                                <form action="{{ route('beautycian.profile.update-password') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label>Password Saat Ini</label>
                                        <div class="input-icon-wrap">
                                            <svg class="input-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                                            <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" placeholder="Masukkan password saat ini">
                                        </div>
                                        @error('current_password') <span style="font-size:11px;color:#DC2626;margin-top:4px;display:block;">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Password Baru</label>
                                        <div class="input-icon-wrap">
                                            <svg class="input-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                                            <input type="password" name="new_password" class="form-control @error('new_password') is-invalid @enderror" placeholder="Masukkan password baru">
                                        </div>
                                        @error('new_password') <span style="font-size:11px;color:#DC2626;margin-top:4px;display:block;">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Konfirmasi Password Baru</label>
                                        <div class="input-icon-wrap">
                                            <svg class="input-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                                            <input type="password" name="new_password_confirmation" class="form-control" placeholder="Konfirmasi password baru">
                                        </div>
                                    </div>
                                    <button type="submit" class="btn-primary-full">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                                        Update Password
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script>
        function previewAndSubmit(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) { document.getElementById('profilePreview').src = e.target.result; };
                reader.readAsDataURL(input.files[0]);
                document.getElementById('fotoForm').submit();
            }
        }
    </script>
    <script src="{{ asset('assets/js/beautycian.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>
</html>