<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasUuids;
    //
    protected $fillable = [
      'question',
      'points'  
    ];

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
