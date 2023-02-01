<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $table = 'barangs';
    protected $fillable = [
        'nama_barang',
        'harga',
        'keterangan',
        'stok',
        'gambar',
    ];

    public function pesanan_detail()
    {
        return $this->belongTo('App\PesananDetail', 'barang_id', 'id');
    }

    public function pesanan() {
        return $this->belongTo(Pesanan::class);
    }
}
