<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Commodity extends Model
{
    use HasUuids;

    public function teams()
    {
        return $this->belongsToMany(Team::class, 'team_commodities')
            ->withPivot('quantity')
            ->withTimestamps();
    }
}
