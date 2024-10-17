<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'quantity',
        'variant_id',
        'user_id'
    ];

    public function variant()
    {
        return $this->belongsTo(Variant::class, 'variant_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
