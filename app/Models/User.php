<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'name',
        'gender',
        'phone_number',
        'position',
        'line_id',
        'consumption_type',
        'food_allergy',
        'drug_allergy',
        'medical_history',
        'student_card',
        'twibbon',
        'team_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $casts = [
        'gender' => 'integer',
        'consumption_type' => 'integer',
        'position' => 'integer',
    ];

    public function relations()
    {
        return ['team'];
    }

    public function team(){
        return $this->belongsTo(Team::class);
    }
}
