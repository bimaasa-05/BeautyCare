<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Profile - BeautyCare</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
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
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        .page-header-premium {
            background: linear-gradient(135deg, #FFF5F8 0%, #FFE5EF 50%, #FFD6E6 100%);
            border-radius: 20px; padding: 28px 32px; margin-bottom: 24px;
            position: relative; overflow: hidden;
            border: 1px solid rgba(255, 79, 135, 0.08);
        }
        .page-header-premium::before {
            content: ''; position: absolute; top: -60px; right: -60px;
            width: 200px; height: 200px; border-radius: 50%;
            background: radial-gradient(circle, rgba(255, 79, 135, 0.12) 0%, transparent 70%);
            pointer-events: none;
        }
        .page-header-premium::after {
            content: ''; position: absolute; bottom: -40px; left: 30%;
            width: 120px; height: 120px; border-radius: 50%;
            background: radial-gradient(circle, rgba(255, 79, 135, 0.08) 0%, transparent 70%);
            pointer-events: none;
        }
        .page-header-premium .ph-content { position: relative; z-index: 1; display: flex; align-items: center; justify-content: space-between; }
        .page-header-premium .ph-left { display: flex; align-items: center; gap: 16px; }
        .page-header-premium .ph-icon-wrap {
            width: 52px; height: 52px; border-radius: 16px;
            background: linear-gradient(135deg, var(--primary), #FF7BA6);
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 22px;
            box-shadow: 0 6px 20px rgba(255, 79, 135, 0.3); flex-shrink: 0;
        }
        .page-header-premium .ph-text h3 { font-size: 20px; font-weight: 700; color: var(--dark); margin: 0; }
        .page-header-premium .ph-text p { font-size: 13px; color: var(--gray); margin: 2px 0 0; }
        .profile-grid { display: grid; grid-template-columns: 340px 1fr; gap: 24px; }
        .profile-card { background: var(--white); border-radius: 20px; box-shadow: 0 2px 12px -4px rgba(0,0,0,0.06); overflow: hidden; }
        .profile-card .pc-header { padding: 20px 24px; border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: 12px; }
        .profile-card .pc-header .pc-icon { width: 36px; height: 36px; border-radius: 10px; background: var(--hover); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 16px; flex-shrink: 0; }
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
        .avatar-section .avatar-overlay i { color: #fff; font-size: 24px; }
        .avatar-section .avatar-name { font-size: 18px; font-weight: 700; color: var(--dark); margin-bottom: 2px; }
        .avatar-section .avatar-role { font-size: 12px; color: var(--gray); font-weight: 500; }
        .avatar-section .avatar-role .badge-role { display: inline-block; padding: 3px 14px; border-radius: 100px; background: var(--hover); color: var(--primary); font-size: 11px; font-weight: 600; }
        #fotoInput { display: none; }
        .form-group { margin-bottom: 20px; }
        .form-group:last-child { margin-bottom: 0; }
        .form-group label { display: block; font-size: 12px; font-weight: 600; color: var(--gray); margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.3px; }
        .form-group .form-control { width: 100%; padding: 11px 16px; border-radius: 12px; border: 1.5px solid var(--border); background: #FAFAFA; font-size: 13px; font-family: 'Inter', sans-serif; color: var(--dark); transition: all 0.2s ease; outline: none; }
        .form-group .form-control:focus { border-color: var(--primary); background: #fff; box-shadow: 0 0 0 3px rgba(255, 79, 135, 0.1); }
        .form-group .form-control:disabled { background: #f5f5f5; color: #999; cursor: not-allowed; }
        .form-group .input-icon-wrap { position: relative; }
        .form-group .input-icon-wrap i { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #bbb; font-size: 14px; }
        .form-group .input-icon-wrap .form-control { padding-left: 40px; }
        .btn-primary-full { width: 100%; padding: 12px 24px; border-radius: 12px; border: none; background: linear-gradient(135deg, var(--primary), #FF7BA6); color: #fff; font-size: 13px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; font-family: 'Inter', sans-serif; box-shadow: 0 4px 16px rgba(255, 79, 135, 0.25); }
        .btn-primary-full:hover { transform: translateY(-2px); box-shadow: 0 6px 24px rgba(255, 79, 135, 0.35); }
        .info-row { display: flex; align-items: center; padding: 14px 0; border-bottom: 1px solid #F5F5F5; }
        .info-row:last-child { border-bottom: none; }
        .info-row .ir-icon { width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 14px; flex-shrink: 0; margin-right: 14px; }
        .info-row .ir-icon.email { background: #DBEAFE; color: #2563EB; }
        .info-row .ir-icon.phone { background: #D1FAE5; color: #059669; }
        .info-row .ir-icon.calendar { background: #FEF3C7; color: #D97706; }
        .info-row .ir-content { flex: 1; }
        .info-row .ir-content .ir-label { font-size: 11px; color: var(--gray); font-weight: 500; text-transform: uppercase; letter-spacing: 0.3px; }
        .info-row .ir-content .ir-value { font-size: 14px; font-weight: 600; color: var(--dark); margin-top: 1px; }
        .alert-premium { border-radius: 16px; padding: 16px 20px; margin-bottom: 24px; display: flex; align-items: center; gap: 12px; font-size: 13px; font-weight: 500; animation: slideDown 0.4s ease; }
        .alert-premium.success { background: linear-gradient(135deg, #ECFDF5, #D1FAE5); border: 1px solid #A7F3D0; color: #065F46; }
        .alert-premium .alert-icon { width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 16px; flex-shrink: 0; }
        .alert-premium.success .alert-icon { background: #A7F3D0; color: #059669; }
        @keyframes slideDown { from { opacity: 0; transform: translateY(-12px); } to { opacity: 1; transform: translateY(0); } }
        @media (max-width: 900px) { .profile-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <div class="dashboard-layout">
        @include('layouts.sidebar')
        <main class="main-content">
            @include('layouts.header2')
            <div class="dashboard-content">
                <div class="page-header-premium">
                    <div class="ph-content">
                        <div class="ph-left">
                            <div class="ph-icon-wrap"><i class="fa-regular fa-user"></i></div>
                            <div class="ph-text"><h3>Profile Saya</h3><p>Kelola data diri dan pengaturan akun Anda</p></div>
                        </div>
                    </div>
                </div>

                @if(session('success'))
                <div class="alert-premium success">
                    <div class="alert-icon"><i class="fa-regular fa-circle-check"></i></div>
                    {{ session('success') }}
                </div>
                @endif
                @if($errors->any())
                <div class="alert-premium" style="background:linear-gradient(135deg,#FEF2F2,#FEE2E2);border:1px solid #FECACA;color:#991B1B;">
                    <div class="alert-icon" style="background:#FECACA;color:#DC2626;"><i class="fa-regular fa-circle-exclamation"></i></div>
                    <ul style="margin:0;padding-left:16px;">@foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul>
                </div>
                @endif

                <div class="profile-grid">
                    <div>
                        <div class="profile-card">
                            <div class="pc-header">
                                <div class="pc-icon"><i class="fa-regular fa-image"></i></div>
                                <div class="pc-title">Foto Profil</div>
                            </div>
                            <div class="pc-body">
                                <div class="avatar-section">
                                    <form id="fotoForm" action="{{ route('admin.profile.update-foto') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="avatar-wrap" onclick="document.getElementById('fotoInput').click()">
                                            <img src="{{ auth()->user()->foto ? asset('storage/' . auth()->user()->foto) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->nama).'&background=FF4F87&color=fff&size=140' }}" alt="Foto Profil" id="profilePreview">
                                            <div class="avatar-overlay"><i class="fa-solid fa-camera"></i></div>
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
                                <div class="pc-icon"><i class="fa-regular fa-circle-info"></i></div>
                                <div class="pc-title">Info Akun</div>
                            </div>
                            <div class="pc-body" style="padding:8px 24px;">
                                <div class="info-row">
                                    <div class="ir-icon email"><i class="fa-regular fa-envelope"></i></div>
                                    <div class="ir-content"><div class="ir-label">Email</div><div class="ir-value">{{ auth()->user()->email }}</div></div>
                                </div>
                                <div class="info-row">
                                    <div class="ir-icon phone"><i class="fa-regular fa-phone"></i></div>
                                    <div class="ir-content"><div class="ir-label">No. Handphone</div><div class="ir-value">{{ auth()->user()->no_hp ?? '-' }}</div></div>
                                </div>
                                <div class="info-row">
                                    <div class="ir-icon calendar"><i class="fa-regular fa-calendar"></i></div>
                                    <div class="ir-content"><div class="ir-label">Bergabung</div><div class="ir-value">{{ auth()->user()->created_at ? \Carbon\Carbon::parse(auth()->user()->created_at)->isoFormat('D MMMM YYYY') : '-' }}</div></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="profile-card">
                            <div class="pc-header">
                                <div class="pc-icon"><i class="fa-regular fa-pen-to-square"></i></div>
                                <div class="pc-title">Edit Profil</div>
                            </div>
                            <div class="pc-body">
                                <form action="{{ route('admin.profile.update') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label>Nama Lengkap</label>
                                        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', auth()->user()->nama) }}">
                                        @error('nama') <span style="font-size:11px;color:#DC2626;margin-top:4px;display:block;">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <div class="input-icon-wrap"><i class="fa-regular fa-envelope"></i>
                                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', auth()->user()->email) }}"></div>
                                        @error('email') <span style="font-size:11px;color:#DC2626;margin-top:4px;display:block;">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>No. Handphone</label>
                                        <div class="input-icon-wrap"><i class="fa-regular fa-phone"></i>
                                        <input type="text" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror" value="{{ old('no_hp', auth()->user()->no_hp) }}"></div>
                                        @error('no_hp') <span style="font-size:11px;color:#DC2626;margin-top:4px;display:block;">{{ $message }}</span> @enderror
                                    </div>
                                    <button type="submit" class="btn-primary-full"><i class="fa-regular fa-floppy-disk"></i> Simpan Perubahan</button>
                                </form>
                            </div>
                        </div>
                        <div class="profile-card" style="margin-top:24px;">
                            <div class="pc-header">
                                <div class="pc-icon"><i class="fa-regular fa-lock"></i></div>
                                <div class="pc-title">Ganti Password</div>
                            </div>
                            <div class="pc-body">
                                <form action="{{ route('admin.profile.update-password') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label>Password Saat Ini</label>
                                        <div class="input-icon-wrap"><i class="fa-regular fa-lock"></i>
                                        <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" placeholder="Masukkan password saat ini"></div>
                                        @error('current_password') <span style="font-size:11px;color:#DC2626;margin-top:4px;display:block;">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Password Baru</label>
                                        <div class="input-icon-wrap"><i class="fa-regular fa-lock"></i>
                                        <input type="password" name="new_password" class="form-control @error('new_password') is-invalid @enderror" placeholder="Masukkan password baru"></div>
                                        @error('new_password') <span style="font-size:11px;color:#DC2626;margin-top:4px;display:block;">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Konfirmasi Password Baru</label>
                                        <div class="input-icon-wrap"><i class="fa-regular fa-lock"></i>
                                        <input type="password" name="new_password_confirmation" class="form-control" placeholder="Konfirmasi password baru"></div>
                                    </div>
                                    <button type="submit" class="btn-primary-full"><i class="fa-regular fa-key"></i> Update Password</button>
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
        const now = new Date();
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        const dateEl = document.getElementById('currentDate');
        if (dateEl) dateEl.textContent = now.toLocaleDateString('id-ID', options);
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>
</html>
