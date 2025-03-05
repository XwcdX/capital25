<?php

namespace App\Models;

use App\Models\ModelUtils;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Division extends Model
{
    use HasFactory;
    use HasUuids, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug'
    ]; 

    /**
     * Rules that applied in this model
     *
     * @var array
     */
    public static function validationRules()
    {
        return [
            'name' => 'required|string|max:50',
            'slug' => 'string|max:50'
        ];
    }

    /**
     * Messages that applied in this model
     *
     * @var array
     */
    public static function validationMessages()
    {
        return [
            'name.required' => 'Name is required',
            'name.string' => 'Name must be a string',
            'name.max' => 'Name must not exceed 50 characters',
            'slug.string' => 'Slug must be a string',
            'slug.max' => 'Slug must not exceed 50 characters'
        ];
    }

    /**
    * Relations associated with this model
    *
    * @var array
    */
    public function relations()
    {
        return ['admins'];
    }

    /**
    * Space for calling the relations
    *
    *
    */
    public function admins()
    {
        return $this->hasMany(Admin::class);
    }
}
