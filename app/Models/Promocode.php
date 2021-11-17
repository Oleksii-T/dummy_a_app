<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Promocode extends Model
{
    use HasFactory;

    protected $fillable = [
        'stripe_coupon_id',
        'code',
        'type',
        'discount',
        'active_from',
        'active_to'
    ];

    protected $casts = [
        'active_from' => 'date',
        'active_to' => 'date'
    ];

    CONST TYPES = ['percent', 'amount'];

    public function getIsActiveAttribute()
    {
        $now = Carbon::now();
        return $now >= $this->active_from && $now <= $this->active_to;
    }

    public static function active()
    {
        $now = Carbon::now();
        return self::where('active_from', '<=', $now)->where('active_to', '>=', $now);
    }
}
