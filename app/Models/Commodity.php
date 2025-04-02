<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Commodity extends Model
{
    use HasUuids;
    protected $fillable = [
        'phase_id',
        'name',
        'image',
        'price',
        'return_rate'
    ];
    public function phase()
    {
        return $this->belongsTo(Phase::class, 'phase_id');
    }
    public function teams()
    {
        return $this->belongsToMany(Team::class, 'commodity_histories', 'commodity_id', 'team_id')
                    ->withPivot('phase_id', 'quantity', 'return_rate')
                    ->withTimestamps();
    }
}
