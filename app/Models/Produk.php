<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $guarded = ["id"];

    public function Status()
    {
        return $this->belongsTo(Status::class);
    }

    public function Kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function Unggulan()
    {
        return $this->hasMany(Unggulan::class);
    }

    public function Notifications()
    {
        return $this->hasMany(Notification::class, 'produk_id');
    }

    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function Image()
    {
        return $this->belongsTo(Image::class);
    }

    //cek apakah user pernah melakukan like
    public function like()
    {
        if (Auth::check()) {
            return $this->hasOne(Like::class)->where('likes.user_id', Auth::user()->id);
        }
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    // Menggunakan withCount untuk menghitung jumlah "like"
    public function totalLikes()
    {
        return $this->hasOne(Like::class)->count();
    }
}
