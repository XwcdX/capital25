<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Phase extends Model
{
    use HasUuids;

    protected $fillable = [
        'phase',
        'status',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function teams()
    {
        return $this->belongsToMany(Team::class, 'rally_histories')
                    ->withPivot('qr_expired_at', 'scanned_at')
                    ->withTimestamps();
    }

    public function rallies()
    {
        return $this->belongsToMany(Rally::class, 'rally_histories')
            ->withPivot('qr_expired_at', 'scanned_at')
            ->withTimestamps();
    }
}
