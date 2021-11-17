<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Setting;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        config(['services.twitter.client_id' => Setting::get('twitter_app_id')]);
        config(['services.twitter.client_secret' => Setting::get('twitter_app_secret')]);
        config(['services.google.client_id' => Setting::get('google_app_id')]);
        config(['services.google.client_secret' => Setting::get('google_app_secret')]);
        config(['services.facebook.client_id' => Setting::get('facebook_app_id')]);
        config(['services.facebook.client_secret' => Setting::get('facebook_app_secret')]);

        \View::composer('*', function($view) {
            if (auth()->check()) {
                $view->with('currentUser', auth()->user());
            }
        });
    }
}
