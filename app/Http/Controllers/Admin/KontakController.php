<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kontak;

class KontakController extends Controller
{
    public function index()
    {
        $kontaks = Kontak::latest('created_at')->get();
        return view('admin.kontak.index', compact('kontaks'));
    }
}
