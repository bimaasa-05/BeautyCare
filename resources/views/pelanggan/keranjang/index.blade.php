<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Keranjang - BeautyCare</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">

    <style>
    body {
        font-family: 'Inter', sans-serif;
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

    .keranjang-table-wrap {
        background: var(--white);
        border-radius: 20px;
        box-shadow: 0 2px 12px -4px rgba(0, 0, 0, 0.06);
        overflow: hidden;
    }

    .keranjang-table {
        width: 100%;
        border-collapse: collapse;
    }

    .keranjang-table thead th {
        padding: 16px 20px;
        text-align: center;
        font-size: 11px;
        font-weight: 700;
        color: var(--gray);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        background: #FAFAFA;
        border-bottom: 1px solid var(--border);
    }

    .keranjang-table thead th:nth-child(2) {
        text-align: left;
    }

    .keranjang-table tbody td {
        padding: 16px 20px;
        font-size: 13px;
        color: var(--dark);
        border-bottom: 1px solid var(--border);
        vertical-align: middle;
        text-align: center;
    }

    .keranjang-table tbody td:nth-child(2) {
        text-align: left;
    }

    .keranjang-table tbody tr:last-child td {
        border-bottom: none;
    }

    .keranjang-table .kt-produk {
        font-weight: 700;
    }

    .btn-hapus-sebagian {
        padding: 10px 22px;
        border-radius: 12px;
        border: 1.5px solid #fecaca;
        background: linear-gradient(135deg, #fff5f5, #fff);
        color: #dc2626;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.25s ease;
        font-family: 'Inter', sans-serif;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 2px 8px rgba(239, 68, 68, 0.06);
    }

    .btn-hapus-sebagian:hover {
        background: linear-gradient(135deg, #fef2f2, #fff5f5);
        border-color: #f87171;
        box-shadow: 0 4px 16px rgba(239, 68, 68, 0.12);
        transform: translateY(-1px);
    }

    .btn-hapus-sebagian.active {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: #fff;
        border-color: transparent;
        box-shadow: 0 4px 16px rgba(239, 68, 68, 0.3);
    }

    .btn-hapus-sebagian.active:hover {
        background: linear-gradient(135deg, #dc2626, #b91c1c);
        box-shadow: 0 6px 24px rgba(239, 68, 68, 0.4);
        transform: translateY(-2px);
    }

    #btnBatalHapus {
        border-color: #e2e8f0;
        background: linear-gradient(135deg, #f8fafc, #fff);
        color: #64748b;
        box-shadow: none;
    }

    #btnBatalHapus:hover {
        border-color: #cbd5e1;
        background: linear-gradient(135deg, #f1f5f9, #f8fafc);
        color: #475569;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        transform: translateY(-1px);
    }

    .cb-hapus {
        width: 16px;
        height: 16px;
        accent-color: var(--primary);
        cursor: pointer;
    }

    .keranjang-table tbody td:first-child .cb-hapus {
        margin: 0 auto;
    }

    .keranjang-table .kt-kategori {
        font-size: 11px;
        color: var(--gray);
        font-weight: 500;
    }

    .keranjang-table .kt-harga {
        font-weight: 700;
        color: var(--primary);
    }

    .keranjang-table .kt-qty-control {
        display: inline-flex;
        align-items: center;
        gap: 0;
        border: 1.5px solid var(--border);
        border-radius: 10px;
        overflow: hidden;
    }

    .keranjang-table .kqc-btn {
        width: 32px;
        height: 32px;
        border: none;
        background: #FAFAFA;
        color: var(--dark);
        font-size: 15px;
        font-weight: 700;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
        font-family: 'Inter', sans-serif;
    }

    .keranjang-table .kqc-btn:hover {
        background: var(--hover);
        color: var(--primary);
    }

    .keranjang-table .kqc-val {
        width: 40px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        font-weight: 700;
        color: var(--dark);
        border-left: 1.5px solid var(--border);
        border-right: 1.5px solid var(--border);
    }

    .btn-hapus {
        padding: 6px 14px;
        border-radius: 100px;
        border: 1.5px solid #fee2e2;
        background: #fff;
        color: #ef4444;
        font-size: 11px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        font-family: 'Inter', sans-serif;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        text-decoration: none;
    }

    .btn-hapus:hover {
        background: #fef2f2;
        border-color: #fecaca;
    }

    .keranjang-footer {
        background: var(--white);
        border-radius: 20px;
        box-shadow: 0 2px 12px -4px rgba(0, 0, 0, 0.06);
        padding: 24px 32px;
        margin-top: 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
    }

    .keranjang-footer .kf-total-label {
        font-size: 13px;
        color: var(--gray);
        font-weight: 500;
    }

    .keranjang-footer .kf-total {
        font-size: 28px;
        font-weight: 800;
        color: var(--dark);
    }

    .keranjang-footer .kf-total span {
        font-size: 14px;
        font-weight: 500;
        color: var(--gray);
    }

    .keranjang-empty {
        text-align: center;
        padding: 80px 20px;
    }

    .keranjang-empty .ke-icon {
        width: 100px;
        height: 100px;
        margin: 0 auto 16px;
        border-radius: 50%;
        background: linear-gradient(135deg, #FFF5F8, #FFE5EF);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 40px;
        color: var(--primary);
        opacity: 0.6;
    }

    .keranjang-empty h4 {
        font-size: 16px;
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 6px;
    }

    .keranjang-empty p {
        font-size: 13px;
        color: var(--gray);
        margin-bottom: 20px;
    }

    .btn-belanja {
        padding: 10px 24px;
        border-radius: 100px;
        border: none;
        background: linear-gradient(135deg, var(--primary), #FF7BA6);
        color: #fff;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        font-family: 'Inter', sans-serif;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-belanja:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(255, 79, 135, 0.3);
    }

    .cart-notif {
        position: fixed;
        top: 24px;
        right: 24px;
        z-index: 9999;
        background: #166534;
        color: #fff;
        padding: 14px 24px;
        border-radius: 14px;
        font-size: 13px;
        font-weight: 600;
        font-family: 'Inter', sans-serif;
        box-shadow: 0 8px 30px rgba(0,0,0,0.15);
        display: flex;
        align-items: center;
        gap: 10px;
        transform: translateX(120%);
        transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        max-width: 380px;
    }

    .cart-notif.show {
        transform: translateX(0);
    }

    .cart-notif .cn-icon {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: rgba(255,255,255,0.15);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        flex-shrink: 0;
    }

    .checkout-modal {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.4);
        z-index: 999;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .checkout-modal.show {
        display: flex;
    }

    .checkout-modal .cm-card {
        background: var(--white);
        border-radius: 24px;
        max-width: 520px;
        width: 100%;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 20px 60px rgba(0,0,0,0.15);
        animation: modalIn 0.3s ease;
    }

    @keyframes modalIn {
        from { opacity: 0; transform: scale(0.92) translateY(20px); }
        to { opacity: 1; transform: scale(1) translateY(0); }
    }

    .checkout-modal .cm-header {
        padding: 24px 28px 0;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .checkout-modal .cm-header h3 {
        font-size: 18px;
        font-weight: 700;
        color: var(--dark);
        margin: 0;
    }

    .checkout-modal .cm-close {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        border: none;
        background: #f1f5f9;
        color: var(--gray);
        font-size: 16px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }

    .checkout-modal .cm-close:hover {
        background: #e2e8f0;
    }

    .checkout-modal .cm-items {
        padding: 16px 28px;
        max-height: 240px;
        overflow-y: auto;
    }

    .checkout-modal .cm-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid var(--border);
        gap: 12px;
    }

    .checkout-modal .cm-item:last-child {
        border-bottom: none;
    }

    .checkout-modal .cm-item .cmi-left {
        flex: 1;
        min-width: 0;
    }

    .checkout-modal .cm-item .cmi-nama {
        font-size: 13px;
        font-weight: 700;
        color: var(--dark);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .checkout-modal .cm-item .cmi-qty {
        font-size: 11px;
        color: var(--gray);
        font-weight: 500;
    }

    .checkout-modal .cm-item .cmi-harga {
        font-size: 14px;
        font-weight: 700;
        color: var(--primary);
        white-space: nowrap;
    }

    .checkout-modal .cm-divider {
        height: 1px;
        background: var(--border);
        margin: 0 28px;
    }

    .checkout-modal .cm-total {
        padding: 16px 28px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .checkout-modal .cm-total .cmt-label {
        font-size: 13px;
        font-weight: 600;
        color: var(--gray);
    }

    .checkout-modal .cm-total .cmt-nominal {
        font-size: 22px;
        font-weight: 800;
        color: var(--dark);
    }

    .checkout-modal .cm-payment {
        padding: 0 28px 24px;
    }

    .checkout-modal .cm-payment .cmp-title {
        font-size: 12px;
        font-weight: 700;
        color: var(--gray);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 12px;
    }

    .checkout-modal .cmp-group {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
    }

    .checkout-modal .cmp-option {
        position: relative;
    }

    .checkout-modal .cmp-option input {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    .checkout-modal .cmp-option label {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 14px;
        border-radius: 12px;
        border: 1.5px solid var(--border);
        background: #FAFAFA;
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 12px;
        font-weight: 600;
        color: var(--dark);
        font-family: 'Inter', sans-serif;
    }

    .checkout-modal .cmp-option label:hover {
        border-color: var(--primary);
        background: var(--hover);
    }

    .checkout-modal .cmp-option input:checked + label {
        border-color: var(--primary);
        background: linear-gradient(135deg, var(--primary), #FF7BA6);
        color: #fff;
        box-shadow: 0 4px 12px rgba(255, 79, 135, 0.2);
    }

    .checkout-modal .cm-bayar {
        margin: 0 28px 24px;
        width: calc(100% - 56px);
        padding: 14px;
        border-radius: 12px;
        border: none;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s ease;
        font-family: 'Inter', sans-serif;
        background: linear-gradient(135deg, var(--primary), #FF7BA6);
        color: #fff;
        box-shadow: 0 4px 16px rgba(255, 79, 135, 0.25);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .checkout-modal .cm-bayar:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 24px rgba(255, 79, 135, 0.35);
    }

    @media (max-width: 768px) {
        .keranjang-table thead { display: none; }
        .keranjang-table tbody td {
            display: block;
            padding: 10px 16px;
            text-align: right;
        }
        .keranjang-table tbody td::before {
            content: attr(data-label);
            float: left;
            font-weight: 700;
            font-size: 11px;
            color: var(--gray);
            text-transform: uppercase;
        }
        .keranjang-table tbody tr {
            display: block;
            padding: 12px 0;
        }
        .keranjang-footer {
            flex-direction: column;
            text-align: center;
        }
        .checkout-modal .cmp-group {
            grid-template-columns: 1fr;
        }
    }
    </style>
</head>

<body>
    <div class="page-loader">
        <div class="loader-spinner"></div>
    </div>

    <div class="dashboard-layout">
        @include('layouts.sidebar')

        <main class="main-content">
            @include('layouts.header2')

            <div class="dashboard-content">
                <div class="page-header-premium">
                    <div class="ph-content">
                        <div class="ph-left">
                            <div class="ph-icon-wrap">
                                <i class="fa-solid fa-cart-shopping"></i>
                            </div>
                            <div class="ph-text">
                                <h3>Keranjang</h3>
                                <p>Daftar produk yang Anda pilih untuk dibeli</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; flex-wrap: wrap; gap: 10px;">
                    <div></div>
                    <div style="display: flex; gap: 8px;">
                        <button class="btn-hapus-sebagian" id="btnBatalHapus" onclick="toggleHapusMode()" style="display: none;">
                            <i class="fa-solid fa-xmark"></i> Batal
                        </button>
                        <button class="btn-hapus-sebagian" id="btnHapusSebagian" onclick="onHapusBtnClick()">
                            <i class="fa-solid fa-check-square"></i> Hapus Sebagian
                        </button>
                    </div>
                </div>

                @if(session('success'))
                <div id="cartNotifData" data-msg="{{ session('success') }}" style="display:none;"></div>
                @endif

                @if($troli->count() > 0)
                    <div class="keranjang-table-wrap">
                        <table class="keranjang-table">
                            <thead>
                                <tr>
                                    <th>
                                        <span class="no-text-header">No</span>
                                        <input type="checkbox" class="cb-hapus" id="cbSelectAll" style="display: none;" onchange="toggleAll(event)">
                                    </th>
                                    <th>Produk</th>
                                    <th>Kategori</th>
                                    <th>Harga Satuan</th>
                                    <th>Jumlah</th>
                                    <th>Sub Total</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($troli as $item)
                                <tr data-id="{{ $item->id }}">
                                    <td data-label="No">
                                        <input type="checkbox" class="cb-hapus" id="cb-{{ $item->id }}" value="{{ $item->id }}" style="display: none;">
                                        <span class="no-text" id="no-{{ $item->id }}">{{ $loop->iteration }}</span>
                                    </td>
                                    <td data-label="Produk">
                                        <div class="kt-produk">{{ $item->nm_produk }}</div>
                                    </td>
                                    <td data-label="Kategori">
                                        <div class="kt-kategori">{{ $item->kategori }}</div>
                                    </td>
                                    <td data-label="Harga Satuan">
                                        <div class="kt-harga">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</div>
                                    </td>
                                    <td data-label="Jumlah">
                                        <div class="kt-qty-control">
                                            <button class="kqc-btn" onclick="updateQty({{ $item->id }}, -1)">−</button>
                                            <span class="kqc-val" id="qty-{{ $item->id }}">{{ $item->qty }}</span>
                                            <button class="kqc-btn" onclick="updateQty({{ $item->id }}, 1)">+</button>
                                        </div>
                                    </td>
                                    <td data-label="Total">
                                        <div class="kt-harga" id="total-item-{{ $item->id }}">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</div>
                                    </td>
                                    <td data-label="Aksi">
                                        <form action="{{ route('pelanggan.keranjang.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus produk ini dari keranjang?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-hapus">
                                                <i class="fa-solid fa-trash-can"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="keranjang-footer">
                        <div>
                            <div class="kf-total-label">Total Belanja</div>
                            <div class="kf-total" id="grandTotal">Rp {{ number_format($total, 0, ',', '.') }} <span></span></div>
                        </div>
                        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                            <a href="{{ route('pelanggan.produk') }}" class="btn-belanja" style="background: transparent; color: var(--gray); border: 1.5px solid var(--border); box-shadow: none;">
                                <i class="fa-solid fa-arrow-left"></i> Lanjut Belanja
                            </a>
                            <button class="btn-belanja" onclick="openCheckout()">
                                <i class="fa-solid fa-credit-card"></i> Checkout
                            </button>
                        </div>
                    </div>
                @else
                    <div class="keranjang-empty">
                        <div class="ke-icon">
                            <i class="fa-solid fa-cart-plus"></i>
                        </div>
                        <h4>Keranjang Kosong</h4>
                        <p>Belum ada produk yang ditambahkan ke keranjang.</p>
                        <a href="{{ route('pelanggan.produk') }}" class="btn-belanja">
                            <i class="fa-solid fa-store"></i> Mulai Belanja
                        </a>
                    </div>
                @endif
            </div>

            <div class="cart-notif" id="cartNotif">
                <div class="cn-icon"><i class="fa-solid fa-check"></i></div>
                <span id="cartNotifMsg">Berhasil!</span>
            </div>

            <div class="checkout-modal" id="checkoutModal">
                <div class="cm-card">
                    <div class="cm-header">
                        <h3><i class="fa-solid fa-receipt"></i> Checkout</h3>
                        <button class="cm-close" onclick="closeCheckout()"><i class="fa-solid fa-xmark"></i></button>
                    </div>
                    <div class="cm-items">
                        @foreach($troli as $item)
                        <div class="cm-item" id="cm-item-{{ $item->id }}">
                            <div class="cmi-left">
                                <div class="cmi-nama">{{ $item->nm_produk }}</div>
                                <div class="cmi-qty" id="cm-qty-{{ $item->id }}">{{ $item->qty }} x Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</div>
                            </div>
                            <div class="cmi-harga" id="cm-total-{{ $item->id }}">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</div>
                        </div>
                        @endforeach
                    </div>
                    <div class="cm-divider"></div>
                    <div class="cm-total">
                        <div class="cmt-label">Total Belanja</div>
                        <div class="cmt-nominal" id="grandTotalModal">Rp {{ number_format($total, 0, ',', '.') }}</div>
                    </div>
                    <div class="cm-divider"></div>
                    <div class="cm-payment">
                        <div class="cmp-title"><i class="fa-solid fa-wallet"></i> Metode Pembayaran</div>
                        <div class="cmp-group">
                            <div class="cmp-option">
                                <input type="radio" name="metode_bayar" id="pay_transfer" value="Transfer" checked>
                                <label for="pay_transfer"><i class="fa-solid fa-building-columns"></i> Transfer</label>
                            </div>
                            <div class="cmp-option">
                                <input type="radio" name="metode_bayar" id="pay_dana" value="Dana">
                                <label for="pay_dana"><i class="fa-solid fa-qrcode"></i> Dana</label>
                            </div>
                            <div class="cmp-option">
                                <input type="radio" name="metode_bayar" id="pay_gopay" value="GoPay">
                                <label for="pay_gopay"><i class="fa-solid fa-qrcode"></i> GoPay</label>
                            </div>
                            <div class="cmp-option">
                                <input type="radio" name="metode_bayar" id="pay_ovo" value="OVO">
                                <label for="pay_ovo"><i class="fa-solid fa-qrcode"></i> OVO</label>
                            </div>
                            <div class="cmp-option">
                                <input type="radio" name="metode_bayar" id="pay_shopeepay" value="ShopeePay">
                                <label for="pay_shopeepay"><i class="fa-solid fa-qrcode"></i> ShopeePay</label>
                            </div>

                        </div>
                    </div>
                    <button class="cm-bayar" onclick="bayarSekarang()">
                        <i class="fa-solid fa-check-circle"></i> Bayar Sekarang
                    </button>
                </div>
            </div>
        </main>
    </div>

    <script>
    function openCheckout() {
        document.getElementById('checkoutModal').classList.add('show');
    }

    function closeCheckout() {
        document.getElementById('checkoutModal').classList.remove('show');
    }

    document.getElementById('checkoutModal').addEventListener('click', function(e) {
        if (e.target === this) closeCheckout();
    });

    function updateQty(id, delta) {
        var valEl = document.getElementById('qty-' + id);
        var curr = parseInt(valEl.textContent);
        var newQty = curr + delta;
        if (newQty < 1) return;

        var csrf = document.querySelector('meta[name="csrf-token"]').content;

        fetch('/pelanggan/keranjang/' + id, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf
            },
            body: JSON.stringify({ qty: newQty })
        })
        .then(function(r) { return r.json(); })
        .then(function(data) {
            if (data.success) {
                valEl.textContent = newQty;
                document.getElementById('total-item-' + id).textContent = 'Rp ' + formatAngka(data.total_item);
                document.getElementById('grandTotal').textContent = 'Rp ' + formatAngka(data.total_all);

                var cmQty = document.getElementById('cm-qty-' + id);
                if (cmQty) {
                    var parts = cmQty.textContent.split(' x ');
                    cmQty.textContent = newQty + ' x ' + parts[1];
                }
                var cmTotal = document.getElementById('cm-total-' + id);
                if (cmTotal) cmTotal.textContent = 'Rp ' + formatAngka(data.total_item);
                var modalTotal = document.getElementById('grandTotalModal');
                if (modalTotal) modalTotal.textContent = 'Rp ' + formatAngka(data.total_all);
            }
        });
    }

    function formatAngka(n) {
        return n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    var hapusMode = false;

    function onHapusBtnClick() {
        if (hapusMode) {
            hapusTerpilih();
        } else {
            toggleHapusMode();
        }
    }

    function toggleHapusMode() {
        hapusMode = !hapusMode;
        var btn = document.getElementById('btnHapusSebagian');
        var btnBatal = document.getElementById('btnBatalHapus');
        var cbs = document.querySelectorAll('.cb-hapus');
        var nos = document.querySelectorAll('.no-text');
        var noHeader = document.querySelector('.no-text-header');

        cbs.forEach(function(cb) { cb.style.display = hapusMode ? 'inline-block' : 'none'; });
        nos.forEach(function(n) { n.style.display = hapusMode ? 'none' : 'inline'; });
        if (noHeader) noHeader.style.display = hapusMode ? 'none' : 'inline';
        btnBatal.style.display = hapusMode ? 'inline-flex' : 'none';

        if (hapusMode) {
            btn.innerHTML = '<i class="fa-solid fa-trash-can"></i> Hapus';
            btn.classList.add('active');
            document.getElementById('cbSelectAll').style.display = 'inline-block';
            document.getElementById('cbSelectAll').checked = false;
        } else {
            btn.innerHTML = '<i class="fa-solid fa-check-square"></i> Hapus Sebagian';
            btn.classList.remove('active');
            document.getElementById('cbSelectAll').style.display = 'none';
            cbs.forEach(function(cb) { cb.checked = false; });
            renumberItems();
        }
    }

    function renumberItems() {
        var rows = document.querySelectorAll('.keranjang-table tbody tr');
        rows.forEach(function(row, index) {
            var noText = row.querySelector('.no-text');
            if (noText) noText.textContent = index + 1;
        });
    }

    function toggleAll(e) {
        var checked = e.target.checked;
        document.querySelectorAll('.cb-hapus').forEach(function(cb) {
            if (cb.id !== 'cbSelectAll') cb.checked = checked;
        });
    }

    function hapusTerpilih() {
        var selected = [];
        document.querySelectorAll('.cb-hapus:checked').forEach(function(cb) {
            if (cb.id !== 'cbSelectAll') selected.push(cb.value);
        });
        if (selected.length === 0) {
            showNotif('Pilih produk yang ingin dihapus.');
            return;
        }

        var csrf = document.querySelector('meta[name="csrf-token"]').content;

        fetch('/pelanggan/keranjang/batch', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf
            },
            body: JSON.stringify({ ids: selected })
        })
        .then(function(r) { return r.json(); })
        .then(function(data) {
            if (data.success) {
                var removedEls = document.querySelectorAll('.cb-hapus:checked');
                removedEls.forEach(function(cb) {
                    if (cb.id !== 'cbSelectAll') {
                        var tr = cb.closest('tr');
                        if (tr) tr.remove();
                    }
                });
                toggleHapusMode();
                document.getElementById('grandTotal').textContent = 'Rp ' + formatAngka(data.total_all);
                var modalTotal = document.getElementById('grandTotalModal');
                if (modalTotal) modalTotal.textContent = 'Rp ' + formatAngka(data.total_all);
                localStorage.setItem('cart_seen', '1');
                showNotif(data.message);

                if (data.count === 0) {
                    location.reload();
                }
            }
        });
    }

    function showNotif(msg) {
        var el = document.getElementById('cartNotif');
        document.getElementById('cartNotifMsg').textContent = msg;
        el.classList.add('show');
        setTimeout(function() { el.classList.remove('show'); }, 3000);
    }

    function bayarSekarang() {
        var metode = document.querySelector('input[name="metode_bayar"]:checked');
        if (metode) {
            alert('Pembayaran via ' + metode.value + ' sedang diproses. Terima kasih!');
            closeCheckout();
        }
    }

    var notifData = document.getElementById('cartNotifData');
    if (notifData) {
        var msg = notifData.getAttribute('data-msg');
        if (msg) {
            document.getElementById('cartNotifMsg').textContent = msg;
            var el = document.getElementById('cartNotif');
            el.classList.add('show');
            setTimeout(function() { el.classList.remove('show'); }, 3000);
        }
    }

    localStorage.setItem('cart_seen', '1');

    window.updateCartBadge = function() {};

    var badge = document.getElementById('cartBadgeSidebar');
    if (badge) badge.style.display = 'none';
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>
