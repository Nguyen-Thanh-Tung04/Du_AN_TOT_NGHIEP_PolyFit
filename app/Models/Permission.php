<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'canonical',
    ];

    protected $table = 'permissions';

    public function usercatalogues() {
        return $this->belongsToMany(UserCatalogue::class, 'user_catalogue_permission', 'permission_id', 'user_catalogue_id');
    }
}
