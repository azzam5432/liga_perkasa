<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    // inisialisasi Tabel Produk
    protected $table = 'tb_peserta';
    
    // Inisialisasi Primary Key
    protected $primaryKey = 'id_peserta';

    // Inisialisasi data yang dapat di isi
    protected $fillable = ['nama_peserta', 'no_telp'];
}
