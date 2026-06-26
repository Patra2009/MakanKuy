<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    public function index()
    {
        $promos = Promo::latest()->get();
        return view('admin.promo.index', compact('promos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|max:100',
            'deskripsi' => 'nullable',
            'diskon' => 'required|numeric|min:0|max:100',
            'tanggal_mulai' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_mulai',
            'status' => 'required',
        ]);

        Promo::create($request->only('judul', 'deskripsi', 'diskon', 'tanggal_mulai', 'tanggal_akhir', 'status'));

        return back()->with('success', 'Promo berhasil ditambahkan.');
    }

    public function update(Request $request, Promo $promo)
    {
        $request->validate([
            'judul' => 'required|max:100',
            'deskripsi' => 'nullable',
            'diskon' => 'required|numeric|min:0|max:100',
            'tanggal_mulai' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_mulai',
            'status' => 'required',
        ]);

        $promo->update($request->only('judul', 'deskripsi', 'diskon', 'tanggal_mulai', 'tanggal_akhir', 'status'));

        return back()->with('success', 'Promo berhasil diperbarui.');
    }

    public function destroy(Promo $promo)
    {
        $promo->delete();
        return back()->with('success', 'Promo berhasil dihapus.');
    }
}
