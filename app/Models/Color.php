<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    protected $table = 'colors';

    public function variants() {
        return $this->hasMany(Variant::class, 'color_id', 'id');
    }
}
