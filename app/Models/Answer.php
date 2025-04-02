<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasUuids;

    protected $fillable = [
        'question_id', 
        'answer_text', 
        'is_correct'
    ];

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class, 'team_answer')
            ->withPivot('team_id')
            ->withTimestamps();
    }
}
