<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Data Membership - BeautyCare</title>
    @include('partials.head-meta')

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/membership.css') }}">
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
                            <div class="ph-icon-wrap">
                                <i class="fa-solid fa-crown"></i>
                            </div>
                            <div class="ph-text">
                                <h3>Data Membership</h3>
                                <p>Atur program membership dan keanggotaan pelanggan.</p>
                            </div>
                        </div>
                        <a href="{{ route('admin.membership.create') }}" class="ph-add-btn">
                            <i class="fa-solid fa-plus"></i> Tambah Paket
                        </a>
                    </div>
                </div>

                @if (session('success'))
                <div class="alert-success">
                    <i class="fa-solid fa-circle-check"></i>
                    {{ session('success') }}
                </div>
                @endif

                @php
                    $warnaTingkat = ['Silver' => 'silver', 'Gold' => 'gold', 'Platinum' => 'platinum'];
                    $iconTingkat = ['Silver' => 'fa-solid fa-medal', 'Gold' => 'fa-solid fa-trophy', 'Platinum' => 'fa-solid fa-gem'];
                @endphp

                <div class="member-status-card">
                    <div class="ms-deco"></div>
                    <div class="ms-deco"></div>
                    <div class="ms-content">
                        <div class="ms-left">
                            <div class="ms-icon">
                                <i class="fa-solid fa-boxes-stacked"></i>
                            </div>
                            <div class="ms-text">
                                <h3>Program Membership</h3>
                                <p>{{ $totalMember }} paket membership terdaftar &middot; {{ $memberAktif }} paket berstatus aktif</p>
                            </div>
                        </div>
                        <div class="ms-level">
                            <i class="fa-solid fa-circle-check"></i>
                            {{ $memberAktif }} Aktif
                        </div>
                    </div>
                </div>

                <div class="stats-membership">
                    <div class="stat-member-card">
                        <div class="sm-icon paket">
                            <i class="fa-solid fa-boxes-stacked"></i>
                        </div>
                        <div class="sm-value">{{ $totalMember }}</div>
                        <div class="sm-label">Total Paket</div>
                    </div>
                    <div class="stat-member-card">
                        <div class="sm-icon aktif">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                        <div class="sm-value">{{ $memberAktif }}</div>
                        <div class="sm-label">Paket Aktif</div>
                    </div>
                    @foreach ($statPerTingkat as $tingkat => $stat)
                    <div class="stat-member-card">
                        <div class="sm-icon tier">
                            <i class="{{ $iconTingkat[$tingkat] ?? 'fa-solid fa-star' }}"></i>
                        </div>
                        <div class="sm-value">{{ $stat['total'] }}</div>
                        <div class="sm-label">{{ $tingkat }} &middot; {{ $stat['diskon'] }}%</div>
                    </div>
                    @endforeach
                </div>

                <div class="progres-card">
                    <div class="pg-head">
                        <h4><i class="fa-solid fa-chart-pie" style="color: var(--primary); margin-right: 8px;"></i>Distribusi Paket per Tingkat</h4>
                        @if ($totalMember > 0)
                        <span class="pg-target"><i class="fa-solid fa-box"></i> {{ $totalMember }} paket</span>
                        @endif
                    </div>
                    @forelse ($statPerTingkat as $tingkat => $stat)
                    <div class="pg-row">
                        <div class="pg-label">
                            <span>{{ $tingkat }} <i class="{{ $iconTingkat[$tingkat] ?? 'fa-solid fa-star' }}" style="color: var(--primary); margin-left: 4px;"></i></span>
                            <span><strong>{{ $stat['total'] }}</strong> / {{ $totalMember }} paket</span>
                        </div>
                        <div class="pg-bar">
                            <div class="pg-fill {{ $stat['total'] >= $totalMember ? 'full' : '' }}" data-width="{{ $totalMember > 0 ? round($stat['total'] / $totalMember * 100) : 0 }}"></div>
                        </div>
                    </div>
                    @empty
                    <div class="pg-label" style="justify-content: center; gap: 6px;">
                        <i class="fa-solid fa-box-open" style="color: var(--gray);"></i>
                        Belum ada paket membership yang terdaftar.
                    </div>
                    @endforelse
                </div>

                <div class="benefit-section-title">
                    <div class="bst-left">
                        <i class="fa-solid fa-crown"></i> Paket Membership Tersedia
                    </div>
                </div>

                <div class="member-tier-grid" id="tierFilters">
                    @forelse ($memberships as $item)
                    @php
                        $banner = $warnaTingkat[$item->tingkat] ?? 'gold';
                        $icon = $iconTingkat[$item->tingkat] ?? 'fa-solid fa-trophy';
                        $statusOtomatis = $item->masa_berlaku > 0 && $item->status === 'aktif'
                            ? 'aktif'
                            : ($item->status === 'suspend' ? 'suspend' : 'non_aktif');
                        $statusLabel = $statusOtomatis === 'aktif' ? 'Aktif' : ($statusOtomatis === 'suspend' ? 'Suspend' : 'Non Aktif');
                    @endphp
                    <div class="member-tier-card" data-tingkat="{{ $item->tingkat }}">
                        <div class="mt-banner {{ $banner }}">
                            <div class="mt-icon-big">
                                <i class="{{ $icon }}"></i>
                            </div>
                            <span class="mt-badge">
                                <i class="fa-solid fa-layer-group"></i> {{ $item->tingkat }}
                            </span>
                            <span class="mt-status">
                                <i class="fa-solid fa-circle {{ $statusOtomatis === 'aktif' ? 'fa-beat-fade' : '' }}" style="font-size: 8px; margin-right: 4px;"></i>{{ $statusLabel }}
                            </span>
                        </div>
                        <div class="mt-body">
                            <div class="mt-title">{{ $item->nm_member }}</div>
                            <div class="mt-subtitle">
                                {{ $item->deskripsi ?: 'Paket membership ' . $item->tingkat . ' BeautyCare' }}
                            </div>
                            <div class="mt-benefits">
                                <div class="mt-benefit-item">
                                    <i class="fa-solid fa-tags"></i> Diskon {{ $item->diskon }}% semua layanan
                                </div>
                                <div class="mt-benefit-item">
                                    <i class="fa-solid fa-bag-shopping"></i> Min. {{ $item->min_transaksi }}x Pembelian Produk
                                </div>
                                <div class="mt-benefit-item">
                                    <i class="fa-solid fa-wallet"></i> Min. Belanja Rp {{ number_format($item->min_pembelian, 0, ',', '.') }}
                                </div>
                                <div class="mt-benefit-item">
                                    <i class="fa-solid fa-money-bill-wave"></i> Harga Upgrade: Rp {{ number_format($item->harga, 0, ',', '.') }}
                                </div>
                                <div class="mt-benefit-item">
                                    <i class="fa-solid fa-comments"></i> Gratis konsultasi {{ (int) $item->jml_konsultasi }}x/bulan
                                </div>
                                <div class="mt-benefit-item">
                                    <i class="fa-solid fa-calendar-check"></i> Prioritas booking
                                </div>
                                <div class="mt-benefit-item">
                                    <i class="fa-solid fa-star"></i> Undangan event eksklusif
                                </div>
                            </div>
                            <div class="mt-syarat">
                                <div class="mt-syarat-row">
                                    <span><i class="fa-regular fa-clock"></i> Masa Berlaku</span>
                                    <span class="mt-syarat-status {{ $item->masa_berlaku > 0 ? 'ok' : 'bad' }}">{{ $item->masa_berlaku }} hari</span>
                                </div>
                                <div class="mt-syarat-row">
                                    <span><i class="fa-solid fa-gear"></i> Status Paket</span>
                                    @if ($statusOtomatis === 'aktif')
                                    <span class="mt-syarat-status ok">Aktif</span>
                                    @elseif ($statusOtomatis === 'suspend')
                                    <span class="mt-syarat-status kurang">Suspend</span>
                                    @else
                                    <span class="mt-syarat-status bad">Non Aktif</span>
                                    @endif
                                </div>
                            </div>
                            <div class="card-actions">
                                <a href="{{ route('admin.membership.edit', $item->id_member) }}" class="card-action-btn edit">
                                    <i class="fa-solid fa-pen-to-square"></i> Edit
                                </a>
                                <form action="{{ route('admin.membership.destroy', $item->id_member) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus paket membership ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="card-action-btn delete">
                                        <i class="fa-regular fa-trash-can"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="manage-card" style="grid-column: 1 / -1; text-align: center; color: var(--gray);">
                        <i class="fa-solid fa-folder-open fa-2x mb-2" style="color: #cbd5e1;"></i>
                        <p style="font-size: 13px; margin: 0;">Belum ada paket membership. Klik "Tambah Paket" untuk membuat yang baru.</p>
                    </div>
                    @endforelse
                </div>

                </div>
        </main>
    </div>

    <script src="{{ asset('assets/js/membership.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>