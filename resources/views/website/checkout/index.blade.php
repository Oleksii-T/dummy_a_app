@extends('website.layouts.app')

@section('header')
    @include('website.layouts.inc.header')
@endsection

@section('content')
    <div class="wrapper_main pt-74">
        <main class="content">
            <section class="chekout first-section-padding">
                <div class="container chekout__container">
                    <div class="chekout__body">
                        <h2 class="section-title">Order checkout</h2>
                        {{-- <p class="section-subtitle">We won’t charge you today. Your payment day will be on October 12, 2021</p> --}}
                        <form href="{{ route('api.stripe.store') }}" id="subscription-form" method="POST">
                            <div class="chekout__row">
                                <div class="chekout__col">
                                    <h3 class="chekout__title">Payment Method</h3>
                                    <div class="card">
                                        @csrf
                                        <div class="card__item">
                                            <div class="card__item-head">
                                                <label class="module__radio">
                                                    <input type="radio" value="crypto" name="payment_method">
                                                    <span class="check"></span>
                                                    <span class="text-module">Crypto</span>
                                                </label>
                                                <div class="card__item-img">
                                                    <img src="{{asset('assets/website/img/logos_bitcoin.jpg')}}" alt="">
                                                    <img src="{{asset('assets/website/img/logos_ethereum.svg')}}"
                                                         alt="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card__item">
                                            <div class="card__item-head">
                                                <label class="module__radio">
                                                    <input type="radio" value="paypal" name="payment_method">
                                                    <span class="check"></span>
                                                    <span class="text-module"><img
                                                                src="{{asset('assets/website/img/PayPal-1.svg')}}"
                                                                alt=""></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="card__item">
                                            <div class="card__item-head">
                                                <label class="module__radio">
                                                    <input type="radio" value="card" name="payment_method" {{$defaultPaymentMethod ? '' : 'checked'}}>
                                                    <span class="check"></span>
                                                    <span class="text-module">Credit or Debit Card</span>
                                                </label>
                                                <div class="card__item-img">
                                                    <img src="{{asset('assets/website/img/metods-1.png')}}" alt="">
                                                    <img src="{{asset('assets/website/img/metods-2.png')}}" alt="">
                                                    <img src="{{asset('assets/website/img/metods-3.png')}}" alt="">
                                                    <img src="{{asset('assets/website/img/metods-4.png')}}" alt="">
                                                </div>
                                            </div>
                                            <div class="card__item-bottom">
                                                <div class="input-group">
                                                    <div id="card-element"></div>
                                                    <div id="card-element-errors"></div>
                                                </div>
                                                <label class="module__check">
                                                    <input type="checkbox" name="save_method" checked>
                                                    <span class="check"></span>
                                                    <span class="text-module">Save payment method</span>
                                                </label>
                                            </div>
                                        </div>
                                        @if ($defaultPaymentMethod)
                                            <div class="card__item">
                                                <div class="card__item-head">
                                                    <label class="module__radio">
                                                        <input type="radio" value="default" name="payment_method" checked>
                                                        <span class="check"></span>
                                                        <span class="text-module checkout-my-def-method">
                                                            @if (cardImage($defaultPaymentMethod['card']['brand']))
                                                                <img src="{{cardImage($defaultPaymentMethod['card']['brand'])}}">  
                                                            @endif
                                                            •••• •••• •••• {{$defaultPaymentMethod['card']['last4']}}
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="chekout__col">
                                    <h3 class="chekout__title">Summary</h3>
                                    <div class="card">
                                        <div class="card__item">
                                            <div class="summary-row">
                                                <span>{{ $subscriptionPlan->title }} (Billed {{$subscriptionPlan->interval_readable}})</span>
                                                <div class="price">{{$subscriptionPlan->price_readable}}
                                                    <span>/ {{$subscriptionPlan->interval}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card__item">
                                            {{-- <div class="summary-row">
                                                <span>Referral bonuses</span>
                                                -$2.00
                                            </div> --}}
                                            @isset($summary['vat'])
                                                <div class="summary-row">
                                                    <span>VAT</span>
                                                    +{{$summary['vat']}} %
                                                </div>
                                            @endisset
                                            <div class="summary-row promocode-label d-none">
                                                <span>Promocode</span>
                                                <span class="promocode-discount" style="text-align: right"></span>
                                                <input type="text" name="promocode" class="d-none">
                                            </div>
                                        </div>
                                        <div class="card__item">
                                            <div class="summary-row-wrapper">
                                                <div class="summary-row">
                                                    <span>
                                                        Today you pay ({{$summary['currency']}})
                                                    </span>
                                                    <div class="price total-price">{{$summary['total']}}</div>
                                                </div>
                                            </div>
                                            <span class="price-next">After {{$subscriptionPlan->number_intervals . ' ' .  $subscriptionPlan->interval . ': ' . $summary['total']}}</span>
                                            <button class="btn btn-sm btn-blue">Checkout</button>
                                            <a href="#" data-plan="{{$subscriptionPlan->id}}" class="promo-code enter-promocode">Have a promo code?</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </main>
        @include('website.layouts.inc.footer')
    </div>
@endsection

@push('js')
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.11.2/jquery.mask.min.js" crossorigin="anonymous"
            referrerpolicy="no-referrer"></script>
    <script src="//js.stripe.com/v3/"></script>
    <script>
        var publishableKey = '{{ \App\Models\Setting::get('stripe_publishable_key') }}';
        var api_token = '{{ auth()->user()->api_token }}';
        var subscriptionPlanId = '{{ $subscriptionPlan->id }}';
        var paymentMethodId = {!! $defaultPaymentMethod ? '"' . $defaultPaymentMethod["id"] . '"' : 'false' !!};
    </script>
    <script src="{{ asset('assets/website/js/checkout.js') }}"></script>
@endpush