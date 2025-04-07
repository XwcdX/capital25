<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasUuids;
    
    protected $table = "transactions";
    protected $fillable = [
        'team_id',
        'transaction_type',
        'action',
        'amount',
        'commodity_id',
        'quantity',
        'meta',
        'description'
    ];
}
