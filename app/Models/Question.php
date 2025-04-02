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

    public static function validationRules()
    {
        return [
            'question' => 'required|string|unique',
        ];
    }

    public static function validationMessages()
    {
        return [
            'question.required' => 'Question is required',
            'question.string' => 'Question must be a string',
            'name.unique' => 'Question has already been made',
        ];
    }
}
