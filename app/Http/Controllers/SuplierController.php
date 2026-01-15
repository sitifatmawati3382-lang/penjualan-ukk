<?php

namespace App\Http\Controllers;

use App\Models\Suplier;
use Illuminate\Http\Request;

class SuplierController extends Controller
{
    public function index(){
        $suplier = Suplier::all();
        return view('suplier.index', compact('suplier'));
    }

    public function create()
    {
        // Ambil data kategori dan suplier untuk dropdown
        $suplier = Suplier::all();

        return view('suplier/form-tambah-suplier', compact('suplier'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_suplier' => 'required|string|max:255',
            'alamat' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'kode_pos' => 'nullable|string|max:20',
        ]);

        Suplier::create($request->all());

        return redirect()->route('suplier.index')->with('success', 'Suplier berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $suplier = Suplier::findOrFail($id);
        return view('suplier.ubah-suplier', compact('suplier'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_suplier' => 'required|string|max:255',
            'alamat' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|max:20',
        ]);

        $suplier = Suplier::findOrFail($id);
        $suplier->update($request->all());

        return redirect()->route('suplier.index')->with('success', 'Suplier berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $suplier = Suplier::findOrFail($id);
        $suplier->delete();

        return redirect()->route('suplier.index')->with('success', 'Suplier berhasil dihapus!');
    }
}

