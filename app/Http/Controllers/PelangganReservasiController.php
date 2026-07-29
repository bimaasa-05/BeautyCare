<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PelangganReservasiController extends Controller
{
    public function index()
    {
        return view('pelanggan.reservasi.index');
    }
}
