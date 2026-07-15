<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminPelangganController extends Controller
{
    public function index()
    {
        return view('admin.pelanggan.index');
    }
}
