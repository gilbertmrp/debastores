<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;
    protected $table = 'pesanans';

    protected $fillable = [
        'gambars',
        'review',
    ];

    public function user()
    {
        return $this->belongTo('App\User', 'user_id', 'id');
    }

    public function users() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function pesanan_detail()
    {
        return $this->hasMany(PesananDetail::class,'pesanan_id', 'id');
    }

    public function barangs() {
        return $this->hasOne(Barang::class, 'id', 'barang_id');
    }
}
