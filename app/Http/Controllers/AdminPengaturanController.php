<?php

namespace App\Http\Controllers;

use App\Models\Pengaturan;
use Illuminate\Http\Request;

class AdminPengaturanController extends Controller
{
    public function index()
    {
        $pengaturan = Pengaturan::first();

        if (!$pengaturan) {
            $pengaturan = Pengaturan::create([
                'push_notification' => true,
                'sms_notifikasi' => false,
                'email_laporan' => true,
                'konfirmasi_otomatis' => true,
                'nama_salon' => 'BeautyCare Premium',
                'telepon' => '021-1234-5678',
                'jam_buka' => '08:00:00',
                'jam_tutup' => '20:00:00',
            ]);
        }

        return view('admin.pengaturan.index', compact('pengaturan'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'push_notification' => 'nullable|boolean',
            'sms_notifikasi' => 'nullable|boolean',
            'email_laporan' => 'nullable|boolean',
            'konfirmasi_otomatis' => 'nullable|boolean',
            'nama_salon' => 'required|string|max:100',
            'telepon' => 'required|string|max:20',
            'jam_buka' => 'required|date_format:H:i',
            'jam_tutup' => 'required|date_format:H:i',
            'syarat_ketentuan' => 'nullable|string',
            'kebijakan_privasi' => 'nullable|string',
            'pusat_bantuan_kategori' => 'nullable|json',
            'pusat_bantuan_faq' => 'nullable|json',
        ]);

        $pengaturan = Pengaturan::first();

        if (!$pengaturan) {
            $pengaturan = new Pengaturan();
        }

        $pengaturan->fill([
            'push_notification' => $request->boolean('push_notification'),
            'sms_notifikasi' => $request->boolean('sms_notifikasi'),
            'email_laporan' => $request->boolean('email_laporan'),
            'konfirmasi_otomatis' => $request->boolean('konfirmasi_otomatis'),
            'nama_salon' => $request->nama_salon,
            'telepon' => $request->telepon,
            'jam_buka' => $request->jam_buka,
            'jam_tutup' => $request->jam_tutup,
            'syarat_ketentuan' => $request->syarat_ketentuan,
            'kebijakan_privasi' => $request->kebijakan_privasi,
            'pusat_bantuan_kategori' => $request->pusat_bantuan_kategori,
            'pusat_bantuan_faq' => $request->pusat_bantuan_faq,
        ]);

        $pengaturan->save();

        return redirect()->route('admin.pengaturan.index')
            ->with('success', 'Pengaturan berhasil disimpan.');
    }
}
