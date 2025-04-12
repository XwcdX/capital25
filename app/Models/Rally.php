<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Rally extends Model
{
    use HasUuids;
    
    protected $fillable = [
        'name',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function teams()
    {
        return $this->belongsToMany(Team::class, 'rally_histories')
                    ->withPivot('phase_id', 'qr_expired_at', 'scanned_at')
                    ->withTimestamps();
    }
}
