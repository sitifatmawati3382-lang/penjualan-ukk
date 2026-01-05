<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index(){
        $pelanggan = Pelanggan::all();
        return view('pelanggan.index', compact('pelanggan'));
    }

    public function create()
    {
        // Ambil data pelanggan untuk dropdown (jika diperlukan)
        $pelanggan = Pelanggan::all();

        return view('pelanggan.form-tambah-pelanggan', compact('pelanggan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pelanggan'   => 'required|string|max:255',
            'alamat' => 'nullable|string|max:255',
            'no_hp'  => 'nullable|string|max:20',
        ]);

        Pelanggan::create($request->all());

        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        return view('pelanggan.ubah-pelanggan', compact('pelanggan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_pelanggan'   => 'required|string|max:255',
            'alamat' => 'nullable|string|max:255',
            'no_hp'  => 'nullable|string|max:20',
        ]);

        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->update($request->all());

        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->delete();

        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil dihapus!');
    }
}
