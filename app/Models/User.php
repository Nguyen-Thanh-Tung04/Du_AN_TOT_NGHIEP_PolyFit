<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     *
     */
    public $primarykey = 'id';
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'province_id',
        'district_id',
        'ward_id',
        'address',
        'birthday',
        'image',
        'description',
        'user_agent',
        'ip',
        'user_catalogue_id',
        'publish',
        'status',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id', 'code');
    }
    public function district()
    {
        return $this->belongsTo(District::class, 'district_id', 'code');
    }
    public function ward()
    {
        return $this->belongsTo(Ward::class, 'ward_id', 'code');
    }
    public function user_catalogues()
    {
        return $this->belongsTo(UserCatalogue::class, 'user_catalogue_id', 'id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id', 'id');
    }
    public function vouchers()
    {
        return $this->belongsToMany(Voucher::class, 'voucher_user')->withTimestamps();
    }
}
