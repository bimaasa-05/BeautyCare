<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard - BeautyCare</title>
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
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

    body {
        font-family: 'Inter', sans-serif;
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

<div class="dashboard-layout">
    @include('layouts.sidebar')
    <main class="main-content">
        @include('layouts.header2')

        <h1 class="mb-4">
            Tambah Pelanggan
        </h1>
        <div class="card shadow-lg">

            <div class="card-body">
                <form action="/student" method="POST">

                    @csrf

                    <div class="mb-3">

                        <label class="form-label">
                            Nama
                        </label>

                        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                            placeholder="Masukan Nama Anda" autofocus>

                        @error('nama')

                        <div class="text-danger mt-1">
                            {{ $message }}
                        </div>

                        @enderror

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Email
                        </label>

                        <input type="text" name="email" class="form-control @error('email') is-invalid @enderror"
                            placeholder="Masukan Alamat Email">

                        @error('email')

                        <div class="text-danger mt-1">
                            {{ $message }}
                        </div>

                        @enderror

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Password
                        </label>

                        <input type="number" name="password"
                            class="form-control @error('password') is-invalid @enderror" placeholder="Masukan Password">

                        @error('password')

                        <div class="text-danger mt-1">
                            {{ $message }}
                        </div>

                        @enderror

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Foto
                        </label>

                        <input type="text" name="foto" class="form-control @error('foto') is-invalid @enderror"
                            placeholder="Masukan foto anda">

                        @error('foto')

                        <div class="text-danger mt-1">
                            {{ $message }}
                        </div>

                        @enderror

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            No HP
                        </label>

                        <input type="number" name="No HP" class="form-control @error('no_hp') is-invalid @enderror"
                            placeholder="Masukan No HP Anda">

                        @error('no_hp')

                        <div class="text-danger mt-1">
                            {{ $message }}
                        </div>

                        @enderror

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Status
                        </label>

                        <input type="text" name="jk" class="form-control @error('status') is-invalid @enderror"
                            placeholder="">

                        @error('status')

                        <div class="text-danger mt-1">
                            {{ $message }}
                        </div>

                        @enderror

                    </div>

                    <button class="btn btn-outline-danger" type="submit">

                        Tambah Data

                    </button>
                    <a href="{{ route('admin.user.index') }}" class="btn btn-outline-secondary">Kembali</a>

                </form>
            </div>
        </div>
    </main>
</div>


<script>
// Set current date
const now = new Date();
const options = {
    weekday: 'long',
    year: 'numeric',
    month: 'long',
    day: 'numeric'
};
document.getElementById('currentDate').textContent = now.toLocaleDateString('id-ID', options);
</script>
<script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>