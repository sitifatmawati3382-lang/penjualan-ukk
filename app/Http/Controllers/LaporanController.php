<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use Illuminate\Support\Carbon;

class LaporanController extends Controller
{
    public function harian(Request $request)
    {
        // Mendapatkan tanggal dari request, jika tidak ada, gunakan tanggal hari ini
        $tanggal = $request->input('tanggal', Carbon::now()->toDateString());
        
        // Mengambil semua transaksi untuk tanggal yang dipilih
        $transaksiHariIni = Transaksi::whereDate('tanggal_transaksi', $tanggal)->get();

        // Menghitung ringkasan laporan
        $totalPenjualan = $transaksiHariIni->sum('total_bayar');
        $totalKeuntungan = $transaksiHariIni->sum('total_keuntungan');
        $jumlahTransaksi = $transaksiHariIni->count();

        // Mengirim data ke view
        return view('laporan.harian', compact('transaksiHariIni', 'totalPenjualan', 'totalKeuntungan', 'jumlahTransaksi', 'tanggal'));
    }
}