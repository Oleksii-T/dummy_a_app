@extends('website.layouts.app')

@section('header')
    @include('website.layouts.inc.header')
@endsection

@section('content')
    <div class="wrapper_main pt-74">
        <main class="content">
            <section class="pricing first-section-padding">
                <div class="container pricing__contaner">
                    <div class="pricing__body">
                        <h2 class="section-title">Pricing</h2>
                        <p class="section-subtitle">Here are some screenshots of our product and features</p>
                        @if (session('error'))
                            <p class="section-subtitle custom-error">{{session('error')}}</p>
                        @endif
                        <div class="pricing-actions">
                            @foreach ($plansByIntervals as $interval => $plans)
                                <button type="button" class="pricing-actions__item {{$loop->first ? 'active' : ''}}" data-interval={{$interval}}>{{\App\Models\SubscriptionPlan::intervalReadable($interval)}}</button>
                            @endforeach
                        </div>
                        @foreach ($plansByIntervals as $interval => $plans)
                            <div class="custom-row pricing-plans {{$loop->first ? '' : 'd-none'}}" data-interval={{$interval}}>
                                @foreach ($plans as $plan)
                                    <div class="custom-col-3">
                                        <div class="pricing-item">
                                            <div class="pricing-item__head">
                                                <h3>{{$plan->title}}</h3>
                                                @if ($plan->popular)
                                                    <span class="pricing-item__stiker">Popular</span>
                                                @endif
                                            </div>
                                            <div class="pricing-item__price">
                                                {{$plan->price==0? 'Free' : $plan->price_readable}}
                                            </div>
                                            <div class="pricing-item__desc">
                                                {!!$plan->description!!}
                                            </div>
                                            <ul class="pricing-item__list">
                                                @foreach ($plan->features as $feature)
                                                    <li>
                                                        <img src="{{asset('assets/website/img/checkmark-circle-1.svg')}}" alt="">
                                                        {{$feature}}
                                                    </li>
                                                @endforeach
                                            </ul>
                                            <form action="{{route('website.subscription-plans.subscribe', $plan)}}" method="post">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-blue-transp">
                                                    @if ($plan->interval == 'endless')
                                                        Endless
                                                    @else
                                                        {{$plan->number_intervals . ' ' . $plan->interval . ($plan->price ? '' : ' Free Trial')}}
                                                    @endif
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        </main>
        @include('website.layouts.inc.footer')
    </div>
@endsection
