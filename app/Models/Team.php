<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasUuids;

    public function rallies()
    {
        return $this->belongsToMany(Rally::class, 'rally_histories')
            ->withPivot('qr_expired_at', 'scanned_at', 'rank', 'point')
            ->withTimestamps();
    }
}
