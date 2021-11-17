<?php

use App\Http\Controllers\Website\BlogController;
use App\Http\Controllers\Website\FAQController;
use App\Http\Controllers\Website\SocialiteAuthController;
use App\Http\Controllers\Website\PageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Website\ProfileController;
use App\Http\Controllers\Website\SubscriptionPlanController;
use App\Http\Controllers\Website\CheckoutController;
use App\Http\Controllers\Website\PaypalController;
use App\Models\Page;

Route::name('website.')->group(function () {
    // Socialite
    Route::get('/provider/{provider}', [SocialiteAuthController::class, 'redirectToProvider'])->name('social.login');
    Route::get('/provider/{provider}/callback', [SocialiteAuthController::class, 'handleProviderCallback']);
    
    // Feedbacks
    Route::resource('contact-us', \App\Http\Controllers\Website\FeedbackController::class)->only(['index', 'store']);

    // Paypal approve
    Route::get('paypal/approve/{subscriptionPlan}', [PaypalController::class, 'approve'])->name('paypal.approve');
    
    // Checkout
    Route::get('checkout/{plan}/promocode/{promocode}', [CheckoutController::class, 'promocode']);
    Route::get('checkout/{subscriptionPlan}', [CheckoutController::class, 'index'])
        ->middleware('auth')->name('checkout.index');
    
    // Subscription plans
    Route::get('/pricing', [SubscriptionPlanController::class, 'index'])->name('subscription-plans.index');
    Route::post('/subscripe/{subscriptionPlan}', [SubscriptionPlanController::class, 'subscribe'])->name('subscription-plans.subscribe');

    Route::post('/blogs/share/email', [BlogController::class, 'shareEmail']);
    Route::resource('blogs', BlogController::class)->only(['index', 'show']);

    Route::resource('faq', FAQController::class)->only(['index']);

    Route::middleware('auth:web')->group(function () {
        // PROFILE
        Route::put('/account/payment-method/{method}/default', [ProfileController::class, 'setDefaultPaymentMethod']); //ajax
        Route::delete('/account/payment-method/{method}/destroy', [ProfileController::class, 'destroyPaymentMethod']); //ajax
        Route::get('/account', [ProfileController::class, 'index'])->name('profile');
        Route::put('/account/update', [ProfileController::class, 'update'])->name('profile.update');
    });

    Route::get('/', function () {
        $page = Page::get('');
        return view('website.index', compact('page'));
    })->name('index');

    Route::get('/login', function () {
        $page = Page::get('login');
        return view('website.auth.login', compact('page'));
    })->name('login');

    Route::get('/sign-up', function () {
        $page = Page::get('sign-up');
        return view('website.auth.sign-up', compact('page'));
    })->name('sign-up');

    Route::get('/terms', function () {
        $page = Page::get('terms');
        return view('website.terms', compact('page'));
    })->name('terms');

    Route::get('/privacy', function () {
        $page = Page::get('privacy');
        return view('website.privacy', compact('page'));
    })->name('privacy');

    Route::get('/how-it-works', function () {
        $page = Page::get('how-it-works');
        return view('website.how-it-works', compact('page'));
    })->name('how-it-works');

    Route::get('/about', function () {
        $page = Page::get('about');
        return view('website.about', compact('page'));
    })->name('about');

    Route::get('/refunds', function () {
        $page = Page::get('refunds');
        return view('website.refunds', compact('page'));
    })->name('refunds');

    Route::get('/features', function () {
        $page = Page::get('features');
        return view('website.features', compact('page'));
    })->name('features');
});

Route::name('admin.')->prefix('admin')->group(function () {

    Route::get('/login', function () {
        return view('admin.auth.login');
    })->name('login');

    Route::get('/forgot-password', function () {
        return view('admin.auth.forgot-password');
    })->name('forgot-password');

    Route::middleware('auth.admin')->group(function () {
        // DASHBOARD
        Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('index');

        // PAGES
        Route::resource('pages', \App\Http\Controllers\Admin\PageController::class)->except(['show']);

        // FAQS
        Route::resource('faqs', \App\Http\Controllers\Admin\FAQController::class)->except(['show']);
        
        // STOCKS
        Route::post('/stocks/types', [\App\Http\Controllers\Admin\StockController::class, 'storeType'])->name('stocks.types.store');
        Route::resource('stocks', \App\Http\Controllers\Admin\StockController::class)->only(['index']);
        
        // BLOGS
        Route::resource('blogs', \App\Http\Controllers\Admin\BlogController::class);
        
        // BLOGS CATEGORIES
        Route::resource('blog-categories', \App\Http\Controllers\Admin\BlogCategoryController::class)->except(['show']);
        
        // USERS
        Route::get('/users/data-table', [\App\Http\Controllers\Admin\UserController::class, 'dataTable']);
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class)->except(['show']);
        
        // PROMOCODES
        Route::resource('promocodes', \App\Http\Controllers\Admin\PromocodeController::class)->except(['show']);
        
        // TAXES
        Route::resource('taxes', \App\Http\Controllers\Admin\TaxController::class)->except(['show']);
        
        // FEEDBACKS
        Route::post('feedbacks/{feedback}/read', [\App\Http\Controllers\Admin\FeedbackController::class, 'read'])->name('feedbacks.read'); //ajax
        Route::resource('feedbacks', \App\Http\Controllers\Admin\FeedbackController::class)->only(['index', 'show', 'destroy']);
        
        // SETTINGS
        Route::name('settings.')->prefix('settings')->group(function (){
            Route::get('site', [SettingController::class, 'site'])->name('site');
            Route::put('site', [SettingController::class, 'siteUpdate'])->name('site.update');
            Route::get('payment', [SettingController::class, 'payment'])->name('payment');
            Route::put('payment', [SettingController::class, 'paymentUpdate'])->name('payment.update');
        });

        // Subscription plans
        Route::resource('subscription-plans',
            \App\Http\Controllers\Admin\SubscriptionPlanController::class)->except(['show']);
        
        // Subscriptions
        Route::resource('subscriptions', \App\Http\Controllers\Admin\SubscriptionController::class)->only(['index', 'show', 'destroy']);

        // ORDERS
        Route::resource('orders', \App\Http\Controllers\Admin\OrderController::class)->except(['show']);
    });
});

Route::get('{url}', [PageController::class, 'index']);
