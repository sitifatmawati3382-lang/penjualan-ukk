<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Menetapkan nama tabel yang benar
    protected $table = 'users';

    // Menetapkan primary key yang benar
    protected $primaryKey = 'id_user';

    // Menetapkan kolom yang dapat diisi secara massal
    protected $fillable = [
        'username',
        'password',
        'nama_lengkap',
        'level_user',
    ];

    // Menyembunyikan atribut yang sensitif saat diubah menjadi array
    protected $hidden = [
        'password',
    ];

    // Menghapus penggunaan 'remember_token'
    public function getRememberTokenName()
    {
        return null; // Laravel tidak akan mencari kolom ini
    }
}