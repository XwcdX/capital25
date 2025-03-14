<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameSetting extends Model
{
    use HasFactory;

    protected $table = 'game_settings'; // Nama tabel di database
    protected $fillable = ['round', 'countdown'];
}

