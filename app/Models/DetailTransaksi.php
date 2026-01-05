<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    protected $table = 'detail_transaksi';
    protected $primaryKey = 'id_detail';
    public $timestamps = false; // Menonaktifkan timestamp
    public $incrementing = true;

    protected $fillable = [
        'id_transaksi',
        'id_barang',
        'jumlah',
        'subtotal',
        'jumlah_beli',
        'harga_saat_beli',
        'keuntungan_item'
    ];

    // Relasi
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi', 'id_transaksi');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
    }
}
