<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_token',
        'email_verified_at',
        'membership',
        'product_limit',
        'user_type',
        "profile"
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Mutator untuk membership
    public function setMembershipAttribute($value)
    {
        $this->attributes['membership'] = $value;
        $this->attributes['product_limit'] = $this->getProductLimit($value);
    }

    private function getProductLimit($membership)
    {
        switch ($membership) {
            case 'mall':
                return 10000;
            case 'agent':
                return 50;
            case 'store':
                return 25;
            case 'basic':
            default:
                return 5;
        }
    }

    public function Produks()
    {
        return $this->hasMany(Produk::class, 'user_id');
    }

    public function Unggulans()
    {
        return $this->hasMany(Unggulan::class, 'user_id');
    }

    public function DataUser()
    {
        return $this->hasOne(DataUser::class,  'user_id');
    }

    public function Baner()
    {
        return $this->belongsTo(Baner::class, 'user_id');
    }
}
