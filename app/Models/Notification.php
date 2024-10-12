<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    //Untuk Memberikan Semua Akses Kecuali ID
    protected $guarded = ["id"];


    //Satu Notification Hanya Boleh Ke Satu User
    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function Produk()
    {
        return $this->belongsTo(Produk::class);
    }

    public function getTanggalNotifAttribute()
    {
        return $this->created_at->format('F j, Y');
    }

    public function getTigaHurufAttribute()
    {
        $kata = explode(' ', $this->message);
        $tigaKata = array_slice($kata, 0, 3);
        return implode(' ', $tigaKata);
    }
}
