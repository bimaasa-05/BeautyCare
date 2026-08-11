<div class="pm-box">
    <div style="text-align:center;padding:8px 0;">
        <div style="width:64px;height:64px;margin:0 auto 12px;border-radius:20px;background:#ECFDF5;display:flex;align-items:center;justify-content:center;color:#10B981;font-size:26px;">
            <i class="fa-solid fa-wallet"></i>
        </div>
        <div style="font-size:14px;font-weight:700;color:#065F46;">Pembayaran dengan Saldo Akun</div>
        <div style="font-size:12px;color:#059669;margin-top:6px;">
            Saldo Rp {{ number_format($transaksi->saldo_terpakai, 0, ',', '.') }} telah digunakan untuk pesanan ini.
        </div>
        <div style="font-size:11.5px;color:var(--gray);margin-top:4px;">
            Menunggu verifikasi kasir untuk menyelesaikan pesanan.
        </div>
    </div>
</div>