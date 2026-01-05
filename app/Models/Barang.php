<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barang';
    protected $primaryKey = 'id_barang';
    public $incrementing = false; // Baris ini penting!
    protected $keyType = 'string'; // Tambahkan ini jika ID berupa string (barcode)
    public $timestamps = false;

    protected $fillable = [
        'id_barang', // Tambahkan juga id_barang ke $fillable
        'nama_barang',
        'id_kategori',
        'id_suplier',
        'stok',
        'harga_beli',
        'harga'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori','id_kategori'); // 'id_kategori' adalah foreign key di tabel 'barang'
    }

    public function suplier()
    {
        return $this->belongsTo(Suplier::class, 'id_suplier','id_suplier'); // 'id_suplier' adalah foreign key di tabel 'barang'
    }

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_barang', 'id_barang');
    }
}



