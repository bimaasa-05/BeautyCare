<?php

namespace App\Http\Controllers;

use App\Models\Pengaturan;

class LegalController extends Controller
{
    public function terms()
    {
        $pengaturan = Pengaturan::first();

        return view('legal.terms', compact('pengaturan'));
    }

    public function privacy()
    {
        $pengaturan = Pengaturan::first();

        return view('legal.privacy', compact('pengaturan'));
    }
}