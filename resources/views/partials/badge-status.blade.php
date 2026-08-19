@props(['status'])

@php
$map = [
    'Lunas'               => ['label' => 'Lunas',          'class' => 'status-selesai', 'icon' => 'fa-regular fa-circle-check'],
    'Selesai'             => ['label' => 'Selesai',        'class' => 'status-selesai', 'icon' => 'fa-regular fa-circle-check'],
    'DP Dibayar'          => ['label' => 'DP Dibayar',     'class' => 'status-selesai', 'icon' => 'fa-regular fa-circle-check'],
    'Pending'             => ['label' => 'Pending',        'class' => 'status-proses',  'icon' => 'fa-regular fa-clock'],
    'Proses'              => ['label' => 'Diproses',       'class' => 'status-proses',  'icon' => 'fa-regular fa-clock'],
    'Sedang Diproses'     => ['label' => 'Diproses',       'class' => 'status-proses',  'icon' => 'fa-regular fa-clock'],
    'Menunggu Pembayaran' => ['label' => 'Menunggu Bayar', 'class' => 'status-proses',  'icon' => 'fa-regular fa-clock'],
    'Batal'               => ['label' => 'Batal',          'class' => 'status-batal',   'icon' => 'fa-regular fa-circle-xmark'],
    'Gagal'               => ['label' => 'Gagal',          'class' => 'status-batal',   'icon' => 'fa-regular fa-circle-xmark'],
    'Kadaluarsa'          => ['label' => 'Kadaluarsa',     'class' => 'status-batal',   'icon' => 'fa-regular fa-clock'],
    'Dibatalkan'          => ['label' => 'Dibatalkan',     'class' => 'status-batal',   'icon' => 'fa-regular fa-circle-xmark'],
];
$s = $map[$status] ?? ['label' => $status, 'class' => 'status-proses', 'icon' => 'fa-regular fa-clock'];
@endphp
<span class="badge-status {{ $s['class'] }}">
    <i class="{{ $s['icon'] }}"></i> {{ $s['label'] }}
</span>
