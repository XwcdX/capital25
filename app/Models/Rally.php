<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Rally extends Model
{
    use HasUuids;
    
    public function teams()
    {
        return $this->belongsToMany(Team::class, 'rally_histories')
                    ->withPivot('qr_expired_at', 'scanned_at', 'rank', 'point')
                    ->withTimestamps();
    }

    public function phases()
    {
        return $this->belongsToMany(Phase::class, 'rally_histories')
                    ->withPivot('qr_expired_at', 'scanned_at', 'rank', 'point')
                    ->withTimestamps();
    }
}
