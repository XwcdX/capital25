<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Phase extends Model
{
    protected $fillable = [
        'phase',
        'status',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
