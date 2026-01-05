<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi';
    public $timestamps = false; // Menonaktifkan timestamp

    protected $fillable = [
        'id_transaksi',
        'id_pelanggan',
        'tanggal_transaksi',
        'total_bayar',
        'jumlah_bayar',
        'total_keuntungan',
        'kembalian',
    ];

    // Relasi
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_transaksi', 'id_transaksi');
    }
}
