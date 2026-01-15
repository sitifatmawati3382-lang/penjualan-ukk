<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Suplier;

class BarangController extends Controller
{
    // app/Http/Controllers/BarangController.php
    public function index()
    {
        $barang = Barang::with(['kategori', 'suplier'])->get(); // Eager load relasi
        return view('barang.index', compact('barang'));
    }

    public function create()
    {
        // Ambil data kategori dan suplier untuk dropdown
        $kategori = Kategori::all();
        $suplier = Suplier::all();

        return view('barang/form-tambah-barang', compact('kategori', 'suplier'));
    }

    public function store(Request $request)
    {
        // Validasi data input dari form
        $request->validate([
            'id_barang' => 'required|string|unique:barang,id_barang',
            'nama_barang' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'id_suplier' => 'required|exists:suplier,id_suplier',
            'stok' => 'required|integer|min:0',
            'harga_beli' => 'required|numeric|min:0',
            'harga' => 'required|numeric|min:0',
        ]);

        // Buat record baru di database menggunakan model Barang
        Barang::create($request->all());

        // Redirect ke halaman daftar barang dengan pesan sukses
        return redirect()->route('barang.index')->with('success', 'Data barang berhasil ditambahkan!');
    }

    public function edit($id)
    {
        // Temukan data barang berdasarkan ID
        $barang = Barang::findOrFail($id);

        // Ambil semua data kategori dan suplier
        $kategori = Kategori::all();
        $suplier = Suplier::all();

        // Kirim data ke view
        return view('barang/ubah-barang', compact('barang', 'kategori', 'suplier'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input dari form
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'id_suplier' => 'required|exists:suplier,id_suplier',
            'stok' => 'required|integer|min:0',
            'harga_beli' => 'required|numeric|min:0',
            'harga' => 'required|numeric|min:0',
        ]);

        // Temukan data barang berdasarkan ID
        $barang = Barang::findOrFail($id);

        // Update data barang
        $barang->update($request->all());

        // Redirect ke halaman data barang dengan pesan sukses
        return redirect()->route('barang.index')->with('success', 'Data barang berhasil diperbarui!');
    }

    public function destroy($id)
    {
        // Temukan data barang berdasarkan ID
        $barang = Barang::findOrFail($id);

        // Hapus data
        $barang->delete();

        // Redirect ke halaman daftar barang dengan pesan sukses
        return redirect()->route('barang.index')->with('success', 'Data barang berhasil dihapus!');
    }
}
