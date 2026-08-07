<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'pesan' => ['required', 'string', 'max:2000'],
        ]);

        $judul = 'Pesan Kontak Baru';
        $isi   = "Dari: {$validated['nama']} ({$validated['email']} | {$validated['no_hp']})\n" .
                 "Pesan: {$validated['pesan']}";

        buatNotifRole('admin', $judul, $isi, 'Lainnya', url('/#kontak'));

        return back()->with('success', 'Pesan Anda berhasil dikirim. Tim BeautyCare akan segera menghubungi Anda.');
    }
}