<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessagesPublicModel extends Model
{
    use HasFactory;
    protected $table = 'message_public';
}
