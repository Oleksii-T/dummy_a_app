<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'stock_type_id',
        'open',
        'high',
        'low',
        'close',
        'adj_close',
        'volume',
        'date'
    ];

    protected $casts = [
        'date' => 'datetime'
    ];
}
