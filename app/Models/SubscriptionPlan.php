<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class SubscriptionPlan extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'title',
        'description',
        'price',
        'interval',
        'number_intervals',
        'free_plan',
        'popular',
        'features',
        'stripe_id',
        'paypal_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'features' => 'array',
    ];

    /**
     * Subscription plan intervals
     */
    const INTERVALS = [
        'day',
        'week',
        'month',
        'year',
        'endless'
    ];

    /**
     * Stripe subscription plan intervals
     */
    const STRIPE_INTERVALS = [
        'day',
        'week',
        'month',
        'year',
    ];

    /**
     * Paypal subscription plan intervals
     */
    const PAYPAL_INTERVALS = [
        'day',
        'week',
        'month',
        'year'
    ];

    /**
     * @return bool
     */
    public function checkStripeInterval()
    {
        return in_array($this->interval, self::STRIPE_INTERVALS);
    }

    /**
     * @return bool
     */
    public function checkPaypalInterval()
    {
        return in_array($this->interval, self::PAYPAL_INTERVALS);
    }

    /**
     * @return array
     */
    public static function features()
    {
        $featuresArrays = self::pluck('features');
        $result = [];
        foreach ($featuresArrays as $features) {
            if (!$features) {
                continue;
            }
            $result = array_merge($result, array_diff($features, $result));
        }
        
        return $result;
    }

    public function getPriceReadableAttribute()
    {
        return Setting::get('currency_sign') . number_format($this->price, 2, '.');
    }

    public function getVatPriceAttribute()
    {
        if ($vat = Tax::active()?->percentage) {
            $vatPrice = $this->price * ($vat/100);
            return $this->price + $vatPrice;
        }
        return $this->price;
    }

    public function getVatPriceReadableAttribute()
    {
        if ($vat = Tax::active()?->percentage) {
            $vatPrice = $this->price * ($vat/100);
            return Setting::get('currency_sign') . number_format($this->price + $vatPrice, 2, '.');
        }
        return $this->price_readable;
    }

    public function getIntervalReadableAttribute()
    {
        return self::intervalReadable($this->interval);
    }

    public static function intervalReadable($interval)
    {
        switch ($interval) {
            case 'day':
                return 'Daily';
            case 'week':
                return 'Weakly';
            case 'month':
                return 'Monthly';
            case 'year':
                return 'Yearly';
            case 'endless':
                return 'Endless';
            default:
                return 'UNDEF';
        }
    }

    public function calculateExpiry($from=null)
    {
        if (!$from) {
            $from = Carbon::now();
        }
        switch ($this->interval) {
            case 'day':
                return $from->addDays($this->number_intervals);
            case 'week':
                return $from->addWeeks($this->number_intervals);
            case 'month':
                return $from->addMonths($this->number_intervals);
            case 'year':
                return $from->addYears($this->number_intervals);
            case 'Endless':
                return null;
            default:
                return $from;
        }
    }
}
