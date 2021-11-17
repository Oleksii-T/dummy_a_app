<?php

namespace App\Services;

use App\Models\Promocode;
use App\Models\Setting;
use App\Models\SubscriptionPlan;
use App\Models\Tax;
use Illuminate\Support\Facades\Cache;

class PaypalService
{
    /**
     * PayPal url
     */
    CONST URL = 'https://api-m.sandbox.paypal.com/v1/';

    /**
     * PayPal token
     * @var string
     */
    private $token;

    /**
     * Currency
     * @var string
     */
    private $currency;

    /**
     * PayPal product id
     * @var string
     */
    private $productId;

    /**
     * PaypalService constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $clientId = Setting::get('paypal_client_id');
        $secret = Setting::get('paypal_client_secret');
        if (!$clientId || !$secret) {
            throw new \Exception('You need to configure the paypal');
        }

        $this->token = $this->getAccessToken($clientId, $secret);
        $this->currency = Setting::get('currency');

        if (!$this->productId = Setting::get('paypal_product_id')) {
            $this->productId = $this->createProduct()['id'];
            Setting::set('paypal_product_id', $this->productId);
        }
    }

    /**
     * @return mixed
     */
    private function createProduct()
    {
        $ch = $this->curl_init("catalogs/products");
        $data = [
            "name" => env('APP_NAME'),
            "type" => "SERVICE",
            "category" => "SOFTWARE",
            "home_url" => 'https://sim.webstaginghub.com'//route('website.index')
        ];
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        return $this->curl_exec($ch);
    }

    /**
     * @param $clientId
     * @param $secret
     * @return mixed
     */
    private function getAccessToken($clientId, $secret)
    {
        if ($token = Cache::get('paypal_access_token')) {
            return $token;
        }

        $ch = curl_init();
        $headers = [
            'Accept: application/json',
            'Accept-Language: en_US',
            'Content-Type: application/x-www-form-urlencoded'
        ];

        curl_setopt($ch, CURLOPT_URL, 'https://api-m.sandbox.paypal.com/v1/oauth2/token');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
        curl_setopt($ch, CURLOPT_USERPWD, "$clientId:$secret");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = $this->curl_exec($ch);
        Cache::put('paypal_access_token', $result['access_token'], $result['expires_in'] - 10);

        return $result['access_token'];
    }

    /**
     * @param float $amount
     * @param $interval
     * @param int $interval_count
     * @param $name
     * @param $description
     * @return mixed
     */
    public function createPlan(float $amount, $interval, $interval_count = 1, $name, $description)
    {
        $ch = $this->curl_init("billing/plans");
        $data = [
            "product_id" => $this->productId,
            "name" => $name,
            "description" => $description,
            "billing_cycles" => [
                [
                    "frequency" => [
                        "interval_unit" => $interval,
                        "interval_count" => $interval_count
                    ],
                    "tenure_type" => "REGULAR",
                    "sequence" => 1,
                    "total_cycles" => 0,
                    "pricing_scheme" => [
                        "fixed_price" => [
                            "value" => $amount,
                            "currency_code" => $this->currency
                        ]
                    ]
                ]
            ],
            "payment_preferences" => [
                "auto_bill_outstanding" => true,
                "payment_failure_threshold" => 1
            ]
        ];
        $tax = Tax::active();
        $data += [
            "taxes" => [
                "percentage" => $tax && !$tax->is_inclusive ? $tax->percentage : 0,
                "inclusive" => false
            ]
        ];

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        return $this->curl_exec($ch);
    }

    public function updatePlan($ids, $data)
    {
        $ids = is_array($ids) ? $ids : [$ids];
        foreach ($data as $field => $value) {
            $fields[] = [
                'op' => 'replace',
                'path' => $field,
                'value' => $value
            ];
        }
        foreach ($ids as $id) {
            $ch = $this->curl_init("billing/plans/$id"); 
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
            $res = $this->curl_exec($ch);
        }
        return true;
    }

    /**
     * @param SubscriptionPlan $subscriptionPlan
     * @param Promocode|null $promocode
     * @return mixed
     */
    public function createSubscription(SubscriptionPlan $subscriptionPlan, Promocode $promocode = null)
    {
        $ch = $this->curl_init("billing/subscriptions");
        $data = [
            "plan_id" => $subscriptionPlan->paypal_id,
            "application_context" => [
                "brand_name" => env('APP_NAME'),
                "return_url" => route('website.paypal.approve', $subscriptionPlan->id),
                "cancel_url" => route('website.checkout.index', $subscriptionPlan->id)
                // "return_url" => "https://sim.webstaginghub.com/paypal/approve/$subscriptionPlan->id",
                // "cancel_url" => "https://sim.webstaginghub.com/checkout/$subscriptionPlan->id"
            ]
        ];
        if ($promocode) {
            if ($promocode->type == 'percent') {
                $discount = $subscriptionPlan->price * ($promocode->discount / 100);
            } else {
                $discount = $promocode->discount;
            }
            $data += [
                'plan' => [
                    'billing_cycles' => [
                        [
                            "sequence" => 1,
                            "total_cycles" => 1,
                            "pricing_scheme" => [
                                "fixed_price" => [
                                    "value" => $subscriptionPlan->price - $discount,
                                    "currency_code" => $this->currency
                                ]
                            ]
                        ],
                        // [
                        //     "sequence" => 2,
                        //     "total_cycles" => 0,
                        //     "pricing_scheme" => [
                        //         "fixed_price" => [
                        //             "value" => $subscriptionPlan->price,
                        //             "currency_code" => $this->currency
                        //         ]
                        //     ]
                        // ]
                    ]
                ]
            ];
        }

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        return $this->curl_exec($ch);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getSubscription($id)
    {
        $ch = $this->curl_init("billing/subscriptions/$id");
        return $this->curl_exec($ch);
    }

    /**
     * @return mixed
     */
    public function getPlans()
    {
        $ch = $this->curl_init('billing/plans');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        return $this->curl_exec($ch);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getPlan($id)
    {
        $ch = $this->curl_init("billing/plans/$id");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        return $this->curl_exec($ch);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deletePlan($id)
    {
        $ch = $this->curl_init("billing/plans/$id/deactivate");
        curl_setopt($ch, CURLOPT_POST, 1);
        return $this->curl_exec($ch);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function cancelSubscription($id)
    {
        $ch = $this->curl_init("billing/subscriptions/$id/cancel");
        curl_setopt($ch, CURLOPT_POST, 1);
        return $this->curl_exec($ch);
    }

    /**
     * @param $ch
     * @return mixed
     */
    private function curl_exec($ch)
    {
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            abort(500, curl_error($ch));
        }
        curl_close($ch);
        return json_decode($result, true);
    }

    /**
     * @param $url
     * @return resource
     */
    private function curl_init($url)
    {
        $ch = curl_init();
        $headers = [
            "Content-Type: application/json",
            "Authorization: Bearer $this->token"
        ];
        curl_setopt($ch, CURLOPT_URL, self::URL . $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        return $ch;
    }
}