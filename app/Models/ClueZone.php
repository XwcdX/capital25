<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class ClueZone extends Model
{
    use HasUuids;

    protected $fillable = [
        'team_id',
        'phase_id',
        'quantity',
        'price',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
    public function phase()
    {
        return $this->belongsTo(Phase::class);
    }
}
