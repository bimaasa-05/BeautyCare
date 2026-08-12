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
            'nama_salon' => 'nullable|string|max:100',
            'telepon' => 'nullable|string|max:20',
            'no_wa' => 'nullable|string|max:20',
            'jam_buka' => 'nullable|date_format:H:i',
            'jam_tutup' => 'nullable|date_format:H:i',
            'syarat_ketentuan' => 'nullable|string',
            'kebijakan_privasi' => 'nullable|string',
            'pusat_bantuan_kategori' => 'nullable|json',
            'pusat_bantuan_faq' => 'nullable|json',
        ]);

        $pengaturan = Pengaturan::first();

        if (!$pengaturan) {
            $pengaturan = new Pengaturan();
        }

        foreach (['push_notification', 'sms_notifikasi', 'email_laporan', 'konfirmasi_otomatis'] as $field) {
            if ($request->has($field)) {
                $pengaturan->$field = $request->boolean($field);
            }
        }

        foreach (['nama_salon', 'telepon', 'no_wa', 'jam_buka', 'jam_tutup', 'syarat_ketentuan', 'kebijakan_privasi', 'pusat_bantuan_kategori', 'pusat_bantuan_faq'] as $field) {
            if ($request->has($field)) {
                $pengaturan->$field = $request->$field;
            }
        }

        $pengaturan->save();

        return redirect()->route('admin.pengaturan.index')
            ->with('success', 'Pengaturan berhasil disimpan.');
    }
}