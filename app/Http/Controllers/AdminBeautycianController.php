<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminBeautycianController extends Controller
{
    public function index()
    {
        return view('admin.beautician.index');
    }
}
