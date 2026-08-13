<?php

namespace App\Http\Controllers;

use App\Models\Pengaturan;

class HelpCenterController extends Controller
{
    public function index()
    {
        $pengaturan = Pengaturan::first();

        $kategori = json_decode($pengaturan->pusat_bantuan_kategori ?? '[]', true) ?: [];
        $faq = json_decode($pengaturan->pusat_bantuan_faq ?? '[]', true) ?: [];

        return view('help.index', compact('pengaturan', 'kategori', 'faq'));
    }
}