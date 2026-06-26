<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LingkaranController extends Controller
{
    public function index()
    {
        return view('lingkaran', [
            'data' => []
        ]);
    }

    public function hitung(Request $request)
    {
        $request->validate([
            'jari_jari' => 'required|numeric|min:1'
        ]);

        $jari_jari = $request->jari_jari;

        $luas = 3.14 * pow($jari_jari, 2);

        $data = [
            [
                'jari_jari' => $jari_jari,
                'luas' => $luas
            ]
        ];

        return view('lingkaran', compact('data'));
    }

    public function get()
    {
        $query = DB::table('lingkarans')->get();
        dd($query);
    }
}
