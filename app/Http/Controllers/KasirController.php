<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Pelanggan;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class KasirController extends Controller
{
    public function index()
    {
        $barang = Barang::all();
        return view('kasir.index', compact('barang'));
    }

    public function cariPelangganByHp($no_hp)
    {
        $pelanggan = Pelanggan::where('no_hp', $no_hp)->first();

        if ($pelanggan) {
            return response()->json([
                'success' => true,
                'pelanggan' => $pelanggan,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Pelanggan tidak ditemukan.',
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'keranjang' => 'required|array',
            'keranjang.*.id' => 'required|string',
            'keranjang.*.jumlah' => 'required|integer|min:1',
            'total_bayar' => 'required|integer',
            'jumlah_bayar' => 'required|integer',
            'id_pelanggan' => 'nullable|string',
        ]);
        
        DB::beginTransaction();
        try {
            $kembalian = $request->jumlah_bayar - $request->total_bayar;
            if ($kembalian < 0) {
                return back()->with('error', 'Jumlah bayar tidak cukup.');
            }

            $id_transaksi = (string) Str::uuid();
            $totalKeuntungan = 0;

            $idPelanggan = $request->id_pelanggan ?: '0';

            $transaksi = Transaksi::create([
                'id_transaksi' => $id_transaksi,
                'id_pelanggan' => $idPelanggan,
                'tanggal_transaksi' => now(),
                'total_bayar' => $request->total_bayar,
                'jumlah_bayar' => $request->jumlah_bayar,
                'kembalian' => $kembalian,
                'total_keuntungan' => 0, // Akan dihitung dan diperbarui nanti
            ]);

            foreach ($request->keranjang as $item) {
                $barang = Barang::find($item['id']);
                if (!$barang || $barang->stok < $item['jumlah']) {
                    DB::rollBack();
                    return back()->with('error', 'Stok barang tidak mencukupi untuk ' . ($barang->nama_barang ?? 'barang ini') . '.');
                }

                $subtotal = $barang->harga * $item['jumlah'];
                $keuntungan = ($barang->harga - $barang->harga_beli) * $item['jumlah'];
                $totalKeuntungan += $keuntungan;

                DetailTransaksi::create([
                    'id_transaksi' => $id_transaksi,
                    'id_barang' => $item['id'],
                    'jumlah' => $item['jumlah'],
                    'subtotal' => $subtotal, // Menggunakan subtotal yang sudah dihitung
                    'jumlah_beli' => $item['jumlah'], // Asumsi sama dengan jumlah jual
                    'harga_saat_beli' => $barang->harga_beli, // Mengambil harga beli dari item
                    'keuntungan_item' => $keuntungan
                ]);

                $barang->stok -= $item['jumlah'];
                $barang->save();
            }

            Transaksi::where('id_transaksi', $id_transaksi)->update([
                'total_keuntungan' => $totalKeuntungan
            ]);

            DB::commit();

            return redirect()->route('kasir.struk.pdf', ['id_transaksi' => $id_transaksi]);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat memproses transaksi: ' . $e->getMessage());
        }
    }
    
    // public function struk($id_transaksi)
    // {
    //     $transaksi = Transaksi::findOrFail($id_transaksi);
    //     $detailTransaksi = DetailTransaksi::where('id_transaksi', $id_transaksi)->with('barang')->get();

    //     // --- Mulai Logika Cetak Langsung ---
    //     try {
    //         // Ganti 'NAMA_PRINTER_ANDA' dengan nama printer yang terinstal di Windows.
    //         $connector = new WindowsPrintConnector("smb://DESKTOP-6NFE3I3/POS58");
    //         $printer   = new Printer($connector);

    //         /* ===== Isi Struk ===== */
    //         $printer->setJustification(Printer::JUSTIFY_CENTER);
    //         $printer->text("Toko Anda\n");
    //         $printer->text("Jalan Raya No. 123\n");
    //         $printer->text("Telp: 0812-345-678\n");
    //         $printer->text("--------------------------------\n");

    //         $printer->setJustification(Printer::JUSTIFY_LEFT);
    //         $printer->text("ID Transaksi: " . $transaksi->id_transaksi . "\n");
    //         $printer->text("Tanggal: " . \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('d-m-Y H:i:s') . "\n");
    //         $printer->text("--------------------------------\n");

    //         foreach ($detailTransaksi as $item) {
    //             $item_line = sprintf("%s x %s Rp%s\n",
    //                 $item->jumlah,
    //                 $item->barang->nama_barang,
    //                 number_format($item->subtotal));
    //             $printer->text($item_line);
    //         }
    //         $printer->text("--------------------------------\n");

    //         $printer->setJustification(Printer::JUSTIFY_RIGHT);
    //         $printer->text("TOTAL: Rp " . number_format($transaksi->total_bayar) . "\n");
    //         $printer->text("BAYAR: Rp " . number_format($transaksi->jumlah_bayar) . "\n");
    //         $printer->text("KEMBALIAN: Rp " . number_format($transaksi->kembalian) . "\n");
    //         $printer->text("--------------------------------\n");

    //         $printer->setJustification(Printer::JUSTIFY_CENTER);
    //         $printer->text("Terima kasih sudah berbelanja!\n");
    //         $printer->cut();
    //         $printer->close();
    //         /* ===== Akhir Isi Struk ===== */

    //         // Setelah mencetak, alihkan pengguna kembali ke halaman kasir
    //         return redirect()->route('kasir.index')->with('success', 'Struk berhasil dicetak.');

    //     } catch (\Exception $e) {
    //         // Jika gagal, alihkan pengguna kembali dengan pesan error
    //         return redirect()->route('kasir.index')->with('error', 'Gagal mencetak struk: ' . $e->getMessage());
    //     }
    // }

    public function cetakStrukPdf($id_transaksi)
    {
        $transaksi = Transaksi::findOrFail($id_transaksi);
        $detailTransaksi = DetailTransaksi::where('id_transaksi', $id_transaksi)
            ->with('barang')
            ->get();

        $pdf = Pdf::loadView('kasir.struk', compact('transaksi', 'detailTransaksi'))
            ->setPaper([0, 0, 226.77, 600], 'portrait'); // 58mm thermal

        return $pdf->stream('struk-'.$id_transaksi.'.pdf');
    }
}