<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    use HasFactory;

    protected $fillable = [
        'stripe_id',
        'title',
        'is_active',
        'is_inclusive',
        'percentage'
    ];

    public static function active()
    {
        return self::where('is_active', true)->first()??null;
    }
}
